<?php

/*
 * block moda2000import
 * by Disarci italian community of PrestaShop
  copyright planete-i sarl
 * 

 */

class moda2000import extends Module {

    protected $maxFileSize = 10000000;

    function __construct() {


        $this->name = 'moda2000import';
        $this->tab = substr(_PS_VERSION_, 0, 3) < 1.4 ? 'PSM' : 'migration_tools';
        $this->version = 2.8;
        $this->author = 'Disarci';

        parent::__construct(); /* The parent construct is required for translations */

        $this->page = basename(__FILE__, '.php');
        $this->displayName = $this->l('Moda Import for PS');
        $this->description = $this->l('Can Import datas from Moda 2000');

        if (substr(_PS_VERSION_, 0, 3) >= 1.4){
            include_once(_PS_TOOL_DIR_ . 'pear/PEAR.php');
        }
        else{
            include_once(_PS_CLASS_DIR_ . 'PEAR.php');
        }

        include_once(_PS_PEAR_XML_PARSER_PATH_ . 'Parser.php');
        include_once(dirname(__FILE__) . '/import_classes.php');

        if (!Configuration::get('PSM_I_lang')){
            $this->warning = $this->l('You MUST fill all datas and press UPDATE CONFIGURATION');
        }
    }

    function install() {
        if (!parent::install()){
            return false;
        }


        if (!Configuration::updateValue('PSM_DANEA_COD', '000000'))
            return false;
        if (!Configuration::updateValue('PSM_DANEA_LINK', ' '))
            return false;
        if (!Configuration::updateValue('PSM_DANEA_ZIP', '0'))
            return false;
        if (!Configuration::updateValue('PSM_DANEA_CONVERTIMAGE', '0'))
            return false;
        if (!Configuration::updateValue('PSM_DANEA_USEDISCOUNT', '0'))
            return false;
        if (!Configuration::updateValue('PSM_DANEA_USEHOME', '0'))
            return false;
        if (!Configuration::updateValue('PSM_DANEA_PRESERVE_TABLES', '0'))
            return false;
        if (!Configuration::updateValue('PSM_DANEA_PRESERVE_IMAGES', '1'))
            return false;

        if (!Configuration::updateValue('PSM_DANEA_HOST', ' '))
            return false;
        if (!Configuration::updateValue('PSM_DANEA_USER', ' '))
            return false;
        if (!Configuration::updateValue('PSM_DANEA_PSW', ' '))
            return false;
        if (!Configuration::updateValue('PSM_DANEA_URL', '/'))
            return false;
        if (!Configuration::updateValue('PSM_DANEA_FZIP', ' '))
            return false;

        return true;
    }

    function uninstall() {
        if (!parent::uninstall())
            return false;
        if (!Configuration::deleteByName('PSM_I_lang'))
            return false;
        if (!Configuration::deleteByName('PSM_DANEA_COD'))
            return false;
        if (!Configuration::deleteByName('PSM_DANEA_LINK'))
            return false;
        if (!Configuration::deleteByName('PSM_DANEA_ZIP'))
            return false;
        if (!Configuration::deleteByName('PSM_DANEA_CONVERTIMAGE'))
            return false;
        if (!Configuration::deleteByName('PSM_DANEA_USEDISCOUNT'))
            return false;
        if (!Configuration::deleteByName('PSM_DANEA_USEHOME'))
            return false;
        if (!Configuration::deleteByName('PSM_DANEA_PRESERVE_TABLES'))
            return false;
        if (!Configuration::deleteByName('PSM_DANEA_PRESERVE_IMAGES'))
            return false;

        if (!Configuration::deleteByName('PSM_DANEA_HOST'))
            return false;
        if (!Configuration::deleteByName('PSM_DANEA_USER'))
            return false;
        if (!Configuration::deleteByName('PSM_DANEA_PSW'))
            return false;
        if (!Configuration::deleteByName('PSM_DANEA_URL'))
            return false;
        if (!Configuration::deleteByName('PSM_DANEA_FZIP'))
            return false;

        return true;
    }

