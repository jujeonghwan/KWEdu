<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

tp_read($_SERVER["DOCUMENT_ROOT"] . "/include/header.html");

////////////////////////////////////////////////////////////////////////////////
// 타이틀
tp_set("title", $SITE_VAR["title"]);

// 카카오톡ID
tp_set("kakaotalk", $SITE_VAR["kakaotalk"]);

// 이메일
tp_set("email", $SITE_VAR["email"]);

// 전화
tp_set("tel", $SITE_VAR["tel"]);


////////////////////////////////////////////////////////////////////////////////
// 로그인 상태에 따라 보여줌
if (user_login_status()) {
	$header_logout_status_begin = "<!--";
	$header_logout_status_end = "-->";

	$header_login_status_begin = "";
	$header_login_status_end = "";
}
else {
	$header_logout_status_begin = "";
	$header_logout_status_end = "";

	$header_login_status_begin = "<!--";
	$header_login_status_end = "-->";
}

tp_set("header_logout_status_begin", $header_logout_status_begin);
tp_set("header_logout_status_end", $header_logout_status_end);
tp_set("header_login_status_begin", $header_login_status_begin);
tp_set("header_login_status_end", $header_login_status_end);

tp_set("session_u_name", $_SESSION["session_u_name"]);


////////////////////////////////////////////////////////////////////////////////
// 회원 가입 폼

tp_set("site_name", $SITE_VAR["name"]);

// 년
$join_u_birthdate_year_begin = $SITE_VAR["birthdate_year_begin"];
$join_u_birthdate_year_end = current_year();

$join_u_birthdate_year_temp = $join_u_birthdate_year_end;

$join_u_birthdate_year_array = array();

while ($join_u_birthdate_year_temp >= $join_u_birthdate_year_begin)
{
	$join_u_birthdate_year_array[$join_u_birthdate_year_temp] = $join_u_birthdate_year_temp . "년";

	$join_u_birthdate_year_temp = year_difference_year($join_u_birthdate_year_temp, -1);
}

$option_array = $join_u_birthdate_year_array;
$option = get_select_option("-년-", $option_array, "");
tp_set("option_join_u_birthdate_year", $option);

// 월
$option_array = array_flip($MONTH_ARRAY);
$option = get_select_option("-월-", $option_array, "");
tp_set("option_join_u_birthdate_month", $option);

// 일
$option_array = array_flip($DAY_ARRAY);
$option = get_select_option("-일-", $option_array, "");
tp_set("option_join_u_birthdate_day", $option);

// 성별
$radio_array = array_flip($db_u_gendertype_array);
$radio = get_input_radio("join_u_gendertype", $radio_array, "", $color_join_u_gendertype_array);
tp_set("radio_join_u_gendertype", $radio);



////////////////////////////////////////////////////////////////////////////////
// User Top Menu List
$get_user_top_menu_list = get_user_top_menu_list();
tp_set("user_top_menu_list", $get_user_top_menu_list);

// Menu Name (Inner Heading)
$menu_name = get_menu_name();
tp_set("menu_name", $menu_name);

// User Menu Navigator
$user_menu_navigator = get_user_menu_navigator();
tp_set("user_menu_navigator", $user_menu_navigator);


tp_print();

?>