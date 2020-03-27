<?php
require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];

$dbh = connectDb();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // フォームに入力されたデータの受け取り
  $good = $_GET['good'];

  if ($good == "1") {
    $good_value = 1;
  } else {
    $good_value = 0;
  }

  // データを更新する処理
  $sql = "update tweets set good = :good_value where id = :id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(":id", $id, PDO::PARAM_INT);
  $stmt->bindParam(":good_value", $good_value);
  $stmt->execute();  
  $tweet = $stmt->fetch();

  $page = $_SERVER['HTTP_REFERER'];
  header('Location:' . $page);
exit;
}