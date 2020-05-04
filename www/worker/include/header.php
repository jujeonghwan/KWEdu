<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

tp_read($_SERVER["DOCUMENT_ROOT"] . "/worker/include/header.html");

// 타이틀
tp_set("title", $SITE_VAR["title"]);

// CSS
tp_set("css_link_list", $css_link_list);

tp_print();

?>