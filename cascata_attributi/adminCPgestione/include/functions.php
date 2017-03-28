<?php
/*
FUNZIONI DI UTILITA'
*/
function stampa_prezzo($prezzo){
 return number_format($prezzo, 2, '.', '');
}

	// per stampare un tot di caratteri news
function textpreviewnews($text, $caratteri=80) {
  $text = stripslashes($text);
  
  if(strlen($text)>$caratteri) {
    $newtext = wordwrap($text, $caratteri, "|");
    $nuovotesto=explode("|",$newtext);
     return $nuovotesto[0]."...";
  } else {
     return $text;
  }
}
	// per stampare un tot di caratteri pagina statica
function textpreviewstat($text, $caratteri=200) {
  $text = stripslashes($text);
  
  if(strlen($text)>$caratteri) {
    $newtext = wordwrap($text, $caratteri, "|");
    $nuovotesto=explode("|",$newtext);
     return $nuovotesto[0]."...";
  } else {
     return $text;
  }
}


function getDataEstesa(){
	$giorno=date("d");
	$mese=getNomeMese(date("d-m-Y"));
	$anno=date("Y");
	$ora=date("H.i");
	$numero_giorno=date("N");
	switch ($numero_giorno){
		case "1":
			$nome_giorno= "Luned&igrave;";
			break;
		case "2":
			$nome_giorno= "Marted&igrave;";
			break;
		case "3":
			$nome_giorno= "Mercoled&igrave;";
			break;
		case "4":
			$nome_giorno= "Gioved&igrave;";
			break;
		case "5":
			$nome_giorno= "Venerd&igrave;";
			break;
		case "6":
			$nome_giorno= "Sabato";
			break;
		case "7":
			$nome_giorno= "Domenica";
			break;
	}
	
	return $nome_giorno." ".$giorno." ".$mese." ".$anno." alle ore ".$ora." in Italia";
}

function getAnno($data){
	$tmp=explode("-",$data);
	return $tmp[0];
}

function getNomeMese($data){
	$tmp=explode("-",$data);
	
	switch ($tmp[1]){
		case "1":
			return "gennaio";
		case "2":
			return "febbraio";
		case "3":
			return "marzo";
		case "4":
			return "aprile";
		case "5":
			return "maggio";
		case "6":
			return "giugno";
		case "7":
			return "luglio";
		case "8":
			return "agosto";
		case "9":
			return "settembre";
		case "10":
			return "ottobre";
		case "11":
			return "novembre";
		case "12":
			return "dicembre";
				
	}
}

function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 } 

function pulisci_stringa($nome)
{ 
    $nome=trim($nome);
    $nome=stripslashes($nome);
    $nome=strip_tags($nome);
    $nome=str_replace("'","",$nome);                
    $nome=str_replace("\"","",$nome);
    $nome=str_replace("\\","",$nome);
    $nome=str_replace("/","",$nome);
    $nome=str_replace("&","e",$nome);    
    $nome=str_replace(" - ","-",$nome);
    $nome=str_replace(" ","-",$nome);
    $nome=str_replace("!","",$nome);
    $nome=str_replace("?","",$nome);
    $nome=str_replace("@","",$nome);    
    $nome=str_replace("à","a",$nome);
    $nome=str_replace("è","e",$nome);
    $nome=str_replace("é","e",$nome);
    $nome=str_replace("ì","i",$nome);
    $nome=str_replace("í","i",$nome);
    $nome=str_replace("ò","o",$nome);
    $nome=str_replace("ù","u",$nome);
    $nome=str_replace("ã","u",$nome);
    $nome=str_replace("--","-",$nome);
    $nome=str_replace("---","-",$nome);
    $nome=str_replace("----","-",$nome);
    $nome=str_replace("-----","-",$nome);
	
    
    $nome=strtolower($nome);
    
    return $nome;
}

function pulisci_stringa_peremail($nome)
{ 
    $nome=str_replace("à","&agrave;",$nome);
    $nome=str_replace("è","&egrave;",$nome);
    $nome=str_replace("é","&eacute;",$nome);
    $nome=str_replace("ì","&igrave;",$nome);
    $nome=str_replace("í","&iacute;",$nome);
    $nome=str_replace("ò","&ograve;",$nome);
    $nome=str_replace("ù","&ugrave;",$nome);
    
    return $nome;
}

