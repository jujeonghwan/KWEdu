<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Admin 로그인 체크
admin_login_check();
adminuser_menu_check();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/header.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/nav.php");

tp_read();

// 경로
tp_set("menu_navigator", get_menu_navigator());


// 목록 페이지 조회조건
tp_set("search_au_usestate", $_REQUEST["search_au_usestate"]);
tp_set("search_type", $_REQUEST["search_type"]);
tp_set("search_keyword", $_REQUEST["search_keyword"]);
tp_set("page", $_REQUEST["page"]);


// QUERY_STRING
$QUERY_STRING = "dummy=dummy";
$QUERY_STRING .= "&search_au_usestate=" . $_REQUEST["search_au_usestate"];
$QUERY_STRING .= "&search_type=" . $_REQUEST["search_type"];
$QUERY_STRING .= "&search_keyword=" . urlencode($_REQUEST["search_keyword"]);
$QUERY_STRING .= "&page=" . $_REQUEST["page"];

// 목록보기 버튼 링크
$list_link_href = "adminuser_list.php?" . $QUERY_STRING;
tp_set("list_link_href", $list_link_href);


// 사용상태
$radio_array = array_flip($db_au_usestate_array);
$radio = get_input_radio("au_usestate", $radio_array, "", $color_au_usestate_array);
tp_set("radio_au_usestate", $radio);

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/footer.php");

?>