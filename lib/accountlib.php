<?php
include_once 'config.php';

class ACCOUNT {

  
  function Login( $accountname, $pwd ){
    // ログインできれば、ユーザ情報が、できなければ false がかえる
    global $CFG;
    $pwd = $this->get_password_hash( $accountname, $pwd );

    $dsn = 'mysql:host=' . $CFG['DBSV'] . ';dbname=' . $CFG['DBNM'] . ';charset=utf8';
    try{
      $pdo = new PDO($dsn, $CFG['DBUSER'], $CFG['DBPASS']);
      $sql = ("SELECT name, sei, mei, usertype_cd FROM users WHERE account = :account AND password = :password");
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':account', $accountname, PDO::PARAM_STR);
      $stmt->bindValue(':password', $pwd, PDO::PARAM_STR);
      $stmt->execute();
      $userdata = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch (PDOException $e){
      print('Error:'.$e->getMessage());
      die();
    }
    return $userdata;
  }

  function addAccount( $accountname, $pwd, $sei, $mei, $email, $sid ){
    // アカウント追加ができればtrue, できなければ false
    global $CFG;

    $pwd = $this->get_password_hash( $accountname, $pwd );
    $name = $sei . " " . $mei;
    $date = date("Y-m-d");
    
    $dsn = 'mysql:host=' . $CFG['DBSV'] . ';dbname=' . $CFG['DBNM'] . ';charset=utf8';
    try{
      $pdo = new PDO($dsn, $CFG['DBUSER'], $CFG['DBPASS']);
      $sql = ("INSERT INTO users (account, name, sei, mei, usertype_cd, password, email, sid, regdate, moddate, passch) VALUES ( :accountname, :name, :sei, :mei, '0', :password, :email, :sid, :regdate, :moddate, :passch)");
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':accountname', $accountname, PDO::PARAM_STR);
      $stmt->bindValue(':name', $name, PDO::PARAM_STR);
      $stmt->bindValue(':sei', $sei, PDO::PARAM_STR);
      $stmt->bindValue(':mei', $mei, PDO::PARAM_STR);      
      $stmt->bindValue(':password', $pwd, PDO::PARAM_STR);
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);
      $stmt->bindValue(':sid', $sid, PDO::PARAM_STR);
      $stmt->bindValue(':regdate', $date, PDO::PARAM_STR);
      $stmt->bindValue(':moddate', $date, PDO::PARAM_STR);
      $stmt->bindValue(':passch', $date, PDO::PARAM_STR);
      $stmt->execute();
    }catch (PDOException $e){
      print('Error:'.$e->getMessage());
      die();
    }
     //      $this->chkMail( $email, $sid );
    return true;
  }

  function isAccountname( $accountname ){
    // アカウントがあれば、true, なければ false
    global $CFG;

    $dsn = 'mysql:host=' . $CFG['DBSV'] . ';dbname=' . $CFG['DBNM'] . ';charset=utf8';
    try{
      $pdo = new PDO($dsn, $CFG['DBUSER'], $CFG['DBPASS']);
      $sql = ("SELECT account FROM users WHERE account = :accountname");
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':accountname', $accountname, PDO::PARAM_STR);
      $stmt->execute();
      $userdata = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch (PDOException $e){
      print('Error:'.$e->getMessage());
      die();
    }

    if ( $userdata ){
      return true;
    } else {
      return false;
    }
  }

    function delAccountSid( $sid = ''){
    // $sid のアカウントを削除
    global $CFG;

    $dsn = 'mysql:host=' . $CFG['DBSV'] . ';dbname=' . $CFG['DBNM'] . ';charset=utf8';
    try{
      $pdo = new PDO($dsn, $CFG['DBUSER'], $CFG['DBPASS']);
      $sql = ("DELETE FROM users WHERE sid = :sid");
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':sid', $sid, PDO::PARAM_STR);
      $stmt->execute();
    }catch (PDOException $e){
      print('Error:'.$e->getMessage());
      die();
    }
    return true;
  }

  function AuthMailAddr( $sid = ''){
    // $email の登録
    global $CFG;
    $date = date("Y-m-d");
    
    $dsn = 'mysql:host=' . $CFG['DBSV'] . ';dbname=' . $CFG['DBNM'] . ';charset=utf8';
    try{
      $pdo = new PDO($dsn, $CFG['DBUSER'], $CFG['DBPASS']);
      $sql = ("UPDATE users SET usertype_cd = '1', moddate = :moddate  WHERE sid = :sid");
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':moddate', $date, PDO::PARAM_STR);
      $stmt->bindValue(':sid', $sid, PDO::PARAM_STR);
      $stmt->execute();
    }catch (PDOException $e){
      print('Error:'.$e->getMessage());
      die();
    }
  }
  
  function isMailAddr( $email ){
    // メールアドレスがあれば、true, なければ false
    global $CFG;

    $dsn = 'mysql:host=' . $CFG['DBSV'] . ';dbname=' . $CFG['DBNM'] . ';charset=utf8';
    try{
      $pdo = new PDO($dsn, $CFG['DBUSER'], $CFG['DBPASS']);
      $sql = ("SELECT email FROM users WHERE email = :email");
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);
      $stmt->execute();
      $email = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch (PDOException $e){
      print('Error:'.$e->getMessage());
      die();
    }

    if ( $email ){
      return true;
    } else {
      return false;
    }
  }

  function chkMailSid( $sid = ''){
    // $email のチェック
    // $CFG['LIMITDATE'] SIDの有効期限のチェック
    global $CFG;

    $limitdate = date("Y-m-d",mktime(0, 0, date("s"), date("m"), date("d") - $CFG['LIMITDATE'], date("Y")));
    
    $dsn = 'mysql:host=' . $CFG['DBSV'] . ';dbname=' . $CFG['DBNM'] . ';charset=utf8';
    try{
      $pdo = new PDO($dsn, $CFG['DBUSER'], $CFG['DBPASS']);
      $sql = ("SELECT name, usertype_cd, regdate FROM users WHERE sid = :sid");
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':sid', $sid, PDO::PARAM_STR);
      $stmt->execute();
      $userdata = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch (PDOException $e){
      print('Error:'.$e->getMessage());
      die();
    }

    if ( $userdata === FALSE ) {
      return 1; //  SID がDBになし
    }
    if ( $userdata['usertype_cd'] > '0' ) {
      return 2;   // 通常ユーザとして登録ずみ
    }
    if ( $userdata['regdate'] < $limitdate ){
      // regdate が昨日よりも前の場合 3 を返す
      return 3;
    } 
    if ( $userdata['usertype_cd'] === '0' ) {
      return 4;  // メールアドレス未認証未登録
    }
    return 0; // 出るはずのないぶぶん
  }
 
  private function get_password_hash($accountname, $pwd) {
    global $CFG;

    $salt = $accountname . pack('H*', $CFG['PWDSALT']);
    $hash = ''; // ハッシュの初期化
    for ($i = 0; $i < $CFG['STRETCHCOUNT']; $i++) {
      $hash = hash('sha256', $hash. $pwd . $salt);
    }
    return $hash;
  }


  
}

