<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// User 로그아웃 체크
user_logout_check();
html_meta_charset_utf8();

$u_name               	=	trim($_POST["join_u_name"]);
$u_firstname          	=	trim($_POST["join_u_firstname"]);
$u_lastname           	=	trim($_POST["join_u_lastname"]);
$u_preferredname      	=	trim($_POST["join_u_preferredname"]);
$u_loginid            	=	trim($_POST["join_u_loginid"]);
$u_password           	=	trim($_POST["join_u_password"]);
$u_birthdate          	=	trim($_POST["join_u_birthdate_year"]) . trim($_POST["join_u_birthdate_month"]) . trim($_POST["join_u_birthdate_day"]);
$u_email              	=	trim($_POST["join_u_email"]);
$u_gendertype         	=	trim($_POST["join_u_gendertype"]);
$u_contryofbirth      	=	trim($_POST["join_u_contryofbirth"]);
$u_contryofcitizenship	=	trim($_POST["join_u_contryofcitizenship"]);
$u_passportnumber     	=	trim($_POST["join_u_passportnumber"]);
$u_usestate           	=	$db_u_usestate_array["사용"];
$u_logindatetime      	=	"";

// 등록 (회원 가입)
$query = "insert into user_tb ( ";
$query .= "u_name, ";
$query .= "u_firstname, ";
$query .= "u_lastname, ";
$query .= "u_preferredname, ";
$query .= "u_loginid, ";
$query .= "u_password, ";
$query .= "u_birthdate, ";
$query .= "u_email, ";
$query .= "u_gendertype, ";
$query .= "u_contryofbirth, ";
$query .= "u_contryofcitizenship, ";
$query .= "u_passportnumber, ";
$query .= "u_usestate, ";
$query .= "u_logindatetime ";
$query .= ") values ( ";
$query .= "'" . $u_name . "', ";
$query .= "'" . $u_firstname . "', ";
$query .= "'" . $u_lastname . "', ";
$query .= "'" . $u_preferredname . "', ";
$query .= "'" . $u_loginid . "', ";
$query .= "password('" . $u_password . "'), ";
$query .= "'" . $u_birthdate . "', ";
$query .= "'" . $u_email . "', ";
$query .= "'" . $u_gendertype . "', ";
$query .= "'" . $u_contryofbirth . "', ";
$query .= "'" . $u_contryofcitizenship . "', ";
$query .= "'" . $u_passportnumber . "', ";
$query .= "'" . $u_usestate . "', ";
$query .= "'" . $u_logindatetime . "' ";
$query .= ")";

if ($result = db_query($query)) {    
    alert("회원 가입완료되었습니다.");
}
else {
    alert_back("회원 가입완료하는데 실패했습니다."); 
}

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

$to 		=	$u_name . "<" . $u_email . ">";
$from 		= 	$SITE_VAR["name"] . "<" . $SITE_VAR["email"] . ">";

$subject    = 	$EMAIL_VAR["title_user_join"];
$subject    =   str_replace("{u_name}", $u_name, $subject);

$body       =   $EMAIL_VAR["content_user_join"];
$body       =   str_replace("{u_name}", $u_name, $body);
$body       =   str_replace("{u_firstname}", $u_firstname, $body);
$body       =   str_replace("{u_lastname}", $u_lastname, $body);
$body       =   str_replace("{u_preferredname}", $u_preferredname, $body);
$body       =   str_replace("{u_loginid}", $u_loginid, $body);
$body       =   str_replace("{u_password}", $u_password, $body);
$body       =   str_replace("{u_birthdate_year}", get_year_format($u_birthdate), $body);
$body       =   str_replace("{u_birthdate_month}", get_month_format($u_birthdate), $body);
$body       =   str_replace("{join_u_birthdate_day}", get_day_format($u_birthdate), $body);
$body       =   str_replace("{u_email}", $u_email, $body);
$body       =   str_replace("{u_gendertype}", array_search($u_gendertype, $db_u_gendertype_array), $body);
$body       =   str_replace("{u_contryofbirth}", $u_contryofbirth, $body);
$body       =   str_replace("{u_contryofcitizenship}", $u_contryofcitizenship, $body);
$body       =   str_replace("{u_passportnumber}", $u_passportnumber, $body);
$body       =   str_replace("{site_url}", $SITE_VAR["url"], $body);

/* 메일 보내기 */ 
$sendmail->send_mail($to, $from, $subject, $body, $cc_mail, $bcc_mail);

// alert("이메일을 발송했습니다.");

// 이메일 발송
////////////////////////////////////////////////////////////////////////////////

// 페이지 이동
$location_href = $PATH_VAR["user_default_url"];
location_href($location_href);

?>