    //terza
    function getContent() {

        if (substr(_PS_VERSION_, 0, 3) >= 1.5)
            $this->_html .= '<a href="' . $_SERVER['PHP_SELF'] . '?controller=' . $_GET['controller'] . '&token=' . $_GET['token'] . '&configure=' . $_GET['configure'] . '"><h2 class="imTitle">' . $this->displayName . '  ' . $this->version . '</h2></a>';
        else
            $this->_html .= '<a href="' . $_SERVER['PHP_SELF'] . '?tab=' . $_GET['tab'] . '&token=' . $_GET['token'] . '&configure=' . $_GET['configure'] . '"><h2 class="imTitle">' . $this->displayName . '  ' . $this->version . '</h2></a>';

        $url = dirname(__FILE__) . '/artmoda.xml';


        if (!empty($_POST)) {
            if (Tools::GetIsset('btnFtp')) {
                Configuration::updateValue('PSM_DANEA_HOST', Tools::getValue('PSM_DANEA_HOST'));
                Configuration::updateValue('PSM_DANEA_USER', Tools::getValue('PSM_DANEA_USER'));
                Configuration::updateValue('PSM_DANEA_PSW', Tools::getValue('PSM_DANEA_PSW'));
                Configuration::updateValue('PSM_DANEA_URL', Tools::getValue('PSM_DANEA_URL'));
                Configuration::updateValue('PSM_DANEA_FZIP', Tools::getValue('PSM_DANEA_FZIP'));
            }

            if (Tools::GetIsset('copyLink')) {
                Configuration::updateValue('PSM_DANEA_LINK', Tools::getValue('PSM_DANEA_LINK'));
            }

            if (Tools::GetIsset('btnSubmit')) {
                Configuration::updateValue('PSM_I_lang', Tools::getValue('PSM_I_lang'));
                Configuration::updateValue('PSM_DANEA_COD', Tools::getValue('PSM_DANEA_COD'));
                Configuration::updateValue('PSM_DANEA_CONVERTIMAGE', Tools::getValue('PSM_DANEA_CONVERTIMAGE'));
                Configuration::updateValue('PSM_DANEA_USEDISCOUNT', Tools::getValue('PSM_DANEA_USEDISCOUNT'));
                Configuration::updateValue('PSM_DANEA_USEHOME', Tools::getValue('PSM_DANEA_USEHOME'));
                Configuration::updateValue('PSM_DANEA_PRESERVE_TABLES', Tools::getValue('PSM_DANEA_PRESERVE_TABLES'));
                Configuration::updateValue('PSM_DANEA_PRESERVE_IMAGES', Tools::getValue('PSM_DANEA_PRESERVE_IMAGES'));



                $zip = Configuration::updateValue('PSM_DANEA_ZIP', Tools::getValue('PSM_DANEA_ZIP'));




                $this->_html .= '<div class="conf confirm"><img src="../img/admin/ok.gif" alt="' . $this->l('OK') . '" /> ' . $this->l('Settings updated') . '</div>';
            }
            if (Tools::GetIsset('SubmitFile')) {
                /* upload the file */
                $filename = $_FILES['file']['name'];
                $filesfx = substr($filename, - (strlen(strrchr($filename, '.'))));
                if ($filesfx != '.xml') {
                    $this->_html .= $this->displayError($this->l('You can upload only XML files.'));
                } elseif (isset($_FILES['file']) AND isset($_FILES['file']['tmp_name']) AND ! empty($_FILES['file']['tmp_name'])) {
                    if ($filename['size'] > $this->maxFileSize) {
                        $this->_html .= $error;
                        return false;
                    } elseif (!move_uploaded_file($_FILES['file']['tmp_name'], dirname(__FILE__) . '/artmoda.xml')) {
                        $this->_html .= $this->displayError($this->l('An error occurred during the image upload.'));
                        return false;
                    } else {
                        $this->_html .= '<div class="conf confirm"><img src="../img/admin/ok.gif" alt="' . $this->l('OK') . '" /> ' . $this->l('File successfully loaded') . '</div>';

                        if (file_exists(dirname(__FILE__) . '/artmoda.xml'))
                            chmod(dirname(__FILE__) . '/artmoda.xml', 0644);
                    }
                }
            }


            if (Tools::GetIsset('SubmitGO')) {
                if ($this->_xmlgo($url)) {
                    $this->_html .= '<div class="conf confirm"><img src="../img/admin/ok.gif" alt="' . $this->l('OK') . '" /> ' . $this->l('Product uploaded') . '</div>';
                    /* Import has finished, we can regenerate the categories nested tree */
                    if (substr(_PS_VERSION_, 0, 3) >= 1.4)
                        Category::regenerateEntireNtree();
                    //Module::hookExec('categoryUpdate'); 
                } else {
                    $this->_html .= $this->l('ERRORS in upload');
                }
            }
        }



        $PSM_DANEA_CONVERTIMAGE = Tools::getValue('PSM_DANEA_CONVERTIMAGE', Configuration::get('PSM_DANEA_CONVERTIMAGE'));
        $PSM_DANEA_USEDISCOUNT = Tools::getValue('PSM_DANEA_USEDISCOUNT', Configuration::get('PSM_DANEA_USEDISCOUNT'));
        $PSM_DANEA_USEHOME = Tools::getValue('PSM_DANEA_USEHOME', Configuration::get('PSM_DANEA_USEHOME'));
        $PSM_DANEA_PRESERVE_TABLES = Tools::getValue('PSM_DANEA_PRESERVE_TABLES', Configuration::get('PSM_DANEA_PRESERVE_TABLES'));
        $PSM_DANEA_PRESERVE_IMAGES = Tools::getValue('PSM_DANEA_PRESERVE_IMAGES', Configuration::get('PSM_DANEA_PRESERVE_IMAGES'));


        if (!Configuration::get('PSM_I_lang')) {

            $this->_html .= '<p class="alert">' . $this->l('Attention you have to choose the language!') . '</p>';
        }


        $this->_html .= '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
			<fieldset>
			<legend><img src="' . $this->_path . 'logo.gif" />' . $this->l('Information') . '</legend>
			<!--
			<label>' . $this->l('Convert images?') . '</label>
			<div class="margin-form">
				<input type="radio" name="PSM_DANEA_CONVERTIMAGE" value="1" ' . ($PSM_DANEA_CONVERTIMAGE ? 'checked="checked"' : '') . ' /> <label class="t">' . $this->l('Yes') . '</label>
				<input type="radio" name="PSM_DANEA_CONVERTIMAGE" value="0" ' . (!$PSM_DANEA_CONVERTIMAGE ? 'checked="checked"' : '') . ' /> <label class="t">' . $this->l('No') . '</label>
			</div>';
        if (!Configuration::get('PS_LEGACY_IMAGES') == 1 AND substr(_PS_VERSION_, 0, 3) >= 1.4)
            $this->_html .= $this->l('ATTENTION IMAGE MODE NOT GOOD, please go to Preferences - and set: Use the legacy image filesystem to YES') . '<br>';

        $this->_html .= '
			<br />
			<label>' . $this->l('Use price 5 as Discount?') . '</label>
			<div class="margin-form">
				<input type="radio" name="PSM_DANEA_USEDISCOUNT" value="1" ' . ($PSM_DANEA_USEDISCOUNT ? 'checked="checked"' : '') . ' /> <label class="t">' . $this->l('Yes') . '</label>
				<input type="radio" name="PSM_DANEA_USEDISCOUNT" value="0" ' . (!$PSM_DANEA_USEDISCOUNT ? 'checked="checked"' : '') . ' /> <label class="t">' . $this->l('No') . '</label>
			</div>
			<br />
			<label>' . $this->l('Usa Libero3 come Home?') . '</label>
			<div class="margin-form">
				<input type="radio" name="PSM_DANEA_USEHOME" value="1" ' . ($PSM_DANEA_USEHOME ? 'checked="checked"' : '') . ' /> <label class="t">' . $this->l('Yes') . '</label>
				<input type="radio" name="PSM_DANEA_USEHOME" value="0" ' . (!$PSM_DANEA_USEHOME ? 'checked="checked"' : '') . ' /> <label class="t">' . $this->l('No') . '</label>
			</div>
			<br />
			<label>' . $this->l('Preserve Images?') . '</label>
			<div class="margin-form">
				<input type="radio" name="PSM_DANEA_PRESERVE_IMAGES" value="1" ' . ($PSM_DANEA_PRESERVE_IMAGES ? 'checked="checked"' : '') . ' /> <label class="t">' . $this->l('Yes') . '</label>
				<input type="radio" name="PSM_DANEA_PRESERVE_IMAGES" value="0" ' . (!$PSM_DANEA_PRESERVE_IMAGES ? 'checked="checked"' : '') . ' /> <label class="t">' . $this->l('No') . '</label>
			</div>
			<p>' . $this->l('(if you set YES un update (with preserve tables) do NOT update images)') . '</p>
			<br />
			<label>' . $this->l('Preserve Tables?') . '</label>
			<div class="margin-form">
				<input type="radio" name="PSM_DANEA_PRESERVE_TABLES" value="1" ' . ($PSM_DANEA_PRESERVE_TABLES ? 'checked="checked"' : '') . ' /> <label class="t">' . $this->l('Yes') . '</label>
				<input type="radio" name="PSM_DANEA_PRESERVE_TABLES" value="0" ' . (!$PSM_DANEA_PRESERVE_TABLES ? 'checked="checked"' : '') . ' /> <label class="t">' . $this->l('No') . '</label>
			</div>
			<p>' . $this->l('(if Yes Danea can\'t clear all products/categories and just make update)') . '</p>
			
			-->
			<br />  ';

        if (!Configuration::get('PS_SMARTY_CACHE') == 0 AND substr(_PS_VERSION_, 0, 3) >= 1.4)
            $this->_html .= $this->l('ATTENTION cache blowfish cannot see new category, please go to Preferences - performance and set: Use class BLOWFISH: NO') . '<br>';

        $this->_html .= '
			 <label>' . $this->l('Language:') . '</label>
        <div class="margin-form">
					        ';

        $languages = Language::getLanguages();
        $this->_html .= '<SELECT name="PSM_I_lang">';
        foreach ($languages as $language) {
            $this->_html .= '<OPTION value="' . $language['id_lang'] . '"';
            if (Configuration::get('PSM_I_lang') == $language['id_lang'])
                $this->_html .= ' SELECTED ';
            $this->_html .= '>' . $language['iso_code'] . '</OPTION>';
        }
        $this->_html .= '</SELECT>';
//print 'qui'.Configuration::get('PSM_DANEA_LINK');
//print 'qui'.$zip;
        $this->_html .= '	

		</div>
		
		<label>' . $this->l('Password:') . '</label>
        <div class="margin-form">
					<input name="PSM_DANEA_COD" value=' . Tools::getValue('PSM_DANEA_COD', Configuration::get('PSM_DANEA_COD')) . '>
							<p style="clear: both">' . $this->l('(Use)') . '</p>

		</div>
			<label>' . $this->l('Link (MODA 2000):') . '</label>
        <div class="margin-form"><input name="PSM_DANEA_LINK" value=' . Tools::getValue('PSM_DANEA_LINK', Configuration::get('PSM_DANEA_LINK')) . '>
							<p style="clear: both">' . $this->l('(Use)') . '</p></div>
			
					
					
					<br /><input class="button" name="btnSubmit" value="' . $this->l('Update settings') . '" type="submit" />
			</fieldset>
		</form>';


//istructions
        $this->_html .= '

<div class="clear"></div>

		<fieldset class="width5">
			<legend><img src="../img/admin/warning.gif" />' . $this->l('Information') . '</legend>
			<br /><br />
			
			
			' . $this->l('1) 
			IMPORTANTE: Assicurarsi di aver dato i corretti permessi al modulo per il caricamento dei file (v. manuale) <br /><br />
		
