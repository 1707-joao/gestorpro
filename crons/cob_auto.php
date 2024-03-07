<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo');

require_once __DIR__ . '/../db/Conexao.php';
require_once __DIR__ . '/../master/classes/functions.php';

function sendCurlRequest($url, $token, $data) {
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . $token,
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);

  return $response;
}

function sendTextMessageWhats($urlapi, $tokenapi, $phone, $textomsg, $apikey) {
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $urlapi . "/message/sendText/AbC123" . $tokenapi,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '{
      "number": "55' . $phone . '",
      "options": {
        "delay": 1200,
        "presence": "composing",
        "linkPreview": false
      },
      "textMessage": {
        "text": "' . $textomsg . '"
      }
    }',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
      'apikey: ' . $apikey . ''
    )
  ));

  curl_exec($curl);

  curl_close($curl);
}

function sendMediaMessageWhats($urlapi, $tokenapi, $phone, $caption, $base64, $apikey) {
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $urlapi . "/message/sendMedia/AbC123" . $tokenapi,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '{
      "number": "55' . $phone . '",
      "options": {
        "delay": 1200,
        "presence": "composing"
      },
      "mediaMessage": {
        "mediatype": "image",
        "caption": "' . $caption . '",
        "media": "' . $base64 . '"
      }
    }',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
      'apikey: ' . $apikey . ''
    )
  ));

  curl_exec($curl);

  curl_close($curl);
}

$currentDate = date("Ymd");
$dueDate = date("Ymd", strtotime("+5 days", strtotime($currentDate)));
$beforeDate = date("Ymd", strtotime("-3 days", strtotime($currentDate)));

$actualHour = date('H:i');

$query = "SELECT * FROM financeiro2 WHERE pagoem = 'n'";
$payments = $connect->query($query);

while ($paymentsRow = $payments->fetch(PDO::FETCH_OBJ)) {
  $dateFormated = DateTime::createFromFormat('d/m/Y', $paymentsRow->datapagamento)->format('Ymd');

  if ($dateFormated >= $beforeDate && $dateFormated <= $dueDate) {
    $wallet = $connect->query("SELECT * FROM carteira WHERE Id = '" . $paymentsRow->idm . "'");
    $walletRow = $wallet->fetch(PDO::FETCH_OBJ);

    $tokenapi = $walletRow->tokenapi;
    $token = $walletRow->vjurus;
    $tokenmp = $walletRow->tokenmp;
    $company = $walletRow->nomecom;
    $cnpj = $walletRow->cnpj;
    $address = $walletRow->enderecom;
    $phone = $walletRow->contato;
    $msg = $walletRow->msg;
    $msgqr = $walletRow->msgqr;
    $msgpix = $walletRow->msgpix;

    $paymentType = $walletRow->pagamentos;

    $clients = $connect->query("SELECT Id, nome, celular FROM clientes WHERE id='" . $paymentsRow->idc . "'");
    $clientsRow = $clients->fetch(PDO::FETCH_OBJ);

    $name = explode(" ", $clientsRow->nome);
    $firstName = $name[0];
    $lastName = end($name);
    $phone = $clientsRow->celular;
    $idcli = $clientsRow->Id;

    $installment = $paymentsRow->parcela;
    $idcob = $paymentsRow->Id;
    $paymentDate = $paymentsRow->datapagamento;

    $bytes = random_bytes(16);
    $idempotency = bin2hex($bytes);

    $linkcob = "/pagamento/?cob=" . $idcob;

    $messages = $connect->query("SELECT * FROM mensagens WHERE tipo = '4' AND idu = '" . $paymentsRow->idm . "'");
    $messagesRow = $messages->fetch(PDO::FETCH_OBJ);

    $search = array('#NOME#', '#VENCIMENTO#', '#VALOR#', '#LINK#', '#EMPRESA#', '#CNPJ#', '#ENDERECO#', '#CONTATO#');
    $replace = array($firstName . " " . $lastName, $paymentDate, $installment, $linkcob, $company, $cnpj, $address, $phone);
    $message = str_replace($search, $replace, $messagesRow->msg);

    $messageToSend = str_replace("\n", "\\n", $message);

    $qrcode_base64 = "";
    $emv = "";

    if ($messagesRow->hora == $actualHour) {
      if ($msg == "1") {
        sendTextMessageWhats($urlapi, $tokenapi, $phone, $messageToSend, $apikey);
      }

      if ($paymentType == "1") {
        $checkQuery = $connect->prepare("SELECT qrcode, linhad FROM mercadopago WHERE idc = :idcli AND status = 'pending' AND DATE(data) >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)");
        $checkQuery->execute(['idcli' => $idcli]);
        $existingRecord = $checkQuery->fetch(PDO::FETCH_ASSOC);

        if ($existingRecord) {
          $qrcode_base64 = $existingRecord['qrcode'];

          $emv = $existingRecord['linhad'];
        } else {
          $data = '{
            "transaction_amount": ' . $installment . ',
            "description": "PAGAMENTO DE MENSALIDADE ' . $firstName . '",
            "payment_method_id": "pix",
            "payer": {
              "email": "mxdinelly@gmail.com",
              "first_name": "' . $firstName . '",
              "last_name": "' . $lastName . '"
            }
          }';

          $response = sendCurlRequest('https://api.mercadopago.com/v1/payments', $tokenmp, $data);
          $response = json_decode($response, true);

          $result = $response["status"];
          $transaction_id = $response["id"];
          $created_date = date("Y-m-d H:i:s");
          $status = $response["status"];
          $value_cents = $response["transaction_details"]["total_paid_amount"];
          $emv = $response["point_of_interaction"]["transaction_data"]["qr_code"];
          $qrcode_base64 = $response["point_of_interaction"]["transaction_data"]["qr_code_base64"];

          if ($result == "pending") {
            $connect->query("INSERT INTO mercadopago (idc, status, instancia, data, valor, idp, qrcode, linhad) VALUES ('$idcli', '$status', '$idcob', '$created_date', '$value_cents', '$transaction_id', '$qrcode_base64', '$emv')");
          }
        }

        if ($msgpix == "1") {
          sendMediaMessageWhats($urlapi, $tokenapi, $phone, "Pague agora via pix. Leia o QRCode.", $qrcode_base64, $apikey);
        }

        if ($msgqr == "1") {
          sendTextMessageWhats($urlapi, $tokenapi, $phone, $emv, $apikey);
        }
      }

      $msfg = "*ATENÇÃO* Esta é uma mensagem automática e não precisa ser respondida.\\n*Caso já tenha efetuado o pagamento por favor desconsidere esta cobrança.*";

      sendTextMessageWhats($urlapi, $tokenapi, $phone, $msfg, $apikey);
    }
  }
}
