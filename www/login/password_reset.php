<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// User 로그아웃 체크
// user_logout_check();
html_meta_charset_utf8();

$u_name		=   trim($_POST["reset_u_name"]);
$u_email	=   trim($_POST["reset_u_email"]);

// 회원(사용자)
$query = "select ";
$query .= "u_id, ";
$query .= "u_name, ";
$query .= "u_loginid, ";
$query .= "u_password, ";
$query .= "u_email, ";
$query .= "u_usestate ";
$query .= "from user_tb ";
$query .= "where u_name = '" . $u_name . "' ";
$query .= "and u_email = '" . $u_email . "' ";

$result = db_query($query);

if (!$row = db_fetch_array($result)) {
    alert_back("입력한 정보가 정확하지 않습니다.");       
}

if ($row["u_usestate"] != $db_u_usestate_array["사용"]) {
	alert_back("해당 회원(사용자)의 '사용상태'가 '사용'중이 아닙니다."); 
}


// 회원(사용자) 비밀번호 초기화
$u_id 		=	$row["u_id"];
$u_password	=	init_user_password($u_id);

////////////////////////////////////////////////////////////////////////////////
// 이메일 발송
// require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/sendmail.inc.php");

/* 클래스 파일 로드 */ 
// include "sendmail.inc.php";

/* 클래스 객체 변수 선언 */ 
$sendmail = new Sendmail();

/* 
 + $to : 받는사람 메일주소 ( ex. $to="hong <hgd@example.com>" 으로도 가능) 
 + $from : 보내는사람 이름 
 + $subject : 메일 제목 
 + $body : 메일 내용 
 + $cc_mail : Cc 메일 있을경우 (옵션값으로 생략가능) 
 + $bcc_mail : Bcc 메일이 있을경우 (옵션값으로 생략가능) 
*/ 

$to 		=	$row["u_name"] . "<" . $row["u_email"] . ">";
$from 		= 	$SITE_VAR["name"] . "<" . $SITE_VAR["email"] . ">";

$subject    = 	$EMAIL_VAR["title_user_password_reset"];
$subject    =   str_replace("{u_name}", $row["u_name"], $subject);

$body       =   $EMAIL_VAR["content_user_password_reset"];
$body       =   str_replace("{u_name}", $row["u_name"], $body);
$body       =   str_replace("{u_password}", $u_password, $body);
$body       =   str_replace("{site_url}", $SITE_VAR["url"], $body);

/* 메일 보내기 */ 
$sendmail->send_mail($to, $from, $subject, $body, $cc_mail, $bcc_mail);

alert("초기화된 비밀번호를 이메일로 발송했습니다.");

// 이메일 발송
////////////////////////////////////////////////////////////////////////////////

// 페이지 이동
$location_href = $PATH_VAR["user_default_url"];
location_href($location_href);

?>