<?php

// DB
$GLOVAL_DB["host"] = "localhost";
$GLOVAL_DB["user"] = "kweduconsulting";
$GLOVAL_DB["pass"] = "#kweduconsulting2019";
$GLOVAL_DB["name"] = "kweduconsulting";

// MariaDB 서버에 접속후 데이터베이스를 선택
function db_connect() {
    global $mysqli_connect;
    global $GLOVAL_DB;

    $mysqli_connect = mysqli_connect($GLOVAL_DB["host"], $GLOVAL_DB["user"], $GLOVAL_DB["pass"], $GLOVAL_DB["name"]);

    // character_set
    $mysqli_connect->query ("set names utf8");
    
    return $mysqli_connect;
}

// 데이터베이스에 질의를 전송
function db_query($pQuery, $pConnect = "") {
    global $mysqli_connect;

    $temp_connect = ($pConnect == "") ? $mysqli_connect : $pConnect;
    
    $result = mysqli_query($mysqli_connect, $pQuery);

    return $result;
}

// 결과로부터 열 개수를 반환
function db_num_rows($pResult) {
    /* determine number of rows result set */
    return mysqli_num_rows($pResult);
}

// 최근 INSERT 작업으로부터 생성된 identifier 값을 반환
function db_insert_id() {
    global $mysqli_connect;
 
    return mysqli_insert_id($mysqli_connect);
}

// 결과를 필드이름 색인 또는 숫자 색인으로 된 배열로 반환
function db_fetch_array($pResult) {
    /* associative and numeric array */
    return mysqli_fetch_array($pResult, MYSQLI_BOTH);
}

// result에 대한 메모리(memory)에 있는 내용을 모두 제거한다.
function db_free_result($pResult) {
    /* free result set */
    mysqli_free_result($pResult);
}

// DB 접속을 닫음
function db_close() {
    global $mysqli_connect;

    if ($mysqli_connect) {
        /* close connection */
        mysqli_close($mysqli_connect);

        $mysqli_connect = "";
    }    
}


// DB 구조및 관련 배열 변수

/* 공통 배열 항목 ABC순 */
// 승인상태
$db_common_approvalstate_array = array (
    "미승인" => "1",
    "승인완료" => "2"
);
$color_common_approvalstate_array = array (
    "1" => "red",
    "2" => "blue"
);

// 진행상태
$db_common_dealstate_array = array (
    "진행" => "1",
    "중단" => "2"
);
$color_common_dealstate_array = array (
    "1" => "blue",
    "2" => "red"
);

// 성별
$db_common_gendertype_array = array (
    "남자" => "1",
    "여자" => "2",
    "기타" => "3"
);
$color_common_gendertype_array = array (
    "1" => "blue",
    "2" => "red",
    "3" => "black"
);

// 처리상태
$db_common_processstate_array = array (
    "미처리" => "1",
    "처리완료" => "2"
);
$color_common_processstate_array = array (
    "1" => "red",
    "2" => "blue"
);

// 정렬순서
$db_common_sorttype_array = array (
    "Ascend" => "1",
    "Descend" => "2"
);
$color_common_sorttype_array = array (
    "1" => "blue",
    "2" => "red"
);

// 사용자구분
$db_common_usertype_array = array (
    "adminuser" => "1",
    "workeruser" => "2",
    "customeruser" => "3"
);
$color_common_usertype_array = array (
    "1" => "black",
    "2" => "red",
    "3" => "blue"
);

// 사용상태
$db_common_usestate_array = array (
    "사용" => "1",
    "중지" => "2"
);
$color_common_usestate_array = array (
    "1" => "blue",
    "2" => "red"
);

// 공개여부
$db_common_viewtype_array = array (
    "공개" => "1",
    "비공개" => "2"
);
$color_common_viewtype_array = array (
    "1" => "blue",
    "2" => "red"
);

// 예아니오
$db_common_yesnotype_array = array (
    "예" => "1",
    "아니오" => "2"
);
$color_common_yesnotype_array = array (
    "1" => "blue",
    "2" => "red"
);

