<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Admin 로그인 체크
admin_login_check();
adminuser_menu_check();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/header.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/nav.php");

tp_read();

// 경로
tp_set("menu_navigator", get_menu_navigator());


// 목록 페이지 조회조건
tp_set("search_wu_approvalstate", $_REQUEST["search_wu_approvalstate"]);
tp_set("search_wu_usestate", $_REQUEST["search_wu_usestate"]);
tp_set("search_type", $_REQUEST["search_type"]);
tp_set("search_keyword", $_REQUEST["search_keyword"]);
tp_set("page", $_REQUEST["page"]);


// QUERY_STRING
$QUERY_STRING = "dummy=dummy";
$QUERY_STRING .= "&search_wu_approvalstate=" . $_REQUEST["search_wu_approvalstate"];
$QUERY_STRING .= "&search_wu_usestate=" . $_REQUEST["search_wu_usestate"];
$QUERY_STRING .= "&search_type=" . $_REQUEST["search_type"];
$QUERY_STRING .= "&search_keyword=" . urlencode($_REQUEST["search_keyword"]);
$QUERY_STRING .= "&page=" . $_REQUEST["page"];

// 목록보기 버튼 링크
$list_link_href = "workeruser_list.php?" . $QUERY_STRING;
tp_set("list_link_href", $list_link_href);


// 담당자번호
$wu_id = trim($_REQUEST["wu_id"]);

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
$query .= "wu_passportimagefile, ";
$query .= "wu_photoimagefile, ";
$query .= "wu_criminalrecordimagefile, ";
$query .= "wu_vehiclefrontimagefile, ";
$query .= "wu_vehiclebackimagefile, ";
$query .= "wu_driverlicencefrontimagefile, ";
$query .= "wu_driverlicencebackimagefile, ";
$query .= "wu_vehicleownershipimagefile, ";
$query .= "wu_vehicleinsuranceimagefile, ";
$query .= "wu_approvalstate, ";
$query .= "wu_usestate, ";
$query .= "wu_logindatetime ";
$query .= "from workeruser_tb ";
$query .= "where wu_id = '" . $wu_id . "' ";

$result = db_query($query);

if (!$row = db_fetch_array($result)) {
    alert_back("해당 항목이 존재하지 않습니다.");
}

tp_set("wu_id", $row["wu_id"]);

tp_set("wu_name", $row["wu_name"]);
tp_set("wu_firstname", $row["wu_firstname"]);
tp_set("wu_lastname", $row["wu_lastname"]);
tp_set("wu_preferredname", $row["wu_preferredname"]);
tp_set("wu_email", $row["wu_email"]);

tp_set("wu_birthdate", get_date_format($row["wu_birthdate"]));

tp_set("color_wu_gendertype", $color_wu_gendertype_array[$row["wu_gendertype"]]);
tp_set("wu_gendertype", array_search($row["wu_gendertype"], $db_wu_gendertype_array));

tp_set("wu_contryofbirth", $row["wu_contryofbirth"]);
tp_set("wu_contryofcitizenship", $row["wu_contryofcitizenship"]);

tp_set("wu_passportnumber", $row["wu_passportnumber"]);
tp_set("wu_sinnumber", $row["wu_sinnumber"]);


tp_set("wu_streetaddress", $row["wu_streetaddress"]);
tp_set("wu_unitnumber", $row["wu_unitnumber"]);
tp_set("wu_city", $row["wu_city"]);
tp_set("wu_province", $row["wu_province"]);
tp_set("wu_country", $row["wu_country"]);
tp_set("wu_postalcode", $row["wu_postalcode"]);


tp_set("wu_additionalemail", $row["wu_additionalemail"]);

tp_set("wu_mobilecountry", $row["wu_mobilecountry"]);
tp_set("wu_mobile1", $row["wu_mobile1"]);
tp_set("wu_mobile2", $row["wu_mobile2"]);
tp_set("wu_mobile3", $row["wu_mobile3"]);

tp_set("wu_homephonecountry", $row["wu_homephonecountry"]);
tp_set("wu_homephone1", $row["wu_homephone1"]);
tp_set("wu_homephone2", $row["wu_homephone2"]);
tp_set("wu_homephone3", $row["wu_homephone3"]);

tp_set("wu_additionalphonecountry", $row["wu_additionalphonecountry"]);
tp_set("wu_additionalphone1", $row["wu_additionalphone1"]);
tp_set("wu_additionalphone2", $row["wu_additionalphone2"]);
tp_set("wu_additionalphone3", $row["wu_additionalphone3"]);
tp_set("wu_additionalphoneextension", $row["wu_additionalphoneextension"]);


tp_set("wu_emergencyname", $row["wu_emergencyname"]);
tp_set("wu_emergencyrelationship", $row["wu_emergencyrelationship"]);

tp_set("wu_emergencyphonecountry", $row["wu_emergencyphonecountry"]);
tp_set("wu_emergencyphone1", $row["wu_emergencyphone1"]);
tp_set("wu_emergencyphone2", $row["wu_emergencyphone2"]);
tp_set("wu_emergencyphone3", $row["wu_emergencyphone3"]);
tp_set("wu_emergencyphoneextension", $row["wu_emergencyphoneextension"]);


