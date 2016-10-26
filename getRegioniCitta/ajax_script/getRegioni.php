<?php
include("../adminCPgestione/conf/config.php");
include("../adminCPgestione/include/functions.php");
include("../adminCPgestione/include/connection_db.php");

if(isset($_GET['nazione'])){
	$id_nazione = $_GET['nazione'];
	$res_regione = $db->query("SELECT region_code as id, region_name as nome FROM ".$prefix."regioni WHERE country_code ='".$id_nazione."' ORDER BY region_name");
	
	$output="<option value=\"-1\">-- seleziona --</option>";
	
	while($obj_regione=$db->fetchNextObject($res_regione)){
		$output .= "<option value=\"".$obj_regione->id."\">".$obj_regione->nome."</option>";
	}
	
	echo $output;
}

?>