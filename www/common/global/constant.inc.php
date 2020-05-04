<?php

////////////////////////////////////////////////////////////////////////////////
// Site setting

$SITE_VAR["host"] = "kweduconsulting.wst.kr";
$SITE_VAR["domain"] = $SITE_VAR["host"];                    // kweduconsulting.wst.kr

$SITE_VAR["url"] = "http://" . $SITE_VAR["domain"] . "/";   // http://kweduconsulting.wst.kr/
$SITE_VAR["title"] = "KW EDU Consulting - 캐나다 워터루 현지 유학원";
$SITE_VAR["keywords"] = "캐나다 워터루 현지 유학원";                 
$SITE_VAR["description"] = "캐나다 워터루 현지 유학원, KW EDU Consulting, KW 에듀컨설팅";     
$SITE_VAR["name"] = "KW 에듀컨설팅";
$SITE_VAR["company_name"] = "KW 에듀컨설팅";                     // 회사명
$SITE_VAR["company_address"] = "Kitchener";                     // 주소
$SITE_VAR["company_province_country"] = "Ontario, Canada";      // 회사 주, 국가

$SITE_VAR["home_name"] = "KW EDU";

$SITE_VAR["email"] = "info@kweduconsulting.com";            // 이메일
$SITE_VAR["dev_email"] = "jujeonghwan@gmail.com";
$SITE_VAR["tel"] = "+1 226 792 2753";                       // 전화
$SITE_VAR["kakaotalk"] = "KWEdu";                           // 카카오톡ID


// 추가 설정
$SITE_VAR["birthdate_year_begin"] = "1900";
$SITE_VAR["vehicleyear_begin"] = "2000";                    // 자동차년도 기준 시작년도


////////////////////////////////////////////////////////////////////////////////
// Page setting
$PAGE_VAR["page_count"] = 10;
$PAGE_VAR["list_count"] = 20;


////////////////////////////////////////////////////////////////////////////////
// Page path setting

// Default path
$PATH_VAR["default_url"] = "/";

// (고객)
// User path 
$PATH_VAR["user_default_url"] = "/";
// User login path
$PATH_VAR["user_login_url"] = "/login/";
// User logout path
$PATH_VAR["user_logout_url"] = "/login/logout.php";

// User mypage_path 
$PATH_VAR["user_mypage_url"] = "/mypage/";
/*
// Client path 
$PATH_VAR["client_default_url"] = "/client/";
// Client login path
$PATH_VAR["client_login_url"] = "/client/login/";
// Client logout path
$PATH_VAR["client_logout_url"] = "/client/login/logout.php";
*/

// (업무담당자)
// Worker path 
$PATH_VAR["worker_default_url"] = "/worker/";
// Worker login path
$PATH_VAR["worker_login_url"] = "/worker/login/";
// Worker logout path
$PATH_VAR["worker_logout_url"] = "/worker/login/logout.php";

// Worker join path
$PATH_VAR["worker_join_url"] = "/worker/workeruser/workeruser_join.php";
// Worker info path
$PATH_VAR["worker_info_url"] = "/worker/workeruser/workeruser_info.php";
// Worker password path
$PATH_VAR["worker_password_url"] = "/worker/workeruser/workeruser_password.php";

// (관리자)
// Admin path 
$PATH_VAR["admin_default_url"] = "/admin/";
// Admin login path
$PATH_VAR["admin_login_url"] = "/admin/login/";
// Admin logout path
$PATH_VAR["admin_logout_url"] = "/admin/login/logout.php";


////////////////////////////////////////////////////////////////////////////////
// File path setting

// Home directory path
$PATH_VAR["home_path"] = "/sigakorea/www";                  // Home path

$PATH_VAR["attachfile_url"] = "/files/attachfile";          // 첨부파일
$PATH_VAR["attachfile_path"] = $_SERVER["DOCUMENT_ROOT"] . $PATH_VAR["attachfile_url"];

$PATH_VAR["imagefile_url"] = "/files/imagefile";            // 이미지파일
$PATH_VAR["imagefile_path"] = $_SERVER["DOCUMENT_ROOT"] . $PATH_VAR["imagefile_url"];


