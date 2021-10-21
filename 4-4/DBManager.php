<?php
function getDB() {
    $dsn = 'mysql:dbname=cafe; host=127.0.0.1; charset=utf8';
    $usr = 'root';
    $passwd = 'Dream1022';
  
    //DBへの接続を確立
    $db = new PDO($dsn, $usr, $passwd);
    return $db;
  }
?>