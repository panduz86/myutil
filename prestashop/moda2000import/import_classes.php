<?php

/* * ********* clear tables *************** */

function import_deltables($mode) {
    if ($mode == "C" OR $mode == "D" OR $mode == "E") {

        Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'product');
        Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'product_lang');
        Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'category_product');
        Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'image');
        Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'image_lang');
        Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'tag');
        Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'product_tag');
        Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'manufacturer');
        Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'manufacturer_lang');
        Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'supplier');
        Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'supplier_lang');
        Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'specific_price');



//print "tabelle svuotate";
        if ($mode == "D" OR $mode == "E") {
//svuoto immagini per update
            if (substr(_PS_VERSION_, 0, 3) >= 1.5) {
                //1.5
                Db::getInstance()->Execute('delete from ' . _DB_PREFIX_ . 'category_group where id_category >2');
                Db::getInstance()->Execute('ALTER TABLE ' . _DB_PREFIX_ . 'category_group AUTO_INCREMENT = 3');
                Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'product_shop');
                Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'product_attribute_shop');
                Db::getInstance()->Execute('delete from ' . _DB_PREFIX_ . 'category_shop where id_category >2');
                Db::getInstance()->Execute('ALTER TABLE ' . _DB_PREFIX_ . 'category_shop AUTO_INCREMENT = 3');
                Db::getInstance()->Execute('delete from ' . _DB_PREFIX_ . 'category where id_category >2');
                Db::getInstance()->Execute('ALTER TABLE ' . _DB_PREFIX_ . 'category AUTO_INCREMENT = 3');
                Db::getInstance()->Execute('delete from ' . _DB_PREFIX_ . 'category_lang where id_category >2');
                Db::getInstance()->Execute('ALTER TABLE ' . _DB_PREFIX_ . 'category_lang AUTO_INCREMENT = 3');
                Db::getInstance()->Execute('INSERT INTO ' . _DB_PREFIX_ . 'category_group (`id_category`, `id_group`) VALUES ("1", "1")');
                Db::getInstance()->Execute('INSERT INTO ' . _DB_PREFIX_ . 'category_group (`id_category`, `id_group`) VALUES ("2", "1")');
                Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'manufacturer_shop');
                Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'supplier_shop');
                Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'product_supplier');
                Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'stock_available');
                Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'image_shop');
            } else {
                Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'category_group');
                Db::getInstance()->Execute('delete from ' . _DB_PREFIX_ . 'category where id_category !=1');
                Db::getInstance()->Execute('ALTER TABLE ' . _DB_PREFIX_ . 'category AUTO_INCREMENT = 2');
                Db::getInstance()->Execute('delete from ' . _DB_PREFIX_ . 'category_lang where id_category !=1');
                Db::getInstance()->Execute('ALTER TABLE ' . _DB_PREFIX_ . 'category_lang AUTO_INCREMENT = 2');
                Db::getInstance()->Execute('INSERT INTO ' . _DB_PREFIX_ . 'category_group (`id_category`, `id_group`) VALUES ("1", "1")');
            }
        }



        if ($mode == "E") {
//svuoto attributi per update

            Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'product_attribute');
            Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'product_attribute_combination');
            Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'attribute_group');
            Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'attribute_group_lang');
            Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'attribute');
            Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'attribute_lang');
            Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'attribute_impact');
            Db::getInstance()->Execute('truncate ' . _DB_PREFIX_ . 'product_attribute_image');
        }
    }// end if c,d,e
    return true;
}

// end deltables

/* * ****************Prepare Tables************** */
/* * *******
  Configuration::get('PSM_DANEA_USEDISCOUNT')=1 clear products in home
  $qty=1 clear quantity in all products / attribute
 * ***** */

function import_preparetables($home = NULL, $qty = NULL) {

//clean quantity
    if ($qty == '1') {
        Db::getInstance()->Execute('UPDATE `' . _DB_PREFIX_ . 'product` SET quantity =  0');
    }
    return true;
}

//end preparetables


/* * *************AMAZON************** */

function import_amazon($Myproduct, $id_product, $id_lang = 5) {

    $sql = "DELETE FROM `" . _DB_PREFIX_ . "marketplace_product_option` WHERE `id_product` ='$id_product'";
//print '<br>'.$sql;
    Db::getInstance()->Execute($sql);

    if ($Myproduct['amazon_price'] > 1) {
        $amazon_price = $Myproduct['amazon_price'];
        $sql = "INSERT INTO " . _DB_PREFIX_ . "marketplace_product_option (id_product, id_lang, disable, price) VALUES ('$id_product','" . $id_lang . "',0,'" . $amazon_price . "')";
        //print '<br>'.$sql.'<br>';
        Db::getInstance()->Execute($sql);
    }


    return true;
}

/* * ***************Manufacturer*********** */

function import_insertmanufacturer_ie($name, $id_lang = 5) {


    $qry_man = "SELECT id_manufacturer FROM " . _DB_PREFIX_ . "manufacturer WHERE name='$name' ORDER BY id_manufacturer DESC";

    $rst_manufacturer = Db::getInstance()->getRow($qry_man);
    if ($rst_manufacturer)
        $id_manufacturer = $rst_manufacturer['id_manufacturer'];

    if (!isset($id_manufacturer)) {
        if (substr(_PS_VERSION_, 0, 3) >= 1.4) {
            $insert_man = "INSERT INTO " . _DB_PREFIX_ . "manufacturer (name, date_add, date_upd, active) VALUES ('$name','" . date('Y-m-d') . "','" . date('Y-m-d') . "',1)";
            Db::getInstance()->Execute($insert_man);
            $id_manufacturer = Db::getInstance()->Insert_ID();
            $insert_man_lang = "INSERT INTO " . _DB_PREFIX_ . "manufacturer_lang (id_manufacturer, id_lang VALUES ('$id_manufacturer','" . $id_lang . "')";
            Db::getInstance()->Execute($insert_man_lang);
        } else {
            $insert_man = "INSERT INTO " . _DB_PREFIX_ . "manufacturer (name, date_add, date_upd) VALUES ('$name','" . date('Y-m-d') . "','" . date('Y-m-d') . "')";
            Db::getInstance()->Execute($insert_man);
            $id_manufacturer = Db::getInstance()->Insert_ID();
        }

        /* 1.5 */
        if (substr(_PS_VERSION_, 0, 3) >= 1.5)
            Db::getInstance()->Execute("INSERT INTO " . _DB_PREFIX_ . "manufacturer_shop (id_manufacturer,id_shop) VALUES (" . $id_manufacturer . ",'1')");
    }



    return $id_manufacturer;
}

/* * ***************Tag*********** */

function import_insertag_ie($name, $id_lang) {
    $rstTag = Db::getInstance()->getRow('SELECT id_tag FROM ' . _DB_PREFIX_ . 'tag WHERE name=' . $name . ' ORDER BY id_tag DESC');
    $id_tag = $rstTag['id_tag'];

    if (!isset($id_tag)) {

        Db::getInstance()->Execute('INSERT INTO ' . _DB_PREFIX_ . 'tag (name,id_lang) VALUES (' . $name . ',' . $id_lang . ')');
        $id_tag = Db::getInstance()->Insert_ID();
        return $id_tag;
    }

    return true;
}

