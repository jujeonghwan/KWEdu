<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Admin 로그인 체크
admin_login_check();
adminuser_menu_check();
html_meta_charset_utf8();

$m_id	=   trim($_POST["m_id"]);

// 삭제
$query = "delete from menu_tb ";
$query .= "where m_id = '" . $m_id . "' ";
$query .= "limit 1 ";

if ($result = db_query($query)) {
    alert("삭제되었습니다.");
}
else {
    alert_back("삭제하는데 실패했습니다."); 
}

// 페이지 이동
$location_href = "worker_menu_list.php?dummy=dummy";
$location_href .= "&search_m_id_1=" . $_REQUEST["search_m_id_1"];
$location_href .= "&search_m_usestate=" . $_REQUEST["search_m_usestate"];
location_href($location_href);

?>