<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class blockspecialtax extends Module
{
    public function __construct()
    {
        $this->name = 'blockspecialtax';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'kamalab.com';
        $this->need_instance = 0;

        parent::__construct();
		
        $this->displayName = $this->l('Special tax');
        $this->description = $this->l('Permette di definire la tassa di consumo sulle sigarette elettroniche');
    }
	public function install() {
		if (! parent::install () || ! $this->installOverrideTplFiles ()) {
			return FALSE;
		}
		
		if (! Db::getInstance ()->Execute ( "
      		ALTER TABLE `" . _DB_PREFIX_ . "product`
						ADD COLUMN tassa_di_consumo tinyint(1) NOT NULL DEFAULT '0' AFTER pack_stock_type
        		" )) {
			return FALSE;
		}
		
		if (! Db::getInstance ()->Execute ( "
      		ALTER TABLE `" . _DB_PREFIX_ . "product_attribute`
						ADD COLUMN tassa_di_consumo_comb tinyint(1) NOT NULL DEFAULT '0' AFTER available_date,
						ADD COLUMN ml_flacone_comb decimal(20,6) NOT NULL DEFAULT '0.00' AFTER tassa_di_consumo_comb,
						ADD COLUMN ml_nicotina_comb decimal(20,6) NOT NULL DEFAULT '0.00' AFTER ml_flacone_comb,
						ADD COLUMN codice_articolo varchar(32) AFTER ml_nicotina_comb
        		" )) {
			return FALSE;
		}
		
		if (! Db::getInstance ()->Execute ( "
      		ALTER TABLE `" . _DB_PREFIX_ . "orders`
						ADD COLUMN total_tassa_di_consumo decimal(20,6) NOT NULL DEFAULT '0.00' AFTER total_shipping_tax_excl
        		" )) {
			return FALSE;
		}
		
		if (! Db::getInstance ()->Execute ( "
      		ALTER TABLE `" . _DB_PREFIX_ . "zone`
						ADD COLUMN tassa_di_consumo tinyint(1) NOT NULL DEFAULT '0' AFTER active
        		" )) {
			return FALSE;
		}
		
		return TRUE;
	}

    public function uninstall()
    {
        $return = TRUE;
        if (!parent::uninstall() || !$this->unInstallOverrideTplFiles()) {
            return FALSE;
        }
        
        if(!Db::getInstance()->Execute('
      		ALTER TABLE `' . _DB_PREFIX_ . 'product`
						DROP COLUMN tassa_di_consumo
        		'))
        {
        	return FALSE;
        }
        
        if(!Db::getInstance()->Execute('
      		ALTER TABLE `' . _DB_PREFIX_ . 'product_attribute`
        		DROP COLUMN tassa_di_consumo_comb,
        		DROP COLUMN ml_flacone_comb,
        		DROP COLUMN ml_nicotina_comb,
        		DROP COLUMN codice_articolo
        		'))
        {
        	return FALSE;
        }
        
        if(!Db::getInstance()->Execute('
      		ALTER TABLE `' . _DB_PREFIX_ . 'orders`
						DROP COLUMN total_tassa_di_consumo
        		'))
        {
        	return FALSE;
        }
        
        if(!Db::getInstance()->Execute('
      		ALTER TABLE `' . _DB_PREFIX_ . 'zone`
						DROP  COLUMN tassa_di_consumo
        		'))
        {
        	return FALSE;
        }

        return $return;
    }

    protected function dirToArray($dir) {
        $result = array();

        $cdir = scandir($dir);
        foreach ($cdir as $value) {
            if (!in_array($value,array(".",".."))) {
                if (is_dir($dir . DS . $value)) {
                    $result[$value] = $this->dirToArray($dir . DS . $value);
                } else {
                    $ext = pathinfo($value, PATHINFO_EXTENSION);
                    if ($ext == 'tpl') {
                        $result[] = $value;
                    }
                }
            }
        }

        return $result;
    }

    protected function arrayToPath($files, &$result, $str_key = NULL) {
        foreach ($files as $key => $value) {
            if (is_array($value)) {
                $this->arrayToPath($files[$key], $result, $str_key . DS. $key);
            } else {
                $result[] = $str_key . DS. $value;
            }
        }

        return $result;
    }

    protected function recurse_copy($src,$dst) {
    	$dir = opendir($src);
    	@mkdir($dst);
    	while(false !== ( $file = readdir($dir)) ) {
    		if (( $file != '.' ) && ( $file != '..' )) {
    			if ( is_dir($src . '/' . $file) ) {
    				$this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
    			}
    			else {
    				copy($src . '/' . $file,$dst . '/' . $file);
    			}
    		}
    	}
    	closedir($dir);
    }

    protected function installOverrideTplFiles()
    {
        $module_override_dir = dirname(__FILE__) . '/override/controllers/admin/templates';
        $override_dir = dirname(__FILE__) . '/../../override/controllers/admin/templates';
        
        $this->recurse_copy($module_override_dir, $override_dir);

        return TRUE;
    }

    protected function unInstallOverrideTplFiles()
    {
        $module_override_dir = dirname(__FILE__) . '/override/controllers/admin/templates';
        $override_dir = dirname(__FILE__) . '/../../override/controllers/admin/templates';
        $files = $this->dirToArray($module_override_dir);

        $files_path = array();
        $files_path = $this->arrayToPath($files, $files_path);

        foreach ($files_path as $filepath) {
            if (file_exists($override_dir . $filepath) && !unlink($override_dir . $filepath)) {
                $this->_errors[] = sprintf($this->l('File `%s` can not be removed'), $override_dir . $filepath);
                return FALSE;
            }
        }

        return TRUE;
    }
    

}
