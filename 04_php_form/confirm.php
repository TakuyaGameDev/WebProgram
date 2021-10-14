
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
  if ((empty($_POST['name'])) or (mb_strlen($name) > 10)) {
      $errors[] = '氏名は必須入力です。10文字以内でご入力ください。';
  };
  // 読み仮名
  if ((empty($_POST['kana'])) or (mb_strlen($kana) > 10)) {
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
let errors =<?php echo $json_errors; ?>


</script>
<head>
<meta charset="UTF-8">
<title>Inquiry</title>
<link rel="stylesheet" type="text/css" href="cafe.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<?php if (empty($errors)) : ?>
  <section>
    <div class="contact_box">
      <h2>お問い合わせ</h2>
    
      <form action="complete.php" method="post">
      
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
          <?php echo $body ?>
          </dd>
          <dd class="confirm_btn">
            <button type="submit">送　信</button>
            <a href="javascript:history.back();">戻　る </a>
          </dd>
        </dl>
      </form>
    </div>

  </section>

<?php else : ?>
  <?php foreach ($errors as $error) {
    echo $error."<br/>";
  }?>
<?php endif; ?>
</body>
