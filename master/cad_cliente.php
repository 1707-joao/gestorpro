<?php  
require_once "topo.php";
?>

<div class="slim-mainpanel">
	<div class="container">
		<div align="right" class="mg-b-10"><a href="clientes" class="btn btn-purple btn-sm"> VOLTAR</a></div>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-body" align="justify">
					<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> CADASTRO DE CLIENTE</label>
					<hr>
					
					<form action="classes/clientes_exe.php" method="post">
					<input type="hidden" name="cad_cli" value="ok">
					<div class="row">
						
						<div class="col-md-6">
							<div class="form-group">
								<label>Nome Completo</label>
								<input type="text" class="form-control" name="nome" maxlength="160" onkeydown="upperCaseF(this)" required>
							</div>
						</div>
						
					
						<div class="col-md-3">
							<div class="form-group">
								<label>Data de Nascimento</label>
								<div class="styled-select">
								<input type="date" name="nascimento" class="form-control" maxlength="15" required>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>CPF/CNPJ</label>
								<input type="text" class="form-control" id="cpfcnpj" name="cpfnj" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
							</div>
						</div>
						 
					</div>
					
					<div class="row">
					
						<div class="col-md-4">
							<div class="form-group">
								<label>Grupo/Categoria</label>
								<select class="form-control select2-show-search" name="cliente" required>
								<option value="">Pesquisar...</option>								
								<?php
								$buscacli  = $connect->query("SELECT * FROM categoria WHERE idu = '".$cod_id."' ORDER BY nome ASC");
								while ($buscaclix = $buscacli->fetch(PDO::FETCH_OBJ)) { 
								?>
								<option value="<?=$buscaclix->id;?>"><?php echo $buscaclix->nome;?></option> 
								<?php } ?>
								</select>
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
						<div class="col-md-4">
							<div class="form-group">
								<label>Email</label>
								<div class="styled-select">
								<input type="email" class="form-control" name="email" maxlength="60" required>
								</div>
							</div>
						</div>	 
					</div>
					
					<hr />
					 
					<div class="row">
						<div class="col-md-12">
							<div align="center"> <button type="submit" class="btn btn-primary" name="cart" onclick="validarDocumento()">Salvar <i class="fa fa-arrow-right"></i></button></div>
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
<script src="../lib/select2/js/select2.full.min.js"></script>
<script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
	function upperCaseF(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}
	</script>
		
 <script>
       $("input[id*='cpfcnpj']").inputmask({
  mask: ['999.999.999-99', '99.999.999/9999-99'],
  keepStatic: true
});
    </script>
	<script>
      $(function(){
        'use strict';

        $('.select2').select2({
          minimumResultsForSearch: Infinity
        });

        // Select2 by showing the search
        $('.select2-show-search').select2({
          minimumResultsForSearch: ''
        });

        // Colored Hover
        $('#select2').select2({
          dropdownCssClass: 'hover-success',
          minimumResultsForSearch: Infinity // disabling search
        });

        $('#select3').select2({
          dropdownCssClass: 'hover-danger',
          minimumResultsForSearch: Infinity // disabling search
        });

        // Outline Select
        $('#select4').select2({
          containerCssClass: 'select2-outline-success',
          dropdownCssClass: 'bd-success hover-success',
          minimumResultsForSearch: Infinity // disabling search
        });

        $('#select5').select2({
          containerCssClass: 'select2-outline-info',
          dropdownCssClass: 'bd-info hover-info',
          minimumResultsForSearch: Infinity // disabling search
        });

        // Full Colored Select Box
        $('#select6').select2({
          containerCssClass: 'select2-full-color select2-primary',
          minimumResultsForSearch: Infinity // disabling search
        });

        $('#select7').select2({
          containerCssClass: 'select2-full-color select2-danger',
          dropdownCssClass: 'hover-danger',
          minimumResultsForSearch: Infinity // disabling search
        });

        // Full Colored Dropdown
        $('#select8').select2({
          dropdownCssClass: 'select2-drop-color select2-drop-primary',
          minimumResultsForSearch: Infinity // disabling search
        });

        $('#select9').select2({
          dropdownCssClass: 'select2-drop-color select2-drop-indigo',
          minimumResultsForSearch: Infinity // disabling search
        });

        // Full colored for both box and dropdown
        $('#select10').select2({
          containerCssClass: 'select2-full-color select2-primary',
          dropdownCssClass: 'select2-drop-color select2-drop-primary',
          minimumResultsForSearch: Infinity // disabling search
        });

        $('#select11').select2({
          containerCssClass: 'select2-full-color select2-indigo',
          dropdownCssClass: 'select2-drop-color select2-drop-indigo',
          minimumResultsForSearch: Infinity // disabling search
        });
      });
    </script>

<script src="../js/slim.js"></script>	
  </body>
</html>
<?php
//ob_end_flush();
?>