/* * ***************Supplier*********** */

function import_insertsupplier_ie($name) {

    if ($supplier = Supplier::getIdByName($name)) {
        $id_supplier = intval($supplier);
    } else {
        if (substr(_PS_VERSION_, 0, 3) >= 1.4) {
            $insert_man = "INSERT INTO " . _DB_PREFIX_ . "supplier (name, date_add, date_upd, active) VALUES ('" . pSQL($name) . "','" . date('Y-m-d') . "','" . date('Y-m-d') . "',1)";
            Db::getInstance()->Execute($insert_man);
            $id_supplier = Db::getInstance()->Insert_ID();
            $insert_man_lang = "INSERT INTO " . _DB_PREFIX_ . "supplier_lang (id_supplier, id_lang VALUES ('$id_supplier','" . $id_lang . "')";
            Db::getInstance()->Execute($insert_man_lang);
        } else {
            $insert_man = "INSERT INTO " . _DB_PREFIX_ . "supplier (name, date_add, date_upd) VALUES ('" . pSQL($name) . "','" . date('Y-m-d') . "','" . date('Y-m-d') . "')";
            Db::getInstance()->Execute($insert_man);
            $id_supplier = Db::getInstance()->Insert_ID();
        }

        /* 1.5 */
        if (substr(_PS_VERSION_, 0, 3) >= 1.5)
            Db::getInstance()->Execute("INSERT INTO " . _DB_PREFIX_ . "supplier_shop (id_supplier,id_shop) VALUES (" . $id_supplier . ",'1')");
    }
    //print '<br>inserito supplier: '.$id_supplier;
    return $id_supplier;
}

/* * ************Product************ */

function import_insertproduct_ie($reference, $prod, $id_lang) {
    $sql = "SELECT id_product FROM " . _DB_PREFIX_ . "product WHERE reference='$reference' ORDER BY id_product DESC";
    $row_datasearch = Db::getInstance()->getRow($sql);
    $prodID = $row_datasearch['id_product'];

    if ($prodID) {
        return false;
    } else {
        $prodID = insertNewProduct($prod, $id_lang);
    }
    return $prodID;
}

/* * *********DeleteProduct************ */

function import_deleteproduct($reference) {
    $sql_id = "SELECT id_product FROM `" . _DB_PREFIX_ . "product` WHERE `reference` = '$reference'";
//print $sql_id;
    $id_prods = Db::getInstance()->getRow($sql_id);
    $id_prod = $id_prods['id_product'];
    $sql = "DELETE FROM `" . _DB_PREFIX_ . "product` WHERE `id_product` ='$id_prod'";
    Db::getInstance()->Execute($sql);
    $sql = "DELETE FROM `" . _DB_PREFIX_ . "product_lang` WHERE `id_product` =$id_prod";
    Db::getInstance()->Execute($sql);
    $sql = "DELETE FROM `" . _DB_PREFIX_ . "product` WHERE `id_product` =$id_prod";
    Db::getInstance()->Execute($sql);

//print $sql;


    return true;
}

//end delete product

/* * **************PRIVATE FUNCTIONS************ */

