<?php  
require_once "topo.php";
?>

<div class="slim-mainpanel">
	<div class="container">
		<div align="right" class="mg-b-10"><a href="contas_pagar" class="btn btn-purple btn-sm"> VOLTAR</a></div>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-body" align="justify">
					<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> CADASTRO CONTAS A PAGAR</label>
					<hr>
					
					<form action="cad_pagar_simulador" method="post">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Descrição</label>
								<input type="text" name="descricao" class="form-control" required>
							</div>
						</div>
						
					</div>	
					
					<hr />
					<hr />
					
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Valor da Mensalidade</label>
								<div class="styled-select">
								<input type="text" name="valor" class="dinheiro form-control" required>
								</div>
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="form-group">
								<label>Frequência</label>
								<select class="form-control select2-show-search" name="fpagamento" required>
								<option value="">Pesquisar...</option>
								<option value="30">Mensal</option>
								</select>
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="form-group">
								<label>Quantidade de Mensalidades</label>
								<div class="styled-select">
								<input type="number" name="parcelas" class="form-control" value="1" required>
								</div>
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="form-group">
								<label>Data do Primeiro Pagamento</label>
								<div class="styled-select">
								<input type="date" name="datap" class="form-control" required>
								</div>
							</div>
						</div>
					</div>
					
					<hr />
					 
					<div class="row">
						<div class="col-md-12">
							<div align="center"> <button type="submit" class="btn btn-primary" name="cart">Avançar <i class="fa fa-arrow-right"></i></button></div>
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
<script src="../lib/bootstrap/js/bootstrap.js"></script>
<script src="../lib/jquery.cookie/js/jquery.cookie.js"></script>
<script src="../lib/jquery.maskedinput/js/jquery.maskedinput.js"></script>
<script src="../lib/select2/js/select2.full.min.js"></script>
<script src="../js/moeda.js"></script>
<script>
	$('.dinheiro').mask('#.##0,00', {reverse: true});
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
    
  </body>
</html>
<?php
//ob_end_flush();
?>