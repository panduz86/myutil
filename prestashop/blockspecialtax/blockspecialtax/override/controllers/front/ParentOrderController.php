<?php


class ParentOrderController extends ParentOrderControllerCore
{
	
	protected function _assignSummaryInformations()
	{
		$summary = $this->context->cart->getSummaryDetails();
		$customizedDatas = Product::getAllCustomizedDatas($this->context->cart->id);
	
		// override customization tax rate with real tax (tax rules)
		if ($customizedDatas) {
			foreach ($summary['products'] as &$productUpdate) {
				$productId = (int)isset($productUpdate['id_product']) ? $productUpdate['id_product'] : $productUpdate['product_id'];
				$productAttributeId = (int)isset($productUpdate['id_product_attribute']) ? $productUpdate['id_product_attribute'] : $productUpdate['product_attribute_id'];
	
				if (isset($customizedDatas[$productId][$productAttributeId])) {
					$productUpdate['tax_rate'] = Tax::getProductTaxRate($productId, $this->context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
				}
			}
	
			Product::addCustomizationPrice($summary['products'], $customizedDatas);
		}
	
		$tassa_di_consumo_totale = 0.0;
	
		$cart_product_context = Context::getContext()->cloneContext();
		foreach ($summary['products'] as $key => &$product) {
			$product['quantity'] = $product['cart_quantity'];// for compatibility with 1.2 themes
	
			if ($cart_product_context->shop->id != $product['id_shop']) {
				$cart_product_context->shop = new Shop((int)$product['id_shop']);
			}
			$product['price_without_specific_price'] = Product::getPriceStatic(
					$product['id_product'],
					!Product::getTaxCalculationMethod(),
					$product['id_product_attribute'],
					6,
					null,
					false,
					false,
					1,
					false,
					null,
					null,
					null,
					$null,
					true,
					true,
					$cart_product_context);
	
			if (Product::getTaxCalculationMethod()) {
				$product['is_discounted'] = Tools::ps_round($product['price_without_specific_price'], _PS_PRICE_COMPUTE_PRECISION_) != Tools::ps_round($product['price'], _PS_PRICE_COMPUTE_PRECISION_);
			} else {
				$product['is_discounted'] = Tools::ps_round($product['price_without_specific_price'], _PS_PRICE_COMPUTE_PRECISION_) != Tools::ps_round($product['price_wt'], _PS_PRICE_COMPUTE_PRECISION_);
			}
	
			$tassa_di_consumo_totale += Product::getTassaDiConsumo($product['id_product'], $product['id_product_attribute'], $product['cart_quantity'], $this->context->cart->id_address_invoice);
		}
	
		// Get available cart rules and unset the cart rules already in the cart
		$available_cart_rules = CartRule::getCustomerCartRules($this->context->language->id, (isset($this->context->customer->id) ? $this->context->customer->id : 0), true, true, true, $this->context->cart, false, true);
		$cart_cart_rules = $this->context->cart->getCartRules();
		foreach ($available_cart_rules as $key => $available_cart_rule) {
			foreach ($cart_cart_rules as $cart_cart_rule) {
				if ($available_cart_rule['id_cart_rule'] == $cart_cart_rule['id_cart_rule']) {
					unset($available_cart_rules[$key]);
					continue 2;
				}
			}
		}
	
		$show_option_allow_separate_package = (!$this->context->cart->isAllProductsInStock(true) && Configuration::get('PS_SHIP_WHEN_AVAILABLE'));
		$advanced_payment_api = (bool)Configuration::get('PS_ADVANCED_PAYMENT_API');
	
		$this->context->smarty->assign($summary);
		$this->context->smarty->assign(array(
				'token_cart' => Tools::getToken(false),
				'isLogged' => $this->isLogged,
				'isVirtualCart' => $this->context->cart->isVirtualCart(),
				'productNumber' => $this->context->cart->nbProducts(),
				'voucherAllowed' => CartRule::isFeatureActive(),
				'shippingCost' => $this->context->cart->getOrderTotal(true, Cart::ONLY_SHIPPING),
				'shippingCostTaxExc' => $this->context->cart->getOrderTotal(false, Cart::ONLY_SHIPPING),
				'customizedDatas' => $customizedDatas,
				'CUSTOMIZE_FILE' => Product::CUSTOMIZE_FILE,
				'CUSTOMIZE_TEXTFIELD' => Product::CUSTOMIZE_TEXTFIELD,
				'lastProductAdded' => $this->context->cart->getLastProduct(),
				'displayVouchers' => $available_cart_rules,
				'show_option_allow_separate_package' => $show_option_allow_separate_package,
				'smallSize' => Image::getSize(ImageType::getFormatedName('small')),
				'advanced_payment_api' => $advanced_payment_api,
				'tassa_di_consumo' => $tassa_di_consumo_totale
	
		));
	
		$this->context->smarty->assign(array(
				'HOOK_SHOPPING_CART' => Hook::exec('displayShoppingCartFooter', $summary),
				'HOOK_SHOPPING_CART_EXTRA' => Hook::exec('displayShoppingCart', $summary)
		));
	}
	
}