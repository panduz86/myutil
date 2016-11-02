<?php


class AdminProductsController extends AdminProductsControllerCore
{
	
	
	/**
	 * @param Product $product
	 * @throws Exception
	 * @throws SmartyException
	 */
	public function initFormInformations($product)
	{
		if (!$this->default_form_language) {
			$this->getLanguages();
		}
	
		$data = $this->createTemplate($this->tpl_form);
	
		$currency = $this->context->currency;
	
		$data->assign(array(
				'languages' => $this->_languages,
				'default_form_language' => $this->default_form_language,
				'currency' => $currency
		));
		$this->object = $product;
		//$this->display = 'edit';
		$data->assign('product_name_redirected', Product::getProductName((int)$product->id_product_redirected, null, (int)$this->context->language->id));
		/*
		 * Form for adding a virtual product like software, mp3, etc...
		 */
		$product_download = new ProductDownload();
		if ($id_product_download = $product_download->getIdFromIdProduct($this->getFieldValue($product, 'id'))) {
			$product_download = new ProductDownload($id_product_download);
		}
	
		$product->{'productDownload'} = $product_download;
	
		$product_props = array();
		// global informations
		array_push($product_props, 'reference', 'ean13', 'upc',
				'available_for_order', 'show_price', 'online_only',
				'id_manufacturer', 'tassa_di_consumo'
				);
	
		// specific / detailled information
		array_push($product_props,
				// physical product
				'width', 'height', 'weight', 'active',
				// virtual product
				'is_virtual', 'cache_default_attribute',
				// customization
				'uploadable_files', 'text_fields'
				);
		// prices
		array_push($product_props,
				'price', 'wholesale_price', 'id_tax_rules_group', 'unit_price_ratio', 'on_sale',
				'unity', 'minimum_quantity', 'additional_shipping_cost',
				'available_now', 'available_later', 'available_date'
				);
	
		if (Configuration::get('PS_USE_ECOTAX')) {
			array_push($product_props, 'ecotax');
		}
	
		foreach ($product_props as $prop) {
			$product->$prop = $this->getFieldValue($product, $prop);
		}
	
		$product->name['class'] = 'updateCurrentText';
		if (!$product->id || Configuration::get('PS_FORCE_FRIENDLY_PRODUCT')) {
			$product->name['class'] .= ' copy2friendlyUrl';
		}
	
		$images = Image::getImages($this->context->language->id, $product->id);
	
		if (is_array($images)) {
			foreach ($images as $k => $image) {
				$images[$k]['src'] = $this->context->link->getImageLink($product->link_rewrite[$this->context->language->id], $product->id.'-'.$image['id_image'], ImageType::getFormatedName('small'));
			}
			$data->assign('images', $images);
		}
		$data->assign('imagesTypes', ImageType::getImagesTypes('products'));
	
		$product->tags = Tag::getProductTags($product->id);
	
		$data->assign('product_type', (int)Tools::getValue('type_product', $product->getType()));
		$data->assign('is_in_pack', (int)Pack::isPacked($product->id));
	
		$check_product_association_ajax = false;
		if (Shop::isFeatureActive() && Shop::getContext() != Shop::CONTEXT_ALL) {
			$check_product_association_ajax = true;
		}
	
		// TinyMCE
		$iso_tiny_mce = $this->context->language->iso_code;
		$iso_tiny_mce = (file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/langs/'.$iso_tiny_mce.'.js') ? $iso_tiny_mce : 'en');
		$data->assign(array(
				'ad' => dirname($_SERVER['PHP_SELF']),
				'iso_tiny_mce' => $iso_tiny_mce,
				'check_product_association_ajax' => $check_product_association_ajax,
				'id_lang' => $this->context->language->id,
				'product' => $product,
				'token' => $this->token,
				'currency' => $currency,
				'link' => $this->context->link,
				'PS_PRODUCT_SHORT_DESC_LIMIT' => Configuration::get('PS_PRODUCT_SHORT_DESC_LIMIT') ? Configuration::get('PS_PRODUCT_SHORT_DESC_LIMIT') : 400
		));
		$data->assign($this->tpl_form_vars);
	
		$this->tpl_form_vars['product'] = $product;
		$this->tpl_form_vars['custom_form'] = $data->fetch();
	}
	
	
	/**
	 * @param Product|ObjectModel $object
	 * @param string              $table
	 */
	protected function copyFromPost(&$object, $table)
	{
		parent::copyFromPost($object, $table);
		if (get_class($object) != 'Product') {
			return;
		}
	
		/* Additional fields */
		foreach (Language::getIDs(false) as $id_lang) {
			if (isset($_POST['meta_keywords_'.$id_lang])) {
				$_POST['meta_keywords_'.$id_lang] = $this->_cleanMetaKeywords(Tools::strtolower($_POST['meta_keywords_'.$id_lang]));
				// preg_replace('/ *,? +,* /', ',', strtolower($_POST['meta_keywords_'.$id_lang]));
				$object->meta_keywords[$id_lang] = $_POST['meta_keywords_'.$id_lang];
			}
		}
		$_POST['width'] = empty($_POST['width']) ? '0' : str_replace(',', '.', $_POST['width']);
		$_POST['height'] = empty($_POST['height']) ? '0' : str_replace(',', '.', $_POST['height']);
		$_POST['depth'] = empty($_POST['depth']) ? '0' : str_replace(',', '.', $_POST['depth']);
		$_POST['weight'] = empty($_POST['weight']) ? '0' : str_replace(',', '.', $_POST['weight']);
	
		if (Tools::getIsset('unit_price') != null) {
			$object->unit_price = str_replace(',', '.', Tools::getValue('unit_price'));
		}
		if (Tools::getIsset('ecotax') != null) {
			$object->ecotax = str_replace(',', '.', Tools::getValue('ecotax'));
		}
	
		if ($this->isTabSubmitted('Informations')) {
			if ($this->checkMultishopBox('available_for_order', $this->context)) {
				$object->available_for_order = (int)Tools::getValue('available_for_order');
			}
	
			if ($this->checkMultishopBox('show_price', $this->context)) {
				$object->show_price = $object->available_for_order ? 1 : (int)Tools::getValue('show_price');
			}
	
			if ($this->checkMultishopBox('online_only', $this->context)) {
				$object->online_only = (int)Tools::getValue('online_only');
			}
			
			if ($this->checkMultishopBox('show_price', $this->context)) {
				$object->tassa_di_consumo = (int)Tools::getValue('tassa_di_consumo');
			}
			
		}
		if ($this->isTabSubmitted('Prices')) {
			$object->on_sale = (int)Tools::getValue('on_sale');
		}
	}
	

	public function renderListAttributes($product, $currency)
	{
		$this->bulk_actions = array('delete' => array('text' => $this->l('Delete selected'), 'confirm' => $this->l('Delete selected items?')));
		$this->addRowAction('edit');
		$this->addRowAction('default');
		$this->addRowAction('delete');
	
		$default_class = 'highlighted';
	
		$this->fields_list = array(
				'attributes' => array('title' => $this->l('Attribute - value pair'), 'align' => 'left'),
				'price' => array('title' => $this->l('Impact on price'), 'type' => 'price', 'align' => 'left'),
				'weight' => array('title' => $this->l('Impact on weight'), 'align' => 'left'),
				'reference' => array('title' => $this->l('Reference'), 'align' => 'left'),
				'ean13' => array('title' => $this->l('EAN-13'), 'align' => 'left'),
				'upc' => array('title' => $this->l('UPC'), 'align' => 'left')
		);
	
		if ($product->id) {
			/* Build attributes combinations */
			$combinations = $product->getAttributeCombinations($this->context->language->id);
			$groups = array();
			$comb_array = array();
			if (is_array($combinations)) {
				$combination_images = $product->getCombinationImages($this->context->language->id);
				foreach ($combinations as $k => $combination) {
					$price_to_convert = Tools::convertPrice($combination['price'], $currency);
					$price = Tools::displayPrice($price_to_convert, $currency);
	
					$comb_array[$combination['id_product_attribute']]['id_product_attribute'] = $combination['id_product_attribute'];
					$comb_array[$combination['id_product_attribute']]['attributes'][] = array($combination['group_name'], $combination['attribute_name'], $combination['id_attribute']);
					$comb_array[$combination['id_product_attribute']]['wholesale_price'] = $combination['wholesale_price'];
					$comb_array[$combination['id_product_attribute']]['price'] = $price;
					$comb_array[$combination['id_product_attribute']]['weight'] = $combination['weight'].Configuration::get('PS_WEIGHT_UNIT');
					$comb_array[$combination['id_product_attribute']]['unit_impact'] = $combination['unit_price_impact'];
					$comb_array[$combination['id_product_attribute']]['reference'] = $combination['reference'];
					$comb_array[$combination['id_product_attribute']]['ean13'] = $combination['ean13'];
					$comb_array[$combination['id_product_attribute']]['upc'] = $combination['upc'];
					$comb_array[$combination['id_product_attribute']]['id_image'] = isset($combination_images[$combination['id_product_attribute']][0]['id_image']) ? $combination_images[$combination['id_product_attribute']][0]['id_image'] : 0;
					$comb_array[$combination['id_product_attribute']]['available_date'] = strftime($combination['available_date']);
					$comb_array[$combination['id_product_attribute']]['default_on'] = $combination['default_on'];
					$comb_array[$combination['id_product_attribute']]['tassa_di_consumo_comb'] = $combination['tassa_di_consumo_comb'];
					$comb_array[$combination['id_product_attribute']]['ml_flacone_comb'] = Tools::ps_round($combination['ml_flacone_comb'],2);
					$comb_array[$combination['id_product_attribute']]['ml_nicotina_comb'] = Tools::ps_round($combination['ml_nicotina_comb'],2);
					$comb_array[$combination['id_product_attribute']]['codice_articolo'] = $combination['codice_articolo'];
					if ($combination['is_color_group']) {
						$groups[$combination['id_attribute_group']] = $combination['group_name'];
					}
				}
			}
	
			if (isset($comb_array)) {
				foreach ($comb_array as $id_product_attribute => $product_attribute) {
					$list = '';
	
					/* In order to keep the same attributes order */
					asort($product_attribute['attributes']);
	
					foreach ($product_attribute['attributes'] as $attribute) {
						$list .= $attribute[0].' - '.$attribute[1].', ';
					}
	
					$list = rtrim($list, ', ');
					$comb_array[$id_product_attribute]['image'] = $product_attribute['id_image'] ? new Image($product_attribute['id_image']) : false;
					$comb_array[$id_product_attribute]['available_date'] = $product_attribute['available_date'] != 0 ? date('Y-m-d', strtotime($product_attribute['available_date'])) : '0000-00-00';
					$comb_array[$id_product_attribute]['attributes'] = $list;
					$comb_array[$id_product_attribute]['name'] = $list;
	
					if ($product_attribute['default_on']) {
						$comb_array[$id_product_attribute]['class'] = $default_class;
					}
				}
			}
		}
	
		foreach ($this->actions_available as $action) {
			if (!in_array($action, $this->actions) && isset($this->$action) && $this->$action) {
				$this->actions[] = $action;
			}
		}
	
		$helper = new HelperList();
		$helper->identifier = 'id_product_attribute';
		$helper->table_id = 'combinations-list';
		$helper->token = $this->token;
		$helper->currentIndex = self::$currentIndex;
		$helper->no_link = true;
		$helper->simple_header = true;
		$helper->show_toolbar = false;
		$helper->shopLinkType = $this->shopLinkType;
		$helper->actions = $this->actions;
		$helper->list_skip_actions = $this->list_skip_actions;
		$helper->colorOnBackground = true;
		$helper->override_folder = $this->tpl_folder.'combination/';
	
		return $helper->generateList($comb_array, $this->fields_list);
	}
	
	
	public function processProductAttribute()
	{
		// Don't process if the combination fields have not been submitted
		if (!Combination::isFeatureActive() || !Tools::getValue('attribute_combination_list')) {
			return;
		}
	
		if (Validate::isLoadedObject($product = $this->object)) {
			if ($this->isProductFieldUpdated('attribute_price') && (!Tools::getIsset('attribute_price') || Tools::getIsset('attribute_price') == null)) {
				$this->errors[] = Tools::displayError('The price attribute is required.');
			}
			if (!Tools::getIsset('attribute_combination_list') || Tools::isEmpty(Tools::getValue('attribute_combination_list'))) {
				$this->errors[] = Tools::displayError('You must add at least one attribute.');
			}
	
			$array_checks = array(
					'reference' => 'isReference',
					'supplier_reference' => 'isReference',
					'location' => 'isReference',
					'ean13' => 'isEan13',
					'upc' => 'isUpc',
					'wholesale_price' => 'isPrice',
					'price' => 'isPrice',
					'ecotax' => 'isPrice',
					'quantity' => 'isInt',
					'weight' => 'isUnsignedFloat',
					'unit_price_impact' => 'isPrice',
					'default_on' => 'isBool',
					'minimal_quantity' => 'isUnsignedInt',
					'available_date' => 'isDateFormat',
					'tassa_di_consumo_comb' => 'isBool',
					'ml_flacone_comb' => 'isUnsignedFloat',
					'ml_nicotina_comb' => 'isUnsignedFloat',
					'codice_articolo' => 'isReference',
			);
			foreach ($array_checks as $property => $check) {
				if (Tools::getValue('attribute_'.$property) !== false && !call_user_func(array('Validate', $check), Tools::getValue('attribute_'.$property))) {
					$this->errors[] = sprintf(Tools::displayError('Field %s is not valid'), $property);
				}
			}
	
			if (!count($this->errors)) {
				if (!isset($_POST['attribute_wholesale_price'])) {
					$_POST['attribute_wholesale_price'] = 0;
				}
				if (!isset($_POST['attribute_price_impact'])) {
					$_POST['attribute_price_impact'] = 0;
				}
				if (!isset($_POST['attribute_weight_impact'])) {
					$_POST['attribute_weight_impact'] = 0;
				}
				if (!isset($_POST['attribute_ecotax'])) {
					$_POST['attribute_ecotax'] = 0;
				}
				if (Tools::getValue('attribute_default')) {
					$product->deleteDefaultAttributes();
				}
				if (!isset($_POST['attribute_tassa_di_consumo_comb'])) {
					$_POST['attribute_tassa_di_consumo_comb'] = 0;
				}
	
				// Change existing one
				if (($id_product_attribute = (int)Tools::getValue('id_product_attribute')) || ($id_product_attribute = $product->productAttributeExists(Tools::getValue('attribute_combination_list'), false, null, true, true))) {
					if ($this->tabAccess['edit'] === '1') {
						if ($this->isProductFieldUpdated('available_date_attribute') && (Tools::getValue('available_date_attribute') != '' &&!Validate::isDateFormat(Tools::getValue('available_date_attribute')))) {
							$this->errors[] = Tools::displayError('Invalid date format.');
						} else {
							$product->updateAttribute((int)$id_product_attribute,
									$this->isProductFieldUpdated('attribute_wholesale_price') ? Tools::getValue('attribute_wholesale_price') : null,
									$this->isProductFieldUpdated('attribute_price_impact') ? Tools::getValue('attribute_price') * Tools::getValue('attribute_price_impact') : null,
									$this->isProductFieldUpdated('attribute_weight_impact') ? Tools::getValue('attribute_weight') * Tools::getValue('attribute_weight_impact') : null,
									$this->isProductFieldUpdated('attribute_unit_impact') ? Tools::getValue('attribute_unity') * Tools::getValue('attribute_unit_impact') : null,
									$this->isProductFieldUpdated('attribute_ecotax') ? Tools::getValue('attribute_ecotax') : null,
									Tools::getValue('id_image_attr'),
									Tools::getValue('attribute_reference'),
									Tools::getValue('attribute_ean13'),
									$this->isProductFieldUpdated('attribute_default') ? Tools::getValue('attribute_default') : null,
									Tools::getValue('attribute_location'),
									Tools::getValue('attribute_upc'),
									$this->isProductFieldUpdated('attribute_minimal_quantity') ? Tools::getValue('attribute_minimal_quantity') : null,
									$this->isProductFieldUpdated('available_date_attribute') ? Tools::getValue('available_date_attribute') : null,
									false,
									array(),
									Tools::getValue('attribute_tassa_di_consumo_comb'),
									Tools::getValue('attribute_ml_flacone_comb'),
									Tools::getValue('attribute_ml_nicotina_comb'),
									Tools::getValue('attribute_codice_articolo')
									);
							StockAvailable::setProductDependsOnStock((int)$product->id, $product->depends_on_stock, null, (int)$id_product_attribute);
							StockAvailable::setProductOutOfStock((int)$product->id, $product->out_of_stock, null, (int)$id_product_attribute);
						}
					} else {
						$this->errors[] = Tools::displayError('You do not have permission to add this.');
					}
				}
				// Add new
				else {
					if ($this->tabAccess['add'] === '1') {
						if ($product->productAttributeExists(Tools::getValue('attribute_combination_list'))) {
							$this->errors[] = Tools::displayError('This combination already exists.');
						} else {
							$id_product_attribute = $product->addCombinationEntity(
									Tools::getValue('attribute_wholesale_price'),
									Tools::getValue('attribute_price') * Tools::getValue('attribute_price_impact'),
									Tools::getValue('attribute_weight') * Tools::getValue('attribute_weight_impact'),
									Tools::getValue('attribute_unity') * Tools::getValue('attribute_unit_impact'),
									Tools::getValue('attribute_ecotax'),
									0,
									Tools::getValue('id_image_attr'),
									Tools::getValue('attribute_reference'),
									null,
									Tools::getValue('attribute_ean13'),
									Tools::getValue('attribute_default'),
									Tools::getValue('attribute_location'),
									Tools::getValue('attribute_upc'),
									Tools::getValue('attribute_minimal_quantity'),
									array(),
									Tools::getValue('available_date_attribute'),
									Tools::getValue('attribute_tassa_di_consumo_comb'),
									Tools::getValue('attribute_ml_flacone_comb'),
									Tools::getValue('attribute_ml_nicotina_comb'),
									Tools::getValue('attribute_codice_articolo')
									);
							StockAvailable::setProductDependsOnStock((int)$product->id, $product->depends_on_stock, null, (int)$id_product_attribute);
							StockAvailable::setProductOutOfStock((int)$product->id, $product->out_of_stock, null, (int)$id_product_attribute);
						}
					} else {
						$this->errors[] = Tools::displayError('You do not have permission to').'<hr>'.Tools::displayError('edit here.');
					}
				}
				if (!count($this->errors)) {
					$combination = new Combination((int)$id_product_attribute);
					$combination->setAttributes(Tools::getValue('attribute_combination_list'));
	
					// images could be deleted before
					$id_images = Tools::getValue('id_image_attr');
					if (!empty($id_images)) {
						$combination->setImages($id_images);
					}
	
					$product->checkDefaultAttributes();
					if (Tools::getValue('attribute_default')) {
						Product::updateDefaultAttribute((int)$product->id);
						if (isset($id_product_attribute)) {
							$product->cache_default_attribute = (int)$id_product_attribute;
						}
	
						if ($available_date = Tools::getValue('available_date_attribute')) {
							$product->setAvailableDate($available_date);
						} else {
							$product->setAvailableDate();
						}
					}
				}
			}
		}
	}
	
	public function initFormCombinations($obj)
	{
		return $this->initFormAttributes($obj);
	}
	
	public function initFormAttributes($product)
	{
		$data = $this->createTemplate($this->tpl_form);
		if (!Combination::isFeatureActive()) {
			$this->displayWarning($this->l('This feature has been disabled. ').
					' <a href="index.php?tab=AdminPerformance&token='.Tools::getAdminTokenLite('AdminPerformance').'#featuresDetachables">'.$this->l('Performances').'</a>');
		} elseif (Validate::isLoadedObject($product)) {
			if ($this->product_exists_in_shop) {
				if ($product->is_virtual) {
					$data->assign('product', $product);
					$this->displayWarning($this->l('A virtual product cannot have combinations.'));
				} else {
					$attribute_js = array();
					$attributes = Attribute::getAttributes($this->context->language->id, true);
					foreach ($attributes as $k => $attribute) {
						$attribute_js[$attribute['id_attribute_group']][$attribute['id_attribute']] = $attribute['name'];
						natsort($attribute_js[$attribute['id_attribute_group']]);
					}
	
					$currency = $this->context->currency;
	
					$data->assign('attributeJs', $attribute_js);
					$data->assign('attributes_groups', AttributeGroup::getAttributesGroups($this->context->language->id));
	
					$data->assign('currency', $currency);
	
					$images = Image::getImages($this->context->language->id, $product->id);
	
					$data->assign('tax_exclude_option', Tax::excludeTaxeOption());
					$data->assign('ps_weight_unit', Configuration::get('PS_WEIGHT_UNIT'));
	
					$data->assign('ps_use_ecotax', Configuration::get('PS_USE_ECOTAX'));
					$data->assign('field_value_unity', $this->getFieldValue($product, 'unity'));
	
					$data->assign('reasons', $reasons = StockMvtReason::getStockMvtReasons($this->context->language->id));
					$data->assign('ps_stock_mvt_reason_default', $ps_stock_mvt_reason_default = Configuration::get('PS_STOCK_MVT_REASON_DEFAULT'));
					$data->assign('minimal_quantity', $this->getFieldValue($product, 'minimal_quantity') ? $this->getFieldValue($product, 'minimal_quantity') : 1);
					$data->assign('available_date', ($this->getFieldValue($product, 'available_date') != 0) ? stripslashes(htmlentities($this->getFieldValue($product, 'available_date'), $this->context->language->id)) : '0000-00-00');
	
					$i = 0;
					$type = ImageType::getByNameNType('%', 'products', 'height');
					if (isset($type['name'])) {
						$data->assign('imageType', $type['name']);
					} else {
						$data->assign('imageType', ImageType::getFormatedName('small'));
					}
					$data->assign('imageWidth', (isset($image_type['width']) ? (int)($image_type['width']) : 64) + 25);
					foreach ($images as $k => $image) {
						$images[$k]['obj'] = new Image($image['id_image']);
						++$i;
					}
					$data->assign('images', $images);
	
					$data->assign($this->tpl_form_vars);
					$data->assign(array(
							'list' => $this->renderListAttributes($product, $currency),
							'product' => $product,
							'id_category' => $product->getDefaultCategory(),
							'token_generator' => Tools::getAdminTokenLite('AdminAttributeGenerator'),
							'combination_exists' => (Shop::isFeatureActive() && (Shop::getContextShopGroup()->share_stock) && count(AttributeGroup::getAttributesGroups($this->context->language->id)) > 0 && $product->hasAttributes())
					));
				}
			} else {
				$this->displayWarning($this->l('You must save the product in this shop before adding combinations.'));
			}
		} else {
			$data->assign('product', $product);
			$this->displayWarning($this->l('You must save this product before adding combinations.'));
		}
	
		$this->tpl_form_vars['custom_form'] = $data->fetch();
	}
	
}

