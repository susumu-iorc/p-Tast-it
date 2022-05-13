<?php
require_once('init.php');

$mso = new MSO();
$user_icon = $mso -> getIcon();

$page_data['type']   = extGet('pageType');
$page_data['data'] = extGet('pageData');

$options['ssl']['verify_peer']=false;
$options['ssl']['verify_peer_name']=false;

switch($page_data['type']){
  case 'icon':
    if(isset($user_icon[$page_data['data']])){
      $imgPath = "img/{$user_icon[$_GET['pageData']]}";
      $data = file_get_contents($imgPath, false, stream_context_create($options));
      header('Content-type: image/png');
      echo $data;
    }
    else viewErrorPage(404);
    break;

  case 'ui':
    header('Content-Type: image/svg+xml');
    header('Vary: Accept-Encoding');
    echo file_get_contents('img/menu-onoff.svg', false, stream_context_create($options));
    break;

  default:
    viewErrorPage(404);
    break;
}
