<?php
ob_start();
session_start();
if((!isset ($_SESSION['cod_id']) == true)) { unset($_SESSION['cod_id']); header('location: ../'); }

$cod_id = $_SESSION['cod_id'];

require "../../db/Conexao.php";

$idcliente 			= $_POST['idcliente'];
$formapagamento 	= $_POST['formapagamento'];
$parcelas 			= $_POST['parcelas'];
$dataparcela 		= $_POST['dataparcela'];
$dataparcelax 		= $_POST['dataparcelax'];
$idpedido 			= $_POST['idpedido'];
$vparcela			= $_POST['vparcela'];

// FINANCEIRO UM
$financeiro1 = $connect->query("INSERT INTO financeiro1 (idc, idm, valorfinal, formapagamento, parcelas, primeiraparcela, chave, vparcela, entrada) VALUES ('$idcliente','$cod_id','$vparcela','$formapagamento','$parcelas','$dataparcelax','$idpedido','$vparcela','".date("d/m/Y")."')");

// MONTA O LOOP DA FORMA DE PAGAMENTO X PASCELAS 
$vencimento_primeira_parcela = explode('/',$dataparcela);

$dia = $vencimento_primeira_parcela[0];
$mes = $vencimento_primeira_parcela[1];
$ano = $vencimento_primeira_parcela[2];

// LOOP GRAVA OS DADOS NO DB
for($parcela = 0; $parcela < $parcelas; $parcela++)
{

$qwerr =  date('d/m/Y', strtotime('+'.($parcela * $formapagamento). " day", mktime(0, 0, 0, $mes, $dia, $ano)));
$financeiro1 = $connect->query("INSERT INTO financeiro2 (idc, chave, idm, parcela, datapagamento) VALUES ('$idcliente','$idpedido','$cod_id','$vparcela','$qwerr')");

}

header("location: ../contas_receber&sucesso=ok"); exit;


?>
