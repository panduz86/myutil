<?php
/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * @property Zone $object
 */
class AdminZonesController extends AdminZonesControllerCore
{
	public $asso_type = 'shop';

    public function renderForm()
    {
    	
    		if (!Module::isEnabled('blockspecialtax'))
    		{
    			return parent::renderForm();
    		}
    		else
    		{
    			//Form for Agents-Zones
    			$this->fields_form = array(
    					'legend' => array(
    							'title' => $this->l('Zones'),
    							'icon' => 'icon-globe'
    					),
    					'input' => array(
    							array(
    									'type' => 'text',
    									'label' => $this->l('Name'),
    									'name' => 'name',
    									'required' => true,
    									'hint' => $this->l('Zone name (e.g. Africa, West Coast, Neighboring Countries).'),
    							),
    							array(
    									'type' => 'switch',
    									'label' => $this->l('Active'),
    									'name' => 'active',
    									'required' => false,
    									'is_bool' => true,
    									'values' => array(
    											array(
    													'id' => 'active_on',
    													'value' => 1,
    													'label' => $this->l('Enabled')
    											),
    											array(
    													'id' => 'active_off',
    													'value' => 0,
    													'label' => $this->l('Disabled')
    											)
    									),
    									'hint' => $this->l('Allow or disallow shipping to this zone.')
    							),
    							array(
    									'type' => 'switch',
    									'label' => $this->l('Attiva tassa di consumo'),
    									'name' => 'tassa_di_consumo',
    									'required' => false,
    									'is_bool' => true,
    									'values' => array(
    											array(
    													'id' => 'active_on',
    													'value' => 1,
    													'label' => $this->l('Enabled')
    											),
    											array(
    													'id' => 'active_off',
    													'value' => 0,
    													'label' => $this->l('Disabled')
    											)
    									),
    									'hint' => $this->l('Attiva o disattiva la tassa di consumo per questa zona')
    							)
    					)
    			);
    			
    			if (Shop::isFeatureActive()) {
    				$this->fields_form['input'][] = array(
    						'type' => 'shop',
    						'label' => $this->l('Shop association'),
    						'name' => 'checkBoxShopAsso',
    				);
    			}
    			
    			$this->fields_form['submit'] = array(
    					'title' => $this->l('Save'),
    			);
    			
    			return AdminController::renderForm();
    		}

    }


}
