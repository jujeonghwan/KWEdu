<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Worker 로그인 체크
worker_login_check();
html_meta_charset_utf8();

$wu_id					=   trim($_SESSION["session_wu_id"]);
$wu_preferredname		=   trim($_POST["wu_preferredname"]);
$wu_password			=   trim($_POST["wu_password"]);
$wu_birthdate          	=	trim($_POST["wu_birthdate_year"]) . trim($_POST["wu_birthdate_month"]) . trim($_POST["wu_birthdate_day"]);
$wu_email              	=	trim($_POST["wu_email"]);
$wu_gendertype         	=	trim($_POST["wu_gendertype"]);
$wu_contryofbirth      	=	trim($_POST["wu_contryofbirth"]);
$wu_contryofcitizenship	=	trim($_POST["wu_contryofcitizenship"]);
$wu_passportnumber     	=	trim($_POST["wu_passportnumber"]);
$wu_sinnumber          	=	trim($_POST["wu_sinnumber"]);

// 기존 비밀번호 체크
$query = "select ";
$query .= "wu_id ";
$query .= "from workeruser_tb ";
$query .= "where wu_id = '" . $wu_id . "' ";
$query .= "and wu_password = password('" . $wu_password . "') ";

$result = db_query($query);

if (!$row = db_fetch_array($result)) {
    alert_back("기존 비밀번호가 정확하지 않습니다.");       
}


// 수정
$query = "update workeruser_tb set ";
$query .= "wu_preferredname = '" . $wu_preferredname . "', ";
$query .= "wu_birthdate = '" . $wu_birthdate . "', ";
$query .= "wu_email = '" . $wu_email . "', ";
$query .= "wu_gendertype = '" . $wu_gendertype . "', ";
$query .= "wu_contryofbirth = '" . $wu_contryofbirth . "', ";
$query .= "wu_contryofcitizenship = '" . $wu_contryofcitizenship . "', ";
$query .= "wu_passportnumber = '" . $wu_passportnumber . "', ";
$query .= "wu_sinnumber = '" . $wu_sinnumber . "' ";
$query .= "where wu_id = '" . $wu_id . "' ";
$query .= "limit 1 ";

if ($result = db_query($query)) {
    alert("수정되었습니다.");
}
else {
    alert_back("수정하는데 실패했습니다."); 
}

// 페이지 이동
$location_href = "workeruser_info.php?dummy=dummy";
location_href($location_href);

?>