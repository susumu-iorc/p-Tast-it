<?php

function setPost($mso, $start, $number, $uid ='--NOTING--'){
  global $page_data,$cst;
  $rtn[0]="";
  $rtn[1]="";
  switch($page_data['sort']){
    case 4: $view_html = "すべてのタスクを表示しています"; break;
    case 3: $view_html = "完了したタスクを表示しています"; break;
    case 2: $view_html = "登録された順に表示しています"  ; break;
    case 1: $view_html = "期限が遅い順に表示しています"  ; break;
    case 0: $view_html = "期限が近い順に表示しています"  ; break;
    default:$view_html = "不正なパラメーターです"        ; break;
  }
  $user_name = $mso -> getName();
  $user_icon = $mso -> getIcon();
  if($mso -> getPost($start, $number, $uid, $page_data['sort'])) exit ('error');
  $post_list = $mso ->fetch();

  $rtn[0] .=<<< EOD
        <div class="PostBox">
          <div class="main-message-box">
          <p>{$view_html}</p>
          </div>

  EOD;

  for($i=0;$i<count($post_list);$i++){
    $tmp = setPostHtml($post_list[$i]["post_title"], $post_list[$i]["pid"], $user_name[$post_list[$i]["uid"]], $post_list[$i]["uid"], $post_list[$i]["is_deadline"], $post_list[$i]["stat"], $post_list[$i]["deadline_at"]);
    $rtn[0] .= $tmp[0];
    $rtn[1] .= $tmp[1];
  }
  if(count($post_list)==0){
  $rtn[0] .= <<<EOD
          <div class="Posts">
            <div class="Posts_tape"></div>
            <div class="Posts_contents"><p>該当するコンテンツが存在しません</p></div>
            <p class="Posts_time"></p>
          </div>

  EOD;
}
  $rtn[0] .="      </div>\n";


  if(count($post_list)<3)
  $rtn[0] .="      <div class=\"hiddenSp\" style=\"height:100px;\">\n</div>";


  return $rtn;
}



function setPostHtml($title, $pid, $name, $uid, $deadline, $stat, $day){
  if($stat){
    if($deadline)
      $status = "予定日：{$day}";
    else
      $status = "予定日：未設定";
    $task_toggle = "完了する";
  }else{
    $status = "完了";
    $task_toggle = "作業中へ";
  }
  $title_full = $title;
  if(mb_strlen($title) > 88 )$title = mb_substr($title, 0, 88) .'...';
  global $cst;
  $tmp[0] =<<<EOF

  <div class="Posts">
      <a href="javascript:postTapeMenu({$pid});"><div class="Posts_tape" id="Posts_tape_{$pid}"></div></a>
      <div class="dropdown" id="drop_{$pid}">
      <a href="javascript:detachPost('{$pid}','{$cst(BASEURL)}process')" class="btn btn--orange btn--radius">{$task_toggle}</a>
  <form action="{$cst(BASEURL)}process" method="post">
        <input type="hidden" name="p_method" value="detach">
        <input type="hidden" name="pid" value="{$pid}">
        </form>
      </div>
  <a class="Link js-modal-open" href="" data-target="{$pid}" id="link_{$pid}" display="inline"></a>
  <div class="Posts_contents"><p>{$title}</p></div>
    <p class="Posts_time">{$status}</p>

  <!--<a href="{$cst(BASEURL)}user/{$uid}" >   ここらへん作り変える               -->
  <p class="Posts_prof"><img src="{$cst(BASEURL)}icon/{$uid}" alt="{$name}" title="{$name}">{$name}</p>
  <!--</a>-->
  </div>
EOF;
$tmp[1] =<<<EOD
<div id="{$pid}" class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
  <div class="button-center" style="margin-bottom:2em;">
        <a href="javascript:detachPost('{$pid}','{$cst(BASEURL)}process')" class="btn btn--orange btn--radius" >{$task_toggle}</a>
  </div><div class="mixbox">
      <p>{$title_full}</p>
      </div>
      <div class="button-center" style="   margin-top:2em;">
      <button class="js-modal-close" href="">close</button>
  </div>
  </div><!--modal__inner-->
  </div><!--modal-->
EOD;

return $tmp;
}
