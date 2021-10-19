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
    <div id = "head">
        <div id = "logo">
            <a href="home.php"><img src = "cafe/img/logo.png"width="247px" height="46.8px"></a>
        </div>
        <nav>
            <div id = "button1">
                <a href="#favLocation">はじめに</a>
            </div>
            <div id = "button2">
                <a href="#Experience">体験</a>
            </div>
            <div id = "button3">
                <a href="contact.php">お問い合わせ</a>
            </div>
        </nav>
        <div id = "signin">
            <a href="">サインイン</a>
        </div>
    </div>
    <div id="overlay"></div>
    <div id = "modal">
        <div id = "strBox">
            <strong>ログイン</strong>
        </div>
        <div id = "inputBox">
            <div id = "emailInput"> 
                <input type = 'text' name="email" placeholder="メールアドレス">
            </div>
            <div id = "passInput">
                <input type = 'text' name="password" placeholder="パスワード">
            </div>
            <div id = "sendBtn">
                <input type = 'submit'name = "loginBtn" value="送　信" style="color:#ffffff">
            </div>
        </div>
        <div id = "snsBtn">
            <a id = "accessBtn" href = "home.php">
                <div id = "btn">
                    <img src = "cafe/img/twitter.png" width="35px" height="35px">
                </div>
            </a>
            <a id = "accessBtn" href = "home.php">
                <div id = "btn">
                    <img src = "cafe/img/fb.png" width="35px" height="35px">
                </div>
            </a>
            <a id = "accessBtn" href = "home.php">
                <div id = "btn">
                    <img src = "cafe/img/google.png" width="35px" height="35px">
                </div>
            </a>
            <a id = "accessBtn" href = "home.php">
                <div id = "btn">
                    <img src = "cafe/img/apple.png" width="35px" height="35px">
                </div>
            </a>
        </div>
    </div>
 
    <div id = "jumpTopBtn">
        <a href="#">Jump To Top</a>
    </div>
</body>
</html>