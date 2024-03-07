<?php  
require_once "topo.php";

$editarcat = $connect->query("SELECT * FROM carteira WHERE Id='$cod_id'");
$dadoscat = $editarcat->fetch(PDO::FETCH_OBJ); 
?>

<div class="slim-mainpanel">
	<div class="container">
		<div align="right" class="mg-b-10"><a href="funcionarios.php" class="btn btn-purple btn-sm"> VOLTAR</a></div>
		
		<?php if(isset($_GET["sucesso"])){ ?>
		<div class="alert alert-solid alert-success" role="alert">
            <strong>Sucesso!!!</strong>
        </div>
		<meta http-equiv="refresh" content="1;URL=./perfil" />
		<?php } ?>
		
		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-body" align="justify">
					<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> MEUS PERFIL</label>
					<hr>
					
					<form action="classes/config_exe.php" method="post">
					<input type="hidden" name="edit_cli" value="<?php print $edicli; ?>">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Nome Completo</label>
								<input type="text" class="form-control" name="nome" value="<?php print $dadoscat->nome; ?>" maxlength="160" onkeydown="upperCaseF(this)" required>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Celular/WhatsApp</label>
								<div class="styled-select">
								<input type="text" class="form-control" name="celular" value="<?php print $dadoscat->celular; ?>" maxlength="11" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>CPF/LOGIN</label>
								<div class="styled-select">
								<input type="text" class="form-control" name="cpf" maxlength="11" value="<?php print $dadoscat->login; ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Senha</label>
								<div class="styled-select">
								<input type="password" class="form-control" name="senha" maxlength="11">
								</div>
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