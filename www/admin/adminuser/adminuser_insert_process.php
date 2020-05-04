<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Admin 로그인 체크
admin_login_check();
adminuser_menu_check();
html_meta_charset_utf8();

$au_name   			=   trim($_POST["au_name"]);
$au_loginid 		=   trim($_POST["au_loginid"]);
$au_password		=   trim($_POST["au_password"]);
$au_email     		=   trim($_POST["au_email"]);
$au_mobile     		=   trim($_POST["au_mobile"]);
$au_usestate  		=   trim($_POST["au_usestate"]);
$au_logindatetime	=	"";

// 등록
$query = "insert into adminuser_tb ( ";
$query .= "au_name, ";
$query .= "au_loginid, ";
$query .= "au_password, ";
$query .= "au_email, ";
$query .= "au_mobile, ";
$query .= "au_usestate, ";
$query .= "au_logindatetime ";
$query .= ") values ( ";
$query .= "'" . $au_name . "', ";
$query .= "'" . $au_loginid . "', ";
$query .= "password('" . $au_password . "'), ";
$query .= "'" . $au_email . "', ";
$query .= "'" . $au_mobile . "', ";
$query .= "'" . $au_usestate . "', ";
$query .= "'" . $au_logindatetime . "' ";
$query .= ")";   

if ($result = db_query($query)) {    
    alert("등록되었습니다.");
}
else {
    alert_back("등록하는데 실패했습니다."); 
}

// 페이지 이동
$location_href = "adminuser_list.php?dummy=dummy";
$location_href .= "&search_au_usestate=" . $_REQUEST["search_au_usestate"];
$location_href .= "&search_type=" . $_REQUEST["search_type"];
$location_href .= "&search_keyword=" . urlencode($_REQUEST["search_keyword"]);
$location_href .= "&page=" . $_REQUEST["page"];
location_href($location_href);

?>