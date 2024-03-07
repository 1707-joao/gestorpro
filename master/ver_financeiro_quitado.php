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
		<div align="right" class="mg-b-10"><a href="finalizados" class="btn btn-purple btn-sm"> VOLTAR</a></div>
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
								<button class="btn btn-danger btn-sm">PENDENTE </button>
								<?php } ?>
								<?php if($buscafinx->status == 2){ ?>
								<button class="btn btn-success btn-sm">QUITADO EM <?php print $buscafinx->pagoem; ?></button>
								<?php } ?>
							</div>
						</div>
					</div>	
					<hr style="margin-top:-5px;">
					 
					
					<div class="row">
						
						<div class="col-md-3">
							<div class="form-group">
								<label>Valor Total</label>
								<input type="text" class="dinheiro form-control" value="R$: <?php print number_format($buscafinx->valorfinal * $buscafinx->parcelas, 2, ',', '.');?>" disabled>
							</div>
						</div>
						
					
						<div class="col-md-3">
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
						
						<div class="col-md-3">
							<div class="form-group">
								<label>Parcelas</label>
								<div class="styled-select">
								<input type="number" name="parcelas" class="form-control" value="<?php print $buscafinx->parcelas;?>" disabled>
								</div>
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="form-group">
								<label>Primeira Parcela</label>
								<div class="styled-select">
								<input type="text" class="form-control" value="<?php print date_format(new DateTime($buscafinx->primeiraparcela),'d/m/Y');?>" disabled>
								</div>
							</div>
						</div>
					</div>
					
					<hr />
					
					
					<div class="row">
					
					<?php
					$buscafin2  = $connect->query("SELECT * FROM financeiro2 WHERE chave='".$buscafinx->chave."' AND idm ='".$cod_id."' ORDER BY Id ASC");
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
					
					$diasprazox		= str_replace("-", "", $prazo);
					$diasprazo		= $diasprazox * $dadosgerais->vjurus;
					$atualizar = $buscafinx2->parcela + $diasprazo;
					
					?>
						<div class="col-md-6">
							<div class="form-group">
								<label>Valor da Parcela</label>
								<input type="text" class="form-control" value="R$: <?php print number_format($buscafinx2->parcela, 2, ',', '.');?>" disabled>
								<?php if($prazo < 0 && $buscafinx2->status == 1){?>
								<label style="margin-top:10px;">Valor Atualizado </label>
								<input type="text" class="form-control" value="R$: <?php print number_format($atualizar, 2, ',', '.');?>" style="background-color:#FF0000; color:#FFFFFF" disabled>
								<p style="font-size:12px">Juros de R$: <?php print $dadosgerais->vjurus;?>,00 por dia de atrazo</p>
								<?php } ?>
								 
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="form-group">
								<label>Vencimento Original</label>
								<div class="styled-select">
								<input type="text" class="form-control" value="<?php print $buscafinx2->datapagamento;?>" disabled>
								
								</div>
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="form-group">
								<label>Data de Pagamento</label>
								<div class="styled-select">
								<input type="text" class="form-control" value="<?php print $buscafinx2->pagoem;?>" disabled>
								
								</div>
							</div>
						</div>
 						<?php } ?>
					</div>
					<hr />
					 
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>		
<script src="../lib/jquery/js/jquery.js"></script>
<script src="../lib/jquery.cookie/js/jquery.cookie.js"></script>
<script src="../lib/jquery.maskedinput/js/jquery.maskedinput.js"></script>
<script src="../lib/select2/js/select2.full.min.js"></script>
<script src="../js/moeda.js"></script>
<script>
	$('.dinheiro').mask('#.##0,00', {reverse: true});
</script>
<script src="../js/slim.js"></script>	 
  </body>
</html>
<?php
//ob_end_flush();
?>