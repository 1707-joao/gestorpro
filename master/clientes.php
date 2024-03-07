<div class="slim-mainpanel">
      <div class="container">
	  <div align="right" class="mg-b-10"><a href="cad_cliente" class="btn btn-purple btn-sm"><i class="fa fa-plus mg-r-10" aria-hidden="true"></i>NOVO CLIENTE</a></div>
		
		<?php if(isset($_GET["sucesso"])){ ?>
		<div class="alert alert-solid alert-success" role="alert">
            <strong>Sucesso!!!</strong>
        </div>
		<meta http-equiv="refresh" content="1;URL=./clientes" />
		<?php } ?>
		
		<div class="section-wrapper">
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> CLientes Cadastrados</label>
		  <hr>
          <div class="table-wrapper">
             <table id="datatable1" class="table display responsive nowrap" width="100%">
              <thead>
                <tr>
				  <th>#</th>
				  <th>Grupo/Categoria</th>
                  <th>Nome</th>
				  <th>CPF</th>
				  <th>Celular</th>
				  <th></th>
                  <th></th>
				  <th></th>
                </tr>
              </thead>
              <tbody>
                
			  <?php
			  $clientes	= $connect->query("SELECT * FROM clientes WHERE idm = '".$cod_id."' ORDER BY nome ASC");
			  while ($dadosclientes = $clientes->fetch(PDO::FETCH_OBJ)) {
			  
			  $editarcat = $connect->query("SELECT nome FROM categoria WHERE id='".$dadosclientes->idc."'");
			  $dadoscat = $editarcat->fetch(PDO::FETCH_OBJ); 
			  ?>
                <tr>
				  <td><?php print $dadosclientes->Id;?></td>
				  <td><?php print $dadoscat->nome;?></td>
                  <td><?php print $dadosclientes->nome;?></td>
				  <td><?php print $dadosclientes->cpf;?></td>
				  <td><a href="https://api.whatsapp.com/send?phone=55<?php print $dadosclientes->celular;?>&text=Olá <?php print $dadosclientes->nome;?>" target = "blank" class="btn btn-dark btn-sm"><i class="icon fa fa-whatsapp"></i></a> <?php print $dadosclientes->celular;?></td>
				  <td align="center">
				  <form action="ver_cliente" method="post">
	              <input type="hidden" name="vercli" value="<?php print $dadosclientes->Id;?>"/>
	              <button type="submit" class="btn btn-success btn-sm"><i class="icon fa fa-search-plus"></i></button>
	              </form>
				  </td>
				  <td align="center">
				  <form action="edit_cliente" method="post">
	              <input type="hidden" name="edicli" value="<?php print $dadosclientes->Id;?>"/>
	              <button type="submit" class="btn btn-warning btn-sm"><i class="icon fa fa-pencil-square"></i></button>
	              </form>
				  </td>
                  <td align="center">
				  <form action="classes/clientes_exe.php" method="post">
	              <input type="hidden" name="delcli" value="<?php print $dadosclientes->Id;?>"/>
	              <button type="submit" class="btn btn-danger btn-sm" onclick='return pergunta();'><i class="icon fa fa-times"></i></button>
	              </form>
				  </td>
                </tr>
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
	
	<script>
	
	function pergunta(){ 
   // retorna true se confirmado, ou false se cancelado
   return confirm('Tem certeza que deseja excluir este cliente?');
}
	
	</script>
<script src="../js/slim.js"></script>	
  </body>
</html>
