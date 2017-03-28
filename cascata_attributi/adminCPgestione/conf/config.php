<?php
@ session_start();

	/*******************************************************
	 *                                                     *
	 *    FILE DI CONFIGURAZIONE DEL SITO                  *
	 *                                                     *
	 *******************************************************/

date_default_timezone_set('Europe/Rome');


//mysqli details

//server address
define("SERVER","localhost");

//user name of mysql database
define("USER","root");

//password of above user of mysql
define("PWD","123456");

//database name
define("DB","luigi");
define("NL","\n");

// Database table prefix
define("PREFIX","ec_"); //Usato dalle classi
$prefix="ec_";

//define('COOKIE_DOMAIN', 'localhost/ecommerce');
define('COOKIE_DOMAIN', 'localhost/luigi');

//INDIRIZZO DEL SITO
$indirizzo_sito_web="http://localhost/luigi/";
$indirizzo_sito_web_sitemap="http://localhost/luigi";


//URL PRINCIPALE DEL SITO in HTTP
$dir="http://localhost/luigi/";

//URL PRINCIPALE DEL PANNELLO ADMIN
$dir_admin=$dir."adminCPgestione/";

//URL PRINCIPALE DEL PANNELLO UTENTE
$dir_utente_login=$dir."account/";

//############################################################################################

//URL CATEGORIE OMBRELLI
$dir_categoria= $dir."ombrelli/";

//URL IMMAGINI DEL SITO
$dir_immagini= $dir."images/";

//URL IMMAGINI ADMIN
$dir_immagini_admin= $dir_admin."images/";

//URL IMMAGINI PRODOTTI
$dir_img_prodotti= $dir."media/imgProdotti/";

//URL IMMAGINI CATEGORIE
$dir_img_categorie= $dir."media/imgCategorie/";

//URL IMMAGINI ATTRIBUTI
$dir_img_attributi= $dir."media/imgAttributi/";

//############################################################################################

//PATH PRINCIPALE DEL SITO
$path_dir=$_SERVER['DOCUMENT_ROOT']."/luigi/";

//PATH ADMIN
$path_dir_admin=$path_dir."adminCPgestione/";

//PATH IMMAGINI DEL SITO
$path_immagini = $path_dir."images/"; 

//PATH IMMAGINI PRODOTTI
$path_img_prodotti=$path_dir."media/imgProdotti/";

//PATH IMMAGINI CATEGORIE
$path_img_categorie= $path_dir."media/imgCategorie/";

//PATH IMMAGINI ATTRIBUTI
$path_img_attributi= $path_dir."media/imgAttributi/";

//###########################################################################################

//CONFIGURAZIONE INVIO E-MAIL
$indirizzo_mittente ="coderlamp@gmail.com";
$indirizzo_mittente_noreply ="coderlamp@gmail.com";

$nome_mittente="kamalab";
$email_sistema="coderlamp@gmail.com"; //email su cui riceverai i messaggi di contatto
$email_nocontat="coderlamp@gmail.com"; //email su cui riceverai i messaggi di contatto
$nome_sito="SITO.COM";

$email_supporto = "coderlamp@gmail.com"; // email su cuiriceverai i messaggi di richiesta supporto

?>