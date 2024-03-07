<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../db/Conexao.php';
require_once __DIR__ . '/../master/classes/functions.php';

$query = $connect->query("SELECT mp.idp, mp.instancia, f2.idm, f2.idc FROM mercadopago mp INNER JOIN financeiro2 f2 ON mp.instancia = f2.Id WHERE mp.status = 'pending'");

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
  $transactionId = $row['idp'];
  $instancia = $row['instancia'];
  $idm = $row['idm'];
  $idc = $row['idc'];

  $walletQuery = $connect->prepare("SELECT tokenmp FROM carteira WHERE Id = :idm");
  $walletQuery->execute(['idm' => $idm]);
  $walletRow = $walletQuery->fetch(PDO::FETCH_ASSOC);

  if (!$walletRow) {
    echo "Erro: carteira não encontrada para o idm: $idm\n";
    continue;
  }

  $accessToken = $walletRow['tokenmp'];

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.mercadopago.com/v1/payments/" . $transactionId,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array("Authorization: Bearer " . $accessToken),
  )
  );

  $response = curl_exec($curl);
  $error = curl_error($curl);
  curl_close($curl);

  if ($error) {
    echo "Erro ao consultar a API do Mercado Pago: " . $error . "\n";
    continue;
  }

  $paymentData = json_decode($response, true);

  if (!isset($paymentData['status'])) {
    echo "Erro: status do pagamento não encontrado.\n";
    continue;
  }

  $newStatus = $paymentData['status'];

  $updateQuery = $connect->prepare("UPDATE mercadopago SET status = :status WHERE idp = :idp");
  $updateQuery->execute(['status' => $newStatus, 'idp' => $transactionId]);

  if ($newStatus == 'approved') {
    $currentDate = date('d/m/Y');

    $updateFinanceiro1 = $connect->prepare("UPDATE financeiro1 SET pagoem = :pagoem, status = '2' WHERE idc = :idc AND idm = :idm");
    $updateFinanceiro1->execute(['pagoem' => $currentDate, 'idc' => $idc, 'idm' => $idm]);

    $updateFinanceiro2 = $connect->prepare("UPDATE financeiro2 SET pagoem = :pagoem, status = '2' WHERE Id = :instancia");
    $updateFinanceiro2->execute(['pagoem' => $currentDate, 'instancia' => $instancia]);

    $paymentsQuery = "SELECT * FROM financeiro2 WHERE idc = '$idc' AND Id = '$instancia'";
    $paymentsResult = $connect->query($paymentsQuery);
    if (!$paymentsResult || !($paymentsRow = $paymentsResult->fetch(PDO::FETCH_OBJ))) {
      echo "Erro: pagamento não encontrado.\n";
      continue;
    }

    $paymentDateDue = $paymentsRow->datapagamento;
    $idm = $paymentsRow->idm;

    $walletQuery = $connect->query("SELECT * FROM carteira WHERE Id='" . $idm . "'");
    if (!$walletQuery || !($walletRow = $walletQuery->fetch(PDO::FETCH_OBJ))) {
      echo "Erro: carteira não encontrada.\n";
      continue;
    }

    $tokenapi = $walletRow->tokenapi;
    $company = $walletRow->nomecom;
    $cnpj = $walletRow->cnpj;
    $address = $walletRow->enderecom;

    $clientsQuery = $connect->query("SELECT Id, nome, celular FROM clientes WHERE Id='" . $idc . "'");
    if (!$clientsQuery || !($clientsRow = $clientsQuery->fetch(PDO::FETCH_OBJ))) {
      echo "Erro: cliente não encontrado.\n";
      continue;
    }

    $name = explode(" ", $clientsRow->nome);
    $firstName = $name[0];
    $lastName = end($name);
    $phone = $clientsRow->celular;

    $installment = $paymentData['transaction_amount'];
    $paymentDate = date('d/m/Y', strtotime($paymentData['date_approved']));

    $messagesQuery = $connect->query("SELECT msg FROM mensagens WHERE tipo='5' AND idu = '" . $idm . "'");
    if (!$messagesQuery || !($messagesRow = $messagesQuery->fetch(PDO::FETCH_OBJ))) {
      echo "Erro: mensagem não encontrada.\n";
      continue;
    }

    $search = array('#NOME#', '#VENCIMENTO#', '#VALOR#', '#EMPRESA#', '#CNPJ#', '#ENDERECO#', '#CONTATO#', '#DATAPAGAMENTO#');
    $replace = array($firstName . " " . $lastName, $paymentDateDue, $installment, $company, $cnpj, $address, $phone, $paymentDate);
    $message = str_replace($search, $replace, $messagesRow->msg);

    $messageToSend = str_replace("\r\n", "\\n", $message);

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $urlapi . "/message/sendText/AbC123" . $tokenapi,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode(
        array(
          "number" => "55" . $phone,
          "textMessage" => array("text" => $messageToSend)
        )
      ),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'apikey: ' . $apikey
      ),
    )
    );
    $response = curl_exec($curl);
    curl_close($curl);
  }
}