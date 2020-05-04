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
tp_set("search_m_id_1", $_REQUEST["search_m_id_1"]);
tp_set("search_m_usestate", $_REQUEST["search_m_usestate"]);


// QUERY_STRING
$QUERY_STRING = "dummy=dummy";
$QUERY_STRING .= "&search_m_id_1=" . $_REQUEST["search_m_id_1"];
$QUERY_STRING .= "&search_m_usestate=" . $_REQUEST["search_m_usestate"];

// 목록보기 버튼 링크
$list_link_href = "admin_menu_list.php?" . $QUERY_STRING;
tp_set("list_link_href", $list_link_href);

// 수정하기 버튼 링크
$update_link_href = "admin_menu_update.php?" . $QUERY_STRING . "&m_id=" . $_REQUEST["m_id"];
tp_set("update_link_href", $update_link_href);


// 메뉴번호
$m_id = trim($_REQUEST["m_id"]);

// 조회
$query = "select ";
$query .= "m_id, ";
$query .= "m_type, ";
$query .= "m_step, ";
$query .= "m_parentid, ";
$query .= "m_name, ";
$query .= "m_url, ";
$query .= "m_usestate, ";
$query .= "m_order ";
$query .= "from menu_tb ";
$query .= "where m_id = '" . $m_id . "' ";

$result = db_query($query);

if (!$row = db_fetch_array($result)) {
    alert_back("해당 항목이 존재하지 않습니다.");
}

tp_set("m_step", array_search($row["m_step"], $db_m_step_array));

// 상위메뉴
$m_parentid_name_list = "";

if ($row["m_step"] == $db_m_step_array["대메뉴"]) {
    $m_parentid_name_list = "";    
}
else if ($row["m_step"] == $db_m_step_array["중메뉴"]) {
    // 대메뉴명
    $query = "select ";
    $query .= "m_name ";
    $query .= "from menu_tb ";
    $query .= "where m_id = '" . $row["m_parentid"] . "' ";
    
    $result_sub = db_query($query);
    
    if ($row_sub = db_fetch_array($result_sub)) {
        $m_parentid_name_list = $row_sub["m_name"];   
    }
}
else if ($row["m_step"] == $db_m_step_array["소메뉴"]) {
    // 중메뉴명
    $query = "select ";
    $query .= "m_parentid, ";
    $query .= "m_name ";
    $query .= "from menu_tb ";
    $query .= "where m_id = '" . $row["m_parentid"] . "' ";
    
    $result_sub = db_query($query);
    
    if ($row_sub = db_fetch_array($result_sub)) {
        $m_parentid_name_list = $row_sub["m_name"];         // 중메뉴명
        
        // 대메뉴명
        $query = "select ";
        $query .= "m_name ";
        $query .= "from menu_tb ";
        $query .= "where m_id = '" . $row_sub["m_parentid"] . "' ";
        
        $result_sub_sub = db_query($query);
        
        if ($row_sub_sub = db_fetch_array($result_sub_sub)) {
            $m_parentid_name_list = $row_sub_sub["m_name"] . " &gt; " . $m_parentid_name_list;
        }        
    }
}
tp_set("m_parentid_name_list", $m_parentid_name_list);

tp_set("m_name", $row["m_name"]);
tp_set("m_url", $row["m_url"]);
tp_set("color_m_usestate", $color_m_usestate_array[$row["m_usestate"]]);
tp_set("m_usestate", array_search($row["m_usestate"], $db_m_usestate_array));
tp_set("m_order", $row["m_order"]);

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/footer.php");

?>