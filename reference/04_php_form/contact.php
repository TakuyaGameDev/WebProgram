




<?php
session_start();
include('./trueheader.php');

//入力保持用変数のエラー防止
$name="";
$kana="";
$tel="";
$email="";
$body="";

//戻る用入力保持
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == "http://localhost:8888/04_php_form/confirm.php") {
    $name = htmlspecialchars($_SESSION["postData"]["name"], ENT_QUOTES, 'UTF-8');
    $kana = htmlspecialchars($_SESSION["postData"]["kana"], ENT_QUOTES, 'UTF-8');
    $tel = htmlspecialchars($_SESSION["postData"]["tel"], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_SESSION["postData"]["email"], ENT_QUOTES, 'UTF-8');
    $body = htmlspecialchars($_SESSION["postData"]["body"], ENT_QUOTES, 'UTF-8');
};

//エラー用入力保持
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == "http://localhost:8888/04_php_form/contact.php") {
    $_SESSION["postData"] = $_POST;
    $name = htmlspecialchars($_SESSION["postData"]["name"], ENT_QUOTES, 'UTF-8');
    $kana = htmlspecialchars($_SESSION["postData"]["kana"], ENT_QUOTES, 'UTF-8');
    $tel = htmlspecialchars($_SESSION["postData"]["tel"], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_SESSION["postData"]["email"], ENT_QUOTES, 'UTF-8');
    $body = htmlspecialchars($_SESSION["postData"]["body"], ENT_QUOTES, 'UTF-8');
};

//再アクセス時にSESSIONをからにする
if (!isset($_SERVER['HTTP_REFERER'])) {
    $_SESSION = array();
} elseif ($_SERVER['HTTP_REFERER'] !== "http://localhost:8888/04_php_form/confirm.php" && !$_SERVER['HTTP_REFERER'] !== "http://localhost:8888/04_php_form/contact.php") {
    $_SESSION = array();
};

//ダイレクトアクセス判定用フラッグ追加
$_SESSION["flg"] = 1;

//DBrelated

function con_ini() {

    try { 
    $dbh = new PDO('mysql:dbname=cafe;host=localhost;charset=utf8','root','root', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    } catch(PDOException $e){
        echo 'DB接続エラー' . $e->getMessage();
        exit();
    };
    return $dbh;
};

$dbh = con_ini();

try {
    $dbh->beginTransaction();
    $sql = "SELECT * FROM contacts";
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $dbh->commit();
    $dbh = null;

} catch(PDOException $e) {
    echo "faillure:". $e->$getMessage();
    $dbh->rollBack();
;}

?>


<head>
<meta charset="UTF-8">
<title>Inquiry</title>
<link rel="stylesheet" type="text/css" href="cafe.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body id="app">
    
    <open-modal style="display: none;"><div id="overlay">
		<div id="signin_box">
			<h2>ログイン</h2>
			<form action="" method="post">
			<dl>
				<dd><input type="text" name="name" placeholder="メールアドレス"></dd>
				<dd><input type="password" name="pass" placeholder="パスワード"></dd>
				<dd><button type="submit">送　信</button></dd>
			</dl>
			<dl class="sns">
				<dd><button name="twitter"><img src="cafe/img/twitter.png"></button></dd>
				<dd><button name="facebook"><img src="cafe/img/fb.png"></button></dd>
				<dd><button name="google"><img src="cafe/img/google.png"></button></dd>
				<dd><button name="apple"><img src="cafe/img/apple.png"></button></dd>
			</dl>
			</form>
		</div>
	</div></open-modal>


    
    <section>
        <div class="contact_box">
            <h2>お問い合わせ</h2>
			<form action="" method="post" id="data">
          
            <h3>下記の項目をご記入の上送信ボタンを押してください</h3>
            <p>送信頂いた件につきましては、当社より折り返しご連絡を差し上げます。</p>
            <p>なお、ご連絡までに、お時間を頂く場合もございますので予めご了承ください。</p>
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

    <table>
        <tr>
            <th>ID</th>
            <th>氏名</th>
            <th>フリガナ</th>
            <th>電話番号</th>
            <th>メールアドレス</th>
            <th>お問い合わせ内容</th>
            <th>送信日時</th>
            <th></th>
            <th></th>
        </tr>
        <?php foreach($result as $column): ?>
        <tr class="papa">
            <td><?php echo $column["id"] ?></td>
            <td><?php echo $column["name"] ?></td>
            <td><?php echo $column["kana"] ?></td>
            <td><?php echo $column["tel"] ?></td>
            <td><?php echo $column["email"] ?></td>
            <td><?php echo $column["body"] ?></td>
            <td><?php echo $column["created_at"] ?></td>
            <td><a href="edit.php?id=<?php echo $column["id"] ?>">編集</a></td>
            <td><a href="" class="delete">削除</a></td>
        </tr>
        <?php endforeach; ?>
    </table>


</body></html>

<?php if ((isset($_POST)) && (isset($_SERVER['HTTP_REFERER'])) && ($_SERVER['HTTP_REFERER'] == "http://localhost:8888/04_php_form/contact.php")): ?>
    
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
const deleteAll = document.querySelectorAll(".delete")


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
        alert(errors.join("\n"))
    } else {
        form.setAttribute("action", "confirm.php")
    };
});




const deleteConfirmation = function (e) {
    e.preventDefault();
    const id = e.target.closest(".papa").firstElementChild.innerHTML
    if (confirm("ほんまに削除してええの？")) {
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

<?php 

$errors = [];

// if (isset($_POST)) {
//     // 氏名
//     if ((empty($name)) or (mb_strlen($name) > 10)) {
//         $errors[] = '氏名は必須入力です。10文字以内でご入力ください。';
//     };
//     // 読み仮名
//     if ((empty($kana)) or (mb_strlen($kana) > 10)) {
//         $errors[] = 'フリナガは必須入力です。10文字以内でご入力ください。';
//     }; 
//     // 電話番号
//     if (!preg_match('/^[0-9]+$/', $tel)) {
//         $errors[] = '電話番号は0-9の数字のみでご入力ください。';
//     };
//     // メール
//     if ((empty($email)) or (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
//         $errors[] = 'メールアドレスは正しくご入力ください。';
//     };
//     // お問い合わせ内容
//     if (empty($body)) {
//         $errors[] = 'お問い合わせ内容は必須入力です。';
//     } elseif (mb_strlen($body) > 255) {
//         $errors[] = 'お問い合わせ内容は255文字以内でお願いします。';
//     };
   
//   };


?>


<?php
include('./footer.php');
?>

