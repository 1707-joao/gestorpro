<?php
session_start();
require_once "db/Conexao.php";
function validateInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}
if(isset($_POST["loginCPF"]))  {

	$login_cpf = validateInput($_POST['loginCPF']);
    $login_sn1 = validateInput($_POST['loginSENHA']);

    $login_snh 	= sha1($login_sn1);

	$buscauser       = $connect->query("SELECT id FROM carteira WHERE login='$login_cpf' AND senha='$login_snh' AND status='1'");
	$count_user      = $buscauser->rowCount();
	$dadoscliente 	 = $buscauser->fetch(PDO::FETCH_OBJ);
 	if ($count_user 	>=1 ) {
	$_SESSION["cod_id"] = $dadoscliente->id;
	header("location: master/");
	exit;
	} else {
	header("location: ./?erro=login");
	exit;
	}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta name="description" content="<?php print $_nomesistema; ?> é o melhor sistema para cobranças e notificações via WhatsAPP">
    <meta name="keywords" content="financeiro, cobranças, whatsapp">
    <meta property="og:url" content="<?php print $_urlmaster;?>">
    <meta property="og:title" content="<?php print $_nomesistema; ?>">
    <meta property="og:description" content="Cobranças automáticas para whatsapp.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="<?php print $_urlmaster;?>/img/favicon.png">
    <meta property="og:image:width" content="520">
    <meta property="og:image:type" content="image/png">
    <meta property="og:site_name" content="<?php print $_nomesistema; ?>">
    <meta property="og:locale" content="pt-BR">
    <title>Whatsapp Cobranças: Integre sua empresa | <?php print $_nomesistema; ?> </title>
    <link rel="icon" href="<?php print $_urlmaster;?>/img/favicon.png" sizes="32x32" type="image/png">
    <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/slim.css">
    <script src="https://www.google.com/recaptcha/api.js"></script>
 <style>
	body {
    color: #000;
    overflow-x: hidden;
    height: 100%;
    background: linear-gradient(45deg, #D96D00 50%, #EEEEEE 50%);
    background-repeat: no-repeat
}

.card0 {
    box-shadow: 0px 4px 8px 0px #757575;
    border-radius: 10px;
}
.card1 {
justify-content: center;
align-items: center;
}

.logo {
    border-radius: 50%;
    width: 30px;
    height: 30px;
    margin-top: 20px;
    margin-left: 25px
}

.image {
    width: 300px;
    display: block;
    margin-left: auto;
    margin-right: auto
}

.card2 {
    border-bottom-right-radius: 10px;
    border-top-right-radius: 10px
}

.login {
    cursor: pointer
}

.line {
    height: 1px;
    width: 45%;
    background-color: #E0E0E0;
    margin-top: 10px
}

.or {
    width: 10%
}

.text-sm {
    font-size: 14px !important
}

input,
textarea {
    padding: 10px 12px 10px 12px;
    border: 1px solid lightgrey;
    border-radius: 4px;
    margin-bottom: 25px;
    margin-top: 2px;
    width: 100%;
    box-sizing: border-box;
    color: #2C3E50;
    font-size: 14px;
    letter-spacing: 1px;
    background-color: #ECEFF1
}

input:focus,
textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: 1px solid #304FFE;
    outline-width: 0
}

button:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    outline-width: 0
}

.btn-blue {
    background-color: #304FFE;
    width: 100%;
    color: #fff;
    border-radius: 6px
}

.btn-blue:hover {
    background-color: #0D47A1;
    width: 100%;
    color: #fff;
    cursor: pointer
}
.btn-green {
    background-color: #00B200;
    width: 100%;
    color: #fff;
    border-radius: 6px
}

.btn-green:hover {
    background-color: #008C00;
    width: 100%;
    color: #fff;
    cursor: pointer
}

@media screen and (max-width: 991px) {
    .card1 {
        border-bottom-left-radius: 0px;
        border-top-right-radius: 10px;
        justify-content: center;
				align-items: center;
    }

    .card2 {
        border-bottom-left-radius: 10px;
        border-top-right-radius: 0px
    }
}
</style>
</head>

  <body style="background-color:#333333">
  <body>
    <div class="signin-wrapper">

      <div class="signin-box" align="center">
	  	<h3>Painel Financeiro</h3>
		<hr />

        <form action="" method="post">
		<div class="form-group">
          <input type="text" class="form-control" name="loginCPF" placeholder="Usuário" required>
        </div><!-- form-group -->
        <div class="form-group">
          <input type="password" class="form-control" name="loginSENHA" placeholder="Senha" maxlength="16" required>
        </div><!-- form-group -->
        <div class="form-group mg-b-1">
            <center>
              <div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="<?php print $_captcha; ?>"></div>
            </center>
            <br>
        </div>
		<?php if(isset($_GET["erro"]))  { ?>
		<div class="form-group" style="color:#FF0000">
			<i class="fa fa-certificate"></i> Login ou Senha incorreto.
		</div>
		<?php } ?>
        <button type="submit" id="submit" name="submit" class="btn btn-dark btn-block" disabled="disabled">Entrar</button>
		</form>

		<?php if($_ativacom == "1"){ ?>
		<a href="./criar_conta" class="btn btn-info btn-block mg-t-10">Nova Conta</a>
		<a href="./recuperar_senha" class="btn btn-danger btn-block mg-t-10">Recuperar Senha</a>
		<?php } ?>
      </div>
    </div>
    </div>
    </div>
    <script src="lib/jquery/js/jquery.js"></script>
    <script>function recaptchaCallback(){jQuery("#submit").prop("disabled",!1)}</script>
  </body>
</html>
