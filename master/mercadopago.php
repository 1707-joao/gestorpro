<?php  
require_once "topo.php";

$editarcat = $connect->query("SELECT * FROM carteira WHERE Id='$cod_id'");
$dadoscat = $editarcat->fetch(PDO::FETCH_OBJ); 
?>

<div class="slim-mainpanel">
	<div class="container">
		<div align="right" class="mg-b-10"><a href="./" class="btn btn-purple btn-sm"> VOLTAR</a></div>
		
		
		<?php if(isset($_GET["sucesso"])){ ?>
		<div class="alert alert-solid alert-success" role="alert">
            <strong>Sucesso!!!</strong>
        </div>
		<meta http-equiv="refresh" content="1;URL=./mercadopago" />
		<?php } ?>
		
		
		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-body" align="justify">
					<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> CONFIGURAÇÃO DO MERCADO PAGO</label>
					<hr>
					
					<form action="classes/config_exe.php" method="post">
					<input type="hidden" name="edit_m" value="<?php print $edicli; ?>">
					 
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Para gerar o seu token acesse o link abaixo:</label><br/>
								1 - <a href="https://www.mercadopago.com.br/developers/panel/app" class="btn btn-success btn-sm" target="_blank"> Clique Aqui</a><br/>
								2 - Clique em <b>Criar Aplicação</b><br/>
								3 - Escreva o <b>Nome da Aplicação</b><br/>
								4 - Marque <b>Pagamento Online</b><br/>
								5 - Você está usando uma plataforma de e-commerce? <b>Não</b><br/>
								6 - Qual produto você está integrando? <b>CheckoutTransparente</b><br/>
								7 - Modelo de integração? <b>Não precisa marcar nada</b><br/>
								8 - Aceite os termos<br/>
								9 - <b>Crie a Aplicação</b><br/>
								10 - Clique no menu <b>Credências de Produção</b> no menu a esqueda<br/>
								11 - Na opção Setor escolha <b>Serviços de TI</b><br/>
								11 - Na opção Site <b>Deixa em branco</b><br/>
								12 - Autorize o uso<br/>
								13 - <b>Crie as Credênciais de Produção</b><br/>
								14 - Escolha a credêncial <b>Access Token</b> copie e cole no campo abaixo<br/>
							</div>
						</div>
					
					</div>
						 
						<hr/>
					<div class="row">
					
						<div class="col-md-8">
							<div class="form-group">
								<label>Token MP</label>
								<input type="text" class="form-control" name="tokenmp" value="<?php print $dadoscat->tokenmp; ?>" required>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label>Chave Copia e Cola</label>
								<select class="form-control" name="msgqr" required>
								
								<?php if($dadoscat->msgqr == "1") {?>
								<option value="1">Sim</option>
								 
								<?php } ?>
								<?php if($dadoscat->msgqr == "2") {?>
								<option value="2" selected="selected">Não</option>
							 
								<?php } ?>
								<option value="1">Sim</option>
								<option value="2">Não</option>
								</select>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label>Envia QRCode</label>
								<select class="form-control" name="msgpix" required>
								
								<?php if($dadoscat->msgpix == "1") {?>
								<option value="1">Sim</option>
								
								<?php } ?>
								<?php if($dadoscat->msgpix == "2") {?>
								<option value="2">Não</option>
							 
								<?php } ?>
								<option value="1">Sim</option>
								<option value="2">Não</option>
								</select>
							</div>
						</div>
                         
					</div>
                      
                      
                      
                      
					<hr />
					<div class="row">
						<div class="col-md-12">
							<div align="center"> <button type="submit" class="btn btn-primary" name="cart">Salvar <i class="fa fa-arrow-right"></i></button></div>
						</div>		
					</div>		
					</form>	
					
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
	<script>
	function upperCaseF(a){
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