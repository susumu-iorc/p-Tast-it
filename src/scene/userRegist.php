<?php
if(extPost('mode')=='regist'){
  $user_name = extPost('name');
  $file_name = extPost("pre-ID");
  $options = stream_context_create(array('ssl' => array(
    'verify_peer'      => false,
    'verify_peer_name' => false
  )));
  $res = file_get_contents("{$cst(BASEURL)}disposable/{$file_name}.json",false,$options);

  if($res!="" && $user_name!='name'){
  $result = json_decode($res, true);
  $mso = new MSO();
  $file_name;
$regist_result = $mso -> newRegist($result['id'], 'Google', 'no', $user_name, 'noting');

  if($regist_result==1)exit('データベースエラー');
  unlink ("{$cst(BASEURL)}disposable/{$file_name}.json");
  login($regist_result);
}exit("エラー");
}

$file_name = extGet('pageData');
$options = stream_context_create(array('ssl' => array(
  'verify_peer'      => false,
  'verify_peer_name' => false
)));

$res = file_get_contents("{$cst(BASEURL)}disposable/{$file_name}.json",false,$options);
  $result = json_decode($res, true);

if(isset($result['id'])){
$putHtml = <<<EOD
  <div class="PostBox">

  <div class="Posts_login">
  <div class="Posts_tape"></div>
  <div class="Posts_contents">
  <div style="padding-left:2em;padding-top:5em;">
    <form action="{$cst(BASEURL)}regist" method="post">
    <label for="name">表示名</label>
    <input type="text" name="name" id="name" value="{$result["name"]}" maxlength="12" required>
      <input type="hidden" name="pre-ID" value="{$file_name}">
      <input type="hidden" name="mode" value="regist">
      <button type="submit" >登録する</button>

      </button>

    </form>
    </div>
  </div>

  </div>


</div>
</div>


EOD;
}else{
  $putTitle = '無効なリクエスト'.SITE_NAME;
  $putDesc  = '';
  $putHtml = "無効なリクエストです。<a href=\"{$cst(BASEURL)}home\">トップページ</a>から再度ご利用ください</div>";
  http_response_code( 400 ) ;
}
