<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Worker 로그인 체크
worker_login_check();
html_meta_charset_utf8();

$wu_id						=   trim($_SESSION["session_wu_id"]);

$wu_vehiclemaker           	=	trim($_POST["wu_vehiclemaker"]);
$wu_vehiclemodel          	=	trim($_POST["wu_vehiclemodel"]);
$wu_vehicleyear           	=	trim($_POST["wu_vehicleyear"]);
$wu_vehiclemileage        	=	trim($_POST["wu_vehiclemileage"]);
$wu_vehicleplatenumber    	=	trim($_POST["wu_vehicleplatenumber"]);
$wu_autoinsurancecompany	=	trim($_POST["wu_autoinsurancecompany"]);
$wu_autoinsurancenumber  	=	trim($_POST["wu_autoinsurancenumber"]);

// 수정
$query = "update workeruser_tb set ";
$query .= "wu_vehiclemaker = '" . $wu_vehiclemaker . "', ";
$query .= "wu_vehiclemodel = '" . $wu_vehiclemodel . "', ";
$query .= "wu_vehicleyear = '" . $wu_vehicleyear . "', ";
$query .= "wu_vehiclemileage = '" . $wu_vehiclemileage . "', ";
$query .= "wu_vehicleplatenumber = '" . $wu_vehicleplatenumber . "', ";
$query .= "wu_autoinsurancecompany = '" . $wu_autoinsurancecompany . "', ";
$query .= "wu_autoinsurancenumber = '" . $wu_autoinsurancenumber . "' ";
$query .= "where wu_id = '" . $wu_id . "' ";
$query .= "limit 1 ";

if ($result = db_query($query)) {

	// 자동차 관련 이미지 컬럼 (/common/global/db.mariadb.inc.php)
	/*
	$DB_WORKERUSER_VEHICLE_IMAGE_COLUMN_ARRAY = array (
		"wu_vehiclefrontimagefile",							// 자동차 앞면 사진번호
		"wu_vehiclebackimagefile",							// 자동차 뒷면 사진번호
		"wu_driverlicencefrontimagefile",					// 운전면허증 앞면 사진번호
		"wu_driverlicencebackimagefile",					// 운전면허증 뒷면 사진번호
		"wu_vehicleownershipimagefile",						// 자동차 오너쉽 사진번호
		"wu_vehicleinsuranceimagefile"						// 자동차 보험증 사진번호
	);
	*/

	foreach ($DB_WORKERUSER_VEHICLE_IMAGE_COLUMN_ARRAY as $IMAGE_COLUMN) {

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
$location_href = "workeruser_vehicle_info.php?dummy=dummy";
location_href($location_href);

?>