function insertNewProduct($prod, $id_lang) {

    $sql = "INSERT INTO " . _DB_PREFIX_ . "product (reference
                                                    , id_supplier
                                                    , id_manufacturer";
    
    if (substr(_PS_VERSION_, 0, 3) >= 1.4){
        $sql .= ", id_tax_rules_group";
    }
    else {
        $sql .= ", id_tax";
    }
    
    $sql .= "
            , id_category_default
            , on_sale
            , ean13
            , ecotax
            , price
            , wholesale_price
            , supplier_reference
            , weight
            , out_of_stock
            , quantity_discount
            , date_add
            , date_upd
            , quantity
            , active)

            VALUES ('" . $prod['reference'] . "'
            , '" . $prod['id_supplier'] . "'
            ,'" . $prod['id_manufacturer'] . "'
            , '" . $prod['id_tax'] . "'
            , '" . $prod['id_category_default'] . "'
            , '" . $prod['on_sale'] . "'
            , '" . $prod['ean13'] . "'
            , '" . $prod['ecotax'] . "'
            , '" . $prod['price'] . "'
            , '" . $prod['wholesale_price'] . "'
            , '" . $prod['supplier_reference'] . "'
            , '" . $prod['weight'] . "'
            , '" . $prod['out_of_stock'] . "'
            , '" . $prod['quantity_discount'] . "'
            , '" . $prod['date_add'] . "'
            , '" . $prod['date_upd'] . "'
            , '" . $prod['quantity_i'] . "'
            , '0')";
    //print '<br>'.$sql;

    Db::getInstance()->Execute($sql);
    $prod['id_product'] = Db::getInstance()->Insert_ID();
    if (substr(_PS_VERSION_, 0, 3) >= 1.5) {
        if ($prod['reduction_price'] > 0.1) {
            $sql_R = "INSERT INTO `" . _DB_PREFIX_ . "specific_price` (
                                                                    `id_product`, 
                                                                    `id_shop`, 
                                                                    `id_currency`, 
                                                                    `id_country`, 
                                                                    `id_group`, 
                                                                    `price`, 
                                                                    `from_quantity`, 
                                                                    `reduction`, 
                                                                    `reduction_type`, 
                                                                    `from`, 
                                                                    `to`) VALUES (
                                                                    '" . $prod['id_product'] . "', 
                                                                    '0', 
                                                                    '0', 
                                                                    '0', 
                                                                    '0', 
                                                                    '-1', 
                                                                    '1', 
                                                                    '" . $prod['reduction_price'] . "', 
                                                                    'amount', 
                                                                    '" . $prod['reduction_from'] . "', 
                                                                    '" . $prod['reduction_to'] . "')";
            //	print '<br>'.$sql_R;	
            Db::getInstance()->Execute($sql_R);
        }
    } elseif (substr(_PS_VERSION_, 0, 3) >= 1.4) {
        if ($prod['reduction_price'] > 0.1) {
            $sql_R = "INSERT INTO `" . _DB_PREFIX_ . "specific_price` (
                                                    `id_product`, 
                                                    `id_shop`, 
                                                    `id_currency`, 
                                                    `id_country`, 
                                                    `id_group`, 
                                                    `price`, 
                                                    `from_quantity`, 
                                                    `reduction`, 
                                                    `reduction_type`, 
                                                    `from`, 
                                                    `to`) VALUES (
                                                    '" . $prod['id_product'] . "', 
                                                    '0', 
                                                    '1', 
                                                    '0', 
                                                    '1', 
                                                    '0', 
                                                    '1', 
                                                    '" . $prod['reduction_price'] . "', 
                                                    'amount', 
                                                    '" . $prod['reduction_from'] . "', 
                                                    '" . $prod['reduction_to'] . "')";
            //	print '<br>'.$sql_R;	
            Db::getInstance()->Execute($sql_R);
        }
    } else {
        if ($prod['reduction_price'] > 0.1) {
            $sql_R = "UPDATE " . _DB_PREFIX_ . "product SET 
                                                on_sale = '" . $prod['on_sale'] . "'
                                                , reduction_price = '" . $prod['reduction_price'] . "'
                                                , reduction_percent = '" . $prod['reduction_percent'] . "'
                                                , reduction_from = '" . $prod['reduction_from'] . "'
                                                , reduction_to = '" . $prod['reduction_to'] . "'

                                        WHERE id_product='" . $prod['id_product'] . "'";

            Db::getInstance()->Execute($sql_R);
        }
    }

    /* for shops in 1.5 */
    if (substr(_PS_VERSION_, 0, 3) >= 1.5) {


        $sql_R = "INSERT INTO `" . _DB_PREFIX_ . "product_shop` (
                                                                `id_product`, 
                                                                `id_shop`, 
                                                                `id_category_default`, 
                                                                `id_tax_rules_group`, 
                                                                `on_sale`, 
                                                                `price`, 
                                                                `wholesale_price`, 
                                                                `active`, 
                                                                `available_for_order`, 
                                                                `available_date`, 
                                                                `show_price`, 
                                                                `date_add`, 
                                                                `date_upd`
                                                                ) VALUES (
                                                                '" . $prod['id_product'] . "', 
                                                                '1', 
                                                                '" . $prod['id_category_default'] . "', 
                                                                '" . $prod['id_tax'] . "', 
                                                                '" . $prod['on_sale'] . "', 
                                                                '" . $prod['price'] . "', 
                                                                '" . $prod['wholesale_price'] . "', 
                                                                '0', 
                                                                '1', 
                                                                '" . $prod['date_upd'] . "', 
                                                                '1', 
                                                                '" . $prod['date_add'] . "', 
                                                                '" . $prod['date_upd'] . "')";
        //print $sql_R;							
        Db::getInstance()->Execute($sql_R);

        $sql_R = "INSERT INTO `" . _DB_PREFIX_ . "product_supplier` (
                                                                        `id_product` 
                                                                        , id_supplier
                                                                ) VALUES ('" . $prod['id_product'] . "'
                                                                , '" . $prod['id_supplier'] . "'
                                                                )";
        //	print '<br>'.$sql_R;
        Db::getInstance()->Execute($sql_R);



        $sql_R = "INSERT INTO `" . _DB_PREFIX_ . "stock_available` (
                                                                    `id_product` 
                                                                    , id_shop
                                                                    , quantity
                                                            ) VALUES ('" . $prod['id_product'] . "'
                                                            , '1'
                                                            , '" . $prod['quantity_i'] . "'
                                                            )";
        Db::getInstance()->Execute($sql_R);
    }


    /* END for shops in 1.5 */

    $sql_lang = "INSERT INTO " . _DB_PREFIX_ . "product_lang (	id_product, 
                                                                id_lang, 
                                                                name, 
                                                                description, 
                                                                description_short,
                                                                link_rewrite,
                                                                meta_description,
                                                                meta_keywords,
                                                                meta_title,
                                                                available_now,
                                                                available_later
                                                                ) values (
                                                                                '" . $prod['id_product'] . "',
                                                                                '$id_lang', 
                                                                                '" . $prod['name'] . "',
                                                                                '" . $prod['description'] . "',
                                                                                '" . $prod['description_short'] . " - cod:" . $prod['reference'] . "',
                                                                                '" . $prod['link_rewrite'] . "',
                                                                                '" . $prod['meta_description'] . "',
                                                                                '" . $prod['meta_keywords'] . "',
                                                                                '" . $prod['meta_title'] . "',
                                                                                '" . $prod['displayed_when_in_stock'] . "',
                                                                                '" . $prod['displayed_when_in_stock'] . "'
                                                                                )";

//print $sql_lang;

    Db::getInstance()->Execute($sql_lang);

//insert in home category
//    if (Configuration::get('PSM_DANEA_USEHOME') == '1') {
//        if ($prod['home'] == 1) {
//            $cancello_category_product = Db::getInstance()->Execute("DELETE FROM " . _DB_PREFIX_ . "category_product WHERE `id_product`= " . $prod['id_product'] . " AND `id_category`=1");
//            if (substr(_PS_VERSION_, 0, 3) >= 1.5)
//                $cancello_category_product = Db::getInstance()->Execute("DELETE FROM " . _DB_PREFIX_ . "category_product WHERE `id_product`= " . $prod['id_product'] . " AND `id_category`=2");
//
//            if (substr(_PS_VERSION_, 0, 3) >= 1.5) {
//                $qry = "INSERT INTO " . _DB_PREFIX_ . "category_product (`id_category`, `id_product`, `position`) VALUES ('2', '" . $prod['id_product'] . "', '1')";
//                $insert_category_product = Db::getInstance()->Execute($qry);
//            } else {
//                $insert_category_product = Db::getInstance()->Execute("INSERT INTO " . _DB_PREFIX_ . "category_product (`id_category`, `id_product`, `position`) VALUES ('1', '" . $prod['id_product'] . "', '1')");
//            }
//        } else {
//            $cancello_category_product = Db::getInstance()->Execute("DELETE FROM " . _DB_PREFIX_ . "category_product WHERE `id_product`= " . $prod['id_product'] . " AND `id_category`=1");
//        }
//    }

    //Aggiungo il prodotto alla categoria di servizio XXX 1127
    $categoria_servizio = 1127;
    //INIZIO
    $qry = "INSERT INTO " . _DB_PREFIX_ . "category_product (`id_category`, `id_product`, `position`) VALUES ('$categoria_servizio', '" . $prod['id_product'] . "', '1')";
    Db::getInstance()->Execute($qry);

    $sqlup = "UPDATE " . _DB_PREFIX_ . "product SET  id_category_default = '$categoria_servizio' WHERE id_product='" . $prod['id_product'] . "'";
    Db::getInstance()->Execute($sqlup);
    if (substr(_PS_VERSION_, 0, 3) >= 1.5) {
        $sqlup = "UPDATE " . _DB_PREFIX_ . "product_shop SET  id_category_default = '$categoria_servizio' WHERE id_product='" . $prod['id_product'] . "'";
        Db::getInstance()->Execute($sqlup);
    }
    //FINE
    
    return $prod['id_product'];
}

//end insertProduct_ie
/* * ****************************************** */

