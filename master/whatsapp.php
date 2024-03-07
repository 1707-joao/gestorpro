<?php  
require_once "topo.php";

$editarcat = $connect->query("SELECT * FROM carteira WHERE Id='$cod_id'");
$dadoscat = $editarcat->fetch(PDO::FETCH_OBJ);

$statuscon = $connect->query("SELECT * FROM conexoes WHERE id_usuario = '$cod_id'");
$dadoscon = $statuscon->fetch(PDO::FETCH_OBJ);
?>
	<div class="slim-mainpanel">
		<div class="container">
			<div align="right" class="mg-b-10"><a href="./" class="btn btn-purple btn-sm"> VOLTAR</a></div>
			
			<?php if(isset($_GET["sucesso"])){ ?>
				<div class="alert alert-solid alert-success" role="alert">
					<strong>Sucesso!!!</strong>
				</div>
				
				<meta http-equiv="refresh" content="1;URL=./whatsapp" />
			<?php } ?>
			
			<?php if(isset($_GET["erro"])){ ?>
				<div class="alert alert-solid alert-danger" role="alert">
					<strong>Tente Novamente!!!</strong>
				</div>
				
				<meta http-equiv="refresh" content="1;URL=./whatsapp" />
			<?php } ?>
			
			<?php if($dadoscon->conn == 0){ ?>
				<div class="row">
					<div class="col-md-12">
						<div class="card card-info">
							<div class="card-body" align="justify">
								<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> CONFIGURAÇÃO DO WHATSAPP</label>
								
								<hr>
								
								<form action="classes/gera_qr.php" method="post">
									<input type="hidden" name="token_api" value="<?php print $dadosgerais->tokenapi;?>">
									
									<input type="hidden" name="celular" value="<?php print $dadosgerais->celular; ?>">
									
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<center><i class="fa  fa-times-circle-o tx-danger fa-5x" aria-hidden="true"></i><br/>Desconectado do WhatsAPP</center>
											</div>
										</div>
									</div>
									
									<hr />
									
									<div class="row">
										<div class="col-md-12">
											<div align="center"><button type="submit" class="btn btn-primary">Conectar</button></div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			<?php } else { ?>
				<div class="row">
					<div class="col-md-12">
						<div class="card card-info">
							<div class="card-body" align="justify">
								<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> WHATSAPP</label>
								
								<hr>
								
								<form action="classes/qr_exit.php" method="post">
									<input type="hidden" name="token_api" value="<?php print $dadosgerais->tokenapi;?>">
									
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<center><i class="fa fa-signal tx-success fa-5x" aria-hidden="true"></i><br/>Conectado ao WhatsAPP</center>
											</div>
										</div>
									</div>
									
									<hr />
									
									<div class="row">
										<div class="col-md-12">
											<div align="center"> <button type="submit" class="btn btn-danger">Desconectar</button></div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	
	<script src="../lib/jquery/js/jquery.js"></script>
	<script src="../lib/jquery.cookie/js/jquery.cookie.js"></script>
	<script src="../lib/jquery.maskedinput/js/jquery.maskedinput.js"></script>
	<script src="../lib/select2/js/select2.full.min.js"></script>
	<script src="../js/moeda.js"></script>
	
	<script>
	$('.dinheiro').mask('#.##0,00', {reverse: true});
	
	function upperCaseF(a) {
		setTimeout(function(){
			a.value = a.value.toUpperCase();
		}, 1);
	}
	</script>
	
	<script src="../js/slim.js"></script>
</body>
</html>
<?php
ob_end_flush();
?>