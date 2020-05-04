<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Admin 로그인 체크
admin_login_check();
adminuser_menu_check();
html_meta_charset_utf8();

$m_id_1 =   trim($_REQUEST["m_id"]);
$m_id_2 =   trim($_REQUEST["prev_m_id"]);


// 기존순서 구함(1)
$query = "select ";
$query .= "m_order as m_order_1 ";
$query .= "from menu_tb ";
$query .= "where m_id = '" . $m_id_1 . "' ";

$result = db_query($query);

if ($row = db_fetch_array($result)) {
    $m_order_2 = $row["m_order_1"];     // 순서 바꿈
}

// 기존순서 구함(2)
$query = "select ";
$query .= "m_order as m_order_2 ";
$query .= "from menu_tb ";
$query .= "where m_id = '" . $m_id_2 . "' ";

$result = db_query($query);

if ($row = db_fetch_array($result)) {
    $m_order_1 = $row["m_order_2"];     // 순서 바꿈
}


// 순서 변경(1)
$query = "update menu_tb set ";
$query .= "m_order = '" . $m_order_1 . "' ";
$query .= "where m_id = '" . $m_id_1 . "' ";
$query .= "limit 1 ";

db_query($query);

// 순서 변경(2)
$query = "update menu_tb set ";
$query .= "m_order = '" . $m_order_2 . "' ";
$query .= "where m_id = '" . $m_id_2 . "' ";
$query .= "limit 1 ";

db_query($query);


// 페이지 이동
$location_href = "worker_menu_list.php?dummy=dummy";
$location_href .= "&search_m_id_1=" . $_REQUEST["search_m_id_1"];
$location_href .= "&search_m_usestate=" . $_REQUEST["search_m_usestate"];
location_href($location_href);

?>