/* DB 테이블 (ABC 순)

/* 관리자
CREATE TABLE adminuser_tb (
  au_id int(11) NOT NULL AUTO_INCREMENT COMMENT '관리자번호',
  au_name varchar(50) NOT NULL DEFAULT '' COMMENT '이름',
  au_loginid varchar(20) NOT NULL DEFAULT '' COMMENT '아이디',
  au_password varchar(50) NOT NULL DEFAULT '' COMMENT '비밀번호',  
  au_email varchar(50) NOT NULL DEFAULT '' COMMENT '이메일',
  au_mobile varchar(20) NOT NULL DEFAULT '' COMMENT '휴대폰',
  au_usestate tinyint(4) NOT NULL DEFAULT '0' COMMENT '사용상태',
  au_logindatetime varchar(14) NOT NULL DEFAULT '' COMMENT '로그인일시',
  PRIMARY KEY (au_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='관리자';
ALTER TABLE adminuser_tb ADD INDEX (au_name);
ALTER TABLE adminuser_tb ADD UNIQUE (au_loginid);           -- UNIQUE
ALTER TABLE adminuser_tb ADD INDEX (au_usestate);
ALTER TABLE adminuser_tb ADD INDEX (au_logindatetime);
*/
// 사용상태
$db_au_usestate_array = $db_common_usestate_array;
$color_au_usestate_array = $color_common_usestate_array;

/* 관리자메뉴권한
CREATE TABLE adminusermenuauth_tb (
  auma_id int(11) NOT NULL AUTO_INCREMENT COMMENT '관리자메뉴권한번호',
  auma_adminuser int(11) NOT NULL DEFAULT '0' COMMENT '관리자번호',
  auma_menu int(11) NOT NULL DEFAULT '0' COMMENT '메뉴번호',  
  PRIMARY KEY (auma_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='관리자메뉴권한';
ALTER TABLE adminusermenuauth_tb ADD INDEX (auma_adminuser);
ALTER TABLE adminusermenuauth_tb ADD INDEX (auma_menu);
*/

/* 메뉴
CREATE TABLE menu_tb (
  m_id int(11) NOT NULL AUTO_INCREMENT COMMENT '메뉴번호',
  m_type tinyint(4) NOT NULL DEFAULT '0' COMMENT '메뉴구분',
  m_step tinyint(4) NOT NULL DEFAULT '0' COMMENT '메뉴단계',
  m_parentid int(11) NOT NULL DEFAULT '0' COMMENT '상위메뉴번호',
  m_name varchar(50) NOT NULL DEFAULT '' COMMENT '메뉴명',
  m_url varchar(100) NOT NULL DEFAULT '' COMMENT '메뉴URL',
  m_usestate tinyint(4) NOT NULL DEFAULT '1' COMMENT '사용상태',
  m_order int(11) NOT NULL DEFAULT '0' COMMENT '순서',
  PRIMARY KEY (m_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='메뉴';
ALTER TABLE menu_tb ADD INDEX (m_type);
ALTER TABLE menu_tb ADD INDEX (m_step);
ALTER TABLE menu_tb ADD INDEX (m_parentid);
ALTER TABLE menu_tb ADD INDEX (m_url);
ALTER TABLE menu_tb ADD INDEX (m_usestate);
ALTER TABLE menu_tb ADD INDEX (m_order);
*/
// 메뉴구분
$db_m_type_array = array (
    "관리자" => "1",
    "담당자" => "2",
    "고객" => "3"
);

// 메뉴단계
$db_m_step_array = array (
    "대메뉴" => "1",
    "중메뉴" => "2",
    "소메뉴" => "3"
);

// 사용상태
$db_m_usestate_array = $db_common_usestate_array;
$color_m_usestate_array = $color_common_usestate_array;

