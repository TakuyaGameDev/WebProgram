<?php
session_start();

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

        $post = filter_input_array(INPUT_POST,$_POST);
        // フォームがサブミットされた場合（POST処理）
        // 入力された値を取得する
        $name1 = $post['name'];
        $furi1 = $post['furigana'];
        $telNum1 = $post['telNum'];
        $add1 = $post['mailAddress'];
        $opinion1 = $post['opinion'];

        
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
        if((empty($add1)) || (!filter_var($add1, FILTER_VALIDATE_EMAIL)))
        {
            $err_msg[3] = "メールアドレスは正しくご入力ください。";
        }
        if(strlen($opinion1) <= 0)
        {
            $err_msg[4] = "お問い合わせ内容をご記入ください。";
        }

        $firstCompFlg = true;
        foreach($err_msg as $str)
        {
            if($str !== "")
            {
                $firstCompFlg = false;
            }
        }
        if($firstCompFlg)
        {
            $_SESSION['form'] = $post;
            header("Location:confirm.php");
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
    <form id = "form" action="" method="POST">
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
                        <p id = "error">
                        <?php if($err_msg[0] !== "")
                        {
                            echo $err_msg[0];
                        };
                        ?>
                        </p>
                        <input type="text" id = "inputBox" name = "name" placeholder="山田太郎"
                        value = <?php if(!empty($name1)){echo htmlspecialchars($name1);};?>></input>
                    </div>
                    <div id = "contactFurigana">
                        <p>フリガナ<span>*</span></p>
                        <p id = "error">
                        <?php if($err_msg[1] !== "")
                        {
                            echo $err_msg[1];
                        };
                        ?>
                        </p>
                        <input type="text" id = "inputBox" name = "furigana" placeholder="ヤマダタロウ"
                        value = <?php if(!empty($furi1)){echo htmlspecialchars($furi1);};?>></input>
                    </div>
                    <div id = "contactTel">
                        <p>電話番号</p>
                        <p id = "error">
                        <?php if($err_msg[2] !== "")
                        {
                            echo $err_msg[2];
                        };
                        ?>
                        </p>
                        <input type="text" id = "inputBox" name = "telNum" placeholder="09012345678"
                        value = <?php if(!empty($telNum1)){echo htmlspecialchars($telNum1);};?>></input>
                    </div>
                    <div id = "contactMailAddress">
                        <p>メールアドレス<span>*</span></p>
                        <p id = "error">
                        <?php if($err_msg[3] !== "")
                        {
                            echo $err_msg[3];
                        };
                        ?>
                        </p>
                        <input type="text" id = "inputBox" name = "mailAddress" placeholder="test@test.co.jp"
                        value = <?php if(!empty($add1)){echo htmlspecialchars($add1);};?>></input>
                    </div>
                </div>
                <div id = "inputOpinionForm">
                    <div id = "strBox">
                        <p>お問い合わせ内容をご記入ください<span>*</span></p>
                    </div>
                    <p id = "error">
                    <?php if($err_msg[4] !== "")
                    {
                        echo $err_msg[4];
                    };
                    ?>
                    </p>
                    <textarea id = "opinionBox" name = "opinion"><?php if(!empty($opinion1)){echo htmlspecialchars($opinion1);}; ?></textarea>
                </div>
                <div id = "submitBtn">
                    <input id = submitBtn type = "submit" name = "submitBtn" value="送　信" style="color:#ffffff"></input>
                </div>
            </div>
        </div>
        </form>
    </body>
</html>

<?php include 'footer.php'; ?>