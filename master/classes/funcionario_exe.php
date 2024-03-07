<?php
ob_start();
session_start();

if ((!isset($_SESSION['cod_id']) == true)) {
	unset($_SESSION['cod_id']);

	header('location: ../');
}

$cod_id = $_SESSION['cod_id'];

require "../../db/Conexao.php";

// CADASTRAR FUNCIONARIO
if (isset($_POST["cad_cli"])) {
	$login_snh = sha1($_POST["senha"]);

	$bytes = random_bytes(16);
	$token = bin2hex($bytes);

	$cadcat = $connect->prepare("INSERT INTO carteira (tokenapi, idm, nome, celular, login, senha, tipo) VALUES (:token, :cod_id, :nome, :celular, :login, :senha, :tipo)");
	
	$cadcat->execute([
		':token' => $token,
		':cod_id' => $cod_id,
		':nome' => $_POST["nome"],
		':celular' => $_POST["celular"],
		':login' => $_POST["cpf"],
		':senha' => $login_snh,
		':tipo' => $_POST["tipo"]
	]);

	$idfun = $connect->query("SELECT id FROM carteira WHERE login = '" . $_POST["cpf"] . "'");
	$dadosf = $idfun->fetch(PDO::FETCH_OBJ);

	$cad7 = $connect->query("INSERT INTO conexoes(id_usuario, tokenid) VALUES ('" . $dadosf->id . "','" . $token . "')");
	$cad1 = $connect->query("INSERT INTO mensagens(idu, tipo, msg) VALUES ('" . $dadosf->id . "','1','*#NOME#* mensagem de com 5 dias antes do vencimento')");
	$cad2 = $connect->query("INSERT INTO mensagens(idu, tipo, msg) VALUES ('" . $dadosf->id . "','2','*#NOME#* mensagem de com 3 dias antes do vencimento')");
	$cad3 = $connect->query("INSERT INTO mensagens(idu, tipo, msg) VALUES ('" . $dadosf->id . "','3','*#NOME#* mensagem no dia do vencimento')");
	$cad4 = $connect->query("INSERT INTO mensagens(idu, tipo, msg) VALUES ('" . $dadosf->id . "','4','*#NOME#* mensagem de mensalidade vencida')");
	$cad5 = $connect->query("INSERT INTO mensagens(idu, tipo, msg) VALUES ('" . $dadosf->id . "','5','*#NOME#* mensagem de agradecimento')");
	$cad6 = $connect->query("INSERT INTO mensagens(idu, tipo, msg) VALUES ('" . $dadosf->id . "','6','*#NOME#* mensagem de cobranca manual')");


	if ($cadcat) {
		header("location: ../usuarios&sucesso=");
		
		exit;
	}
}

// EDITAR FUNCIONARIO
if (isset($_POST["edit_cli"])) {
	$senha = $_POST['senha'];

	if ($senha) {
		$senha = sha1($_POST['senha']);

		$editarcad = $connect->prepare("UPDATE carteira SET nome=:nome, celular=:celular, login=:login, senha=:senha, tipo=:tipo, assinatura=:assinatura WHERE Id=:edit_cli");
    
    $editarcad->execute([
      ':nome' => $_POST["nome"],
      ':celular' => $_POST["celular"],
      ':login' => $_POST["cpf"],
      ':senha' => $senha,
      ':tipo' => $_POST["tipo"],
      ':assinatura' => $_POST["assinatura"],
      ':edit_cli' => $_POST["edit_cli"]
    ]);
	} else {
		$editarcad = $connect->prepare("UPDATE carteira SET nome=:nome, celular=:celular, login=:login, tipo=:tipo, assinatura=:assinatura WHERE Id=:edit_cli");
    
    $editarcad->execute([
      ':nome' => $_POST["nome"],
      ':celular' => $_POST["celular"],
      ':login' => $_POST["cpf"],
      ':tipo' => $_POST["tipo"],
      ':assinatura' => $_POST["assinatura"],
      ':edit_cli' => $_POST["edit_cli"]
    ]);
	}

	if ($editarcad) {
		header("location: ../usuarios&sucesso=");
		exit;
	}
}

// DEL CLIENTE
if (isset($_POST["delcob"])) {

	$delb = $connect->query("DELETE FROM carteira WHERE Id='" . $_POST['delcob'] . "' AND idm ='" . $cod_id . "'");
	$delb = $connect->query("DELETE FROM clientes WHERE idm='" . $_POST['delcob'] . "' AND idm ='" . $cod_id . "'");
	$delb = $connect->query("DELETE FROM financeiro1 WHERE idm='" . $_POST['delcob'] . "' AND idm ='" . $cod_id . "'");
	$delb = $connect->query("DELETE FROM financeiro2 WHERE idm='" . $_POST['delcob'] . "' AND idm ='" . $cod_id . "'");
	$delb = $connect->query("DELETE FROM mensagens WHERE idu='" . $_POST['delcob'] . "' AND idu ='" . $cod_id . "'");

	if ($delb) {
		header("location: ../usuarios&sucesso=ok");
    
		exit;
	}
}