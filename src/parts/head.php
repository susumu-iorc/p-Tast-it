<?php
function headSet($title, $discription, $header){
  global $cst;
  echo <<< EOF
  <!DOCTYPE html>
  <html lang="ja">
    <head>
      <meta charset="UTF-8">
      <title>{$title}</title>
      <meta name="viewport" content="width=device-width">
      <meta name="discription" content="{$discription}">
      <meta http-equiv="Cache-Control" content="no-cache">
      <link href="{$cst(FONT_CSS_PATH)}" rel="stylesheet" type="text/css">
      <link href="{$cst(STYLE_CSS_PATH)}" rel="stylesheet" type="text/css">
    </head>
    <body>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{$cst(JS_PATH)}"></script>
    <header>
      <h1><a href="{$cst(BASEURL)}">{$header}</a></h1>
    </header>
    <div id="contents">
      <div id="main">

  EOF;
}