////////////////////////////////////////////////////////////////////////////////
// Email setting

// Email Title & Content

// 비밀번호 찾기 (관리자, 담당자)
$EMAIL_VAR["title_search_password"] = "[" . $SITE_VAR["name"] . "] {user_name}님 비밀번호가 초기화 되었습니다.";
$EMAIL_VAR["content_search_password"] = "{user_name}님 비밀번호가 {user_password} 로 초기화 되었습니다.";

// 사용자(회원) 비밀번호 초기화
$EMAIL_VAR["title_user_password_reset"] = "[" . $SITE_VAR["name"] . "] {u_name}님 비밀번호가 초기화 되었습니다.";
$EMAIL_VAR["content_user_password_reset"] = "{u_name}님 비밀번호가 {u_password} 로 초기화 되었습니다.<br />";
$EMAIL_VAR["content_user_password_reset"] .= "<br />";
$EMAIL_VAR["content_user_password_reset"] .= "<a href=\"{site_url}\">{site_url}</a><br />";

// 회원 가입
$EMAIL_VAR["title_user_join"] = "[" . $SITE_VAR["name"] . "] {u_name}님 회원가입 되었습니다.";
$EMAIL_VAR["content_user_join"] = "{u_name}님 회원가입해주셔서 감사합니다.<br />";
$EMAIL_VAR["content_user_join"] .= "가입하신 회원 가입 정보는 아래와 같습니다.<br />";
$EMAIL_VAR["content_user_join"] .= "<br />";
$EMAIL_VAR["content_user_join"] .= "이름(한글): {u_name}<br />";
$EMAIL_VAR["content_user_join"] .= "First Name(영문): {u_firstname}<br />";
$EMAIL_VAR["content_user_join"] .= "Last Name(영문): {u_lastname}<br />";
$EMAIL_VAR["content_user_join"] .= "Preferred Name(영문): {u_preferredname}<br />";
$EMAIL_VAR["content_user_join"] .= "아이디: {u_loginid}<br />";
$EMAIL_VAR["content_user_join"] .= "비밀번호: {u_password}<br />";
$EMAIL_VAR["content_user_join"] .= "생년월일: {u_birthdate_year}년 {u_birthdate_month}월 {join_u_birthdate_day}일<br />";
$EMAIL_VAR["content_user_join"] .= "이메일: {u_email}<br />";
$EMAIL_VAR["content_user_join"] .= "성별(Gender): {u_gendertype}<br />";
$EMAIL_VAR["content_user_join"] .= "출생국가(Country of Birth): {u_contryofbirth}<br />";
$EMAIL_VAR["content_user_join"] .= "국적(Country of Citizenship): {u_contryofcitizenship}<br />";
$EMAIL_VAR["content_user_join"] .= "여권번호(Passport Number): {u_passportnumber}<br />";
$EMAIL_VAR["content_user_join"] .= "<br />";
$EMAIL_VAR["content_user_join"] .= "<a href=\"{site_url}\">{site_url}</a><br />";

////////////////////////////////////////////////////////////////////////////////
// Page name

