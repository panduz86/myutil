<?php

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
include dirname(__FILE__).'/moda2000import.php';


$serveur_file=Configuration::get('PSM_DANEA_LINK');
$is_zip = Configuration::get('PSM_DANEA_ZIP');




		
		 //-- Parametri connessione FTP
        $ftp_server = Configuration::get('PSM_DANEA_HOST'); 
        $ftp_user_name = Configuration::get('PSM_DANEA_USER'); 
        $ftp_user_pass = Configuration::get('PSM_DANEA_PSW'); 
        
                $ftp_path = Configuration::get('PSM_DANEA_URL'); 

        //$destination_file = $folder_path.$local_file;
		

print_r('TEST: '.$ftp_server);		
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, $ftp_user_name, $ftp_user_pass);

$local_file = dirname(__FILE__).'/'.Configuration::get('PSM_DANEA_FZIP');

$server_file = Configuration::get('PSM_DANEA_FZIP');

print '<br>'.$ftp_path .'/'.$server_file.'<br>';
// download server file

if (ftp_get($ftp_conn, $local_file, $ftp_path.'/'.$server_file, FTP_BINARY))
  {
  echo "Successfully written to $local_file.<br>";
  }
else
  {
  echo "Error downloading $server_file.<br>";
  }
  
   print('TEST: '.$local_file.'<br>');


// close connection
ftp_close($ftp_conn);
       sleep(5);
       
 $zipFile = Configuration::get('PSM_DANEA_FZIP');
 $dirFromZip = dirname(__FILE__).'/';
 
 print '<br>--'.$dirFromZip.$zipFile;
 $zip = new ZipArchive;
if ($zip->open($dirFromZip.$zipFile) === TRUE) {
    $zip->extractTo($dirFromZip);
    $zip->close();
    echo 'ok';
} else {
    echo 'failed';
}

$nomefile = 'artmoda.xml';
$remotefile=$dirFromZip.'ArtModa.xml';
//Cartella locale in cui copiare il file
$cartella=$dirFromZip; // cartella dove mettere immagini
//apro il file remoto da leggere
$srcfile1 = fopen("$remotefile", "r");
//apro il file in locale
if (!($fp1 = fopen($cartella.$nomefile,"w")));
//scrivo contenuto del file remoto, ora in temp file, in file locale
print $cartella.$nomefile;
while ($contents = fread( $srcfile1, 8192 )) {
	$contents=utf8_encode($contents);
	fwrite( $fp1, $contents, strlen($contents) );
}
//chiudo i due files
fclose($srcfile1);
fclose($fp1);




     
/*

$zipFile = Configuration::get('PSM_DANEA_FZIP');
 $dirFromZip = 'dirname(__FILE__)';
   
    define(DIRECTORY_SEPARATOR, '/');

    $zipDir = getcwd() . DIRECTORY_SEPARATOR;
    print '<br>dirfile: '.$zipDir.$zipFile;
    $zip = zip_open($zipDir.$zipFile);
    if ($zip)
    {
        while ($zip_entry = zip_read($zip))
        {
            $completePath = $zipDir . dirname(zip_entry_name($zip_entry));
            $completeName = $zipDir . zip_entry_name($zip_entry);
            // Walk through path to create non existing directories
            // This won't apply to empty directories ! They are created further below

            if(!file_exists($completePath) && preg_match( '#^' . $dirFromZip .'.*#', dirname(zip_entry_name($zip_entry)) ) )
            {
                $tmp = '';
                foreach(explode('/',$completePath) AS $k)
                {
                    $tmp .= $k.'/';
                    if(!file_exists($tmp) )
                    {
                        @mkdir($tmp, 0777);
                    }
                }
            }
           
            if (zip_entry_open($zip, $zip_entry, "r"))
            {
            	print '<br>'.$completePath;
            	print '<br>'.$completeName;
            	
                if( 1 )
                {
                    if ($fd = @fopen($completeName, 'w+'))
                    {
                    	print '+';
                        fwrite($fd, utf8_encode(zip_entry_read($zip_entry, zip_entry_filesize($zip_entry))));
                        fclose($fd);
                    }
                    else
                    {
                        // We think this was an empty directory
                        mkdir($completeName, 0777);
                    }
                    zip_entry_close($zip_entry);
                }
            }
        }
        zip_close($zip);
    }

       
   
       
       
 */       


echo '<br> OK!!!';
?>