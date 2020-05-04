<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

$u_name		=   trim($_POST["u_name"]);
$u_email	=   trim($_POST["u_email"]);

// 중복체크
$query = "select count(*) as total_count ";
$query .= "from user_tb ";
$query .= "where u_name = '" . $u_name . "' ";
$query .= "and u_email = '" . $u_email . "' ";

$result = db_query($query);
$row = db_fetch_array($result);

if ($row["total_count"] > 0) {
    echo "Y";
}
else {
    echo "N";
}

?>