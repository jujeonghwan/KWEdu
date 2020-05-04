<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

tp_read($_SERVER["DOCUMENT_ROOT"] . "/include/footer.html");

// 회사명
tp_set("company_name", $SITE_VAR["company_name"]);

// 주소
tp_set("company_address", $SITE_VAR["company_address"]);

// 회사 주, 국가
tp_set("company_province_country", $SITE_VAR["company_province_country"]);

// 전화
tp_set("tel", $SITE_VAR["tel"]);

// 이메일
tp_set("email", $SITE_VAR["email"]);

// 카카오톡ID
tp_set("kakaotalk", $SITE_VAR["kakaotalk"]);


// Copyright 년도
$copyright_year = current_year();
tp_set("copyright_year", $copyright_year);

tp_print();

?>