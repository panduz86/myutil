<?php
include("../conf/config.php");
include("functions.php");
include("connection_db.php");

// Recupero il nome del file dalla querystring
  $file_name = @$_GET['tpl'];

//Posizione reale del file del file
  $file_path= $path_dir_admin."bk_db/".$file_name;
//  $file_path = "../../".$path_file_remote.$file_name;

//Formato MIME del file
  $file_mime = "application/octet-string"; 

//Controllo esistenza del file
  if(file_exists($file_path))
  {	

//Ottieni la dimensione del file
    $file_size = filesize($file_path);

//Preparazione del protocollo di comunicazione tra browser e server
            header("Content-Type: application; name=" . $file_name);
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: " . $file_size);
            header("Content-Type: " . $file_mime);
            header("Content-Disposition: inline; filename=" . $file_name);
            header("Expires: 0");
            header("Cache-Control: no-cache, must-revalidate");
            header("Cache-Control: private");
            header("Pragma: public");
            
//Invio file al browser
            readfile($file_path);
			
}else{
	echo $file_path; echo "<br>";
die("Il file non esiste!");
}	
?>