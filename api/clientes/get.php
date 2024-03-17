<?php

if ($acao == ""){ echo json_encode(['ERRO' => 'Caminho não encontrado!']); }

if ($acao == 'lista' && $param == ''){
  $db = Db::connect();
  $rs = $db->prepare("SELECT * FROM clientes ORDER BY nome");
  $rs->execute();
  $obj = $rs->fetchAll(PDO::FETCH_ASSOC);

  if ($obj) {
    echo json_encode(["dados" => $obj]);
  } else {
    echo json_encode(["dados" => "Não existem dados a serem retornados"]);
  }
}

if ($acao == 'lista' && $param != ''){
  $db = Db::connect();
  $rs = $db->prepare("SELECT * FROM clientes WHERE id={$param}");
  $rs->execute();
  $obj = $rs->fetchObject();

  if ($obj) {
    echo json_encode(["dados" => $obj]);
  } else {
    echo json_encode(["dados" => "Não existem dados a serem retornados"]);
  }
}