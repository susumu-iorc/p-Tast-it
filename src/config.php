<?php
$cst = function($s){return $s;};
define ('SITE_NAME'     , 'SERVICENAME' );
define ('SITE_OWNER'    , 'OWNER'     );

//外部ファイル設定
define ('FONT_CSS_FILE' , 'font.css'  );
define ('STYLE_CSS_FILE', 'style.css' );
define ('JS_FILE'       , 'script.js'  );

// データベース設定
define('DBNAME','database' );
define('DBHOST','mysql');
define('DBUSER','USER');
define('DBPSWD','PASSWORD');

define('DBCHAR','utf8mb4');
define('DSN',"mysql:dbname={$cst(DBNAME)};host={$cst(DBHOST)};charset={$cst(DBCHAR)}");


define ('BASEURL', (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] .'/');
define ('FONT_CSS_PATH' , BASEURL . FONT_CSS_FILE  );
define ('STYLE_CSS_PATH', BASEURL . STYLE_CSS_FILE );
define ('JS_PATH', BASEURL . JS_FILE );

//google oauth
// アプリケーション設定
define('CONSUMER_KEY', 'xxxxxxxxxxx-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.apps.googleusercontent.com');
//実行環境でこちらをかえる
define('CALLBACK_URL', 'https://example.com/oauth.php');
define('CONSUMER_SECRET', 'xxxxxx-xxxxxxxxxxxxxxxxxxxxxx_xxxxx');
// URL
define('AUTH_URL', 'https://accounts.google.com/o/oauth2/auth');
// URL
define('TOKEN_URL', 'https://accounts.google.com/o/oauth2/token');
define('INFO_URL', 'https://www.googleapis.com/oauth2/v1/userinfo');
