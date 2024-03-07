<?php
if(isset($_GET["mes"])) {

$mmm = $_GET["mes"];
$aaa = date("Y");
$datam = $mmm."/".$aaa;
$codcliii = $_GET["idcli"];
$codcliix = $_GET["idmas"];

} else {

$mmm = date("m");
$aaa = date("Y");
$datam = $mmm."/".$aaa;
$codcliii = $_POST["idcli"];
$codcliix = $_POST["idmas"];

}

$clientesx	= $connect->query("SELECT * FROM carteira WHERE Id ='".$codcliii."' AND idm ='".$codcliix."'");
$clientesconta = $clientesx->rowCount();

if($clientesconta <= 0)

{ ?>

<meta http-equiv="refresh" content="0;URL=./funcionarios" />

<?php } ?>


<?php

// dados do cliente
$clientesxdados 	= $clientesx->fetch(PDO::FETCH_OBJ);

// PAGAMENTOS
$pempativos 	= $connect->query("SELECT * FROM pagamentofun WHERE data = '".$datam."' AND idc ='".$codcliii."' AND idm ='".$cod_id."'");
$pempativosx = $pempativos->rowCount();

// SOMA VALORES A RECEBER
$valoresareceber 	= $connect->query("SELECT SUM(parcela) AS totalparcela FROM financeiro2 WHERE status='1' AND datapagamento LIKE '%".$datam."%' AND idm ='".$codcliii."'");
$valoresareceberx 	= $valoresareceber->fetch(PDO::FETCH_OBJ);

// SOMA VALORES RECEBIDOS
$valoresrecebidos 	= $connect->query("SELECT SUM(parcela) AS totalpago FROM financeiro2 WHERE status='2' AND pagoem LIKE '%".$datam."%' AND idm ='".$codcliii."'");
$valoresrecebidoss 	= $valoresrecebidos->fetch(PDO::FETCH_OBJ);

// EMPRÉSTIMOS ATIVOS
$empativos 	= $connect->query("SELECT * FROM financeiro1 WHERE status='1' AND idm ='".$codcliii."'");
$empativosx = $empativos->rowCount();

// PARCELAS ABERTAS
$parcelasab	= $connect->query("SELECT * FROM financeiro2 WHERE status='1' AND datapagamento LIKE '%".$datam."%' AND idm ='".$codcliii."'");
$parcelasabx = $parcelasab->rowCount();

// PARCELAS PAGAS
$parcelasap	= $connect->query("SELECT * FROM financeiro2 WHERE status='2' AND pagoem LIKE '%".$datam."%' AND idm ='".$codcliii."'");
$parcelasapx = $parcelasap->rowCount();

// CLIENTES
$cadcli	= $connect->query("SELECT * FROM clientes WHERE idm ='".$codcliii."'");
$cadclix = $cadcli->rowCount();

//pega mes

