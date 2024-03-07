<?php
$servidor = 'localhost';
$usuario  = 'u518180969_financeiro';
$senha 	  = '>Zs5tFI+';
$banco    = 'u518180969_financeiro';

$connect = new PDO("mysql:host=$servidor;dbname=$banco", $usuario , $senha);  
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$_urlmaster = "https://".@$_SERVER['HTTP_HOST'];
$_urlapi = "https://api.gestorproplw.com";
$_ativacom = "1";


// ALTERAR AS LINHAS 18 E 22 SOMENTE

// Para criar sua chave acesse:
//https://www.google.com/recaptcha/admin/create

$_captcha = "6Lcz0CApAAAAAOkvJdgJOz7FGOxGlxB0bAnuNpy8";

// Dados do Painel

$_nomesistema = "Painel PLW";

// ALTERAR AS LINHAS 16 E 19 SOMENTE