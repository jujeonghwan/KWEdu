<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// 전체세션 해제
session_destroy();

alert("관리자 로그아웃되었습니다.");

// 페이지 이동
top_location_href($PATH_VAR["admin_login_url"]);

?>