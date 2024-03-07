<?php
if(isset($_GET["mes"])) {
	$mmm = $_GET["mes"];
	$aaa = date("Y");
	$ddd = date("d");
	$datam = $mmm."/".$aaa;
	$datam2 = $ddd."/".$mmm."/".$aaa;
	$datam3 = $mmm."/".$aaa;
} else {
	$datam = date("m/Y");
	$mmm = date("m");
	$aaa = date("Y");
	$datam2 = date("d/m/Y");
	$datam3 = date("Y-m");
}

// SOMA VALORES A RECEBER
$valoresareceber 	= $connect->query("SELECT SUM(parcela) AS totalparcela FROM financeiro2 WHERE status='1' AND datapagamento LIKE '%".$datam."%' AND idm ='".$cod_id."'");
$valoresareceberx 	= $valoresareceber->fetch(PDO::FETCH_OBJ);

// SOMA VALORES RECEBIDOS
$valoresrecebidos 	= $connect->query("SELECT SUM(parcela) AS totalpago FROM financeiro2 WHERE status='2' AND pagoem LIKE '%".$datam."%' AND idm ='".$cod_id."'");
$valoresrecebidoss 	= $valoresrecebidos->fetch(PDO::FETCH_OBJ);

// SOMA VALORES RECEBIDOS
$valoresrecebidosh 	= $connect->query("SELECT SUM(parcela) AS totalrh FROM financeiro2 WHERE status='2' AND pagoem = '".$datam2."' AND idm ='".$cod_id."'");
$valoresrecebidossh 	= $valoresrecebidosh->fetch(PDO::FETCH_OBJ);

// EMPRÉSTIMOS ATIVOS
$empativos 	= $connect->query("SELECT * FROM financeiro1 WHERE status='1' AND idm ='".$cod_id."'");
$empativosx = $empativos->rowCount();

// PARCELAS ABERTAS
$parcelasab	= $connect->query("SELECT * FROM financeiro2 WHERE status='1' AND datapagamento LIKE '%".$datam."%' AND idm ='".$cod_id."'");
$parcelasabx = $parcelasab->rowCount();

// PARCELAS PAGAS
$parcelasap	= $connect->query("SELECT * FROM financeiro2 WHERE status='2' AND pagoem LIKE '%".$datam."%' AND idm ='".$cod_id."'");
$parcelasapx = $parcelasap->rowCount();

// CLIENTES
$cadcli	= $connect->query("SELECT * FROM clientes WHERE idm ='".$cod_id."'");
$cadclix = $cadcli->rowCount();

// SOMA VALORES CONTAS A PAGAR
$valoresapagar 	= $connect->query("SELECT SUM(valor) AS totalapagar FROM financeiro3 WHERE status='1' AND datavencimento LIKE '%".$datam."%' AND idm ='".$cod_id."'");
$valoresapagarx 	= $valoresapagar->fetch(PDO::FETCH_OBJ);

// SOMA VALORES CONTAS PAGAS
$valorespagos 	= $connect->query("SELECT SUM(valor) AS totalpago FROM financeiro3 WHERE status='2' AND datapagamento LIKE '%".$datam3."%' AND idm ='".$cod_id."'");
$valorespagosx 	= $valorespagos->fetch(PDO::FETCH_OBJ);

