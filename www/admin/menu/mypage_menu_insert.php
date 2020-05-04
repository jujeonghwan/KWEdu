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
tp_set("search_m_id_1", $_REQUEST["search_m_id_1"]);
tp_set("search_m_usestate", $_REQUEST["search_m_usestate"]);


// QUERY_STRING
$QUERY_STRING = "dummy=dummy";
$QUERY_STRING .= "&search_m_id_1=" . $_REQUEST["search_m_id_1"];
$QUERY_STRING .= "&search_m_usestate=" . $_REQUEST["search_m_usestate"];

// 목록보기 버튼 링크
$list_link_href = "mypage_menu_list.php?" . $QUERY_STRING;
tp_set("list_link_href", $list_link_href);


// 메뉴단계
$radio_array = array_flip($db_m_step_array);
$radio = get_input_radio("m_step", $radio_array, "", "");
tp_set("radio_m_step", $radio);

// 사용상태
$radio_array = array_flip($db_m_usestate_array);
$radio = get_input_radio("m_usestate", $radio_array, $db_m_usestate_array["사용"], $color_m_usestate_array);
tp_set("radio_m_usestate", $radio);

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/footer.php");

?>