<?php

////////////////////////////////////////////////////////////////////////////////
// Login function

// (고객)
// User 로그인 상태
function user_login_status() {
    global $_SESSION;

    if (isset($_SESSION["session_u_id"]) && $_SESSION["session_u_id"] != "") {
        return true;
    }
    else {
        return false;
    }
}

// User 로그인 체크
function user_login_check() {
    global $_SESSION;    
    global $_SERVER;
    global $PATH_VAR;
    
    if (!client_login_status()) {
        top_location_href($PATH_VAR["user_login_url"] . "?login_return_url=" . urlencode($_SERVER["REQUEST_URI"]));
        exit;
    }
}

// User 로그아웃 체크
function user_logout_check() {
    global $_SESSION;
    global $PATH_VAR;
    
    if (user_login_status()) {
        top_location_href($PATH_VAR["user_default_url"]);
        exit;
    }
}

// (업무담당자)
// Worker 로그인 상태
function worker_login_status() {
    global $_SESSION;

    if (isset($_SESSION["session_wu_id"]) && $_SESSION["session_wu_id"] != "") {
        return true;
    }
    else {
        return false;
    }
}

// Worker 로그인 체크
function worker_login_check() {
    global $_SESSION;    
    global $_SERVER;
    global $PATH_VAR;
    
    if (!worker_login_status()) {
        top_location_href($PATH_VAR["worker_login_url"] . "?login_return_url=" . urlencode($_SERVER["REQUEST_URI"]));
        exit;
    }
}

// Worker 로그아웃 체크
function worker_logout_check() {
    global $_SESSION;
    global $PATH_VAR;
    
    if (worker_login_status()) {
        top_location_href($PATH_VAR["worker_default_url"]);
        exit;
    }
}

// (관리자)
// Admin 로그인 상태
function admin_login_status() {
    global $_SESSION;

    if (isset($_SESSION["session_au_id"]) && $_SESSION["session_au_id"] != "") {
        return true;
    }
    else {
        return false;
    }
}

// Admin 로그인 체크
function admin_login_check() {
    global $_SESSION;    
    global $_SERVER;
    global $PATH_VAR;
    
    if (!admin_login_status()) {
        top_location_href($PATH_VAR["admin_login_url"] . "?login_return_url=" . urlencode($_SERVER["REQUEST_URI"]));
        exit;
    }
}

// Admin 로그아웃 체크
function admin_logout_check() {
    global $_SESSION;
    global $PATH_VAR;
    
    if (admin_login_status()) {
        top_location_href($PATH_VAR["admin_default_url"]);
        exit;
    }
}


////////////////////////////////////////////////////////////////////////////////
// Password function

// 랜덤 비밀번호
function get_random_password() {
    $random_text = "";
    
    $length = 8;                                // 비밀번호 자리수
    
    for ($i = 0; $i < $length; $i++) {
        $random_text .= mt_rand(0, 9);    
    }
    
    return $random_text;
}


// 사용자(회원) 비밀번호 초기화
function init_user_password($u_id) {
    $u_password = get_random_password();
    
    $query = "update user_tb set ";
    $query .= "u_password = password('" . $u_password . "') ";
    $query .= "where u_id = '" . $u_id . "' ";
    $query .= "limit 1 ";

    if ($result = db_query($query)) {
        return $u_password; 
    }
    else {
        return ""; 
    }
}

// 관리자 비밀번호 초기화
function init_adminuser_password($au_id) {
    $au_password = get_random_password();
    
    $query = "update adminuser_tb set ";
    $query .= "au_password = password('" . $au_password . "') ";
    $query .= "where au_id = '" . $au_id . "' ";
    $query .= "limit 1 ";

    if ($result = db_query($query)) {
        return $au_password; 
    }
    else {
        return ""; 
    }
}


////////////////////////////////////////////////////////////////////////////////
// Menu function

// Parent Menu Name (User)
function get_parent_menu_name() {
    global $_SERVER;
    global $USER_MENU_ARRAY;

    $parent_menu_name = "";

    foreach ($USER_MENU_ARRAY as $key => $val) {
        $menu_name_1 = $key;            // 상위 메뉴명
        $menu_2_array = $val;

        foreach ($menu_2_array as $key2 => $val2) {
            $menu_name_2 = $key2;       // 하위 메뉴명  
            $menu_url_2 = $val2;        // 하위 메뉴 URL

            // 페이지명을 구함
            if ($_SERVER["PHP_SELF"] == $menu_url_2) {
                $parent_menu_name = $menu_name_1;
            }
        }
    }

    return $parent_menu_name;
}

// Menu Name (User)
function get_menu_name() {
    global $_SERVER;
    global $USER_MENU_ARRAY;

    $menu_name = "";

    foreach ($USER_MENU_ARRAY as $key => $val) {
        $menu_name_1 = $key;            // 상위 메뉴명
        $menu_2_array = $val;

        foreach ($menu_2_array as $key2 => $val2) {
            $menu_name_2 = $key2;       // 하위 메뉴명  
            $menu_url_2 = $val2;        // 하위 메뉴 URL

            // 페이지명을 구함
            if ($_SERVER["PHP_SELF"] == $menu_url_2) {
                $menu_name = $menu_name_2;
            }
        }
    }

    return $menu_name;
}