/* 이미지파일
CREATE TABLE imagefile_tb (
  if_id int(11) NOT NULL AUTO_INCREMENT COMMENT '이미지파일번호',
  if_tablename varchar(50) NOT NULL DEFAULT '' COMMENT '테이블명',
  if_tablekeyname varchar(50) NOT NULL DEFAULT '' COMMENT '테이블키컬럼',
  if_tablekeyid int(11) NOT NULL DEFAULT '0' COMMENT '테이블키번호',
  if_tablecolumn varchar(50) NOT NULL DEFAULT '' COMMENT '테이블컬럼',
  if_name varchar(100) NOT NULL DEFAULT '' COMMENT '첨부파일이름',
  if_filepath varchar(200) NOT NULL DEFAULT '' COMMENT '파일경로',
  if_filename varchar(100) NOT NULL DEFAULT '' COMMENT '파일명',
  if_filesize int(11) NOT NULL DEFAULT '0' COMMENT '파일크기',
  if_note varchar(100) NOT NULL DEFAULT '' COMMENT '비고',

  if_usertype tinyint(4) NOT NULL DEFAULT '0' COMMENT '사용자구분',
  if_reguser int(11) NOT NULL DEFAULT '0' COMMENT '등록사용자번호',  
  if_regtime varchar(14) NOT NULL DEFAULT '' COMMENT '등록일시',
  PRIMARY KEY (if_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='이미지파일';
ALTER TABLE imagefile_tb ADD INDEX (if_tablename);
ALTER TABLE imagefile_tb ADD INDEX (if_tablekeyname);
ALTER TABLE imagefile_tb ADD INDEX (if_tablekeyid);

ALTER TABLE imagefile_tb ADD INDEX (if_usertype);
ALTER TABLE imagefile_tb ADD INDEX (if_reguser);
ALTER TABLE imagefile_tb ADD INDEX (if_regtime);
*/
// 사용자구분
$db_if_usertype_array = $db_common_usertype_array;
$color_if_usertype_array = $color_common_usertype_array;

/* 사용자
CREATE TABLE user_tb (
  u_id int(11) NOT NULL AUTO_INCREMENT COMMENT '사용자번호',
  u_name varchar(50) NOT NULL DEFAULT '' COMMENT '이름(한글)',
  u_firstname varchar(30) NOT NULL DEFAULT '' COMMENT 'First Name(영문)',
  u_lastname varchar(30) NOT NULL DEFAULT '' COMMENT 'Last Name(영문)',
  u_preferredname varchar(30) NOT NULL DEFAULT '' COMMENT 'Preferred Name(영문)',
  u_loginid varchar(20) NOT NULL DEFAULT '' COMMENT '아이디',
  u_password varchar(50) NOT NULL DEFAULT '' COMMENT '비밀번호',  

  u_birthdate varchar(8) NOT NULL DEFAULT '' COMMENT '생년월일',
  u_email varchar(50) NOT NULL DEFAULT '' COMMENT '이메일',
  u_gendertype tinyint(4) NOT NULL DEFAULT '0' COMMENT '성별(Gender)',

  u_contryofbirth varchar(30) NOT NULL DEFAULT '' COMMENT '출생국가(Country of Birth)',
  u_contryofcitizenship varchar(30) NOT NULL DEFAULT '' COMMENT '국적(Country of Citizenship)',
  u_passportnumber varchar(20) NOT NULL DEFAULT '' COMMENT '여권번호(Passport Number)',
  
  u_usestate tinyint(4) NOT NULL DEFAULT '0' COMMENT '사용상태',
  u_logindatetime varchar(14) NOT NULL DEFAULT '' COMMENT '로그인일시',
  PRIMARY KEY (u_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='사용자';
ALTER TABLE user_tb ADD INDEX (u_name);
ALTER TABLE user_tb ADD INDEX (u_firstname);
ALTER TABLE user_tb ADD INDEX (u_lastname);
ALTER TABLE user_tb ADD UNIQUE (u_loginid);          -- UNIQUE
ALTER TABLE user_tb ADD INDEX (u_usestate);
ALTER TABLE user_tb ADD INDEX (u_logindatetime);
*/
// 성별
$db_u_gendertype_array = $db_common_gendertype_array;
$color_u_gendertype_array = $color_common_gendertype_array;

// 사용상태
$db_u_usestate_array = $db_common_usestate_array;
$color_u_usestate_array = $color_common_usestate_array;

