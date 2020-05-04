<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// User 로그아웃 체크
user_logout_check();

////////////////////////////////////////////////////////////////////////////////
// 사용자 계정 체크

$query = "select ";
$query .= "u_id, ";
$query .= "u_name, ";
$query .= "u_loginid, ";
$query .= "u_password, ";
$query .= "u_email, ";
$query .= "u_usestate, ";
$query .= "u_logindatetime ";
$query .= "from user_tb ";
$query .= "where u_loginid = '" . trim($_POST["u_loginid"]) . "' ";
$query .= "and u_password = password('" . trim($_POST["u_password"]) . "') ";

$result = db_query($query);

// 아이디,비밀번호 체크
if (!$row = db_fetch_array($result)) {
    alert_back("아이디 또는 비밀번호가 정확하지 않습니다.");       
}

// 사용자 사용상태 체크
if ($row["u_usestate"] != $db_u_usestate_array["사용"]) {
    alert_back("사용자 사용상태가 중지 중입니다.");       
}


////////////////////////////////////////////////////////////////////////////////
// 쿠키설정(아이디)

// 사용자 아이디
if (trim($_POST["u_loginid_save"]) == "remember-me")
{
	$cookie_u_loginid = $row["u_loginid"];
}
else
{
	$cookie_u_loginid = "";
}

$expire = 60 * 60 * 24 * 10;            // 10일
setcookie("cookie_u_loginid", $cookie_u_loginid, time() + $expire, "/", "");


////////////////////////////////////////////////////////////////////////////////
// 세션설정
$_SESSION["session_u_id"] = $row["u_id"];
$_SESSION["session_u_name"] = $row["u_name"];
$_SESSION["session_u_loginid"] = $row["u_loginid"];


////////////////////////////////////////////////////////////////////////////////
// 로그인일시 저장
$u_logindatetime = current_datetime();

$query = "update user_tb set ";
$query .= "u_logindatetime = '" . $u_logindatetime . "' ";
$query .= "where u_loginid = '" . trim($_POST["u_loginid"]) . "' ";
$query .= "limit 1 ";

db_query($query);

alert("회원 로그인되었습니다.");

// 페이지 이동
top_location_href($PATH_VAR["user_default_url"]);

?>