tp_set("wu_vehiclemaker", $row["wu_vehiclemaker"]);
tp_set("wu_vehiclemodel", $row["wu_vehiclemodel"]);
tp_set("wu_vehicleyear", $row["wu_vehicleyear"]);
tp_set("wu_vehiclemileage", $row["wu_vehiclemileage"]);

tp_set("wu_vehicleplatenumber", $row["wu_vehicleplatenumber"]);

tp_set("wu_autoinsurancecompany", $row["wu_autoinsurancecompany"]);
tp_set("wu_autoinsurancenumber", $row["wu_autoinsurancenumber"]);


// 승인상태
tp_set("color_wu_approvalstate", $color_wu_approvalstate_array[$row["wu_approvalstate"]]);
tp_set("wu_approvalstate", array_search($row["wu_approvalstate"], $db_wu_approvalstate_array));

// 승인상태 변경 버튼
$button_wu_approvalstate_change = "";

if ($row["wu_approvalstate"] == $db_wu_approvalstate_array["미승인"]) {
    $button_wu_approvalstate_change = "<input type=\"button\" class=\"btn btn-primary btn-sm\" onclick=\"workeruser_approvalstate_change('" . $db_wu_approvalstate_array["승인완료"] . "');\" value=\"'승인완료'로 변경\" />";
}
else if ($row["wu_approvalstate"] == $db_wu_approvalstate_array["승인완료"]) {
    $button_wu_approvalstate_change = "<input type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"workeruser_approvalstate_change('" . $db_wu_approvalstate_array["미승인"] . "');\" value=\"'미승인'으로 변경\" />";
}

tp_set("button_wu_approvalstate_change", $button_wu_approvalstate_change);


// 사용상태
tp_set("color_wu_usestate", $color_wu_usestate_array[$row["wu_usestate"]]);
tp_set("wu_usestate", array_search($row["wu_usestate"], $db_wu_usestate_array));

// 사용상태 변경 버튼
$button_wu_usestate_change = "";

if ($row["wu_usestate"] == $db_wu_usestate_array["사용"]) {
    $button_wu_usestate_change = "<input type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"workeruser_usestate_change('" . $db_wu_usestate_array["중지"] . "');\" value=\"'중지'로 변경\" />";
}
else if ($row["wu_usestate"] == $db_wu_usestate_array["중지"]) {
    $button_wu_usestate_change = "<input type=\"button\" class=\"btn btn-primary btn-sm\" onclick=\"workeruser_usestate_change('" . $db_wu_usestate_array["사용"] . "');\" value=\"'사용'으로 변경\" />";
}

tp_set("button_wu_usestate_change", $button_wu_usestate_change);


tp_set("wu_logindatetime", get_datetime_format($row["wu_logindatetime"]));


////////////////////////////////////////////////////////////////////////////////
// 이미지

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
    tp_set($IMAGE_COLUMN, $row[$IMAGE_COLUMN]);             // ex) wu_passportimagefile


    // 이미지 너비
    $width = 300;

    // 초기화
    $wu_imagefile_image = "";           // 이미지
    $wu_imagefile_download = "";        // 다운로드 버튼

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
        }
    }

    tp_set($IMAGE_COLUMN . "_image", $wu_imagefile_image);
    tp_set($IMAGE_COLUMN . "_download", $wu_imagefile_download);
}


// 자동차 관련 이미지 컬럼 (/common/global/db.mariadb.inc.php)
/*
$DB_WORKERUSER_VEHICLE_IMAGE_COLUMN_ARRAY = array (
    "wu_vehiclefrontimagefile",         // 자동차 앞면 사진번호
    "wu_vehiclebackimagefile",          // 자동차 뒷면 사진번호
    "wu_driverlicencefrontimagefile",   // 운전면허증 앞면 사진번호
    "wu_driverlicencebackimagefile",    // 운전면허증 뒷면 사진번호
    "wu_vehicleownershipimagefile",     // 자동차 오너쉽 사진번호
    "wu_vehicleinsuranceimagefile"      // 자동차 보험증 사진번호
);
*/

foreach ($DB_WORKERUSER_VEHICLE_IMAGE_COLUMN_ARRAY as $IMAGE_COLUMN) {

    // 사진번호
    tp_set($IMAGE_COLUMN, $row[$IMAGE_COLUMN]);             // ex) wu_vehiclefrontimagefile


    // 이미지 너비
    $width = 300;

    // 초기화
    $wu_imagefile_image = "";           // 이미지
    $wu_imagefile_download = "";        // 다운로드 버튼

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
        }
    }

    tp_set($IMAGE_COLUMN . "_image", $wu_imagefile_image);
    tp_set($IMAGE_COLUMN . "_download", $wu_imagefile_download);
}

// 이미지
////////////////////////////////////////////////////////////////////////////////

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/footer.php");

?>