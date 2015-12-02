<?php
include_once 'config.php';
include_once 'lib/function.php';
include_once 'lib/accountlib.php';
session_start();
$errormode = 0;

// ログイン処理
if ( isset($_POST['mode']) && $_POST['mode'] === 'login'){
  if ( ! isset($_POST['accountname']) ||  ! isset($_POST['password'])){
    $errormode = 1;
  }

  // エラーなしなのでログインチャレンジ
  if ( $errormode == 0 ){ 
    $accountname = h($_POST['accountname']);
    $password = h($_POST['password']);
    $ac = new ACCOUNT;
    $userdata = $ac->Login( $accountname, $password);
  }

  // ログインの確認
  if ( ($userdata !== FALSE) ){
    $_SESSION['accountname'] = $accountname;
    $_SESSION['name'] = h($userdata['name']);
    $_SESSION['level'] = h($userdata['level']);
  } else {
    $_SESSION['accountname'] = '';
    $_SESSION['name'] = '';
    $_SESSION['level'] = '';
    $errormode = 2;
  }
}

// ログインに成功すれば最初のページへ
isset( $_SESSION['name'])? $name = $_SESSION['name'] : $name = '';
if ( $name !== '') {
     header('Location:' . $CFG['HOMEPATH'] . '/index.php');
}

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./favicon.ico">

    <title>Signin Template for Bootstrap</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

    <!-- Custom styles for this template -->
    <link href="./css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]>
    <script src="./js/ie8-responsive-file-warning.js"></script>
    <![endif]-->
    <script src="./js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <form class="form-signin" action="login.php" method="POST">
        <h2 class="form-signin-heading">ログイン</h2>
	<label for="inputaccountname" class="sr-only">アカウント名：</label>
	<input type="text" id="inputaccountname" name="accountname" class="form-control" placeholder="アカウント名" required autofocus>
	<label for="inputPassword" class="sr-only">パスワード：</label>
	<input type="password" id="inputPassword" name="password" class="form-control" placeholder="パスワード" required>
<!--
	<div class="checkbox">
	  <label>
	    <input type="checkbox" value="remember-me"> ログインしたままにする 
	  </label>
	</div>
-->
	<input type="hidden" name="mode" value="login">
	<button class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>
	<?php
	if ( $errormode === 1 ){
	  print("	<p class=\"bg-denger\">アカウント名とパスワードを入力してください。</p>");
	} else if ( $errormode === 2 ) {
	  print("	<p class=\"bg-denger\">アカウント名かパスワードが違います。</p>");
	}
	?>
      </form>

    </div> <!-- /container -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
