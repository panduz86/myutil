<?php


class Product extends ProductCore
{
	
	/** @var int Flag per sapere se la tassa di consumo e' attiva o no */
	public $tassa_di_consumo = false;
	
	public static $importo_tassa_nicotina = 0.385;
	
	public function __construct($id_product = null, $full = false, $id_lang = null, $id_shop = null, Context $context = null)
	{
		self::$definition['fields']['tassa_di_consumo'] = array('type' => self::TYPE_BOOL, 'validate' => 'isBool');
		parent::__construct($id_product, $full, $id_lang, $id_shop, $context);
	}
	
	public function addCombinationEntity($wholesale_price, $price, $weight, $unit_impact, $ecotax, $quantity,
			$id_images, $reference, $id_supplier, $ean13, $default, $location = null, $upc = null, $minimal_quantity = 1,
			array $id_shop_list = array(), $available_date = null, $tassa_di_consumo_comb = false, $ml_flacone_comb = 0.00,
			$ml_nicotina_comb = 0.00, $codice_articolo = null)
	{
		$id_product_attribute = $this->addAttribute(
				$price, $weight, $unit_impact, $ecotax, $id_images,
				$reference, $ean13, $default, $location, $upc, $minimal_quantity, $id_shop_list, $available_date,
				$tassa_di_consumo_comb, $ml_flacone_comb, $ml_nicotina_comb, $codice_articolo);
		$this->addSupplierReference($id_supplier, $id_product_attribute);
		$result = ObjectModel::updateMultishopTable('Combination', array(
				'wholesale_price' => (float)$wholesale_price,
		), 'a.id_product_attribute = '.(int)$id_product_attribute);
	
		if (!$id_product_attribute || !$result) {
			return false;
		}
	
		return $id_product_attribute;
	}
	
	public function addAttribute($price, $weight, $unit_impact, $ecotax, $id_images, $reference, $ean13,
			$default, $location = null, $upc = null, $minimal_quantity = 1, array $id_shop_list = array(), $available_date = null,
			$tassa_di_consumo_comb = false, $ml_flacone_comb = 0.00, $ml_nicotina_comb = 0.00, $codice_articolo = null)
	{
		if (!$this->id) {
			return;
		}
	
		$price = str_replace(',', '.', $price);
		$weight = str_replace(',', '.', $weight);
	
		$combination = new Combination();
		$combination->id_product = (int)$this->id;
		$combination->price = (float)$price;
		$combination->ecotax = (float)$ecotax;
		$combination->quantity = 0;
		$combination->weight = (float)$weight;
		$combination->unit_price_impact = (float)$unit_impact;
		$combination->reference = pSQL($reference);
		$combination->location = pSQL($location);
		$combination->ean13 = pSQL($ean13);
		$combination->upc = pSQL($upc);
		$combination->default_on = (int)$default;
		$combination->minimal_quantity = (int)$minimal_quantity;
		$combination->available_date = $available_date;
		$combination->tassa_di_consumo_comb = $tassa_di_consumo_comb;
		$combination->ml_flacone_comb = (float)$ml_flacone_comb;
		$combination->ml_nicotina_comb = (float)$ml_nicotina_comb;
		$combination->codice_articolo = pSQL($codice_articolo);
	
		if (count($id_shop_list)) {
			$combination->id_shop_list = array_unique($id_shop_list);
		}
	
		$combination->add();
	
		if (!$combination->id) {
			return false;
		}
	
		$total_quantity = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
			SELECT SUM(quantity) as quantity
			FROM '._DB_PREFIX_.'stock_available
			WHERE id_product = '.(int)$this->id.'
			AND id_product_attribute <> 0 '
				);
	
		if (!$total_quantity) {
			Db::getInstance()->update('stock_available', array('quantity' => 0), '`id_product` = '.$this->id);
		}
	
		$id_default_attribute = Product::updateDefaultAttribute($this->id);
	
		if ($id_default_attribute) {
			$this->cache_default_attribute = $id_default_attribute;
			if (!$combination->available_date) {
				$this->setAvailableDate();
			}
		}
	
		if (!empty($id_images)) {
			$combination->setImages($id_images);
		}
	
		Tools::clearColorListCache($this->id);
	
		if (Configuration::get('PS_DEFAULT_WAREHOUSE_NEW_PRODUCT') != 0 && Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
			$warehouse_location_entity = new WarehouseProductLocation();
			$warehouse_location_entity->id_product = $this->id;
			$warehouse_location_entity->id_product_attribute = (int)$combination->id;
			$warehouse_location_entity->id_warehouse = Configuration::get('PS_DEFAULT_WAREHOUSE_NEW_PRODUCT');
			$warehouse_location_entity->location = pSQL('');
			$warehouse_location_entity->save();
		}
	
