<?php

function h( $str ){
  return(htmlspecialchars( $str, ENT_QUOTES, 'UTF-8' ));
}

function page_url_path(){
  return ((empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
}

function debug_prn( $str ){
  if ( isset($str)){
    return $str;
  } else {
    $str = '';
    return $str;
  }
}