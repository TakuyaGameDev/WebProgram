
<?php

session_start();

//ダイレクトアクセス禁止
if ($_SESSION["flg"] !== 1 || !$_SERVER['HTTP_REFERER'] == "http://localhost:8888/04_php_form/contact.php") {
  header('Location: http://localhost:8888/04_php_form/contact.php');
};

$_SESSION["flg_confirm"] = 1;

$_SESSION["postData"] = $_POST;

$name = htmlspecialchars($_SESSION["postData"]["name"], ENT_QUOTES, 'UTF-8');
$kana = htmlspecialchars($_SESSION["postData"]["kana"], ENT_QUOTES, 'UTF-8');
$tel = htmlspecialchars($_SESSION["postData"]["tel"], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_SESSION["postData"]["email"], ENT_QUOTES, 'UTF-8');
$body = htmlspecialchars($_SESSION["postData"]["body"], ENT_QUOTES, 'UTF-8');

// if (isset($_POST)) {
//   // 氏名
//   if ((empty($_POST['name'])) or (mb_strlen($name) > 10)) {
//       $errors[] = '氏名は必須入力です。10文字以内でご入力ください。';
//   };
//   // 読み仮名
//   if ((empty($_POST['kana'])) or (mb_strlen($kana) > 10)) {
//       $errors[] = 'フリナガは必須入力です。10文字以内でご入力ください。';
//   }; 
//   // 電話番号
//   if (!preg_match('/^[0-9]+$/', $tel)) {
//       $errors[] = '電話番号は0-9の数字のみでご入力ください。';
//   };
//   // メール
//   if ((empty($email)) or (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
//       $errors[] = 'メールアドレスは正しくご入力ください。';
//   };
//   // お問い合わせ内容
//   if (empty($body)) {
//       $errors[] = 'お問い合わせ内容は必須入力です。';
//   } elseif (mb_strlen($body) > 255) {
//       $errors[] = 'お問い合わせ内容は255文字以内でお願いします。';
//   };
// };


?>

<head>
<meta charset="UTF-8">
<title>Inquiry</title>
<link rel="stylesheet" type="text/css" href="cafe.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

  <section>
    <div class="contact_box">
      <h2>お問い合わせ</h2>
    
      <form action="complete.php" class="confirm_form">
      
        <p>下記の内容をご確認の上送信ボタンを押してください</p>
        <p>内容を訂正する場合は戻るを押してください。</p>
        <dl class="confirm">
          <dt>氏名</dt>
          <dd><?php echo $name?></dd>
          <dt>フリガナ</dt>
          <dd><?php echo $kana?></dd>
          <dt>電話番号</dt>
          <dd><?php echo $tel ?></dd>
          <dt>メールアドレス</dt>
          <dd><?php echo $email?></dd>
          <dt>お問い合わせ内容</dt>
          <dd>
          <?php 
          echo nl2br($body)
          ?>
          </dd>
          <dd class="confirm_btn">
            <button type="submit" class="submit">送　信</button>
            <a href="contact.php" class="confirm_back">戻　る </a>
          </dd>
        </dl>
      </form>
    </div>

  </section>



</body>



