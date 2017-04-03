<?php


$serveur_file='http://www.senno.it/moda/ArtModa.xml';
$monmicro_file='ArtModa.xml';

set_time_limit(300);
//Percorso file remoto
$remotefile=$serveur_file;
//Cartella locale in cui copiare il file
$cartella=""; // cartella dove mettere immagini
//apro il file remoto da leggere
$srcfile1 = fopen("$remotefile", "r");
//prelevo il nome del file
$nomefile=$monmicro_file;
//apro il file in locale
if (!($fp1 = fopen($cartella.$nomefile,"w")));
//scrivo contenuto del file remoto, ora in temp file, in file locale
while ($contents = fread( $srcfile1, 8192 )) {
	$contents=utf8_encode($contents);
	fwrite( $fp1, $contents, strlen($contents) );
}
//chiudo i due files
fclose($srcfile1);
fclose($fp1);




echo 'ok';
?>