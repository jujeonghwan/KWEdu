<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Admin 로그인 체크
admin_login_check();
adminuser_menu_check();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/header.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/nav.php");

tp_read();

// 경로
tp_set("menu_navigator", get_menu_navigator());


// 목록 페이지 조회조건
tp_set("search_au_usestate", $_REQUEST["search_au_usestate"]);
tp_set("search_type", $_REQUEST["search_type"]);
tp_set("search_keyword", $_REQUEST["search_keyword"]);
tp_set("page", $_REQUEST["page"]);


// QUERY_STRING
$QUERY_STRING = "dummy=dummy";
$QUERY_STRING .= "&search_au_usestate=" . $_REQUEST["search_au_usestate"];
$QUERY_STRING .= "&search_type=" . $_REQUEST["search_type"];
$QUERY_STRING .= "&search_keyword=" . urlencode($_REQUEST["search_keyword"]);
$QUERY_STRING .= "&page=" . $_REQUEST["page"];

// 목록보기 버튼 링크
$list_link_href = "adminuser_list.php?" . $QUERY_STRING;
tp_set("list_link_href", $list_link_href);


// 관리자번호
$au_id = trim($_REQUEST["au_id"]);
tp_set("au_id", $au_id);

// 조회
$query = "select ";
$query .= "au_id, ";
$query .= "au_name, ";
$query .= "au_loginid, ";
$query .= "au_password, ";
$query .= "au_email, ";
$query .= "au_mobile, ";
$query .= "au_usestate, ";
$query .= "au_logindatetime ";
$query .= "from adminuser_tb ";
$query .= "where au_id = '" . $au_id . "' ";

$result = db_query($query);

if (!$row = db_fetch_array($result)) {
    alert_back("해당 항목이 존재하지 않습니다.");
}

tp_set("au_name", $row["au_name"]);
tp_set("au_loginid", $row["au_loginid"]);
tp_set("au_email", $row["au_email"]);
tp_set("au_mobile", $row["au_mobile"]);

// 사용상태
$radio_array = array_flip($db_au_usestate_array);
$radio = get_input_radio("au_usestate", $radio_array, $row["au_usestate"], $color_au_usestate_array);
tp_set("radio_au_usestate", $radio);

tp_set("au_logindatetime", get_datetime_format($row["au_logindatetime"]));


// 관리자 메뉴권한
$query = "select ";
$query .= "m1.m_id as m_id_1, ";
$query .= "m1.m_name as m_name_1, ";
$query .= "m2.m_id as m_id_2, ";
$query .= "m2.m_name as m_name_2, ";
$query .= "m3.m_id as m_id_3, ";
$query .= "m3.m_name as m_name_3, ";
$query .= "ifnull(auma.auma_menu, '') as auma_menu ";

$query .= "from menu_tb m1 ";

$query .= "inner join menu_tb m2 ";
$query .= "on m1.m_id = m2.m_parentid ";

$query .= "inner join menu_tb m3 ";
$query .= "on m2.m_id = m3.m_parentid ";

$query .= "left outer join adminusermenuauth_tb auma ";
$query .= "on m3.m_id = auma.auma_menu ";
$query .= "and auma.auma_adminuser = '" . $au_id . "' ";

$query .= "where m1.m_type = '" . $db_m_type_array["관리자"] . "' ";
$query .= "and m2.m_type = '" . $db_m_type_array["관리자"] . "' ";
$query .= "and m3.m_type = '" . $db_m_type_array["관리자"] . "' ";

$query .= "and m1.m_step = '" . $db_m_step_array["대메뉴"] . "' ";
$query .= "and m2.m_step = '" . $db_m_step_array["중메뉴"] . "' ";
$query .= "and m3.m_step = '" . $db_m_step_array["소메뉴"] . "' ";

$query .= "order by m1.m_order, m2.m_order, m3.m_order ";

$result_adminusermenuauth = db_query($query);

$m_name_1_array 	=   array();
$m_name_2_array 	=   array();
$m_name_3_array 	=   array();
$auma_menu_array	=   array();

while ($row_adminusermenuauth = db_fetch_array($result_adminusermenuauth)) {
    $key = $row_adminusermenuauth["m_id_1"] . "_" . $row_adminusermenuauth["m_id_2"];
    
    $m_name_1_array[$key]                               		=   $row_adminusermenuauth["m_name_1"];
    $m_name_2_array[$key]                               		=   $row_adminusermenuauth["m_name_2"];
    $m_name_3_array[$key][$row_adminusermenuauth["m_id_3"]]		=   $row_adminusermenuauth["m_name_3"];
    $auma_menu_array[$key][$row_adminusermenuauth["m_id_3"]]	=   $row_adminusermenuauth["auma_menu"];
}
// print_r($auma_menu_array);

$template = "row_adminusermenuauth";
tp_dynamic($template);

$no = 0;

foreach ($m_name_1_array as $key => $val) {
    $no++;
    
    // 대메뉴
    if ($m_name_1_array[$key] != $prev_m_name_1) {
        $m_name_1_text = $m_name_1_array[$key];   
    }
    else {
        $m_name_1_text = "";
    }
    
    // 소메뉴 체크박스 목록
    $checkbox_auma_menu_list	= "";
    
    $db_auma_menu_array      	=   array();
    $checked_auma_menu_array	=   array();
    $color_auma_menu_array   	=   array();
    
    foreach ($m_name_3_array[$key] as $key2 => $val2) {
        $db_auma_menu_array[$key2]	=   $m_name_3_array[$key][$key2];               
        
        if ($auma_menu_array[$key][$key2] != "") {
            $checked_auma_menu_array[$key2]	=   "checked";
            $color_auma_menu_array[$key2] 	=   "blue";
        }
        else {
            $checked_auma_menu_array[$key2]	=   "";
            $color_auma_menu_array[$key2]  	=   "red";
        }
    }
    
    $checkbox_auma_menu_list = get_input_checkbox("auma_menu", $db_auma_menu_array, $checked_auma_menu_array, $color_auma_menu_array);
    
    tp_set($template, array(
        "no"                        =>  $no,
        "m_name_1"                  =>  $m_name_1_text,
        "m_name_2"                  =>  $m_name_2_array[$key],
        "checkbox_auma_menu_list" 	=>  $checkbox_auma_menu_list
    ));
    tp_parse($template);
    
    $prev_m_name_1 = $m_name_1_array[$key];                 // 이전 대메뉴명
}

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/footer.php");

?>