/* 담당자
CREATE TABLE workeruser_tb (
  wu_id int(11) NOT NULL AUTO_INCREMENT COMMENT '담당자번호',
  wu_name varchar(50) NOT NULL DEFAULT '' COMMENT '이름(한글)',
  wu_firstname varchar(30) NOT NULL DEFAULT '' COMMENT 'First Name(영문)',
  wu_lastname varchar(30) NOT NULL DEFAULT '' COMMENT 'Last Name(영문)',
  wu_preferredname varchar(30) NOT NULL DEFAULT '' COMMENT 'Preferred Name(영문)',
  wu_loginid varchar(20) NOT NULL DEFAULT '' COMMENT '아이디',
  wu_password varchar(50) NOT NULL DEFAULT '' COMMENT '비밀번호',  

  wu_birthdate varchar(8) NOT NULL DEFAULT '' COMMENT '생년월일',
  wu_email varchar(50) NOT NULL DEFAULT '' COMMENT '이메일',
  wu_gendertype tinyint(4) NOT NULL DEFAULT '0' COMMENT '성별(Gender)',

  wu_contryofbirth varchar(30) NOT NULL DEFAULT '' COMMENT '출생국가(Country of Birth)',
  wu_contryofcitizenship varchar(30) NOT NULL DEFAULT '' COMMENT '국적(Country of Citizenship)',
  wu_passportnumber varchar(20) NOT NULL DEFAULT '' COMMENT '여권번호(Passport Number)',
  wu_sinnumber varchar(9) NOT NULL DEFAULT '' COMMENT 'SIN넘버(SIN Number)',

  wu_streetaddress varchar(30) NOT NULL DEFAULT '' COMMENT 'Street Address',
  wu_unitnumber varchar(20) NOT NULL DEFAULT '' COMMENT 'Apartment Number (Optional)',
  wu_city varchar(20) NOT NULL DEFAULT '' COMMENT 'City',
  wu_province varchar(20) NOT NULL DEFAULT '' COMMENT 'Province',
  wu_country varchar(20) NOT NULL DEFAULT '' COMMENT 'Country',
  wu_postalcode varchar(10) NOT NULL DEFAULT '' COMMENT 'Postal/Zip Code',

  wu_additionalemail varchar(50) NOT NULL DEFAULT '' COMMENT '추가이메일',

  wu_mobilecountry varchar(6) NOT NULL DEFAULT '' COMMENT '휴대폰국가번호',
  wu_mobile1 varchar(4) NOT NULL DEFAULT '' COMMENT '휴대폰1',
  wu_mobile2 varchar(4) NOT NULL DEFAULT '' COMMENT '휴대폰2',
  wu_mobile3 varchar(4) NOT NULL DEFAULT '' COMMENT '휴대폰3',

  wu_homephonecountry varchar(6) NOT NULL DEFAULT '' COMMENT '집전화국가번호',
  wu_homephone1 varchar(4) NOT NULL DEFAULT '' COMMENT '집전화1',
  wu_homephone2 varchar(4) NOT NULL DEFAULT '' COMMENT '집전화2',
  wu_homephone3 varchar(4) NOT NULL DEFAULT '' COMMENT '집전화3',

  wu_additionalphonecountry varchar(6) NOT NULL DEFAULT '' COMMENT '기타전화국가번호',
  wu_additionalphone1 varchar(4) NOT NULL DEFAULT '' COMMENT '기타전화1',
  wu_additionalphone2 varchar(4) NOT NULL DEFAULT '' COMMENT '기타전화2',
  wu_additionalphone3 varchar(4) NOT NULL DEFAULT '' COMMENT '기타전화3',
  wu_additionalphoneextension varchar(4) NOT NULL DEFAULT '' COMMENT '기타전화내선번호',
  
  wu_emergencyname varchar(50) NOT NULL DEFAULT '' COMMENT '긴급연락처 이름',
  wu_emergencyrelationship varchar(20) NOT NULL DEFAULT '' COMMENT '긴급연락처 관계',
  wu_emergencyphonecountry varchar(6) NOT NULL DEFAULT '' COMMENT '긴급연락처전화국가번호',
  wu_emergencyphone1 varchar(4) NOT NULL DEFAULT '' COMMENT '긴급연락처전화1',
  wu_emergencyphone2 varchar(4) NOT NULL DEFAULT '' COMMENT '긴급연락처전화2',
  wu_emergencyphone3 varchar(4) NOT NULL DEFAULT '' COMMENT '긴급연락처전화3',
  wu_emergencyphoneextension varchar(4) NOT NULL DEFAULT '' COMMENT '긴급연락처전화내선번호',

  wu_vehiclemaker varchar(20) NOT NULL DEFAULT '' COMMENT '자동차 Maker',
  wu_vehiclemodel varchar(30) NOT NULL DEFAULT '' COMMENT '자동차 Model',
  wu_vehicleyear varchar(4) NOT NULL DEFAULT '' COMMENT '자동차 년도',
  wu_vehiclemileage int(11) NOT NULL DEFAULT '0' COMMENT '자동차 주행거리',
  wu_vehicleplatenumber varchar(30) NOT NULL DEFAULT '' COMMENT '자동차 등록번호',

  wu_autoinsurancecompany varchar(30) NOT NULL DEFAULT '' COMMENT '자동차 보험회사',
  wu_autoinsurancenumber varchar(30) NOT NULL DEFAULT '' COMMENT '자동차 보험증번호',

  wu_passportimagefile int(11) NOT NULL DEFAULT '0' COMMENT '여권 사진번호',
  wu_photoimagefile int(11) NOT NULL DEFAULT '0' COMMENT '본인 사진번호',
  wu_criminalrecordimagefile int(11) NOT NULL DEFAULT '0' COMMENT '범죄경력증명서 사진번호',
  
  wu_vehiclefrontimagefile int(11) NOT NULL DEFAULT '0' COMMENT '자동차 앞면 사진번호',
  wu_vehiclebackimagefile int(11) NOT NULL DEFAULT '0' COMMENT '자동차 뒷면 사진번호',
  wu_driverlicencefrontimagefile int(11) NOT NULL DEFAULT '0' COMMENT '운전면허증 앞면 사진번호',
  wu_driverlicencebackimagefile int(11) NOT NULL DEFAULT '0' COMMENT '운전면허증 뒷면 사진번호',
  wu_vehicleownershipimagefile int(11) NOT NULL DEFAULT '0' COMMENT '자동차 오너쉽 사진번호',
  wu_vehicleinsuranceimagefile int(11) NOT NULL DEFAULT '0' COMMENT '자동차 보험증 사진번호',

  wu_approvalstate tinyint(4) NOT NULL DEFAULT '0' COMMENT '승인상태',
  wu_usestate tinyint(4) NOT NULL DEFAULT '0' COMMENT '사용상태',
  wu_logindatetime varchar(14) NOT NULL DEFAULT '' COMMENT '로그인일시',
  PRIMARY KEY (wu_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='담당자';
ALTER TABLE workeruser_tb ADD INDEX (wu_name);
ALTER TABLE workeruser_tb ADD INDEX (wu_firstname);
ALTER TABLE workeruser_tb ADD INDEX (wu_lastname);
ALTER TABLE workeruser_tb ADD UNIQUE (wu_loginid);          -- UNIQUE
ALTER TABLE workeruser_tb ADD INDEX (wu_approvalstate);
ALTER TABLE workeruser_tb ADD INDEX (wu_usestate);
ALTER TABLE workeruser_tb ADD INDEX (wu_logindatetime);
*/
// 성별
$db_wu_gendertype_array = $db_common_gendertype_array;
$color_wu_gendertype_array = $color_common_gendertype_array;

