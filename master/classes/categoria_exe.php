<?php
ob_start();
session_start();
if((!isset ($_SESSION['cod_id']) == true)) { unset($_SESSION['cod_id']); header('location: ../'); }

$cod_id = $_SESSION['cod_id'];

require "../../db/Conexao.php";

// CADASTRAR CLIENTES

if(isset($_POST["cad_cat"]))  {


$cadcat = $connect->query("INSERT INTO categoria(nome, idu) VALUES ('".$_POST["nome"]."','".$cod_id."')");

if ($cadcat) {
        echo "Registro inserido com sucesso!";
    } else {
        echo "Erro ao inserir o registro no banco de dados.";
    }

}

// EDITAR CLIENTES

if(isset($_POST["edit_cat"]))  {

$editarcad = $connect->query("UPDATE categoria SET nome='".$_POST["nome"]."' WHERE id = '".$_POST["edit_cat"]."' AND idu ='".$cod_id."'");

if($editarcad) {
	header("location: ../categorias&sucesso=ok"); exit;
}

}

// DEL CLIENTE

if(isset($_POST["delcli"]))  {

$delb = $connect->query("DELETE FROM categoria WHERE id='".$_POST['delcli']."' AND idu ='".$cod_id."'");

if($delb) {
	header("location: ../categorias&sucesso=ok"); exit;
}

}
?>