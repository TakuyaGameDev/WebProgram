<?php require_once 'DBManager.php'?>

<?php
    // データベース接続
    // パスワードなどのエラーはここで失敗になるとエラーとして表示してくれる
    $db = getDB();

    // (3) SQL作成
    $stmt = $db->prepare("SELECT * FROM players");
    $stmt->execute();
    // foreach文で配列の中身を一行ずつ出力
    foreach ($stmt as $row) {
        // データベースのフィールド名で出力
        echo "uniform:".$row['uniform_num'];
        
        // 改行を入れる
        echo '<br>';
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>database_lesson</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
    <body>

    </body>
</html>