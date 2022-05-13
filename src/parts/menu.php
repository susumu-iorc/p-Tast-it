<?php

function buttonPageMove($mso, $now_page){
  global $cst, $user_data, $page_data;
  $on  = '#ff9300';
  $off = '#555222';
  if(             1 <= $now_page            ) $prev = $on; else $prev = $off;
  if(($now_page+1)*12 < $mso -> getPostNum($user_data[0]['uid'],$page_data['sort'])) $next = $on; else $next = $off;

  $tmp = <<<EOP
  <div class="PageMoveBox">
    {$cst(($prev == $on) ?'<a href="'.BASEURL.'home/'.($now_page-1).'">' : '<a>')}
    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevrons-left" width="76" height="76" viewBox="0 0 24 24" stroke-width="1.5" stroke="{$prev}" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <polyline points="11 7 6 12 11 17" />
      <polyline points="17 7 12 12 17 17" />
    </svg>
    </a>
    {$cst(($next == $on) ?'<a href="'.BASEURL.'home/'.($now_page+1).'">' : '<a>')}
    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevrons-right" width="76" height="76" viewBox="0 0 24 24" stroke-width="1.5" stroke="{$next}" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <polyline points="7 7 12 12 7 17" />
      <polyline points="13 7 18 12 13 17" />
    </svg>
    </a>
  </div>
  EOP;

  return $tmp;
}


function chaseMenu($tmp, $mso, $now_page = 0){
  global $cst,$user_data;
  if(extCookie('spmenu') == "none") $menu_cookie = 'none'; else $menu_cookie ='inline';
  $menuOnOffButton = menuOnOffButton();
  if(!$tmp) return 0;
  $rtn= <<<EOD
  <div class="new_Posts_box">
  <div style="text-align: right;">{$menuOnOffButton}</div>
  <div id="FloatMenu" style="display:{$menu_cookie}">

  {$cst(buttonPageMove($mso, $now_page))}
    <div class="new_Posts">
      <div class="new_Posts_tape"></div>
        <div class="new_Posts_contents">
          <a class="Link" href="{$cst(BASEURL)}posting"></a>
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-square-plus" width="100%" height="140%" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff9300" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <rect x="4" y="4" width="16" height="16" rx="2" />
            <line x1="9" y1="12" x2="15" y2="12" />
            <line x1="12" y1="9" x2="12" y2="15" />
          </svg>
        </div>
        </div>
    </div>
  </div>
  <!--Copyright (c) Tabler Icons
  Released under the MIT license
  https://tablericons.com/-->
  EOD;
  return $rtn;
}

function menuSet(){
  global $cst, $page_data, $user_data;
  $navi = naviOnOffButton();
  $n_post = "newPostButton";

  echo <<< EOF
    </div>
    <div id="menu">
      <div class="menu-box-pc">
      <p>{$user_data[0]['name']}さん</p>
      <ul>
        <li><a class="Link" href="javascript:setViewModeCookie(0);">期限が近い順に表示</a></li>
        <li><a class="Link" href="javascript:setViewModeCookie(1);">期限が遅い順に表示</a></li>
        <li><a class="Link" href="javascript:setViewModeCookie(3);">完了したタスクを表示</a></li>
        <li><a class="Link" href="javascript:doLogout();">ログアウト</a></a></li>
        <li><a class="Link js-modal-open" href="" data-target="deleteuser" >ユーザーの削除</a></li>
      </ul>
    </div>
  </div>
  <nav>
    <div class="hiddenPc" style="position: relative;left: -60px;">{$navi}</div>
    <ul>
    <p>{$user_data[0]['name']}さん</p>
    <li><a href="javascript:setViewModeCookie(0);">期限が近い順に表示</a></li>
    <li><a href="javascript:setViewModeCookie(1);">期限が遅い順に表示</a></li>
    <li><a href="javascript:setViewModeCookie(3);">完了したタスクを表示</a></li>
    <li><a href="/"><a href="javascript:adoLogout();">ログアウト</a></a></li>
    <li><a class="Link js-modal-open" href="" onclick="$('nav').toggleClass('open');" data-target="deleteuser" >ユーザーの削除</a></li>
  </nav>

  EOF;
}
function loginMenu(){
  global $cst;
  echo <<<EOD
      <div class="PostBox">
        <div class="Posts_login">
          <div class="Posts_tape"></div>
          <div class="Posts_contents">
            <form action="{$cst(BASEURL)}login" method="post">
              <input type="hidden" name="mode" value="login">
              <button type="submit" class="login-google-button">
              <svg aria-hidden="true" class="native svg-icon iconGoogle" width="24" height="24" viewBox="0 0 18 18"><path d="M16.51 8H8.98v3h4.3c-.18 1-.74 1.48-1.6 2.04v2.01h2.6a7.8 7.8 0 002.38-5.88c0-.57-.05-.66-.15-1.18z" fill="#4285F4"></path><path d="M8.98 17c2.16 0 3.97-.72 5.3-1.94l-2.6-2a4.8 4.8 0 01-7.18-2.54H1.83v2.07A8 8 0 008.98 17z" fill="#34A853"></path><path d="M4.5 10.52a4.8 4.8 0 010-3.04V5.41H1.83a8 8 0 000 7.18l2.67-2.07z" fill="#FBBC05"></path><path d="M8.98 4.18c1.17 0 2.23.4 3.06 1.2l2.3-2.3A8 8 0 001.83 5.4L4.5 7.49a4.77 4.77 0 014.48-3.3z" fill="#EA4335"></path></svg>
              Sign in with Google
            </button>
        </form><br>
        <hr>
        <a href="{$cst(BASEURL)}sample">お試し</a>
      </div>
      </div>
    </div>
  </div>

  EOD;
  return 0;
}
