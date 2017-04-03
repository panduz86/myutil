<?php

/* * **************conversions - name array******************** */

function import_convertArray($prod) {
    Configuration::updateValue('PSM_DANEA_USEHOME', '0');

    //$categories
    $Myproducts[categories] = (string) $prod->Categoria_x0020_Descrizione;

    if ($prod->Tipologia_x0020_Descrizione)
        $Myproducts[categories] = $Myproducts[categories] . '|' . (string) $prod->Tipologia_x0020_Descrizione;


    if ((string) $prod->Outlet_x0020_Sigla == "SI")
        $Myproducts[categories] = "OUTLET" . '|' . $Myproducts[categories];



    $Myproducts[categories] = pSQL($Myproducts[categories]);
    //general
    $Myproducts[code] = pSQL((string) $prod->articolo_x0020_codice_x0020_esterno . ' ' . (string) $prod->variante);
    $Myproducts[code] = substr($Myproducts[code], 0, 32);


    $Myproducts[manufacturer] = (string) $prod->ProducerName;
    //product
    $Myproducts[imagefile] = (string) $prod->ImageFileName;
    $Myproducts[imagefile] = str_replace(' ', '_', $Myproducts[imagefile]);


    $Myproducts[reference] = $Myproducts[code];
    $Myproducts[manufacturer] = (string) $prod->Marca_x0020_Descrizione;
    $Myproducts[id_tax] = '1';
    //if (!$Myproducts[id_tax]=Tax::getTaxIdByRate((string)$prod->Vat)) $Myproducts[id_tax]='1';
    $Myproducts[id_category_default] = '1';
    $Myproducts[id_color_default] = 0;
    $Myproducts[on_sale] = 0;
    $Myproducts[ean13] = (string) $prod->Barcode;
    $Myproducts[ecotax] = (string) $prod->NetEcoFee;
    $Myproducts[wholesale_price] = (string) $prod->SupplierNetPrice;

    $Myproducts[price] = (string) $prod->prezzo_x0020_vendita_x0020_tg1 / 1.22;
//amazon

    $Myproducts['amazon_price'] = (string) $prod->prezzo3_x0020_vendita_x0020_tg1;
    if ($Myproducts['amazon_price'] > 1)
        $Myproducts[supplier] = 'amazon';
    else
        $Myproducts[supplier] = (string) $prod->codice_x0020_fornitore;



    $pzd = (string) $prod->prezzo_x0020_vendita_x0020_tg1;
    $pzl = (string) $prod->prezzo2_x0020_vendita_x0020_tg1;
    if ($pzl > $pzd) {
        $Myproducts['reduction_from'] = date('Y-m-d');
        $Myproducts['reduction_to'] = date("Y-m-d", mktime(0, 0, 0, 1, date("H"), date("Y") + 1));
        $Myproducts['reduction_price'] = abs($pzl - $pzd);
        $Myproducts['on_sale'] = 1;

//		print '<br>sconto: '.$Myproducts['reduction_price'];	
        $Myproducts[price] = $pzl / 1.22;
    } elseif ($pzd > $pzl) {
        $Myproducts['reduction_from'] = date('Y-m-d');
        $Myproducts['reduction_to'] = date("Y-m-d", mktime(0, 0, 0, 1, date("H"), date("Y") + 1));
        $Myproducts['reduction_price'] = abs($pzd - $pzl);
        $Myproducts['on_sale'] = 1;

//		print '<br>sconto: '.$Myproducts['reduction_price'];	
        $Myproducts[price] = $pzd / 1.22;
    } {
        $reduction = NULL;
    }

    $Myproducts[supplier_reference] = (string) $prod->SupplierProductCode;
    $Myproducts[weight] = (string) $prod->NetWeight;
    $Myproducts[out_of_stock] = "2";
    $Myproducts[quantity_discount] = "";
    $Myproducts[date_add] = date('Y-m-d');
    $Myproducts[date_upd] = date('Y-m-d');
    $Myproducts[quantity_i] = 1;

    $Myproducts[active] = "0";
    $i = 0;
    for ($i = 1; $i <= 30; $i++) {
        $gcv = 'giacenza_x0020_tg' . $i;

        if ((string) $prod->$gcv > 0)
            $Myproducts[active] = "1";
    }
    //product_lang
    $Myproducts[name] = substr((string) $prod->articolo, 0, 80);
    $Myproducts[description] = (string) $prod->articolo_x0020_note;
    $Myproducts[description] = pSQL($Myproducts[description]);
    //$Myproducts[description]=addslashes($Myproducts[Tipologia_x0020_Descrizione]);
    $Myproducts[description] = str_replace('\n', '<BR>', $Myproducts[description]);

    $Myproducts[description_short] = (string) $prod->Tipologia_x0020_Descrizione;
    $Myproducts[description_short] = pSQL($Myproducts[description_short]);
    $Myproducts[link_rewrite] = str_replace(" ", "_", substr($Myproducts[name], 0, 45));
    $Myproducts[link_rewrite] = preg_replace('/[^a-zA-Z0-9]+/', '-', $Myproducts[link_rewrite]);

    $Myproducts[meta_description] = (string) $prod->ProducerName . ' ' . substr((string) $description_short, 0, 60);
    $Myproducts[meta_description] = pSQL($Myproducts[meta_description]);
    $Myproducts[meta_keywords] = "";
    $Myproducts[meta_title] = substr((string) $prod->Description, 0, 120);
    $Myproducts[meta_title] = pSQL($Myproducts[meta_title]);
    $Myproducts[displayed_when_in_stock] = "";
    $Myproducts[displayed_when_in_stock] = "";


    if (0) {
        print '<br>**********<br><pre>';
        print_r($Myproducts);
        print '</pre><br><br>';
    }
    return $Myproducts;
}

//end convensions
?>