<?php 

session_start(); 

if (!$_SERVER['HTTP_REFERER'] == "http://localhost:8888/04_php_form/edit.php") {
    header('Location: http://localhost:8888/04_php_form/contact.php');
  };

$_SESSION["postData"] = $_POST;

$name = htmlspecialchars($_SESSION["postData"]["name"], ENT_QUOTES, 'UTF-8');
$kana = htmlspecialchars($_SESSION["postData"]["kana"], ENT_QUOTES, 'UTF-8');
$tel = htmlspecialchars($_SESSION["postData"]["tel"], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_SESSION["postData"]["email"], ENT_QUOTES, 'UTF-8');
$body = htmlspecialchars($_SESSION["postData"]["body"], ENT_QUOTES, 'UTF-8');

?>

<?php

function con_ini() {

    try { 
    $dbh = new PDO('mysql:dbname=cafe;host=localhost;charset=utf8','root','root', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    } catch(PDOException $e){
        echo 'DB接続エラー' . $e->getMessage();
        exit();
    };
    return $dbh;
};

$dbh = con_ini();

$id = $_POST["id"];

if (empty($id)) {
    echo "id is not set properly";
};

$sql = "UPDATE contacts SET 
            name = :name, kana = :kana, tel = :tel, email = :email, body = :body
        WHERE 
            id = :id";
$dbh->beginTransaction();

try {
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(":name", $name);
    $stmt->bindValue(":kana", $kana);
    $stmt->bindValue(":tel", $tel);
    $stmt->bindValue(":email", $email);
    $stmt->bindValue(":body", $body);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $dbh->commit();
} catch(PDOException $e) {
    $dbh->rollBack();
    exit($e);
};
?>

<head>
<meta charset="UTF-8">
<title>Inquiry</title>
<link rel="stylesheet" type="text/css" href="cafe.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<section>
        <div class="contact_box">
            <h2>お問い合わせ</h2>
            <div class="complete_msg">
                <p>お問い合わせをご編集頂きありがとうございます。</p>
                <p>送信頂いた件につきましては、当社より折り返しご連絡を差し上げます。</p>
                <p>なお、ご連絡までに、お時間を頂く場合もございますので予めご了承ください。</p>
                <a href="cafe.php">トップへ戻る</a>
            </div>
        </div>
</section>
