<?php 

function con_ini() {

    try { 
    $dbh = new PDO('mysql:dbname=cafe;host=localhost;charset=utf8','root','root', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    } catch(PDOException $e){
        echo 'DB接続エラー' . $e->getMessage();
        exit();
    };
    return $dbh;
};

?>