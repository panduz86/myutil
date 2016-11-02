<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class blockagentzone extends Module
{
    public function __construct()
    {
        $this->name = 'blockagentzone';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'kamalab.com';
        $this->need_instance = 0;

        parent::__construct();
		
        $this->displayName = $this->l('Agent zone');
        $this->description = $this->l('Permette di definire agenti per zona');
    }

    public function install()
    {
        if (!parent::install()) {
            return FALSE;
        }
        
				if(!Db::getInstance()->Execute('
      		ALTER TABLE `' . _DB_PREFIX_ . 'zone`
						ADD COLUMN name_agente VARCHAR(100) NULL AFTER active
        		'))
				{
					return FALSE;
				}
				
				if(!Db::getInstance()->Execute('
      		ALTER TABLE `' . _DB_PREFIX_ . 'zone`
						ADD COLUMN email_agente VARCHAR(100) NULL AFTER name_agente
        		'))
				{
					return FALSE;
				}

        return TRUE;
    }

    public function uninstall()
    {
        $return = TRUE;
        if (!parent::uninstall()) {
            return FALSE;
        }
        
        if(!Db::getInstance()->Execute('
      		ALTER TABLE `' . _DB_PREFIX_ . 'zone`
						DROP  COLUMN name_agente
        		'))
        {
        	return FALSE;
        }
        
        if(!Db::getInstance()->Execute('
      		ALTER TABLE `' . _DB_PREFIX_ . 'zone`
						DROP  COLUMN email_agente
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

    protected function copy_directory($source, $destination)
    {
        if (is_dir($source)) {
            if (!is_dir($destination)) {
                mkdir($destination);
            }

            $directory = dir($source);
            while (FALSE !== ($readdirectory = $directory->read())) {
                if ($readdirectory == '.' || $readdirectory == '..') {
                    continue;
                }

                $PathDir = $source . '/' . $readdirectory;
                if (is_dir($PathDir)) {
                    self::copy_directory($PathDir, $destination . '/' . $readdirectory);
                    continue;
                }

                if (file_exists($destination . '/' . $readdirectory)) {
                    $this->_errors[] = sprintf($this->l('File `%s` is already exists, please rename it and try again'), $destination . '/' . $readdirectory);
                    return false;
                }
                copy($PathDir, $destination . '/' . $readdirectory);
            }

            $directory->close();
        } else {

            if (file_exists($destination)) {
                $this->_errors[] = sprintf($this->l('File `%s` is already exists, please rename it and try again'), $destination);
                return false;
            }
            copy($source, $destination);
        }
    }

    protected function installOverrideTplFiles()
    {
        $module_override_dir = dirname(__FILE__) . '/override/controllers/admin/templates';
        $override_dir = dirname(__FILE__) . '/../../override/controllers/admin/templates';
        $this->copy_directory($module_override_dir, $override_dir);

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

    public function getContent() {
        $redirect = $this->context->link->getAdminLink('AdminZones');
        header('Location: ' . $redirect);
        exit;
    }
}