			per support contattare: sites@planete-i.fr') . '
			
			
		</fieldset>
				<div class="clear"></div>';

        $this->_html .= '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post"  enctype="multipart/form-data">
			<fieldset>
			<legend><img src="' . $this->_path . 'logo.gif" />' . $this->l('Xml Upload') . '</legend>
<br>' . $this->l('Use direct connect from Moda2000 instead of this (this is only for debug mode)') . '
					<div class="clear"></div><br>

			  <label>' . $this->l('File (MODA 2000 Xml):') . '</label>
        <div class="margin-form"><input type="file" name="file" id="file" /></div>
					
					
					<br /><input class="button" name="SubmitFile" value="' . $this->l('Upload File') . '" type="submit" />
					<input class="button" name="SubmitGO" value="' . $this->l('LOAD PRODUCT FROM FILE') . '" type="submit" />

					
			</fieldset>
		</form>
		<br />';

        $this->_html .= '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post"  enctype="multipart/form-data">
			<fieldset>
			<legend><img src="' . $this->_path . 'logo.gif" />' . $this->l('FTP Configuration') . '</legend>
<br>' . $this->l('Take the zip file from the server') . '
					<div class="clear"></div><br>

			  <label>' . $this->l('Host:') . '</label>
        <div class="margin-form"><input name="PSM_DANEA_HOST" type="text" value=' . Tools::getValue('PSM_DANEA_HOST', Configuration::get('PSM_DANEA_HOST')) . ' /></div>
			 <label>' . $this->l('Username:') . '</label>
        <div class="margin-form"><input name="PSM_DANEA_USER" type="text" value=' . Tools::getValue('PSM_DANEA_USER', Configuration::get('PSM_DANEA_USER')) . ' /></div>
			<label>' . $this->l('Password:') . '</label>
        <div class="margin-form"><input name="PSM_DANEA_PSW" type="text" value=' . Tools::getValue('PSM_DANEA_PSW', Configuration::get('PSM_DANEA_PSW')) . ' /></div>
		<label>' . $this->l('URL: (site/url/)') . '</label>
        <div class="margin-form"><input name="PSM_DANEA_URL" type="text" value=' . Tools::getValue('PSM_DANEA_URL', Configuration::get('PSM_DANEA_URL')) . ' /></div>
			<label>' . $this->l('File (name.zip):') . '</label>
        <div class="margin-form"><input name="PSM_DANEA_FZIP" type="text" value=' . Tools::getValue('PSM_DANEA_FZIP', Configuration::get('PSM_DANEA_FZIP')) . ' /></div>
					
					
				<br /><input class="button" name="btnFtp" value="' . $this->l('Update FTP ZIP') . '" type="submit" />	

					
			</fieldset>
		</form>
		<br />';

