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
tp_set("search_u_usestate", $_REQUEST["search_u_usestate"]);
tp_set("search_type", $_REQUEST["search_type"]);
tp_set("search_keyword", $_REQUEST["search_keyword"]);
tp_set("page", $_REQUEST["page"]);


// QUERY_STRING
$QUERY_STRING = "dummy=dummy";
$QUERY_STRING .= "&search_u_usestate=" . $_REQUEST["search_u_usestate"];
$QUERY_STRING .= "&search_type=" . $_REQUEST["search_type"];
$QUERY_STRING .= "&search_keyword=" . urlencode($_REQUEST["search_keyword"]);
$QUERY_STRING .= "&page=" . $_REQUEST["page"];

// 목록보기 버튼 링크
$list_link_href = "user_list.php?" . $QUERY_STRING;
tp_set("list_link_href", $list_link_href);

// 수정하기 버튼 링크
$update_link_href = "user_update.php?" . $QUERY_STRING . "&u_id=" . $_REQUEST["u_id"];
tp_set("update_link_href", $update_link_href);


// 사용자번호
$u_id = trim($_REQUEST["u_id"]);

// 조회
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
$query .= "where u_id = '" . $u_id . "' ";

$result = db_query($query);

if (!$row = db_fetch_array($result)) {
    alert_back("해당 항목이 존재하지 않습니다.");
}

tp_set("u_name", $row["u_name"]);
tp_set("u_firstname", $row["u_firstname"]);
tp_set("u_lastname", $row["u_lastname"]);
tp_set("u_preferredname", $row["u_preferredname"]);

tp_set("u_loginid", $row["u_loginid"]);

tp_set("u_birthdate", get_date_format($row["u_birthdate"]));

tp_set("color_u_gendertype", $color_u_gendertype_array[$row["u_gendertype"]]);
tp_set("u_gendertype", array_search($row["u_gendertype"], $db_u_gendertype_array));

tp_set("u_email", $row["u_email"]);

tp_set("u_contryofbirth", $row["u_contryofbirth"]);
tp_set("u_contryofcitizenship", $row["u_contryofcitizenship"]);
tp_set("u_passportnumber", $row["u_passportnumber"]);

tp_set("color_u_usestate", $color_u_usestate_array[$row["u_usestate"]]);
tp_set("u_usestate", array_search($row["u_usestate"], $db_u_usestate_array));
tp_set("u_logindatetime", get_datetime_format($row["u_logindatetime"]));

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/include/footer.php");

?>