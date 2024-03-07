<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../db/Conexao.php';
require_once __DIR__ . '/../master/classes/functions.php';
require_once "class-valida-cpf-cnpj.php";

// Verifica se o acesso está autorizado
if ($_ativacom != "1") {
  header("location: ../");
  exit;
}

// Obtém dados gerais
$pegadadosgerais = $connect->query("SELECT * FROM carteira LIMIT 1");
$dadosgerais = $pegadadosgerais->fetch(PDO::FETCH_OBJ);
$tokenapi = $dadosgerais->tokenapi;

// Função para validar a entrada do usuário
function validateInput($input)
{
  return htmlspecialchars(stripslashes(trim($input)));
}

// Função para gerar senha aleatória
function gerarSenhaAleatoria($tamanho)
{
  $caracteres = '0123456789';
  $senha = '';
  for ($i = 0; $i < $tamanho; $i++) {
    $index = rand(0, strlen($caracteres) - 1);
    $senha .= $caracteres[$index];
  }
  return $senha;
}

$arr = array("(", ")", ".", "-", "/");

// Processamento do formulário
if (isset($_POST["cpfnj"])) {
  $login_cpf = str_replace($arr, "", $_POST['cpfnj']);
  $login_cel = str_replace($arr, "", $_POST['celular']);
  $login_cpf = validateInput($login_cpf);
  $login_cel = validateInput($login_cel);
  $nomec = validateInput($_POST['nomec']);

  // Validação de CPF/CNPJ
  $cpf_cnpj = new ValidaCPFCNPJ($login_cpf);
  $formatado = $cpf_cnpj->formata();
  if (!$formatado) {
    echo '<script type="text/javascript">';
    echo 'alert("CPF ou CNPJ incorreto");';
    echo 'history.go(-1);';
    echo '</script>';
    exit;
  }

  // Verificação de duplicidade de CPF/CNPJ
  $buscauser = $connect->prepare("SELECT id FROM carteira WHERE login = :login");
  $buscauser->execute(['login' => $login_cpf]);
  if ($buscauser->rowCount() >= 1) {
    header("location: ./?erroL=login");
    exit;
  }

  // Verificação de duplicidade de celular
  $buscauser = $connect->prepare("SELECT id FROM carteira WHERE celular = :celular");
  $buscauser->execute(['celular' => $login_cel]);
  if ($buscauser->rowCount() >= 1) {
    header("location: ./?erroC=login");
    exit;
  }

  $senhaAleatoria = gerarSenhaAleatoria(6);
  $login_snh = sha1($senhaAleatoria);

  $dataAtual = date("d/m/Y");
  $dataAtualArray = explode("/", $dataAtual);
  $dataAssinaturaArray = date('Y-m-d', strtotime($dataAtualArray[2] . '-' . $dataAtualArray[1] . '-' . $dataAtualArray[0] . ' +3 days'));
  $dataAssinatura = date("d/m/Y", strtotime($dataAssinaturaArray));

  $cadcat = $connect->prepare("INSERT INTO carteira (idm, login, senha, tipo, nome, celular, assinatura) VALUES ('1', :login, :senha, '2', :nome, :celular, :assinatura)");
  $cadcat->execute([
    'login' => $login_cpf,
    'senha' => $login_snh,
    'nome' => $nomec,
    'celular' => $login_cel,
    'assinatura' => $dataAssinatura
  ]);

  $lastInsertId = $connect->lastInsertId();

  $connect->query("INSERT INTO conexoes(id_usuario, tokenid) VALUES ('" . $lastInsertId . "','" . $token . "')");
	$connect->query("INSERT INTO mensagens(idu, tipo, msg) VALUES ('" . $lastInsertId . "','1','*#NOME#* mensagem de com 5 dias antes do vencimento')");
	$connect->query("INSERT INTO mensagens(idu, tipo, msg) VALUES ('" . $lastInsertId . "','2','*#NOME#* mensagem de com 3 dias antes do vencimento')");
	$connect->query("INSERT INTO mensagens(idu, tipo, msg) VALUES ('" . $lastInsertId . "','3','*#NOME#* mensagem no dia do vencimento')");
	$connect->query("INSERT INTO mensagens(idu, tipo, msg) VALUES ('" . $lastInsertId . "','4','*#NOME#* mensagem de mensalidade vencida')");
	$connect->query("INSERT INTO mensagens(idu, tipo, msg) VALUES ('" . $lastInsertId . "','5','*#NOME#* mensagem de agradecimento')");
	$connect->query("INSERT INTO mensagens(idu, tipo, msg) VALUES ('" . $lastInsertId . "','6','*#NOME#* mensagem de cobranca manual')");

  // Mensagem de criação de conta
  $msfg = "*NOVA CONTA CRIADA COM SUCESSO*\n\nOlá *" . $nomec . "* sua conta foi criada com sucesso.\n\nSegue abaixo os dados de login:\n\n*URL*: " . $_urlmaster . "\n\n*Usuário*: " . $login_cpf . "\n\n*Senha*: " . $senhaAleatoria . "\n\n*Esta é uma mensagem automática e não precisa ser respondida.*";
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $urlapi . "/message/sendText/AbC123" . $tokenapi,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(
      array(
        "number" => "55" . $login_cel,
        "options" => array("delay" => 1200, "presence" => "composing", "linkPreview" => false),
        "textMessage" => array("text" => $msfg)
      )
    ),
    CURLOPT_HTTPHEADER => array('Content-Type: application/json', 'apikey: ' . $apikey)
  )
  );
  $response = curl_exec($curl);
  $error = curl_error($curl);
  curl_close($curl);

  if ($error) {
    echo $error;
  }

  header("location: ./?sucesso=login");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">

  <meta name="description"
    content="<?php print $_nomesistema; ?> é o melhor sistema para cobranças e notificações via WhatsAPP">

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

  <title>Whatsapp Cobranças: Integre sua empresa |
    <?php print $_nomesistema; ?>
  </title>

  <link rel="icon" href="<?php print $_urlmaster; ?>/img/favicon.png" sizes="32x32" type="image/png">

  <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">

  <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">

  <link rel="stylesheet" href="../css/slim.css">

  <script src="https://www.google.com/recaptcha/api.js"></script>
