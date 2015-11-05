<?php
include_once 'config.php';

class ACCOUNT {

  function AccountCheck( $account, $password ){
    echo 'mode2';
    echo $account;
    echo $CFG['DVSV'];
    $dcon = 'mysql:host=' . $CFG['DBSV'] . ';dbname=' . $CFG['DBNM'];
    try{
      $pdo = new PDO($dcon, $CFG['DBUSER'], $CFG['DBPASS']);
      $sql = ("SELECT name, level FROM users WHERE account = :account AND pass = :pass");
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':account', $account, PDO::PARAM_STR);
      $stmt->bindParam(':pass', $password, PDO::PARAM_STR);
      $stmt->execute();
      $userdata = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch (PDOException $e){
      print('Error:'.$e->getMessage());
      die();
    }
    return $userdata;
  }

  
}

