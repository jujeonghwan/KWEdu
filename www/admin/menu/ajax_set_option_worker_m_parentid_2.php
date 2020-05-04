<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Admin 로그인 체크
admin_login_check();
adminuser_menu_check();

$m_parentid =   trim($_POST["m_parentid_1"]);

// 중메뉴
$query = "select ";
$query .= "m_id, ";
$query .= "m_name ";
$query .= "from menu_tb ";
$query .= "where m_type = '" . $db_m_type_array["담당자"] . "' ";
$query .= "and m_step = '" . $db_m_step_array["중메뉴"] . "' ";
$query .= "and m_parentid = '" . $m_parentid . "' ";
$query .= "order by m_order ";

$result = db_query($query);

$data_list_array = array();

$no = 0;
while ($row = db_fetch_array($result)) {
    $no++;
    
    // $data_list_array[$row["m_id"]] = $row["m_name"];
    $data_list_array[$no] = $row["m_id"] . "||" . $row["m_name"];
}

echo json_encode($data_list_array);

?>