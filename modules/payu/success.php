<?php

include (dirname(__FILE__) . '/../../config/config.inc.php');
include (dirname(__FILE__) . '/../../init.php');
include (dirname(__FILE__) . '/payu.php');
include (dirname(__FILE__) . '/../../header.php');

$payu = new payu();

$response = $_REQUEST;

$key = Configuration::get('PAYU_MERCHANT_ID');
$salt = Configuration::get('PAYU_SALT');
$log = Configuration::get('PAYU_LOGS');

$baseUrl = Tools::getShopDomain(true, true) . __PS_BASE_URI__;
$cart_id = $response['txnid'];
$transactionId = $response['mihpayid'];

$smarty->assign('baseUrl', $baseUrl);
$smarty->assign('$cart_id', $cart_id);
$smarty->assign('transactionId', $transactionId);

$amount = $response['amount'];
$productinfo = $response['productinfo'];
$firstname = $response['firstname'];

$email = $response['email'];

$cart = new Cart((int)$cart_id);

//check for indian transactions
$invoice_address = new Address((int)$cart->id_address_invoice);
if ($invoice_address->id_country == 110)
{
	$key='VLBB6Z';
	$salt='KQUxLUkT';
}

if ($response['status'] == 'success') {
    
    $Udf1 = $response['udf1'];
    $Udf2 = $response['udf2'];
    $Udf3 = $response['udf3'];
    $Udf4 = $response['udf4'];
    $Udf5 = $response['udf5'];
    $Udf6 = $response['udf6'];
    $Udf7 = $response['udf7'];
    $Udf8 = $response['udf8'];
    $Udf9 = $response['udf9'];
    $Udf10 = $response['udf10'];
    
    $txnid = $response['txnid'];
    $keyString = $key . '|' . $txnid . '|' . $amount . '|' . $productinfo . '|' .
             $firstname . '|' . $email . '|' . $Udf1 . '|' . $Udf2 . '|' . $Udf3 .
             '|' . $Udf4 . '|' . $Udf5 . '|' . $Udf6 . '|' . $Udf7 . '|' . $Udf8 .
             '|' . $Udf9 . '|' . $Udf10;
    
    $keyArray = explode("|", $keyString);
    $reverseKeyArray = array_reverse($keyArray);
    $reverseKeyString = implode("|", $reverseKeyArray);
    
    if ($log == 1) {
        $responseValue = str_replace("'", " ", implode(",", $response));
        $successQuery = "update ps_payu_order set payment_response='$responseValue' where id_order= " .
                 $order_id;
                ;
                Db::getInstance()->Execute($successQuery);
            }
            
    $status = $response['status'];
    $saltString = $salt . '|' . $status . '|' . $reverseKeyString;
    $sentHashString = strtolower(hash('sha512', $saltString));
    
    $currency = new Currency(Tools::getValue('currency_payement', false) ? Tools::getValue('currency_payement') : $cookie->id_currency);
    $total = (float)($cart->getOrderTotal(true, Cart::BOTH));
    
    $customer = new Customer((int)$cart->id_customer);
    
    $responseHashString = $_REQUEST['hash'];
    
    if ($sentHashString != $responseHashString) {
        
        $history = new OrderHistory();
        $history->id_order = (int) ($order_id);
        $history->changeIdOrderState(Configuration::get('PS_OS_ERROR'), 
                (int) ($order_id));
        $history->add();
        
        $smarty->display('failure.tpl');
    } else {
        // PS_OS_PREPARATION
        // PS_OS_PAYMENT
        $payu->validateOrder((int)$cart->id, _PS_OS_PREPARATION_, $total, $payu->displayName, NULL, NULL, (int)$currency->id, false, $customer->secure_key);
        $order = new Order($payu->currentOrder);
        
        /*$history = new OrderHistory();
        $history->id_order = (int) ($order_id);
        $history->changeIdOrderState(
                Configuration::get('PS_OS_PREPARATION'), 
                (int) ($order_id));
        $history->add();*/
        Tools::redirectLink(__PS_BASE_URI__.'order-confirmation.php?key='.$customer->secure_key.'&id_cart='.(int)($cart->id).'&id_module='.(int)$payu->id.'&id_order='.(int)$payu->currentOrder);
    }
        
}

