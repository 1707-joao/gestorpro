<?php  
require_once "topo.php";

$edicli = $_POST['edicli'];

$editarcat = $connect->query("SELECT * FROM carteira WHERE Id='$edicli'");

$dadoscat = $editarcat->fetch(PDO::FETCH_OBJ); 
?>
	<div class="slim-mainpanel">
		<div class="container">
			<div align="right" class="mg-b-10"><a href="usuarios" class="btn btn-purple btn-sm"> VOLTAR</a></div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="card card-info">
						<div class="card-body" align="justify">
							<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> EDIÇÃO DE FUNCIONÁRIO</label>
							
							<hr>
							
							<form action="classes/funcionario_exe.php" method="post">
								<input type="hidden" name="edit_cli" value="<?php print $edicli; ?>">
								
								<input type="hidden" name="tipo" value="<?php print $dadoscat->tipo; ?>">
								
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
									
									<div class="col-md-2">
										<div class="form-group">
											<label>CPF/LOGIN</label>
											
											<div class="styled-select">
												<input type="text" class="form-control" name="cpf" maxlength="11" value="<?php print $dadoscat->login; ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
											</div>
										</div>
									</div>
									
									<div class="col-md-2">
										<div class="form-group">
											<label>Senha</label>
											
											<div class="styled-select">
												<input type="password" class="form-control" name="senha" maxlength="19">
											</div>
										</div>
									</div>
									
									<div class="col-md-2">
										<div class="form-group">
											<label>Assinatura</label>
											
											<div class="styled-select">
												<input id="dateMask" type="text" class="form-control" name="assinatura" value="<?php print $dadoscat->assinatura; ?>" maxlength="10">
											</div>
										</div>
									</div>
								</div>
								
								<hr />
								
								<div class="row">
									<div class="col-md-12">
										<div align="center"> <button type="submit" class="btn btn-primary" name="cart">Editar <i class="fa fa-arrow-right"></i></button></div>
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
	$(function() {
		'use strict';
		
		$('#cel').mask('(99)99999-9999');
		
		$('#numb').mask('9999');

		$('#dateMask').mask('00/00/0000');
	});

	function upperCaseF(a) {
		setTimeout(function() {
			a.value = a.value.toUpperCase();
		}, 1);
	}
	</script>
	<script src="../js/slim.js"></script>
</body>
</html>