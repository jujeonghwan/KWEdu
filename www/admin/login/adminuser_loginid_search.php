<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Admin 로그아웃 체크
admin_logout_check();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/header.php");
// require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/nav.php");

tp_read();

// 경로
tp_set("menu_navigator", get_menu_navigator());

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/footer.php");

?>