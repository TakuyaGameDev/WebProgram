<?php
session_start();
$post = $_SESSION['form'];

if(!empty($_POST['back']))
{
    if($_POST['back']){
        header("Location:contact.php");
    }
}
if(!empty($_POST['send']))
{
    if($_POST['send']){
        header("Location:complete.php");
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>Sample Site</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="process.js"></script>

<link rel="stylesheet" type="text/css" href="style.css">
</head>
    <body>
        <form method="post">
            <div id = "confirmHeader">
                <h1>送信内容はこれでよろしいですか？</h1>
                <div id = "box">
                    <span id = "first">氏名 : </span><p><?php echo htmlspecialchars($post['name']); ?></p>
                </div>
                <div id = "box">
                    <span id = "first">フリガナ : </span><p><?php echo htmlspecialchars($post['furi']) ?></p>
                </div>
                <div id = "box">
                    <span id = "first">電話番号 : </span><p><?php echo htmlspecialchars($post['telNum'])?></p>
                </div>
                <div id = "box">
                    <span id = "first">メールアドレス : </span><p><?php echo htmlspecialchars($post['mailAddress'])?></p>
                </div>
                <div id = "box">
                    <span id = "first">お問い合わせ内容 : </span><p><?php echo nl2br(htmlspecialchars($post['opinion']))?></p>
                </div>
                <div id = "btns">
                    <input id = "submitBtn" type="submit" name = "send" value="送　信" style="color:#ffffff">
                    <input id = "backBtn" type="submit" name = "back" value="戻る">
                </div>
            </div>
        </form>
    </body>
</html>