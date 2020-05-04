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
$list_link_href = "mypage_menu_list.php?" . $QUERY_STRING;
tp_set("list_link_href", $list_link_href);



// 메뉴번호
$m_id = trim($_REQUEST["m_id"]);
tp_set("m_id", $m_id);

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

tp_set("m_step", $row["m_step"]);
tp_set("m_step_text", array_search($row["m_step"], $db_m_step_array));

if ($row["m_step"] == $db_m_step_array["중메뉴"]) {
    
    // 대메뉴
    $query = "select ";
    $query .= "m_id, ";
    $query .= "m_name ";
    $query .= "from menu_tb ";
    $query .= "where m_type = '" . $db_m_type_array["고객"] . "' ";
    $query .= "and m_step = '" . $db_m_step_array["대메뉴"] . "' ";
    $query .= "order by m_order ";
    
    $result_sub = db_query($query);
    
    $data_list_array = array();
    while ($row_sub = db_fetch_array($result_sub)) {
        $data_list_array[$row_sub["m_id"]] = $row_sub["m_name"];
    }
    $option_array = $data_list_array;
    $option = get_select_option("--선택--", $option_array, $row["m_parentid"]);
    tp_set("option_m_parentid_1", $option);
    
}
else if ($row["m_step"] == $db_m_step_array["소메뉴"]) {
    
    // 대메뉴번호
    $query = "select ";
    $query .= "m_parentid as m_parentid_1 ";
    $query .= "from menu_tb ";
    $query .= "where m_step = '" . $db_m_step_array["중메뉴"] . "' ";
    $query .= "and m_id = '" . $row["m_parentid"] . "' ";
    
    $result_sub = db_query($query);
    
    if ($row_sub = db_fetch_array($result_sub)) {
        $m_parentid_1 = $row_sub["m_parentid_1"];   
    }
    
    // 대메뉴
    $query = "select ";
    $query .= "m_id, ";
    $query .= "m_name ";
    $query .= "from menu_tb ";
    $query .= "where m_type = '" . $db_m_type_array["고객"] . "' ";
    $query .= "and m_step = '" . $db_m_step_array["대메뉴"] . "' ";
    $query .= "order by m_order ";
    
    $result_sub = db_query($query);
    
    $data_list_array = array();
    while ($row_sub = db_fetch_array($result_sub)) {
        $data_list_array[$row_sub["m_id"]] = $row_sub["m_name"];
    }
    $option_array = $data_list_array;
    $option = get_select_option("--선택--", $option_array, $m_parentid_1);
    tp_set("option_m_parentid_1", $option);
    
    // 중메뉴
    $query = "select ";
    $query .= "m_id, ";
    $query .= "m_name ";
    $query .= "from menu_tb ";
    $query .= "where m_step = '" . $db_m_step_array["중메뉴"] . "' ";
    $query .= "and m_parentid = '" . $m_parentid_1 . "' ";
    $query .= "order by m_order ";
    
    $result_sub = db_query($query);
    
    $data_list_array = array();
    while ($row_sub = db_fetch_array($result_sub)) {
        $data_list_array[$row_sub["m_id"]] = $row_sub["m_name"];
    }
    $option_array = $data_list_array;
    $option = get_select_option("--선택--", $option_array, $row["m_parentid"]);
    tp_set("option_m_parentid_2", $option);
}

tp_set("m_name", $row["m_name"]);
tp_set("m_url", $row["m_url"]);

// 사용상태
$radio_array = array_flip($db_m_usestate_array);
$radio = get_input_radio("m_usestate", $radio_array, $row["m_usestate"], $color_m_usestate_array);
tp_set("radio_m_usestate", $radio);

tp_set("m_order", $row["m_order"]);

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/footer.php");

?>