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
/*
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
*/
$query .= "wu_vehiclemaker, ";
$query .= "wu_vehiclemodel, ";
$query .= "wu_vehicleyear, ";
$query .= "wu_vehiclemileage, ";
$query .= "wu_vehicleplatenumber, ";
$query .= "wu_autoinsurancecompany, ";
$query .= "wu_autoinsurancenumber, ";

// 사진번호
$query .= "wu_vehiclefrontimagefile, ";
$query .= "wu_vehiclebackimagefile, ";
$query .= "wu_driverlicencefrontimagefile, ";
$query .= "wu_driverlicencebackimagefile, ";
$query .= "wu_vehicleownershipimagefile, ";
$query .= "wu_vehicleinsuranceimagefile ";

/*
$query .= "wu_approvalstate, ";
$query .= "wu_usestate, ";
$query .= "wu_logindatetime ";
*/
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


////////////////////////////////////////
// 차량 정보 (Vehicle Information)

tp_set("wu_vehiclemaker", $row["wu_vehiclemaker"]);
tp_set("wu_vehiclemodel", $row["wu_vehiclemodel"]);

// 자동차 년도
$wu_vehicleyear_begin = $SITE_VAR["vehicleyear_begin"];
$wu_vehicleyear_end = current_year();

$wu_vehicleyear_temp = $wu_vehicleyear_end;

$wu_vehicleyear_array = array();

while ($wu_vehicleyear_temp >= $wu_vehicleyear_begin)
{
	$wu_vehicleyear_array[$wu_vehicleyear_temp] = $wu_vehicleyear_temp . "년";

	$wu_vehicleyear_temp = year_difference_year($wu_vehicleyear_temp, -1);
}

$option_array = $wu_vehicleyear_array;
$option = get_select_option("--선택--", $option_array, get_year_format($row["wu_vehicleyear"]));
tp_set("option_wu_vehicleyear", $option);

tp_set("wu_vehiclemileage", $row["wu_vehiclemileage"]);
tp_set("wu_vehicleplatenumber", $row["wu_vehicleplatenumber"]);

tp_set("wu_autoinsurancecompany", $row["wu_autoinsurancecompany"]);
tp_set("wu_autoinsurancenumber", $row["wu_autoinsurancenumber"]);


////////////////////////////////////////////////////////////////////////////////
// 사진

// 자동차 관련 이미지 컬럼 (/common/global/db.mariadb.inc.php)
/*
$DB_WORKERUSER_VEHICLE_IMAGE_COLUMN_ARRAY = array (
	"wu_vehiclefrontimagefile",			// 자동차 앞면 사진번호
	"wu_vehiclebackimagefile",			// 자동차 뒷면 사진번호
	"wu_driverlicencefrontimagefile",	// 운전면허증 앞면 사진번호
	"wu_driverlicencebackimagefile",	// 운전면허증 뒷면 사진번호
	"wu_vehicleownershipimagefile",		// 자동차 오너쉽 사진번호
	"wu_vehicleinsuranceimagefile"		// 자동차 보험증 사진번호
);
*/

foreach ($DB_WORKERUSER_VEHICLE_IMAGE_COLUMN_ARRAY as $IMAGE_COLUMN) {

	// 사진번호
	tp_set($IMAGE_COLUMN, $row[$IMAGE_COLUMN]);				// ex) wu_vehiclefrontimagefile


	// 이미지 너비
	$width = 300;

	// 초기화
	$wu_imagefile_image = "";			// 이미지
	$wu_imagefile_download = "";		// 다운로드 버튼
	$wu_imagefile_delete = "";			// 삭제 버튼

	if ($row[$IMAGE_COLUMN] != 0)
	{
		$query = "select ";
		$query .= "if_id, ";
		$query .= "if_name, ";
		$query .= "if_filepath, ";
		$query .= "if_filename ";
		$query .= "from imagefile_tb ";
		$query .= "where if_id = '" . $row[$IMAGE_COLUMN] . "' ";

		$result_image = db_query($query);

		if ($row_image = db_fetch_array($result_image)) {
		    $wu_imagefile_image = "<img src=\"" . $row_image["if_filepath"] . "/" . $row_image["if_filename"] . "\" alt=\"" . $row_image["if_name"] . "\" width=\"" . $width . "px\" />";
			$wu_imagefile_download = "<input type=\"button\" class=\"btn btn-info btn-sm\" onclick=\"download_imagefile('" . $row_image["if_id"] . "');\" value=\"이미지 다운로드\" />";
		    $wu_imagefile_delete = "<input type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"delete_imagefile('" . $row_image["if_id"] . "');\" value=\"이미지 삭제하기\" />";
		}
	}

	tp_set($IMAGE_COLUMN . "_image", $wu_imagefile_image);
	tp_set($IMAGE_COLUMN . "_download", $wu_imagefile_download);
	tp_set($IMAGE_COLUMN . "_delete", $wu_imagefile_delete);
}

// 사진
////////////////////////////////////////////////////////////////////////////////

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/worker/include/footer.php");

?>