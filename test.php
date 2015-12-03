<!DOCTYPE html>
<?php
include_once 'config.php';
include_once 'lib/function.php';
include_once 'lib/accountlib.php';

session_start();
$errormode = 0;
$stat = '';

// ログアウト時の処理、セッションID, Cookie の削除
if ( isset($_GET['mode']) && $_GET['mode'] === 'logout'){
  $_SESSION = array();
  $params = session_get_cookie_params();
  setcookie(session_name(), '' , time() - 42000,
	    $params['path'], $params['domain'],
	    $params['secure'], $params['httponly']
  );
  session_destroy();
  $stat = $stat . 'mode : logout<br />';
}

// セッションIDの設定
if ( ! isset($_SESSION['id'])){
  $_SESSION['id'] = session_id();
  $stat = $stat . 'mode : set session id.<br />';
}

// アカウントチェックの処理
if ( isset($_POST['mode']) && $_POST['mode'] === 'login'){
  if ( ! isset($_POST['account']) ||  ! isset($_POST['password'])){
    $errormode = 1;
    $stat = $stat . 'mdoe : account or password errror.<br />';
  }

  // エラーなしなのでログインチャレンジ
  if ( $errormode == 0 ){ 
    $account = h($_POST['account']);
    $password = h($_POST['password']);

    $ac = new ACCOUNT;
    $userdata = $ac->Login( $account, $password);
    $stat = $stat . 'mode : user account check.<br />';
  }

  // ログインの確認
  if ( isset($userdata)){
    $_SESSION['account'] = $account;
    $_SESSION['name'] = h($userdata['name']);
    $_SESSION['usertype_cd'] = h($userdata['usertype_cd']);
    $stat = $stat . 'mode : succsess user login.<br />';

    include_once 'lib/mailaddrlib.php';
    $smail = new MailAddr;
    $smail->chkAddrMailSend( $account, $_SESSION['name'], $_SESSION['id']);
    echo 'mailsend.';

  } else {
    $_SESSION['account'] = '';
    $_SESSION['name'] = '';
    $_SESSION['level'] = '';
  }
}

foreach (array("id", "account","name") as $v){
  $p[$v] = filter_input(INPUT_GET, $v);
}

?>
<html lang="ja">
  <head>
  </head>
  <body>
  <?php

  echo var_dump( $_GET['mode']);
  echo var_dump( $_POST['mode']);

  echo "<pre>";
  echo var_dump( $_SESSION );
  echo var_dump($p);
  echo "</pre>";
  echo $stat; echo "<br>";
  print_r( page_url_path() . "<br />\n");




     echo $date;
  
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
    <a href="test.php?mode=logout">logout</a><br />

    <form name="loginchk" method="POST" action="test2.php">
    <input type="hidden" name="session_id" value="<?php echo $_SESSION['id'] ?>">
    <a href="#" onClick="document.loginchk.submit();">test2</a>
    </form>
  </body>
</html>
  
