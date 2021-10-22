<?php include 'header.php';?>
<?php require_once 'DBManager.php';?>
<?php
    session_start();
    // id番号の取得(contact.phpから?でつないで変数を渡しているのできちんと反映されている)
    $id = $_GET['id'];
    echo $id;
    try
    {
        //DBへの接続を確立
        $db = getDB();
        try 
        {
            $db->beginTransaction();
            $sql = "SELECT * FROM contacts WHERE id=$id";
            $stmt = $db->query($sql);
            // SQLステートメントを実行し、結果を変数に格納
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $db->commit();
            $db = null;
        } 
        catch(PDOException $e)
        {
            echo "faillure:". $e->$getMessage();
            $db->rollBack();
        };

        // 編集対象のデータ
        $editData = [];
        // 編集対象データの格納
        foreach($result as $data)
        {
            $editData['id'] = htmlspecialchars($data['id']);
            $editData['name'] = htmlspecialchars($data['name']);
            $editData['kana'] = htmlspecialchars($data['kana']);
            $editData['tel'] = htmlspecialchars($data['tel']);
            $editData['email'] = htmlspecialchars($data['email']);
            $editData['body'] = htmlspecialchars($data['body']);
            $editData['time'] = htmlspecialchars($data['created_at']);
        }
        // エラーメッセージ・完了メッセージの用意
        $err_msg = array("","","","","");
        if ($_SERVER['REQUEST_METHOD'] != 'POST')
        {

        }
        else
        {
            // フォームがサブミットされた場合（POST処理）
            // 入力された値を取得する
            //if(isset($_POST['exeBtn']))
            {
                $post = filter_input_array(INPUT_POST,$_POST);
                $name_mod = $post['name'];
                $kana_mod = $post['kana'];
                $tel_mod = $post['tel'];
                $email_mod = $post['email'];
                $body_mod = $post['body'];


                // チェック
                if(($name_mod === "") || (mb_strlen($kana_mod) >= 10))
                {
                    $err_msg[0] = "氏名は必須入力です。10文字以内でご入力ください。";
                }
                if(($kana_mod === "") || (mb_strlen($kana_mod) >= 10))
                {
                    $err_msg[1] = "フリガナは必須入力です。10文字以内でご入力ください。";
                }
                if(!empty($tel_mod))
                {
                    if(!preg_match('/^[0-9]+$/', $tel_mod))
                    {
                        $err_msg[2] = "電話番号は0-9の数字のみでご入力ください。";
                    }
                }
                
                if((empty($email_mod)) || (!filter_var($email_mod, FILTER_VALIDATE_EMAIL)))
                {
                    $err_msg[3] = "メールアドレスは正しくご入力ください。";
                }
                if(strlen($body_mod) <= 0)
                {
                    $err_msg[4] = "お問い合わせ内容をご記入ください。";
                }
                $firstCompFlg = true;
                for($s = 0;$s < count($err_msg);$s++)
                {
                    if(empty($editData['tel']))
                    {
                        if($s !== 2)
                        {
                            if($err_msg[$s] !== "")
                            {
                                $firstCompFlg = false;
                            }
                        }
                    }
                    else
                    {
                        if($err_msg[$s] !== "")
                        {
                            $firstCompFlg = false;
                        }
                    }
                }
            }
            if($firstCompFlg)
            {
                //DBへの接続を確立
                $db = getDB();
                
                // id番号の取得(contact.phpから?でつないで変数を渡しているのできちんと反映されている)
                try {
                    // UPDATE文を変数に格納
                    $sql = "UPDATE contacts SET name = :name, kana = :kana, tel = :tel, email = :email, body = :body WHERE id = $id";
                    $stmt = $db->prepare($sql);
                    $stmt->bindValue(":name", $name_mod);
                    $stmt->bindValue(":kana", $kana_mod);
                    $stmt->bindValue(":tel", $tel_mod);
                    $stmt->bindValue(":email", $email_mod);
                    $stmt->bindValue(":body", $body_mod);

                    $stmt->execute();
                } catch(PDOException $e) {
                    echo $e->getMessage();
                    exit($e);
                };
                header("Location:contact.php");
            }
        }
    }
    catch (PDOException $e) 
    {
        print "エラーメッセージ：{$e->getMessage()}";
    } 
    finally
    {
        $db = null;
    }

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
        <form action="" method='POST'>
        <!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>Contact</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
    <body>
        <form id = "form" action="" method="POST">
            <div id = "contactBox">
                <div id = "contactHeader">
                    <h2>データの編集</h2>
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
                            <input type="text" id = "inputBox" name = "name"
                            value = <?php echo $editData['name'];?>></input>
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
                            <input type="text" id = "inputBox" name = "kana"
                            value = <?php echo $editData['kana'];?>></input>
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
                            <input type="text" id = "inputBox" name = "tel"
                            value = <?php echo $editData['tel'];?>></input>
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
                            <input type="text" id = "inputBox" name = "email"
                            value = <?php echo $editData['email'];?>></input>
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
                        <textarea id = "opinionBox" name = "body"><?php echo $editData['body'];?></textarea>
                    </div>
                        <input id = submitBtn type = "submit" name = "exeBtn" value="実　行" style="color:#ffffff"></input>
                </div>
            </div>
        </form>
    </body>
</html>
