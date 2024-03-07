<?php  
require_once "topo.php";
?>

<div class="slim-mainpanel">
	<div class="container">
		<div align="right" class="mg-b-10"><a href="cobradores.php" class="btn btn-purple btn-sm"> VOLTAR</a></div>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-body" align="justify">
					<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> CADASTRO DE COBRADORES</label>
					<hr>
					
					<form action="classes/cobrador_exe.php" method="post">
					<input type="hidden" name="cad_cli" value="ok">
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label>Nome Completo</label>
								<input type="text" class="form-control" name="nome" maxlength="160" onkeydown="upperCaseF(this)" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Celular/WhatsApp</label>
								<div class="styled-select">
								<input type="text" class="form-control" name="celular" maxlength="11" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
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
//ob_end_flush();
?>