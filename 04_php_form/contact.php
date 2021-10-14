<?php

session_start();


    $name = $_POST["name"];
    $kana = $_POST["kana"];
    $tel = $_POST["tel"];
    $email = $_POST["email"];
    $body = $_POST["body"];

    $_SESSION["form_data"] = $_FORM;

    if (isset($_POST)) {
        // 氏名
        if ((empty($name)) or (mb_strlen($name) > 10)) {
            $errors[] = '氏名は必須入力です。10文字以内でご入力ください。';
        };
        // 読み仮名
        if ((empty($kana)) or (mb_strlen($kana) > 10)) {
            $errors[] = 'フリナガは必須入力です。10文字以内でご入力ください。';
        }; 
        // 電話番号
        if (!preg_match('/^[0-9]+$/', $tel)) {
            $errors[] = '電話番号は0-9の数字のみでご入力ください。';
        };
        // メール
        if ((empty($email)) or (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
            $errors[] = 'メールアドレスは正しくご入力ください。';
        };
        // お問い合わせ内容
        if (empty($body)) {
            $errors[] = 'お問い合わせ内容は必須入力です。';
        } elseif (mb_strlen($body) > 255) {
            $errors[] = 'お問い合わせ内容は255文字以内でお願いします。';
        };
    };

    $json_errors = json_encode($errors);


?>

<script>

// let errors =<?php echo $json_errors; ?>

// console.log(errors);



// const submit = document.querySelector(".submit")

// submit.addEventListener("click", (e) => {
//     if (errors != []) {
//         e.preventDefault();
//         forEach(error => alert(error))
//     }       

// }, false)


</script>




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
			<form action="confirm.php" method="post">
          
            <h3>下記の項目をご記入の上送信ボタンを押してください</h3>
            <p>送信頂いた件につきましては、当社より折り返しご連絡を差し上げます。</p>
            <p>なお、ご連絡までに、お時間を頂く場合もございますので予めご了承ください。</p>
            <p><span class="required">*</span>は必須項目となります。</p>
			<dl>
                <dt><label for="name">氏名</label><span class="required">*</span></dt>
                <dd class="error"><?php if ((empty($name)) or (mb_strlen($name) > 10)) echo "氏名は必須入力です。10文字以内でご入力ください。"; ?></dd>
                <dd><input type="text" name="name" id="name" value="<?php echo $name ?>" placeholder="山田太郎"></dd>
                <dt><label for="kana">フリガナ</label><span class="required">*</span></dt>
                <!-- <dd class="error">フリナガは必須入力です。10文字以内でご入力ください。</dd> -->
                <dd><input type="text" name="kana" id="kana" value="<?php echo $kana ?>" placeholder="ヤマダタロウ"></dd>
                <dt><label for="tel">電話番号</label></dt>
                <!-- <dd class="error">電話番号は0-9の数字のみでご入力ください。</dd> -->
                <dd><input type="text" name="tel" id="tel" value="<?php echo $tel ?>" placeholder="09012345678"></dd>
                <dt><label for="email">メールアドレス</label><span class="required">*</span></dt>
                <!-- <dd class="error">メールアドレスは正しくご入力ください。</dd> -->
                <dd><input type="text" name="email" id="email" value="<?php echo $email ?>" placeholder="test@test.co.jp"></dd>
            </dl>
            <h3><label for="body">お問い合わせ内容をご記入ください<span class="required">*</span></label></h3>
            <dl class="body">
                <!-- <dd class="error">お問い合わせ内容は必須入力です。</dd> -->
                <dd><textarea name="body" id="body"></textarea></dd>
				<dd><button class="submit" type="submit">送　信</button></dd>
			</dl>
			</form>
        </div>
    </section>


</body></html>

<?php
include('./footer.php');
?>

