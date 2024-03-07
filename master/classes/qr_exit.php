<?php
ob_start();
session_start();
if((!isset ($_SESSION['cod_id']) == true)) { unset($_SESSION['cod_id']); header('location: ../'); }

$cod_id = $_SESSION['cod_id'];

require_once "../../db/Conexao.php";
require_once "functions.php";


if (isset($_POST["token_api"])) {
  
	$tokenid = $_POST["token_api"];
	
	$curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $urlapi . '/instance/logout/AbC123'. $tokenid,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'DELETE',
      CURLOPT_HTTPHEADER => array(
		'apikey: '.$apikey.''
	  ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
	
	
	// delete
	
	$curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $urlapi . '/instance/delete/AbC123'. $tokenid,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'DELETE',
      CURLOPT_HTTPHEADER => array(
		'apikey: '.$apikey.''
	  ),
    ));

    echo $response = curl_exec($curl);
	curl_close($curl);
	
	$editarcad = $connect->query("UPDATE conexoes SET qrcode='', conn = '0', apikey = '0' WHERE id_usuario = '".$cod_id."'");
	
	header("location: ../whatsapp"); 
		
}

?>