// 사용자 메뉴 목록
$USER_MENU_ARRAY = array (

    "Home" => array (
        "Main" => "/index.php"
    ),

    "회사소개" => array (
        "캐나다" => "/company/canada.php",
        "워터루 지역" => "/company/waterloo_region.php",
        "KW에듀컨설팅" => "/company/kwedu_consulting.php"
    ),

    "자녀무상교육" => array (
        "자녀무상교육이란" => "/education/children_free_education.php",
        "코네스토가 컬리지" => "/education/conestoga_college.php",
        "워터루일반공립교육청(WRDSB)" => "/education/wrdsb.php",
        "워터루카톨릭공립교육청(WCDSB)" => "/education/wcdsb.php"
    ),

    "유학후이민" => array (
        "유학후이민이란" => "/immigration/immigration_after_study.php",
        "캐나다 이민의 종류" => "/immigration/canada_immigration_types.php",
        "유학후이민 성공 사례" => "/immigration/immigration_success_case.php"
    ),

    "조기유학" => array (
        "조기유학 안내" => "/early_study/early_study_guide.php",
        "캐나다 교육 제도" => "/early_study/canada_education_system.php",
        "온타리오주 교육과정 및 학제 소개" => "/early_study/ontario_education_system.php",
        "워터루카톨릭공립교육청(WCDSB)" => "/early_study/wcdsb.php",
        "사립학교 선택시 주의사항" => "/early_study/private_school_notice.php",
        "사립학교" => "/early_study/private_school.php",
        "단기유학(스쿨링)" => "/early_study/schooling.php"
    ),

    "어학연수" => array (
        "어학연수 안내" => "/language_course/what_is_language_course.php",
        "캐나다 교육 제도" => "/language_course/renison_university_college.php",
        "온타리오주 교육과정 및 학제 소개" => "/language_course/university_of_guelph.php",
        "워터루카톨릭공립교육청(WCDSB)" => "/language_course/conestoga_college.php"
    ),

    "학업관리서비스" => array (
        "학업관리서비스란" => "/academic_management/what_is_academic_management.php",
        "가디언 서비스" => "/academic_management/guardian_service.php",
        "스탠다드 학업관리서비스" => "/academic_management/standard_service.php",
        "프리미엄 학업관리서비스" => "/academic_management/premium_service.php"
    ),

    "랜딩서비스" => array (
        "랜딩서비스 안내" => "/landing_service/landing_service_guide.php",
        "스탠다드 랜딩서비스" => "/landing_service/standard_service.php",
        "프리미엄 랜딩서비스" => "/landing_service/premium_service.php"
    ),

    "게시판" => array (
        "공지사항" => "/bulletin_board/notice.php",
        "FAQ" => "/bulletin_board/faq.php",
        "QnA" => "/bulletin_board/qna.php"
    ),

    "온라인신청" => array (
        "코네스토가 컬리지 수속 신청" => "/online_apply/conestoga_apply.php",
        "조기유학 수속 신청" => "/online_apply/early_education_apply.php",
        "어학연수 수속 신청" => "/online_apply/language_course_apply.php",
        "학업관리서비스 신청" => "/online_apply/academic_management_apply.php",
        "정착서비스 신청" => "/online_apply/privlandging_service_applyate_school.php"
    ),

    "Contact" => array (
        "Contact" => "/contact/contact.php"
    ),
);

// 관리자 메뉴 목록
$ADMIN_MENU_ARRAY = array (
    "관리자 메인" => "/admin/index.php",
    "관리자 아이디 찾기" => "/admin/login/adminuser_loginid_search.php",
    "관리자 아이디 찾기 결과" => "/admin/login/adminuser_loginid_search_result.php",
    "관리자 비밀번호 찾기" => "/admin/login/adminuser_password_search.php",
    "관리자 비밀번호 찾기 결과" => "/admin/login/adminuser_password_search_result.php"
);


////////////////////////////////////////////////////////////////////////////////
// 날짜

// 요일
$WDATE_ARRAY = array (
    "일" =>  "0",
    "월" =>  "1",
    "화" =>  "2",
    "수" =>  "3",
    "목" =>  "4",
    "금" =>  "5",
    "토" =>  "6"
);

// 월
$MONTH_ARRAY = array (
    "01월" => "01",
    "02월" => "02",
    "03월" => "03",
    "04월" => "04",
    "05월" => "05",
    "06월" => "06",
    "07월" => "07",
    "08월" => "08",
    "09월" => "09",
    "10월" => "10",
    "11월" => "11",
    "12월" => "12"
);

// 일
$DAY_ARRAY = array (
    "01일" => "01",
    "02일" => "02",
    "03일" => "03",
    "04일" => "04",
    "05일" => "05",
    "06일" => "06",
    "07일" => "07",
    "08일" => "08",
    "09일" => "09",
    "10일" => "10",
    "11일" => "11",
    "12일" => "12",
    "13일" => "13",
    "14일" => "14",
    "15일" => "15",
    "16일" => "16",
    "17일" => "17",
    "18일" => "18",
    "19일" => "19",
    "20일" => "20",
    "21일" => "21",
    "22일" => "22",
    "23일" => "23",
    "24일" => "24",
    "25일" => "25",
    "26일" => "26",
    "27일" => "27",
    "28일" => "28",
    "29일" => "29",
    "30일" => "30",
    "31일" => "31"
);

