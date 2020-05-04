<?php

// Session start
session_start();

// 쿠키허용 설정
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"'); 

// DB
require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/db.inc.php");

// Constant
require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/constant.inc.php");

// Function
require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/function.inc.php");

// Site Function
require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/site.inc.php");

// Template
require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/template.inc.php");

// Email
$include_mail_array = array (
    "/admin/login/adminuser_password_search_result.php",	// 관리자 비밀번호 찾기
    "/login/password_reset.php",                            // 사용자 비밀번호 초기화
    "/user/user_join_process.php",                          // 사용자 회원 가입
    "_"
);
if (in_array($_SERVER["PHP_SELF"], $include_mail_array)) {
    require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/sendmail.inc.php");
}


////////////////////////////////////////////////////////////////////////////////
// 도메인체크 해서 메인도메인으로 이동
/*
if ($_SERVER["HTTP_HOST"] != $SITE_VAR["domain"]) {
    // 예)
    // 이동전 : http://kwedu.com/?dummy=dummy
    // 이동후 : http://www.kwedu.com/?dummy=dummy
    // $_SERVER["REQUEST_URI"] : /?dummy=dummy
    
    $location_href = "http://" . $SITE_VAR["domain"] . $_SERVER["REQUEST_URI"];
    // echo $location_href;    
    location_href($location_href);
}
*/

?>