function import_updateproduct($prod, $id_lang) {

    $sql = "SELECT id_product FROM " . _DB_PREFIX_ . "product WHERE reference='" . $prod['reference'] . "' ORDER BY id_product DESC";
    $row_datasearch = Db::getInstance()->getRow($sql);
    $prodID = $row_datasearch['id_product'];
    print '<br>' . $prodID . '--- ' . $sql . '<br>';

    $sqlup = "UPDATE " . _DB_PREFIX_ . "product SET  ";
    if (substr(_PS_VERSION_, 0, 3) >= 1.4)
        $sqlup .= "id_tax_rules_group = '" . $prod['id_tax'] . "'";
    else
        $sqlup .= "id_tax = '" . $prod['id_tax'] . "'";
    $sqlup .= ", on_sale = '" . $prod['on_sale'] . "'
									, price = '" . $prod['price'] . "'
									, wholesale_price = '" . $prod['wholesale_price'] . "'
									, out_of_stock = '" . $prod['out_of_stock'] . "'
									, quantity_discount = '" . $prod['quantity_discount'] . "'
									, date_upd = '" . $prod['date_upd'] . "'
									, quantity = '" . $prod['quantity_i'] . "'
									, weight = '" . $prod['weight'] . "'
									, id_supplier = '" . $prod['id_supplier'] . "'
									, id_manufacturer = '" . $prod['id_manufacturer'] . "'";

    if ($prod['active'] == 0)
        $sqlup .= "									, active = '" . $prod['active'] . "'";

    $sqlup .= "									, ean13 = '" . $prod['ean13'] . "'
								WHERE id_product='" . $prodID . "'";
//		print '<br>'.$sqlup;  
    Db::getInstance()->Execute($sqlup);


    /* for shops in 1.5 */
    if (substr(_PS_VERSION_, 0, 3) >= 1.5) {


        $sql_R = "UPDATE `" . _DB_PREFIX_ . "product_shop` SET
									 id_shop = '1'
									, id_tax_rules_group = '" . $prod['id_tax'] . "'
									, on_sale = '" . $prod['on_sale'] . "'
									, wholesale_price = '" . $prod['wholesale_price'] . "'
									, price = '" . $prod['price'] . "'";

        if ($prod['active'] == 0)
            $sql_R .= "									, active = '" . $prod['active'] . "'";


        $sql_R .= "									, date_upd = '" . $prod['date_upd'] . "'
								WHERE id_product='" . $prodID . "'";
//	print '<br>'.$sql_R;							
        Db::getInstance()->Execute($sql_R);

        $sql_R = "UPDATE `" . _DB_PREFIX_ . "stock_available` SET
									quantity = '" . $prod['quantity_i'] . "'
								WHERE id_product='" . $prodID . "' AND id_product_attribute=0";

        Db::getInstance()->Execute($sql_R);



        $sql_R = "DELETE FROM `" . _DB_PREFIX_ . "product_supplier` WHERE id_product='$prodID'";
        print $sql_R;
        Db::getInstance()->Execute($sql_R);

        if ($prod['active'] > 0) {
            $sql_R = "INSERT INTO `" . _DB_PREFIX_ . "product_supplier` (
																	`id_product` 
									, id_supplier
								) VALUES ('" . $prodID . "'
								, '" . $prod['id_supplier'] . "'
								)";
            print '<br>' . $sql_R;
            Db::getInstance()->Execute($sql_R);
        }
    }

    /* END for shops in 1.5 */


    $sql_del_specific = "DELETE FROM `" . _DB_PREFIX_ . "specific_price` WHERE id_product='$prodID'";
    Db::getInstance()->Execute($sql_del_specific);
    if ($prod['reduction_price'] > 0.1) {

        if (substr(_PS_VERSION_, 0, 3) >= 1.5) {
            if ($prod['reduction_price'] > 0.1) {
                $sql_R = "INSERT INTO `" . _DB_PREFIX_ . "specific_price` (
																	`id_product`, 
																	`id_shop`, 
																	`id_currency`, 
																	`id_country`, 
																	`id_group`, 
																	`price`, 
																	`from_quantity`, 
																	`reduction`, 
																	`reduction_type`, 
																	`from`, 
																	`to`) VALUES (
																			'$prodID', 
																	'0', 
																	'0', 
																	'0', 
																	'0', 
																	'-1', 
																	'1', 
																	'" . $prod['reduction_price'] . "', 
																	'amount', 
																	'" . $prod['reduction_from'] . "', 
																	'" . $prod['reduction_to'] . "')";
                //	print '<br>'.$sql_R;	
                Db::getInstance()->Execute($sql_R);
            }
        } elseif (substr(_PS_VERSION_, 0, 3) >= 1.4) {
            $sql_R = "INSERT INTO `" . _DB_PREFIX_ . "specific_price` (
																			`id_product`, 
																			`id_shop`, 
																			`id_currency`, 
																			`id_country`, 
																			`id_group`, 
																			`price`, 
																			`from_quantity`, 
																			`reduction`, 
																			`reduction_type`, 
																			`from`, 
																			`to`) VALUES (
																			'$prodID', 
																			'1', 
																			'0', 
																			'0', 
																			'1', 
																			'0', 
																			'1', 
																			'" . $prod['reduction_price'] . "', 
																			'amount', 
																			'" . $prod['reduction_from'] . "', 
																			'" . $prod['reduction_to'] . "')";

            Db::getInstance()->Execute($sql_R);
        } else {
            $sql_R = "UPDATE " . _DB_PREFIX_ . "product SET 
											on_sale = '" . $prod['on_sale'] . "'
											, reduction_price = '" . $prod['reduction_price'] . "'
											, reduction_percent = '" . $prod['reduction_percent'] . "'
											, reduction_from = '" . $prod['reduction_from'] . "'
											, reduction_to = '" . $prod['reduction_to'] . "'
										
										WHERE id_product='$prodID'";



            Db::getInstance()->Execute($sql_R);
        }
    }


    $sql_lang = "UPDATE " . _DB_PREFIX_ . "product_lang SET  	description = '" . $prod['description'] . "', 
											description_short = '" . $prod['description_short'] . " - cod:" . $prod['reference'] . "',
											name = '" . $prod['name'] . "',
											link_rewrite  = '" . $prod['link_rewrite'] . "',
											id_supplier  = '" . $prod['id_supplier'] . "',
											meta_description = '" . $prod['meta_description'] . "',
											meta_keywords = '" . $prod['meta_keywords'] . "',
											meta_title = '" . $prod['meta_title'] . "'											
									 WHERE id_product='$prodID' and id_lang='$id_lang'";
    //print $sql_lang;
    Db::getInstance()->Execute($sql_lang);
