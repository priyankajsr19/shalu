<?php
/*
* 2007-2011 PrestaShop 
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 6931 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../header.php');
include(dirname(__FILE__).'/cashondelivery.php');

$cashOnDelivery = new CashOnDelivery();
if ($cart->id_customer == 0 OR $cart->id_address_delivery == 0 OR $cart->id_address_invoice == 0 OR !$cashOnDelivery->active)
	Tools::redirectLink(__PS_BASE_URI__.'order.php?step=1');
$cid = Tools::getValue('cid');
if($cid && $cid > 0)
{
	$cart->id_carrier = $cid;
	$cart->update();
}
else 
	Tools::redirectLink(__PS_BASE_URI__.'order.php?step=1');

$customer = new Customer((int)$cart->id_customer);

if (!Validate::isLoadedObject($customer))
	Tools::redirectLink(__PS_BASE_URI__.'order.php?step=1');

/* Assign cart summary info */
	$summary = $cart->getSummaryDetails();
	$customizedDatas = Product::getAllCustomizedDatas((int)($cart->id));
	
	// override customization tax rate with real tax (tax rules)
	foreach($summary['products'] AS &$productUpdate)
	{
		$productId = (int)(isset($productUpdate['id_product']) ? $productUpdate['id_product'] : $productUpdate['product_id']);
		$productAttributeId = (int)(isset($productUpdate['id_product_attribute']) ? $productUpdate['id_product_attribute'] : $productUpdate['product_attribute_id']);
	
		if (isset($customizedDatas[$productId][$productAttributeId]))
		$productUpdate['tax_rate'] = Tax::getProductTaxRate($productId, $cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
	}
	
	Product::addCustomizationPrice($summary['products'], $customizedDatas);
	
	if ($free_ship = Tools::convertPrice((float)(Configuration::get('PS_SHIPPING_FREE_PRICE')), new Currency((int)($cart->id_currency))))
	{
		$discounts = $cart->getDiscounts();
		$total_free_ship =  $free_ship - ($summary['total_products_wt'] + $summary['total_discounts']);
		foreach ($discounts as $discount)
		if ($discount['id_discount_type'] == 3 || $discount['id_discount_type'] == 4 || $discount['id_discount_type'] == 5)
		{
			$total_free_ship = 0;
			break;
		}
		$smarty->assign('free_ship', $total_free_ship);
	}
	// for compatibility with 1.2 themes
	foreach($summary['products'] AS $key => $product)
	$summary['products'][$key]['quantity'] = $product['cart_quantity'];
	
	$smarty->assign($summary);
	$address = new Address((int)($cart->id_address_delivery));
	$smarty->assign('delivery_address', $address);
	$smarty->assign(array(
				'token_cart' => Tools::getToken(false),
				'isVirtualCart' => $cart->isVirtualCart(),
				'productNumber' => $cart->nbProducts(),
				'voucherAllowed' => Configuration::get('PS_VOUCHERS'),
				'shippingCost' => $cart->getOrderTotal(true, Cart::ONLY_SHIPPING),
	            'codCharge' => COD_CHARGE,
				'shippingCostTaxExc' => $cart->getOrderTotal(false, Cart::ONLY_SHIPPING),
				'customizedDatas' => $customizedDatas,
				'CUSTOMIZE_FILE' => _CUSTOMIZE_FILE_,
				'CUSTOMIZE_TEXTFIELD' => _CUSTOMIZE_TEXTFIELD_,
				'lastProductAdded' => $cart->getLastProduct(),
				'displayVouchers' => Discount::getVouchersToCartDisplay((int)($cookie->id_lang), (isset($cookie->id_customer) ? (int)($cookie->id_customer) : 0)),
				'currencySign' => $currency->sign,
				'currencyRate' => $currency->conversion_rate,
				'currencyFormat' => $currency->format,
				'currencyBlank' => $currency->blank));

/* Validate order */
if (Tools::getValue('confirm'))
{
	$customer = new Customer((int)$cart->id_customer);
	$total = $cart->getOrderTotal(true, Cart::BOTH, false);
	$cashOnDelivery->validateOrder((int)$cart->id, _PS_OS_COD_PENDING_CONFIRMATION, $total, $cashOnDelivery->displayName, NULL, array(), NULL, false, $customer->secure_key);
	$order = new Order((int)$cashOnDelivery->currentOrder);
	Tools::redirectLink(__PS_BASE_URI__.'order-confirmation.php?key='.$customer->secure_key.'&id_cart='.(int)($cart->id).'&id_module='.(int)$cashOnDelivery->id.'&id_order='.(int)$cashOnDelivery->currentOrder);
}
else
{
	/* or ask for confirmation */ 
	$smarty->assign(array(
		'total' => $cart->getOrderTotal(true, Cart::BOTH, false),
		'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/cashondelivery/'
	));

	$smarty->assign('this_path', __PS_BASE_URI__.'modules/cashondelivery/');
	$template = 'validation.tpl';
	echo Module::display('cashondelivery', $template);
}

include(dirname(__FILE__).'/../../footer.php');