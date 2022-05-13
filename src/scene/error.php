<?php
global $cst;
$putHtml .="<div class=\"main-message-box\">\n";
switch($page_data['data']){
  case 400:
    $putTitle = SITE_NAME.' - 無効なリクエスト(400 Bad Request)';
    $putHtml  .= "  <p>リクエストの解析に失敗しました。(400 Bad Request)</p>\n  <p><a href=\"{$cst(BASEURL)}home\">ホームへ</a></p>";
    break;

  case 401:
    $putTitle = SITE_NAME.' - 認証エラー(401 Unauthorized)';
    $putHtml  .= "  <p>認証に失敗しました。(401 Unauthorized)</p>\n  <p><a href=\"{$cst(BASEURL)}home\">ホームへ</a></p>";
    break;

  case 403:
    $putTitle = SITE_NAME.' - アクセス制限(403 Forbidden)';
    $putHtml  .= "  <p>このページは閲覧できません。(403 Forbidden)</p>\n  <p><a href=\"{$cst(BASEURL)}home\">ホームへ</a></p>";
    break;

  case 500:
    $putTitle = SITE_NAME.' - サーバーエラー(500 Internal Server Error)';
    $putHtml  .= "  <p>サーバープログラムに致命的なエラーが発生しております。(500 Internal Server Error)</p>\n  <p><a href=\"{$cst(BASEURL)}home\">ホームへ</a></p>";
    break;

  case 503:
    $putTitle = SITE_NAME.' - アクセス集中(503 Service Unavailable)';
    $putHtml  .= "  <p>アクセスが集中しています。再度時間をおいてアクセスしてください。(503 Service Unavailable)</p>\n  <p><a href=\"{$cst(BASEURL)}home\">ホームへ</a></p>";
    break;

  case 404:
  default:
    $putTitle = SITE_NAME.' - ページが見つかりません(404 Not Found)';
    $putHtml  .= "  <p>ページが見つかりませんでした。(404 Not Found)</p>\n  <p><a href=\"{$cst(BASEURL)}home\">ホームへ</a></p>";


  break;
}
$putHtml .='</div>';
$putDesc  = '';
