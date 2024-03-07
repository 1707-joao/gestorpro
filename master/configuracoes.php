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
		<meta http-equiv="refresh" content="1;URL=./configuracoes" />
		<?php } ?>
		
		
		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-body" align="justify">
					<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> DADOS DA EMPRESA</label>
					<hr>
					
					<form action="classes/config_exe.php" method="post">
					<input type="hidden" name="edit_emp" value="<?php print $edicli; ?>">
					 
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label>NOME COMERCIAL</label>
								<input type="text" class="form-control" name="nomecom" value="<?php print $dadoscat->nomecom; ?>" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>CNPJ</label>
								<div class="styled-select">
								<input type="text" class="form-control" name="cnpj" value="<?php print $dadoscat->cnpj; ?>" required>
								</div>
							</div>
						</div>
                        <div class="col-md-6">
							<div class="form-group">
								<label>ENDEREÇO</label>
								<input type="text" class="form-control" name="enderecom" value="<?php print $dadoscat->enderecom; ?>" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>CONTATO</label>
								<input type="text" class="form-control" name="contato" value="<?php print $dadoscat->contato; ?>" required>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label>Modelo de Cobrança</label>
								<select class="form-control" name="tipopgmto" required>
								
								<?php if($dadoscat->pagamentos == "1") {?>
								<option value="1">Mercado Pago</option>
								
								<?php } ?>
								<?php if($dadoscat->pagamentos == "2") {?>
								<option value="2">Sem Gateway</option>
							 
								<?php } ?>
								<option value="2">Sem Gateway</option>
								<option value="1">Mercado Apgo</option>
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
		
		
		<?php if($dadoscat->tipo == 1) {?>
		
		<br/>
		
		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-body" align="justify">
					<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> TAREFA CRON</label>
					<hr>
					
					<div class="row">
						<div class="col-md-12">
						- Você deve criar duas tarefas CRON eu seu CPANEL com as seguintes configurações:<br/><br/>
						
						1 - Executar a cada minuto todos os dias da semana.<br/>
						2 - Utilize o comando abaixo:<br/><br/>
						
						<code>curl https://seusite/crons/cob_auto.php'</code><br/><br/>
						<code>curl https://seusite/crons/conf_pgmto.php'</code><br/><br/>
						
						
						
						</div>
					</div>
					
					
				</div>	
			</div>
		 
		
		
			<br/>
		
		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-body" align="justify">
					<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> API INTEGRADA NO SISTEMA</label>
					<hr>
					
					<div class="row">
						<div class="col-md-12">
						- Atualmente você está usando nosso API, caso queira uma adquira um VPS.<br/>- Caso tenha a necessidade de montar sua própria api de conexão com o whatsapp basta seguir os passos abaixo:<br/><br/>
						
						1 - Contrate uma VPS básica <a href="#" target="_blank">Clique aqui...</a> Se possuir uma basta formatar e colocar ubunto 20.4<br/><br/>
						
						2 - Crie um subdimonio do (tipo A) apontando pro IP da sua VPS:<br/><br/>
						
						3 - Nos fazemos a instalação pra você por valor de R$ 50,00 Basta contrata uma Vps.<br/> PLW Design<br/>
						
						
						</div>
					</div>
					
					
				</div>	
			</div>
			
			<?php } ?>
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