<?php
require_once "topo.php";
?>
<div class="slim-mainpanel">
      <div class="container">
	  <div align="right" class="mg-b-10"><a href="./" class="btn btn-purple btn-sm"> VOLTAR</a></div>
		
		<?php if(isset($_GET["sucesso"])){ ?>
		<div class="alert alert-solid alert-success" role="alert">
            <strong>Sucesso!!!</strong>
        </div>
		<meta http-equiv="refresh" content="1;URL=./finalizados" />
		<?php } ?>
		
	  <div class="section-wrapper mg-t-20">
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Pagamentos Finalizados</label>
		  <hr>
          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap" width="100%">
              <thead>
                <tr>
				  <th>#</th>
                  <th>Nome</th>
				  <th>Data Cadastro</th> 
				  <th>Data da Baixa</th>
				  <th></th>
				  <!--<th></th>-->
                </tr>
              </thead>
              <tbody>
                
			  <?php
			  $atrazado = "0";
			  $emprestimos	= $connect->query("SELECT * FROM financeiro1 WHERE status='2' AND idm = '".$cod_id."'");
			  while ($dadosemprestimos = $emprestimos->fetch(PDO::FETCH_OBJ)) {
			  $clientes	= $connect->query("SELECT * FROM clientes WHERE Id='".$dadosemprestimos->idc."' AND idm = '".$cod_id."'");
			  while ($dadosclientes = $clientes->fetch(PDO::FETCH_OBJ)) {
			   
			  ?>
                <tr>
				  <td><?php print $dadosemprestimos->Id;?></td>
                  <td><?php print $dadosclientes->nome;?><br/><?php print $dadosclientes->cpf;?></td>
				  <td><?php print $dadosemprestimos->entrada;?></td>
				  <td><?php print date_format(new DateTime($dadosemprestimos->pagoem),'d/m/Y');?></td>
				  <td align="center">
				  <form action="ver_financeiro_quitado" method="post">
	              <input type="hidden" name="vercli" value="<?php print $dadosemprestimos->Id;?>"/>
	              <button type="submit" class="btn btn-info btn-sm"><i class="icon fa fa-search-plus"></i></button>
	              </form>
				  </td>
				  <!--
				  <td align="center">
				  <form action="classes/clientes_exe.php" method="post">
	              <input type="hidden" name="delfin" value="<?php print $dadosemprestimos->chave;?>"/>
	              <button type="submit" class="btn btn-danger btn-sm"><i class="icon fa fa-times"></i></button>
	              </form>
				  </td> -->
                </tr>
               <?php } ?> 
			   <?php } ?>
			   
                 
              </tbody>
            </table>
          </div> 
        </div> 

      </div><!-- container -->
    </div><!-- slim-mainpanel -->
    <script src="../lib/jquery/js/jquery.js"></script>
	
    <script src="../lib/datatables/js/jquery.dataTables.js"></script>
    <script src="../lib/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="../lib/select2/js/select2.min.js"></script>
	
    <script>
      $(function(){
        'use strict';

        $('#datatable1').DataTable({
		  "order": [[ 0, "desc" ]],
          responsive: true,
          language: {
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            lengthMenu: '_MENU_ ítens',
          }
        });

        $('#datatable2').DataTable({
          bLengthChange: false,
          searching: false,
          responsive: true
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
    </script>
	<?php if($atrazado >= 1){?>
	<script>
	var audio = new Audio('campainha.mp3');
	audio.addEventListener('canplaythrough', function() {
	audio.play();
	});
	</script>
	<?php } ?>
<script src="../js/slim.js"></script>	
  </body>
</html>
