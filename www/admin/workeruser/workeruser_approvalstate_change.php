<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Admin 로그인 체크
admin_login_check();
adminuser_menu_check();
html_meta_charset_utf8();

$wu_id              =   trim($_POST["wu_id"]);
$wu_approvalstate   =   trim($_POST["wu_approvalstate"]);

// 승인상태 변경
$query = "update workeruser_tb set ";
$query .= "wu_approvalstate = '" . $wu_approvalstate . "' ";
$query .= "where wu_id = '" . $wu_id . "' ";
$query .= "limit 1 ";

if ($result = db_query($query)) {
    alert("변경되었습니다.");
}
else {
    alert_back("변경하는데 실패했습니다."); 
}

// 페이지 이동
$location_href = "workeruser_view.php?dummy=dummy";
$location_href .= "&search_wu_approvalstate=" . $_REQUEST["search_wu_approvalstate"];
$location_href .= "&search_wu_usestate=" . $_REQUEST["search_wu_usestate"];
$location_href .= "&search_type=" . $_REQUEST["search_type"];
$location_href .= "&search_keyword=" . urlencode($_REQUEST["search_keyword"]);
$location_href .= "&page=" . $_REQUEST["page"];
$location_href .= "&wu_id=" . $_REQUEST["wu_id"];
location_href($location_href);

?>