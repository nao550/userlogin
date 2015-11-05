<?php
include_once 'config.php';

class ACCOUNT {

  function AccountCheck( $account, $password ){
    global $CFG;

    $dsn = 'mysql:host=' . $CFG['DBSV'] . ';dbname=' . $CFG['DBNM'] . ';charset=utf8';
    try{
      $pdo = new PDO($dsn, $CFG['DBUSER'], $CFG['DBPASS']);
      $sql = ("SELECT name, level FROM users WHERE account = :account AND pass = :pass");
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':account', $account, PDO::PARAM_STR);
      $stmt->bindValue(':pass', $password, PDO::PARAM_STR);
      $stmt->execute();
      $userdata = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch (PDOException $e){
      print('Error:'.$e->getMessage());
      die();
    }
    return $userdata;
  }

  
}

