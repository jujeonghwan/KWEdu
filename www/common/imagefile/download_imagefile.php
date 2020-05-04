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

if (!$row = db_fetch_array($result)) {
	alert_back("해당 항목이 존재하지 않습니다.");
}

$file_name = basename($row["if_name"]);
$file_pathname = $_SERVER["DOCUMENT_ROOT"] . $row["if_filepath"] . "/" . basename($row["if_filename"]);
// $file_pathname = $row["if_filepath"] . "/" . $row["if_filename"];
$file_size = $row["if_filesize"];

if (!file_exists($file_pathname)) {
    alert_back("해당 파일이 존재하지 않습니다.");
    exit;
}

// Define header
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=" . $file_name);
header("Content-Type: application/zip");
header("Content-Transfer-Encoding: binary");

// Read the file
readfile($file_pathname);
exit;

?>