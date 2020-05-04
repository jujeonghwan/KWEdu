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


// 대메뉴
$search_m_id_1 = trim($_REQUEST["search_m_id_1"]);

$query = "select ";
$query .= "m_id, ";
$query .= "m_name ";
$query .= "from menu_tb ";
$query .= "where m_type = '" . $db_m_type_array["관리자"] . "' ";
$query .= "and m_step = '" . $db_m_step_array["대메뉴"] . "' ";
$query .= "order by m_order, m_id ";

$result = db_query($query);

$db_m_id_1_array = array();
while ($row = db_fetch_array($result)) {
    $db_m_id_1_array[$row["m_id"]] = $row["m_name"];
}
$option_array = $db_m_id_1_array;
$option = get_select_option("--전체--", $option_array, $search_m_id_1);
tp_set("option_search_m_id_1", $option);

// 사용상태
$search_m_usestate = trim($_REQUEST["search_m_usestate"]);
$option_array = array_flip($db_m_usestate_array);
$option = get_select_option("--전체--", $option_array, $search_m_usestate);
tp_set("option_search_m_usestate", $option);


// QUERY_STRING
$QUERY_STRING = "dummy=dummy";
$QUERY_STRING .= "&search_m_id_1=" . $search_m_id_1;
$QUERY_STRING .= "&search_m_usestate=" . $search_m_usestate;

// 등록하기 버튼 링크
$insert_link_href = "admin_menu_insert.php?" . $QUERY_STRING;
tp_set("insert_link_href", $insert_link_href);


// 목록
$template = "row";
tp_dynamic($template);

////////////////////////////////////////////////////////////////////////////////
// 대메뉴
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
$query .= "where 1 = 1 ";
if ($search_m_id_1 != "") {
    $query .= "and m_id = '" . $search_m_id_1 . "' ";
}
$query .= "and m_type = '" . $db_m_type_array["관리자"] . "' ";
$query .= "and m_step = '" . $db_m_step_array["대메뉴"] . "' ";
if ($search_m_usestate != "") {
    $query .= "and m_usestate = '" . $search_m_usestate . "' ";
}
$query .= "order by m_order ";

$result = db_query($query);

$no = 0;
$prev_m_id_1 = "";                      // 이전 메뉴번호 (대메뉴)

