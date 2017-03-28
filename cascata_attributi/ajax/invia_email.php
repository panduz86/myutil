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

$destinatario = $_GET['destinatario'];
$oggetto_mail = "Riepilogo ordine";

// costruiamo alcune intestazioni generali
$header = "From: ".$nome_mittente." <".$indirizzo_mittente.">\n";
$header .= "X-Mailer: ".$nome_mittente;

// generiamo la stringa che funge da separatore
$boundary = "==String_Boundary_x" .md5(time()). "x";

// costruiamo le intestazioni specifiche per un messaggio
// con parti relazionate
$header .= "MIME-Version: 1.0\n";
$header .= "Content-Type: multipart/related;\n";
$header .= " boundary=\"$boundary\";\n\n";

// questa parte del messaggio viene visualizzata
// solo se il programma non sa interpretare
// i MIME poiché è posta prima della stringa boundary
$messaggio = "\n\n";

//TESTO EMAIL
$fp=fopen($path_dir_admin."email/riepilogo_ordine.html","r");
$file_content="";
while(!feof($fp)){
        $file_content.=fread($fp,4096);
}
fclose($fp);
$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
$file_messaggio = str_replace("#stima#", number_format($costo,2),$file_messaggio);
$file_messaggio = str_replace("#oggetto#",$oggetto_mail,$file_messaggio);
$file_messaggio = str_replace("#nome_sito#",$nome_sito,$file_messaggio);

$messaggio .= "--$boundary\n";
$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
$messaggio .= $file_messaggio."\n\n";

// chiusura del messaggio con la stringa boundary
$messaggio .= "--$boundary--\n";

// Processo di invio 
mail($destinatario, $oggetto_mail, $messaggio, $header);
        
echo "OK";
