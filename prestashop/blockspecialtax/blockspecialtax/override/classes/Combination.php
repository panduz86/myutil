<?php


class Combination extends CombinationCore
{
	public $tassa_di_consumo_comb;
	public $ml_flacone_comb;
	public $ml_nicotina_comb;
	public $codice_articolo;
	
	public static $definition = array(
			'table' => 'product_attribute',
			'primary' => 'id_product_attribute',
			'fields' => array(
					'id_product' =>        array('type' => self::TYPE_INT, 'shop' => 'both', 'validate' => 'isUnsignedId', 'required' => true),
					'location' =>            array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 64),
					'ean13' =>                array('type' => self::TYPE_STRING, 'validate' => 'isEan13', 'size' => 13),
					'upc' =>                array('type' => self::TYPE_STRING, 'validate' => 'isUpc', 'size' => 12),
					'quantity' =>            array('type' => self::TYPE_INT, 'validate' => 'isInt', 'size' => 10),
					'reference' =>            array('type' => self::TYPE_STRING, 'size' => 32),
					'supplier_reference' => array('type' => self::TYPE_STRING, 'size' => 32),
	
					/* Shop fields */
					'wholesale_price' =>    array('type' => self::TYPE_FLOAT, 'shop' => true, 'validate' => 'isPrice', 'size' => 27),
					'price' =>                array('type' => self::TYPE_FLOAT, 'shop' => true, 'validate' => 'isNegativePrice', 'size' => 20),
					'ecotax' =>            array('type' => self::TYPE_FLOAT, 'shop' => true, 'validate' => 'isPrice', 'size' => 20),
					'weight' =>            array('type' => self::TYPE_FLOAT, 'shop' => true, 'validate' => 'isFloat'),
					'unit_price_impact' =>    array('type' => self::TYPE_FLOAT, 'shop' => true, 'validate' => 'isNegativePrice', 'size' => 20),
					'minimal_quantity' =>    array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isUnsignedId', 'required' => true),
					'default_on' =>        array('type' => self::TYPE_BOOL, 'allow_null' => true, 'shop' => true, 'validate' => 'isBool'),
					'available_date' =>    array('type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDateFormat'),
					'tassa_di_consumo_comb' =>    array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
					'ml_flacone_comb' =>    array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
					'ml_nicotina_comb' =>    array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
					'codice_articolo' =>     array('type' => self::TYPE_STRING, 'size' => 32),
			),
	);
	
}