//    if (Configuration::get('PSM_DANEA_USEHOME') == '1') {
//
//        if ($prod['home'] == 1) {
//            $clear_category_product = Db::getInstance()->Execute("DELETE FROM " . _DB_PREFIX_ . "category_product WHERE `id_product`= " . $prodID . " AND `id_category`=1");
//            if (substr(_PS_VERSION_, 0, 3) >= 1.5)
//                $insert_category_product = Db::getInstance()->Execute("INSERT INTO " . _DB_PREFIX_ . "category_product (`id_category`, `id_product`, `position`) VALUES ('2', '$prodID', '1')");
//            else
//                $insert_category_product = Db::getInstance()->Execute("INSERT INTO " . _DB_PREFIX_ . "category_product (`id_category`, `id_product`, `position`) VALUES ('1', '$prodID', '1')");
//        } else {
//            $clear_category_product = Db::getInstance()->Execute("DELETE FROM " . _DB_PREFIX_ . "category_product WHERE `id_product`= " . $prodID . " AND `id_category`=1");
//        }
//    }
////pre-defined category
//    $sqlCatProd = "SELECT id_category FROM " . _DB_PREFIX_ . "category_product  WHERE id_product='$id_prod' ORDER DESC LIMIT 1";


    return $prodID;
}

/* * ****************************************** */

function import_insertproduct_category_ie($categories, $id_prod, $id_lang, $id_shop = 1) {
    //added for category change
    $sql = "DELETE FROM " . _DB_PREFIX_ . "category_product WHERE `id_product`= " . $id_prod;
    if (substr(_PS_VERSION_, 0, 3) >= 1.5)
        $sql .= " AND id_category!=2";
    else
        $sql .= " AND id_category!=1";

    Db::getInstance()->Execute($sql);

    //print "entrato".$categories;
    $categories = explode("|", $categories);
//	print_r ($categories);
//			print"<br>--<br>";
    $x = 0;
    foreach ($categories as $category) {
        $x = $x + 1;
        //print '<br>x= '.$x.'<br>';
        //print_r ($category);
        /* counter for subcategories */
        $y = $x - 1;
        if (!$y) {
            if (substr(_PS_VERSION_, 0, 3) >= 1.5) {
                $y = '2';
                $cat_ids[$y] = '2';
            } else {
                $y = '1';
                $cat_ids[$y] = '1';
            }
        }
        //print '<br>vecchia cat= '.$cat_ids[$y].'<br>';

        /* end per subcategories */
        //---if category exist if not insert

        $sqlCat = "SELECT " . _DB_PREFIX_ . "category_lang.id_category FROM " . _DB_PREFIX_ . "category_lang INNER JOIN " . _DB_PREFIX_ . "category ON " . _DB_PREFIX_ . "category_lang.id_category =" . _DB_PREFIX_ . "category.id_category WHERE " . _DB_PREFIX_ . "category_lang.name='$category' and " . _DB_PREFIX_ . "category.id_parent='" . $cat_ids[$y] . "' ORDER BY id_category DESC";
        //print$sqlCat;
        //print"<br>--<br>";

        $cats = Db::getInstance()->getRow($sqlCat);

        $id_Cat = $cats['id_category'];
        $cat_ids[$x] = $id_Cat;
        //se non c'e' la creo
        if (!$id_Cat) {
            $date = date('Y-m-d');

            /* counter for subcategories */
            $y = $x - 1;
            if (!$y) {
                if (substr(_PS_VERSION_, 0, 3) >= 1.5) {
                    $y = '2';
                    $cat_ids[$y] = '2';
                } else {
                    $y = '1';
                    $cat_ids[$y] = '1';
                }
            }
            /* end per subcategories */
            if (substr(_PS_VERSION_, 0, 3) >= 1.5)
                $lvl = $x + 1;
            else
                $lvl = $x;
            if (substr(_PS_VERSION_, 0, 3) >= 1.5)
                $sqlCatIns = "INSERT INTO " . _DB_PREFIX_ . "category (id_parent,level_depth,active,date_add,date_upd,is_root_category) VALUES ('" . $cat_ids[$y] . "','$lvl','1','$date','$date','1')";
            else
                $sqlCatIns = "INSERT INTO " . _DB_PREFIX_ . "category (id_parent,level_depth,active,date_add,date_upd) VALUES ('" . $cat_ids[$y] . "','$lvl','1','$date','$date')";
            //print $sqlCatIns;
            //print"<br>--<br>";
            Db::getInstance()->Execute($sqlCatIns);

            //id category for insert in lang
            $id_Cat = Db::getInstance()->Insert_ID();

            if (substr(_PS_VERSION_, 0, 3) >= 1.5) {
                $sqlCatIns = "INSERT INTO " . _DB_PREFIX_ . "category_shop (id_category,id_shop) VALUES ('" . $id_Cat . "','1')";
                //print $sqlCatIns;
                //print"<br>--<br>";
                Db::getInstance()->Execute($sqlCatIns);
            }

            //creo un llink_rewrite
            $link_rewrite_cat = preg_replace('/^[0-9]+\./', '', $category);
            $link_rewrite_cat = preg_replace('/[^a-zA-Z0-9]+/', '-', $link_rewrite_cat);

            $sql_cat = "INSERT INTO " . _DB_PREFIX_ . "category_lang (id_category,name,id_lang,link_rewrite) VALUES ('$id_Cat','$category','$id_lang',	'$link_rewrite_cat')";
            //print $sql_cat;
            //print"<br>--<br>";

            Db::getInstance()->Execute($sql_cat);

            if (substr(_PS_VERSION_, 0, 3) >= 1.5)
                $groups = Group::getGroups($id_lang, $id_shop);
            else
                $groups = Group::getGroups($id_lang);


            foreach ($groups as $group) {
                $sql_cat_lang = "INSERT INTO " . _DB_PREFIX_ . "category_group (`id_category`, `id_group`) VALUES ('$id_Cat', '" . $group['id_group'] . "')";
                Db::getInstance()->Execute($sql_cat_lang);
            }
            //inserisco nel gruppo
            /*
              for ($i = 1; $i <= 3; $i++) {
              $sql_cat_lang = "INSERT INTO "._DB_PREFIX_."category_group (`id_category`, `id_group`) VALUES ('$id_Cat', '$i')";
              Db::getInstance()->Execute($sql_cat_lang);
              }
             */

            $cat_ids[$x] = $id_Cat;
        }// end if $id_cat
        //insert product in categories (here I have to insert in level) 
        $sqlCatProd = "SELECT id_category FROM " . _DB_PREFIX_ . "category_product  WHERE id_product='$id_prod' AND id_category='$id_Cat'";
        //print"<br>- -<br>";
        //print $sqlCatProd;

        if (!Db::getInstance()->getRow($sqlCatProd)) {
            $sql_prodcat = "INSERT INTO " . _DB_PREFIX_ . "category_product (`id_category`, `id_product`, `position`) VALUES ('$id_Cat', '$id_prod', '1')";
            //print"<br>-prod cat-".$sql_prodcat.$id_prod."<br>";
            //print $sql_prodcat;
            Db::getInstance()->Execute($sql_prodcat);
        }
    } //end foreach
    //category default
    $sqlup = "UPDATE " . _DB_PREFIX_ . "product SET  id_category_default = '$id_Cat' WHERE id_product='$id_prod'";
    $inserisco_dati = Db::getInstance()->Execute($sqlup);
    if (substr(_PS_VERSION_, 0, 3) >= 1.5) {
        $sqlup = "UPDATE " . _DB_PREFIX_ . "product_shop SET  id_category_default = '$id_Cat' WHERE id_product='$id_prod'";
        $inserisco_dati = Db::getInstance()->Execute($sqlup);
    }

    //print "<br><br>fine";

    return true;
}

