<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// Admin 로그인 체크
admin_login_check();
adminuser_menu_check();
html_meta_charset_utf8();

$au_id        	=   trim($_POST["au_id"]);
$au_email    	=   trim($_POST["au_email"]);
$au_mobile    	=   trim($_POST["au_mobile"]);
$au_usestate	=   trim($_POST["au_usestate"]);

// 수정
$query = "update adminuser_tb set ";
$query .= "au_email = '" . $au_email . "', ";
$query .= "au_mobile = '" . $au_mobile . "', ";
$query .= "au_usestate = '" . $au_usestate . "' ";
$query .= "where au_id = '" . $au_id . "' ";
$query .= "limit 1 ";

if ($result = db_query($query)) {

	////////////////////////////////////////////////////////////////////////////////
    // 관리자메뉴권한
    
    $auma_adminuser		=   $au_id;
    $auma_menu_array	=   $_POST["auma_menu"];    
    
    // 삭제
    if (count($auma_menu_array) > 0) {
        $auma_menu_list = "";            
        $i = 0;
        
        foreach ($auma_menu_array as $key => $val) {
            $i++;
            
            if ($i > 1) {
                $auma_menu_list .= ", ";    
            }
            $auma_menu_list .= "'" . $val . "'";
        }        
    }
    else {
        $auma_menu_list = "''";    
    }    
    // echo "<br />" . $auma_menu_list;
    
    $query = "delete from adminusermenuauth_tb ";
    $query .= "where auma_adminuser = '" . $auma_adminuser . "' ";
    $query .= "and auma_menu not in (" . $auma_menu_list . ") ";
    
    db_query($query);
    
    // 등록, 수정
    if (count($auma_menu_array) > 0) {
        foreach ($auma_menu_array as $key => $val) {
            $auma_adminuser	=	$au_id;
            $auma_menu    	=   $val;
            
            $query = "select count(*) as total_count ";
            $query .= "from adminusermenuauth_tb ";
            $query .= "where auma_adminuser = '" . $auma_adminuser . "' ";
            $query .= "and auma_menu = '" . $auma_menu . "' ";
    		
            $result_count = db_query($query);
            $row_count = db_fetch_array($result_count);
            
            if ($row_count["total_count"] > 0) {            // 수정 (해주지 않아도 되지만 일관성 유지를 위해 함)
                $query = "update adminusermenuauth_tb set ";
                $query .= "auma_adminuser = '" . $auma_adminuser . "', ";
                $query .= "auma_menu = '" . $auma_menu . "' ";
                $query .= "where auma_adminuser = '" . $auma_adminuser . "' ";
                $query .= "and auma_menu = '" . $auma_menu . "' ";
                $query .= "limit 1 ";
    
                db_query($query);    
            }
            else {
                $query = "insert into adminusermenuauth_tb ( ";
                $query .= "auma_adminuser, ";
                $query .= "auma_menu ";
                $query .= ") values ( ";
                $query .= "'" . $auma_adminuser . "', ";
                $query .= "'" . $auma_menu . "' ";
                $query .= ")";  
    
                db_query($query);
            }
        }        
    }    
            
    // 관리자메뉴권한
    ////////////////////////////////////////////////////////////////////////////////
    
    alert("수정되었습니다.");
}
else {
    alert_back("수정하는데 실패했습니다."); 
}

// 페이지 이동
$location_href = "adminuser_list.php?dummy=dummy";
$location_href .= "&search_au_usestate=" . $_REQUEST["search_au_usestate"];
$location_href .= "&search_type=" . $_REQUEST["search_type"];
$location_href .= "&search_keyword=" . urlencode($_REQUEST["search_keyword"]);
$location_href .= "&page=" . $_REQUEST["page"];
location_href($location_href);

?>