// User Top Menu List
function get_user_top_menu_list() {
    global $_SERVER;
    global $USER_MENU_ARRAY;

    $user_top_menu_list = "";

    foreach ($USER_MENU_ARRAY as $key => $val) {
        $active = "";
        
        $menu_name_1 = $key;            // 상위 메뉴명
        $menu_2_array = $val;

        $menu_url_1 = "";               // 상위 메뉴 URL 초기화

        $user_top_sub_menu_list = "";   // 하위 메뉴 html 초기화
        
        foreach ($menu_2_array as $key2 => $val2) {
            $menu_name_2 = $key2;       // 하위 메뉴명  
            $menu_url_2 = $val2;        // 하위 메뉴명  

            // 첫번째 하위 메뉴 URL을 기본 상위 메뉴 URL로 설정
            if ($menu_url_1 == "") {
                $menu_url_1 = $menu_url_2;  
            }

            // 현재 페이지 URL과 같다면
            if ($_SERVER["PHP_SELF"] == $menu_url_2) {
                $active = " active";
            }

            // 하위 메뉴 html
            $user_top_sub_menu_list .= "
                        <li><a href=\"" . $menu_url_2 . "\">" . $menu_name_2 . "</a></li>
            ";
        }

        $user_top_menu_list .= "
                    <li class=\"dropdown" . $active . "\">
                      <a href=\"" . $menu_url_1 . "\">" . $menu_name_1 . " <i class=\"icon-angle-down\"></i></a>
                      <ul class=\"dropdown-menu\">
                        " . $user_top_sub_menu_list . "
                      </ul>
                    </li>
        ";
    }

    return $user_top_menu_list;
}

// User Menu Navigator
function get_user_menu_navigator() {
    global $_SERVER;
    global $USER_MENU_ARRAY;

    $user_menu_navigator = "";

    foreach ($USER_MENU_ARRAY as $key => $val) {
        $menu_name_1 = $key;            // 상위 메뉴명
        $menu_2_array = $val;

        $menu_url_1 = "";               // 상위 메뉴 URL 초기화
        
        foreach ($menu_2_array as $key2 => $val2) {
            $menu_name_2 = $key2;       // 하위 메뉴명  
            $menu_url_2 = $val2;        // 하위 메뉴명  

            // 첫번째 하위 메뉴 URL을 기본 상위 메뉴 URL로 설정
            if ($menu_url_1 == "") {
                $menu_url_1 = $menu_url_2;  
            }

            // 페이지명을 구함
            if ($_SERVER["PHP_SELF"] == $menu_url_2) {
                $current_menu_1_name = $menu_name_1;
                $current_menu_1_url = $menu_url_1;

                $current_menu_2_name = $menu_name_2;
                $current_menu_2_url = $menu_url_2;
            }
        }
    }

    $user_menu_navigator = "
              <li><a href=\"/\"><i class=\"icon-home\"></i></a><i class=\"icon-angle-right\"></i></li>
              <li><a href=\"" . $current_menu_1_url . "\">" . $current_menu_1_name . "</a><i class=\"icon-angle-right\"></i></li>
              <li class=\"active\">" . $current_menu_2_name . "</li>
    ";

    return $user_menu_navigator;
}

// Sidebar Menu List
function get_sidebar_menu_list($parent_menu_name) {
    global $_SERVER;
    global $USER_MENU_ARRAY;

    $sidebar_menu_list = "";

    foreach ($USER_MENU_ARRAY[$parent_menu_name] as $key2 => $val2) {
        
        $menu_name_2 = $key2;       // 하위 메뉴명  
        $menu_url_2 = $val2;        // 하위 메뉴명  

        // 페이지명을 구함
        if ($_SERVER["PHP_SELF"] == $menu_url_2) {
            $class_text = " class=\"active\"";
        }
        else {
            $class_text = "";
        }

        $sidebar_menu_list .= "
            <li" . $class_text . "><i class=\"icon-angle-right\"></i><a href=\"" . $menu_url_2 . "\">" . $menu_name_2 . "</a></li>
        ";
    }

    return $sidebar_menu_list;
}

