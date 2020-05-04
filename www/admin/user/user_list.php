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


// 사용상태
$search_u_usestate = trim($_REQUEST["search_u_usestate"]);
$option_array = array_flip($db_u_usestate_array);
$option = get_select_option("--전체--", $option_array, $search_u_usestate);
tp_set("option_search_u_usestate", $option);

// 검색어구분
$search_type_array = array (
    "u_name"        =>  "이름(한글)",
    "u_firstname"   =>  "First Name(영문)",
    "u_lastname"    =>  "Last Name(영문)",
    "u_loginid"     =>  "아이디",
    "u_email"       =>  "이메일"
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
$QUERY_STRING .= "&search_u_usestate=" . $search_u_usestate;
$QUERY_STRING .= "&search_type=" . $search_type;
$QUERY_STRING .= "&search_keyword=" . urlencode($search_keyword);
$QUERY_STRING .= "&page=" . $page;


// 쿼리
$where_query = "where 1 = 1 ";
if ($search_u_usestate != "") {
    $where_query .= "and u_usestate = '" . $search_u_usestate . "' ";
}
if (($search_type != "") && ($search_keyword != "")) {
    $where_query .= "and " . $search_type . " like '%" . $search_keyword . "%' ";
}

$orderby_query = "order by u_id desc ";

// 전체개수
$query = "select count(*) as total_count ";
$query .= "from user_tb ";
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
$query .= "u_id, ";
$query .= "u_name, ";
$query .= "u_firstname, ";
$query .= "u_lastname, ";
$query .= "u_preferredname, ";
$query .= "u_loginid, ";
$query .= "u_password, ";
$query .= "u_birthdate, ";
$query .= "u_email, ";
$query .= "u_gendertype, ";
$query .= "u_contryofbirth, ";
$query .= "u_contryofcitizenship, ";
$query .= "u_passportnumber, ";
$query .= "u_usestate, ";
$query .= "u_logindatetime ";
$query .= "from user_tb ";
$query .= $where_query;
$query .= $orderby_query;
$query .= "limit " . $begin_row . ", " . $PAGE_VAR["list_count"] . " ";

$result = db_query($query);

while ($row = db_fetch_array($result)) {
    $no--;
    
    // 조회하기 링크
    $view_link_href = "user_view.php?" . $QUERY_STRING . "&u_id=" . $row["u_id"];
    
    tp_set($template, array(
        "no"                =>  $no,
        "view_link_href"    =>  $view_link_href,
        "u_name"            =>  $row["u_name"],
        "u_firstname"       =>  $row["u_firstname"],
        "u_lastname"        =>  $row["u_lastname"],
        
        "u_loginid"         =>  $row["u_loginid"],
        "u_email"           =>  $row["u_email"],
        
        "color_u_usestate"  =>  $color_u_usestate_array[$row["u_usestate"]],  
        "u_usestate"        =>  array_search($row["u_usestate"], $db_u_usestate_array),
        "u_logindatetime"   =>  get_datetime_format($row["u_logindatetime"])
    ));
    tp_parse($template);
}

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/footer.php");

?>