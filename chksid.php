<?PHP
include_once 'config.php';
include_once 'lib/function.php';
include_once 'lib/accountlib.php';
include_once 'lib/mailaddrlib.php';

session_start();
$errormode = 0;

isset($_SESSION['name'])? $name = $_SESSION['name'] : $name = '';
if ( $name !== '' ){
  header('Location:' . $CFG['HOMEPATH'] . '/index.php');
}

isset(! $_GET['sid'] ){
  header('Location:' . $CFG['HOMEPATH'] . '/index.php');
}

$sid = (string)filter_input(INPUT_GET, 'sid');

// sid が渡されたのでチェック
$sidchk = new MailAddr;
$errormode = $sidchk->chkMailSid( $sid );

if ( $errormode === 2 ) {
  $sidchk->AuthMail( $sid );
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
	if ( ($errormode === 0) || ($errormode === 1)){
	?>
	このリンクは無効です
	再度登録をお願いいたします。
	<?php
	} else if { $errormode === 2 )
	?>
	メールアドレスを確認しました。次はプロフィールの登録をお願いします。
	profile site link.
	<?php
	}
	>
      </div>

      <div class="col-sm-2"></div>
    </div>
  </body>
</HTML>
