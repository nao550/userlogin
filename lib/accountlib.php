<?php
include_once 'config.php';

class ACCOUNT {

  
  function Login( $account, $pwd ){
    // ログインできれば、ユーザ情報が、できなければ false がかえる
    global $CFG;
    $pwd = $this->get_password_hash( $account, $pwd );

    $dsn = 'mysql:host=' . $CFG['DBSV'] . ';dbname=' . $CFG['DBNM'] . ';charset=utf8';
    try{
      $pdo = new PDO($dsn, $CFG['DBUSER'], $CFG['DBPASS']);
      $sql = ("SELECT name, usertype_cd FROM users WHERE account = :account AND password = :password");
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':account', $account, PDO::PARAM_STR);
      $stmt->bindValue(':password', $pwd, PDO::PARAM_STR);
      $stmt->execute();
      $userdata = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch (PDOException $e){
      print('Error:'.$e->getMessage());
      die();
    }
    return $userdata;
  }

  function addAccount( $account, $pwd, $sei, $mei, $email ){
    // アカウント追加ができればtrue, できなければ false
    global $CFG;

    $pwd = $this->get_password_hash( $account, $pwd );
    $name = $sei . " " . $mei;
    $date = date("Y-m-d");
    
    $dsn = 'mysql:host=' . $CFG['DBSV'] . ';dbname=' . $CFG['DBNM'] . ';charset=utf8';
    try{
      $pdo = new PDO($dsn, $CFG['DBUSER'], $CFG['DBPASS']);
      $sql = ("INSERT INTO users (account, name, usertype_cd, password, email, regdate, moddate, passch) VALUES ( :account, :name, '1', :password, :email, :regdate, :moddate, :passch)");
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':account', $account, PDO::PARAM_STR);
      $stmt->bindValue(':name', $name, PDO::PARAM_STR);
      $stmt->bindValue(':password', $pwd, PDO::PARAM_STR);
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);
      $stmt->bindValue(':regdate', $date, PDO::PARAM_STR);
      $stmt->bindValue(':moddate', $date, PDO::PARAM_STR);
      $stmt->bindValue(':passch', $date, PDO::PARAM_STR);
      $stmt->execute();
    }catch (PDOException $e){
      print('Error:'.$e->getMessage());
      die();
    }
    return true;
  }
  
  function isAccount( $account ){
    // アカウントがあれば、true, なければ false
    global $CFG;

    $dsn = 'mysql:host=' . $CFG['DBSV'] . ';dbname=' . $CFG['DBNM'] . ';charset=utf8';
    try{
      $pdo = new PDO($dsn, $CFG['DBUSER'], $CFG['DBPASS']);
      $sql = ("SELECT name FROM users WHERE account = :account");
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':account', $account, PDO::PARAM_STR);
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

  private function get_password_hash($account, $pwd) {
    global $CFG;

    $salt = $account . pack('H*', $CFG['PWDSALT']);
    $hash = ''; // ハッシュの初期化
    for ($i = 0; $i < $CFG['STRETCHCOUNT']; $i++) {
      $hash = hash('sha256', $hash. $pwd . $salt);
    }
    return $hash;
  }

  
}

