<?php

function h( $str ){
  return(htmlspecialchars( $str, ENT_QUOTES, 'UTF-8' ));
}

function debug_prn( $str ){
  if ( isset($str)){
    return $str;
  } else {
    $str = '';
    return $str;
  }
}