<?php
    // エラーメッセージ・完了メッセージの用意
    $err_msg = array("","","","","");
    if ($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        // POSTでのアクセスでない場合
        $name = '';
        $furi = '';
        $telNum = '';
        $add = '';
        $opinion = '';
    }
    else
    {

        // フォームがサブミットされた場合（POST処理）
        // 入力された値を取得する
        $name1 = $_POST['name'];
        $furi1 = $_POST['furigana'];
        $telNum1 = $_POST['telNum'];
        $add1 = $_POST['mailAddress'];
        $opinion1 = $_POST['opinion'];

        // チェック
        if(($name1 === "") || (mb_strlen($name1) >= 10))
        {
            $err_msg[0] = "氏名は必須入力です。10文字以内でご入力ください。";
        }
        if(($furi1 === "") || (mb_strlen($furi1) >= 10))
        {
            $err_msg[1] = "フリガナは必須入力です。10文字以内でご入力ください。";
        }
        if(!preg_match('/^[0-9]+$/', $telNum1))
        {
            $err_msg[2] = "電話番号は0-9の数字のみでご入力ください。";
        }
        if((empty($add1)) or (!filter_var($add1, FILTER_VALIDATE_EMAIL)))
        {
            $err_msg[3] = "メールアドレスは正しくご入力ください。";
        }

        $sendFlg = true;
        foreach($err_msg as $str)
        {
            if($str !== "")
            {
                $sendFlg = false;
            }
        }

        if($sendFlg)
        {
            header('Location:confirm.php?name='.$name1.'&furi='.$furi1.'&telNum='.$telNum1.'&email='.$add1.'&opinion='.$opinion1);
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>Contact</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="process.js"></script>

<link rel="stylesheet" type="text/css" href="style.css">
</head>
    <body>
    <form method="post">
        <div id = "contactBox">
            <div id = "contactHeader">
                <h1>お問い合わせ</h1>
            </div>
            <div id = "contactBody">
                <div id = "strBox">
                    <p>下記の項目をご記入の上送信ボタンを押して下さい</p>
                </div>
                <div id = "sub">
                    <p>送信頂いた件につきましては、当社より折り返しご連絡を差し上げます。<br>なお、ご連絡までに、お時間を頂く場合もございますのであらかじめご了承ください。</p>
                    <p id = "essential"><span>*</span>は必須項目となります。</p>
                </div>
                <div id = "inputForm">
                    <div id = "contactName">
                        <p>氏名<span>*</span></p>
                        <?php if($err_msg[0] !== "")
                        {
                            echo "<p>".$err_msg[0]."</p>";
                        };
                        ?>
                        <input type="text" id = "inputBox" name = "name" placeholder="山田太郎"></input>
                    </div>
                    <div id = "contactFurigana">
                        <p>フリガナ<span>*</span></p>
                        <?php if($err_msg[1] !== "")
                        {
                            echo "<p>".$err_msg[1]."</p>";
                        };
                        ?>
                        <input type="text" id = "inputBox" name = "furigana" placeholder="ヤマダタロウ"></input>
                    </div>
                    <div id = "contactTel">
                        <p>電話番号</p>
                        <?php if($err_msg[2] !== "")
                        {
                            echo "<p>".$err_msg[2]."</p>";
                        };
                        ?>
                        <input type="text" id = "inputBox" name = "telNum" placeholder="09012345678"></input>
                    </div>
                    <div id = "contactMailAddress">
                        <p>メールアドレス<span>*</span></p>
                        <input type="text" id = "inputBox" name = "mailAddress" placeholder="test@test.co.jp"></input>
                    </div>
                </div>
                <div id = "inputOpinionForm">
                    <div id = "strBox">
                        <p>お問い合わせ内容をご記入ください<span>*</span></p>
                    </div>
                    <textarea id = "opinionBox" name = "opinion"></textarea>
                </div>
                <div id = "submitBtn">
                    <input type = "submit" name = "submitBtn" value="送　信" style="color:#ffffff"></input>
                </div>
            </div>
        </div>
        </form>
    </body>
</html>

<?php include 'footer.php'; ?>