<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Worker 로그인 체크
worker_login_check();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/worker/include/header.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/worker/include/nav.php");

tp_read();

// 경로
tp_set("menu_navigator", get_menu_navigator());


// 담당자번호
$wu_id = trim($_SESSION["session_wu_id"]);

// 조회
$query = "select ";
$query .= "wu_id, ";
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
$query .= "wu_sinnumber, ";
/*
$query .= "wu_streetaddress, ";
$query .= "wu_unitnumber, ";
$query .= "wu_city, ";
$query .= "wu_province, ";
$query .= "wu_country, ";
$query .= "wu_postalcode, ";
$query .= "wu_additionalemail, ";
$query .= "wu_mobilecountry, ";
$query .= "wu_mobile1, ";
$query .= "wu_mobile2, ";
$query .= "wu_mobile3, ";
$query .= "wu_homephonecountry, ";
$query .= "wu_homephone1, ";
$query .= "wu_homephone2, ";
$query .= "wu_homephone3, ";
$query .= "wu_additionalphonecountry, ";
$query .= "wu_additionalphone1, ";
$query .= "wu_additionalphone2, ";
$query .= "wu_additionalphone3, ";
$query .= "wu_additionalphoneextension, ";
$query .= "wu_emergencyname, ";
$query .= "wu_emergencyrelationship, ";
$query .= "wu_emergencyphonecountry, ";
$query .= "wu_emergencyphone1, ";
$query .= "wu_emergencyphone2, ";
$query .= "wu_emergencyphone3, ";
$query .= "wu_emergencyphoneextension, ";
$query .= "wu_vehiclemaker, ";
$query .= "wu_vehiclemodel, ";
$query .= "wu_vehicleyear, ";
$query .= "wu_vehiclemileage, ";
$query .= "wu_vehicleplatenumber, ";
$query .= "wu_autoinsurancecompany, ";
$query .= "wu_autoinsurancenumber, ";
*/
$query .= "wu_approvalstate, ";
$query .= "wu_usestate, ";
$query .= "wu_logindatetime ";
$query .= "from workeruser_tb ";
$query .= "where wu_id = '" . $wu_id . "' ";

$result = db_query($query);

if (!$row = db_fetch_array($result)) {
    alert_back("해당 항목이 존재하지 않습니다.");
}

////////////////////////////////////////
// 기본 정보 (Basic Information)
tp_set("wu_name", $row["wu_name"]);
tp_set("wu_firstname", $row["wu_firstname"]);
tp_set("wu_lastname", $row["wu_lastname"]);
tp_set("wu_preferredname", $row["wu_preferredname"]);
tp_set("wu_loginid", $row["wu_loginid"]);

// 생년월일
// 년
$wu_birthdate_year_begin = $SITE_VAR["birthdate_year_begin"];
$wu_birthdate_year_end = current_year();

$wu_birthdate_year_temp = $wu_birthdate_year_end;

$wu_birthdate_year_array = array();

while ($wu_birthdate_year_temp >= $wu_birthdate_year_begin)
{
	$wu_birthdate_year_array[$wu_birthdate_year_temp] = $wu_birthdate_year_temp . "년";

	$wu_birthdate_year_temp = year_difference_year($wu_birthdate_year_temp, -1);
}

$option_array = $wu_birthdate_year_array;
$option = get_select_option("-년-", $option_array, get_year_format($row["wu_birthdate"]));
tp_set("option_wu_birthdate_year", $option);

// 월
$option_array = array_flip($MONTH_ARRAY);
$option = get_select_option("-월-", $option_array, get_month_format($row["wu_birthdate"]));
tp_set("option_wu_birthdate_month", $option);

// 일
$option_array = array_flip($DAY_ARRAY);
$option = get_select_option("-일-", $option_array, get_day_format($row["wu_birthdate"]));
tp_set("option_wu_birthdate_day", $option);

// 이메일
tp_set("wu_email", $row["wu_email"]);

// 성별
$radio_array = array_flip($db_wu_gendertype_array);
$radio = get_input_radio("wu_gendertype", $radio_array, $row["wu_gendertype"], $color_wu_gendertype_array);
tp_set("radio_wu_gendertype", $radio);

// 출생국가, 국적, 여권번호, SIN넘버
tp_set("wu_contryofbirth", $row["wu_contryofbirth"]);
tp_set("wu_contryofcitizenship", $row["wu_contryofcitizenship"]);
tp_set("wu_passportnumber", $row["wu_passportnumber"]);
tp_set("wu_sinnumber", $row["wu_sinnumber"]);


// 승인상태
tp_set("color_wu_approvalstate", $color_wu_approvalstate_array[$row["wu_approvalstate"]]);
tp_set("wu_approvalstate", array_search($row["wu_approvalstate"], $db_wu_approvalstate_array));

// 사용상태
tp_set("color_wu_usestate", $color_wu_usestate_array[$row["wu_usestate"]]);
tp_set("wu_usestate", array_search($row["wu_usestate"], $db_wu_usestate_array));

// 로그인일시
tp_set("wu_logindatetime", get_datetime_format($row["wu_logindatetime"]));

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/worker/include/footer.php");

?>