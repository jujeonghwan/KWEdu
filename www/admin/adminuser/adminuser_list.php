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
$search_au_usestate = trim($_REQUEST["search_au_usestate"]);
$option_array = array_flip($db_au_usestate_array);
$option = get_select_option("--전체--", $option_array, $search_au_usestate);
tp_set("option_search_au_usestate", $option);

// 검색어구분
$search_type_array = array (
    "au_name"       =>  "이름",
    "au_loginid"    =>  "아이디",
    "au_email"      =>  "이메일",
    "au_mobile"     =>  "휴대폰"
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
$QUERY_STRING .= "&search_au_usestate=" . $search_au_usestate;
$QUERY_STRING .= "&search_type=" . $search_type;
$QUERY_STRING .= "&search_keyword=" . urlencode($search_keyword);
$QUERY_STRING .= "&page=" . $page;

// 등록하기 버튼 링크
$insert_link_href = "adminuser_insert.php?" . $QUERY_STRING;
tp_set("insert_link_href", $insert_link_href);


// 쿼리
$where_query = "where 1 = 1 ";
if ($search_au_usestate != "") {
    $where_query .= "and au_usestate = '" . $search_au_usestate . "' ";
}
if (($search_type != "") && ($search_keyword != "")) {
    $where_query .= "and " . $search_type . " like '%" . $search_keyword . "%' ";
}

$orderby_query = "order by au_id desc ";

// 전체개수
$query = "select count(*) as total_count ";
$query .= "from adminuser_tb ";
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
$query .= "au_id, ";
$query .= "au_name, ";
$query .= "au_loginid, ";
$query .= "au_password, ";
$query .= "au_email, ";
$query .= "au_mobile, ";
$query .= "au_usestate, ";
$query .= "au_logindatetime ";
$query .= "from adminuser_tb ";
$query .= $where_query;
$query .= $orderby_query;
$query .= "limit " . $begin_row . ", " . $PAGE_VAR["list_count"] . " ";

$result = db_query($query);

while ($row = db_fetch_array($result)) {
    $no--;
    
    // 조회하기 링크
    $view_link_href = "adminuser_view.php?" . $QUERY_STRING . "&au_id=" . $row["au_id"];
    
    tp_set($template, array(
        "no"                =>  $no,
        "view_link_href"    =>  $view_link_href,
        "au_name"           =>  $row["au_name"],
        
        "au_loginid"        =>  $row["au_loginid"],
        "au_email"          =>  $row["au_email"],
        "au_mobile"         =>  $row["au_mobile"],
        
        "color_au_usestate" =>  $color_au_usestate_array[$row["au_usestate"]],  
        "au_usestate"       =>  array_search($row["au_usestate"], $db_au_usestate_array),
        "au_logindatetime"  =>  get_datetime_format($row["au_logindatetime"])
    ));
    tp_parse($template);
}

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/footer.php");

?>