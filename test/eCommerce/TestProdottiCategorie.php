<?php

//server address
define("SERVER","localhost");

//user name of mysql database
define("USER","root");

//password of above user of mysql
define("PWD","123456");

//database name
define("DB","kamalabc_ecomDB");
define("NL","\n");

// Database table prefix
define("PREFIX","ec_"); //Usato dalle classi
$prefix="ec_";

include_once '../../database/db.class.php';
$db = new DB(DB, SERVER, USER, PWD);

include_once '../../eCommerce/ProdottiCategorie.php';

//Inizio test

print_r(ProdottiCategorie::alberoCategorieDown(44));
