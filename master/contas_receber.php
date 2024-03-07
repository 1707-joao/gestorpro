<?php
if(isset($_GET["mes"])) {

$mmm = $_GET["mes"];
$aaa = date("Y");
$datam = $mmm."/".$aaa;

} else {

$datam = date("m/Y");
$mmm = date("m");
}

// SOMA VALORES A RECEBER
$valoresareceber 	= $connect->query("SELECT SUM(parcela) AS totalparcela FROM financeiro2 WHERE status='1' AND datapagamento LIKE '%".$datam."%' AND idm ='".$cod_id."'");
$valoresareceberx 	= $valoresareceber->fetch(PDO::FETCH_OBJ);

// SOMA VALORES RECEBIDOS
$valoresrecebidos 	= $connect->query("SELECT SUM(parcela) AS totalpago FROM financeiro2 WHERE status='2' AND pagoem LIKE '%".$datam."%' AND idm ='".$cod_id."'");
$valoresrecebidoss 	= $valoresrecebidos->fetch(PDO::FETCH_OBJ);

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

//pega mes

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
$mes = date('F');
$mes = $meses[$mmm];
$ano = date('Y');
?>
<div class="slim-mainpanel">
      <div class="container">
	  
	  
	  
	  <div class="report-summary-header" style="margin-top:-10px;">
          <div>
            <h4 class="tx-inverse mg-b-3">CONTAS A RECEBER</h4>
            <p class="mg-b-0"><i class="icon ion-calendar mg-r-3"></i> Dados Referente a <?php print $mes;?> de <?php print $ano;?></p>
          </div>
          <div>
		   
			  <a href="cad_contas" class="btn btn-danger mg-r-5"><i class="fa fa-plus tx-22 mg-r-10" aria-hidden="true"></i> Cadastrar Nova</a>
			   
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
	  
	  <?php if(isset($_GET["sucesso"])){ ?>
		<div class="alert alert-solid alert-success mg-t-20" role="alert">
            <strong>Sucesso!!!</strong>
        </div>
		<meta http-equiv="refresh" content="1;URL=./contas_receber" />
		<?php } ?>
	  
	  
	  <div class="section-wrapper mg-t-20">
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> LISTA DE COBRANÇAS ATIVAS</label>
		  <hr>
          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap" width="100%">
              <thead>
                <tr>
				  <th>#</th>
                  <th>Nome</th>
				  <th>Celular</th>
				  <th>CADASTRADO EM</th>
				  <th>Parcelas</th>
				  <th></th>
                  <th></th>
				  <th></th> 
                </tr>
              </thead>
              <tbody>
                
			  <?php
			  $atrazado = "0";
			  $emprestimos	= $connect->query("SELECT * FROM financeiro1 WHERE status='1' AND idm = '".$cod_id."'");
			  while ($dadosemprestimos = $emprestimos->fetch(PDO::FETCH_OBJ)) {
			  $clientes	= $connect->query("SELECT * FROM clientes WHERE Id='".$dadosemprestimos->idc."' AND idm = '".$cod_id."'");
			  while ($dadosclientes = $clientes->fetch(PDO::FETCH_OBJ)) {
			   
			  ?>
                <tr>
				  <td><?php print $dadosemprestimos->Id;?></td>
                  <td><?php print $dadosclientes->nome;?><br/><?php print $dadosclientes->cpf;?></td>
				  <td><?php print $dadosclientes->celular;?></td>
				  <td><?php print $dadosemprestimos->entrada;?></td>
				  <td><?php print $dadosemprestimos->parcelas;?></td>
				 
				  <td align="center">
				  <?php
				    $atrz = 0;
				  
					$buscafin2  = $connect->query("SELECT * FROM financeiro2 WHERE chave='".$dadosemprestimos->chave."' AND status='1' LIMIT 1");
					while ($buscafin23 = $buscafin2->fetch(PDO::FETCH_OBJ)) {
					
					
					$data1 = date("d/m/Y");
					$data2 = $buscafin23->datapagamento;

					// transforma a data do formato BR para o formato americano, ANO-MES-DIA
					$data1 = implode('-', array_reverse(explode('/', $data1)));
					$data2 = implode('-', array_reverse(explode('/', $data2)));

					// converte as datas para o formato timestamp
					$d1 = strtotime($data1);
					$d2 = strtotime($data2);

					if($d2 < $d1) {
					
					echo "<button class=\"btn btn-danger btn-sm\"> EM ATRASO</button>"; $atrz = 1;
					
					}
					
					}
					
				  ?>
				  <?php if($atrz <= 0){ ?>
				  <button class="btn btn-success btn-sm"> EM DIAS</button>
				  <?php } ?>
				  </td>
				  
				  <td align="center">
				  <form action="ver_financeiro" method="post">
	              <input type="hidden" name="vercli" value="<?php print $dadosemprestimos->Id;?>"/>
	              <button type="submit" class="btn btn-info btn-sm"><i class="icon fa fa-search-plus"></i></button>
	              </form>
				  </td>
                  <td align="center">
				  <form action="classes/clientes_exe.php" method="post">
	              <input type="hidden" name="delfin" value="<?php print $dadosemprestimos->chave;?>"/>
	              <button type="submit" class="btn btn-dark btn-sm" onclick='return pergunta();'><i class="icon fa fa-times"></i></button>
	              </form>
				  </td>
                </tr>
               <?php } ?> 
			   <?php } ?>
			   
                 
              </tbody>
            </table>
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
     
    
   	
    
    <script>
      $(function(){
        'use strict';

        $('#datatable1').DataTable({
		  "order": [[ 0, "desc" ]],
          responsive: true,
          language: {
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            lengthMenu: '_MENU_ ítens',
          }
        });

        $('#datatable2').DataTable({
          bLengthChange: false,
          searching: false,
          responsive: true
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
    </script>
<script>
	
	function pergunta(){ 
   // retorna true se confirmado, ou false se cancelado
   return confirm('Tem certeza que deseja excluir esta cobrança?');
}
	
	</script>
	
 
   
    
  </body>
</html>