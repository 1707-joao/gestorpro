<?php
require_once "../db/Conexao.php";
require_once "classes/functions.php";
require_once "topo.php";
require_once "menu.php";
$Url[1]=(empty($Url[1])?null:$Url[1]);
$getUrl=strip_tags(trim(filter_input(INPUT_GET,'url',FILTER_DEFAULT)));
$setUrl=(!isset($getUrl)?'index':$getUrl);
$Url=explode('/',$setUrl);if(file_exists($Url[0].'.php')): require_once $Url[0].'.php';
else:
require_once 'home.php';
endif;
?>