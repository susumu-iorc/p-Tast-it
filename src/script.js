const cookie_age = 30 * 24 * 60 * 60;
let date  = new Date();
let year  = date.getFullYear();
let month = (tmp = date.getMonth() + 1) < 10 ? '0' + tmp : tmp;
let day   = (tmp = date.getDate()  + 1) < 10 ? '0' + tmp : tmp;
//投稿されたコンテンツについて
var lastid = 0;
function postTapeMenu( pid ){
  const drop = document.getElementById( 'drop_' + pid );
  const link = document.getElementById( 'link_' + pid );
  drop.style.display = drop.style.display == 'inline' ? 'none' :'inline';
  link.style.display = drop.style.display == 'inline' ? 'none' :'inline';
  lastid = pid;
  if( drop.style.display != 'inline' )
    lastid = 0;
}

$(document).on('click',function(e) {
   if(!$(e.target).closest('#Posts_tape_' + lastid + ', #drop_' +lastid).length) {
     if(lastid)
      postTapeMenu(lastid);
   }
 }
);

function detachPost( pid, sendurl ){
  var postData = { 'p_method' : 'detach' , 'pid' : pid };
  $.post(
      sendurl,
      postData,
      function( data ){
        location.reload();
      }
  );
}

//ログアウト移行
function doLogout( code = '0921'){
  var postData = {'mode':'logout', 'ans':'true', 'code':code};
  $.post(
    '/login',
    postData,
    function(data){
      location.reload();
    }
  );
}

//モーダル
//参考:https://webdesignday.jp/inspiration/technique/css/4680/
$(function(){
    $('.js-modal-open').each(function(){
        $(this).on('click',function(){
            var target = $(this).data('target');
            var modal = document.getElementById(target);
            $(modal).fadeIn();
            return false;
        });
    });
    $('.js-modal-close').on('click',function(){
        $('.js-modal').fadeOut();
        return false;
    });
});

function menuSwitch(){
  tmp = document.getElementById('FloatMenu');
  if( tmp.style.display == 'inline' ){
    tmp.style.display = 'none';
    document.cookie = 'spmenu=none;max-age=' + cookie_age + ';path=/';
  }else{
    tmp.style.display = 'inline';
    document.cookie = 'spmenu=inline;max-age=' + cookie_age + ';path=/';
  }

}

function setViewModeCookie(mode){
  document.cookie = 'viewMode=' + mode + ';max-age=' + cookie_age + ';path=/';
  location.reload();
}


//投稿ページ用
function escape_html (string) {
  if(typeof string !== 'string') {
    return string;
  }
  return string.replace(/[&'`"<>]/g, function(match) {
    return {
      '&': '&amp;',
      "'": '&#x27;',
      '`': '&#x60;',
      '"': '&quot;',
      '<': '&lt;',
      '>': '&gt;',
    }[match]
  });
}

function inputCheck() {
  let inputValue = document.getElementById( 'posting-contents' ).value;
  let end ='';
  if( inputValue == '' ) inputValue = 'ここにプレビューが表示されます';
  if( inputValue.length >= 88 )end = '...';
  document.getElementById( 'realtime-contents' ).innerHTML =  escape_html( inputValue.substr(0, 89) + end);
}

function dateCheckBox() {
  let sData = document.getElementById( 'sDate' );
  let sTime = document.getElementById( 'sTime' );
  let setSc = document.getElementById( 'set-scheduled' );
  let reaSc = document.getElementById( 'realtime-scheduled' );
  if (setChekBox.checked){
    sDate.value = year + '-' + month + '-' + day;
    sTime.value ='00:00:00';
    setSc.style.display  = 'none';
    reaSc.innerHTML = '予定日：未設定';
  } else {
    let inputDate = sDate.value;
    let inputTime = sTime.value;
    setSc.style.display  = 'inline';
    reaSc.innerHTML = '予定日：' + inputDate + ' ' + inputTime;
  }
}

//アカウント削除関連
function deleteCheck(){
  let delbtn = document.getElementById('deletebutton');
  let deletepin = document.getElementById( 'deletepin' ).textContent;
  let typpin   = document.getElementById( 'typdeletepin' ).value;
  if(deletepin == typpin){
    delbtn.style.display = 'inline';
  }else{
    delbtn.style.display = 'none';
  }
}

function accountDelete( pin ){
  if(window.confirm("本当にアカウントを削除しますか？")){
    var postData = {'mode':'getKey', 'ans':'true'};
    $.post(
      '/login',
      postData,
      function(data){
        if(data=='0') alert('お試しアカウントなので削除はされませんでした');
        else {
          var postData = {'mode':'delete', 'key':data};
          $.post(
            '/login',
            postData,
            function(data){
              doLogout('1005');
            }
          );
        }
      }
    );
  }
}
