<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Admin 로그아웃 체크
admin_logout_check();

////////////////////////////////////////////////////////////////////////////////
// 관리자 계정 체크

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
$query .= "where au_loginid = '" . trim($_POST["au_loginid"]) . "' ";
$query .= "and au_password = password('" . trim($_POST["au_password"]) . "') ";

$result = db_query($query);

// 아이디,비밀번호 체크
if (!$row = db_fetch_array($result)) {
    alert_back("아이디 또는 비밀번호가 정확하지 않습니다.");       
}

// 관리자 사용상태 체크
if ($row["au_usestate"] != $db_au_usestate_array["사용"]) {
    alert_back("관리자 사용상태가 중지 중입니다.");       
}


////////////////////////////////////////////////////////////////////////////////
// 쿠키설정(아이디)

// 관리자 아이디
if (trim($_POST["au_loginid_save"]) == "remember-me")
{
	$cookie_au_loginid = $row["au_loginid"];
}
else
{
	$cookie_au_loginid = "";
}

$expire = 60 * 60 * 24 * 10;            // 10일
setcookie("cookie_au_loginid", $cookie_au_loginid, time() + $expire, "/", "");


////////////////////////////////////////////////////////////////////////////////
// 세션설정
$_SESSION["session_au_id"] = $row["au_id"];
$_SESSION["session_au_name"] = $row["au_name"];
$_SESSION["session_au_loginid"] = $row["au_loginid"];


////////////////////////////////////////////////////////////////////////////////
// 로그인일시 저장
$au_logindatetime = current_datetime();

$query = "update adminuser_tb set ";
$query .= "au_logindatetime = '" . $au_logindatetime . "' ";
$query .= "where au_loginid = '" . trim($_POST["au_loginid"]) . "' ";
$query .= "limit 1 ";

db_query($query);

alert("관리자 로그인되었습니다.");

// 페이지 이동
top_location_href($PATH_VAR["admin_default_url"]);

?>