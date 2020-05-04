<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Admin 로그인 체크
admin_login_check();
adminuser_menu_check();
html_meta_charset_utf8();

$m_id       =   trim($_POST["m_id"]);
$m_type     =   $db_m_type_array["고객"];
$m_step     =   trim($_POST["m_step"]);

if ($m_step == $db_m_step_array["대메뉴"]) {
    $m_parentid =   "";
}
else if ($m_step == $db_m_step_array["중메뉴"]) {
    $m_parentid =   trim($_POST["m_parentid_1"]);
}
else if ($m_step == $db_m_step_array["소메뉴"]) {
    $m_parentid =   trim($_POST["m_parentid_2"]);
}

$m_name     =   trim($_POST["m_name"]);
$m_url      =   trim($_POST["m_url"]);
$m_usestate =   trim($_POST["m_usestate"]);
$m_order    =   "";

// 등록
$query = "insert into menu_tb ( ";
$query .= "m_type, ";
$query .= "m_step, ";
$query .= "m_parentid, ";
$query .= "m_name, ";
$query .= "m_url, ";
$query .= "m_usestate, ";
$query .= "m_order ";
$query .= ") values ( ";
$query .= "'" . $m_type . "', ";
$query .= "'" . $m_step . "', ";
$query .= "'" . $m_parentid . "', ";
$query .= "'" . $m_name . "', ";
$query .= "'" . $m_url . "', ";
$query .= "'" . $m_usestate . "', ";
$query .= "'" . $m_order . "' ";
$query .= ")";   

if ($result = db_query($query)) {   
    $m_id       =   db_insert_id();
    $m_order    =   $m_id;
    
    // 순서
    $query = "update menu_tb set ";
    $query .= "m_order = '" . $m_order . "' ";
    $query .= "where m_id = '" . $m_id . "' ";
    $query .= "limit 1 ";
    
    $result = db_query($query);
     
    alert("등록되었습니다.");
}
else {
    alert_back("등록하는데 실패했습니다."); 
}

// 페이지 이동
$location_href = "mypage_menu_list.php?dummy=dummy";
$location_href .= "&search_m_id_1=" . $_REQUEST["search_m_id_1"];
$location_href .= "&search_m_usestate=" . $_REQUEST["search_m_usestate"];
location_href($location_href);

?>