<?php
 
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
include(dirname(__FILE__).'/payu.php');


include(dirname(__FILE__).'/../../header.php');


$payu = new payu();
if (!$cookie->isLogged(true))
	Tools::redirect('authentication.php?back=order.php');
elseif (!$cart->getOrderTotal(true, Cart::BOTH))
	Tools::displayError('Error: Empty cart');

if ($cart->id_customer == 0 OR $cart->id_address_delivery == 0 OR $cart->id_address_invoice == 0 OR !$payu->active)
	Tools::redirectLink(__PS_BASE_URI__.'order.php?step=1');




// Prepare payment

$customer = new Customer((int)$cart->id_customer);

if (!Validate::isLoadedObject($customer))
	Tools::redirectLink(__PS_BASE_URI__.'order.php?step=1');

$currency = new Currency(Tools::getValue('currency_payement', false) ? Tools::getValue('currency_payement') : $cookie->id_currency);
$total = (float)($cart->getOrderTotal(true, Cart::BOTH));

/*
$payu->validateOrder((int)$cart->id, Configuration::get('PS_OS_BANKWIRE'), $total, $payu->displayName, NULL, NULL, (int)$currency->id, false, $customer->secure_key);

$order = new Order($payu->currentOrder);
//echo $payu->currentOrder;
 * 
 
*/
Tools::redirectLink(__PS_BASE_URI__.'order-confirmation.php?id_cart='.(int)$cart->id.'&id_module='.$payu->id.'&id_order='.$payu->currentOrder.'&key='.$customer->secure_key);



