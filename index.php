<?php
//Permite que sites externos acessem a API
header('Access-Control-Allow-Origin: *'); //* -> Todos || Sites específicos: site1.com, site2.com...
//Fuso horário
date_default_timezone_set("America/Sao_Paulo");

if(isset($_GET['path'])){
  $path = explode("/", $_GET['path']);
}

if ($path[0] != '') { $api = $path[0]; } else { echo "Caminho não existe"; exit; }

$acao = '';
$param = '';

if (isset($path[1])){
  if ($path[1] != '') { $acao = $path[1]; } else { $acao = ''; }
}

if (isset($path[2])){
  if ($path[2] != '') { $param = $path[2]; } else { $param = ''; }
}

$method = $_SERVER['REQUEST_METHOD'];

//var_dump ($path);
//var_dump ($acao);
// var_dump ($method);

include_once "classes/Db.php";
include_once "api/clientes/clientes.php";