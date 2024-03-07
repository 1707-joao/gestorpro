<?php
ob_start();
session_start();
if((!isset ($_SESSION['cod_id']) == true)) { unset($_SESSION['cod_id']); header('location: ../'); }

$cod_id = $_SESSION['cod_id'];

require "../../db/Conexao.php";

if(isset($_POST["cadpagar"]))  {
    
$descricao 			= $_POST['descricao'];
$formapagamento 	= $_POST['formapagamento'];
$parcelas 			= $_POST['parcelas'];
$dataparcela 		= $_POST['dataparcela'];
$dataparcelax 		= $_POST['dataparcelax'];
$idpedido 			= $_POST['idpedido'];
$vparcela			= $_POST['vparcela'];


// MONTA O LOOP DA FORMA DE PAGAMENTO X PASCELAS 
$vencimento_primeira_parcela = explode('/',$dataparcela);

$dia = $vencimento_primeira_parcela[0];
$mes = $vencimento_primeira_parcela[1];
$ano = $vencimento_primeira_parcela[2];

// LOOP GRAVA OS DADOS NO DB
for($parcela = 0; $parcela < $parcelas; $parcela++)
{

$qwerr =  date('d/m/Y', strtotime('+'.($parcela * $formapagamento). " day", mktime(0, 0, 0, $mes, $dia, $ano)));
$financeiro1 = $connect->query("INSERT INTO financeiro3 (idm, valor, datavencimento, descricao, status) VALUES ('$cod_id', '$vparcela', '$qwerr', '$descricao', '1')");

}

header("location: ../contas_pagar&sucesso=ok"); exit;

}

// DEL FINAN

if(isset($_POST["delfin"]))  {

$delb = $connect->query("DELETE FROM financeiro3 WHERE id='".$_POST['delfin']."'");

if($delb) {
	header("location: ../contas_pagar&sucesso=ok"); exit;
}

}
?>