		return (int)$combination->id;
	}
	
	public function updateProductAttribute($id_product_attribute, $wholesale_price, $price, $weight, $unit, $ecotax,
			$id_images, $reference, $id_supplier = null, $ean13, $default, $location = null, $upc = null, $minimal_quantity, $available_date,
			$tassa_di_consumo_comb = false, $ml_flacone_comb = 0.00, $ml_nicotina_comb = 0.00, $codice_articolo = null)
	{
		Tools::displayAsDeprecated();
	
		$return = $this->updateAttribute(
				$id_product_attribute, $wholesale_price, $price, $weight, $unit, $ecotax,
				$id_images, $reference, $ean13, $default, $location = null, $upc = null, $minimal_quantity, $available_date,
				$tassa_di_consumo_comb, $ml_flacone_comb, $ml_nicotina_comb, $codice_articolo
				);
		$this->addSupplierReference($id_supplier, $id_product_attribute);
	
		return $return;
	}
	
	public function updateAttribute($id_product_attribute, $wholesale_price, $price, $weight, $unit, $ecotax,
			$id_images, $reference, $ean13, $default, $location = null, $upc = null, $minimal_quantity = null, $available_date = null,
			$update_all_fields = true, array $id_shop_list = array(),
			$tassa_di_consumo_comb = false, $ml_flacone_comb = 0.00, $ml_nicotina_comb = 0.00, $codice_articolo = null)
	{
		$combination = new Combination($id_product_attribute);
	
		
		if (!$update_all_fields) {
			$combination->setFieldsToUpdate(array(
					'price' => !is_null($price),
					'wholesale_price' => !is_null($wholesale_price),
					'ecotax' => !is_null($ecotax),
					'weight' => !is_null($weight),
					'unit_price_impact' => !is_null($unit),
					'default_on' => !is_null($default),
					'minimal_quantity' => !is_null($minimal_quantity),
					'available_date' => !is_null($available_date),
			));
		}
	
		$price = str_replace(',', '.', $price);
		$weight = str_replace(',', '.', $weight);
	
		$combination->price = (float)$price;
		$combination->wholesale_price = (float)$wholesale_price;
		$combination->ecotax = (float)$ecotax;
		$combination->weight = (float)$weight;
		$combination->unit_price_impact = (float)$unit;
		$combination->reference = pSQL($reference);
		$combination->location = pSQL($location);
		$combination->ean13 = pSQL($ean13);
		$combination->upc = pSQL($upc);
		$combination->default_on = (int)$default;
		$combination->minimal_quantity = (int)$minimal_quantity;
		$combination->available_date = $available_date ? pSQL($available_date) : '0000-00-00';
	
		$combination->tassa_di_consumo_comb = $tassa_di_consumo_comb;
		$combination->ml_flacone_comb = (float)$ml_flacone_comb;
		$combination->ml_nicotina_comb = (float)$ml_nicotina_comb;
		$combination->codice_articolo = pSQL($codice_articolo);
		
		//print_r($combination);
		
		
		if (count($id_shop_list)) {
			$combination->id_shop_list = $id_shop_list;
		}
	
		$combination->save();
	
		if (is_array($id_images) && count($id_images)) {
			$combination->setImages($id_images);
		}
	
		$id_default_attribute = (int)Product::updateDefaultAttribute($this->id);
		if ($id_default_attribute) {
			$this->cache_default_attribute = $id_default_attribute;
		}
	
		// Sync stock Reference, EAN13 and UPC for this attribute
		if (Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') && StockAvailable::dependsOnStock($this->id, Context::getContext()->shop->id)) {
			Db::getInstance()->update('stock', array(
					'reference' => pSQL($reference),
					'ean13'     => pSQL($ean13),
					'upc'        => pSQL($upc),
			), 'id_product = '.$this->id.' AND id_product_attribute = '.(int)$id_product_attribute);
		}
	
		Hook::exec('actionProductAttributeUpdate', array('id_product_attribute' => (int)$id_product_attribute));
		Tools::clearColorListCache($this->id);
	
		return true;
	}
	
	
	public static function getTassaDiConsumo($id_product, $id_product_attribute, $quantity, $id_address = null, $id_state = null)
	{
		
		$prod_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `tassa_di_consumo`
        														FROM `"._DB_PREFIX_."product`
        														WHERE `id_product` = ".(int)$id_product);
		
		$prod_attributes = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `id_product_attribute`, `tassa_di_consumo_comb`, `ml_flacone_comb`, `ml_nicotina_comb`
	        													FROM `"._DB_PREFIX_."product_attribute`
	        													WHERE `id_product_attribute` = ".(int)$id_product_attribute);
		 
		if($id_address != null && AddressCore::getZoneById($id_address))
		{
			$zone_id = AddressCore::getZoneById($id_address);
			
			$zone_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select *
	        													FROM `"._DB_PREFIX_."zone`
	        													WHERE `id_zone` = ".(int)$zone_id);
			
			if($zone_info && $zone_info['tassa_di_consumo'] != "1")
			{
				return 0.00;
			}
			
		}
		
		if($id_state != null && StateCore::getZoneById($id_state))
		{
			$zone_id = AddressCore::getZoneById($id_address);
				
			$zone_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select *
	        														FROM `"._DB_PREFIX_."zone`
	        														WHERE `id_zone` = ".(int)$zone_id);
				
			if($zone_info && $zone_info['tassa_di_consumo'] != "1")
			{
				return 0.00;
			}
				
		}
		 
		if($prod_info['tassa_di_consumo'] == "1" && $prod_attributes['tassa_di_consumo_comb'] == "1")
		{
			return ($quantity*Product::$importo_tassa_nicotina*((float)$prod_attributes['ml_flacone_comb'])*((float)$prod_attributes['ml_nicotina_comb']))/100;
		}
		else
		{
			return 0.00;
		}
		 
	}
	
	public static function priceCalculation($id_shop, $id_product, $id_product_attribute, $id_country, $id_state, $zipcode, $id_currency,
			$id_group, $quantity, $use_tax, $decimals, $only_reduc, $use_reduc, $with_ecotax, &$specific_price, $use_group_reduction,
			$id_customer = 0, $use_customer_price = true, $id_cart = 0, $real_quantity = 0)
	{
		static $address = null;
		static $context = null;
	
		if ($address === null) {
			$address = new Address();
		}
	
		if ($context == null) {
			$context = Context::getContext()->cloneContext();
		}
	
		if ($id_shop !== null && $context->shop->id != (int)$id_shop) {
			$context->shop = new Shop((int)$id_shop);
		}
	
		if (!$use_customer_price) {
			$id_customer = 0;
		}
	
		if ($id_product_attribute === null) {
			$id_product_attribute = Product::getDefaultAttribute($id_product);
		}
	
		$cache_id = (int)$id_product.'-'.(int)$id_shop.'-'.(int)$id_currency.'-'.(int)$id_country.'-'.$id_state.'-'.$zipcode.'-'.(int)$id_group.
		'-'.(int)$quantity.'-'.(int)$id_product_attribute.
		'-'.(int)$with_ecotax.'-'.(int)$id_customer.'-'.(int)$use_group_reduction.'-'.(int)$id_cart.'-'.(int)$real_quantity.
		'-'.($only_reduc?'1':'0').'-'.($use_reduc?'1':'0').'-'.($use_tax?'1':'0').'-'.(int)$decimals;
	
		// reference parameter is filled before any returns
		$specific_price = SpecificPrice::getSpecificPrice(
				(int)$id_product,
				$id_shop,
				$id_currency,
				$id_country,
				$id_group,
				$quantity,
				$id_product_attribute,
				$id_customer,
				$id_cart,
				$real_quantity
				);
	
		if (isset(self::$_prices[$cache_id])) {
			/* Affect reference before returning cache */
			if (isset($specific_price['price']) && $specific_price['price'] > 0) {
				$specific_price['price'] = self::$_prices[$cache_id];
			}
			return self::$_prices[$cache_id];
		}
	
		// fetch price & attribute price
		$cache_id_2 = $id_product.'-'.$id_shop;
		if (!isset(self::$_pricesLevel2[$cache_id_2])) {
			$sql = new DbQuery();
			$sql->select('product_shop.`price`, product_shop.`ecotax`');
			$sql->from('product', 'p');
			$sql->innerJoin('product_shop', 'product_shop', '(product_shop.id_product=p.id_product AND product_shop.id_shop = '.(int)$id_shop.')');
			$sql->where('p.`id_product` = '.(int)$id_product);
			if (Combination::isFeatureActive()) {
				$sql->select('IFNULL(product_attribute_shop.id_product_attribute,0) id_product_attribute, product_attribute_shop.`price` AS attribute_price, product_attribute_shop.default_on');
				$sql->leftJoin('product_attribute_shop', 'product_attribute_shop', '(product_attribute_shop.id_product = p.id_product AND product_attribute_shop.id_shop = '.(int)$id_shop.')');
			} else {
				$sql->select('0 as id_product_attribute');
			}
	
			$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
	
			if (is_array($res) && count($res)) {
				foreach ($res as $row) {
					$array_tmp = array(
							'price' => $row['price'],
							'ecotax' => $row['ecotax'],
							'attribute_price' => (isset($row['attribute_price']) ? $row['attribute_price'] : null)
					);
					self::$_pricesLevel2[$cache_id_2][(int)$row['id_product_attribute']] = $array_tmp;
	
					if (isset($row['default_on']) && $row['default_on'] == 1) {
						self::$_pricesLevel2[$cache_id_2][0] = $array_tmp;
					}
				}
			}
		}
	
		if (!isset(self::$_pricesLevel2[$cache_id_2][(int)$id_product_attribute])) {
			return;
		}
	
		$result = self::$_pricesLevel2[$cache_id_2][(int)$id_product_attribute];
	
		if (!$specific_price || $specific_price['price'] < 0) {
			$price = (float)$result['price'];
		} else {
			$price = (float)$specific_price['price'];
		}
		// convert only if the specific price is in the default currency (id_currency = 0)
		if (!$specific_price || !($specific_price['price'] >= 0 && $specific_price['id_currency'])) {
			$price = Tools::convertPrice($price, $id_currency);
			if (isset($specific_price['price']) && $specific_price['price'] >= 0) {
				$specific_price['price'] = $price;
			}
		}
	
		// Attribute price
		if (is_array($result) && (!$specific_price || !$specific_price['id_product_attribute'] || $specific_price['price'] < 0)) {
			$attribute_price = Tools::convertPrice($result['attribute_price'] !== null ? (float)$result['attribute_price'] : 0, $id_currency);
			// If you want the default combination, please use NULL value instead
			if ($id_product_attribute !== false) {
				$price += $attribute_price;
			}
		}
	
		// Tax
		$address->id_country = $id_country;
		$address->id_state = $id_state;
		$address->postcode = $zipcode;
			
		$tax_manager = TaxManagerFactory::getManager($address, Product::getIdTaxRulesGroupByIdProduct((int)$id_product, $context));
		$product_tax_calculator = $tax_manager->getTaxCalculator();
	
		// Add Tax
		if ($use_tax) {
			if($context->cart)
				$price = $product_tax_calculator->addTaxes($price + Product::getTassaDiConsumo($id_product, $id_product_attribute, 1, $context->cart->id_address_invoice));
			else
				$price = $product_tax_calculator->addTaxes($price);
		}
	
		// Eco Tax
		if (($result['ecotax'] || isset($result['attribute_ecotax'])) && $with_ecotax) {
			$ecotax = $result['ecotax'];
			if (isset($result['attribute_ecotax']) && $result['attribute_ecotax'] > 0) {
				$ecotax = $result['attribute_ecotax'];
			}
	
			if ($id_currency) {
				$ecotax = Tools::convertPrice($ecotax, $id_currency);
			}
			if ($use_tax) {
				// reinit the tax manager for ecotax handling
				$tax_manager = TaxManagerFactory::getManager(
						$address,
						(int)Configuration::get('PS_ECOTAX_TAX_RULES_GROUP_ID')
						);
				$ecotax_tax_calculator = $tax_manager->getTaxCalculator();
				$price += $ecotax_tax_calculator->addTaxes($ecotax);
			} else {
				$price += $ecotax;
			}
		}
	
		// Reduction
		$specific_price_reduction = 0;
		if (($only_reduc || $use_reduc) && $specific_price) {
			if ($specific_price['reduction_type'] == 'amount') {
				$reduction_amount = $specific_price['reduction'];
	
				if (!$specific_price['id_currency']) {
					$reduction_amount = Tools::convertPrice($reduction_amount, $id_currency);
				}
	
				$specific_price_reduction = $reduction_amount;
	
				// Adjust taxes if required
	
				if (!$use_tax && $specific_price['reduction_tax']) {
					$specific_price_reduction = $product_tax_calculator->removeTaxes($specific_price_reduction);
				}
				if ($use_tax && !$specific_price['reduction_tax']) {
					$specific_price_reduction = $product_tax_calculator->addTaxes($specific_price_reduction);
				}
			} else {
				$specific_price_reduction = $price * $specific_price['reduction'];
			}
		}
	
		if ($use_reduc) {
			$price -= $specific_price_reduction;
		}
	
		// Group reduction
		if ($use_group_reduction) {
			$reduction_from_category = GroupReduction::getValueForProduct($id_product, $id_group);
			if ($reduction_from_category !== false) {
				$group_reduction = $price * (float)$reduction_from_category;
			} else { // apply group reduction if there is no group reduction for this category
				$group_reduction = (($reduc = Group::getReductionByIdGroup($id_group)) != 0) ? ($price * $reduc / 100) : 0;
			}
	
			$price -= $group_reduction;
		}
	
		if ($only_reduc) {
			return Tools::ps_round($specific_price_reduction, $decimals);
		}
	
		$price = Tools::ps_round($price, $decimals);
	
		if ($price < 0) {
			$price = 0;
		}
	
		self::$_prices[$cache_id] = $price;
		return self::$_prices[$cache_id];
	}
}

