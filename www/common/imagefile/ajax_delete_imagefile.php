<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

$if_id = trim($_POST["if_id"]);

// 이미지파일 정보 조회
$query = "select ";
$query .= "if_id, ";
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
$query .= "from imagefile_tb ";
$query .= "where if_id = '" . $if_id . "' ";

$result = db_query($query);

if ($row = db_fetch_array($result)) {

	// 해당되는 테이블의 '사진번호' 컬럼 값을 '0'으로 설정
	$query = "update " . $row["if_tablename"] . " set ";
	$query .= $row["if_tablecolumn"] . " = '0' ";
	$query .= "where " . $row["if_tablekeyname"] . " = '" . $row["if_tablekeyid"] . "' ";
	$query .= "limit 1 ";

	if ($result_update = db_query($query)) {
		echo "Y";
	}
	else {
		echo "N";
	}
}
else {
	echo "N";
}

?>