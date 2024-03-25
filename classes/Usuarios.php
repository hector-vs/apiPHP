<?php

class Usuarios 
{
  public static function login($login, $senha)
  {
    $login = addslashes(htmlspecialchars($login)) ?? '';
    $senha = addslashes(htmlspecialchars($senha)) ?? '';
    $secretJWT = $GLOBALS['secretJWT'];

    $db = DB::connect();
    $rs = $db->prepare("SELECT * FROM usuarios WHERE login = '{$login}'");
    $exec = $rs->execute();
    $obj = $rs->fetchObject();
    $rows = $rs->rowCount();

    if ($rows > 0) {
      $idDB          = $obj->id;
      $nameDB        = $obj->nome;
      $passDB        = $obj->senha;
      $validUsername = true;
      $validPassword = password_verify($senha, $passDB) ? true : false;
    } else {
      $validUsername = false;
      $validPassword = false;
    }

    if ($validUsername and $validPassword) {
      $expire_in = time() + 60000;
      $token     = JWT::encode([
        'id' => $idDB,
        'name' => $nameDB,
        'expires_in' => $expire_in
      ], $GLOBALS['secretJWT']);

      $db->query("UPDATE usuarios SET token = '$token' WHERE id = $idDB");
      echo json_encode(['token' => $token, 'data' => JWT::decode($token, $secretJWT)]);
    } else {
      if (!$validPassword) {
        echo json_encode(['ERROR', 'invalid password']);
      }
    }
  }

  public static function verificar()
  {
    $headers = apache_request_headers();
    if (isset($headers['Authorization'])) {
      $token = str_replace("Bearer ", "", $headers['Authorization']);
    } else {
      echo json_encode(['ERRO' => 'Você não está logado, ou seu token é inválido.']);
      exit;
    }

    $db = DB::connect();
    $rs = $db->prepare("SELECT * FROM usuarios WHERE token = '{$token}'");
    $exec = $rs->execute();
    $obj = $rs->fetchObject();
    $rows = $rs->rowCount();
    $secretJWT = $GLOBALS['secretJWT'];

    if ($rows > 0) {
      $idDB = $obj->id;
      $tokenDB = $obj->token;
        $decodedJWT = JWT::decode($tokenDB, $secretJWT);
        if ($decodedJWT->expires_in > time()) {
          return true;
        } else {
          $db->query("UPDATE usuarios SET token = '' WHERE id = $idDB");
          return false;
        }
    } else {
      return false;
    }
  }
}