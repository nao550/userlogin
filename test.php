<!DOCTYPE html>
<?php
include_once 'config.php';
include_once 'lib/function.php';
include_once 'lib/accountlib.php';
session_start();


$stat = 'noset';
$errormode = '0';

// ログアウト時の処理、セッションID, Cookie の削除
if ( isset($_GET['mode']) && $_GET['mode'] === 'logout'){
  $_SESSION = array();
  $params = session_get_cookie_params();
  setcookie(session_name(), '' , time() - 42000,
	    $params['path'], $params['domain'],
	    $params['secure'], $params['httponly']
  );
  session_destroy();
  $stat =  'mode logout<br />';
}

// セッションIDの設定
if ( ! isset($_SESSION['id'])){
  $_SESSION['id'] = session_id();
}

// アカウントチェックの処理
if ( isset($_POST['mode']) && $_POST['mode'] === 'login'){
  if ( ! isset($_POST['account']) ||  ! isset($_POST['password'])){
    $errormode = 1;
  }

  // エラーなしなのでログインチャレンジ
  if ( $errormode == 0 ){ 
    $account = h($_POST['account']);
    $password = h($_POST['password']);

    $ac = new ACCOUNT;
    $userdata = $ac->AccountCheck( $account, $password);
  }

  // ログインの確認
  if ( isset($userdata)){
    $_SESSION['name'] = h($userdata['name']);
    $_SESSION['level'] = h($userdata['level']);
  } else {
    $_SESSION['name'] = '';
    $_SESSION['level'] = '';
  }
}

?>
<html lang="ja">
  <head>
  </head>
  <body>
  <?php
  if ( isset($_GET['mode'] )){
    echo $_GET['mode'];
  }
  echo "<pre>";
  echo var_dump( $_SESSION );
  echo "</pre>";
  echo $stat; echo "<br>";
  echo var_dump( isset($_GET['mode']));
  echo var_dump( strcmp($_GET['mode'], 'logout'));
  echo var_dump( $_GET['mode'] === 'logout' );
  echo var_dump( $id );
  echo var_dump( $_POST );
  
?>

    <form action="test.php" method="POST">
      <label>id</label>
      <input type="text" name="account">
      <label>pass</label>
      <input type="text" name="password">
      <input type="hidden" name="mode" value="login">
      <input type="submit">
      <input type="reset">
    </form>
    <br />
    <a href="test.php?mode=logout">logout</a>
  </body>
</html>
  
