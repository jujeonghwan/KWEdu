<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/header.php");

tp_read($_SERVER["DOCUMENT_ROOT"] . "/main.html");

//

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/footer.php");

?>