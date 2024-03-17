<?php

class Db {
  public static function connect()
  {
    $host = 'localhost';  
    $user = 'root';  
    $pass = '';  
    $base = 'phpapi';

    return new PDO("mysql:host={$host};dbname={$base};charset=UTF8;", $user, $pass);
  }
}