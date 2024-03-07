<?php
require_once "topo.php";

// ID CLIENTE
if(isset($_GET["vercli"]))  {
$cliente 	= $_GET['vercli'];
}
if(isset($_POST["vercli"]))  {
$cliente 	= $_POST['vercli'];
}

$buscafin  = $connect->query("SELECT * FROM financeiro1 WHERE Id='$cliente' AND idm ='".$cod_id."'");
$buscafinx = $buscafin->fetch(PDO::FETCH_OBJ);

$buscacli  = $connect->query("SELECT * FROM clientes WHERE Id='".$buscafinx->idc."' AND idm ='".$cod_id."'");
$buscaclix = $buscacli->fetch(PDO::FETCH_OBJ);								

?>
<div class="slim-mainpanel">
	<div class="container">
		<div align="right" class="mg-b-10"><a href="./" class="btn btn-purple btn-sm"> VOLTAR</a></div>
		
		<?php if(isset($_GET["sucesso"])){ ?>
		<div class="alert alert-solid alert-success" role="alert">
            <strong>Sucesso!!!</strong>
        </div>
		<meta http-equiv="refresh" content="1;URL=./ver_financeiro" />
		<?php } ?>
		
		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-body" align="justify">
					<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> SITUAÇÃO FINANCEIRA POR CLIENTE</label>
					<hr>
					<div class="row">
						<div class="col-md-12" align="center">
							<div class="form-group">
								<h4><span style="color:#FF9966"></span> <?=$buscaclix->nome;?></h4>
								<?php if($buscafinx->status == 1){ ?>
								<button class="btn btn-danger btn-sm">MENSALIDADES PENDENTE </button>
								<?php } ?>
								<?php if($buscafinx->status == 2){ ?>
								<button class="btn btn-success btn-sm">MENSALIDADES QUITADAS EM <?php print $buscafinx->pagoem; ?></button>
								<?php } ?>
							</div>
						</div>
					</div>	
					<hr style="margin-top:-5px;">
					 
					
					<div class="row">
						 
						<div class="col-md-4">
							<div class="form-group">
								<label>Valor Final</label>
								<input type="text" class="dinheiro form-control" value="R$: <?php print number_format($buscafinx->valorfinal * $buscafinx->parcelas, 2, ',', '.');?>" disabled>
							</div>
						</div>
						
					 	
						<div class="col-md-4">
							<div class="form-group">
								<label>Forma de Pagamento</label>
								<?php if($buscafinx->formapagamento == 1){ ?>
								<input type="text" name="valor" class="form-control" value="Diário" disabled>
								<?php } ?>
								<?php if($buscafinx->formapagamento == 7){ ?>
								<input type="text" name="valor" class="form-control" value="Semanal" disabled>
								<?php } ?>
								<?php if($buscafinx->formapagamento == 15){ ?>
								<input type="text" name="valor" class="form-control" value="Quinzenal" disabled>
								<?php } ?>
								<?php if($buscafinx->formapagamento == 30){ ?>
								<input type="text" name="valor" class="form-control" value="Mensal" disabled>
								<?php } ?>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label>Parcelas</label>
								<div class="styled-select">
								<input type="number" name="parcelas" class="form-control" value="<?php print $buscafinx->parcelas;?>" disabled>
								</div>
							</div>
						</div>
						
						
					</div>
					
					<hr />
					
					<div class="row">
					<div class="col-md-12">
						<div class="table-wrapper">
						
							 <table id="datatable1" class="table display responsive nowrap" width="100%">
							  <thead>
								<tr>
								  <th>#</th>
								   <th>Data de Vencimento</th>
								   <th>Data de Pagamento</th>
								   <th>Valor</th>
                                   <th></th>
								   <th></th>
								   <th></th>
								   
								</tr>
							  </thead>
							  <tbody>
							  
							  
							  <?php
					$buscafin2  = $connect->query("SELECT * FROM financeiro2 WHERE chave='".$buscafinx->chave."' AND idm = '".$cod_id."' ORDER BY Id ASC");
					while($buscafinx2 = $buscafin2->fetch(PDO::FETCH_OBJ)){
					
					$data1 = date("d/m/Y");
					$data2 = $buscafinx2->datapagamento;

					// transforma a data do formato BR para o formato americano, ANO-MES-DIA
					$data1 = implode('-', array_reverse(explode('/', $data1)));
					$data2 = implode('-', array_reverse(explode('/', $data2)));

					// converte as datas para o formato timestamp
					$d1 = strtotime($data1); 
					$d2 = strtotime($data2);

					// verifica a diferença em segundos entre as duas datas e divide pelo número de segundos que um dia possui
					$prazo = ($d2 - $d1) /86400;
					
					$prazox 	= explode(".", $prazo);
					
					$diasprazox		= str_replace("-", "", $prazo);
					
					
					?>
							  
							  <tr>
									
									<td><?php print $buscafinx2->Id;?></td>
									<td><?php print $buscafinx2->datapagamento;?><br/>
								    <?php if($prazox[0] < 0 AND $buscafinx2->pagoem === "n"){?>
									<span class="square-8 bg-danger mg-r-5 rounded-circle"></span> Vencida a <?php print $diasprazox; ?> dia(s)
									<?php } ?>
									
									<?php if($buscafinx2->pagoem != "n"){?>
									<span class="square-8 bg-success mg-r-5 rounded-circle"></span>  Mensalidade Paga
									<?php } else {?>
									<?php if($prazox[0] >= 0){?>
									<span class="square-8 bg-success mg-r-5 rounded-circle"></span>  Em Dias
									<?php } ?>
									<?php } ?>
									
									
									</td>
									<?php if($buscafinx2->pagoem == "n"){?>
									<td>--</td>
									<?php } else {?>
									<td><?php print $buscafinx2->pagoem;?></td>
									<?php } ?>
									<td>R$: <?php print number_format($buscafinx2->parcela, 2, ',', '.');?></td>
									
									<td>
									<form action="editar_mensalidade" method="post">
									<input type="hidden" name="codmens" value="<?php print $buscafinx2->Id;?>"/>
									<input type="hidden" name="vercli" value="<?php print $cliente; ?>"/>
									<input type="hidden" name="editar_m" value="ok"/>
									<button type="submit" class="btn btn-sm btn-teal" data-toggle="tooltip" data-placement="top" title="Editar dados da mensalidade"><i class="fa fa-pencil" aria-hidden="true"></i></button>
									</form>
									</td>
									
									
									<?php if($buscafinx2->status == 2){?>
									<td><button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Esta mensalidade já está paga"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button></td>
									<?php } else {?>
									<td>
									<form action="classes/baixa_exe.php" method="get">
									<input type="hidden" name="idfin2" value="<?php print $buscafinx2->Id;?>"/>
									<input type="hidden" name="codcli" value="<?php print $cliente; ?>"/>
									<input type="hidden" name="emdias" value="ok"/>
									<button type="submit" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Dar baixa manual na mensalidade"><i class="fa fa-check-square-o" aria-hidden="true"></i></button>
									</form>
									</td>
									<?php } ?>
									
									<?php if($buscafinx2->status == 1 && $prazo <= 0){?>
									<td>	
									<form action="../cobm.php" method="POST">
									<input type="hidden" name="dcob" value="<?php print $cliente;?>"/>
									<input type="hidden" name="cob" value="<?php print $buscafinx2->Id;?>"/>
									<input type="hidden" name="codclix" value="<?php print $buscaclix->Id; ?>"/>
									<input type="hidden" name="tipom" value="6"/>
									<button type="submit" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Enviar cobrança da mensalidade no WhatsAPP"><i class="fa fa-whatsapp" aria-hidden="true"></i></button>
									</form>
									</td>
									<?php } ?>
						
						
									<?php if($buscafinx2->status == 1 && $prazo >=1){?>
									<td>	
									<form action="../cobm.php" method="POST">
									<input type="hidden" name="dcob" value="<?php print $cliente;?>"/>
									<input type="hidden" name="cob" value="<?php print $buscafinx2->Id;?>"/>
									<input type="hidden" name="codclix" value="<?php print $buscaclix->Id; ?>"/>
									<input type="hidden" name="tipom" value="4"/>
									<button type="submit" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Enviar cobrança da mensalidade no WhatsAPP"><i class="fa fa-whatsapp" aria-hidden="true"></i></button>
									</form>
									</td>
									<?php } ?>
						
									<?php if($buscafinx2->status == 2){?>
									<td>		
									<form action="../agrad.php" method="POST">
									<input type="hidden" name="dcob" value="<?php print $cliente;?>"/>
									<input type="hidden" name="cob" value="<?php print $buscafinx2->Id;?>"/>
									<input type="hidden" name="codclix" value="<?php print $buscaclix->Id; ?>"/>
									<input type="hidden" name="tipom" value="5"/>
									<button type="submit" class="btn btn-sm btn-dark" data-toggle="tooltip" data-placement="top" title="Enviar comprovante de pagamento da mensalidade"><i class="fa fa-external-link-square" aria-hidden="true"></i></button>
									</form>
									</td>
									<?php } ?>		
									
									
									
									
									
					  
							  </tr>
				   
					 <?php } ?>
							 </tbody>
							 </table>
			  			</div> 
					</div> 
					</div> 
					
				 
					<hr />
					<?php
					$buscafink  = $connect->query("SELECT * FROM financeiro1 WHERE chave='".$buscafinx->chave."' AND idm ='".$cod_id."'");
					$buscafinkx = $buscafink->fetch(PDO::FETCH_OBJ);
					
					$buscafinr  = $connect->query("SELECT * FROM financeiro2 WHERE chave='".$buscafinx->chave."' AND status='2' AND idm ='".$cod_id."'");
					$buscafinx = $buscafinr->rowCount();
					?>
					<?php if($buscafinx == $buscafinkx->parcelas){ ?>
					<div class="row">
						<div class="col-md-12">
							<div align="center">
								<form action="classes/baixa_exe.php" method="get">
							    <input type="hidden" name="idbaixa" value="<?php print $cliente;?>"/>
								<input type="hidden" name="codcli" value="<?php print $cliente; ?>"/>
							    <button type="submit" class="btn btn-success">Baixar Cobrança</button>
							    </form>
							</div>
						</div>	
					</div>
					<?php } ?>		
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>		
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
  </body>
</html>