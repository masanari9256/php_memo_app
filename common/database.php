<?php

/**
 * PDOを使用してDBに接続する
 * @return PDO|void
 */
function getDatabaseConnection() {
  try {
    $database_handler = new PDO(
      'mysql:host=db;dbname=simple_memo;charset=utf8mb4',
      'root',
      'password'
    );
  } catch(PDOException $e) {
    echo '接続に失敗しました';
    echo $e->getMessage();
    exit;
  }
  return $database_handler;
}
