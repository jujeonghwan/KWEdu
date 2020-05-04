<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

tp_read($_SERVER["DOCUMENT_ROOT"] . "/worker/include/nav_not_login.html");

/*

// 메뉴
$query = "select ";
$query .= "m1.m_id as m_id_1, ";
$query .= "m1.m_name as m_name_1, ";
$query .= "m2.m_id as m_id_2, ";
$query .= "m2.m_name as m_name_2, ";
$query .= "m3.m_id as m_id_3, ";
$query .= "m3.m_name as m_name_3, ";
$query .= "m3.m_url as m_url_3 ";

$query .= "from menu_tb m1 ";                               // 메뉴1

$query .= "inner join menu_tb m2 ";                         // 메뉴2
$query .= "on m1.m_id = m2.m_parentid ";

$query .= "inner join menu_tb m3 ";                         // 메뉴3
$query .= "on m2.m_id = m3.m_parentid ";

$query .= "where m1.m_type = '" . $db_m_type_array["담당자"] . "' ";
$query .= "and m2.m_type = '" . $db_m_type_array["담당자"] . "' ";
$query .= "and m3.m_type = '" . $db_m_type_array["담당자"] . "' ";

$query .= "and m1.m_step = '" . $db_m_step_array["대메뉴"] . "' ";
$query .= "and m2.m_step = '" . $db_m_step_array["중메뉴"] . "' ";
$query .= "and m3.m_step = '" . $db_m_step_array["소메뉴"] . "' ";

$query .= "and m1.m_usestate = '" . $db_m_usestate_array["사용"] . "' ";
$query .= "and m2.m_usestate = '" . $db_m_usestate_array["사용"] . "' ";
$query .= "and m3.m_usestate = '" . $db_m_usestate_array["사용"] . "' ";

$query .= "order by m1.m_order, m2.m_order, m3.m_order ";

$result_nav = db_query($query);

$m_name_1_array = array();
$m_name_2_array = array();
$m_url_3_array = array();

while ($row_nav = db_fetch_array($result_nav)) {
    // 대메뉴
    $m_name_1_array[$row_nav["m_id_1"]] = $row_nav["m_name_1"];
    
    // 중메뉴
    $m_name_2_array[$row_nav["m_id_1"]][$row_nav["m_id_2"]] = $row_nav["m_name_2"];
    
    // 중메뉴에 해당하는 첫번째 소메뉴 URL
    if ($m_url_3_array[$row_nav["m_id_1"]][$row_nav["m_id_2"]] == "") {
        $m_url_3_array[$row_nav["m_id_1"]][$row_nav["m_id_2"]] = $row_nav["m_url_3"];        
    }   
}

$template = "row_nav";
tp_dynamic($template);

if (count($m_name_1_array) > 0) {
    foreach ($m_name_1_array as $key => $val) {
        
        $template_sub = "row_nav_sub";
        tp_dynamic($template_sub, $template);
        
        if (count($m_name_2_array[$key]) > 0) {
            foreach ($m_name_2_array[$key] as $key2 => $val2) {   
                tp_set($template_sub, array(
                    "m_url_3"   =>  $m_url_3_array[$key][$key2],
                    "m_name_2"  =>  $m_name_2_array[$key][$key2],
                ));
                tp_parse($template_sub);
            } 
        }
        
        tp_set($template, array(
            "m_name_1"  =>  $val
        ));
        tp_parse($template);
    }    
}


tp_set("session_wu_name", $_SESSION["session_wu_name"]);
tp_set("worker_logout_url", $PATH_VAR["worker_logout_url"]);
tp_set("worker_info_url", $PATH_VAR["worker_info_url"]);
tp_set("worker_password_url", $PATH_VAR["worker_password_url"]);

*/

tp_print();

?>