<div class="slim-mainpanel">
      <div class="container">
	  <div align="right" class="mg-b-10"><a href="cad_categoria" class="btn btn-purple btn-sm"><i class="fa fa-plus mg-r-10" aria-hidden="true"></i>NOVA CATEGORIA</a></div>
		
		<?php if(isset($_GET["sucesso"])){ ?>
		<div class="alert alert-solid alert-success" role="alert">
            <strong>Sucesso!!!</strong>
        </div>
		<meta http-equiv="refresh" content="1;URL=./categorias" />
		<?php } ?>
		
		<div class="section-wrapper">
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Categorias Cadastradas</label>
		  <hr>
          <div class="table-wrapper">
             <table id="datatable1" class="table display responsive nowrap" width="100%">
              <thead>
                <tr>
				  <th>#</th>
                  <th>Nome</th>
                  <th></th>
				  <th></th>
                </tr>
              </thead>
              <tbody>
                
			  <?php
			  $clientes	= $connect->query("SELECT * FROM categoria WHERE idu = '".$cod_id."' ORDER BY nome ASC");
			  while ($dadosclientes = $clientes->fetch(PDO::FETCH_OBJ)) {
			  ?>
                <tr>
				  <td><?php print $dadosclientes->id;?></td>
                  <td><?php print $dadosclientes->nome;?></td>
				   
				  <td align="center">
				  <form action="edit_categoria" method="post">
	              <input type="hidden" name="edicli" value="<?php print $dadosclientes->id;?>"/>
	              <button type="submit" class="btn btn-warning btn-sm"><i class="icon fa fa-pencil-square"></i></button>
	              </form>
				  </td>
                  <td align="center">
				  <form id="formulario">
	              <input type="hidden" name="delcli" id="delcli" value="<?php print $dadosclientes->id;?>"/>
	              <button type="button" onclick="excluirRegistro()" class="btn btn-danger btn-sm"><i class="icon fa fa-times"></i></button>
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
function excluirRegistro() {
    
	// Obter os valores dos campos do formulário
    var delcli = $("#delcli").val();
    // Enviar os dados para o arquivo PHP usando AJAX
    $.ajax({
        type: "POST",
        url: "classes/categoria_exe.php", // Substitua pelo nome do seu arquivo PHP
        data: { delcli: delcli },
        success: function (response) {
            // Exibir a mensagem de sucesso ou erro
            //var status = $("#mensagem").html(response);
			alert("Excluido com sucesso.");
    		window.location.href='./categorias';
			
        }
    });
}
</script>
	
	<script>
	
	function pergunta(){ 
   // retorna true se confirmado, ou false se cancelado
   return confirm('Tem certeza que deseja excluir esta categoria?');
}
	
	</script>
<script src="../js/slim.js"></script>	
  </body>
</html>
