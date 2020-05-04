<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Admin 로그인 체크
admin_login_check();
adminuser_menu_check();

$au_id		=	trim($_POST["au_id"]);
$au_name	=	trim($_POST["au_name"]);

// 중복체크
$query = "select count(*) as total_count ";
$query .= "from adminuser_tb ";
$query .= "where au_id != '" . $au_id . "' ";
$query .= "and au_name = '" . $au_name . "' ";

$result = db_query($query);
$row = db_fetch_array($result);

if ($row["total_count"] > 0) {
    echo "Y";
}
else {
    echo "N";
}

?>