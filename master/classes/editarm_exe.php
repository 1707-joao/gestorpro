<?php
ob_start();
session_start();
if((!isset ($_SESSION['cod_id']) == true)) { unset($_SESSION['cod_id']); header('location: ../'); }

$cod_id = $_SESSION['cod_id'];

require "../../db/Conexao.php";

// EDITAR PARCELA

if(isset($_POST["emdias"]))  {
    
$valor 		= $_POST['valor'];
$valor		= str_replace(".", "", $valor);
$valor		= str_replace(",", ".", $valor);

$editarcad = $connect->query("UPDATE financeiro2 SET datapagamento='".$_POST["datap"]."', parcela='".$valor."', obsv='".$_POST["obsv"]."' WHERE Id='".$_POST["idfin2"]."' AND idm ='".$cod_id."'");

$chave 		= $_POST['chave'];

// SOMA VALORES A RECEBER
$valoresareceber 	= $connect->query("SELECT SUM(parcela) AS totalparcela FROM financeiro2 WHERE chave = '".$_POST["chave"]."' AND idm ='".$cod_id."'");
$valoresareceberx 	= $valoresareceber->fetch(PDO::FETCH_OBJ);

$novot = $valoresareceberx->totalparcela;

$editarcads = $connect->query("UPDATE financeiro1 SET valorfinal='".$novot ."' WHERE chave = '".$_POST["chave"]."' AND idm ='".$cod_id."'");

if($editarcads) {
	header("location: ../ver_financeiro&vercli=".$_POST["codcli"].""); exit;
}

}


if(isset($_POST["pagas"]))  {
    
$valor 		= $_POST['valor'];
$valor		= str_replace(".", "", $valor);
$valor		= str_replace(",", ".", $valor);

$editarcad = $connect->query("UPDATE financeiro3 SET datavencimento='".$_POST["datap"]."', valor='".$valor."', descricao='".$_POST["descricao"]."', observacao='".$_POST["obsv"]."' WHERE id='".$_POST["idfin2"]."' AND idm ='".$cod_id."'");

if($editarcad) {
	header("location: ../contas_pagar&sucesso=ok"); exit;
}

}





?>