$meses = array(
    'January' => 'Janeiro',
    'February' => 'Fevereiro',
    'March' => 'Março',
    'April' => 'Abril',
    'May' => 'Maio',
    'June' => 'Junho',
    'July' => 'Julho',
    'August' => 'Agosto',
    'September' => 'Setembro',
    'October' => 'Outubro',
    'November' => 'Novembro',
    'December' => 'Dezembro'
);
$mes = date('F');
$mes = $meses[$mes];
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
		  		 <?php if($pempativosx <= 0) { ?>
				<form action="classes/baixa_pgm.php" method="post">
				<input type="hidden" name="mes" value="<?php print $mmm;?>"/>
				<input type="hidden" name="idc" value="<?php print $codcliii;?>"/>
				<input type="hidden" name="idm" value="<?php print $codcliix;?>"/>
				<input type="hidden" name="valor" value="<?php print $resultado = ($valoresrecebidoss->totalpago * $clientesxdados->nascimento) / 100; ?>"/>
				<input type="hidden" name="emdias" value="ok"/>
				<button type="submit" class="btn btn-danger mg-r-5"><i class="fa fa-thumbs-up tx-20 mg-r-10" aria-hidden="true"></i> Baixar Pagamento</button>
				</form>
				 <?php } else { ?>
			     <button class="btn btn-success mg-r-5"><i class="fa fa-thumbs-up tx-20 mg-r-10" aria-hidden="true"></i> Pagamento em Dias</button>
				 <?php } ?>
			    <div class="dropdown">
              <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="icon ion-ios-calendar-outline tx-24"></i> Alterar Mês
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="painel_usuario&mes=01&idcli=<?php print $codcliii;?>&idmas=<?php print $codcliix;?>">Janeiro</a>
                <a class="dropdown-item" href="painel_usuario&mes=02&idcli=<?php print $codcliii;?>&idmas=<?php print $codcliix;?>">Fevereiro</a>
                <a class="dropdown-item" href="painel_usuario&mes=03&idcli=<?php print $codcliii;?>&idmas=<?php print $codcliix;?>">Março</a>
				<a class="dropdown-item" href="painel_usuario&mes=04&idcli=<?php print $codcliii;?>&idmas=<?php print $codcliix;?>">Abril</a>
				<a class="dropdown-item" href="painel_usuario&mes=05&idcli=<?php print $codcliii;?>&idmas=<?php print $codcliix;?>">Maio</a>
				<a class="dropdown-item" href="painel_usuario&mes=06&idcli=<?php print $codcliii;?>&idmas=<?php print $codcliix;?>">Junho</a>
				<a class="dropdown-item" href="painel_usuario&mes=07&idcli=<?php print $codcliii;?>&idmas=<?php print $codcliix;?>">Julho</a>
				<a class="dropdown-item" href="painel_usuario&mes=08&idcli=<?php print $codcliii;?>&idmas=<?php print $codcliix;?>">Agosto</a>
				<a class="dropdown-item" href="painel_usuario&mes=09&idcli=<?php print $codcliii;?>&idmas=<?php print $codcliix;?>">Setembro</a>
				<a class="dropdown-item" href="painel_usuario&mes=10&idcli=<?php print $codcliii;?>&idmas=<?php print $codcliix;?>">Outubro</a>
				<a class="dropdown-item" href="painel_usuario&mes=11&idcli=<?php print $codcliii;?>&idmas=<?php print $codcliix;?>">Novembro</a>
				<a class="dropdown-item" href="painel_usuario&mes=12&idcli=<?php print $codcliii;?>&idmas=<?php print $codcliix;?>">Dezembro</a>
              </div><!-- dropdown-menu -->
            </div><!-- dropdown -->
			   
			 
          </div>
        </div><!-- d-flex -->
		
		<hr />
	  
	  <div class="dash-headline-two">
          <div>
            <p class="mg-b-0">Resumo financeiro  <br/> do mês.</p>
          </div>
          <div class="d-h-t-right">
            <div class="summary-item">
              <h1>R$: <?php echo number_format($valoresrecebidoss->totalpago, 2, ',', '.'); ?></h1>
              <span>Valores<br>recebidos</span>
            </div>
			 <div class="summary-item">
              <h1>R$: <?php echo number_format($valoresareceberx->totalparcela, 2, ',', '.'); ?></h1>
              <span>Valores a<br>receber</span>
            </div>
            <div class="summary-item">
              
			  <?php 
			  $valr = $valoresareceberx->totalparcela - $valoresrecebidoss->totalpago;
			  $valorNumerico = floatval($valr);
			  if ($valorNumerico < 0) {
			  ?>
			  <h1>R$: 0,00</h1>
			  <?php } else { ?>
			  <h1>R$: <?php echo number_format($valoresareceberx->totalparcela - $valoresrecebidoss->totalpago, 2, ',', '.'); ?></h1>
			  <?php } ?>
			  
              <span>Valores<br>pendentes</span>
            </div>
          </div>
        </div><!-- dash-headline-two -->
	  
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
        <h4 class="tx-inverse mg-b-5">CLIENTE - <?php echo $clientesxdados->nome; ?></h4>
        
        <p class="mg-b-0">Resumo do Mês</p>
      </div>
      
      <div class="d-h-t-right">
        <div class="summary-item" style="flex-direction: column;">
          <h3 style="color: #000;">Vencimento de plano</h3>

          <h4><?php echo $clientesxdados->assinatura; ?></h4>
        </div>
      </div>
    </div>

	  
	 

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