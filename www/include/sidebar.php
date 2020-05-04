<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

tp_read($_SERVER["DOCUMENT_ROOT"] . "/include/sidebar.html");

// Parent Menu Name (User)
$parent_menu_name = get_parent_menu_name();
tp_set("parent_menu_name", $parent_menu_name);

// Sidebar Menu List
$sidebar_menu_list = get_sidebar_menu_list($parent_menu_name);
tp_set("sidebar_menu_list", $sidebar_menu_list);

tp_print();

?>