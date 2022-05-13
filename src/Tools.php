<?php
function extGet($tmp){
  if(isset($_GET[$tmp]))
    return $_GET[$tmp];
  else
    return NULL;
}

function extPost($tmp){
  if(isset($_POST[$tmp]))
    return $_POST[$tmp];
  else
    return NULL;
}

function extCookie($tmp){
  if(isset($_COOKIE[$tmp]))
    return $_COOKIE[$tmp];
  else
    return NULL;
}

function viewErrorPage( $tmp ){
  global $is_login,$page_data;
  http_response_code( $tmp ) ;
  $page_data['data'] = $tmp;
  include("scene/error.php");
  include("Viewer.php");
  return 1;
}

$cst ='cst';
function cst($const){return $const;};

foreach ( glob( './*Tools.php' ) as $filename )
{
  include_once $filename;
}
