<?php
ob_start();
session_start();
if((!isset ($_SESSION['cod_id']) == true)) { unset($_SESSION['cod_id']); header('location: ../'); }

$cod_id = $_SESSION['cod_id'];

require "../../db/Conexao.php";

// PAGAMENTO EM DIAS

if(isset($_GET["emdias"]))  {

$baixasimples = $connect->query("UPDATE financeiro2 SET status='2', pagoem='".date("d/m/Y")."' WHERE Id='".$_GET["idfin2"]."' AND idm ='".$cod_id."'");

if($baixasimples) {
	header("location: ../ver_financeiro&vercli=".$_GET["codcli"].""); exit;
}

}

// BAIXAR EMPRESTIMO

if(isset($_GET["idbaixa"]))  {

$baixasimples = $connect->query("UPDATE financeiro1 SET status='2', pagoem='".date("Y-m-d H:i:s")."' WHERE Id='".$_GET["idbaixa"]."' AND idm ='".$cod_id."'");

if($baixasimples) {
	header("location: ../finalizados"); exit;
}

}

// BAIXAR EMPRESTIMO

if(isset($_GET["baixapagar"]))  {

$baixasimples = $connect->query("UPDATE financeiro3 SET status='2', datapagamento='".date("Y-m-d H:i:s")."' WHERE id='".$_GET["idfin2"]."' AND idm ='".$cod_id."'");

if($baixasimples) {
	header("location: ../contas_pagar&sucesso=ok"); exit;
}

}
?>