<?php
include_once 'config.php';
include_once 'lib/function.php';
include_once 'lib/mailaddrlib.php';

session_start();
$errormode = 0;

isset($_SESSION['name'])? $name = $_SESSION['name'] : $name = '';
isset( $_GET['sid'] )? $sid = h($_GET['sid']) : $sid = '';
if ( $name !== '' || $sid === ''){
//  header('Location:' . $CFG['HOMEPATH'] . '/index.php');
}

$mail = new MailAddr;
$errormode = $mail->chkMailSid( $sid );
// 1: SID がDBにない
// 2: 通常ユーザとして登録済
// 3: SIDの登録日が $CFG['LIMITDATE'] より古い
// 4: メールアドレス認証未認証

if ( $errormode === 1 || $errormode === 2){
  header('Location:' . $CFG['HOMEPATH'] . '/index.php');
} else if ( $errormode === 3 ){
  $mail->delAccountSid($sid);
}

// チェックして問題なかったので、SID を有効化
if ( $errormode === 4  ) {
  $mail->AuthMail( $sid );
}

switch( $errormode ){
case 0:
  $message = "<p>SIDエラー</p>";
  break;
case 2:
  $message = "<p>登録済</p>";
  break;
case 3:
  $message = "<p>認証メールの有効期限が切れています。<br />再度登録をしてください。</p>";
  break;
case 4:
  $message = "<p>メールアドレスを認証しました。</p>";
  break;
default:
  $message = "なんかエラー";
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

      <div class="col-sm-8">

	<?= $message; ?>

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
