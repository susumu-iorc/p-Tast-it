<?php
//未使用
$mso = new MSO();
$prf = $mso -> getUserProfile($page_data['data']);
if($prf[0]['uid']!=$page_data['data']){
  $putTitle = '存在しないアカウント'.SITE_NAME;
  $putDesc  = 'このアカウントは存在しません';
  $putHtml = "このアカウントは存在しません";
  http_response_code( 404 ) ;
}else{
  $putTitle = $prf[0]['name'].'　さんのプロフィール - '.SITE_NAME;
  $putDesc  = 'このアカウントは存在しません';
  $putHtml .= "<h2><img src=\"{$icon_path}{$page_data['data']}\" alt=\"{$prf[0]["name"]}\" title=\"{$prf[0]["name"]}\">{$prf[0]["name"]}</h2>\n<p></p><p>{$mso -> getPostNum($page_data['data'])}件の投稿があります</p>";
  $putHtml .= setPost($mso, $mso -> getPostNum($page_data['data']), 100, $page_data['data'],)[0];
}
