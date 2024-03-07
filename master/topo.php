<?php
ob_start();
session_start();

if((!isset ($_SESSION['cod_id']) == true)) { unset($_SESSION['cod_id']); header('location: ../'); }

$cod_id = $_SESSION['cod_id'];

$bytes = random_bytes(16);
$idempotency = bin2hex($bytes);

require_once __DIR__ . '/../db/Conexao.php';

//CELULAR ADMINISTRADOR
$celphoneAdm = $connect->query("SELECT contato FROM carteira WHERE tipo = 1");
$celphoneAdmRow = $celphoneAdm->fetch(PDO::FETCH_OBJ);

// DADOS GERAIS
$pegadadosgerais = $connect->query("SELECT * FROM carteira WHERE Id = '$cod_id'");
$dadosgerais = $pegadadosgerais->fetch(PDO::FETCH_OBJ);

$actualDate = strtotime(date("Y-m-d"));

$date = $dadosgerais->assinatura;
$dateParts = explode("/", $date);
$convertedDate = $dateParts[2] . "-" . $dateParts[1] . "-" . $dateParts[0];

$subscriptionDate = strtotime(date("Y-m-d", strtotime($convertedDate)));

if ($actualDate > $subscriptionDate && $dadosgerais->tipo > 1) {
  if(isset($_COOKIE['pdvx'])) {
    unset($_COOKIE['pdvx']);

    setcookie('pdvx', null, -1, '/');
  }

  session_destroy();

  session_write_close();

  header('location: ../index.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="description" content="Painel Administrativo.">

  <meta name="author" content="DELIVERY APP">

  <title>:: PAINEL ADMINISTRATIVO ::</title>

  <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">

  <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">

  <link href="../lib/datatables/css/jquery.dataTables.css" rel="stylesheet">

  <link href="../lib/select2/css/select2.min.css" rel="stylesheet">

  <link href="../styles/planos.css" rel="stylesheet">

  <link href="../styles/msg-assinatura.css" rel="stylesheet">

  <link rel="stylesheet" href="../css/slim.css">
</head>

<body>
  <div class="slim-header with-sidebar" style="background-image: linear-gradient(to right, #00EE00 0%, #008B00 100%);">
    <div class="container-fluid">
      <div class="slim-header-left">
        <a class="slim-logo" href="/.">
          <img src="img/logo.png" alt="Logo Financeiro">
        </a>

        <a href="javascript: void(0);" id="slimSidebarMenu" class="slim-sidebar-menu"><span></span></a>
      </div>

      <?php if ($dadosgerais->tipo > 1) { ?>
        <div id="msg-assinatura" class="slim-header-center">
          <div class="time">Seu plano expira em: <?php echo $date; ?></div>

          <a href="planos" target="_parent" class="button">Renovar assinatura</a>
        </div>
      <?php } ?>

      <div class="slim-header-right">
        <div class="dropdown dropdown-c">
          <a href="./" class="logged-user" data-toggle="dropdown" style="color:#FFFFFF">
            <span><?php print $dadosgerais->nome;?></span>

            <i class="fa fa-angle-down"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
