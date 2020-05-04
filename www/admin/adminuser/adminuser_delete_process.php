<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Admin 로그인 체크
admin_login_check();
adminuser_menu_check();
html_meta_charset_utf8();

$au_id	=   trim($_POST["au_id"]);

// 삭제
$query = "delete from adminuser_tb ";
$query .= "where au_id = '" . $au_id . "' ";
$query .= "limit 1 ";

if ($result = db_query($query)) {
    alert("삭제되었습니다.");
}
else {
    alert_back("삭제하는데 실패했습니다."); 
}

// 페이지 이동
$location_href = "adminuser_list.php?dummy=dummy";
$location_href .= "&search_au_usestate=" . $_REQUEST["search_au_usestate"];
$location_href .= "&search_type=" . $_REQUEST["search_type"];
$location_href .= "&search_keyword=" . urlencode($_REQUEST["search_keyword"]);
$location_href .= "&page=" . $_REQUEST["page"];
location_href($location_href);

?>