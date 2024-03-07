<?php
ob_start();
session_start();
if((!isset ($_SESSION['cod_id']) == true)) { unset($_SESSION['cod_id']); header('location: ../'); }

$cod_id = $_SESSION['cod_id'];

require "../../db/Conexao.php";

// PAGAMENTO EM DIAS

if(isset($_POST["emdias"]))  {

$mmm = $_POST["mes"];
$aaa = date("Y");
$datam = $mmm."/".$aaa;

$cadcat = $connect->query("INSERT INTO pagamentofun(idc, idm, data, valor) VALUES ('".$_POST["idc"]."','".$_POST["idm"]."','".$datam."','".$_POST["valor"]."')");

if($cadcat) {
	header("location: ../painel_usuario&mes=".$mmm."&idcli=".$_POST["idc"]."&idmas=".$_POST["idm"].""); exit;
}

}
?>