<?php  
require_once "topo.php";
$edicli = $_POST['edicli'];
$editarcat = $connect->query("SELECT * FROM categoria WHERE id='$edicli'");
$dadoscat = $editarcat->fetch(PDO::FETCH_OBJ); 
?>

<div class="slim-mainpanel">
	<div class="container">
		<div align="right" class="mg-b-10"><a href="funcionarios" class="btn btn-purple btn-sm"> VOLTAR</a></div>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-body" align="justify">
					<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> EDITAR CATEGORIA</label>
					<hr>
					<form id="formulario">
					<input type="hidden" name="edit_cat"  id="edit_cat" value="<?php print $edicli; ?>">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Nome</label>
								<input type="text" class="form-control" name="nome" id="nome" value="<?php print $dadoscat->nome; ?>" maxlength="160" onkeydown="upperCaseF(this)" required>
							</div>
						</div>
						 
						 
						 
						 
					</div>	
					<hr />
					<div class="row">
						<div class="col-md-12">
							<div align="center"> <button type="button" onclick="editarRegistro()" class="btn btn-primary" name="cart">Salvar <i class="fa fa-arrow-right"></i></button></div>
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

<script>
function editarRegistro() {
    // Obter os valores dos campos do formulário
    var nome = $("#nome").val();
    var edit_cat = $("#edit_cat").val();

    // Enviar os dados para o arquivo PHP usando AJAX
    $.ajax({
        type: "POST",
        url: "classes/categoria_exe.php", // Substitua pelo nome do seu arquivo PHP
        data: { nome: nome, edit_cat: edit_cat },
        success: function (response) {
            // Exibir a mensagem de sucesso ou erro
            //var status = $("#mensagem").html(response);
			alert("Processo realizado com sucesso.");
    		window.location.href='./categorias';
			
        }
    });
}
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