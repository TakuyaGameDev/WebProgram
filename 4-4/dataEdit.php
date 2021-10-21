<?php include 'header.php';?>
<?php require_once 'DBManager.php';?>
<?php
    session_start();
    try {
        $dbh = getDB();
        $dbh->beginTransaction();
        $stmt = $dbh->prepare("SELECT * FROM contacts WHERE id = :id");
        $stmt->bindValue(":id", (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            exit("no data found with the id sorry");
        };
        $dbh->commit();
    } catch (PDOException $e) {
        $dbh->rollBack();
        exit($e);
    };

    $id = $_GET['id'];
    $id = $result["id"];
    $name = $result["name"];
    $kana = $result["kana"];
    $tel = $result["tel"];
    $email = $result["email"];
    $body = $result["body"];
    echo $id;

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>Contact</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
    <body>
        <p id = "text"></p>
    </body>
</html>