while ($row = db_fetch_array($result)) {
    $no++;
    
    // 조회하기 링크
    $view_link_href_1 = "admin_menu_view.php?" . $QUERY_STRING . "&m_id=" . $row["m_id"];
    
    // 순서변경 버튼
    if ($prev_m_id_1 != "") {
        $order_change_link_href_1 = "admin_menu_order_change.php?" . $QUERY_STRING . "&m_id=" . $row["m_id"] . "&prev_m_id=" . $prev_m_id_1;
        
        $button_order_change_1 = "<a class=\"btn btn-default btn-xs\" href=\"" . $order_change_link_href_1 . "\" role=\"button\"> ▲ </a>";    
    }
    else {
        $button_order_change_1 = "";    
    }
    
    tp_set($template, array(
        "no"                    =>  $no,
        
        "view_link_href_1"      =>  $view_link_href_1,
        "m_name_1"              =>  $row["m_name"],
        "color_m_usestate_1"    =>  $color_m_usestate_array[$row["m_usestate"]],  
        "m_usestate_1"          =>  array_search($row["m_usestate"], $db_m_usestate_array),
        "button_order_change_1" =>  $button_order_change_1,
        
        "view_link_href_2"      =>  "",
        "m_name_2"              =>  "",
        "color_m_usestate_2"    =>  "",
        "m_usestate_2"          =>  "",
        "button_order_change_2" =>  "",
        
        "view_link_href_3"      =>  "",
        "m_name_3"              =>  "",
        "color_m_usestate_3"    =>  "",
        "m_usestate_3"          =>  "",
        "button_order_change_3" =>  "",
        "m_url_3"               =>  ""
    ));
    tp_parse($template);
    
    $prev_m_id_1 = $row["m_id"];        // 이전 메뉴번호 (대메뉴)
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 중메뉴
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
    $query .= "where 1 = 1 ";
    $query .= "and m_type = '" . $db_m_type_array["관리자"] . "' ";
    $query .= "and m_step = '" . $db_m_step_array["중메뉴"] . "' ";
    $query .= "and m_parentid = '" . $row["m_id"] . "' ";
    if ($search_m_usestate != "") {
        $query .= "and m_usestate = '" . $search_m_usestate . "' ";
    }
    $query .= "order by m_order ";
    
    $result_sub = db_query($query);
    
    $prev_m_id_2 = "";                  // 이전 메뉴번호 (중메뉴)
    
    while ($row_sub = db_fetch_array($result_sub)) {
        $no++;
        
        // 조회하기 링크
        $view_link_href_2 = "admin_menu_view.php?" . $QUERY_STRING . "&m_id=" . $row_sub["m_id"];
        
        // 순서변경 버튼
        if ($prev_m_id_2 != "") {
            $order_change_link_href_2 = "admin_menu_order_change.php?" . $QUERY_STRING . "&m_id=" . $row_sub["m_id"] . "&prev_m_id=" . $prev_m_id_2;
            
            $button_order_change_2 = "<a class=\"btn btn-default btn-xs\" href=\"" . $order_change_link_href_2 . "\" role=\"button\"> ▲ </a>";    
        }
        else {
            $button_order_change_2 = "";    
        }
        
        tp_set($template, array(
            "no"                    =>  $no,
            
            "view_link_href_1"      =>  "",
            "m_name_1"              =>  "",
            "color_m_usestate_1"    =>  "",
            "m_usestate_1"          =>  "",
            "button_order_change_1" =>  "",
            
            "view_link_href_2"      =>  $view_link_href_2,
            "m_name_2"              =>  $row_sub["m_name"],
            "color_m_usestate_2"    =>  $color_m_usestate_array[$row_sub["m_usestate"]],
            "m_usestate_2"          =>  array_search($row_sub["m_usestate"], $db_m_usestate_array),
            "button_order_change_2" =>  $button_order_change_2,
            
            "view_link_href_3"      =>  "",
            "m_name_3"              =>  "",
            "color_m_usestate_3"    =>  "",
            "m_usestate_3"          =>  "",
            "button_order_change_3" =>  "",
            "m_url_3"               =>  ""
        ));
        tp_parse($template);
        
        $prev_m_id_2 = $row_sub["m_id"];                    // 이전 메뉴번호 (중메뉴)  
        
        
        ////////////////////////////////////////////////////////////////////////////////
        // 소메뉴
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
        $query .= "where 1 = 1 ";
        $query .= "and m_type = '" . $db_m_type_array["관리자"] . "' ";
        $query .= "and m_step = '" . $db_m_step_array["소메뉴"] . "' ";
        $query .= "and m_parentid = '" . $row_sub["m_id"] . "' ";
        if ($search_m_usestate != "") {
            $query .= "and m_usestate = '" . $search_m_usestate . "' ";
        }
        $query .= "order by m_order ";
        
        $result_sub_sub = db_query($query);
        
        $prev_m_id_3 = "";              // 이전 메뉴번호 (소메뉴)
        
        while ($row_sub_sub = db_fetch_array($result_sub_sub)) {
            $no++;
            
            // 조회하기 링크
            $view_link_href_3 = "admin_menu_view.php?" . $QUERY_STRING . "&m_id=" . $row_sub_sub["m_id"];
            
            // 순서변경 버튼
            if ($prev_m_id_3 != "") {
                $order_change_link_href_3 = "admin_menu_order_change.php?" . $QUERY_STRING . "&m_id=" . $row_sub_sub["m_id"] . "&prev_m_id=" . $prev_m_id_3;
                
                $button_order_change_3 = "<a class=\"btn btn-default btn-xs\" href=\"" . $order_change_link_href_3 . "\" role=\"button\"> ▲ </a>";    
            }
            else {
                $button_order_change_3 = "";    
            }
            
            tp_set($template, array(
                "no"                    =>  $no,
                
                "view_link_href_1"      =>  "",
                "m_name_1"              =>  "",
                "color_m_usestate_1"    =>  "",
                "m_usestate_1"          =>  "",
                "button_order_change_1" =>  "",
                
                "view_link_href_2"      =>  "",
                "m_name_2"              =>  "",
                "color_m_usestate_2"    =>  "",
                "m_usestate_2"          =>  "",
                "button_order_change_2" =>  "",
                
                "view_link_href_3"      =>  $view_link_href_3,
                "m_name_3"              =>  $row_sub_sub["m_name"],
                "color_m_usestate_3"    =>  $color_m_usestate_array[$row_sub_sub["m_usestate"]],
                "m_usestate_3"          =>  array_search($row_sub_sub["m_usestate"], $db_m_usestate_array),
                "button_order_change_3" =>  $button_order_change_3,
                "m_url_3"               =>  $row_sub_sub["m_url"]
            ));
            tp_parse($template);
            
            $prev_m_id_3 = $row_sub_sub["m_id"];            // 이전 메뉴번호 (소메뉴)  
        }   
    }
}

$total_rows = $no;
tp_set("total_rows", number_format($total_rows));

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/footer.php");

?>