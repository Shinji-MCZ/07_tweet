<?php
require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // フォームに入力されたデータの受け取り
  $good = $_GET['good'];

  if (count($good < 0)) {
    
  } else {
  
  }
