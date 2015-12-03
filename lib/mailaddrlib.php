<?php
include_once 'config.php';
mb_language("ja");
mb_internal_encoding("UTF-8");


class MailAddr {
  // メールアドレスチェッククラス
  // chkMailSend チェック用メールの送信
  // chkMail  メールの情報があるかのチェック
  // AuthMail メールアドレス許可、ユーザタイプを 0 から 1 へ変更
  //  0 未認証、 1 認証済

  
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
}
