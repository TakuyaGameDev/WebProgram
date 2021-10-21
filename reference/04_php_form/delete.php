<?php

echo "削除した";

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

$dbh = con_ini();

$id = $_GET["id"];

if (empty($id)) {
    echo "id not set";
};

$sql = "DELETE FROM contacts WHERE id = :id";

try {
    $dbh->beginTransaction();
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(":id", (int)$id, PDO::PARAM_INT);
    $stmt->execute();
    $dbh->commit();
} catch(PDOException $e) {
    $dbh->rollBack();
    exit($e);
    echo "fail";
};


?>

<a href="contact.php" class="confirm_back">戻　る </a>
