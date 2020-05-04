<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Admin 로그인 체크
admin_login_check();
adminuser_menu_check();

$m_id           =   trim($_POST["m_id"]);
$m_type         =   $db_m_type_array["담당자"];
$m_step         =   trim($_POST["m_step"]);
$m_parentid_1   =   trim($_POST["m_parentid_1"]);
$m_parentid_2   =   trim($_POST["m_parentid_2"]);
$m_name         =   trim($_POST["m_name"]);

if ($m_step == $db_m_step_array["대메뉴"]) {
    $m_parentid =   "";
}
else if ($m_step == $db_m_step_array["중메뉴"]) {
    $m_parentid =   $m_parentid_1;   
}
else if ($m_step == $db_m_step_array["소메뉴"]) {
    $m_parentid =   $m_parentid_2;   
}

// 중복체크
$query = "select count(*) as total_count ";
$query .= "from menu_tb ";
$query .= "where m_id != '" . $m_id . "' ";
$query .= "and m_type = '" . $m_type . "' ";
$query .= "and m_step = '" . $m_step . "' ";
$query .= "and m_parentid = '" . $m_parentid . "' ";
$query .= "and m_name = '" . $m_name . "' ";

$result = db_query($query);
$row = db_fetch_array($result);

if ($row["total_count"] > 0) {
    echo "Y";
}
else {
    echo "N";
}

?>