// Menu title
function get_menu_navigator() {
    global $_SERVER;
    global $SITE_VAR;
    global $PATH_VAR;
    global $ADMIN_MENU_ARRAY;           // 관리자 메뉴 목록

    global $db_m_type_array;
    global $db_m_step_array;
    
    $ret_text = "";
    
    ////////////////////////////////////////
    // 관리자 (직접 설정한 메뉴)

    if (array_search($_SERVER["PHP_SELF"], $ADMIN_MENU_ARRAY)) {
        $ret_text .= $SITE_VAR["home_name"] . " ";
        $ret_text .= "관리자 &gt; ";
        $ret_text .= array_search($_SERVER["PHP_SELF"], $ADMIN_MENU_ARRAY);
        
        return $ret_text;
    }
    
    ////////////////////////////////////////
    // 담당자

    // 담당자 > 메인페이지
    if ($_SERVER["PHP_SELF"] == "/worker/index.php") {
        $ret_text .= $SITE_VAR["home_name"] . " ";
        $ret_text .= "담당자 &gt; ";
        $ret_text .= "담당자 메인";
        
        return $ret_text;
    }

    // 담당자 > 회원가입
    if ($_SERVER["PHP_SELF"] == $PATH_VAR["worker_join_url"]) {
        $ret_text .= $SITE_VAR["home_name"] . " ";
        $ret_text .= "담당자 &gt; ";
        $ret_text .= "담당자 회원가입";
        
        return $ret_text;
    }

    ////////////////////////////////////////
    // 고객

    // 고객 > 메인페이지
    if ($_SERVER["PHP_SELF"] == "/client/index.php") {
        /*
        $ret_text .= $SITE_VAR["home_name"] . " ";
        $ret_text .= "고객 &gt; ";
        */
        $ret_text .= $SITE_VAR["home_name"] . " &gt; ";
        $ret_text .= "고객 메인";
        
        return $ret_text;
    }
    
    ////////////////////////////////////////
    // DB
    $query = "select ";    
    $query .= "m1.m_type as m_type, ";                      // 메뉴구분
    $query .= "m1.m_name as m_name_1, ";
    $query .= "m2.m_name as m_name_2, ";
    $query .= "m3.m_name as m_name_3 ";
    $query .= "from menu_tb m3 ";
    
    $query .= "inner join menu_tb m2 ";
    $query .= "on m3.m_parentid = m2.m_id ";
    
    $query .= "inner join menu_tb m1 ";
    $query .= "on m2.m_parentid = m1.m_id ";
    
    $query .= "where m3.m_step = '" . $db_m_step_array["소메뉴"] . "' ";
    $query .= "and m3.m_url = '" . $_SERVER["PHP_SELF"] . "' ";
    
    $result = db_query($query);
    if (!$row = db_fetch_array($result)) {
        return $ret_text;
    }
    
    /*
    $ret_text .= "<li><a href=\"/\">". $SITE_VAR["home_name"] . "</a></li>";
    $ret_text .= "<li>" . $row["m_name_1"] . "</li>";
    $ret_text .= "<li>" . $row["m_name_2"] . "</li>";
    $ret_text .= "<li>" . $row["m_name_3"] . "</li>";
    // $ret_text .= "<li class=\"active\">" . $row["m_name_3"] . "</li>";
    */
    
    // $ret_text .= $SITE_VAR["home_name"] . " &gt; ";
    $ret_text .= $SITE_VAR["home_name"] . " ";
    $ret_text .= array_search($row["m_type"], $db_m_type_array) ." &gt; ";
    $ret_text .= $row["m_name_1"] . " &gt; ";
    $ret_text .= $row["m_name_2"] . " &gt; ";
    $ret_text .= $row["m_name_3"];
    
    return $ret_text;
}


////////////////////////////////////////////////////////////////////////////////
// Menu 권한

// 관리자 Menu 권한 체크
function adminuser_menu_check() {
    global $_SERVER;
    global $_SESSION;
    global $_POST;
    
    global $db_m_type_array;
    global $db_m_step_array;    
    global $db_m_usestate_array;

    global $db_m_usestate_array;
    global $db_au_usestate_array;
    
    $adminuser_menu_check = true;       // 메뉴권한 초기화 (있음)
    
    $query = "select ";
    $query .= "m_id, ";
    $query .= "m_usestate ";
    $query .= "from menu_tb ";
    $query .= "where m_type = '" . $db_m_type_array["관리자"] . "' ";
    $query .= "and m_step = '" . $db_m_step_array["소메뉴"] . "' ";
    $query .= "and m_url = '" . $_SERVER["PHP_SELF"] . "' ";
    
    $result = db_query($query);
    
    if ($row = db_fetch_array($result)) {
        if ($row["m_usestate"] == $db_m_usestate_array["사용"]) {
            
            // 사용자그룹메뉴 
            $query = "select ";
            $query .= "auma.auma_id ";
            $query .= "from adminusermenuauth_tb auma ";
            
            $query .= "inner join adminuser_tb au ";        // 관리자
            $query .= "on auma.auma_adminuser = au.au_id ";
            $query .= "and au.au_usestate = '" . $db_au_usestate_array["사용"] . "' ";
            $query .= "and au.au_id = '" . $_SESSION["session_au_id"] . "' ";
            
            $query .= "where auma.auma_menu = '" . $row["m_id"] . "' ";
            
            $result_sub = db_query($query);
            
            if ($row_sub = db_fetch_array($result_sub)) {
                $adminuser_menu_check = true;
            }
            else {
                $adminuser_menu_check = false;
            }
        }
        else {                                              // 중지
            $adminuser_menu_check = false;
        }
    }
    
    if (!$adminuser_menu_check) {        
        alert_back("메뉴 권한이 없습니다."); 
        
        exit;          
    }
}



?>