// end import_insertproduct_category_ie

/* * ***********insert images in Update************* */

function import_insertproduct_images($Myproduct, $id_prod, $id_lang) {
    //print_r($Myproduct);
    if ($Myproduct['imagefile']) {
        $image_path = dirname(__FILE__) . '/imgs/' . $Myproduct['imagefile'];
    }
    if (file_exists($image_path)) {
        $cover = 1;

        /* clear images for this product */
        $mask = _PS_PROD_IMG_DIR_ . $id_prod . "*.jpg";
        array_map("unlink", glob($mask));


        $sqlCatProd = "SELECT id_image FROM " . _DB_PREFIX_ . "image  WHERE id_product='$id_prod'";
        $imgds = Db::getInstance()->ExecuteS($sqlCatProd);
        foreach ($imgds as $imgd) {
            //print '<br>cancello -'.$imgd['id_image'];
            Db::getInstance()->ExecuteS('delete from ' . _DB_PREFIX_ . 'image where id_image =' . $imgd['id_image']);
            Db::getInstance()->ExecuteS('delete from ' . _DB_PREFIX_ . 'image_lang where id_image =' . $imgd['id_image']);

            $mask = _PS_PROD_IMG_DIR_ . $id_prod . "*.jpg";
            array_map("unlink", glob($mask));
            //print $mask;
        }
        $sql_prodcat = ("INSERT INTO " . _DB_PREFIX_ . "image (id_product, position,cover) VALUES ('$id_prod','1','$cover')");
        //print $sql_prodcat;
        Db::getInstance()->Execute($sql_prodcat);

        $id_image = Db::getInstance()->Insert_ID();

        if (substr(_PS_VERSION_, 0, 3) >= 1.5) {
            $sql_image_shop = ("INSERT INTO " . _DB_PREFIX_ . "image_shop (id_image, id_shop, cover) VALUES ('$id_image','1','$cover')");
            //print $sql_image_shop;
            Db::getInstance()->Execute($sql_image_shop);
        }

        $imgcat = $id_prod . '-' . $id_image;
        $imgname = $image_path;
        $imagesTypes = ImageType::getImagesTypes('products');

        include_once(dirname(__FILE__) . '/../../images.inc.php');
        /*         * ***********image convert************* */
        if (file_exists($imgname)) {
            foreach ($imagesTypes AS $k => $imageType) {
                $file['tmp_name'] = $imgname;
                $file['type'] = 'image/jpg';
                $newimage = _PS_IMG_DIR_ . 'p/' . $imgcat . '-' . stripslashes($imageType['name']) . '.jpg';

                if (!imageResize($imgname, $newimage, intval($imageType['width']), intval($imageType['height'])))
                    print '<br>error converting file:' . $imgname;
            }
            rename($imgname, _PS_IMG_DIR_ . 'p/' . $imgcat . '.jpg');
        } else {
            print '<br>no img file:' . $imgname;
            return false;
        }
        /*         * *********fine********** */


        $legend = $name;

        $inserisco_image_lang = Db::getInstance()->Execute("INSERT INTO " . _DB_PREFIX_ . "image_lang (id_image, id_lang, legend) VALUES 			('$id_image','$id_lang','$legend')");
    }

    return true;
}

//end insert images in Update


/* * ***********insert images in Full************* */

function import_insertproduct_images_no($Myproduct, $id_prod, $id_lang) {
    //print_r($Myproduct);
    if ($Myproduct['imagefile']) {
        $image_path = dirname(__FILE__) . '/imgs/' . $Myproduct['imagefile'];
    }
    if (file_exists($image_path)) {
        //print '<br>****convert image:'.$srv_images;
        $cover = 1;
        /* delete images before upload */
        $mask = _PS_PROD_IMG_DIR_ . $id_prod . "*.jpg";
        array_map("unlink", glob($mask));


        $sqlCatProd = "SELECT id_image FROM " . _DB_PREFIX_ . "image  WHERE id_product='$id_prod'";
        $imgds = Db::getInstance()->ExecuteS($sqlCatProd);
        foreach ($imgds as $imgd) {

            Db::getInstance()->ExecuteS('delete from ' . _DB_PREFIX_ . 'image where id_image =' . $imgd['id_image']);
            Db::getInstance()->ExecuteS('delete from ' . _DB_PREFIX_ . 'image_lang where id_image =' . $imgd['id_image']);
        }

        $sql_prodcat = ("INSERT INTO " . _DB_PREFIX_ . "image (id_product, position,cover) VALUES ('$id_prod','1','$cover')");
        //print $sql_prodcat;
        Db::getInstance()->Execute($sql_prodcat);

        $id_image = Db::getInstance()->Insert_ID();

        if (substr(_PS_VERSION_, 0, 3) >= 1.5) {
            $sql_image_shop = ("INSERT INTO " . _DB_PREFIX_ . "image_shop (id_image, id_shop, cover) VALUES ('$id_image','1','$cover')");
            //print $sql_image_shop;
            Db::getInstance()->Execute($sql_image_shop);
        }
        /*
          $stringone='http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'modules/daneaimport/img_convert.php?name='.$image_path.'&imgcat='.$id_prod.'-'.$id_image;

          //print 'ora'.$stringone;
          $a = file_get_contents($stringone);
          echo ($a);

         */
        $imgcat = $id_prod . '-' . $id_image;
        $imgname = $image_path;
        $imagesTypes = ImageType::getImagesTypes('products');
        include_once(dirname(__FILE__) . '../../../images.inc.php');

        /*         * ***********copy images************* */
        if (file_exists($imgname)) {
            rename($imgname, _PS_IMG_DIR_ . 'p/' . $imgcat . '.jpg');
        } else {
            print '<br>no img file:' . $imgname;
        }
        /*         * *********fine********** */


        $legend = $name;
        $inserisco_image_lang = Db::getInstance()->Execute("INSERT INTO " . _DB_PREFIX_ . "image_lang (id_image, id_lang, legend) VALUES 			('$id_image','$id_lang','$legend')");
    }

    return true;
}

//end insert images


/* * ***************** A T T R I B U T I ********************* */

/* * ************INSERT VARIANT************* */

