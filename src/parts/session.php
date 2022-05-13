<?php
session_start();
function isLogin(){
  global $user_data;
  if (!isset($_SESSION["login"])) {
    return 0;
  }
  $mso = new MSO();
  $user_data = $mso -> getUserProfile($_SESSION["login"]);
  if($user_data[0]['uid']!=$_SESSION["login"]) logout();

  return 1;
}



function gglRedirect(){
$params = array(
	'client_id' => CONSUMER_KEY,
	'redirect_uri' => CALLBACK_URL,
	'scope' => 'https://www.googleapis.com/auth/userinfo.profile',
	'response_type' => 'code',
);

// 認証ページにリダイレクト
header("Location: " . AUTH_URL . '?' . http_build_query($params));
exit;
}

function login($uid){
  session_regenerate_id(TRUE);
  $_SESSION["login"] = $uid;
  echo $_SESSION["login"];
  header("Location: home");
  exit();
}

function logout($code = '0921'){
  if (!isset($_SESSION["login"])) {
    header("Location: home");
    exit();
  }

  $_SESSION = array();
  if (ini_get("session.use_cookies")) {
    setcookie(session_name(), '', time() - 42000, '/');
  }
  session_destroy();
  header("Location: home/{$code}");
  exit();
}

function deleteUser($key){
  if($key == getKey($_SESSION['login'])){
    $mso = new MSO();
    if($mso ->deleteUser($_SESSION['login'])) {
      return 0;
    }else{
      return 1;
    }
  }

}

function getKey($uid){
  $mso = new MSO();
  return $mso -> getKey($uid);
}
