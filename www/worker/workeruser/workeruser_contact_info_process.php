<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Worker 로그인 체크
worker_login_check();
html_meta_charset_utf8();

$wu_id							=   trim($_SESSION["session_wu_id"]);

$wu_streetaddress           	=	trim($_POST["wu_streetaddress"]);
$wu_unitnumber              	=	trim($_POST["wu_unitnumber"]);
$wu_city                    	=	trim($_POST["wu_city"]);
$wu_province                	=	trim($_POST["wu_province"]);
$wu_country                 	=	trim($_POST["wu_country"]);
$wu_postalcode              	=	trim($_POST["wu_postalcode"]);
$wu_additionalemail         	=	trim($_POST["wu_additionalemail"]);
$wu_mobilecountry           	=	trim($_POST["wu_mobilecountry"]);
$wu_mobile1                 	=	trim($_POST["wu_mobile1"]);
$wu_mobile2                 	=	trim($_POST["wu_mobile2"]);
$wu_mobile3                 	=	trim($_POST["wu_mobile3"]);
$wu_homephonecountry        	=	trim($_POST["wu_homephonecountry"]);
$wu_homephone1              	=	trim($_POST["wu_homephone1"]);
$wu_homephone2              	=	trim($_POST["wu_homephone2"]);
$wu_homephone3              	=	trim($_POST["wu_homephone3"]);
$wu_additionalphonecountry  	=	trim($_POST["wu_additionalphonecountry"]);
$wu_additionalphone1        	=	trim($_POST["wu_additionalphone1"]);
$wu_additionalphone2        	=	trim($_POST["wu_additionalphone2"]);
$wu_additionalphone3        	=	trim($_POST["wu_additionalphone3"]);
$wu_additionalphoneextension	=	trim($_POST["wu_additionalphoneextension"]);
$wu_emergencyname           	=	trim($_POST["wu_emergencyname"]);
$wu_emergencyrelationship   	=	trim($_POST["wu_emergencyrelationship"]);
$wu_emergencyphonecountry   	=	trim($_POST["wu_emergencyphonecountry"]);
$wu_emergencyphone1         	=	trim($_POST["wu_emergencyphone1"]);
$wu_emergencyphone2         	=	trim($_POST["wu_emergencyphone2"]);
$wu_emergencyphone3         	=	trim($_POST["wu_emergencyphone3"]);
$wu_emergencyphoneextension 	=	trim($_POST["wu_emergencyphoneextension"]);

// 수정
$query = "update workeruser_tb set ";
$query .= "wu_streetaddress = '" . $wu_streetaddress . "', ";
$query .= "wu_unitnumber = '" . $wu_unitnumber . "', ";
$query .= "wu_city = '" . $wu_city . "', ";
$query .= "wu_province = '" . $wu_province . "', ";
$query .= "wu_country = '" . $wu_country . "', ";
$query .= "wu_postalcode = '" . $wu_postalcode . "', ";
$query .= "wu_additionalemail = '" . $wu_additionalemail . "', ";
$query .= "wu_mobilecountry = '" . $wu_mobilecountry . "', ";
$query .= "wu_mobile1 = '" . $wu_mobile1 . "', ";
$query .= "wu_mobile2 = '" . $wu_mobile2 . "', ";
$query .= "wu_mobile3 = '" . $wu_mobile3 . "', ";
$query .= "wu_homephonecountry = '" . $wu_homephonecountry . "', ";
$query .= "wu_homephone1 = '" . $wu_homephone1 . "', ";
$query .= "wu_homephone2 = '" . $wu_homephone2 . "', ";
$query .= "wu_homephone3 = '" . $wu_homephone3 . "', ";
$query .= "wu_additionalphonecountry = '" . $wu_additionalphonecountry . "', ";
$query .= "wu_additionalphone1 = '" . $wu_additionalphone1 . "', ";
$query .= "wu_additionalphone2 = '" . $wu_additionalphone2 . "', ";
$query .= "wu_additionalphone3 = '" . $wu_additionalphone3 . "', ";
$query .= "wu_additionalphoneextension = '" . $wu_additionalphoneextension . "', ";
$query .= "wu_emergencyname = '" . $wu_emergencyname . "', ";
$query .= "wu_emergencyrelationship = '" . $wu_emergencyrelationship . "', ";
$query .= "wu_emergencyphonecountry = '" . $wu_emergencyphonecountry . "', ";
$query .= "wu_emergencyphone1 = '" . $wu_emergencyphone1 . "', ";
$query .= "wu_emergencyphone2 = '" . $wu_emergencyphone2 . "', ";
$query .= "wu_emergencyphone3 = '" . $wu_emergencyphone3 . "', ";
$query .= "wu_emergencyphoneextension = '" . $wu_emergencyphoneextension . "' ";
$query .= "where wu_id = '" . $wu_id . "' ";
$query .= "limit 1 ";