// 시
$HOUR_ARRAY = array (
    "00시" => "00",
    "01시" => "01",
    "02시" => "02",
    "03시" => "03",
    "04시" => "04",
    "05시" => "05",
    "06시" => "06",
    "07시" => "07",
    "08시" => "08",
    "09시" => "09",
    "10시" => "10",
    "11시" => "11",
    "12시" => "12",
    "13시" => "13",
    "14시" => "14",
    "15시" => "15",
    "16시" => "16",
    "17시" => "17",
    "18시" => "18",
    "19시" => "19",
    "20시" => "20",
    "21시" => "21",
    "22시" => "22",
    "23시" => "23"
);

// 분
$MINUTE_ARRAY = array (
    "00분" => "00",
    "01분" => "01",
    "02분" => "02",
    "03분" => "03",
    "04분" => "04",
    "05분" => "05",
    "06분" => "06",
    "07분" => "07",
    "08분" => "08",
    "09분" => "09",
    "10분" => "10",
    "11분" => "11",
    "12분" => "12",
    "13분" => "13",
    "14분" => "14",
    "15분" => "15",
    "16분" => "16",
    "17분" => "17",
    "18분" => "18",
    "19분" => "19",
    "20분" => "20",
    "21분" => "21",
    "22분" => "22",
    "23분" => "23",
    "24분" => "24",
    "25분" => "25",
    "26분" => "26",
    "27분" => "27",
    "28분" => "28",
    "29분" => "29",
    "30분" => "30",
    "31분" => "31",
    "32분" => "32",
    "33분" => "33",
    "34분" => "34",
    "35분" => "35",
    "36분" => "36",
    "37분" => "37",
    "38분" => "38",
    "39분" => "39",
    "40분" => "40",
    "41분" => "41",
    "42분" => "42",
    "43분" => "43",
    "44분" => "44",
    "45분" => "45",
    "46분" => "46",
    "47분" => "47",
    "48분" => "48",
    "49분" => "49",
    "50분" => "50",
    "51분" => "51",
    "52분" => "52",
    "53분" => "53",
    "54분" => "54",
    "55분" => "55",
    "56분" => "56",
    "57분" => "57",
    "58분" => "58",
    "59분" => "59"
);

// 초
$SECOND_ARRAY = array (
    "00초" => "00",
    "01초" => "01",
    "02초" => "02",
    "03초" => "03",
    "04초" => "04",
    "05초" => "05",
    "06초" => "06",
    "07초" => "07",
    "08초" => "08",
    "09초" => "09",
    "10초" => "10",
    "11초" => "11",
    "12초" => "12",
    "13초" => "13",
    "14초" => "14",
    "15초" => "15",
    "16초" => "16",
    "17초" => "17",
    "18초" => "18",
    "19초" => "19",
    "20초" => "20",
    "21초" => "21",
    "22초" => "22",
    "23초" => "23",
    "24초" => "24",
    "25초" => "25",
    "26초" => "26",
    "27초" => "27",
    "28초" => "28",
    "29초" => "29",
    "30초" => "30",
    "31초" => "31",
    "32초" => "32",
    "33초" => "33",
    "34초" => "34",
    "35초" => "35",
    "36초" => "36",
    "37초" => "37",
    "38초" => "38",
    "39초" => "39",
    "40초" => "40",
    "41초" => "41",
    "42초" => "42",
    "43초" => "43",
    "44초" => "44",
    "45초" => "45",
    "46초" => "46",
    "47초" => "47",
    "48초" => "48",
    "49초" => "49",
    "50초" => "50",
    "51초" => "51",
    "52초" => "52",
    "53초" => "53",
    "54초" => "54",
    "55초" => "55",
    "56초" => "56",
    "57초" => "57",
    "58초" => "58",
    "59초" => "59"
);

?>