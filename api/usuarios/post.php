<?php

if ($acao == ""){ echo json_encode(['ERRO' => 'Caminho não encontrado!']); exit; }

if ($acao == 'login' && $param == ''){
  Usuarios::login($_POST['login'], $_POST['senha']);
  exit;
}