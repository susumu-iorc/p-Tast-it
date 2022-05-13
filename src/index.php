<?php
require_once 'init.php';
$is_login = isLogin();

if($is_login){
  switch($page_data['type']){
    case 'home':
      include'scene/home.php';
      break;

    //case 'post':
    //  $putTitle = "準備中 - " . SITE_NAME;
    //  $putHtml  = " <p>準備中</p>";
    //  break;

    case 'posting':
      include'scene/posting.php';
      break;

    //case 'user':
    //  include"scene/user.php";
    //  break;

    case 'process':
      include"scene/process.php";
      break;

    case 'error':
      include"scene/error.php";
      break;

    case 'login':
      include"scene/login.php";
      break;

    default:
        header("Location: {$cst(BASEURL)}home");
  }
}else{
  switch($page_data['type']){
    case 'home':
    case 'login':
      include'scene/login.php';
      break;

    case 'regist':
    include 'scene/userRegist.php';
      break;

    default:
        header("Location: {$cst(BASEURL)}home");

  }
}
include"Viewer.php";
