<?php
if(isset($_GET["mes"])) {

$mmm = $_GET["mes"];
$aaa = date("Y");
$datam = $mmm."/".$aaa;

} else {
$datam = date("m/Y");
$mmm = date("m");
$datam2 = date("Y-m");
}

// SOMA VALORES CONTAS A PAGAR
$valoresapagar 	= $connect->query("SELECT SUM(valor) AS totalapagar FROM financeiro3 WHERE status='1' AND datavencimento LIKE '%".$datam."%' AND idm ='".$cod_id."'");
$valoresapagarx 	= $valoresapagar->fetch(PDO::FETCH_OBJ);

// SOMA VALORES CONTAS PAGAS
$valorespagos 	= $connect->query("SELECT SUM(valor) AS totalpago FROM financeiro3 WHERE status='2' AND datapagamento LIKE '%".$datam2."%' AND idm ='".$cod_id."'");
$valorespagosx 	= $valorespagos->fetch(PDO::FETCH_OBJ);

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
            <h4 class="tx-inverse mg-b-3">CONTAS A PAGAR</h4>
            <p class="mg-b-0"><i class="icon ion-calendar mg-r-3"></i> Dados Referente a <?php print $mes;?> de <?php print $ano;?></p>
          </div>
          <div>
		   
			  <a href="cad_pagar" class="btn btn-danger mg-r-5"><i class="fa fa-plus tx-22 mg-r-10" aria-hidden="true"></i> Cadastrar Nova</a>
			   
			  <div class="dropdown">
              <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon ion-ios-calendar-outline tx-24"></i> Alterar Mês
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			    <a class="dropdown-item" href="./contas_pagar">Mês Atual</a>
                <a class="dropdown-item" href="contas_pagar&mes=01">Janeiro</a>
                <a class="dropdown-item" href="contas_pagar&mes=02">Fevereiro</a>
                <a class="dropdown-item" href="contas_pagar&mes=03">Março</a>
				<a class="dropdown-item" href="contas_pagar&mes=04">Abril</a>
				<a class="dropdown-item" href="contas_pagar&mes=05">Maio</a>
				<a class="dropdown-item" href="contas_pagar&mes=06">Junho</a>
				<a class="dropdown-item" href="contas_pagar&mes=07">Julho</a>
				<a class="dropdown-item" href="contas_pagar&mes=08">Agosto</a>
				<a class="dropdown-item" href="contas_pagar&mes=09">Setembro</a>
				<a class="dropdown-item" href="contas_pagar&mes=10">Outubro</a>
				<a class="dropdown-item" href="contas_pagar&mes=11">Novembro</a>
				<a class="dropdown-item" href="contas_pagar&mes=12">Dezembro</a>
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
              <h1>R$: <?php echo number_format($valorespagosx->totalpago, 2, ',', '.'); ?></h1>
              <span>Contas<br>pagas</span>
            </div>
			 <div class="summary-item">
              <h1>R$: <?php echo number_format($valoresapagarx->totalapagar, 2, ',', '.'); ?></h1>
              <span>Contas a<br>pagar</span>
            </div>
           
          </div>
        </div><!-- dash-headline-two -->
	  
	   
	  
	  <hr/>
	  
	  <?php if(isset($_GET["sucesso"])){ ?>
		<div class="alert alert-solid alert-success mg-t-20" role="alert">
            <strong>Sucesso!!!</strong>
        </div>
		<meta http-equiv="refresh" content="1;URL=./contas_pagar" />
		<?php } ?>
	  
	  
	  <div class="section-wrapper mg-t-20">
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> CONTAS CADASTRADAS</label>
		  <hr>
          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap" width="100%">
              <thead>
                <tr>
				  <th>#</th>
                  <th>Descrição</th>
                  <th>Valor</th>
				  <th>Vencimento</th>
				  <th>Situação </th>
				  <th></th>
				  <th></th>
				  <th></th> 
                </tr>
              </thead>
              <tbody>
                
			  <?php
			  $atrazado = "0";
			  $emprestimos	= $connect->query("SELECT * FROM financeiro3 WHERE datavencimento LIKE '%".$datam."%'  AND idm = '".$cod_id."'");
			  while ($dadosemprestimos = $emprestimos->fetch(PDO::FETCH_OBJ)) {
			   
			  ?>
                <tr>
				  <td><?php print $dadosemprestimos->id;?></td>
                  <td><?php print $dadosemprestimos->descricao;?></td>
                  <td><?php echo number_format($dadosemprestimos->valor, 2, ',', '.'); ?></td>
				  <td><?php print $dadosemprestimos->datavencimento;?>
				  
				  
				  </td>
				  <td align="center">
				  
				  <?php if($dadosemprestimos->status == 1){?>
				  <?php
				    $atrz = 0;
				  
					$data1 = date("d/m/Y");
					$data2 = $dadosemprestimos->datavencimento;

					// transforma a data do formato BR para o formato americano, ANO-MES-DIA
					$data1 = implode('-', array_reverse(explode('/', $data1)));
					$data2 = implode('-', array_reverse(explode('/', $data2)));

					// converte as datas para o formato timestamp
					$d1 = strtotime($data1);
					$d2 = strtotime($data2);

					if($d2 < $d1) {
					
					echo "<button class=\"btn btn-danger btn-sm\"> EM ATRAZO</button>"; $atrz = 1;
					
					}
					
					
				  ?>
				  <?php if($atrz <= 0){ ?>
				  <button class="btn btn-success btn-sm"> EM DIAS</button>
				  <?php } ?>
				  <?php } else {?>
				  
				  <button class="btn btn-dark btn-sm">PAGO</button>
				  <?php } ?>
				  
				  
									
				  
				  </td>
				  
				  <?php if($dadosemprestimos->status == 2){?>
				<td align="center"><button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Esta mensalidade já está paga"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button></td>
				<?php } else {?>
				  
				  <td align="center">
                    <form action="classes/baixa_exe.php" method="get">
                    <input type="hidden" name="idfin2" value="<?php print $dadosemprestimos->id;?>"/>
                    <input type="hidden" name="baixapagar" value="ok"/>
                    <button type="submit" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Dar baixa manual"><i class="fa fa-check-square-o" aria-hidden="true"></i></button>
                    </form>    
				      
				  </td>
				  
				  <?php } ?>
				  	
				  <td align="center">
				  <form action="editar_pagamento" method="post">
	              <input type="hidden" name="vercli" value="<?php print $dadosemprestimos->id;?>"/>
	              <button type="submit" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Editar Conta"><i class="icon fa fa-search-plus"></i></button>
	              </form>
				  </td>
                  <td align="center">
				  <form action="classes/apagar_exe.php" method="post">
	              <input type="hidden" name="delfin" value="<?php print $dadosemprestimos->id;?>"/>
	              <button type="submit" class="btn btn-dark btn-sm" onclick='return pergunta();' data-toggle="tooltip" data-placement="top" title="Excluir Conta"><i class="icon fa fa-times"></i></button>
	              </form>
				  </td>
                </tr>
              
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
    <script src="../lib/datatables/js/jquery.dataTables.js"></script>
    <script src="../lib/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="../lib/select2/js/select2.min.js"></script>
	
    <script>
      $(function(){
        'use strict';

        $('#datatable1').DataTable({
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
	

<script src="../js/slim.js"></script>

<script>
      $(function(){
        'use strict';

        // Initialize tooltip
        $('[data-toggle="tooltip"]').tooltip();

        // colored tooltip
        $('[data-toggle="tooltip-primary"]').tooltip({
          template: '<div class="tooltip tooltip-primary" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
        });

        $('[data-toggle="tooltip-success"]').tooltip({
          template: '<div class="tooltip tooltip-success" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
        });

        $('[data-toggle="tooltip-warning"]').tooltip({
          template: '<div class="tooltip tooltip-warning" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
        });

        $('[data-toggle="tooltip-danger"]').tooltip({
          template: '<div class="tooltip tooltip-danger" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
        });

        $('[data-toggle="tooltip-info"]').tooltip({
          template: '<div class="tooltip tooltip-info" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
        });

        $('[data-toggle="tooltip-indigo"]').tooltip({
          template: '<div class="tooltip tooltip-indigo" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
        });

        $('[data-toggle="tooltip-purple"]').tooltip({
          template: '<div class="tooltip tooltip-purple" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
        });

        $('[data-toggle="tooltip-teal"]').tooltip({
          template: '<div class="tooltip tooltip-teal" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
        });

        $('[data-toggle="tooltip-orange"]').tooltip({
          template: '<div class="tooltip tooltip-orange" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
        });

        $('[data-toggle="tooltip-pink"]').tooltip({
          template: '<div class="tooltip tooltip-pink" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
        });
      });
    </script>
<script>
	
	function pergunta(){ 
   // retorna true se confirmado, ou false se cancelado
   return confirm('Tem certeza que deseja excluir esta conta a pagar?');
}
	
	</script>
	
 
   
    
  </body>
</html>