<?php
require '../../common/auth.php';
require '../../common/database.php';

if(!isLogin()) {
  header('Location ../login/');
  exit;
}

$id = $_GET['id'];
$user_id = getLoginUserId();

$database_handler = getDatabaseConnection();

if($statement = $database_handler->prepare('
  SELECT id, title, content FROM memos
  WHERE user_id = :user_id AND id = :id
')) {
  $statement->bindParam(':user_id', $user_id);
  $statement->bindParam(':id', $id);
  $statement->execute();
  $result = $statement->fetch(PDO::FETCH_ASSOC);
}

$_SESSION['select_memo'] = [
  'id' => $result['id'],
  'title' => $result['title'],
  'content' => $result['content']
];

header('Location: ../../memo/');
exit;
