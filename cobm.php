<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo');

require_once __DIR__ . '/db/Conexao.php';
require_once __DIR__ . '/master/classes/functions.php';

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

if (isset($_POST["cob"], $_POST["codclix"], $_POST["tipom"], $_POST["dcob"])) {
  $idfinan2 = $_POST["cob"];
  $idcliente = $_POST["codclix"];
  $tipocob = $_POST["tipom"];
  $dcob = $_POST["dcob"];

  $dataAtual = date("d/m/Y");

  $stmt = $connect->prepare("SELECT * FROM financeiro2 WHERE Id = :idfinan2 AND idc = :idcliente");
  $stmt->execute(array(':idfinan2' => $idfinan2, ':idcliente' => $idcliente));
  $row = $stmt->fetch(PDO::FETCH_OBJ);

  $getMaster = $connect->query("SELECT * FROM carteira WHERE Id = '" . $row->idm . "'");
  $masterInfo = $getMaster->fetch(PDO::FETCH_OBJ);

  $tokenapi = $masterInfo->tokenapi;
  $tokenmp = $masterInfo->tokenmp;
  $company = $masterInfo->nomecom;
  $cnpj = $masterInfo->cnpj;
  $address = $masterInfo->enderecom;

  $getClient = $connect->query("SELECT Id, nome, celular FROM clientes WHERE id = '" . $row->idc . "'");
  $clientInfo = $getClient->fetch(PDO::FETCH_OBJ);

  $nameParts = explode(" ", $clientInfo->nome);
  $firstName = $nameParts[0];
  $lastName = end($nameParts);
  $phone = $clientInfo->celular;
  $clientId = $clientInfo->Id;

  $amount = $row->parcela;
  $cobId = $row->Id;
  $paymentDate = $row->datapagamento;

  $linkcob = "/pagamento/?cob=" . $dcob . "";

  $messages = $connect->query("SELECT msg FROM mensagens WHERE tipo = '" . $tipocob . "' AND idu = '" . $row->idm . "'");
  $messagesRow = $messages->fetch(PDO::FETCH_OBJ);

  $search = array('#NOME#', '#VENCIMENTO#', '#VALOR#', '#LINK#', '#EMPRESA#', '#CNPJ#', '#ENDERECO#', '#CONTATO#');
  $replace = array($firstName . " " . $lastName, $paymentDate, $amount, $linkcob, $company, $cnpj, $address, $phone);
  $message = str_replace($search, $replace, $messagesRow->msg);

  $messageToSend = str_replace("\n", "\\n", $message);

  $data = '{
    "transaction_amount": ' . $amount . ',
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

  $transactionId = $response["id"];
  $createdDate = date("Y-m-d H:i:s");
  $status = $response["status"];
  $totalPaid = $response["transaction_details"]["total_paid_amount"];
  $codePix = $response["point_of_interaction"]["transaction_data"]["qr_code"];
  $qrcodeBase64 = $response["point_of_interaction"]["transaction_data"]["qr_code_base64"];

  if ($status == "pending") {
    $add = $connect->query("INSERT INTO mercadopago (idc, status, instancia, data, valor, idp, qrcode, linhad) VALUES ('$clientId', '$status', '$cobId', '$createdDate', '$totalPaid', '$transactionId', '$qrcodeBase64', '$codePix')");
  }

  sendTextMessageWhats($urlapi, $tokenapi, $phone, $messageToSend, $apikey);

  sendTextMessageWhats($urlapi, $tokenapi, $phone, $codePix, $apikey);

  sendMediaMessageWhats($urlapi, $tokenapi, $phone, "Pague agora via pix. Leia o QRCode.", $qrcodeBase64, $apikey);

  $messageText = "*ATENÇÃO* Esta é uma mensagem automática e não precisa ser respondida.\\n*Caso já tenha efetuado o pagamento por favor desconsidere esta cobrança.*";

  sendTextMessageWhats($urlapi, $tokenapi, $phone, $messageText, $apikey);

  header("location: ./master/ver_financeiro&vercli=" . $dcob);
}
