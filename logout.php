<?php
include_once 'config.php';
include_once './lib/function.php';
session_start();

isset($_SESSION['name'])? $name = $_SESSION['name'] : $name = '';
if ( $name === '' ) {
  header('Location:' . $CFG['HOMEPATH'] . '/index.php');
} else {
  // ログアウト時の処理、セッションID, Cookie の削除
  $_SESSION = array();
  $params = session_get_cookie_params();
  setcookie(session_name(), '' , time() - 42000,
	    $params['path'], $params['domain'],
	    $params['secure'], $params['httponly']
  );
  session_destroy();
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>ログアウト</title>
    <meta httpequiv="refresh" content="5; <?= $CFG['HOMEPATH'] ?>" />
  </head>
  
<body>
  ログアウトしました。<br />
  5秒後に<a href="<?= $CFG['HOMEPATH'] ?>">移動</a>します。
</body>
</html>

