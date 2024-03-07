<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../db/Conexao.php';
require_once __DIR__ . '/../master/classes/functions.php';

if ($_ativacom != "1") {
  header("location: ../");

  exit;
}

$pegadadosgerais = $connect->query("SELECT * FROM carteira LIMIT 1");
$dadosgerais = $pegadadosgerais->fetch(PDO::FETCH_OBJ);

$token = $dadosgerais->tokenapi;

function validateInput($input) {
  $input = trim($input);

  $input = stripslashes($input);

  $input = htmlspecialchars($input);

  return $input;
}

$arr = array("(", ")", ".", "-", "/");

if (isset($_POST["celular"])) {
  $login_cel = str_replace($arr, "", $_POST['celular']);

  $login_cel = validateInput($login_cel);

  $buscauser = $connect->query("SELECT * FROM carteira WHERE celular='$login_cel'");

  $count_user = $buscauser->rowCount();

  if ($count_user <= 0) {
    header("location: ./?erroL=login");

    exit;
  }

  function gerarSenhaAleatoria($tamanho) {
    $caracteres = '0123456789';

    $senha = '';

    for ($i = 0; $i < $tamanho; $i++) {
      $index = rand(0, strlen($caracteres) - 1);

      $senha .= $caracteres[$index];
    }

    return $senha;
  }

  $senhaAleatoria = gerarSenhaAleatoria(4);

  $login_snh = sha1($senhaAleatoria);

  $baixasimples = $connect->query("UPDATE carteira SET senha='" . $login_snh . "' WHERE celular ='" . $login_cel . "' AND idm ='1'");

  $dadosuser = $buscauser->fetch(PDO::FETCH_OBJ);

  $msfg = "*NOVA SENHA CRIADA COM SUCESSO*\r\nOlá *" . $dadosuser->nome . "* sua conta foi criada com sucesso.\r\nSegue abaixo os dados de login:\r\n*URL*: " . $_urlmaster . "\r\n*Usuário*: " . $dadosuser->login . "\r\n*Senha*: " . $senhaAleatoria . "\r\n*Esta é uma mensagem automática e não precisa ser respondida.*";
  $msfg = str_replace("\r\n", "\n\n", $msfg);

  $data = array(
    "number" => "55" . $login_cel,
    "options" => array(
      "delay" => 2000,
      "presence" => "composing",
      "linkPreview" => false
    ),
    "textMessage" => array(
      "text" => $msfg
    )
  );

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $urlapi . "/message/sendText/AbC123" . $token,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_FAILONERROR => true,
    CURLOPT_VERBOSE => true,
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
      'apikey: ' . $apikey . ''
    ),
  )
  );

  $response = curl_exec($curl);

  if ($response === false) {
    echo 'Erro cURL: ' . curl_error($curl);
  }

  curl_close($curl);

  header("location: ./?sucesso=login");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
  <meta name="description" content="<?php print $_nomesistema; ?> é o melhor sistema para cobranças e notificações via WhatsAPP">
  <meta name="keywords" content="financeiro, cobranças, whatsapp">
  <meta property="og:url" content="<?php print $_urlmaster; ?>">
  <meta property="og:title" content="<?php print $_nomesistema; ?>">
  <meta property="og:description" content="Cobranças automáticas para whatsapp.">
  <meta property="og:type" content="website">
  <meta property="og:image" content="<?php print $_urlmaster; ?>/img/favicon.png">
  <meta property="og:image:width" content="520">
  <meta property="og:image:type" content="image/png">
  <meta property="og:site_name" content="<?php print $_nomesistema; ?>">
  <meta property="og:locale" content="pt-BR">
  <title>Whatsapp Cobranças: Integre sua empresa | <?php print $_nomesistema; ?></title>
  <link rel="icon" href="<?php print $_urlmaster; ?>/img/favicon.png" sizes="32x32" type="image/png">
  <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/slim.css">
  <script src="https://www.google.com/recaptcha/api.js"></script>
</head>

<body style="background-color:#333333">
  <div class="signin-wrapper">
    <div class="signin-box">
      <h3 style="text-align: center;">Recuperar Conta</h3>
      
      <hr />
      
      <form action="" method="post">
        <div class="form-group">
          <input type="text" class="form-control" name="celular" id="celular" placeholder="Nº celular com WhatsAPP" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
          
          <code>Informe o número do celular cadastrado para recuperar sua senha.</code>
        </div>
        
        <div class="form-group mg-b-1" style="text-align: center;">
          <div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="<?php print $_captcha; ?>" style="display: inline-block;"></div>
        </div>

        <?php if (isset($_GET["sucesso"])) { ?>
        
        <div class="form-group" style="color:#00CC00">
          <i class="fa fa-certificate"></i> Senha alterada com sucesso.
        </div>

        <?php } ?>

        <?php if (isset($_GET["erroL"])) { ?>
        <div class="form-group" style="color:#FF0000">
          <i class="fa fa-certificate"></i> Nº celular não cadastrado. Tente outro.
        </div>
        <?php } ?>

        <button type="submit" id="submit" name="submit" class="btn btn-dark btn-block" disabled="disabled">Enviar</button>
      </form>

      <a href="../" class="btn btn-warning btn-block mg-t-10">Voltar</a>
    </div>
  </div>

  <script src="../lib/jquery/js/jquery.js"></script>

  <script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>

  <script>
    function upperCaseF(a) {
      setTimeout(function () {
        a.value = a.value.toUpperCase();
      }, 1);
    }

    $("input[id*='cpfcnpj']").inputmask({ mask: ['999.999.999-99', '99.999.999/9999-99'], keepStatic: true });

    $("input[id*='celular']").inputmask({ mask: ['(99)999999999'], keepStatic: true });

    function recaptchaCallback() {
      jQuery("#submit").prop("disabled", !1);
    }
  </script>
</body>
</html>