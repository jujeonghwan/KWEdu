<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Worker 로그아웃 체크
worker_logout_check();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/worker/include/header.php");
// require_once ($_SERVER["DOCUMENT_ROOT"] . "/worker/include/nav.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/worker/include/nav_not_login.php");

tp_read();

// 경로
tp_set("menu_navigator", get_menu_navigator());


// 목록 페이지 조회조건 (없음)

// 로그인페이지 가기 버튼 링크
tp_set("login_link_href", $PATH_VAR["worker_login_url"]);


// 생년월일
// 년
$wu_birthdate_year_begin = $SITE_VAR["birthdate_year_begin"];
$wu_birthdate_year_end = current_year();

$wu_birthdate_year_temp = $wu_birthdate_year_end;

$wu_birthdate_year_array = array();

while ($wu_birthdate_year_temp >= $wu_birthdate_year_begin)
{
	$wu_birthdate_year_array[$wu_birthdate_year_temp] = $wu_birthdate_year_temp . "년";

	$wu_birthdate_year_temp = year_difference_year($wu_birthdate_year_temp, -1);
}

$option_array = $wu_birthdate_year_array;
$option = get_select_option("-년-", $option_array, "");
tp_set("option_wu_birthdate_year", $option);

// 월
$option_array = array_flip($MONTH_ARRAY);
$option = get_select_option("-월-", $option_array, "");
tp_set("option_wu_birthdate_month", $option);

// 일
$option_array = array_flip($DAY_ARRAY);
$option = get_select_option("-일-", $option_array, "");
tp_set("option_wu_birthdate_day", $option);

// 성별
$radio_array = array_flip($db_wu_gendertype_array);
$radio = get_input_radio("wu_gendertype", $radio_array, "", $color_wu_gendertype_array);
tp_set("radio_wu_gendertype", $radio);


tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/worker/include/footer.php");

?>