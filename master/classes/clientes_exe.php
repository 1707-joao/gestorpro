<?php
ob_start();
session_start();
if((!isset ($_SESSION['cod_id']) == true)) { unset($_SESSION['cod_id']); header('location: ../'); }

$cod_id = $_SESSION['cod_id'];

require "../../db/Conexao.php";

// CADASTRAR CLIENTES

if(isset($_POST["cad_cli"]))  {

$datac = date('d-m-Y', strtotime($_POST["nascimento"]));

$cadcat = $connect->query("INSERT INTO clientes(nome, idm, idc, cpf, uf, nascimento, email, celular, cep, endereco, numero, bairro, complemento, cidade) VALUES ('".$_POST["nome"]."','".$cod_id."','".$_POST["cliente"]."','".$_POST["cpfnj"]."','".$_POST["uf"]."','".$_POST["nascimento"]."','".$_POST["email"]."','".$_POST["celular"]."','".$_POST["cep"]."','".$_POST["rua"]."','".$_POST["numero"]."','".$_POST["bairro"]."','".$_POST["complemento"]."','".$_POST["cidade"]."')");

if($cadcat) {
	header("location: ../clientes&sucesso="); exit;
}

}

// EDITAR CLIENTES

if(isset($_POST["edit_cli"]))  {

$editarcad = $connect->query("UPDATE clientes SET idc='".$_POST["cliente"]."', nome='".$_POST["nome"]."', cpf='".$_POST["cpf"]."', uf='".$_POST["uf"]."', nascimento='".$_POST["nascimento"]."', email='".$_POST["email"]."', celular='".$_POST["celular"]."', cep='".$_POST["cep"]."', endereco='".$_POST["rua"]."', numero='".$_POST["numero"]."', bairro='".$_POST["bairro"]."', complemento='".$_POST["complemento"]."', cidade='".$_POST["cidade"]."', uf='".$_POST["uf"]."' WHERE Id='".$_POST["edit_cli"]."' AND idm ='".$cod_id."'");

if($editarcad) {
	header("location: ../clientes&sucesso=ok"); exit;
}

}

// DEL CLIENTE

if(isset($_POST["delcli"]))  {

$delb = $connect->query("DELETE FROM clientes WHERE Id='".$_POST['delcli']."' AND idm ='".$cod_id."'");
$delb = $connect->query("DELETE FROM financeiro1 WHERE Id='".$_POST['delcli']."' AND idm ='".$cod_id."'");
$delb = $connect->query("DELETE FROM financeiro2 WHERE Id='".$_POST['delcli']."' AND idm ='".$cod_id."'");

if($delb) {
	header("location: ../clientes&sucesso=ok"); exit;
}

}

if(isset($_POST["delfin"]))  {

$delb = $connect->query("DELETE FROM financeiro1 WHERE chave='".$_POST['delfin']."' AND idm ='".$cod_id."'");
$delb = $connect->query("DELETE FROM financeiro2 WHERE chave='".$_POST['delfin']."' AND idm ='".$cod_id."'");

if($delb) {
	header("location: ../contas_receber&sucesso=ok"); exit;
}

}
?>