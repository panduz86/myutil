<?php
include("../adminCPgestione/conf/config.php");
include("../adminCPgestione/include/functions.php");
include("../adminCPgestione/include/connection_db.php");

if(isset($_GET['regione'])){
	$id_regione = $_GET['regione'];
	$id_nazione = $_GET['nazione'];
	
	$res_provincia = $db->query("SELECT id_city as id, asci_city as nome FROM ".$prefix."citta_europa WHERE country_code='".$id_nazione."' AND state_region ='".$id_regione."' ORDER BY nome");
	
	$output="<option value=\"-1\">-- seleziona --</option>";
	
	while($obj_provincia=$db->fetchNextObject($res_provincia)){
		$output .= "<option value=\"".$obj_provincia->id."\">".$obj_provincia->nome."</option>";
	}
	
	echo $output;
}

?>