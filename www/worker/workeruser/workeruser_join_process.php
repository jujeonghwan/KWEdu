<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Worker 로그아웃 체크
worker_logout_check();
html_meta_charset_utf8();

$wu_name               	=	trim($_POST["wu_name"]);
$wu_firstname          	=	trim($_POST["wu_firstname"]);
$wu_lastname           	=	trim($_POST["wu_lastname"]);
$wu_preferredname      	=	trim($_POST["wu_preferredname"]);
$wu_loginid            	=	trim($_POST["wu_loginid"]);
$wu_password           	=	trim($_POST["wu_password"]);
$wu_birthdate          	=	trim($_POST["wu_birthdate_year"]) . trim($_POST["wu_birthdate_month"]) . trim($_POST["wu_birthdate_day"]);
$wu_email              	=	trim($_POST["wu_email"]);
$wu_gendertype         	=	trim($_POST["wu_gendertype"]);
$wu_contryofbirth      	=	trim($_POST["wu_contryofbirth"]);
$wu_contryofcitizenship	=	trim($_POST["wu_contryofcitizenship"]);
$wu_passportnumber     	=	trim($_POST["wu_passportnumber"]);
$wu_sinnumber          	=	trim($_POST["wu_sinnumber"]);

// 등록
$query = "insert into workeruser_tb ( ";
$query .= "wu_name, ";
$query .= "wu_firstname, ";
$query .= "wu_lastname, ";
$query .= "wu_preferredname, ";
$query .= "wu_loginid, ";
$query .= "wu_password, ";
$query .= "wu_birthdate, ";
$query .= "wu_email, ";
$query .= "wu_gendertype, ";
$query .= "wu_contryofbirth, ";
$query .= "wu_contryofcitizenship, ";
$query .= "wu_passportnumber, ";
$query .= "wu_sinnumber ";
$query .= ") values ( ";
$query .= "'" . $wu_name . "', ";
$query .= "'" . $wu_firstname . "', ";
$query .= "'" . $wu_lastname . "', ";
$query .= "'" . $wu_preferredname . "', ";
$query .= "'" . $wu_loginid . "', ";
$query .= "password('" . $wu_password . "'), ";
$query .= "'" . $wu_birthdate . "', ";
$query .= "'" . $wu_email . "', ";
$query .= "'" . $wu_gendertype . "', ";
$query .= "'" . $wu_contryofbirth . "', ";
$query .= "'" . $wu_contryofcitizenship . "', ";
$query .= "'" . $wu_passportnumber . "', ";
$query .= "'" . $wu_sinnumber . "' ";
$query .= ")";

if ($result = db_query($query)) {    
    alert("회원 가입완료되었습니다.");
}
else {
    alert_back("회원 가입완료하는데 실패했습니다."); 
}

// 페이지 이동
$location_href = $PATH_VAR["worker_default_url"];
location_href($location_href);

?>