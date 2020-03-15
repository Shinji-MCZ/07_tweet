<?php

require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];

$dbh = connectDb();

$sql = "select * from tweets where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

$tweet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tweet) {
  header('Location: index.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  $content = $_POST['content'];
  $unchange = $_POST['unchange'];
  $errors = [];

  if ($content == '') {
    $errors['content'] = '入力がされていません';
  }

  //タイトルと本文が未編集の場合エラー文表示
  if ($content === $tweet['content']) {
    $errors['unchanged'] = '内容が変更されていません';
  }

  if (empty($errors)){
  $sql = "update tweets set content = :content, created_at = now() where id = :id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(":content", $content);
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  //index.phpに戻る
  header('Location: index.php');
  exit;
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>tweetの編集画面</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>tweetの編集</h1>
  <p>
    <a href="index.php">戻る</a>
  </p>
  <?php if ($errors) : ?>
    <ul class="error">
      <?php foreach ($errors as $error) : ?>
        <li>
          <?php echo h($error); ?>
        </li>
      <? endforeach; ?>
    </ul>
  <?php endif; ?>
  <form action="" method="post">
    <p>
      <label for="content">ツイート内容</label><br>
      <textarea name="content" id="" cols="30" rows="5"><?php echo h($post['content']); ?></textarea>
    </p>
    <p>
      <input type="submit" value="編集する">
    </p>
  </form>
</body>
</html>