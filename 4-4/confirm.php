<?php
session_start();
//直リンク禁止
if (empty($_SERVER["HTTP_REFERER"])) 
{
    //リダイレクト
    header('Location: contact.php');
}

$post = $_SESSION['form'];

if(!empty($_POST['back']))
{
    if($_POST['back']){
        $_SESSION['form'] = $post;
        header("Location:contact.php");
    }
}
if(!empty($_POST['send']))
{
    if($_POST['send']){
        $_SESSION['form'] = $post;
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
        <?php include 'header.php'?>
            <div id = "confirmHeader">
                <div id = "strBox">
                    <h2>お問い合わせ</h2>
                </div>
                <div id = "confirm">
                    <p>下記の内容をご確認の上送信ボタンを押してください<br>内容を訂正する場合は戻るを押してください。</p>
                </div>
                <div id = "box">
                    <span id = "first">氏名</span>
                </div>
                <div id = "itemStrBox">
                    <p id = "itemStr"><?php echo htmlspecialchars($post['name']); ?></p>
                </div>
                <div id = "box">
                    <span id = "first">フリガナ</span>
                </div>
                <div id = "itemStrBox">
                    <p id = "itemStr"><?php echo htmlspecialchars($post['furigana']) ?></p>
                </div>
                <div id = "box">
                    <span id = "first">電話番号</span>
                </div>
                <div id = "itemStrBox">
                    <p id = "itemStr"><?php echo htmlspecialchars($post['telNum'])?></p>
                </div>
                <div id = "box">
                    <span id = "first">メールアドレス</span>
                </div>
                <div id = "itemStrBox">
                    <p id = "itemStr"><?php echo htmlspecialchars($post['mailAddress'])?></p>
                </div>
                <div id = "box">
                    <span id = "first">お問い合わせ内容</span>
                </div>
                <div id = "itemStrBox">
                    <p id = "itemStr"><?php echo nl2br(htmlspecialchars($post['opinion']))?></p>
                </div>
                <div id = "btn">
                    <div id = "btn1">
                        <input id = "submitBtn" type="submit" name = "send" value="送　信" style="color:#ffffff">
                    </div>
                    <div id = "btn2">
                        <input id = "backBtn" type="submit" name = "back" value="戻　る">
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>

<?php include 'footer.php'?>