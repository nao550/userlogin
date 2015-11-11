<?php
include_once 'config.php';

class ACCOUNT {

  
  function Login( $account, $pwd ){
    // ログインできれば、ユーザ情報が、できなければ false がかえる
    global $CFG;

    $dsn = 'mysql:host=' . $CFG['DBSV'] . ';dbname=' . $CFG['DBNM'] . ';charset=utf8';
    try{
      $pdo = new PDO($dsn, $CFG['DBUSER'], $CFG['DBPASS']);
      $sql = ("SELECT name, level FROM users WHERE account = :account AND pass = :pass");
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':account', $account, PDO::PARAM_STR);
      $stmt->bindValue(':pass', $pwd, PDO::PARAM_STR);
      $stmt->execute();
      $userdata = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch (PDOException $e){
      print('Error:'.$e->getMessage());
      die();
    }
    return $userdata;
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

    $salt = $id . pack('H*', $CFG['PWDSALT']);
    $hash = ''; // ハッシュの初期化
    for ($i = 0; $i < $CFG['STRETCHCOUNT']; $i++) {
      $hash = hash('sha256', $hash. $pwd . $salt);
    }
    return $hash;
  }

  
}

