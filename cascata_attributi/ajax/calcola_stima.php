<?php

include("../adminCPgestione/conf/config.php");
include("../adminCPgestione/include/functions.php");
include("../adminCPgestione/include/connection_db.php");

$idprod = $_GET['idprod'];
$id_attributi = $_GET['idattributi']; //lista di id attributo divisi da virgola (per esempio "12,4,1,2")

$obj_prodotto = $db->queryUniqueObject("SELECT * FROM " . $prefix . "prodotti WHERE id_prodotto=" . $idprod);

$costo = floatval($obj_prodotto->prezzo_con_iva);

$qry_attributi = $db->query("SELECT * FROM ".$prefix."prodotti_attribute WHERE id_attributo_prodotto IN (".$id_attributi.")");

while($item = $db->fetchNextArray($qry_attributi)){
    $costo += floatval($item['impatto_prezzo']);
}

echo $costo;
