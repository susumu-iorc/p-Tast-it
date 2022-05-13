<?php
if($page_data['data']=='sample'){
  login('1');
}

if(extPost("mode") == "login"){
  gglRedirect();
}

if(extPost("mode") == "logout"){
  logout(extPost("code"));
  if(extPost("ans"))exit('logouted');
}

if(extPost("mode") == "delete"){
  if(deleteUser(extPost("key")))
    echo '1';
  else
    echo '0';
  exit();
}

if(extPost("mode") == "getKey"){
  if($_SESSION['login']=='1') echo '0';
  else echo getKey($_SESSION['login']);
  exit;
}

if($page_data['data']=='0921'){
  $putHtml .= <<<EOD
  <script> alert('ログアウトしました')</script>
  EOD;
}

if($page_data['data']=='1005'){
  $putHtml .= <<<EOD
  <script> alert('アカウントは削除されました')</script>
  EOD;
}
