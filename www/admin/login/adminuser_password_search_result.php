<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Admin 로그아웃 체크
admin_logout_check();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/header.php");
// require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/nav.php");

tp_read();

// 경로
tp_set("menu_navigator", get_menu_navigator());

$au_loginid	=   trim($_POST["au_loginid"]);
$au_name  	=   trim($_POST["au_name"]);
$au_email	=   trim($_POST["au_email"]);
$au_mobile	=   number_only(trim($_POST["au_mobile"]));		// '휴대폰'' 숫자만 남김

// 관리자 비밀번호 찾기
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
$query .= "and au_loginid = '" . $au_loginid . "' ";
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

tp_set("au_loginid", $row["au_loginid"]);
tp_set("au_name", $row["au_name"]);
tp_set("au_email", $row["au_email"]);
tp_set("au_mobile", $row["au_mobile"]);


// 관리자 비밀번호 초기화
$au_id 			=	$row["au_id"];
$au_password	=	init_adminuser_password($au_id);

// tp_set("au_password_result", $au_password);
tp_set("au_password_result", "초기화된 비밀번호를 이메일로 발송했습니다.");

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

$to 		=	$row["au_name"] . "<" . $row["au_email"] . ">";
$from 		= 	$SITE_VAR["name"] . "<" . $SITE_VAR["email"] . ">";

$subject    = 	$EMAIL_VAR["title_search_password"];
$subject    =   str_replace("{user_name}", $row["au_name"], $subject);

$body       =   $EMAIL_VAR["content_search_password"];
$body       =   str_replace("{user_name}", $row["au_name"], $body);
$body       =   str_replace("{user_password}", $au_password, $body);

/* 메일 보내기 */ 
$sendmail->send_mail($to, $from, $subject, $body, $cc_mail, $bcc_mail);

alert("초기화된 비밀번호를 이메일로 발송했습니다.");

// 이메일 발송
////////////////////////////////////////////////////////////////////////////////

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/footer.php");

?>