$meses = array(
    '01' => 'Janeiro',
    '02' => 'Fevereiro',
    '03' => 'Março',
    '04' => 'Abril',
    '05' => 'Maio',
    '06' => 'Junho',
    '07' => 'Julho',
    '08' => 'Agosto',
    '09' => 'Setembro',
    '10' => 'Outubro',
    '11' => 'Novembro',
    '12' => 'Dezembro'
);
$mes = $meses[$mmm];
$ano = date('Y');
?>
<div class="slim-mainpanel">
      <div class="container">
	  
	  <div class="report-summary-header" style="margin-top:-10px;">
          <div>
            <h4 class="tx-inverse mg-b-3">PAINEL FINANCEIRO</h4>
            <p class="mg-b-0"><i class="icon ion-calendar mg-r-3"></i> Dados Referente a <?php print $mes;?> de <?php print $ano;?></p>
          </div>
          <div>
		  		<?php 
				
				$v_conexao = $connect->query("SELECT count(id) FROM conexoes WHERE id_usuario = '".$cod_id."' AND conn = '1'")->fetchColumn();

				if($v_conexao === "0") {
				
				?>
            	<a href="whatsapp" class="btn btn-secondary mg-r-5"><i class="fa fa-whatsapp tx-22 mg-r-10" aria-hidden="true"></i> API Desconectada</a>
				<?php } else { 
			   
			   $idins = $dadosgerais->tokenapi;
			   
			   $curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => $urlapi.'/instance/connectionState/AbC123'. $idins,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => '',
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => 'GET',
				  CURLOPT_HTTPHEADER => array(
					'apikey: '.$idins.''
				  ),
				));
			
				$response = curl_exec($curl);
			
				curl_close($curl);
			  
				$res = json_decode($response, true);
			
					$conexaoo = "false";
					$conexaoo = $res['instance']['state'];
				  
					if($conexaoo == 'open') {
			   
 
			   
			   ?>
			   <a href="" class="btn btn-success mg-r-5"><i class="fa fa-whatsapp tx-22 mg-r-10" aria-hidden="true"></i> API Conectada</a>
			   <?php } else { 
			   
			   $editarcad = $connect->query("UPDATE conexoes SET qrcode='', conn = '0', apikey = '0' WHERE id_usuario = '".$cod_id."'");
			   
			   ?>
			   <a href="whatsapp" class="btn btn-danger mg-r-5"><i class="fa fa-whatsapp tx-22 mg-r-10" aria-hidden="true"></i> API Desconectada</a>
			   <?php } ?>
			   <?php } ?>
			   
			    <div class="dropdown">
              <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="icon ion-ios-calendar-outline tx-24"></i> Alterar Mês
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			    <a class="dropdown-item" href="./">Mês Atual</a>
                <a class="dropdown-item" href="&mes=01">Janeiro</a>
                <a class="dropdown-item" href="&mes=02">Fevereiro</a>
                <a class="dropdown-item" href="&mes=03">Março</a>
				<a class="dropdown-item" href="&mes=04">Abril</a>
				<a class="dropdown-item" href="&mes=05">Maio</a>
				<a class="dropdown-item" href="&mes=06">Junho</a>
				<a class="dropdown-item" href="&mes=07">Julho</a>
				<a class="dropdown-item" href="&mes=08">Agosto</a>
				<a class="dropdown-item" href="&mes=09">Setembro</a>
				<a class="dropdown-item" href="&mes=10">Outubro</a>
				<a class="dropdown-item" href="&mes=11">Novembro</a>
				<a class="dropdown-item" href="&mes=12">Dezembro</a>
              </div><!-- dropdown-menu -->
            </div><!-- dropdown -->
			   
			 
          </div>
        </div><!-- d-flex -->
		
		 
        <hr/>
        
        <div class="row row-xs">
          
          <div class="col-sm-6 col-lg-4">
            <div class="card card-status">
              <div class="media">
                <i class="icon ion-ios-bookmarks-outline tx-teal"></i>
                <div class="media-body">
                  <h1>R$: <?php echo number_format($valoresrecebidoss->totalpago, 2, ',', '.'); ?></h1>
                  <p>Recebidos no mês</p>
                </div><!-- media-body -->
              </div><!-- media -->
            </div><!-- card -->
          </div><!-- col-3 -->
          <div class="col-sm-6 col-lg-4 mg-t-10 mg-lg-t-0">
            <div class="card card-status">
              <div class="media">
                <i class="icon ion-ios-cloud-upload-outline tx-primary"></i>
                <div class="media-body">
                  <h1>R$: <?php echo number_format($valoresrecebidossh->totalrh, 2, ',', '.'); ?></h1>
                  <p>Recebidos Hoje</p>
                </div><!-- media-body -->
              </div><!-- media -->
            </div><!-- card -->
          </div><!-- col-3 -->
          <div class="col-sm-6 col-lg-4 mg-t-10 mg-sm-t-0">
            <div class="card card-status">
              <div class="media">
                <i class="icon ion-ios-cloud-download-outline tx-purple"></i>
                <div class="media-body">
                  <h1>R$: <?php echo number_format($valoresareceberx->totalparcela, 2, ',', '.'); ?></h1>
                  <p>A receber no mês</p>
                </div><!-- media-body -->
              </div><!-- media -->
            </div><!-- card -->
          </div><!-- col-3 -->
           
        </div><!-- row -->
		
		
		<div class="card card-dash-one mg-t-20">
          <div class="row no-gutters">
		  
		  <div class="col-lg-3">
              <i class="fa fa-users tx-38" aria-hidden="true"></i>
              <div class="dash-content">
                <span class="tx-12">CLIENTES CADASTRADOS</span>
                <h4><?php echo $cadclix; ?></h4>
              </div>
           </div>
		   
		   <div class="col-lg-3">
              <i class="fa fa-database tx-38" aria-hidden="true"></i>
              <div class="dash-content">
                <span class="tx-12">COBRANÇAS ATIVAS</span>
                <h4><?php echo $empativosx; ?></h4>
              </div>
           </div>
		   
		   <div class="col-lg-3">
              <i class="fa fa-info-circle tx-38" aria-hidden="true"></i>
              <div class="dash-content">
                <span class="tx-12">MENSALIDADES EM ABERTO</span>
                <h4><?php echo $parcelasabx; ?></h4>
              </div>
           </div>
		   
		   <div class="col-lg-3">
              <i class="fa fa-check-square tx-38" aria-hidden="true"></i>
              <div class="dash-content">
                <span class="tx-12">MENSALIDADES PAGAS</span>
                <h4><?php echo $parcelasapx; ?></h4>
              </div>
           </div>
		  
		  </div>
	  </div>
	  
	  <hr/>
	  
	  
	  <div class="dash-headline-two">
          <div>
            <h5 class="mg-b-0">Resumo financeiro de <br/> contas a pagar.</h5>
          </div>
          <div class="d-h-t-right">
            <div class="summary-item">
              <h1>R$: <?php echo number_format($valorespagosx->totalpago, 2, ',', '.'); ?></h1>
              <span>Valores<br>pagos</span>
            </div>
			 <div class="summary-item">
              <h1>R$: <?php echo number_format($valoresapagarx->totalapagar, 2, ',', '.'); ?></h1>
              <span>Valores a<br>pagar</span>
            </div>
            
          </div>
        </div><!-- dash-headline-two -->
	  
	  
	  <hr/>
	  
	  <div class="row row-xs">
		
		<div class="col-lg-4">
		
		<a href="clientes" class="btn btn-info btn-block mg-b-10"><i class="fa fa-users tx-22 mg-r-10" aria-hidden="true"></i> Cadastrar Clientes</a> 
		
		</div>
		
		<div class="col-lg-4">
		
		<a href="contas_pagar" class="btn btn-danger btn-block mg-b-10"><i class="fa fa-random tx-22 mg-r-10" aria-hidden="true"></i> Contas a Pagar</a> 
		
		</div>
		
		<div class="col-lg-4">
		
		<a href="contas_receber" class="btn btn-success btn-block mg-b-10"><i class="fa fa-money tx-22 mg-r-10" aria-hidden="true"></i> Contas a Receber</a> 
		
		</div>
		
		</div><!-- row -->
	  
	 

      </div><!-- container -->
    </div><!-- slim-mainpanel -->
    <script src="../lib/jquery/js/jquery.js"></script>
	<script src="../lib/popper.js/js/popper.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.js"></script>
    <script src="../lib/select2/js/select2.min.js"></script>
	<script src="../lib/datatables/js/jquery.dataTables.js"></script>
    <script src="../lib/datatables-responsive/js/dataTables.responsive.js"></script>
	 

    <script src="../js/slim.js"></script>
     
    
   	
   
 
	
 
   
    
  </body>
</html>