// 승인상태
$db_wu_approvalstate_array = $db_common_approvalstate_array;
$color_wu_approvalstate_array = $color_common_approvalstate_array;

// 사용상태
$db_wu_usestate_array = $db_common_usestate_array;
$color_wu_usestate_array = $color_common_usestate_array;

// 개인 관련 이미지 컬럼 
$DB_WORKERUSER_PERSON_IMAGE_COLUMN_ARRAY = array (
    "wu_passportimagefile",             // 여권 사진번호
    "wu_photoimagefile",                // 본인 사진번호
    "wu_criminalrecordimagefile"        // 범죄경력증명서 사진번호
);

// 자동차 관련 이미지 컬럼 
$DB_WORKERUSER_VEHICLE_IMAGE_COLUMN_ARRAY = array (
    "wu_vehiclefrontimagefile",         // 자동차 앞면 사진번호
    "wu_vehiclebackimagefile",          // 자동차 뒷면 사진번호
    "wu_driverlicencefrontimagefile",   // 운전면허증 앞면 사진번호
    "wu_driverlicencebackimagefile",    // 운전면허증 뒷면 사진번호
    "wu_vehicleownershipimagefile",     // 자동차 오너쉽 사진번호
    "wu_vehicleinsuranceimagefile"      // 자동차 보험증 사진번호
);

// 데이터베이스 접속
db_connect();

?>
