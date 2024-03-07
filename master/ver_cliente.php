<?php  
require_once "topo.php";
$edicli = $_POST['vercli'];
$editarcat = $connect->query("SELECT * FROM clientes WHERE Id='$edicli'  AND idm = '".$cod_id."'");
$dadoscat = $editarcat->fetch(PDO::FETCH_OBJ); 
?>

<div class="slim-mainpanel">
	<div class="container">
		<div align="right" class="mg-b-10"><a href="clientes" class="btn btn-purple btn-sm"> VOLTAR</a></div>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-body" align="justify">
					<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> VER CADASTRO DE CLIENTE</label>
					<hr>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Nome Completo</label>
								<input type="text" class="form-control" disabled value="<?php print $dadoscat->nome; ?>">
							</div>
						</div>
						
					
						<div class="col-md-3">
							<div class="form-group">
								<label>Data de Nascimento</label>
								<div class="styled-select">
								<input type="text" disabled class="form-control" disabled value="<?php print $dadoscat->nascimento; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>CPF</label>
								<input type="text" class="form-control" disabled value="<?php print $dadoscat->cpf; ?>">
							</div>
						</div>
						
						
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Celular/WhatsApp</label>
								<div class="styled-select">
								<input type="text" class="form-control" disabled value="<?php print $dadoscat->celular; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Email</label>
								<div class="styled-select">
								<input type="text" class="form-control" disabled value="<?php print $dadoscat->email; ?>">
								</div>
							</div>
						</div>	 
					</div>
					
					<hr />
					<hr />
					
					<div class="row">
						<div class="col-md-2">
						<div class="form-group">
							<label>CEP</label>
							<input type="text" class="form-control" disabled value="<?php print $dadoscat->cep; ?>">
							</div>
						</div>
						<div class="col-md-8">
						<div class="form-group">
							<label>Endereço</label>
							<input type="text" class="form-control" disabled value="<?php print $dadoscat->endereco; ?>">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Número</label>
								<input type="number" class="form-control" disabled value="<?php print $dadoscat->numero; ?>">
							</div>
						</div>
					</div>	
						
					<div class="row">	
						<div class="col-md-3">
							<div class="form-group">
								<label>Bairro</label>
								<input type="text" class="form-control" disabled value="<?php print $dadoscat->bairro; ?>">
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group">
								<label>Complemento</label>
								<input type="text" class="form-control" disabled value="<?php print $dadoscat->complemento; ?>">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Cidade</label>
								<div class="styled-select">
								<input type="text" class="form-control" disabled value="<?php print $dadoscat->cidade; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>UF</label>
								<div class="styled-select">
								<input type="text" class="form-control" disabled value="<?php print $dadoscat->uf; ?>">
								</div>
							</div>
						</div>
					</div>
					
					<hr>
 				<div class="row" align="center">
					<div class="col-md-12">
					<?php
					$maps = "https://www.google.com.br/maps/place/".$dadoscat->endereco.", ".$dadoscat->numero." - ".$dadoscat->bairro.", ".$dadoscat->cidade." - ".$dadoscat->uf2;
					echo "<a href=\"{$maps}\" target=\"_blank\" class=\"btn btn-primary\" rel=\"noopener noreferrer\">Ver no Mapa</a>";
					?>
					</div>		
				</div>		
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
	$(function(){
		'use strict';
		$('#cel').mask('(99)99999-9999');  
		$('#numb').mask('9999');	
	});
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
//ob_end_flush();
?>