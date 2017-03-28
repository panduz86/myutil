<?php
/**********************************************************************************
* index.php                                                                       *
* File Location : /                                                               *
***********************************************************************************
* FRONTEND: configuratore                                                         *
* =============================================================================== *
* Software Version:           1.1 - Date : 01/2017                                *
* Software by:                KAMALAB.COM                                         *
* Copyright (c) 2009 by:      KAMALAB.COM                                         *
* Support, News, Updates at:  INFO (AT) KAMALAB.COM                               *
***********************************************************************************
*                                                                                 *
* La duplicazione o la vendita senza l'autorizzazione della KAMALAB               *
* comporta una violazione delle norme sul diritto d'autore e copyright nonchè una *
* violazione della proprietà intellettuale.                                       *
*                                                                                 *
* KAMALAB si riserverà di tutelare i propri interessi nelle sedi e nei            *
* modi che riterrà più opportuno.                                                 *
**********************************************************************************/

include("adminCPgestione/conf/config.php");
include("adminCPgestione/include/functions.php");
include("adminCPgestione/include/connection_db.php");
include("include/Mobile_Detect.php");

	$detect = new Mobile_Detect;
	$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
	
$root_sito ="home";

include("include/head.php"); 
?><script type="text/javascript">/* <![CDATA[ */var baseDir='http://www.i-parts.it/';var static_token='e7adb6862e2fe0181a838f4239c10874';var token='b828ff58088248656f7cbdfc8a2a69da';var priceDisplayPrecision=2;var priceDisplayMethod=0;var roundMode=2;var prestashop_version=1.4;var responsive=1;/* ]]> */</script><script type="text/javascript">/* <![CDATA[ */var _gaq=_gaq||[];_gaq.push(['_setAccount','UA-46218729-1']);_gaq.push(['_setSiteSpeedSampleRate',5]);_gaq.push(['_trackPageview','index']);(function(){var ga=document.createElement('script');ga.type='text/javascript';ga.async=true;ga.src=('https:'==document.location.protocol?'https://ssl':'http://www')+'.google-analytics.com/ga.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(ga,s);})();/* ]]> */</script></head>

	<body id="index"> 
<header><div id="header_container">  <div class="container" id="header">   <a href="http://www.i-parts.it/" id="header_logo" title="i-Parts.it - Ricambi per iPhone,iPad e iPod">   <img class="logo" src="http://www.i-parts.it/img/logo.jpg" alt="i-Parts.it - Ricambi per iPhone,iPad e iPod" /> </a>    </div><div class="container" id="categoriestopmenu"> 

<div class="selected" id="categoriestopmenu_home"> <a href="http://www.i-parts.it/ricambi-iphone-ipad-galaxy" title="Home"><i class="fa fa-home fa-2x"></i></a></div>

 <div id="categoriestopmenu_showmenu"><a href="#" onClick="$('#categoriestopmenu_ul').slideToggle('slow');return false;" title="Menu">Menu<span class="menu_arrows"></span><i class="fa fa-bars"></i></a></div> 
 
 <div id="categoriestopmenu_news"  >
 
 <a href="http://www.i-parts.it/nuovi-prodotti" title="Nuovi Prodotti">Nuovi Prodotti</a></div>  
 
 <ul id="categoriestopmenu_ul"><li class="node" id="categoriestopmenu_node_100"> <a class="nodelink node_parent" href="http://www.i-parts.it/100-iphone-ricondizionati" id="categoriestopmenu_nodelink_100" style="padding-right:25px" title="iPhone Ricondizionati">iPhone Ricondizionati<span class="node_arrows"><i class="fa fa-sort-desc"></i></span></a><ul>
 
 <li class="node" id="categoriestopmenu_node_99"> <a class="nodelink" href="http://www.i-parts.it/99-iphone-4s-usati-ricondizionati" id="categoriestopmenu_nodelink_99" title="iPhone 4S">iPhone 4S</a></li><li class="node" id="categoriestopmenu_node_98"> <a class="nodelink" href="http://www.i-parts.it/98-iphone-5-ricondizionati" id="categoriestopmenu_nodelink_98" title="iPhone 5">iPhone 5</a></li><li class="node" id="categoriestopmenu_node_106"> <a class="nodelink" href="http://www.i-parts.it/106-iphone-5c-usati-ricondizionati" id="categoriestopmenu_nodelink_106" title="iPhone 5C">iPhone 5C</a></li><li class="node" id="categoriestopmenu_node_101"> <a class="nodelink" href="http://www.i-parts.it/101-iphone-5s-ricondizionati" id="categoriestopmenu_nodelink_101" title="iPhone 5S">iPhone 5S</a></li><li class="node" id="categoriestopmenu_node_119"> <a class="nodelink" href="http://www.i-parts.it/119-iphone-se-ricondizionati" id="categoriestopmenu_nodelink_119" title="iPhone SE">iPhone SE</a></li><li class="node" id="categoriestopmenu_node_104"> <a class="nodelink" href="http://www.i-parts.it/104-iphone-6-ricondizionati-usato" id="categoriestopmenu_nodelink_104" title="iPhone 6">iPhone 6</a></li><li class="node" id="categoriestopmenu_node_107"> <a class="nodelink" href="http://www.i-parts.it/107-iphone-6-plus-ricondizionati" id="categoriestopmenu_nodelink_107" title="iPhone 6 Plus">iPhone 6 Plus</a></li><li class="node" id="categoriestopmenu_node_112"> <a class="nodelink" href="http://www.i-parts.it/112-iphone-6s-ricondizionati" id="categoriestopmenu_nodelink_112" title="iPhone 6S">iPhone 6S</a></li><li class="node" id="categoriestopmenu_node_122"> <a class="nodelink" href="http://www.i-parts.it/122-iphone-6s-plus-ricondizionati" id="categoriestopmenu_nodelink_122" title="iPhone 6S Plus">iPhone 6S Plus</a></li><li class="node" id="categoriestopmenu_node_131"> <a class="nodelink" href="http://www.i-parts.it/131-iphone-7-ricondizionati-usato" id="categoriestopmenu_nodelink_131" title="iPhone 7">iPhone 7</a></li><li class="node last" id="categoriestopmenu_node_137"> <a class="nodelink" href="http://www.i-parts.it/137-iphone-7-plus-usato-ricondizionato" id="categoriestopmenu_nodelink_137" title="iPhone 7 Plus">iPhone 7 Plus</a></li></ul></li>
 
 <li class="node" id="categoriestopmenu_node_102"> <a class="nodelink node_parent" href="http://www.i-parts.it/102-ipad-usati-ricondizionati" id="categoriestopmenu_nodelink_102" style="padding-right:25px" title="iPad Ricondizionati">iPad Ricondizionati<span class="node_arrows"><i class="fa fa-sort-desc"></i></span></a><ul>
 
 <li class="node" id="categoriestopmenu_node_103"> <a class="nodelink" href="http://www.i-parts.it/103-ipad-2-usati-ricondizionati" id="categoriestopmenu_nodelink_103" title="iPad 2">iPad 2</a></li><li class="node" id="categoriestopmenu_node_123"> <a class="nodelink" href="http://www.i-parts.it/123-ipad-3-ricondizionati" id="categoriestopmenu_nodelink_123" title="iPad 3">iPad 3</a></li><li class="node" id="categoriestopmenu_node_124"> <a class="nodelink" href="http://www.i-parts.it/124-ipad-4-ricondizionati-usato" id="categoriestopmenu_nodelink_124" title="iPad 4">iPad 4</a></li><li class="node" id="categoriestopmenu_node_120"> <a class="nodelink" href="http://www.i-parts.it/120-ipad-mini-ricondizionati" id="categoriestopmenu_nodelink_120" title="iPad Mini">iPad Mini</a></li><li class="node" id="categoriestopmenu_node_136"> <a class="nodelink" href="http://www.i-parts.it/136-ipad-mini-2" id="categoriestopmenu_nodelink_136" title="iPad Mini 2">iPad Mini 2</a></li><li class="node" id="categoriestopmenu_node_127"> <a class="nodelink" href="http://www.i-parts.it/127-ipad-air-ricondizionati-usato" id="categoriestopmenu_nodelink_127" title="iPad Air">iPad Air</a></li><li class="node" id="categoriestopmenu_node_132"> <a class="nodelink" href="http://www.i-parts.it/132-ipad-air-2-ricondizionati" id="categoriestopmenu_nodelink_132" title="iPad Air 2">iPad Air 2</a></li><li class="node" id="categoriestopmenu_node_142"> <a class="nodelink" href="http://www.i-parts.it/142-ipad-pro-97-usato-ricondizionato-rigenerato" id="categoriestopmenu_nodelink_142" title="iPad Pro 9.7&quot;">iPad Pro 9.7&quot;</a></li><li class="node last" id="categoriestopmenu_node_143"> <a class="nodelink" href="http://www.i-parts.it/143-ipad-pro-129-usato-ricondizionato-rigenerato" id="categoriestopmenu_nodelink_143" title="iPad Pro 12.9&quot;">iPad Pro 12.9&quot;</a></li></ul></li>
 
 <li class="node" id="categoriestopmenu_node_113"> <a class="nodelink node_parent" href="http://www.i-parts.it/113-macbook-ricondizionati" id="categoriestopmenu_nodelink_113" style="padding-right:25px" title="Mac Ricondizionati">Mac Ricondizionati<span class="node_arrows"><i class="fa fa-sort-desc"></i></span></a><ul>
 
 <li class="node" id="categoriestopmenu_node_114"> <a class="nodelink" href="http://www.i-parts.it/114-macbook-2008-2009" id="categoriestopmenu_nodelink_114" title="MacBook ">MacBook </a></li><li class="node" id="categoriestopmenu_node_115"> <a class="nodelink" href="http://www.i-parts.it/115-macbook-air" id="categoriestopmenu_nodelink_115" title="MacBook Air">MacBook Air</a></li><li class="node" id="categoriestopmenu_node_116"> <a class="nodelink" href="http://www.i-parts.it/116-macbook-pro-usati-ricondizionati" id="categoriestopmenu_nodelink_116" title="MacBook Pro">MacBook Pro</a></li><li class="node" id="categoriestopmenu_node_128"> <a class="nodelink" href="http://www.i-parts.it/128-imac" id="categoriestopmenu_nodelink_128" title="iMac">iMac</a></li><li class="node last" id="categoriestopmenu_node_129"> <a class="nodelink" href="http://www.i-parts.it/129-mac-mini-usato-ricondizionato" id="categoriestopmenu_nodelink_129" title="Mac Mini">Mac Mini</a></li></ul></li>
 
 <li class="node" id="categoriestopmenu_node_108"> <a class="nodelink" href="http://www.i-parts.it/108-apple-watch" id="categoriestopmenu_nodelink_108" title="Apple Watch Ricondizionati">Apple Watch Ricondizionati</a></li>
 
 <li class="node last" id="categoriestopmenu_node_133"> <a class="nodelink node_parent" href="http://www.i-parts.it/133-accessori-iphone-ipadwatch" id="categoriestopmenu_nodelink_133" style="padding-right:25px" title="Accessori">Accessori<span class="node_arrows"><i class="fa fa-sort-desc"></i></span></a><ul><li class="node" id="categoriestopmenu_node_134"> <a class="nodelink" href="http://www.i-parts.it/134-cover-e-protezioni" id="categoriestopmenu_nodelink_134" title="Cover e Protezioni">Cover e Protezioni</a></li><li class="node" id="categoriestopmenu_node_135"> <a class="nodelink" href="http://www.i-parts.it/135-pellicole-vetro-temperato" id="categoriestopmenu_nodelink_135" title="Pellicole Vetro Temperato">Pellicole Vetro Temperato</a></li><li class="node" id="categoriestopmenu_node_140"> <a class="nodelink" href="http://www.i-parts.it/140-scatole-originali-iphone" id="categoriestopmenu_nodelink_140" title="Scatole Originali">Scatole Originali</a></li><li class="node last" id="categoriestopmenu_node_141"> <a class="nodelink" href="http://www.i-parts.it/141-cinturini-apple-watch" id="categoriestopmenu_nodelink_141" title="Cinturini Apple Watch">Cinturini Apple Watch</a></li></ul></li></ul>  <div class="clear" style="clear:both"></div></div><div>
		<div id="wrap">

		<div id="main">
			<?php	
			if($deviceType == 'computer')
			{
			?>				

                    <div class="first-block">

                    <div class="container">
                
                        
                        <div id="youtube-preview" class="pull-left">
                            <div>Scopri come funziona</div>
                            <img src="<?php echo $dir_immagini; ?>screen-video-td.jpg" alt="" data-toggle="modal" data-target="#youtube-modal" data-videosrc="https://www.youtube.com/embed/Z4FT43kXuIk" />
                        </div>
                        
                    
                        <a href="<?php echo $dir_immagini; ?>guida-condizioni-idevice-trendevice.pdf" style="
                              position: absolute;
                              bottom: 50px;
                              left: 15px;
                           " class="banner_home" target="_blank">
                              <img class="gradi" src="<?php echo $dir_immagini; ?>bannerino-ok.png" />      
                           </a>	

                            <div class="idevice">
                                <?php
                                }
                                ?>						

                                    <h1 class="vendi">
                                        Vendi il Tuo Vendere&nbsp;<strong>iPhone, iPad e Mac</strong><br />
                                                                        Scopri la nostra <em>quotazione</em>
                                     </h1>


                                <?php	
                                if($deviceType == 'computer')
                                {
                                ?>		


                                <img class='back' src='<?php echo $dir_immagini; ?>imgh.png'>

                                    <div class="inizia" id="show">
                                        Inizia qui
                                    </div>
                            </div>

                            <div class="bulletpoint pull-left">

                                <ul class="">

                                    <li>Pagamento in Contanti o con Buono Acquisto</li>                                
                                    <li>Ritiro a Domicilio <strong>GRATIS</strong></li>                                
                                    <li>Super Valutazione</li>                                
                                    <li><strong>100% Sicuro</strong></li>
                                    <li><div class="containerPopup">
                                                 <button class="btn_popup btn_popup-open" data-modal="open">>>> apri popup</button>
                                            </div></li> 
                                </ul>
                            </div>
                        </div>
                    
                        </div>
			<?php
			}
			?>			
			
                <div>
                    <div id="contenuto_usato" class="

					<?php
					if($deviceType == 'computer')
					{	
						echo "hide";
					}
					?>

					">
                        <div id="selezione_device">
                            <h2 class="titolo_usato">
                                <div class="freccia_step"></div>
                                Quale iDevice vuoi vendere?
                            </h2>
                            
                            <div id="elenco_device">
                                
			<?php
                        $SQLcate = $db->query("SELECT * FROM ".$prefix."categorie WHERE categoria_padre=0 ORDER BY titolo");
                        $conta_cate_0=1;
                        while($row_cate=$db->fetchNextArray($SQLcate)){
                            
                            $url_cate_0 = $dir_categoria.$row_cate['link_categoria'].".php";
                            $immagine = $dir_img_categorie."cat-".$row_cate['id_categoria']."-".$row_cate['categoria_padre'].$row_cate['est'];
							
                        ?>                                                            
                                <div class="device js-device" data-device="<?php echo $row_cate['id_categoria']; ?>">
                                    <div class="immagine_device">
                                        <img src="<?php echo $immagine; ?>" alt="<?php echo $row_cate['titolo']; ?>" />
                                    </div>
                                    <?php echo $row_cate['titolo']; ?>
                                </div>
                                
                        <?php } ?>

                            </div>
                            
                        </div>
                
 
                        <div id="selezione_modello" style="display: none">
                            <h2 class="sottotitolo_usato">
                                <div class="freccia_step"></div>
                                Seleziona il modello
                            </h2>
                            <div id="elenco_modelli">
                                <!-- RIEMPITO DA elenco_modelli.php -->
                            </div>
		        </div>


                        <div id="selezione_caratteristiche" style="display: none; margin-bottom: 200px;">
                            <h2 class="sottotitolo_usato">
                                <div class="freccia_step"></div>
                                Seleziona le caratteristiche
                            </h2>
                            
                            <div id="elenco_caratteristiche">
                                <!-- RIEMPITO DA elenco_caratteristiche.php -->
                            </div>
		        </div>

                        <div id="step_finale" method="post" style="display: none">
                            <div class="freccia_step"></div>
                            <button class="bottone_submit" id="js-valuta">
                                Valuta
                            </button>
                        </div>                

                        <div id="mask">
                            <!--  popup -->
                        </div>
                        
                    </div>
                </div>
                
                <div class="modal fade" id="youtube-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
                            </div>
                            <div class="modal-body">
                                <iframe width="100%" height="350" src=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- motore gestione menu a scelta -->              
                <script src="<?php echo $dir; ?>js/engine.js" type="text/javascript"></script>

	    </div>
            <!-- main -->
            
            </div>
            <!-- wrap -->
        
        <!-- INIZIO POPUP -->
        <div class="modal-wrapper" data-modal="wrapper">
            <form id="form_submit" method="post" action="<?php echo $dir; ?>pagina_destinazione.php">
            <div class="modal-content">
                <div class="relative">
                    <button data-modal="close" class="btn_popup btn_popup-close" type="button">&times;</button>
    
                    <div class="text">
                    
                          
                        <div id="pannello_submit">
                        
                            <div id="colonna_continua">
        
                                <div id="messaggio_stima">
                                    Sei pronto a incassare
                                    <br>
                                    <span id="stima"><!-- riempito da calcola_stima.php --></span> Euro
                                    ?
                                </div>
        
                                <div id="elenco_input"></div>
                                <input name="step_1" value="1" type="hidden">
                                <button class="bottone_submit" type="submit" id="js-submit">
                                    Sì, procedi!
                                </button>
        
                                <ul id="elenco_vantaggi_trendevice">
                                    <li>
                                        <svg width="15" height="15" class="checkbox_vantaggi" viewBox="0 0 15 15">
                                            <image xlink:href="<?php echo $dir_immagini; ?>bullet-green.svg" src="<?php echo $dir_immagini; ?>bullet-green.png" width="15" height="15"></image>
                                        </svg>
                                        Comodo: zero costi per il ritiro a domicilio, scegli tu giorno e orario
                                    </li>
                                    <li>
                                        <svg width="15" height="15" class="checkbox_vantaggi" viewBox="0 0 15 15">
                                            <image xlink:href="<?php echo $dir_immagini; ?>bullet-green.svg" src="<?php echo $dir_immagini; ?>bullet-green.png" width="15" height="15"></image>
                                        </svg>
                                        Sicuro: cancelliamo sempre tutti i dati personali dagli iDevice ritirati
        
                                    </li>
                                    <li>
                                        <svg width="15" height="15" class="checkbox_vantaggi" viewBox="0 0 15 15">
                                            <image xlink:href="<?php echo $dir_immagini; ?>bullet-green.svg" src="<?php echo $dir_immagini; ?>bullet-green.png" width="15" height="15"></image>
                                        </svg>
                                        Smart: il 91% dei clienti ha raccomandato questo servizio a un amico
                                    </li>
                                </ul>
        
        
                            </div>
                            <div id="colonna_invia_riepilogo">
                                <div id="testo_invia_riepilogo">
                                    Vai di fretta? Invia il riepilogo di valutazione alla tua casella email!!
                                </div>
                                <div id="form_invia_riepilogo">
                                    Email: <input value="" size="30" id="js-email_invia_riepilogo" type="text">
                                </div>
                                <button class="bottone_submit" id="bottone_invia_riepilogo" onclick="inviaEmail()" type="button">
                                    Inviami il riepilogo
                                </button>
                                <div id="risultato_invia_riepilogo_err" class="messaggio_error" style="display: none; opacity: 1;">Email non valida</div>
                                <div id="risultato_invia_riepilogo" class="messaggio_success" style="display: none; opacity: 1;">Una email con il riepilogo è stata inviata a "ssa@sss.com"</div>
				                                
                            </div>
                            
                            <div id="nota_stima">
                                Il prezzo offerto e mostrato in automatico è sempre soggetto alla verifica della veridicità dei dati forniti:
        la conferma della cifra proposta verrà confermata via email o telefonicamente al momento della ricezione del prodotto
        presso la sede di TrenDevice
                            </div>
                            <div class="clearfix"></div>
                        
                        </div>

                    </div>
                    
                    
                </div>
            </div>
                <input type="hidden" name="lista_attributi" id="lista_attributi" value="" /><!-- elenco id attributo divisi da virgola -->
                <input type="hidden" name="id_prodotto" id="id_prodotto" value=""/>
            </form>
        </div>

        <!-- FINE POPUP -->
        
       <?php echo include("include/footer.php"); ?>

    
	</body>
</html>