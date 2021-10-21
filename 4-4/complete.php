
<?php
    require_once 'DBManager.php';

    session_start();
    //直リンク禁止
    if (empty($_SERVER["HTTP_REFERER"]))
    {
        //リダイレクト
        header('Location: contact.php');
    }

    // 入力情報の保存
    $post = $_SESSION['form'];
    try 
    {
        $name = $post['name'];
        $kana = $post['furigana'];
        $tel = $post['telNum'];
        $email = $post['mailAddress'];
        $body = $post['opinion'];
        //DBへの接続を確立
        $db = getDB();
      
        //insert命令を準備
        $sql = "INSERT INTO contacts (name, kana,tel,email,body) VALUES (:name, :kana,:tel,:email,:body)";
        $stmt = $db->prepare($sql);
        $params = array(':name' => $name, ':kana' => $kana, ':tel' => $tel, ':email' => $email, ':body' => $body);
        $stmt->execute($params);
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

<?php include 'header.php'?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>Complete</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
    <body>
        
        <div id = "compBox">
            <div id = "strBox">
                <h1>お問い合わせ</h1>
            </div>
            <div id = "detail">
                <p>お問い合わせ頂きありがとうございます。<br>送信頂いた件につきましては、当社より折り返しご連絡を差し上げます。<br>なお、ご連絡までに、お時間を頂く場合もございますので予めご了承ください。</p>
            </div>
            <a href="home.php" id="page-top">トップへ戻る</a>
        </div>
    </body>
</html>

<?php include 'footer.php';?>