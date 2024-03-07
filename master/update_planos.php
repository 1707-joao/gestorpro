<?php
ob_start();
session_start();

if (!isset($_SESSION['cod_id'])) {
  unset($_SESSION['cod_id']);

  header('location: ../');

  exit;
}

$cod_id = $_SESSION['cod_id'];

require_once __DIR__ . '/../db/Conexao.php';

$type = base64_decode($_GET['token']);

switch ($type) {
  case 'Mensal':
    $period = 1;
  break;

  case 'Trimestral':
    $period = 3;
  break;

  case 'Semestral':
    $period = 6;
  break;

  case 'Anual':
    $period = 12;
  break;
}

$query = $connect->prepare("SELECT assinatura FROM carteira WHERE Id = :cod_id");

$query->bindParam(':cod_id', $cod_id, PDO::PARAM_INT);

$query->execute();

if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
  $currentAssinatura = DateTime::createFromFormat('d/m/Y', $row['assinatura']);

  if ($currentAssinatura) {
    $currentAssinatura->modify("+$period months");

    $newAssinatura = $currentAssinatura->format('d/m/Y');

    $updateQuery = "UPDATE carteira SET assinatura = :newAssinatura WHERE Id = :cod_id";

    $update = $connect->prepare($updateQuery);

    $update->bindParam(':newAssinatura', $newAssinatura);

    $update->bindParam(':cod_id', $cod_id, PDO::PARAM_INT);

    $updateResult = $update->execute();

    if ($updateResult) {
      header("location: /master");

      exit;
    }
  }
}