        $this->_html .= '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post"  enctype="multipart/form-data">
			<fieldset>
			<legend><img src="' . $this->_path . 'logo.gif" />' . $this->l('LINK Configuration') . '</legend>
<br>' . $this->l('Configuration link') . '
					<div class="clear"></div><br>

			 <label>' . $this->l('Link (FILE.zip):') . '</label>
        <div class="margin-form"><input name="PSM_DANEA_LINK" value=' . Tools::getValue('PSM_DANEA_LINK', Configuration::get('PSM_DANEA_LINK')) . '>
							<p style="clear: both">' . $this->l('(Use)') . '</p></div>
					
				<br /><input class="button" name="copyLink" value="' . $this->l('Set LINK') . '" type="submit" />	

					
			</fieldset>
		</form>
		<br />';


        return $this->_html;
    }

//end fetcontent








    /*     * ************Read Xml File*********** */

//parse xml;
    public function _xmlgo($url) {
        $supplierID = NULL;

        $xml = simplexml_load_file($url);
//print '<br>mode: '.$xml['Mode'].'<br>';

        /*         * ************Full or Incremental*********** */


//deactivate all product
        /*
          if (substr(_PS_VERSION_,0,3)>=1.5) {
          $sql="UPDATE "._DB_PREFIX_."product_shop SET active= 0";
          Db::getInstance()->Execute($sql);
          }
          $sql="UPDATE "._DB_PREFIX_."product SET active= 0";
          Db::getInstance()->Execute($sql);
         */

        if (0) {
            if (Configuration::get('PSM_DANEA_PRESERVE_TABLES') == 0) {
                //print 'cancello tabelle';
                if (!import_deltables("E")) {
                    $this->_html .= "Error in clear tables";
                    return false;
                }
                if (!DeleteProductImages_all(_PS_PROD_IMG_DIR_, 'products', true)) {
                    $this->_html .= "Error in clear tables";
                    return false;
                }
            }
        }



        /*
          if ($xml['Mode']=='full')
          {
          //print "<br>cancella tutto";
          if (Configuration::get('PSM_DANEA_PRESERVE_TABLES')==0){
          //print 'cancello tabelle';
          if (!import_deltables("E") )
          {
          $this->_html.="Error in clear tables";
          return false;
          }
          if (!DeleteProductImages_all(_PS_PROD_IMG_DIR_,'products',true))
          {
          $this->_html.="Error in clear tables";
          return false;
          }
          }

          } elseif ($xml['Mode']!='incremental') {
          print 'Attenzione mode non supportato';


          return false;
          } //end full mode

         */
        $id_lang = Configuration::get('PSM_I_lang');

        /*         * ************prepare table: home, qty*********** */
        if (!import_preparetables(Configuration::get('PSM_I_home'), Configuration::get('PSM_I_qty'))) {
            $this->_html .= "Error in prepare tables";
            return false;
        }

//************deleting products****************//
        if ($xml->DeletedProducts->Product)
            foreach ($xml->DeletedProducts->Product as $DELproducts) {
                //print '<br><br><br>prodotto n.'.$DELproducts->Code;

                if (!import_deleteproduct($DELproducts->Code)) {
                    $this->_html .= "Error in delete product:" . $DELproducts->Code;
                    return false;
                }
            }//end foreach

            
//************end deleting products***************//		


        /*         * ************cycle new products*********** */



        if (1)
            foreach ($xml->articoli as $products) {
                /* 		
                  print '1';

                  print '<br>Name.'.$products->Code;
                  print '<br>Price:'.$products->NetPrice1;

                 */

                /*                 * ***********NOW I have to plan variables********** */
                /*                 * ************************************************* */
                /*                 * **********and to fill empty fields*************** */
                if (!$Myproduct = import_convertArray($products)) {
                    $this->_html .= "Error in convert variables";
                    return false;
                }

                /* 		print '<br>';
                  print_r ($Myproduct);
                  print '<br>';
                  $attr_default=1;
                  print '<br><br><br>prodotto n.'.$Myproduct['InternalID'];
                  print '<br>Albero:'.$Myproduct['categories'];

                  print '<br>Name.'.$Myproduct['code'];
                  print '<br>Price:'.$Myproduct['manufacturer'];
                 */


                /*                 * ************manufacturer*********** */
                if ($Myproduct['manufacturer']) {
                    if ($manufID = import_insertmanufacturer_ie($Myproduct['manufacturer'], $id_lang)) {
                        $Myproduct['id_manufacturer'] = $manufID;
                    } else {
                        $this->_html .= "Error in manufacturers: " . $Myproduct['manufacturer'];
                        return false;
                    }
                }
                /*                 * ************tag**********NOT IN DANEA
                  if (isset($products->Tag) AND !$tagID==import_insertag_ie($products->Tag)) {
                  $this->_html.="Error in manufacturers";
                  return false;
                  }* */


                /*                 * ************supplier*********** */
                /*                 * **************** */



                if ($Myproduct['supplier']) {
                    if ($supplierID = import_insertsupplier_ie($Myproduct['supplier'], $id_lang)) {
                        $Myproduct['id_supplier'] = $supplierID;
                    } else {
                        $this->_html .= "Error in supplier: " . $Myproduct['supplier'];
                        return false;
                    }
                }

                // verifying product exists
                if (isset($Myproduct['code']) AND $prodID = import_insertproduct_ie($Myproduct['code'], $Myproduct, $id_lang)) {


                    $updated = 0;
                } else {
                    // update if exist 
                    if (!$prodID = import_updateproduct($Myproduct, $id_lang)) {
                        $this->_html .= "Error in update products: " . $Myproduct['reference'];
                        return false;
                    }
                    $updated = 1;
                }

                //***********product_category************//
                //NON C'E' BISOGNO, PERCHE' I PRODOTTI VENGONO AGGIUNTI NELLA CATEGORIA SERVIZIO
//                if (!import_insertproduct_category_ie($Myproduct['categories'], $prodID, $id_lang)) {
//                    $this->_html .= "Error in product in category: " . $Myproduct['categories'] . " prod: " . $products->Code;
//                    return false;
//                }


                if ($supplierID = import_amazon($Myproduct, $prodID, $id_lang)) {
                    
                } else {
                    $this->_html .= "Error in Amazon: " . $prodID;
                    return false;
                }


                if ($supplierID = import_insertsupplier_ie($Myproduct, $prodID, $id_lang)) {
                    
                } else {
                    $this->_html .= "Error in supplier: " . $prodID;
                    return false;
                }
//************insert images**********//
                if (Configuration::get('PSM_DANEA_PRESERVE_IMAGES') == true AND $updated == 1) {
                    //print '<br>NOT UPDATE img'.$updated;
                } else {
                    if (Configuration::get('PSM_DANEA_CONVERTIMAGE') == false) {
                        if (!import_insertproduct_images_no($Myproduct, $prodID, $id_lang)) {
                            $this->_html .= "Error in images in products: " . $Myproduct['reference'] . " img: " . $Myproduct['imagefile'];
                            return false;
                        }
                    } else {
                        if (!import_insertproduct_images($Myproduct, $prodID, $id_lang)) {
                            $this->_html .= "Error in images in products: " . $Myproduct['reference'] . " img: " . $Myproduct['imagefile'];
                            return false;
                        }
                    }
                }
                /* ADDED FOR VARIANT */
                $i = 0;
                $tot_quantity = 0;
                for ($i = 1; $i <= 30; $i++) {
                    $tgv = 'tg' . $i;
                    $gcv = 'giacenza_x0020_tg' . $i;
                    $pzv = 'prezzo_x0020_vendita_x0020_tg' . $i;
                    $brc = 'barcode_esterno' . $i;
                    //aggiunto per gli sconti:
                    $pzv = 0;

                    if (strlen($products->$tgv) < 1){
                        continue;
                    }

                    $tg[$i] = $products->$tgv;
                    $gc[$i] = $products->$gcv;
                    $pz[$i] = $products->$pzv;
                    $bc[$i] = $products->$brc;

                    if ($i == 1){
                        $attr_default = "1";
                    }
                    else{
                        $attr_default = "NULL";
                    }

                    //print '<br>'.$i.' - '.$tg[$i].' - '.$gc[$i].' - '.$pz[$i].' -R '.$Myproduct['reference'];
                    insert_variant($tg[$i], NULL, $gc[$i], $Myproduct, $attr_default, $id_lang, $bc[$i]);
                    $tot_quantity += intval($gc[$i]);
                }
                
                if($tot_quantity){
                    //salviamo la quantita totale
                    $sql_upd_stock_available = "UPDATE `" . _DB_PREFIX_ . "stock_available` SET quantity=$tot_quantity WHERE id_product=$prodID and id_product_attribute=0";
                    Db::getInstance()->Execute($sql_upd_stock_available);
                }


                /* END VARIANT */
            } //end foreach
//***************************************//
//*******end insert new products*********//
//***************************************//
//*******update existing products********//
        if ($xml->UpdatedProducts->Product)
            foreach ($xml->UpdatedProducts->Product as $products) {
                $attr_default = "1";

                //print_r ($products);
//print '<br><br><br>prodotto n.'.$products->InternalID;
                /*                 * ***********NOW I have to plan variables********** */
                /*                 * ************************************************* */
                /*                 * **********and to fill empty fields*************** */
                if (!$Myproduct = import_convertArray($products)) {
                    $this->_html .= "Error in convert variables";
                    return false;
                }

                /*                 * ************manufacturer*********** */
                if ($Myproduct['manufacturer']) {
                    if ($manufID = import_insertmanufacturer_ie($Myproduct['manufacturer'])) {
                        $Myproduct['id_manufacturer'] = $manufID;
                    } else {
                        $this->_html .= "Error in manufacturers: " . $Myproduct['manufacturer'];
                        return false;
                    }
                }


                if ($supplierID = import_amazon($Myproduct, $prodID, $id_lang)) {
                    
                } else {
                    $this->_html .= "Error in Amazon: " . $prodID;
                    return false;
                }



                /*                 * ************supplier*********** */
                /*                 * **************** */
                /*                 * **************** */
                /**/
                if ($Myproduct['supplier'] AND ! $supplierID = import_insertsupplier_ie($Myproduct['supplier'])) {
                    $this->_html .= "Error in supplier: " . $Myproduct['supplier'];
                    return false;
                } else {
                    $Myproduct['id_supplier'] = $supplierID;
                }

                if (isset($Myproduct['code']) AND $prodID = import_insertproduct_ie($Myproduct['code'], $Myproduct, $id_lang)) {
                    
                } else {
                    if (!$prodID = import_updateproduct($Myproduct, $id_lang)) {
                        $this->_html .= "Error in update products: " . $Myproduct['reference'];
                        return false;
                    }
                } //end update product if not exist
                //***********product_category************//
                ////NON C'E' BISOGNO, PERCHE' I PRODOTTI VENGONO AGGIUNTI NELLA CATEGORIA SERVIZIO
//                if (!import_insertproduct_category_ie($Myproduct['categories'], $prodID, $id_lang)) {
//                    $this->_html .= "Error in product in category: " . $Myproduct['categories'] . " prod: " . $products->Code;
//                    return false;
//                }



                /*                 * ****************UPDATE ATTRIBUTES*************** */
//$sql="DELETE FROM "._DB_PREFIX_."product_attribute WHERE id_product=$prodID";
//Db::getInstance()->Execute($sql); 
//print '<br>varianti';
                /* ADDED FOR VARIANT */
                foreach ($products->Variant as $ProductVar) {
                    //$variante=(string)$ProductVar->Size.'-'.(string)$ProductVar->Color;
                    $variant_Size = (string) $ProductVar->Size;
                    $variant_Color = (string) $ProductVar->Color;

                    insert_variant($variant_Size, $variant_Color, (string) $ProductVar->AvailableQty, $Myproduct, $attr_default, $id_lang, 0);
                    $attr_default = "NULL";
                }

//************insert images**********//
                if (Configuration::get('PSM_DANEA_PRESERVE_IMAGES') == true) {
                    //print '<br>NOT UPDATE img'.$updated;
                } else {

                    if (Configuration::get('PSM_DANEA_CONVERTIMAGE') == false) {
                        if (!import_insertproduct_images_no($Myproduct, $prodID, $id_lang)) {
                            $this->_html .= "Error in images in products: " . $Myproduct['reference'] . " img: " . $Myproduct['imagefile'];
                            return false;
                        }
                    } else {
                        if (!import_insertproduct_images($Myproduct, $prodID, $id_lang)) {
                            $this->_html .= "Error in images in products: " . $Myproduct['reference'] . " img: " . $Myproduct['imagefile'];
                            return false;
                        }
                    }
                }

                //print '<br>'.$Myproduct['id_product'];	
            }//end foreach update product

            
//*******end update existing products*****//
        //print htmlspecialchars($xml_level1);	


        return $this->_html;
    }

//end _xmlgo
}

?>
