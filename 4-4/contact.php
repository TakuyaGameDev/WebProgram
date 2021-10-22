<?php include 'header.php';?>

<?php
require_once 'DBManager.php';
session_start();
    $id = 0;
    try 
    {
        //DBへの接続を確立
        $db = getDB();
        try 
        {
            $db->beginTransaction();
            $sql = "SELECT * FROM contacts";
            $stmt = $db->query($sql);
            // SQLステートメントを実行し、結果を変数に格納
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $sql = "show full columns from contacts";
            $column_data = $db->query($sql);
            $db->commit();
            $db = null;
        } 
        catch(PDOException $e)
        {
            echo "faillure:". $e->$getMessage();
            $db->rollBack();
        ;}
        // データベース空抽出してきたデータ達
        $dataArr = [];
        // テーブルのヘッダーに出力するデータベースに登録した各コメント達
        $thNames = [];

        $cnt = 0;
        // foreach文で配列の中身を一行ずつ出力
        foreach ($result as $row) {
            $dataArr[$cnt]['id'] = $row['id'];
            $dataArr[$cnt]['name'] = $row['name'];
            $dataArr[$cnt]['kana'] = $row['kana'];
            $dataArr[$cnt]['tel'] = $row['tel'];
            $dataArr[$cnt]['email'] = $row['email'];
            $dataArr[$cnt]['body'] = $row['body'];
            $dataArr[$cnt]['time'] = $row['created_at'];
            $cnt++;
        }

        // データベースに格納したテーブルの各データ達のコメント抽出
        $cnt = 0;
        foreach($column_data as $value)
        {        
            if($cnt < 6)
            {
                // 各コメントの格納
                $thNames[] = $value[8];
            }
            $cnt++;
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

    // エラーメッセージ・完了メッセージの用意
    $err_msg = array("","","","","");
    if ($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        // POSTでのアクセスでない場合
        if(!empty($_SESSION['form']))
        {
            $post = $_SESSION['form'];
            $name1 = $post['name'];
            $furi1 = $post['furigana'];
            $telNum1 = $post['telNum'];
            $add1 = $post['mailAddress'];
            $opinion1 = $post['opinion'];
        }
        else
        {
            $name1 = '';
            $furi1 = '';
            $telNum1 = '';
            $add1 = '';
            $opinion1 = '';
        }
    }
    else
    {
        // フォームがサブミットされた場合（POST処理）
        // 入力された値を取得する

        $post = filter_input_array(INPUT_POST,$_POST);

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
        if(!empty($telNum1))
        {
            if(!preg_match('/^[0-9]+$/', $telNum1))
            {
                $err_msg[2] = "電話番号は0-9の数字のみでご入力ください。";
            }
        }
        
        if((empty($add1)) || (!filter_var($add1, FILTER_VALIDATE_EMAIL)))
        {
            $err_msg[3] = "メールアドレスは正しくご入力ください。";
        }
        if(strlen($opinion1) <= 0)
        {
            $err_msg[4] = "お問い合わせ内容をご記入ください。";
        }
        // 消去okボタンを押した時
        if (isset($_POST['ok'])) 
        {
            $id = $_GET['id'];
            echo $id;
            // header("Location:delete.php");
        }
        $firstCompFlg = true;
        for($s = 0;$s < count($err_msg);$s++)
        {
            if(empty($telNum1))
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
<link rel="stylesheet" type="text/css" href="style.css">
</head>
    <body>
    <form id = "form" action="" method="POST">
        
        <div id = "contactBox">
            <div id = "contactHeader">
                <h2>お問い合わせ</h2>
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
                    <input id = submitBtn type = "submit" name = "submitBtn" value="送　信" style="color:#ffffff"></input>
            </div>
        </div>
            <div id = "databaseTbl">
                <table border="1" align="center" width="80%" height="100%">
                    　<tr>
                        <?php foreach($thNames as $c)
                        {
                            echo '<th>'.$c.'</th>';
                        }
                        echo '<th>送信日時</th>';
                        $cnt = 0;
                        ?>
                    　</tr>
                        <?php foreach($dataArr as $val):?>
                            <tr class = "tblRow">
                                <td><?php echo $val['id']?></td>
                                <td><?php echo $val['name']?></td>
                                <td><?php echo $val['kana']?></td>
                                <td><?php echo $val['tel']?></td>
                                <td><?php echo $val['email']?></td>
                                <td><?php echo $val['body']?></td>
                                <td><?php echo $val['time']?></td>
                                <?php $id = $val['id'];?>
                                <td><a href="dataEdit.php?id=<?php echo $val['id'];?>">編集</a></td>
                                <td><a class = "deleteBtn" href="">削除</a></td>
                            </tr>
                        <?php endforeach;?>
                </table>
            </div>

        </form>
    </body>
</html>

<script>
const deleteAll = document.querySelectorAll(".deleteBtn");

const deleteConfirmation = function (e) {
    e.preventDefault();
    const id = e.target.closest(".tblRow").firstElementChild.innerHTML;
    if (confirm("id:"+id+"Delete OK?")) {
        //削除処理
        window.location.href = `delete.php?id=${id}`;
    } else {
        return;
    };
};

for (const deleteBtn of deleteAll) {
    deleteBtn.addEventListener("click", deleteConfirmation)
};

</script>

<?php include 'footer.php'; ?>