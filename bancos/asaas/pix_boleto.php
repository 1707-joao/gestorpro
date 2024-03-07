<?php    
    
	$bytes = random_bytes(16);
    $idempotency = bin2hex($bytes);
	
	
    // GERA COBRANCA NO MP
    
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://sandbox.asaas.com/api/v3/payments',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
		  
		  "customer":"cus_123456",
		  "billingType":"BOLETO",
		  "dueDate":"2023-12-10"
		   
		  
		  }',
		  
          CURLOPT_HTTPHEADER => array(
          'Accept: application/json',
		  'Content-Type: application/json',
          'Access_Token: $aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDAyODcxMjY6OiRhYWNoXzMyZjYxNzdmLWY3MTMtNDI3MC05MjBkLTlkZDQ1ODNlNzE5Ng==',
          ),
        ));
        
        echo $response = curl_exec($curl);
          
        //$response = json_decode($response, true);
    
        curl_close($curl);
          
         