function crea_pagina($path_modello,$nome_file,$path_destinazione,$id,$livello){
	$fp=fopen($path_modello,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	$file_new = str_replace("##",pulisci_stringa($nome_file),$file_content);
	$file_new = str_replace("@@",$id,$file_new);
	$file_new = str_replace("%%",$livello,$file_new);
	fclose($fp);
	
	$fp2=fopen($path_destinazione.(pulisci_stringa($nome_file)).".php","w");
	fwrite($fp2,$file_new);
	fclose($fp2);
}

function crea_pagina_prodotto($path_modello,$nome_file,$path_destinazione,$idp,$id,$livello){
	$fp=fopen($path_modello,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	$file_new = str_replace("##",pulisci_stringa($nome_file),$file_content);
	$file_new = str_replace("££",$idp,$file_new);
	$file_new = str_replace("@@",$id,$file_new);
	$file_new = str_replace("%%",$livello,$file_new);
	fclose($fp);
	
	$fp2=fopen($path_destinazione.(pulisci_stringa($nome_file)).".php","w");
	fwrite($fp2,$file_new);
	fclose($fp2);
}

function crea_pagina_produttore($path_modello,$nome_file,$path_destinazione,$idp){
	$fp=fopen($path_modello,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	$file_new = str_replace("##",pulisci_stringa($nome_file),$file_content);
	$file_new = str_replace("££",$idp,$file_new);
	fclose($fp);
	
	$fp2=fopen($path_destinazione.(pulisci_stringa($nome_file)).".php","w");
	fwrite($fp2,$file_new);
	fclose($fp2);
}

	// formattazione data italiana
function ricadatita($data_ita)
{ 
	
	$giorno = substr($data_ita,8,2);
	$mese = substr($data_ita,5,2);
	$anno = substr($data_ita,0,4);
	$ora_ita = substr($data_ita,11,8);

    $stampo_data = $giorno."-".$mese."-".$anno;
	return $stampo_data;
}

	// formattazione data italiana + ora
function ricadatitaora($data_ita)
{ 
	
	$giorno = substr($data_ita,8,2);
	$mese = substr($data_ita,5,2);
	$anno = substr($data_ita,0,4);
	$ora_ita = substr($data_ita,11,8);

    $stampo_data = $giorno."-".$mese."-".$anno." ".$ora_ita;
	return $stampo_data;
}

	// formattazione data usa + ora
function ricadatusa($data_usa)
{ 
	
	$giorno = substr($data_usa,0,2);
	$mese = substr($data_usa,3,2);
	$anno = substr($data_usa,6,4);
	$ora = "00:00:00";

    $stampo_data = $anno."-".$mese."-".$giorno." ".$ora;
	return $stampo_data;
}

	// formattazione data usa + ora
function ricadatusaori($data_usa)
{ 
	
	$giorno = substr($data_usa,0,2);
	$mese = substr($data_usa,3,2);
	$anno = substr($data_usa,6,4);
	$ora = "00:00:00";

    $stampo_data = $anno."/".$mese."/".$giorno." ".$ora;
	return $stampo_data;
}

function AlexaRank( $url )
{
preg_match( '#<POPULARITY URL="(.*?)" TEXT="([0-9]+){1,}"/>#si', file_get_contents('http://data.alexa.com/data?cli=10&dat=s&url=' . $url), $p );
return ( $p[2] ) ? number_format( intval($p[2]) ):0;
}

function pulisci_stringa_login_varie($nome)
{ 
	$nome=stripslashes($nome);
	$nome=strip_tags($nome);
	$nome=trim($nome);
	$nome=str_replace("'","",$nome);				
	$nome=str_replace("\"","",$nome);							
	$nome=str_replace(" ","-",$nome);
	$nome=str_replace("à","",$nome);
	$nome=str_replace("è","",$nome);
	$nome=str_replace("é","",$nome);
	$nome=str_replace("ì","",$nome);
	$nome=str_replace("í","",$nome);
	$nome=str_replace("ò","",$nome);
	$nome=str_replace("ù","",$nome);
	$nome=str_replace("ã","",$nome);
	$nome=str_replace('"', "", $nome);
	$nome=str_replace('@', "", $nome);
	$nome=str_replace('!', "", $nome);
	$nome=str_replace('#', "", $nome);
	$nome=str_replace('$', "", $nome);
	$nome=str_replace('%', "", $nome);
	$nome=str_replace('^', "", $nome);
	$nome=str_replace('&', "", $nome);
	$nome=str_replace('*', "", $nome);
	$nome=str_replace('(', "", $nome);
	$nome=str_replace(')', "", $nome);
	$nome=str_replace('+', "", $nome);
	$nome=str_replace('=', "", $nome);
	$nome=str_replace('`', "", $nome);
	$nome=str_replace('~', "", $nome);
	$nome=str_replace(' ', "", $nome);
	$nome=str_replace(':', "", $nome);
	$nome=str_replace(';', "", $nome);
	$nome=str_replace(',', "", $nome);
	$nome=str_replace(']', "", $nome);
	$nome=str_replace('[', "", $nome);
	$nome=str_replace('<', "", $nome);
	$nome=str_replace('>', "", $nome);
	$nome=str_replace('|', "", $nome);
	$nome=str_replace('_', "", $nome);
	$nome=str_replace('-', "", $nome);
	return $nome;
}

// Use this to clean up email addresses.
function vdata_lite($data)
{
	return addslashes(htmlentities(strip_tags(trim($data))));
}

// per stampare un tot di caratteri da una stringa
function textpreview($text, $caratteri=100) {
  $text = stripslashes($text);
  if(strlen($text)>$caratteri) {
    $newtext = wordwrap($text, $caratteri, "|");
    $nuovotesto=explode("|",$newtext);
     return $nuovotesto[0]."...";
  } else {
     return $text;
  }
}

// leggo IP autorizzati
function getIP() { 
$ip; 
if (getenv("HTTP_CLIENT_IP")) 
$ip = getenv("HTTP_CLIENT_IP"); 
else if(getenv("HTTP_X_FORWARDED_FOR")) 
$ip = getenv("HTTP_X_FORWARDED_FOR"); 
else if(getenv("REMOTE_ADDR")) 
$ip = getenv("REMOTE_ADDR"); 
else 
$ip = "UNKNOWN";
return $ip; 
} 

function widget_income_overview($vars) {
    global $_ADMINLANG,$chart;
    
    $args = array();
    $args['colors'] = '#F9D88C,#1E78BB';
    $args['legendpos'] = 'top';
    $args['xlabel'] = 'Day of the Month';
    $args['ylabel'] = 'Default Currency';
    $args['chartarea'] = '80,40,85%,70%';

    $content = $chart->drawChart('Area','income',$args,'300px');

    return array('content'=>$content);

}

function codice_referal()
{ 
		$time = microtime();
		$randomstr = sha1("$time magic");
		$casual_lett = rand (1, 21);
		$lettera_1= $stringa_alfabeto[$casual_lett];
		$casual_lett = rand (1, 21);
		$lettera_2= $stringa_alfabeto[$casual_lett];
		$casual_lett = rand (1, 21);
		$lettera_3= $stringa_alfabeto[$casual_lett];
		$casual_lett = rand (1, 21);
		$lettera_4= $stringa_alfabeto[$casual_lett];

		$lettera_array = $lettera_1.$lettera_2.$lettera_3.$lettera_4;
		$referal_id = strtoupper($lettera_array.substr($randomstr,2,8));
    
    return $referal_id;
}

function codice_utente()
{ 
		$casual_lett = rand (1, 9);
		$lettera_1= $casual_lett;
		$casual_lett = rand (10, 50);
		$lettera_2= $casual_lett;
		$casual_lett = rand (1, 9);
		$lettera_3= $casual_lett;
		$casual_lett = rand (20, 31);
		$lettera_4= $casual_lett;
		$casual_lett = rand (1, 9);
		$lettera_5= $casual_lett;
		$casual_lett = rand (15, 70);
		$lettera_6= $casual_lett;
		$casual_lett = rand (1, 9);
		$lettera_7= $casual_lett;
		$casual_lett = rand (10, 21);
		$lettera_8= $casual_lett;
		$cod_utente = $lettera_1.$lettera_2.$lettera_3.$lettera_4.$lettera_5.$lettera_6.$lettera_7.$lettera_8;
    
    return $cod_utente;
}


function codice_coupon()
{
	$casual_lett = rand (1, 9);
	$lettera_1= $casual_lett;
	$casual_lett = rand (10, 50);
	$lettera_2= $casual_lett;
	$casual_lett = rand (1, 9);
	$lettera_3= $casual_lett;
	$casual_lett = rand (20, 31);
	$lettera_4= $casual_lett;
	$casual_lett = rand (1, 9);
	$lettera_5= $casual_lett;
	$casual_lett = rand (15, 70);
	$lettera_6= $casual_lett;
	$casual_lett = rand (1, 9);
	$lettera_7= $casual_lett;
	$casual_lett = rand (10, 21);
	$lettera_8= $casual_lett;
	return $lettera_1.$lettera_2.$lettera_3.$lettera_4.$lettera_5.$lettera_6.$lettera_7.$lettera_8;
}

function codice_attivazione()
{ 
       $stringa_alfabeto = array('a','b','c','d','e','f','g','h','i','l','m','n','o','p','q','r','s','t','u','v','z');
	   
		$time = microtime();
		$randomstr = sha1("$time magic");
		$casual_lett = rand (1, 21);
		$lettera_1= $stringa_alfabeto[$casual_lett];
		$casual_lett = rand (1, 21);
		$lettera_2= $stringa_alfabeto[$casual_lett];
		$casual_lett = rand (1, 21);
		$lettera_3= $stringa_alfabeto[$casual_lett];
		$casual_lett = rand (1, 21);
		$lettera_4= $stringa_alfabeto[$casual_lett];
		
		$lettera_array = $lettera_1.$lettera_2.$lettera_3.$lettera_4;
		$codice_att = strtoupper($lettera_array.substr($randomstr,2,11));
    
    return $codice_att;
}

   // scarico file da URL
		function download_remote_file($file_url, $save_to)
		{
			$content = file_get_contents($file_url);
			file_put_contents($save_to, $content);
		}

// arrotondamento
function arrotonda1($f, $p)  // $F = numero | $P = quanti decimali si vuole
{
     echo "f | ".$f." |p ".$p." | <br>";
	
    // Sono numeri di precisione piccola, uso la manipolazione simbolica
    $s = "$f";
    $dot = strpos($s, ".");

    if ($dot === false) { 
        // se non ci sono cifre decimali restituisco il numero formattato
        return round($f, $p);
		
    } else { 
	    // se ci sono cifre decimali comincio la verifica di arrotandamento
    
        // ricavo l'intero e il decimale
		$seziono_numero=explode('.',$s);
        $intero= trim($seziono_numero[0]);
		
        $decimale= trim($seziono_numero[1]);
        $decimale= substr($decimale, 0, 2);


        if($decimale==5) $decimale=$decimale."0";
		
     echo "intero | ".$intero." |decimale ".$decimale." | ";
     echo "<br>";	
	 
	// verifico se il decimale è < 95 applico arrotondamento decimale
	if($decimale<50) { echo "passa<br>";
        $decimale = (intval(substr($decimale,0,1)) - 1)*10*(strlen($decimale)-1);
	} else if($decimale>50 && $decimale<99) { echo "passa1<br>";
        $decimale = (intval(substr($decimale,0,1)) + 1)*10*(strlen($decimale)-1);
	} else if($decimale=50) { echo "passa2<br>";
        $decimale = $decimale;
		// altrimenti incremento l'intero di uno
	} else { echo "passa3<br>";
		$intero = $intero+1;
        $decimale =0;
	}

     echo "intero | ".$intero." |decimale ".$decimale." | ";
break;	 
    return $intero.".".$decimale;

    }
}

// arrotondamento
function arrotonda($f, $p)  // $F = numero | $P = quanti decimali si vuole
{

    // Sono numeri di precisione piccola, uso la manipolazione simbolica
    $s = "$f";
    $dot = strpos($s, ".");

    if ($dot === false) { 
        // se non ci sono cifre decimali restituisco il numero formattato
        return round($f, $p);
		
    } else { 
	    // se ci sono cifre decimali comincio la verifica di arrotandamento
    
        // ricavo l'intero e il decimale
		$seziono_numero=explode('.',$s);
        $intero= trim($seziono_numero[0]);
		
        $decimale= trim($seziono_numero[1]);
        $decimale= substr($decimale, 0, 2);


        if($decimale==5) $decimale=$decimale."0";
		
 //    echo "intero | ".$intero." |decimale ".$decimale." | ";
 //    echo "<br>";	


        $decimale1 = (intval(substr($decimale,0,1)));
        $decimale2 = (intval(substr($decimale,1,1)));

 //    echo "decimale1 | ".$decimale1." |decimale2 ".$decimale2." | ";
 //    echo "<br>";	
		
		if($decimale2<5) {
			$decimale2 = "0";
			
		} else if($decimale2>=5) {
			
			if($decimale1==9) {
			  $intero = $intero+1;
		 	  $decimale1 = "0";
		 	  $decimale2 = "0";
			} else {
			  $decimale1 = $decimale1+1;
			  $decimale2 = "0";
			}
		}
	 
		
 //    echo "decimale1 | ".$decimale1." |decimale2 ".$decimale2." | ";echo "<br>";
	 
    $decimale1 = $decimale1.$decimale2;
	 
   //  break;	 
    return $intero.".".$decimale1;

    }
}

function aggiungiGiorniAData($data,$num_giorni){
//$data deve essere con formato Y-m-d 2013-11-17 (nota i trattini)
if($num_giorni>1){
return date("d/m/Y",strtotime($data." +".$num_giorni." days"));
}
else{
return date("d/m/Y",strtotime($data." +1 day"));
}
//la data risultato viene restituita con formato d/m/Y 17/11/2013
}

function aggiungiMesiAData($data,$num_mesi){
//$data deve essere con formato Y-m-d 2013-11-17 (nota i trattini)
if($num_mesi>1){
return date("d/m/Y",strtotime($data." +".$num_mesi." months"));
}
else{
return date("d/m/Y",strtotime($data." +1 month"));
}
//la data risultato viene restituita con formato d/m/Y 17/11/2013
}


function aggiungiAnniAData($data,$num_anni){
//$data deve essere con formato Y-m-d 2013-11-17 (nota i trattini)
if($num_anni>1){
return date("d/m/Y",strtotime($data." +".$num_anni." years"));
}
else{
return date("d/m/Y",strtotime($data." +1 year"));
}
//la data risultato viene restituita con formato d/m/Y 17/11/2013
}

function aggiungiAnniFull($data,$num_anni){
//$data deve essere con formato Y-m-d 2013-11-17 (nota i trattini)
if($num_anni>1){
return date("d/m/Y",strtotime($data." +".$num_anni." years"));
}
else{
return date("d/m/Y",strtotime($data." +50 year"));
}
//la data risultato viene restituita con formato d/m/Y 17/11/2013
}


function mres_completo($value, $db) {
	if (! is_string ( $value )) {
		return $value;
	}
	
	// verifico se devo eliminare gli slash inseriti automaticamente da PHP
	if (! get_magic_quotes_gpc ()) {
		return $db->escape ( stripslashes ( $value ) );
	} else {
		$search = array (
				"\\",
				"\x00",
				"\n",
				"\r",
				"'",
				'"',
				"\x1a" 
		);
		$replace = array (
				"\\\\",
				"\\0",
				"\\n",
				"\\r",
				"\'",
				'\"',
				"\\Z" 
		);
		
		return $db->escape ( str_replace ( $search, $replace, $value ) );
	}
}

function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            self::deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}

// ricavo url pagian corrente
function get_current_url() {
  $url  = 'http' . ($_SERVER['HTTPS'] == 'on' ? 's' : '') . '://'
        . $_SERVER['SERVER_NAME']
        . ($_SERVER['SERVER_PORT'] !== 80  ? ':' . $_SERVER['SERVER_PORT'] : '')
        . $_SERVER['REQUEST_URI'];
  return $url;
}

function genID($length) { // genero un codice random
	
// http://stackoverflow.com/questions/18942553/loop-to-check-dupilicate-random-strings	
	
    $chars = "123456789123456789123456789123456789"; 
    //only allowed chars in the blowfish salt.
    $size = strlen($chars); $str = "";
    for ($i = 0; $i < $length; $i++)
        $str .= $chars[rand(0, $size - 1)]; // strings can be used as char arrays
        // Yes, I am aware this salt isn't generated using the OS source.
        // use mycrypt_create_iv or /dev/urandom/
    return $str;
}

function uHash(){ // crea id utente non registrato e controlla che non esiste nel db

// http://stackoverflow.com/questions/18942553/loop-to-check-dupilicate-random-strings	

    global $prefix, $db;
	
    $continue = true;
    while ($continue) {
		
	//  $code = time().microtime()*1000000;
	  $code = genID(10);
	  $code_id = substr($code,0,6);// utente non registrato

        $query = $db->query("SELECT * FROM ".$prefix."utenti WHERE id_utente=".$code_id." LIMIT 1");

        if ($db->numRows($query) != 1)
            $continue = false;

        return $code_id;
    }
}

?>