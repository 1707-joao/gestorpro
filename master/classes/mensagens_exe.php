<?php
ob_start();

session_start();

if((!isset ($_SESSION['cod_id']) == true)) { unset($_SESSION['cod_id']); header('location: ../'); }

$cod_id = $_SESSION['cod_id'];

require_once __DIR__ . '/../../db/Conexao.php';

if(isset($_POST["edit_cli"]))  {
  $msg = $_POST['msg'];
  $msgProccessed = str_replace("\r\n", "\\n", $msg);
  $msgProccessed = str_replace("\n", "\\n", $msgProccessed);
  $msgProccessed = str_replace("\r", "\\n", $msgProccessed);

	$editarcad = $connect->query("UPDATE mensagens SET msg = '" . $msgProccessed . "', hora = '" . $_POST["hora"] . "' WHERE id = '" . $_POST["edit_cli"] . "' AND idu = '" . $cod_id . "'");

	if($editarcad) {
		header("location: ../mensagens&sucesso="); exit;
	}
}