</head>

<body style="background-color:#333333">
  <div class="signin-wrapper">
    <div class="signin-box">
      <h3>Criar Conta</h3>

      <hr />

      <form action="" method="post">
        <div class="form-group">
          <input type="text" class="form-control" name="nomec" placeholder="Nome Completo" required>
        </div>

        <div class="form-group">
          <input type="text" class="form-control" id="cpfcnpj" name="cpfnj" placeholder="CPF ou CNPJ"
            onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>

          <code>Apenas Números</code>
        </div>

        <div class="form-group">
          <input type="text" class="form-control" name="celular" id="celular" placeholder="Nº celular com WhatsAPP"
            onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>

          <code>Informe um número válido para ativar sua conta.</code>
        </div>

        <div class="form-group mg-b-1">
          <div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="<?php print $_captcha; ?>"></div>

          <br>
        </div>

        <?php if (isset($_GET["sucesso"])) { ?>
          <div class="form-group" style="color:#00CC00">
            <i class="fa fa-certificate"></i> Cadastrado com sucesso.
          </div>

          <meta http-equiv="refresh" content="1;URL=../" />
        <?php } ?>

        <?php if (isset($_GET["erroC"])) { ?>
          <div class="form-group" style="color:#FF0000">
            <i class="fa fa-certificate"></i> Nº celular já cadastrado. Tente outro.
          </div>
        <?php } ?>

        <?php if (isset($_GET["erroL"])) { ?>
          <div class="form-group" style="color:#FF0000">
            <i class="fa fa-certificate"></i> CPF ou CNPJ já cadastrado. Tente outro.
          </div>
        <?php } ?>

        <button type="submit" id="submit" name="submit" class="btn btn-dark btn-block"
          disabled="disabled">Entrar</button>
      </form>

      <a href="../" class="btn btn-warning btn-block mg-t-10">Voltar</a>
    </div>
  </div>

  <script src="../lib/jquery/js/jquery.js"></script>

  <script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>

  <script>function upperCaseF(a) { setTimeout(function () { a.value = a.value.toUpperCase(); }, 1); }</script>

  <script>
    $("input[id*='cpfcnpj']").inputmask({
      mask: ['999.999.999-99', '99.999.999/9999-99'],
      keepStatic: true
    });
  </script>

  <script>
    $("input[id*='celular']").inputmask({
      mask: ['(99)999999999'],
      keepStatic: true
    });
  </script>

  <script>function recaptchaCallback() { jQuery("#submit").prop("disabled", !1) }</script>
</body>

</html>