<?php
include_once 'config.php';
mb_language("ja");
mb_internal_encoding("UTF-8");


class MailAddr {
  // メールアドレスチェッククラス
  // chkMailSend チェック用メールの送信
  // chkMail  メールの情報があるかのチェック
  // AuthMail メールアドレス許可、ユーザタイプを -1 から 1 へ変更
  //  -1 未認証、 1 認証済

  
  function chkAddrMailSend( $email, $name, $sid ){
    // アドレスチェックメールの送信
    global $CFG;

    $authurl = $CFG['HOMEPATH'] . '/mailaddr.php?sid=' . $sid;  
    $toaddr = "$email";  // 宛先
    $subject = "講師登録のユーザ登録をありがとうございます。";

    // テンプレートからメール本文の読み込み
    ob_start();
    require_once 'chkAddrMail.tpl';
    $mailbody = ob_get_contents();
    ob_end_clean();

    $target = array("%name%", "%email%", "%authurl%" );
    $replace = array($name, $email, $authurl );
    $mailbody = str_replace ($target, $replace, $mailbody);

    $fromaddr = "From: " . mb_encode_mimeheader ('"名前"') .  "<noreply@morris.co.jp>";
    $mailbody = mb_convert_encoding ($mailbody, "iso-2022-jp", "UTF-8");
    mb_send_mail ($toaddr, $subject, $mailbody, $fromaddr);
    
  }
  
  function chkMailSid( $email, $sid = ''){
    // $email のチェック
    global $CFG;

    $dsn = 'mysql:host=' . $CFG['DBSV'] . ';dbname=' . $CFG['DBNM'] . ';charset=utf8';
    try{
      $pdo = new PDO($dsn, $CFG['DBUSER'], $CFG['DBPASS']);
      $sql = ("SELECT name, usertype_cd FROM users WHERE email = :email AND sid = $sid");
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);
      $stmt->bindValue(':sid', $sid, PDO::PARAM_STR);
      $stmt->execute();
      $userdata = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch (PDOException $e){
      print('Error:'.$e->getMessage());
      die();
    }
    if ( $userdata === FALSE ) {
      return 0; // email, SID がなし
    } else if ( $userdata['usertype_cd'] > 0 ) {
      return 1;   // 登録ずみ
    } else if ( $userdata['usertype_cd'] < 0 ) {
      return 2;  // メールアドレス未認証未登録
    } 
  }

  function AuthMail( $email, $sid = ''){
    // $email の登録
    global $CFG;

    $dsn = 'mysql:host=' . $CFG['DBSV'] . ';dbname=' . $CFG['DBNM'] . ';charset=utf8';
    try{
      $pdo = new PDO($dsn, $CFG['DBUSER'], $CFG['DBPASS']);
      $sql = ("UPDATE users SET usertype_cd = '1' WHERE email = :email AND sid = $sid");
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);
      $stmt->bindValue(':sid', $sid, PDO::PARAM_STR);
      $stmt->execute();
    }catch (PDOException $e){
      print('Error:'.$e->getMessage());
      die();
    }
    
  }
}
