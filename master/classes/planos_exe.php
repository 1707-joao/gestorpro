<?php
ob_start();
session_start();

if((!isset ($_SESSION['cod_id']) == true)) { unset($_SESSION['cod_id']); header('location: ../'); }

$bytes = random_bytes(16);
$idempotency = bin2hex($bytes);

require_once __DIR__ . '/../../db/Conexao.php';

$wallet = $connect->query("SELECT * FROM carteira WHERE Id = 1");
$walletRow = $wallet->fetch(PDO::FETCH_OBJ);

// CADASTRAR PLANOS
if(isset($_POST["cad_planos"]))  {
  $name = base64_decode($_POST['type']);

  switch ($name) {
    case 'Mensal':
      $frequency = 1;
    break;

    case 'Trimestral':
      $frequency = 3;
    break;

    case 'Semestral':
      $frequency = 6;
    break;

    case 'Anual':
      $frequency = 12;
    break;
  }

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.mercadopago.com/preapproval_plan',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '{
      "auto_recurring": {
        "frequency": ' . $frequency . ',
        "frequency_type": "months",
        "repetitions": 1,
        "transaction_amount": ' . str_replace(",", ".", $_POST['value']) . ',
        "currency_id": "BRL"
      },
      "payment_methods_allowed": {
        "payment_types": [
          {
            "id": "credit_card"
          }
        ]
      },
      "back_url": "' . $_POST['base_url'] . '/master/update_planos&token=' . $_POST['type'] . '",
      "reason": "' . $name . '"
    }',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . $walletRow->tokenmp . '',
      'X-Idempotency-Key: ' . $idempotency . ''
    ))
  );

  $response = curl_exec($curl);

  $response = json_decode($response, true);

  curl_close($curl);

  if($response) {
    header("location: /master/planos&cad=ok");

    exit;
  }
}

// EDITAR PLANOS
if(isset($_POST["edit_planos"]))  {
  $name = base64_decode($_POST['type']);

  switch ($name) {
    case 'Mensal':
      $frequency = 1;
    break;

    case 'Trimestral':
      $frequency = 3;
    break;

    case 'Semestral':
      $frequency = 6;
    break;

    case 'Anual':
      $frequency = 12;
    break;
  }

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.mercadopago.com/preapproval_plan/' . $_POST['id'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'PUT',
    CURLOPT_POSTFIELDS => '{
      "auto_recurring": {
        "frequency": ' . $frequency . ',
        "frequency_type": "months",
        "repetitions": 1,
        "transaction_amount": ' . str_replace(",", ".", $_POST['value']) . ',
        "currency_id": "BRL"
      },
      "payment_methods_allowed": {
        "payment_types": [
          {
            "id": "credit_card"
          }
        ]
      },
      "back_url": "' . $_POST['base_url'] . '/master/update_planos&token=' . $_POST['type'] . '",
      "reason": "' . $name . '"
    }',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . $walletRow->tokenmp . '',
      'X-Idempotency-Key: ' . $idempotency . ''
    ))
  );

  /* Pagamentos por cartão e pix
    "payment_types": [
      {
        "id": "account_money"
      },
    ],
    "payment_methods": [
      {
        "id": "pix"
      }
    ]
  */

  $response = curl_exec($curl);

  $response = json_decode($response, true);

  print_r($response);

  curl_close($curl);

  if($response) {
    header("location: /master/planos&edit=ok");

    exit;
  }
}
