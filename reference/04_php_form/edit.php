<?php

session_start();

//入力保持用変数のエラー防止
$name="";
$kana="";
$tel="";
$email="";
$body="";

//DB
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

$id = $_GET["id"];

if (empty($id)) {
    exit("no id found lol");
};

try {
    $dbh = con_ini();
    $dbh->beginTransaction();
    $stmt = $dbh->prepare("SELECT * FROM contacts WHERE id = :id");
    $stmt->bindValue(":id", (int)$id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        exit("no data found with the id sorry");
    };
    $dbh->commit();
} catch (PDOException $e) {
    $dbh->rollBack();
    exit($e);
};

$id = $result["id"];
$name = $result["name"];
$kana = $result["kana"];
$tel = $result["tel"];
$email = $result["email"];
$body = $result["body"];

//エラー用入力保持

if (isset($_SESSION["flg_edit"])) {
    $_SESSION["postData"] = $_POST;
    $name = htmlspecialchars($_SESSION["postData"]["name"], ENT_QUOTES, 'UTF-8');
    $kana = htmlspecialchars($_SESSION["postData"]["kana"], ENT_QUOTES, 'UTF-8');
    $tel = htmlspecialchars($_SESSION["postData"]["tel"], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_SESSION["postData"]["email"], ENT_QUOTES, 'UTF-8');
    $body = htmlspecialchars($_SESSION["postData"]["body"], ENT_QUOTES, 'UTF-8');
};


//フラッグ追加
$_SESSION["flg_edit"] = 1;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="cafe.css">
    <title>Edit</title>
</head>
<body>
<section>
        <div class="contact_box">
            <h2>お問合せ内容編集</h2>
			<form action="" method="post" id="data">
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <h3>下記の項目を編集の上送信ボタンを押してください</h3>
            <p><span class="required">*</span>は必須項目となります。</p>
			<dl>
                <dt><label for="name">氏名</label><span class="required">*</span></dt>
                <?php if ((empty($name)) or (mb_strlen($name)>10)): ?>
                    <dd>
                        <p class="error_msg hidden_error">氏名は必須入力です。10文字以内でご入力ください。</p>
                    </dd>
                <?php endif; ?>
                <dd><input type="text" name="name" id="name" placeholder="山田太郎" value="<?php echo $name ?>"></dd>
                <dt><label for="kana">フリガナ</label><span class="required">*</span></dt>
                <?php if ((empty($kana)) or (mb_strlen($kana)>10)): ?>
                    <dd>
                    <p class="error_msg hidden_error">フリナガは必須入力です。10文字以内でご入力ください。</p>
                    </dd>
                <?php endif; ?>
                <!-- <dd class="error">フリナガは必須入力です。10文字以内でご入力ください。</dd> -->
                <dd><input type="text" name="kana" id="kana" placeholder="ヤマダタロウ" value="<?php echo $kana ?>"></dd>
                <dt><label for="tel">電話番号</label></dt>
                <?php if ((!empty($tel)) && (!preg_match('/^[0-9]+$/', $tel))): ?>
                    <dd>
                    <p class="error_msg hidden_error">電話番号は0-9の数字のみでご入力ください。</p>
                    </dd>
                <?php endif; ?>
                <!-- <dd class="error">電話番号は0-9の数字のみでご入力ください。</dd> -->
                <dd><input type="text" name="tel" id="tel" placeholder="09012345678" value="<?php echo $tel ?>"></dd>
                <dt><label for="email">メールアドレス</label><span class="required">*</span></dt>
                <?php if ((empty($email)) or (!filter_var($email, FILTER_VALIDATE_EMAIL))): ?>
                    <dd>
                    <p class="error_msg hidden_error">メールアドレスは正しくご入力ください。</p>
                    </dd>
                <?php endif; ?>
                <!-- <dd class="error">メールアドレスは正しくご入力ください。</dd> -->
                <dd><input type="text" name="email" id="email" placeholder="test@test.co.jp" value="<?php echo $email ?>"></dd>
                </dl>
                <h3><label for="body">お問い合わせ内容をご記入ください<span class="required">*</span></label></h3>
                <dl class="body">
                <?php if (empty($body)): ?>
                    <dd>
                    <p class="error_msg hidden_error">お問い合わせ内容は必須入力です。</p>
                    </dd>
                <?php elseif (mb_strlen($body) > 255): ?>
                    <dd>
                    <p class="error_msg hidden_error">お問い合わせ内容は255文字以内でお願いします。</p>
                    </dd>
                <?php endif; ?>
                <!-- <dd class="error">お問い合わせ内容は必須入力です。</dd> -->
                <dd><textarea name="body" id="body"><?php echo $body ?></textarea></dd>
				<dd><button class="submit" type="submit">送　信</button></dd>
			</dl>
			</form>
        </div>
    </section>
</body>
</html>

<?php if (isset($_SESSION["flg_edit"])): ?>
    
    <script>
    var elems = document.querySelectorAll(".hidden_error");
    [].forEach.call(elems, function(el) {
    el.classList.remove("hidden_error");
    });
    </script>
 

<?php endif; ?>

<script>



const submit = document.querySelector(".submit")

const form = document.querySelector(".contact_box form")


submit.addEventListener("click", (e) => {
    const name = document.getElementById("name").value;
    const kana = document.getElementById("kana").value;
    const tel = document.getElementById("tel").value;
    const email = document.getElementById("email").value;
    const body = document.getElementById("body").value;
    let errors = [];
  
    if ((name.length === 0) || (name.length > 10)) {
        errors.push('氏名は必須入力です。10文字以内でご入力ください。');
    }; 
    if (kana.length === 0 || kana.length > 10) {
        errors.push('フリナガは必須入力です。10文字以内でご入力ください。');
    };
    if (tel.length !== 0 && !/^[0-9]*$/.test(tel)) {
        errors.push('電話番号は0-9の数字のみでご入力ください。');
    };
    if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
        errors.push('メールアドレスは正しくご入力ください。');
    };
    if (body.length === 0) {
        errors.push('お問い合わせ内容は必須入力です。');
    };
    if (body.length > 255) {
        errors.push('お問い合わせ内容は255文字以内でお願いします。');
    };
    if (errors.length !== 0) {
        alert(errors.join("\n"));
    } else {
        form.setAttribute("action", "update.php")
    };
});




</script>