<?php
require_once 'init.php';

$params = array(
	'code' => $_GET['code'],
	'grant_type' => 'authorization_code',
	'redirect_uri' => CALLBACK_URL,
	'client_id' => CONSUMER_KEY,
	'client_secret' => CONSUMER_SECRET,
);

// POST送信
$options = array('http' => array(
	'method' => 'POST',
  'header' => 'Content-type: application/x-www-form-urlencoded',
	'content' => http_build_query($params)
));

// アクセストークンの取得
$res = file_get_contents(TOKEN_URL, false, stream_context_create($options));

// レスポンス取得
$token = json_decode($res, true);
if(isset($token['error'])){
	echo 'エラー発生';
	exit;
}

$access_token = $token['access_token'];
$params = array('access_token' => $access_token);

// ユーザー情報取得
$res = file_get_contents(INFO_URL . '?' . http_build_query($params));
$result = json_decode($res, true);

$mso = new MSO();
$get_uid = $mso -> getUserId($result['id'])[0]['uid'];

if(!$get_uid){
	$file_name = hash("sha256", $result['id'].time());
	file_put_contents("./disposable/{$file_name}.json", $res);
	header("Location: regist/{$file_name}");
	exit();
}

login($get_uid);
