<?php

require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];

$dbh = connectDb();

$sql = "select * from tweets where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();

$tweet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tweet) {
  header('Location: index.php');
  exit;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>編集画面</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1><?php echo h($tweet['content']); ?></h1>
  <p>
    <ul class="tweet">
      <li>
        [#<?php echo h($tweet['id']) ?>]
        <?php echo h($tweet['content']); ?></a><br>
        <span>投稿日時:<?php echo h($tweet['created_at']); ?></span>
        <a href="edit.php?id=<?php echo h($tweet['id']); ?>">[編集]</a>
        <a href="delete.php?id=<?php echo h($tweet['id']); ?>">[削除]</a>
        <?php if($tweet['good'] == 0) : ?>
          <a href="good.php?id=<?php echo h($tweet['id']) . "&good=1"; ?>" class="good-link"><?php echo '☆'; ?></a>
        <?php else : ?>
          <a href="good.php?id=<?php echo h($tweet['id']) . "&good=0"; ?>" class="bad-link"><?php echo '★'; ?></a>
        <?php endif; ?>
        <hr>
      </li>
    </ul>
  </p>
  </form>
</body>
</html>