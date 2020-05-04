<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

$u_id  		=   trim($_POST["u_id"]);
$u_loginid	=   trim($_POST["u_loginid"]);

// 중복체크
$query = "select count(*) as total_count ";
$query .= "from user_tb ";
$query .= "where u_id != '" . $u_id . "' ";
$query .= "and u_loginid = '" . $u_loginid . "' ";

$result = db_query($query);
$row = db_fetch_array($result);

if ($row["total_count"] > 0) {
    echo "Y";
}
else {
    echo "N";
}

?>