function insert_variant($varSize, $varColor, $pz, $prod, $attr_default, $id_lang, $barcode = 0) {
    if (true) {
        $gp = "Taglia";

        $attribute_reference = trim($prod['reference'] . '-' . $varSize . $varColor);
        //verify if group exists
        $sql = 'SELECT * FROM ' . _DB_PREFIX_ . 'attribute_group INNER JOIN ' . _DB_PREFIX_ . 'attribute_group_lang ON ' . _DB_PREFIX_ . 'attribute_group_lang.id_attribute_group =' . _DB_PREFIX_ . 'attribute_group.id_attribute_group WHERE ' . _DB_PREFIX_ . 'attribute_group_lang.name="' . $gp . '"';
        $id_Groups = Db::getInstance()->GetRow($sql);
        $id_Group1 = $id_Groups['id_attribute_group'];
        //print '<br>'.$sql.'<br>';
        //print_r ($id_Groups);
        //print '<br>'.$id_Group1.'group trovata';
        //se non c'e' la creo
        if (!$id_Group1) {
            $sql = 'INSERT INTO ' . _DB_PREFIX_ . 'attribute_group (is_color_group) VALUES ("0")';
            //print '<br>'.$sql;
            $id_Group1 = Db::getInstance()->ExecuteS($sql);
            $id_Group1 = Db::getInstance()->Insert_ID();

            $sql_Group = 'INSERT INTO ' . _DB_PREFIX_ . 'attribute_group_lang (id_attribute_group,id_lang,name,public_name) VALUES (' . $id_Group1 . ',' . $id_lang . ',"' . $gp . '","' . $gp . '")';
            $inserisco_cat1 = Db::getInstance()->Execute($sql_Group);

            //print '<br>'.$sql_Group;
        } //end if !id_group

        if ($varColor) {
            $gp = "Colore"; //I have to use the italian's name!

            $sql = 'SELECT * FROM ' . _DB_PREFIX_ . 'attribute_group INNER JOIN ' . _DB_PREFIX_ . 'attribute_group_lang ON ' . _DB_PREFIX_ . 'attribute_group_lang.id_attribute_group =' . _DB_PREFIX_ . 'attribute_group.id_attribute_group WHERE ' . _DB_PREFIX_ . 'attribute_group_lang.name="' . $gp . '"';
            $id_Groups = Db::getInstance()->GetRow($sql);
            $id_Group2 = $id_Groups['id_attribute_group'];
            //print '<br>'.$sql.'<br>';
            //print_r ($id_Groups);
            //print '<br>'.$id_Group1.'group trovata';
            //se non c'e' la creo
            if (!$id_Group2) {
                $sql = 'INSERT INTO ' . _DB_PREFIX_ . 'attribute_group (is_color_group) VALUES ("0")';
                //print $sql;
                $id_Group2 = Db::getInstance()->ExecuteS($sql);
                $id_Group2 = Db::getInstance()->Insert_ID();

                $sql_Group = 'INSERT INTO ' . _DB_PREFIX_ . 'attribute_group_lang (id_attribute_group,id_lang,name,public_name) VALUES (' . $id_Group2 . ',' . $id_lang . ',"' . $gp . '","' . $gp . '")';
                //print '<br>'.$sql_Group;
                $inserisco_cat2 = Db::getInstance()->Execute($sql_Group);
            } //end if !id_group

            $sql = 'SELECT * FROM ' . _DB_PREFIX_ . 'attribute INNER JOIN ' . _DB_PREFIX_ . 'attribute_lang ON ' . _DB_PREFIX_ . 'attribute_lang.id_attribute =' . _DB_PREFIX_ . 'attribute.id_attribute WHERE ' . _DB_PREFIX_ . 'attribute_lang.name="' . $varColor . '"';
            $id_Group4 = Db::getInstance()->GetRow($sql);
            $id_Attr2 = $id_Group4['id_attribute'];
            //se non c'e' la creo
            if (!$id_Attr2) {
                $sql = 'INSERT INTO ' . _DB_PREFIX_ . 'attribute (id_attribute_group,color) VALUES (' . $id_Group2 . ',"#000000")';
                $id_Attr = Db::getInstance()->Execute($sql);
                $id_Attr2 = Db::getInstance()->Insert_ID();

                $sql_Attr = 'INSERT INTO ' . _DB_PREFIX_ . 'attribute_lang (id_attribute,id_lang,name) VALUES (' . $id_Attr2 . ',' . $id_lang . ',"' . $varColor . '")';
                $inserisco_cat2 = Db::getInstance()->Execute($sql_Attr);
            } //end if !id_group
        }


        $sql = 'SELECT * FROM ' . _DB_PREFIX_ . 'attribute INNER JOIN ' . _DB_PREFIX_ . 'attribute_lang ON ' . _DB_PREFIX_ . 'attribute_lang.id_attribute =' . _DB_PREFIX_ . 'attribute.id_attribute WHERE ' . _DB_PREFIX_ . 'attribute_lang.name="' . $varSize . '"';
        $id_Group3 = Db::getInstance()->GetRow($sql);
        $id_Attr1 = $id_Group3['id_attribute'];
        //print '<br>-'.$id_Attr.'Attributo trovato';
        //se non c'e' la creo
        if (!$id_Attr1) {
            $sql = 'INSERT INTO ' . _DB_PREFIX_ . 'attribute (id_attribute_group,color) VALUES (' . $id_Group1 . ',"#000000")';
            $id_Attr = Db::getInstance()->Execute($sql);
            $id_Attr1 = Db::getInstance()->Insert_ID();

            $sql_Attr = 'INSERT INTO ' . _DB_PREFIX_ . 'attribute_lang (id_attribute,id_lang,name) VALUES (' . $id_Attr1 . ',' . $id_lang . ',"' . $varSize . '")';
            $inserisco_cat1 = Db::getInstance()->Execute($sql_Attr);
        } //end if !id_group

        /* 			


         */
    }//end if $groupname1



    /*     * ***********if attribute exists** */
    $id_Attributo = NULL;
    $sqlSearchAttribute = "SELECT id_product_attribute,quantity FROM " . _DB_PREFIX_ . "product_attribute WHERE reference='" . $attribute_reference . "' ORDER BY id_product DESC";
    $id_Attr = Db::getInstance()->GetRow($sqlSearchAttribute);
    $id_Attributo = $id_Attr['id_product_attribute'];



//print $sqlCercaProdotto;
// ora cerco ID nel prodotto
    $sqlCercaProdotto = "SELECT id_product FROM " . _DB_PREFIX_ . "product WHERE reference='" . $prod['reference'] . "' ORDER BY id_product DESC";
    $id_Attr = Db::getInstance()->getRow($sqlCercaProdotto);
    $id_ProducT = $id_Attr['id_product'];


    //now I create this
    if (!$id_Attributo) {



//print $sqlCercaProdotto;
        //se non c'e' la creo
        if ($id_ProducT) {


            $sql_ProdAttr = "INSERT INTO  `" . _DB_PREFIX_ . "product_attribute` (
            `id_product` ,
            `reference` ,
            `supplier_reference` ,
            `location` ,
            `ean13` ,
            `wholesale_price` ,
            `price` ,
            `ecotax` ,
            `quantity` ,
            `weight` ,
            `default_on`
            )
            VALUES (
             '$id_ProducT', '$attribute_reference' , NULL , NULL , '$barcode' ,  '0.000000',  '0',  '0.00',  '$pz',  '0',  $attr_default
            )";
            
            Db::getInstance()->Execute($sql_ProdAttr);
            $id_ProdAttr = Db::getInstance()->Insert_ID();

            /* for shops in 1.5 */
            if (substr(_PS_VERSION_, 0, 3) >= 1.5) {


                $sql_R = "INSERT INTO `" . _DB_PREFIX_ . "product_attribute_shop` (
                                                                                `id_product`,																	
                                                                                `id_product_attribute`, 
                                                                                `id_shop`, 
                                                                                `price`, 
                                                                                `wholesale_price`, 
                                                                                `default_on`
                                                                                ) VALUES (
                                                                                '$id_ProducT',
                                                                                '" . $id_ProdAttr . "', 
                                                                                '1', 
                                                                                '0', 
                                                                                '0', 
                                                                                " . $attr_default . ")";
                //print $sql_R;							
                Db::getInstance()->Execute($sql_R);


                $sqlCercaProdotto = "SELECT id_stock_available FROM " . _DB_PREFIX_ . "stock_available	WHERE id_product_attribute='$id_ProdAttr' and id_product='$id_ProducT'";

                //print "<br>".$sqlCercaProdotto;

                $id_Attr_Stock = Db::getInstance()->getRow($sqlCercaProdotto);
                $id_product_attribute_stock = $id_Attr_Stock['id_stock_available'];

                if (!$id_product_attribute_stock) {
                    $sql_insert_attrib_stock = "INSERT INTO `" . _DB_PREFIX_ . "stock_available` (id_product,id_product_attribute,quantity,id_shop,id_shop_group,out_of_stock) 
				VALUES ($id_ProducT,$id_ProdAttr,$pz,1,0,2)";
                    //print "<br>".$sql_insert_attrib_stock;
                    Db::getInstance()->Execute($sql_insert_attrib_stock);
                }
            }
            /* END for shops in 1.5 */




            //insert link  product-attribute
            $sql_Comb = "INSERT INTO  `" . _DB_PREFIX_ . "product_attribute_combination` (
                        `id_attribute` ,
                        `id_product_attribute`
                        )
                        VALUES (
                        '$id_Attr1',  '$id_ProdAttr'
                        )";

            $inserisco_cat1 = Db::getInstance()->Execute($sql_Comb);
            //print '<br>COMB:'.$sql_Comb;
            /*             * ****for the combo box**** */
            $sql_Comb = "INSERT INTO  `" . _DB_PREFIX_ . "product_attribute_combination` (
                    `id_attribute` ,
                    `id_product_attribute`
                    )
                    VALUES (
                    '$id_Attr2',  '$id_ProdAttr'
                    )";
            $inserisco_cat2 = Db::getInstance()->Execute($sql_Comb);
