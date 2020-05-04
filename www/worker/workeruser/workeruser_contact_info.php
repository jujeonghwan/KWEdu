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
*/
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
/*
$query .= "wu_vehiclemaker, ";
$query .= "wu_vehiclemodel, ";
$query .= "wu_vehicleyear, ";
$query .= "wu_vehiclemileage, ";
$query .= "wu_vehicleplatenumber, ";
$query .= "wu_autoinsurancecompany, ";
$query .= "wu_autoinsurancenumber, ";
*/
$query .= "wu_passportimagefile, ";
$query .= "wu_photoimagefile, ";
$query .= "wu_criminalrecordimagefile ";
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
// 연락처 정보 (Contact Information)

// 주소
tp_set("wu_streetaddress", $row["wu_streetaddress"]);
tp_set("wu_unitnumber", $row["wu_unitnumber"]);
tp_set("wu_city", $row["wu_city"]);
tp_set("wu_province", $row["wu_province"]);
tp_set("wu_country", $row["wu_country"]);
tp_set("wu_postalcode", $row["wu_postalcode"]);

// 추가이메일
tp_set("wu_additionalemail", $row["wu_additionalemail"]);

// 휴대폰
tp_set("wu_mobilecountry", $row["wu_mobilecountry"]);
tp_set("wu_mobile1", $row["wu_mobile1"]);
tp_set("wu_mobile2", $row["wu_mobile2"]);
tp_set("wu_mobile3", $row["wu_mobile3"]);

// 집전화
tp_set("wu_homephonecountry", $row["wu_homephonecountry"]);
tp_set("wu_homephone1", $row["wu_homephone1"]);
tp_set("wu_homephone2", $row["wu_homephone2"]);
tp_set("wu_homephone3", $row["wu_homephone3"]);

// 기타전화
tp_set("wu_additionalphonecountry", $row["wu_additionalphonecountry"]);
tp_set("wu_additionalphone1", $row["wu_additionalphone1"]);
tp_set("wu_additionalphone2", $row["wu_additionalphone2"]);
tp_set("wu_additionalphone3", $row["wu_additionalphone3"]);
tp_set("wu_additionalphoneextension", $row["wu_additionalphoneextension"]);

// 긴급연락처 이름, 관계
tp_set("wu_emergencyname", $row["wu_emergencyname"]);
tp_set("wu_emergencyrelationship", $row["wu_emergencyrelationship"]);

// 긴급연락처 전화
tp_set("wu_emergencyphonecountry", $row["wu_emergencyphonecountry"]);
tp_set("wu_emergencyphone1", $row["wu_emergencyphone1"]);
tp_set("wu_emergencyphone2", $row["wu_emergencyphone2"]);
tp_set("wu_emergencyphone3", $row["wu_emergencyphone3"]);
tp_set("wu_emergencyphoneextension", $row["wu_emergencyphoneextension"]);

////////////////////////////////////////////////////////////////////////////////
// 사진

// 개인 관련 이미지 컬럼 (/common/global/db.mariadb.inc.php)
/*
$DB_WORKERUSER_PERSON_IMAGE_COLUMN_ARRAY = array (
    "wu_passportimagefile",             // 여권 사진번호
    "wu_photoimagefile",                // 본인 사진번호
    "wu_criminalrecordimagefile"        // 범죄경력증명서 사진번호
);
*/

foreach ($DB_WORKERUSER_PERSON_IMAGE_COLUMN_ARRAY as $IMAGE_COLUMN) {

	// 사진번호
	tp_set($IMAGE_COLUMN, $row[$IMAGE_COLUMN]);				// ex) wu_passportimagefile


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