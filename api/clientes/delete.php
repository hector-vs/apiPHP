<?php

if ($acao == ""){ echo json_encode(['ERRO' => 'Caminho não encontrado!']); exit; }

if ($acao == "deleta" && $param == '') { echo json_encode(['ERRO' => 'Cliente não informado.']); exit; }

if ($acao == "deleta" && $param != '') {
  // DELETE from clientes WHERE id={$param}

  $db = Db::connect();
  $rs = $db->prepare("DELETE FROM clientes WHERE id={$param}");
  $exec = $rs->execute();

  if ($exec) {
    echo json_encode(["dados" => "Dados foram excluídos com sucesso!"]);
  } else {
    echo json_encode(["dados" => "Houve algum erro ao excluir os dados."]);
  }
}