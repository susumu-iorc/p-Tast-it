<?php

$putTitle = SITE_NAME.' - 新規作成';
$putDesc  = '新規作成です';

$putHtml = <<<EOD
        <div class="Posts">
          <div class="Posts_tape"></div>
          <div class="Posts_contents">
            <p id="realtime-contents"></p>
          </div>
          <p class="Posts_time" id="realtime-scheduled">予定日：未設定</p>
          <p class="Posts_prof"><img src="{$cst(BASEURL)}icon/{$user_data[0]['uid']}" alt="name" title="name">{$user_data[0]['name']}</p>
        </div>
        <div class="Posting_box mixbox">
          <form action="process" method="post">
            <textarea type="text" id="posting-contents" name="Contents" onkeyup="inputCheck()" required="required" autofocus></textarea>
            <label><input type="checkbox" name="isntDeadline" value="1" id="setChekBox" onclick="dateCheckBox();">予定日を設定しない</label><br>
            <span id="set-scheduled">
              <input type="date" id="sDate" name="Date" onchange="dateCheckBox()" required="required">
              <input type="time" id="sTime" name="Time" onchange="dateCheckBox()" required="required"><br>
              </span>
              <input type="hidden" id="uid" name="uid" value="{$user_data[0]['uid']}">
              <input type="hidden" name="p_method" value="posting">
              <button type="submit">登録</button>
            </form>
        </div>
        <script>
          window.onload = function () {
            inputCheck();
            dateCheckBox();
          }
        </script>
        
  EOD;
