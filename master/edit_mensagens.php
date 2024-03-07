<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "topo.php";

$edicli = $_POST['edicli'];

$editarcat = $connect->query("SELECT * FROM mensagens WHERE id = '$edicli' AND idu = '" . $cod_id . "'");

$dadoscat = $editarcat->fetch(PDO::FETCH_OBJ);

if ($dadoscat->tipo == '1') {
	$tipomsg = "Cobrança 5 dias";
}

if ($dadoscat->tipo == '2') {
	$tipomsg = "Cobrança 3 dias";
}

if ($dadoscat->tipo == '3') {
	$tipomsg = "Cobrança no dia";
}

if ($dadoscat->tipo == '4') {
	$tipomsg = "Cobrança mensalidade vencida";
}

if ($dadoscat->tipo == '5') {
	$tipomsg = "Agradecimento";
}

if ($dadoscat->tipo == '6') {
	$tipomsg = "Cobrança Manual";
}
?>

<div class="slim-mainpanel">
	<div class="container">
		<div align="right" class="mg-b-10">
			<a href="mensagens" class="btn btn-purple btn-sm">VOLTAR</a>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-body" align="justify">
						<label class="section-title">
							<i class="fa fa-check-square-o" aria-hidden="true"></i>

							ATUALIZAR MENSAGEM

							<?php print $tipomsg; ?>
						</label>

						<hr>

						<form action="classes/mensagens_exe.php" method="post">
							<input type="hidden" name="edit_cli" value="<?php print $edicli; ?>">

							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label>Hora de execução:</label>

										<input id="hora" type="text" name="hora" class="form-control" value="<?php print $dadoscat->hora; ?>">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label>Mensagem:</label>

										<textarea name="msg" cols="30" rows="7" class="form-control"><?php print $dadoscat->msg; ?></textarea>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Opcionais:</label>

										<br />

										#EMPRESA# - Nome do Cliente

										<br />

										#CNPJ# - Nome do Cliente

										<br />

										#ENDERECO# - Nome do Cliente

										<br />

										#CONTATO# - Nome do Cliente

										<br />

										#NOME# - Nome do Cliente

										<br />

										#VENCIMENTO# - Data de vencimento da parcela

										<br />

										#DATAPAGAMENTO# - Data de pagamento da parcela

										<br />

										#VALOR# - Valor da Parcela

										<br />

										#LINK# - Link de Pagamento final, adicione seu domínio antes.
									</div>
								</div>
							</div>

							<hr>

							<div class="row">
								<div class="col-md-12">
									<div align="center">
										<button type="submit" class="btn btn-primary" name="cart">Atualizar <i class="fa fa-arrow-right"></i></button>
									</div>
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
	function upperCaseF(a) {
		setTimeout(function () {
			a.value = a.value.toUpperCase();
		}, 1);
	}

	$(function() {
		'use strict';

		$("#hora").mask("99:99");
	});
</script>
<script src="../js/slim.js"></script>
</body>
</html>
<?php
//ob_end_flush();
?>
