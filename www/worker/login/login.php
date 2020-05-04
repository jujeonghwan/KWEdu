<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Worker 로그아웃 체크
worker_logout_check();

////////////////////////////////////////////////////////////////////////////////
// 담당자 계정 체크

$query = "select ";
$query .= "wu_id, ";
$query .= "wu_name, ";
$query .= "wu_firstname, ";
$query .= "wu_lastname, ";
$query .= "wu_preferredname, ";
$query .= "wu_loginid, ";
$query .= "wu_password, ";
$query .= "wu_email, ";
$query .= "wu_approvalstate, ";
$query .= "wu_usestate, ";
$query .= "wu_logindatetime ";
$query .= "from workeruser_tb ";
$query .= "where wu_loginid = '" . trim($_POST["wu_loginid"]) . "' ";
$query .= "and wu_password = password('" . trim($_POST["wu_password"]) . "') ";

$result = db_query($query);

// 아이디,비밀번호 체크
if (!$row = db_fetch_array($result)) {
    alert_back("아이디 또는 비밀번호가 정확하지 않습니다.");       
}

/*
// 담당자 승인상태 체크
if ($row["wu_approvalstate"] != $db_wu_approvalstate_array["승인완료"]) {
    alert_back("담당자 승인상태가 미승인 중입니다.");       
}

// 담당자 사용상태 체크
if ($row["wu_usestate"] != $db_wu_usestate_array["사용"]) {
    alert_back("담당자 사용상태가 중지 중입니다.");       
}
*/

////////////////////////////////////////////////////////////////////////////////
// 쿠키설정(아이디)

// 담당자 아이디
if (trim($_POST["wu_loginid_save"]) == "remember-me")
{
	$cookie_wu_loginid = $row["wu_loginid"];
}
else
{
	$cookie_wu_loginid = "";
}

$expire = 60 * 60 * 24 * 10;            // 10일
setcookie("cookie_wu_loginid", $cookie_wu_loginid, time() + $expire, "/", "");


////////////////////////////////////////////////////////////////////////////////
// 세션설정
$_SESSION["session_wu_id"] = $row["wu_id"];
$_SESSION["session_wu_name"] = $row["wu_name"];
$_SESSION["session_wu_loginid"] = $row["wu_loginid"];


////////////////////////////////////////////////////////////////////////////////
// 로그인일시 저장
$wu_logindatetime = current_datetime();

$query = "update workeruser_tb set ";
$query .= "wu_logindatetime = '" . $wu_logindatetime . "' ";
$query .= "where wu_loginid = '" . trim($_POST["wu_loginid"]) . "' ";
$query .= "limit 1 ";

db_query($query);

alert("담당자 로그인되었습니다.");

// 페이지 이동
top_location_href($PATH_VAR["worker_default_url"]);

?>