<?php
include_once 'config.php';
include_once 'lib/function.php';
include_once 'lib/accountlib.php';

session_start();
$errormode = 0;
$stat = '';
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
  
  </head>
  <body>
  <?php
  if ( isset($_SESSION['account']) && isset($_SESSION['name']) && isset($_SESSION['id'] )){
      if ( $_POST['session_id'] === $_SESSION['id'] ){
	print("<p>user alredy logind.");
	print("<p>name:" . $_SESSION['name'] );
	print("<p>account:" . $_SESSION['account'] );
	print("<p><a href=\"test.php?mode=logout\">logout</aa>");	
      } else {
	print("<p>session high jacked.");
      }
    } else {
      print("<p>user not logind.<br />");
    }
  ?>
  
  </body>
</html>