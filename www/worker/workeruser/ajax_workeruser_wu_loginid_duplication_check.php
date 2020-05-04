<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Worker 로그인 체크
// worker_login_check();

$wu_id  	=   trim($_POST["wu_id"]);
$wu_loginid	=   trim($_POST["wu_loginid"]);

// 중복체크
$query = "select count(*) as total_count ";
$query .= "from workeruser_tb ";
$query .= "where wu_id != '" . $wu_id . "' ";
$query .= "and wu_loginid = '" . $wu_loginid . "' ";

$result = db_query($query);
$row = db_fetch_array($result);

if ($row["total_count"] > 0) {
    echo "Y";
}
else {
    echo "N";
}

?>