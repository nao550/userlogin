<?PHP
include_once 'config.php';
include_once 'lib/function.php';
include_once 'lib/accountlib.php';

session_start();
$errormode = 0;

isset($_SESSION['name'])? $name = $_SESSION['name'] : $name = '';
if ( $name !== '' ){
  header('Location:' . $CFG['HOMEPATH'] . '/index.php');
}

if ( isset($_POST['email']) ){
  $ac = new ACCOUNT;
  if ( $ac->isAccount(h($_POST['email']))) {
    $email = h($_POST['email']);
    $errormode = 1;
  } else {
    $errormode = 0;
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

    <title>利用者登録</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="./css/bootstrap-template.css" rel="stylesheet">
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
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container-fluid">

      <div class="col-sm-2"></div>

      <div class="col-sm-8 signin">

	<div class="signin-form">

	  <form action="#" method="POST" name="form-signin" class="form-horizontal">
	    <h2>利用者登録</h2>

	    <div class="form-group">
	      <label for="email" class="col-sm-3 control-label">メールアドレス</label>
	      <div class="col-sm-9">
		<input type="email" id="email" name="email" class="form-control"  placeholder="メールアドレスを入力してください" <?php if(isset($email)) print("value=\"" . $email . "\""); ?>>
	      </div>
	    </div>
	    <?php
	    if ($errormode === 1){
	      print <<< EOL
	      <div class="col-sm-offset-3 col-sm-9">
	      <p class="bg-danger mailerror">
	      アドレスはすでに存在します.
	    </p>
	    </div>
EOL;
	    }
	      
	      ?>
	    
	    <div class="form-group">	    	  
	      <label for="password1" class="control-label col-sm-3">パスワード</label>
	      <div class="col-sm-9">
		<input type="password" name="password1" class="form-control" placeholder="パスワードを入力してください">
	      </div>
	    </div>

	    <div class="form-group">	    	  
	      <label for="password2" class="control-label col-sm-3">パスワード再入力</label>
	      <div class="col-sm-9">
		<input type="password" name="password1" class="form-control" placeholder="パスワードを再入力してください">
	      </div>
	    </div>

	    <div class="form-group">	    	  
	      <label for="sei" class="control-label col-sm-3">お名前</label>
	      <div class="col-sm-4">
		<input type="sei" name="sei" class="form-control" placeholder="姓">
	      </div>
	      <div class="col-sm-4">
		<input type="mei" name="mei" class="form-control" placeholder="名">
	      </div>
	    </div>

<!--
	    <div class="form-group">
	      <div class="col-sm-offset-3 col-sm-9">
		<div class="checkbox">
		  <label>
		    <input type="checkbox"> Remember me
		  </label>
		</div>
	      </div>
	    </div>
-->
	    <div class="form-group">
	      <div class="col-sm-offset-3 col-sm-10">
		<button type="submit" class="btn btn-default">登録</button>
	      </div>
	    </div>
		    

	  </form>
	</div>
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
