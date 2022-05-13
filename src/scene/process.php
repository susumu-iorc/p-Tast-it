<?php
function htmlEscape($str){
  $usable_tags = array(
    array('#br','<br>'),
    array('#hr','<hr>'),
  );
  $str = htmlspecialchars($str, ENT_QUOTES|ENT_HTML5);

/*
  for($i=0;$i<count($usable_tags);$i++){
    $str = str_replace($usable_tags[$i][0], $usable_tags[$i][1], $str);
  }
  */
  return $str;
}

$mso = new MSO();
if( ($p_method      = extPost('p_method'))      == NULL ){echo "不正なパラメーター";exit();}
switch ($p_method) {
  case 'posting':
    if( ($uid      = extPost('uid'))      == NULL ){echo "不正なパラメーター：ユーザーIDが入力されていません";exit();}
    if(  $_SESSION['login'] != $mso -> getUserProfile($uid)[0]['uid'] ){echo "不正なパラメーター：ユーザーIDが存在しません";exit();};
    if( ($contents = extPost('Contents')) == NULL ){echo "不正なパラメーター：コンテンツが存在しません";exit();}
    if(extPost('isntDeadline') == 1){
      $deadline = 0;
      $deadline_at = '2199-12-31 23:59:59';
    }else{
      $deadline=1;
      if( ( ($Date = extPost('Date')) == NULL) || ($Time = extPost('Time') ) == NULL ){echo "不正なパラメーター：日付、時間の入力が不正です";exit();}
      $deadline_at = $Date.' '.$Time;
      if(date_parse_from_format('Y-m-d H:i',$deadline_at)['error_count']){echo "不正なパラメーター：日付、時間の入力が不正です";exit();}
    }
      $contents = htmlEscape($contents);
      if(($result = $mso -> newPost($uid, $contents, "--NOTING--", $deadline, $deadline_at))) {echo "なんかエラーが起きたみたい:".$result;$mso -> viewError();exit();}
      $pid = $mso -> fetch();
        header("Location: {$cst(BASEURL)}home");
  break;
  case 'detach':
    if( ($pid      = extPost('pid'))      == NULL ){echo "不正なパラメーター：postIDが入力されていません";exit();}
    if($mso -> updatePost($pid)){echo"なんかエラー";exit();}

    exit("detach_ok");
  break;
  default:
    echo "処理が定義されていません";exit();
  break;
};
