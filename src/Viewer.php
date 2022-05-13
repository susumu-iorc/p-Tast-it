<?php
headSet($putTitle, $putDesc, SITE_NAME);
echo $putHtml;
if($page_data['type']=="home"){
  if($is_login)
    menuSet();
  else
    loginMenu();
} else echo"</div>";
if(!empty($modal_html)) echo $modal_html;
footSet();
