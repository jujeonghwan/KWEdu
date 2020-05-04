<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Admin 로그인 체크
admin_login_check();
adminuser_menu_check();
html_meta_charset_utf8();

$u_id                   =   trim($_POST["u_id"]);
$u_firstname            =   trim($_POST["u_firstname"]);
$u_lastname    	        =   trim($_POST["u_lastname"]);
$u_preferredname        =   trim($_POST["u_preferredname"]);

$u_email                =   trim($_POST["u_email"]);
$u_contryofbirth        =   trim($_POST["u_contryofbirth"]);
$u_contryofcitizenship  =   trim($_POST["u_contryofcitizenship"]);
$u_passportnumber       =   trim($_POST["u_passportnumber"]);

$u_usestate             =   trim($_POST["u_usestate"]);

// 수정
$query = "update user_tb set ";
$query .= "u_firstname = '" . $u_firstname . "', ";
$query .= "u_lastname = '" . $u_lastname . "', ";
$query .= "u_preferredname = '" . $u_preferredname . "', ";

$query .= "u_email = '" . $u_email . "', ";
$query .= "u_contryofbirth = '" . $u_contryofbirth . "', ";
$query .= "u_contryofcitizenship = '" . $u_contryofcitizenship . "', ";
$query .= "u_passportnumber = '" . $u_passportnumber . "', ";

$query .= "u_usestate = '" . $u_usestate . "' ";
$query .= "where u_id = '" . $u_id . "' ";
$query .= "limit 1 ";

if ($result = db_query($query)) {
	alert("수정되었습니다.");
}
else {
    alert_back("수정하는데 실패했습니다."); 
}

// 페이지 이동
$location_href = "user_list.php?dummy=dummy";
$location_href .= "&search_u_usestate=" . $_REQUEST["search_u_usestate"];
$location_href .= "&search_type=" . $_REQUEST["search_type"];
$location_href .= "&search_keyword=" . urlencode($_REQUEST["search_keyword"]);
$location_href .= "&page=" . $_REQUEST["page"];
location_href($location_href);

?>