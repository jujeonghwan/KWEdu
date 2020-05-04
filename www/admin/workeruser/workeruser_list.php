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


// 승인상태
$search_wu_approvalstate = trim($_REQUEST["search_wu_approvalstate"]);
$option_array = array_flip($db_wu_approvalstate_array);
$option = get_select_option("--전체--", $option_array, $search_wu_approvalstate);
tp_set("option_search_wu_approvalstate", $option);

// 사용상태
$search_wu_usestate = trim($_REQUEST["search_wu_usestate"]);
$option_array = array_flip($db_wu_usestate_array);
$option = get_select_option("--전체--", $option_array, $search_wu_usestate);
tp_set("option_search_wu_usestate", $option);

// 검색어구분
$search_type_array = array (
    "wu_name"       =>  "이름(한글)",
    "wu_firstname"  =>  "First Name(영문)",
    "wu_lastname"   =>  "Last Name(영문)",
    "wu_loginid"    =>  "아이디",
    "wu_email"      =>  "이메일"
);

$search_type = trim($_REQUEST["search_type"]);
if ($search_type == "") {
    $search_type = key($search_type_array);                 // 배열의 첫번째 키값
}
$option_array = $search_type_array;
$option = get_select_option("", $option_array, $search_type);
tp_set("option_search_type", $option);

// 검색어
$search_keyword = trim($_REQUEST["search_keyword"]);
tp_set("search_keyword", $search_keyword);

// 페이지 초기화
$page = page_init();


// QUERY_STRING
$QUERY_STRING = "dummy=dummy";
$QUERY_STRING .= "&search_wu_approvalstate=" . $search_wu_approvalstate;
$QUERY_STRING .= "&search_wu_usestate=" . $search_wu_usestate;
$QUERY_STRING .= "&search_type=" . $search_type;
$QUERY_STRING .= "&search_keyword=" . urlencode($search_keyword);
$QUERY_STRING .= "&page=" . $page;



// 쿼리
$where_query = "where 1 = 1 ";
if ($search_wu_approvalstate != "") {
    $where_query .= "and wu_approvalstate = '" . $search_wu_approvalstate . "' ";
}
if ($search_wu_usestate != "") {
    $where_query .= "and wu_usestate = '" . $search_wu_usestate . "' ";
}
if (($search_type != "") && ($search_keyword != "")) {
    $where_query .= "and " . $search_type . " like '%" . $search_keyword . "%' ";
}

$orderby_query = "order by wu_id desc ";

// 전체개수
$query = "select count(*) as total_count ";
$query .= "from workeruser_tb ";
$query .= $where_query;

$result = db_query($query);
$row = db_fetch_array($result);

$total_rows = $row["total_count"];
$total_page = calc_total_page($total_rows, $PAGE_VAR["list_count"]); 
$begin_row = calc_begin_row($page, $PAGE_VAR["list_count"]); 
$no = calc_begin_no($total_rows, $begin_row);

tp_set("total_rows", number_format($total_rows));
tp_set("page", $page);   
tp_set("total_page", number_format($total_page));
tp_set("pagination_link_list", pagination_link_list($total_page, $page, $PAGE_VAR["page_count"], $PAGE_VAR["list_count"]));


// 목록
$template = "row";
tp_dynamic($template);

$query = "select ";
$query .= "wu_id, ";
$query .= "wu_name, ";
$query .= "wu_firstname, ";
$query .= "wu_lastname, ";
$query .= "wu_loginid, ";
$query .= "wu_email, ";
$query .= "wu_approvalstate, ";
$query .= "wu_usestate, ";
$query .= "wu_logindatetime ";
$query .= "from workeruser_tb ";
$query .= $where_query;
$query .= $orderby_query;
$query .= "limit " . $begin_row . ", " . $PAGE_VAR["list_count"] . " ";

$result = db_query($query);

while ($row = db_fetch_array($result)) {
    $no--;
    
    // 조회하기 링크
    $view_link_href = "workeruser_view.php?" . $QUERY_STRING . "&wu_id=" . $row["wu_id"];
    
    tp_set($template, array(
        "no"                        =>  $no,
        "view_link_href"            =>  $view_link_href,
        "wu_name"                   =>  $row["wu_name"],
        
        "wu_firstname"              =>  $row["wu_firstname"],
        "wu_lastname"               =>  $row["wu_lastname"],
        "wu_loginid"                =>  $row["wu_loginid"],
        "wu_email"                  =>  $row["wu_email"],
        
        "color_wu_approvalstate"    =>  $color_wu_approvalstate_array[$row["wu_approvalstate"]],  
        "wu_approvalstate"          =>  array_search($row["wu_approvalstate"], $db_wu_approvalstate_array),
        "color_wu_usestate"         =>  $color_wu_usestate_array[$row["wu_usestate"]],  
        "wu_usestate"               =>  array_search($row["wu_usestate"], $db_wu_usestate_array),
        "wu_logindatetime"          =>  get_datetime_format($row["wu_logindatetime"])
    ));
    tp_parse($template);
}

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/footer.php");

?>