<?php
//ob_start();

require_once "db/Conexao.php";
require_once "master/classes/functions.php";

$idfinan2 = $_POST["cob"];
$idcliente = $_POST["codclix"];
$tipocob = $_POST["tipom"];
$dcob = $_POST["dcob"];

$dataAtual = date("d/m/Y");

// Consulta SQL para buscar registros
$sql = "SELECT * FROM financeiro2 WHERE Id = '".$idfinan2."' AND idc = '".$idcliente."'";
$buscafin2  = $connect->query($sql);
$empativosx = $buscafin2->rowCount();

while ($val = $buscafin2->fetch(PDO::FETCH_OBJ)) {
  
        
        // PEGA DADOS DO MASTER
        $pegamaster  = $connect->query("SELECT * FROM carteira WHERE Id='".$val->idm."'");
        $pegamastern = $pegamaster->fetch(PDO::FETCH_OBJ);
        					
        //$urlapi = $pegamastern->valor;
		$tokenapi = $pegamastern->tokenapi;
        $token = $pegamastern->vjurus;
        $tokenmp = $pegamastern->tokenmp;
        $empnome = $pegamastern->nomecom;
        $empcnpj = $pegamastern->cnpj;
        $empende = $pegamastern->enderecom;
        $empcomt = $pegamastern->contato;
        $msg1 = $pegamastern->msg;
        $msg2 = $pegamastern->msgqr;
        $msg3 = $pegamastern->msgpix;
		
		$monta = $urlapi."/message/sendText/text?key=".$token;
        $monta2 = $urlapi."/message/sendText/pix?key=".$token;
    
    // FIM PEGA DADOS DO MASTER
    
    // FIM PEGA DADOS DO CLIENTE
    
        $buscacli  = $connect->query("SELECT Id, nome, celular FROM clientes WHERE id='".$val->idc."'");
        $buscacli = $buscacli->fetch(PDO::FETCH_OBJ);
        
        $partesNome = explode(" ", $buscacli->nome);
        $primeiroNome = $partesNome[0];
        $ultimoNome = end($partesNome);
        $celular = $buscacli->celular;
        $idcli = $buscacli->Id;
    
    // FIM PEGA DADOS DO CLIENTE
    
    // DADOS DA COBRANCA
    
        $parcela = $val->parcela;
        $idcob 	 = $val->Id;
        $data2x	 = $val->datapagamento;
    
    // FIM DADOS DA COBRANCA
    
    
	$bytes = random_bytes(16);
    $idempotency = bin2hex($bytes);
	
	
    // GERA COBRANCA NO MP
    
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.mercadopago.com/v1/payments',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
              "transaction_amount": '.$parcela.',
              "description": "PAGAMENTO MENSALIDADE '.$primeiroNome.'",
              "payment_method_id": "pix",
              "payer": {
                "email": "mxdinelly@gmail.com",
                "first_name": "'.$primeiroNome.'",
                "last_name": "'.$ultimoNome.'",
                "identification": {
                    "type": "CPF",
                    "number": ""
                },
              }
            }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$tokenmp.'',
			'X-Idempotency-Key: '.$idempotency.'',
          ),
        ));
        
        $response = curl_exec($curl);
          
        $response = json_decode($response, true);
    
        curl_close($curl);
          
        $result         = $response["status"];
        $transaction_id = $response["id"];
        $created_date   = date("Y-m-d H:i:s");
        $status         = $response["status"];
        $value_cents    = $response["transaction_details"]["total_paid_amount"];
        $emv            = $response["point_of_interaction"]["transaction_data"]["qr_code"];
        
        $qrcode_base64  = $response["point_of_interaction"]["transaction_data"]["qr_code_base64"];
        
        if($result == "pending") {
        
        $add = $connect->query("INSERT INTO mercadopago (idc, status, instancia, data, valor, idp, qrcode, linhad) VALUES ('$idcli', '$status', '$idcob', '$created_date', '$value_cents', '$transaction_id', '$qrcode_base64', '$emv')");
        
        } 
		
		 // MENSAGEM DE COBRANCA
    
        $linkcob = $_urlmaster."/pagamento/?cob=".$idcob."";							
    
        $buscamsg  = $connect->query("SELECT msg FROM mensagens WHERE tipo='".$tipocob."' AND idu = '".$val->idm."'");
        
        $buscamsg = $buscamsg->fetch(PDO::FETCH_OBJ);
        														
        $search  = array('#NOME#', '#VENCIMENTO#', '#VALOR#', '#LINK#', '#EMPRESA#', '#CNPJ#', '#ENDERECO#', '#CONTATO#');
        $replace = array($primeiroNome." ".$ultimoNome, $data2x, $parcela, $linkcob, $empnome, $empcnpj, $empende, $empcomt);
        $textomsg = str_replace($search, $replace, $buscamsg->msg);
        									
        $textomsg = str_replace("\r\n","\\n",$textomsg);
    
    // FIM MENSAGEM DE COBRANCA
    
    // MSG1
    
        if($msg1 == "1") {
        
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
            CURLOPT_URL => $urlapi."/message/sendText/AbC123".$tokenapi,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
				"number": "55'.$celular.'",
				"options": {
					"delay": 1200,
					"presence": "composing",
					"linkPreview": false
				},
				"textMessage": {
					"text": "'.$textomsg.'"
				}
			}',
			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'apikey: '.$apikey .''
			  ),
            ));
            								
            $response = curl_exec($curl);
            curl_close($curl);
        
        }
    
    // FIM MSG1
	
	// MSG2
    
        if($msg2 == "1") {
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
        CURLOPT_URL => $urlapi."/message/sendText/AbC123".$tokenapi,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
				"number": "55'.$celular.'",
				"options": {
					"delay": 1200,
					"presence": "composing",
					"linkPreview": false
				},
				"textMessage": {
					"text": "'.$emv.'"
				}
			}',
			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'apikey: '.$apikey .''
			  ),
        ));
        								
        $response = curl_exec($curl);
        curl_close($curl);
        
        }
    
    // FIM MSG2
	
	// MSG3
    
        if($msg3 == "1") {
        
        $curl = curl_init();
        
    
        curl_setopt_array($curl, array(
          CURLOPT_URL => $urlapi."/message/sendMedia/AbC123".$tokenapi,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
		   CURLOPT_POSTFIELDS =>'{
    "number": "55'.$celular.'",
    "options": {
        "delay": 1200,
        "presence": "composing"
    },
    "mediaMessage": {
        "mediatype": "image",
        "caption": "Pague agora via pix. Leia o QRCode",
        "media": "'.$qrcode_base64.'"
    }
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'apikey: '.$apikey .''
  ),
          
		  
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        
        }
    
    // FIM MSG3
	
	
	// MSG4
        
            $msfg = "*ATENÇÃO* Esta é uma mensagem automática e não precisa ser respondida.
    
*Caso já tenha efetuado o pagamento por favor desconsidere esta cobrança.*";
            
            $msfg = str_replace("\r\n","\\n",$msfg);
            
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
            CURLOPT_URL => $urlapi."/message/sendText/AbC123".$tokenapi,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
				"number": "55'.$celular.'",
				"options": {
					"delay": 1200,
					"presence": "composing",
					"linkPreview": false
				},
				"textMessage": {
					"text": "'.$msfg.'"
				}
			}',
			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'apikey: '.$apikey .''
			  ),
 
            ));
            								
            $response = curl_exec($curl);
            curl_close($curl);
	
	    
   header("location: ./master/ver_financeiro&vercli=".$dcob."");

}
?>