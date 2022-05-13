<?php

require_once 'Tools.php';
require_once 'config.php';
require_once 'database/dbLib.php';
require_once 'parts/index.php';


$icon_path = BASEURL.'icon/';
$page_data['type'] = extGet('pageType');
$page_data['data'] = extGet('pageData');
$page_data['sort'] = ($tmp = extCookie("viewMode")) ? $tmp : 0;
$putTitle = NULL;
$putDesc  = NULL;
$putHtml  = NULL;