if ($result = db_query($query)) {

	// 개인 관련 이미지 컬럼 (/common/global/db.mariadb.inc.php)
	/*
	$DB_WORKERUSER_PERSON_IMAGE_COLUMN_ARRAY = array (
	    "wu_passportimagefile",             // 여권 사진번호
	    "wu_photoimagefile",                // 본인 사진번호
	    "wu_criminalrecordimagefile"        // 범죄경력증명서 사진번호
	);
	*/

	foreach ($DB_WORKERUSER_PERSON_IMAGE_COLUMN_ARRAY as $IMAGE_COLUMN) {

	    if ($_FILES[$IMAGE_COLUMN]["error"] == UPLOAD_ERR_OK) {
	    	////////////////////////////////////////////////////////////////////////////////
	    	// 현재 년도, 월일
			$current_year = current_year();
			$current_monthday = current_monthday();

			// 디렉터리 확인
			check_directory ($PATH_VAR["imagefile_path"]);
		    check_directory ($PATH_VAR["imagefile_path"] . "/" . $current_year);
		    check_directory ($PATH_VAR["imagefile_path"] . "/" . $current_year . "/" . $current_monthday);
		    
		    $if_filepath = $PATH_VAR["imagefile_url"] . "/" . $current_year . "/" . $current_monthday;
		    ////////////////////////////////////////////////////////////////////////////////

	    	// 확장자
	        $filename = explode (".",  $_FILES[$IMAGE_COLUMN]["name"]);
	        $extension = strtolower($filename[sizeof($filename) - 1]);

	        // DB 컬럼
			$if_tablename  		=	"workeruser_tb";
			$if_tablekeyname	=	"wu_id";
			$if_tablekeyid 		=	$wu_id;
			$if_tablecolumn		=	$IMAGE_COLUMN;
			$if_name       		=	$_FILES[$IMAGE_COLUMN]["name"];
			$if_filepath   		=	$if_filepath;
			$if_filename   		=	$wu_id . "_" . $IMAGE_COLUMN . "_" . get_random_string() . "." . $extension;
			$if_filesize   		=	$_FILES[$IMAGE_COLUMN]["size"];
			$if_note       		=	"";
			$if_usertype   		=	$db_if_usertype_array["workeruser"];
			$if_reguser    		=	trim($_SESSION["session_wu_id"]);
			$if_regtime    		=	current_datetime();

			$tmp_name = $_FILES[$IMAGE_COLUMN]["tmp_name"];
			move_uploaded_file($tmp_name, $_SERVER["DOCUMENT_ROOT"] . $if_filepath . "/" . $if_filename);
			
			// DB 저장
			$query = "insert into imagefile_tb ( ";
			$query .= "if_tablename, ";
			$query .= "if_tablekeyname, ";
			$query .= "if_tablekeyid, ";
			$query .= "if_tablecolumn, ";
			$query .= "if_name, ";
			$query .= "if_filepath, ";
			$query .= "if_filename, ";
			$query .= "if_filesize, ";
			$query .= "if_note, ";
			$query .= "if_usertype, ";
			$query .= "if_reguser, ";
			$query .= "if_regtime ";
	        $query .= ") values ( ";
			$query .= "'" . $if_tablename . "', ";
			$query .= "'" . $if_tablekeyname . "', ";
			$query .= "'" . $if_tablekeyid . "', ";
			$query .= "'" . $if_tablecolumn . "', ";
			$query .= "'" . $if_name . "', ";
			$query .= "'" . $if_filepath . "', ";
			$query .= "'" . $if_filename . "', ";
			$query .= "'" . $if_filesize . "', ";
			$query .= "'" . $if_note . "', ";
			$query .= "'" . $if_usertype . "', ";
			$query .= "'" . $if_reguser . "', ";
			$query .= "'" . $if_regtime . "' ";
	        $query .= ")";

	    	if ($result_imagefile = db_query($query)) {
	    		
	    		// 이미지파일 사진번호
	    		$if_id_insert = db_insert_id();

	    		// 수정
				$query = "update workeruser_tb set ";
				$query .= $IMAGE_COLUMN . " = '" . $if_id_insert . "' ";
				$query .= "where wu_id = '" . $wu_id . "' ";
				$query .= "limit 1 ";

				db_query($query);
	    	}
	    }

	}
	
    alert("수정되었습니다.");
}
else {
    alert_back("수정하는데 실패했습니다."); 
}

// 페이지 이동
$location_href = "workeruser_contact_info.php?dummy=dummy";
location_href($location_href);

?>