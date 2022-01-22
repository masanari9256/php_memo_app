<?php
/**
 * タイトルを指定してヘッダーを作成する
 * @param $title
 * @return string
 */
function getHeader($title) {
  return <<<EOF
    <head>
      <meta charset="utf-8" />
      <title>SimpleMemo | {$title}</title>
      <link rel="stylesheet" type="text/css" href="../public/css/bootstrap.min.css" />
      <link rel="stylesheet" type="text/css" href="../public/css/main.css" />
      <script defer src="../public/js/all.js"></script>
    </head>
EOF;
}

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
