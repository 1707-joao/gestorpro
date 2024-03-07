<?php  
require_once "topo.php";
$edicli = $_POST['edicli'];
$editarcat = $connect->query("SELECT * FROM clientes WHERE Id='$edicli' AND idm = '".$cod_id."'");
$dadoscat = $editarcat->fetch(PDO::FETCH_OBJ); 
?>

<div class="slim-mainpanel">
	<div class="container">
		<div align="right" class="mg-b-10"><a href="clientes" class="btn btn-purple btn-sm"> VOLTAR</a></div>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-body" align="justify">
					<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> ATUALIZAR CADASTRO DE CLIENTE</label>
					<hr>
					<form action="classes/clientes_exe.php" method="post">
					<input type="hidden" name="edit_cli" value="<?php print $edicli; ?>">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Nome Completo</label>
								<input type="text" class="form-control" name="nome" value="<?php print $dadoscat->nome; ?>" maxlength="160" onkeydown="upperCaseF(this)" required>
							</div>
						</div>
						 
					 
						<div class="col-md-3">
							<div class="form-group">
								<label>Data de Nascimento</label>
								<div class="styled-select">
								<input type="text" name="nascimento" class="form-control" value="<?php print $dadoscat->nascimento;?>" maxlength="18" required>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>CPF</label>
								<input type="text" class="form-control" name="cpf" maxlength="11" value="<?php print $dadoscat->cpf; ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
							</div>
						</div>
						
						 
						
					</div>
					<div class="row">
						
						<div class="col-md-4">
							<div class="form-group">
								<label>Grupo/Categoria</label>
								<select class="form-control select2-show-search" name="cliente" required>
														
								<?php
								$buscacli  = $connect->query("SELECT * FROM categoria WHERE id = '".$dadoscat->idc."'");
								while ($buscaclix = $buscacli->fetch(PDO::FETCH_OBJ)) { 
								?>
								<option value="<?=$buscaclix->id;?>"><?php echo $buscaclix->nome;?></option> 
								<?php } ?>
								
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
								<input type="text" class="form-control" name="celular" maxlength="11" value="<?php print $dadoscat->celular; ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Email</label>
								<div class="styled-select">
								<input type="text" class="form-control" name="email" value="<?php print $dadoscat->email; ?>" maxlength="60">
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
							<input type="text" class="form-control" name="cep" id="cep" maxlength="8" value="<?php print $dadoscat->cep; ?>">
							</div>
						</div>
						<div class="col-md-8">
						<div class="form-group">
							<label>Endereço</label>
							<input type="text" class="form-control" name="rua" id='rua' onkeydown="upperCaseF(this)" value="<?php print $dadoscat->endereco; ?>">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Número</label>
								<input type="number" class="form-control" name="numero" maxlength="5" value="<?php print $dadoscat->numero; ?>">
							</div>
						</div>
					</div>	
						
					<div class="row">	
						<div class="col-md-3">
							<div class="form-group">
								<label>Bairro</label>
								<input type="text" class="form-control" name="bairro" id="bairro" onkeydown="upperCaseF(this)" value="<?php print $dadoscat->bairro; ?>">
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group">
								<label>Complemento</label>
								<input type="text" class="form-control" name="complemento" onkeydown="upperCaseF(this)" value="<?php print $dadoscat->complemento; ?>">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Cidade</label>
								<div class="styled-select">
								<input type="text" class="form-control" name="cidade" id="cidade" onkeydown="upperCaseF(this)" value="<?php print $dadoscat->cidade; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>UF</label>
								<div class="styled-select">
								<input type="text" class="form-control" name="uf" id="uf" onkeydown="upperCaseF(this)" maxlength="2" value="<?php print $dadoscat->uf; ?>">
								</div>
							</div>
						</div>
					</div>
					
					<hr>
 				<div class="row">
					<div class="col-md-12">
						<div align="center"> <button type="submit" class="btn btn-primary" name="cart">Atualizar <i class="fa fa-arrow-right"></i></button></div>
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
		
<script>

        $(document).ready(function() {

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
                $("#ibge").val("");
            }
            
            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");
                        $("#ibge").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#rua").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                                $("#ibge").val(dados.ibge);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });

    </script>
<script src="../js/slim.js"></script>	
  </body>
</html>
<?php
//ob_end_flush();
?>