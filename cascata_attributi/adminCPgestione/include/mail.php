<?php

function invia_email_pannello_admin($path_testo_mail,$destinatario,$nome_mittente,$indirizzo_mittente,$url_sito,$oggetto_mail,$testo_mail){
	
	$dir=$url_sito;
	
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
	
	// costruiamo la sezione in formato html
	$fp=fopen($path_testo_mail,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	fclose($fp);
	$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
	$file_messaggio = str_replace("#testo#",$testo_mail,$file_messaggio);
	$file_messaggio = str_replace("#mittente#",$nome_mittente,$file_messaggio);
	
	$messaggio .= "--$boundary\n";
	$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
	$messaggio .= $file_messaggio."\n\n";

	// chiusura del messaggio con la stringa boundary
	$messaggio .= "--$boundary--\n";
		
	// Processo di invio 
	@mail($destinatario, $oggetto_mail, $messaggio, $header);
}

function invia_email_richiesta_contatto($path_testo_mail,$destinatario,$nome_mittente,$indirizzo_mittente,$url_sito,$email,$destinatario,$oggetto,$testo){
	
	$dir=$url_sito;
	
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
	
	// costruiamo la sezione in formato html
	$fp=fopen($path_testo_mail,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	fclose($fp);
	$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
	$file_messaggio = str_replace("#testo#",$testo,$file_messaggio);
	$file_messaggio = str_replace("#mittente#",$email,$file_messaggio);
	$file_messaggio = str_replace("#nome#",$nome,$file_messaggio);
	$file_messaggio = str_replace("#oggetto#",$oggetto,$file_messaggio);
	
	$messaggio .= "--$boundary\n";
	$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
	$messaggio .= $file_messaggio."\n\n";

	// chiusura del messaggio con la stringa boundary
	$messaggio .= "--$boundary--\n";
		
	// Processo di invio 
	@mail($destinatario, $oggetto_mail, $messaggio, $header);
}

function invia_email_registrazione_utente($path_testo_mail,$destinatario,$nome_mittente,$nome_sito,$indirizzo_mittente,$email_sistema,$email_supporto,$url_sito,$oggetto_mail,$id_utente,$nominativo,$password,$codice,$label101,$label102,$label103,$label104,$label105,$label106,$label107,$label108,$label109,$label110,$label111,$label112,$label113,$label114,$telefono_supporto){

	$dir=$url_sito;

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
	
	// costruiamo la sezione in formato html
	$fp=fopen($path_testo_mail,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	fclose($fp);
	$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
	$file_messaggio = str_replace("#art101#",$label101,$file_messaggio);	
	$file_messaggio = str_replace("#nominativo#",$nominativo,$file_messaggio);
	$file_messaggio = str_replace("#art102#",$label102,$file_messaggio);	
	$file_messaggio = str_replace("#nome_sito#",$nome_sito,$file_messaggio);
	$file_messaggio = str_replace("#art103#",$label103,$file_messaggio);	
	$file_messaggio = str_replace("#art104#",$label104,$file_messaggio);	
	$file_messaggio = str_replace("#art105#",$label105,$file_messaggio);	
	$file_messaggio = str_replace("#art106#",$label106,$file_messaggio);	
	$file_messaggio = str_replace("#email#",$destinatario,$file_messaggio);
	$file_messaggio = str_replace("#password#",$password,$file_messaggio);
	$file_messaggio = str_replace("#art107#",$label107,$file_messaggio);	
	$file_messaggio = str_replace("#art108#",$label108,$file_messaggio);	
	$file_messaggio = str_replace("#art109#",$label109,$file_messaggio);	
	$file_messaggio = str_replace("#art110#",$label110,$file_messaggio);	
	$file_messaggio = str_replace("#art111#",$label111,$file_messaggio);	
	$file_messaggio = str_replace("#art112#",$label112,$file_messaggio);	
	$file_messaggio = str_replace("#art113#",$label113,$file_messaggio);	
	$file_messaggio = str_replace("#email_supporto#",$email_supporto,$file_messaggio);	
	$file_messaggio = str_replace("#art114#",$label114,$file_messaggio);	
	$file_messaggio = str_replace("#telefono_supporto#",$telefono_supporto,$file_messaggio);
	
	$messaggio .= "--$boundary\n";
	$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
	$messaggio .= $file_messaggio."\n\n";

	// chiusura del messaggio con la stringa boundary
	$messaggio .= "--$boundary--\n";
		
	// Processo di invio 
	@mail($destinatario, $oggetto_mail, $messaggio, $header);
}

function invia_email_registrazione_utente_admin($path_testo_mail,$destinatario,$nome_mittente,$indirizzo_mittente,$url_sito,$oggetto_email,$last_id,$password,$codice,$email_utente,$nominativo,$utente_tipo){
	
	$dir=$url_sito;
	$data_reg = date("Y/m/d H:i:s");

	$giorno = substr($data_reg,8,2);
	$mese = substr($data_reg,5,2);
	$anno = substr($data_reg,0,4);
	$ora_ita = substr($data_reg,11,8);

    $data_reg = $giorno."-".$mese."-".$anno." ".$ora_ita;
	
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
	
	// costruiamo la sezione in formato html
	$fp=fopen($path_testo_mail,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	fclose($fp);
	$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
	$file_messaggio = str_replace("#nome_utente#",$nominativo,$file_messaggio);
	$file_messaggio = str_replace("#id_utente#",$last_id,$file_messaggio);
	$file_messaggio = str_replace("#codice#",$codice,$file_messaggio);
	$file_messaggio = str_replace("#email_utente#",$email_utente,$file_messaggio);
	$file_messaggio = str_replace("#password#",$password,$file_messaggio);
	$file_messaggio = str_replace("#nome_sito#",$nome_mittente,$file_messaggio);
	$file_messaggio = str_replace("#utente_tipo#",$utente_tipo,$file_messaggio);
	
	$messaggio .= "--$boundary\n";
	$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
	$messaggio .= $file_messaggio."\n\n";

	// chiusura del messaggio con la stringa boundary
	$messaggio .= "--$boundary--\n";
		
	// Processo di invio 
	@mail($destinatario, $oggetto_email, $messaggio, $header);
}

function invia_email_recupera_password($path_testo_mail,$destinatario,$nome_mittente,$indirizzo_mittente,$url_sito,$oggetto_mail,$nominativo,$password){
	
	$dir=$url_sito;
	
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
	
	// costruiamo la sezione in formato html
	$fp=fopen($path_testo_mail,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	fclose($fp);
	$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
	$file_messaggio = str_replace("#email#",$destinatario,$file_messaggio);
	$file_messaggio = str_replace("#nome_utente#",$nominativo,$file_messaggio);
	$file_messaggio = str_replace("#password#",$password,$file_messaggio);
	$file_messaggio = str_replace("#nome_sito#",$nome_mittente,$file_messaggio);
	
	$messaggio .= "--$boundary\n";
	$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
	$messaggio .= $file_messaggio."\n\n";

	// chiusura del messaggio con la stringa boundary
	$messaggio .= "--$boundary--\n";
	
	
	// Processo di invio 
	@mail($destinatario, $oggetto_mail, $messaggio, $header);
}







function invia_email_newsletter($path_testo_mail,$destinatario,$nome_mittente,$email_sistema,$url_sito,$indirizzo_mittente,$oggetto_mail,$testo_mail,$id_utente){
	
	$dir=$url_sito;
	
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
	
	// costruiamo la sezione in formato html
	$fp=fopen($path_testo_mail,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	fclose($fp);
	$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
	$file_messaggio = str_replace("#testo#",$testo_mail,$file_messaggio);
	$file_messaggio = str_replace("#oggetto#",$oggetto_mail,$file_messaggio);
	$file_messaggio = str_replace("#email_sito#",$email_sistema,$file_messaggio);
	$file_messaggio = str_replace("#id_utente#",$id_utente,$file_messaggio);
	$file_messaggio = str_replace("#nome_sito#",$nome_mittente,$file_messaggio);
	
	$messaggio .= "--$boundary\n";
	$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
	$messaggio .= $file_messaggio."\n\n";

	// chiusura del messaggio con la stringa boundary
	$messaggio .= "--$boundary--\n";
		
	// Processo di invio 
	@mail($destinatario, $oggetto_mail, $messaggio, $header);
}

















function invia_email_ordine_lavorazione($path_testo_mail,$destinatario,$nome_mittente,$indirizzo_mittente,$url_sito,$oggetto_mail,$cod_ordine,$nominativo,$dirscrivania){
	
	$dir=$url_sito;
	
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
	
	// costruiamo la sezione in formato html
	$fp=fopen($path_testo_mail,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	fclose($fp);
	$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
	$file_messaggio = str_replace("#nome_utente#",$nominativo,$file_messaggio);
	$file_messaggio = str_replace("#codordine#",$cod_ordine,$file_messaggio);
	$file_messaggio = str_replace("#nome_sito#",$nome_mittente,$file_messaggio);
	$file_messaggio = str_replace("#oggetto#",$oggetto_mail,$file_messaggio);
	$file_messaggio = str_replace("#dirweb#",$dirscrivania,$file_messaggio);
	
	
	$messaggio .= "--$boundary\n";
	$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
	$messaggio .= $file_messaggio."\n\n";

	// chiusura del messaggio con la stringa boundary
	$messaggio .= "--$boundary--\n";
		
	// Processo di invio 
	@mail($destinatario, $oggetto_mail, $messaggio, $header);
}

function invia_email_ordine_rifiutato($path_testo_mail,$destinatario,$nome_mittente,$indirizzo_mittente,$url_sito,$oggetto_mail,$cod_ordine,$nominativo,$dirscrivania){
	
	$dir=$url_sito;
	
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
	
	// costruiamo la sezione in formato html
	$fp=fopen($path_testo_mail,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	fclose($fp);
	$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
	$file_messaggio = str_replace("#nome_utente#",$nominativo,$file_messaggio);
	$file_messaggio = str_replace("#codordine#",$cod_ordine,$file_messaggio);
	$file_messaggio = str_replace("#nome_sito#",$nome_mittente,$file_messaggio);
	$file_messaggio = str_replace("#oggetto#",$oggetto_mail,$file_messaggio);
	$file_messaggio = str_replace("#dirweb#",$dirscrivania,$file_messaggio);
	
	
	$messaggio .= "--$boundary\n";
	$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
	$messaggio .= $file_messaggio."\n\n";

	// chiusura del messaggio con la stringa boundary
	$messaggio .= "--$boundary--\n";
		
	// Processo di invio 
	@mail($destinatario, $oggetto_mail, $messaggio, $header);
}

function invia_email_ordine_consegnato($path_testo_mail,$destinatario,$nome_mittente,$indirizzo_mittente,$url_sito,$oggetto_mail,$cod_ordine,$nominativo,$dirscrivania){
	
	$dir=$url_sito;
	
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
	
	// costruiamo la sezione in formato html
	$fp=fopen($path_testo_mail,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	fclose($fp);
	$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
	$file_messaggio = str_replace("#nome_utente#",$nominativo,$file_messaggio);
	$file_messaggio = str_replace("#codordine#",$cod_ordine,$file_messaggio);
	$file_messaggio = str_replace("#nome_sito#",$nome_mittente,$file_messaggio);
	$file_messaggio = str_replace("#oggetto#",$oggetto_mail,$file_messaggio);
	$file_messaggio = str_replace("#dirweb#",$dirscrivania,$file_messaggio);
	
	
	$messaggio .= "--$boundary\n";
	$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
	$messaggio .= $file_messaggio."\n\n";

	// chiusura del messaggio con la stringa boundary
	$messaggio .= "--$boundary--\n";
		
	// Processo di invio 
	@mail($destinatario, $oggetto_mail, $messaggio, $header);
}

function invia_email_ordine_spedito($path_testo_mail,$destinatario,$nome_mittente,$indirizzo_mittente,$url_sito,$oggetto_mail,$cod_ordine,$nominativo,$url,$codice_spedizione,$nome_corriere){
	
	$dir=$url_sito;
	
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
	
	// costruiamo la sezione in formato html
	$fp=fopen($path_testo_mail,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	fclose($fp);
	$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
	$file_messaggio = str_replace("#nome_utente#",$nominativo,$file_messaggio);
	$file_messaggio = str_replace("#codordine#",$cod_ordine,$file_messaggio);
	$file_messaggio = str_replace("#nome_sito#",$nome_mittente,$file_messaggio);
	$file_messaggio = str_replace("#oggetto#",$oggetto_mail,$file_messaggio);
	$file_messaggio = str_replace("#tracking#",$url,$file_messaggio);
	$file_messaggio = str_replace("#codice#",$codice_spedizione,$file_messaggio);
	$file_messaggio = str_replace("#nome_corriere#",$nome_corriere,$file_messaggio);
	
	
	$messaggio .= "--$boundary\n";
	$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
	$messaggio .= $file_messaggio."\n\n";

	// chiusura del messaggio con la stringa boundary
	$messaggio .= "--$boundary--\n";
		
	// Processo di invio 
	@mail($destinatario, $oggetto_mail, $messaggio, $header);
}

function invia_email_ticket_utente($path_testo_mail,$destinatario,$nome_mittente,$indirizzo_mittente,$url_sito,$oggetto_mail,$nominativo){
	
	$dir=$url_sito;
	
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
	
	// costruiamo la sezione in formato html
	$fp=fopen($path_testo_mail,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	fclose($fp);
	$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
	$file_messaggio = str_replace("#nome_utente#",$nominativo,$file_messaggio);
	$file_messaggio = str_replace("#nome_sito#",$nome_mittente,$file_messaggio);
	
	$messaggio .= "--$boundary\n";
	$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
	$messaggio .= $file_messaggio."\n\n";

	// chiusura del messaggio con la stringa boundary
	$messaggio .= "--$boundary--\n";
		
	// Processo di invio 
	@mail($destinatario, $oggetto_mail, $messaggio, $header);
}

function invia_email_ticket_dasito($path_testo_mail,$destinatario,$nome_mittente,$indirizzo_mittente,$url_sito,$oggetto_mail,$testo_risposta){
	
	$dir=$url_sito;
	
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
	
	// costruiamo la sezione in formato html
	$fp=fopen($path_testo_mail,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	fclose($fp);
	$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
	$file_messaggio = str_replace("#oggetto#",$oggetto_mail,$file_messaggio);
	$file_messaggio = str_replace("#risposta#",$testo_risposta,$file_messaggio);
	$file_messaggio = str_replace("#nome_sito#",$nome_mittente,$file_messaggio);
	
	$messaggio .= "--$boundary\n";
	$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
	$messaggio .= $file_messaggio."\n\n";

	// chiusura del messaggio con la stringa boundary
	$messaggio .= "--$boundary--\n";
		
	// Processo di invio 
	@mail($destinatario, $oggetto_mail, $messaggio, $header);
}

function invia_email_reso_concluso($path_testo_mail,$destinatario,$nome_mittente,$indirizzo_mittente,$url_sito,$oggetto_mail,$numero_reso,$nominativo){
	
	$dir=$url_sito;
	
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
	
	// costruiamo la sezione in formato html
	$fp=fopen($path_testo_mail,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	fclose($fp);
	$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
	$file_messaggio = str_replace("#nome_utente#",$nominativo,$file_messaggio);
	$file_messaggio = str_replace("#codreso#",$numero_reso,$file_messaggio);
	$file_messaggio = str_replace("#nome_sito#",$nome_mittente,$file_messaggio);
	$file_messaggio = str_replace("#oggetto#",$oggetto_mail,$file_messaggio);
	
	$messaggio .= "--$boundary\n";
	$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
	$messaggio .= $file_messaggio."\n\n";

	// chiusura del messaggio con la stringa boundary
	$messaggio .= "--$boundary--\n";
		
	// Processo di invio 
	@mail($destinatario, $oggetto_mail, $messaggio, $header);
}

function invia_email_pagamento_ricevuto($path_testo_mail,$destinatario,$nome_mittente,$indirizzo_mittente,$url_sito,$oggetto_mail,$id_ordine,$nominativo){
	
	$dir=$url_sito;
	
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
	
	// costruiamo la sezione in formato html
	$fp=fopen($path_testo_mail,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	fclose($fp);
	$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
	$file_messaggio = str_replace("#nome_utente#",$nominativo,$file_messaggio);
	$file_messaggio = str_replace("#id#",$id_ordine,$file_messaggio);
	$file_messaggio = str_replace("#nome_sito#",$nome_mittente,$file_messaggio);
	$file_messaggio = str_replace("#oggetto#",$oggetto_mail,$file_messaggio);
	
	$messaggio .= "--$boundary\n";
	$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
	$messaggio .= $file_messaggio."\n\n";

	// chiusura del messaggio con la stringa boundary
	$messaggio .= "--$boundary--\n";
		
	// Processo di invio 
	@mail($destinatario, $oggetto_mail, $messaggio, $header);
}

function invia_email_valutazione_reso_accettato($path_testo_mail,$destinatario,$nome_mittente,$indirizzo_mittente,$url_sito,$oggetto_mail,$id_reso){
	
	$dir=$url_sito;
	
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
	
	// costruiamo la sezione in formato html
	$fp=fopen($path_testo_mail,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	fclose($fp);
	$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
	$file_messaggio = str_replace("#nome_sito#",$nome_mittente,$file_messaggio);
	$file_messaggio = str_replace("#oggetto#",$oggetto_mail,$file_messaggio);
	$file_messaggio = str_replace("#idreso#",$id_reso,$file_messaggio);
	
	$messaggio .= "--$boundary\n";
	$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
	$messaggio .= $file_messaggio."\n\n";

	// chiusura del messaggio con la stringa boundary
	$messaggio .= "--$boundary--\n";
		
	// Processo di invio 
	@mail($destinatario, $oggetto_mail, $messaggio, $header);
}

function invia_email_valutazione_reso_nonaccettato($path_testo_mail,$destinatario,$nome_mittente,$indirizzo_mittente,$url_sito,$oggetto_mail,$id_reso){
	
	$dir=$url_sito;
	
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
	
	// costruiamo la sezione in formato html
	$fp=fopen($path_testo_mail,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	fclose($fp);
	$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
	$file_messaggio = str_replace("#nome_sito#",$nome_mittente,$file_messaggio);
	$file_messaggio = str_replace("#oggetto#",$oggetto_mail,$file_messaggio);
	$file_messaggio = str_replace("#idreso#",$id_reso,$file_messaggio);
	
	$messaggio .= "--$boundary\n";
	$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
	$messaggio .= $file_messaggio."\n\n";

	// chiusura del messaggio con la stringa boundary
	$messaggio .= "--$boundary--\n";
		
	// Processo di invio 
	@mail($destinatario, $oggetto_mail, $messaggio, $header);
}

function invia_email_aggiornamento_stato_reso($path_testo_mail,$destinatario,$nome_mittente,$indirizzo_mittente,$url_sito,$oggetto_mail,$id_reso){
	
	$dir=$url_sito;
	
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
	
	// costruiamo la sezione in formato html
	$fp=fopen($path_testo_mail,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	fclose($fp);
	$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
	$file_messaggio = str_replace("#nome_sito#",$nome_mittente,$file_messaggio);
	$file_messaggio = str_replace("#oggetto#",$oggetto_mail,$file_messaggio);
	$file_messaggio = str_replace("#idreso#",$id_reso,$file_messaggio);
	
	$messaggio .= "--$boundary\n";
	$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
	$messaggio .= $file_messaggio."\n\n";

	// chiusura del messaggio con la stringa boundary
	$messaggio .= "--$boundary--\n";
		
	// Processo di invio 
	@mail($destinatario, $oggetto_mail, $messaggio, $header);
}

function invia_email_ordine_reso_spedito($path_testo_mail,$destinatario,$nome_mittente,$indirizzo_mittente,$url_sito,$oggetto_mail,$cod_ordine,$nominativo,$url,$codice_spedizione,$nome_corriere){
	
	$dir=$url_sito;
	
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
	
	// costruiamo la sezione in formato html
	$fp=fopen($path_testo_mail,"r");
	$file_content="";
	while(!feof($fp)){
		$file_content.=fread($fp,4096);
	}
	fclose($fp);
	$file_messaggio = str_replace("#url_sito#",$dir,$file_content);
	$file_messaggio = str_replace("#nome_utente#",$nominativo,$file_messaggio);
	$file_messaggio = str_replace("#codordine#",$cod_ordine,$file_messaggio);
	$file_messaggio = str_replace("#nome_sito#",$nome_mittente,$file_messaggio);
	$file_messaggio = str_replace("#oggetto#",$oggetto_mail,$file_messaggio);
	$file_messaggio = str_replace("#tracking#",$url,$file_messaggio);
	$file_messaggio = str_replace("#codice#",$codice_spedizione,$file_messaggio);
	$file_messaggio = str_replace("#nome_corriere#",$nome_corriere,$file_messaggio);
	
	
	$messaggio .= "--$boundary\n";
	$messaggio .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$messaggio .= "Content-Transfer-Encoding: 7bit\n\n";
	$messaggio .= $file_messaggio."\n\n";

	// chiusura del messaggio con la stringa boundary
	$messaggio .= "--$boundary--\n";
		
	// Processo di invio 
	@mail($destinatario, $oggetto_mail, $messaggio, $header);
}
?>