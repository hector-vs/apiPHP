<?php

if ($acao == ""){ echo json_encode(['ERRO' => 'Caminho não encontrado!']); exit; }

if ($acao == "atualiza" && $param == '') { echo json_encode(['ERRO' => 'Cliente não informado.']); exit; }

if ($acao == 'atualiza' && $param != "") {
  //Elimina o primeiro indice do array
  array_shift($_POST);

  $sql = "UPDATE clientes SET ";

  $cont = 1;
  foreach (array_keys($_POST) as $indice) {
    if (count($_POST) > $cont) {
      $sql.= "{$indice} = '{$_POST[$indice]}', ";
    } else {
      $sql.= "{$indice} = '{$_POST[$indice]}' ";
    }
    $cont++;
  }

  $sql .= "WHERE id ={$param}";

  $db = Db::connect();
  $rs = $db->prepare($sql);
  $exec = $rs->execute();

  if ($exec) {
    echo json_encode(["dados" => "Dados atualizados com sucesso!"]);
  } else {
    echo json_encode(["dados" => "Houve algum erro ao atualizar os dados."]);
  }

}

