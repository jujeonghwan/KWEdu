<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Admin 로그아웃 체크
admin_logout_check();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/header.php");
// require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/nav.php");

tp_read();

// 경로
tp_set("menu_navigator", get_menu_navigator());

$au_name  	=   trim($_POST["au_name"]);
$au_email	=   trim($_POST["au_email"]);
$au_mobile	=   number_only(trim($_POST["au_mobile"]));		// '휴대폰'' 숫자만 남김

// 관리자 아이디 찾기
$query = "select ";
$query .= "au_id, ";
$query .= "au_name, ";
$query .= "au_loginid, ";
$query .= "au_password, ";
$query .= "au_email, ";
$query .= "au_mobile, ";
$query .= "au_usestate, ";
$query .= "au_logindatetime ";
$query .= "from adminuser_tb ";
$query .= "where au_name = '" . $au_name . "' ";
$query .= "and au_email = '" . $au_email . "' ";
// $query .= "and au_mobile = '" . $au_mobile . "' ";
$query .= "and replace(replace(replace(au_mobile, '-', ''), '/', ''), ' ', '') = '" . $au_mobile . "' ";				// '휴대폰' 숫자만 비교

$result = db_query($query);

if (!$row = db_fetch_array($result)) {
    alert_back("입력한 정보가 정확하지 않습니다.");       
}

if ($row["au_usestate"] != $db_au_usestate_array["사용"]) {
	alert_back("해당 관리자의 '사용상태'가 '사용'중이 아닙니다."); 
}

tp_set("au_name", $row["au_name"]);
tp_set("au_email", $row["au_email"]);
tp_set("au_mobile", $row["au_mobile"]);
tp_set("au_loginid", $row["au_loginid"]);

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/footer.php");

?>