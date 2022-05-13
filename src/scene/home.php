<?php

$putTitle = SITE_NAME.' - ホーム';
$putDesc  = SITE_NAME.'のホームです';
$mso = new MSO();
$start =  ($page_data['data'] * 12);
$putHtml_tmp = setPost($mso, $start, 12,$user_data[0]['uid']);
$putHtml = $putHtml_tmp[0];
$modal_html = $putHtml_tmp[1];
$putHtml .= chaseMenu(1,$mso, $page_data['data']);
//$putHtml .= buttonPageMove($mso, $page_data['data']);
