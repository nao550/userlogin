<?PHP
include_once 'config.php';
include_once 'lib/function.php';
include_once 'lib/accountlib.php';
include_once 'lib/mailaddrlib.php';

session_start();
$errormode = 0;

isset( $_SESSION['id'] )? $sid = $_SESSION['id'] : $_SESSION['id'] = session_id();
isset($_SESSION['name'])? $name = $_SESSION['name'] : $name = '';
if ( $name === '' ){
  header('Location:' . $CFG['HOMEPATH'] . '/index.php');
}

isset($_POST['mode'])? $mode = h($_POST['mode']) : $mode = '';

/*
以下の修正が必要になる

$_SESSION からアカウント名などをもってきてtextboxに入れる

変更のアルゴリズムをかんがえる
  一時テーブルを使用する方法

 */


if ( $mode !== '' ){

  // ユーザ名チェック
  isset($_POST['accountname'])? $accountname = h($_POST['accountname']) : $accountname = '';
  $ac = new ACCOUNT;
  if ( $accountname === '' ) {
    $errormode = 1;
    $accountname_er = 1;  // ユーザ名入力なしエラー
  } else if ( $ac->isAccountname($accountname)) {
    $errormode = 1;
    $accountname_er = 2;  // ユーザ名重複エラー
  } else if ( strlen($accountname) < 6 || strlen($accountname) > 20) {
    $errormode = 1;
    $accountname_er = 3; // ユーザ名長エラー
  } else if (! ctype_alnum($accountname)) {
    $errormode = 1;
    $accountname_er = 4; // 英数字以外エラー
    echo "hogehoge";
  } else {
    $mail_er = 0;    
  }

  
  // メールアドレス入力チェック
  isset($_POST['email'])? $email = h($_POST['email']) : $email = '';
  $ac = new ACCOUNT;

  if ( $email === '' ){
    $errormode = 1;
    $email_er = 1;  // アドレス入力なしエラー
  } else if ( $ac->isMailAddr($email)) {
    $errormode = 1;
    $email_er = 2;  // アドレス重複エラー
  } else {
    $email_er = 0;    
  }

  // パスワードチェック
  // TODO: パスワード長の設定をconfig設定化する
  isset($_POST['pwd1'])? $pwd1 = h($_POST['pwd1']) : $pwd1 = '';
  isset($_POST['pwd2'])? $pwd2 = h($_POST['pwd2']) : $pwd2 = '';	
  if ( $pwd1 === '' || $pwd2 === '' ) {
    $errormode = 2;
    $pass_er = 1; // パスワード入力不足エラー
  } else if ( strlen($pwd1) < 6 || strlen($pwd1) > 20 ||
	      strlen($pwd2) < 6 || strlen($pwd2) > 20 ) {
    $errormode = 2;
    $pass_er = 2; // パスワード長エラー
  } else if ( $pwd1 !== $pwd2 ) {
    $errormode = 2;
    $pass_er = 3; // パスワードミスマッチエラー
    /*
    英数字以外禁止にしたが、英数字以外も有効にしたほうがいいので
    一旦削除。
    TODO: preg_match() でチェックする？
    } else if ( ctype_alnum($pwd1)) {
    $errormode = 2;
    $pass_er = 4; // 英数字以外エラー
     */
  } else {
    $pass_er = 0;
  }

  // 名前入力チェック
  isset($_POST['sei'])? $sei = h($_POST['sei']) : $sei = '';
  isset($_POST['mei'])? $mei = h($_POST['mei']) : $mei = '';
  if ( $sei === '' || $mei === '' ) {
    $errormode = 1;
    $name_er = 1;
  }

  // アカウト登録処理
  if ( $mode === 'submit' && $errormode === 0 ){
    // アカウント登録
    $ac = new ACCOUNT;
    $ac->addAccount( $accountname, $pwd1, $sei, $mei, $email, $sid );
    $name = $sei . ' ' . $mei;
    // 確認メールの送信
    $mailsend = new MailAddr;
    $mailsend->chkAddrMailSend( $email, $name, $sid);
    
    $mode = 'addaccount';
    $_SESSION['account'] = $email;
    $_SESSION['name'] = $sei . " " . $mei;
    $_SESSION['level'] = '1';
  }

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
1
    <title>利用者登録</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="./css/bootstrap-template.css" rel="stylesheet">
    <link href="./css/signin.css" rel="stylesheet">

    <script src="./js/signini.js"></script>
    
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

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="./index.php">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container-fluid">

      <div class="col-sm-2"></div>

      <div class="col-sm-8 signin">

	<?php
	if ( $mode !== 'addaccount' ){ // サインイン画面の表示
	?>

	<div class="signin-form">
	  <form action="#" method="POST" id="form-signini" name="form-signin" class="form-horizontal">
	    <h2>利用者登録</h2>

	    <div class="form-group">
	      <label for="accountname" class="col-sm-3 control-label">ユーザ名</label>
	      <div class="col-sm-9">
		<input type="text" id="accountname" name="accountname" class="form-control"  placeholder="ユーザ名を入力してください" <?php if(isset($accountname)) print("value=\"" . $accountname . "\""); ?>>
	      </div>
	    </div>
	    <?php
	    if (isset($accountname_er)){
	      if ($accountname_er === 1 ){
		print <<< EOL
		<div class="col-sm-offset-3 col-sm-9">
		<p class="bg-danger mailerror">
		ユーザ名を入力してください.
	        </p>
		</div>
EOL;
	      } else if  ($accountname_er === 2){
		print <<< EOL
		<div class="col-sm-offset-3 col-sm-9">
		<p class="bg-danger mailerror">
	        ユーザ名はすでに存在します.
	        </p>
		</div>
EOL;
	      } else if  ($accountname_er === 3){
		print <<< EOL
		<div class="col-sm-offset-3 col-sm-9">
		<p class="bg-danger mailerror">
		ユーザ名を6文字以上20文字以下で入力してください.
	        </p>
		</div>
EOL;
	      } else if  ($accountname_er === 4){
		print <<< EOL
		<div class="col-sm-offset-3 col-sm-9">
		<p class="bg-danger mailerror">
		ユーザ名は英数字で入力してください.
	        </p>
		</div>
EOL;
              }
	    }
	      ?>
	    

	    <div class="form-group">
	      <label for="email" class="col-sm-3 control-label">メールアドレス</label>
	      <div class="col-sm-9">
		<input type="email" id="email" name="email" class="form-control"  placeholder="メールアドレスを入力してください" <?php if(isset($email)) print("value=\"" . $email . "\""); ?>>
	      </div>
	    </div>
	    <?php
	    if (isset($email_er)){
	      if ($email_er === 1 ){
		print <<< EOL
		<div class="col-sm-offset-3 col-sm-9">
		<p class="bg-danger mailerror">
		メールアドレスを入力してください.
	        </p>
		</div>
EOL;
	      } else if  ($email_er === 2){
		print <<< EOL
		<div class="col-sm-offset-3 col-sm-9">
		<p class="bg-danger mailerror">
	        メールアドレスはすでに存在します.
	        </p>
		</div>
EOL;
               }
             }
	      ?>
	    


	    <div class="form-group">	    	  
	      <label for="pwd1" class="control-label col-sm-3">パスワード</label>
	      <div class="col-sm-9">
		<input type="password" id="pwd1" name="pwd1" class="form-control" placeholder="パスワードを入力してください">
	      </div>
	    </div>

	    <div class="form-group">	    	  
	      <label for="pwd2" class="control-label col-sm-3">パスワード再入力</label>
	      <div class="col-sm-9">
		<input type="password" id="pwd2" name="pwd2" class="form-control" placeholder="パスワードを再入力してください">
	      </div>
	    </div>
	         
	    <?php
	    if (isset($pass_er)){
	      if ($pass_er === 1){
	      print <<< EOL
	      <div class="col-sm-offset-3 col-sm-9">
	        <p class="bg-danger mailerror">
	        パスワードを入力してください。
	        </p>
	      </div>
EOL;
	      }
	      if ( $pass_er === 2) {
	        print <<< EOL
	        <div class="col-sm-offset-3 col-sm-9">
	          <p class="bg-danger mailerror">
	          パスワードは6文字以上20文字以下で入力してください。
	          </p>
  	        </div>
EOL;
	      }
	      if ( $pass_er === 3 ) {
	        print <<< EOL
	        <div class="col-sm-offset-3 col-sm-9">
	          <p class="bg-danger mailerror">
	          パスワードが一致しません。
	          </p>
	        </div>
EOL;
	      }
	    }
	      ?>


	    
	    <div class="form-group">	    	  
	      <label for="sei" class="control-label col-sm-3">お名前</label>
	      <div class="col-sm-4">
		<input type="sei" id="sei" name="sei" class="form-control" placeholder="姓" value="<?php 
		if (isset($sei)) { echo $sei; } else {  echo '';};?>">
	      </div>
	      <div class="col-sm-4">
		<input type="mei" id="mei" name="mei" class="form-control" placeholder="名" value="<?php 
		if (isset($mei)) { echo $mei; } else {  echo '';};?>">
	      </div>
	    </div>

	    <?php
	    if (isset($name_er)){
	      if ($name_er === 1 ){
		print <<< EOL
		<div class="col-sm-offset-3 col-sm-9">
		<p class="bg-danger mailerror">
		姓、名を入力してください。
	        </p>
		</div>
EOL;
	      }
	    }
	      ?>

	    <div class="form-group">
	      <div class="col-sm-offset-3 col-sm-10">
		<button type="submit" id="sbumit_sign" class="btn btn-default">登録</button>
	      </div>
	    </div>
		    
	    <input type="hidden" class="form-control" name="mode" value="submit">
	  </form>
	</div>

	<?php
// アカウント登録完了画面
	} else if ( $mode === 'addaccount' ){ 
	?>
	<div class="form-signin">
	  <p>アカウント登録が完了しました。<br />
	    登録いただいたアドレス宛にメールを送信しておりますので、
	    本文中にあるリンクをクリックしてアドレスの確認を
	    してください。
	  </p>
	  <P>
	    ひきつづきプロファイル登録よりプロファイルの登録を
	    してください。
	  </p>
	</div>
	<?php
	} // 画面表示終了
	?>

      </div>

      <div class="col-sm-2"></div>
    </div><!-- /.container -->


    <footer class="footer">
      <div class="container">
        <p class="text-muted">モーリスビジネス学院</p>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./js/ie10-viewport-bug-workaround.js"></script>

  </body>
</html>