//print '<br>2'.$sql_Comb;
        }//end if id_product

        /*         * ********************************** */
        /*         * **here just in case of update***** */
    } else {

//print 'qty: '.$old_quantity.' - '.$quantity.'<-<br>';
        $sql_Attr = "UPDATE  `" . _DB_PREFIX_ . "product_attribute` SET  
`id_product` =  '$id_ProducT',
`reference` =  '$attribute_reference',
`supplier_reference` =  NULL,
`location` =  NULL,
`ean13` =  '$barcode',
`wholesale_price` =  '0.000000',
`price` =  '0',
`ecotax` =  '0.00',
`quantity` =  '$pz',
`weight` =  '0',
`default_on` =  $attr_default WHERE  `" . _DB_PREFIX_ . "product_attribute`.`id_product_attribute` = $id_Attributo LIMIT 1";





        Db::getInstance()->Execute($sql_Attr);
//print $sql_Attr.'<br>';


        /* for shops in 1.5 */
        if (substr(_PS_VERSION_, 0, 3) >= 1.5) {


            $sql_R = "UPDATE `" . _DB_PREFIX_ . "product_attribute_shop` SET
													`id_shop` =  '1',
													`price` =  '0',
													`wholesale_price` =  '0',
													`default_on` =  $attr_default 
													WHERE  `id_product_attribute` = $id_Attributo LIMIT 1";

            Db::getInstance()->Execute($sql_R);


            $sql_R = "UPDATE `" . _DB_PREFIX_ . "stock_available` SET
                                                                quantity = '" . $pz . "'
								WHERE id_product='" . $id_ProducT . "' AND id_product_attribute='$id_Attributo'";
            Db::getInstance()->Execute($sql_R);
        }

        /* END for shops in 1.5 */
    } //end update attribute

    return true;
}

//end insert_attrib


/* * *******************END ATTRIBUTI******************** */

/* * *******************functions from presta******************** */

function DeleteProductImages_all($dir, $type, $product = false) {
    $imageTypeS = ImageType::getImagesTypes('products');
    $toDel = scandir($dir);
    foreach ($toDel AS $d) {
        foreach ($imageTypeS AS $imageType) {
            if (preg_match('/^[0-9]+\-' . ($product ? '[0-9]+\-' : '') . $imageType['name'] . '\.jpg$/', $d) OR preg_match('/^([[:lower:]]{2})\-default\-(.*)\.jpg$/', $d) OR preg_match('/^[0-9]+\-[0-9]+\.jpg$/', $d))
                if (file_exists($dir . $d) AND is_numeric(substr($d, 0, 2))) {
                    unlink($dir . $d);
                }
        }
    }
    // delete product images using new filesystem.
    if ($product) {
        $productsImages = Image::getAllImages();
        foreach ($productsImages AS $k => $image) {
            $imageObj = new Image($image['id_image']);
            $imageObj->id_product = $image['id_product'];
            if (file_exists($dir . $imageObj->getImgFolder())) {
                $toDel = scandir($dir . $imageObj->getImgFolder());
                foreach ($toDel AS $d)
                    foreach ($type AS $imageType)
                        if (preg_match('/^[0-9]+\-' . $imageType['name'] . '\.jpg$/', $d))
                            if (file_exists($dir . $imageObj->getImgFolder() . $d))
                                unlink($dir . $imageObj->getImgFolder() . $d);
            }
        }
    }

    return true;
}

function getTaxRulesIdByRate($vat) {
    $default_country = Configuration::get('PS_COUNTRY_DEFAULT');
    $sql_tax = '
			SELECT tr.`id_tax_rules_group`
			FROM `' . _DB_PREFIX_ . 'tax` t
			LEFT JOIN `' . _DB_PREFIX_ . 'tax_rule` tr ON (t.id_tax = tr.id_tax AND tr.id_country=' . $default_country . ')
			
			WHERE t.`rate` = ' . (float) ($vat) . ' AND t.`active` = 1 ';
    $tax = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql_tax);


    return $tax ? (int) ($tax['id_tax']) : false;
}

/* * ************ P E R S O N A L I Z Z A Z I O N E * PERSONALIZATIONS************ */
include_once ('moda_classe.php');
?>