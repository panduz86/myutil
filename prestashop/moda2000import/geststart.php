<?php

include(dirname(__FILE__) . '/../../config/config.inc.php');
include(dirname(__FILE__) . '/../../init.php');
include dirname(__FILE__) . '/moda2000import.php';

$url = dirname(__FILE__) . '/artmoda.xml';

/* * ************DEBUG******* */
$handle = fopen("risultati.html", "w");
fwrite($handle, "*********geststart*********<br>\n");
fwrite($handle, "start: " . " \n<br>\n [" . date("Y-m-d h-m-s") . "]<br><br>\n");

ob_start();
$module = new moda2000Import();

$danea_html_debug = $module->_xmlgo($url);
$danea_debug = ob_get_contents();

if (substr(_PS_VERSION_, 0, 3) >= 1.4){
    Category::regenerateEntireNtree();
}
ob_end_clean();


fwrite($handle, "msg: " . $danea_debug . "<br>\n");
fwrite($handle, "dbg: " . $danea_html_debug . "<br>\n");
fwrite($handle, "end: " . " \n<br>\n [" . date("Y-m-d h-m-s") . "]<br><br>\n");
fclose($handle);
/* * ************************ */

die('OK');
