<?php
require_once "topo.php";

// ID CLIENTE
if(isset($_GET["vercli"]))  {
$cliente 	= $_GET['vercli'];
}
if(isset($_POST["vercli"]))  {
$cliente 	= $_POST['vercli'];
}

$buscamens  = $connect->query("SELECT * FROM financeiro3 WHERE id='$cliente' AND idm ='".$cod_id."'");
$buscamensx = $buscamens->fetch(PDO::FETCH_OBJ);

?>
<div class="slim-mainpanel">
	<div class="container">
		<div align="right" class="mg-b-10"><a href="contas_pagar" class="btn btn-purple btn-sm"> VOLTAR</a></div>
		
		<?php if(isset($_GET["sucesso"])){ ?>
		<div class="alert alert-solid alert-success" role="alert">
            <strong>Sucesso!!!</strong>
        </div>
		<meta http-equiv="refresh" content="1;URL=./ver_financeiro" />
		<?php } ?>
		
		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-body" align="justify">
					<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> EDITAR MENSALIDADE #ID - <?php print $cliente; ?></label>
					
						
					<hr style="margin-top:-5px;">
					 <form action="classes/editarm_exe.php" method="post">
									<input type="hidden" name="idfin2" value="<?php print $cliente;?>"/>
									<input type="hidden" name="pagas" value="ok"/>
					
					<div class="row">
					    
					    <div class="col-md-6">
							<div class="form-group">
								<label>Descrição</label>
								<input type="text" name="descricao" class="form-control" value="<?php print $buscamensx->descricao; ?>" required>
							</div>
						</div>
					
						<div class="col-md-3">
							<div class="form-group">
								<label>Data de Vencimento</label>
								<div class="styled-select">
								<?php if($buscamensx->status == "2") { ?>
								<input type="hidden" name="datap" value="<?php print $buscamensx->datavencimento;?>"/>
								<input type="text" class="form-control"  value="<?php print $buscamensx->datavencimento;?>" disabled>
								<?php } else { ?>
								<input name="datap" id="dateMask" class="form-control"  value="<?php print $buscamensx->datavencimento;?>" required>
								<?php }  ?>
								</div>
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="form-group">
								<label>Valor da Parcela</label>
								<?php if($buscamensx->status == "2") { ?>
								<input type="hidden" name="valor" value="<?php print number_format($buscamensx->valor, 2, ',', '.');?>"/>
								<input type="text" class="dinheiro form-control" value="R$: <?php print number_format($buscamensx->valor, 2, ',', '.');?>" disabled>
								<?php } else { ?>
								<input type="text" name="valor" class="dinheiro form-control" value="R$: <?php print number_format($buscamensx->valor, 2, ',', '.');?>" required>
							    <?php }  ?>
							
							</div>
						</div>
						
					 	
					 
						
						<div class="col-md-12">
							<div class="form-group">
								<label>Inserir Observação:</label>
								<div class="styled-select">
								 <textarea rows="3" name="obsv" class="form-control"><?php print $buscamensx->observacao;?></textarea>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div align="center">	
						<hr/>
						<center>
						<button type="submit" class="btn btn-sm btn-teal">Salvar</button>
						</center>
									</form>
					</div>
					
					 </div>
					
					 
					
				 
					 
					 	
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
        'use strict'

        // Input Masks
        $('#dateMask').mask('99/99/9999');
         

      });
    </script>
<script src="../js/slim.js"></script>

 
  </body>
</html>
