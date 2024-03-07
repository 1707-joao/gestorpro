<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo');

require_once __DIR__ . '/../db/Conexao.php';
require_once __DIR__ . '/../master/classes/functions.php';

$currentDate = new DateTime();

$tokenQuery = "SELECT tokenapi FROM carteira WHERE Id = 1";

$tokenResult = $connect->query($tokenQuery);

$tokenRow = $tokenResult->fetch(PDO::FETCH_OBJ);

$tokenapi = $tokenRow->tokenapi;

$selectQuery = "SELECT Id, assinatura, celular FROM carteira";

$walletResults = $connect->query($selectQuery);

while ($walletRow = $walletResults->fetch(PDO::FETCH_OBJ)) {
  $dueDate = DateTime::createFromFormat('d/m/Y', $walletRow->assinatura);

  $interval = $currentDate->diff($dueDate);

  if ($interval->days <= 3 && $interval->invert == 0) {
    $daysRemaining = $interval->days;

    $messageToSend = "Sua assinatura vence em " . ($daysRemaining == 0 ? "hoje" : $daysRemaining . " dia(s)") . ", entre no sistema e adicione uma assinatura.";

    $curl = curl_init();

    $phone = $walletRow->celular;

    curl_setopt_array($curl, array(
      CURLOPT_URL => $urlapi . "/message/sendText/AbC123" . $tokenapi,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode([
        "number" => "55" . $phone,
        "options" => [
          "delay" => 1200,
          "presence" => "composing",
          "linkPreview" => false
        ],
        "textMessage" => [
          "text" => $messageToSend
        ]
      ]),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'apikey: ' . $apikey
      )
    ));

    $response = curl_exec($curl);

    curl_close($curl);
  }
}
