<?php
session_start();
require '../../common/validation.php';
require '../../common/database.php';

$user_email = $_POST['user_email'];
$user_password = $_POST['user_password'];

$_SESSION['errors'] = [];

// バリデーションチェック
// 空チェック
emptyCheck($_SESSION['errors'], $user_email, 'メールアドレスを入力してください。');
emptyCheck($_SESSION['errors'], $user_password, 'パスワードを入力してください。');

// 文字数チェック

stringMinSizeCheck($_SESSION['errors'], $user_password, 'パスワードは8文字以上で入力してください。');
stringMaxSizeCheck($_SESSION['errors'], $user_email, 'メールアドレスは255文字以内で入力してください。');
stringMaxSizeCheck($_SESSION['errors'], $user_password, 'パスワードは255文字以内で入力してください。');

if(!$_SESSION['errors']) {
  // メアドチェック
  mailAddressCheck($_SESSION['errors'], $user_email, "正しいメールアドレスと入力してください。");
  
  // パスワード半角英数チェック
  halfAlphanumericCheck($_SESSION['errors'], $user_password, 'パスワードは半角英数字で入力してください。');
}

if($_SESSION['errors']) {
  header('Location: ../../memo/');
  exit;
}

// ログイン処理
$database_handler = getDatabaseConnection();

if($statement = $database_handler->prepare(
  'SELECT id, name, password FROM users WHERE email = :user_email'
)) {
  $statement->bindParam(':user_email', $user_email);
  $statement->execute();
  
  $user = $statement->fetch(PDO::FETCH_ASSOC);
  if(!$user) {
    $_SESSION['errors'] = [
      'メールアドレスまたはパスワードが間違っています。'
    ];
    header('Location: ../../login/');
    exit;
  }
  
  $name = $user['name'];
  $id = $user['id'];
  
  if(password_verify($user_password, $user['password'])) {
    $_SESSION['user'] = [
      'name' => $name,
      'id' => $id
    ];
    header('Location: ../../memo/');
    exit;
  } else {
    $_SESSION['errors'] = [
      'メールアドレスまたはパスワードが間違っています。'
    ];
    header('Location: ../../login/');
    exit;
  }
}
