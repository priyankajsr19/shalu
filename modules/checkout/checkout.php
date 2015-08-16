<?php

class checkout extends PaymentModule {

    private $_html = '';
    private $_postErrors = array();

    public function __construct() {
        $this->name = 'checkout';
        $this->displayName = '2Checkout Payments';
        $this->tab = 'payments_gateways';
        $this->version = 0.7;

        $config = Configuration::getMultiple(array('CHECKOUT_SID', 'CHECKOUT_SECRET', 'CHECKOUT_CURRENCIES'));

        if (isset($config['CHECKOUT_SID']))
            $this->SID = $config['CHECKOUT_SID'];
        if (isset($config['CHECKOUT_SECRET']))
            $this->SECRET = $config['CHECKOUT_SECRET'];
        if (isset($config['CHECKOUT_CURRENCIES']))
            $this->currencies = $config['CHECKOUT_CURRENCIES'];

        parent::__construct();

        /* The parent construct is required for translations */
        $this->page = basename(__FILE__, '.php');
        $this->description = $this->l('Accept payments with 2Checkout');

        if (!isset($this->SID) OR !isset($this->currencies))
            $this->warning = $this->l('your 2Checkout vendor account number must be configured in order to use this module correctly');
        if (!Configuration::get('CHECKOUT_CURRENCIES')) {
            $currencies = Currency::getCurrencies();
            $authorized_currencies = array();
            foreach ($currencies as $currency)
                $authorized_currencies[] = $currency['id_currency'];
            Configuration::updateValue('CHECKOUT_CURRENCIES', implode(',', $authorized_currencies));
        }
    }

    function install() {
        //Call PaymentModule default install function
        parent::install();

        //Create Payment Hooks
        $this->registerHook('payment');
        $this->registerHook('paymentReturn');

        //Create Valid Currencies
        $currencies = Currency::getCurrencies();
        $authorized_currencies = array();
        foreach ($currencies as $currency)
            $authorized_currencies[] = $currency['id_currency'];
        Configuration::updateValue('CHECKOUT_CURRENCIES', implode(',', $authorized_currencies));
    }

    function uninstall() {
        Configuration::deleteByName('CHECKOUT_SID');
        Configuration::deleteByName('CHECKOUT_SECRET');
        Configuration::deleteByName('CHECKOUT_CURRENCIES');
        parent::uninstall();
    }

    function getContent() {
        $this->_html = '<h2>' . $this->displayName . '</h2>';

        if (!empty($_POST)) {
            $this->_postValidation();
            if (!sizeof($this->_postErrors))
                $this->_postProcess();
            else
                foreach ($this->_postErrors AS $err)
                    $this->_html .= "<div class='alert error'>{$err}</div>";
        }
        else {
            $this->_html .= "<br />";
        }

        $this->_displaycheckout();
        $this->_displayForm();

        return $this->_html;
    }

    function execPayment($cart) {
        global $cart;
        global $smarty;
        $invoice_address = new Address((int) $cart->id_address_invoice);
        
        if ($invoice_address->id_country == 110)
            return;
        
        $curr_currency = CurrencyCore::getCurrency($cart->id_currency);
        if( (int)$curr_currency['paypal_support'] === 1)
            return;
        
        $delivery = new Address(intval($cart->id_address_delivery));
        $invoice = new Address(intval($cart->id_address_invoice));
        $customer = new Customer(intval($cart->id_customer));

        global $cookie, $smarty;

        //Verify currencies and display payment form

        $currencies = Currency::getCurrencies();
        $authorized_currencies = array_flip(explode(',', $this->currencies));
        $currencies_used = array();
        foreach ($currencies as $key => $currency)
            if (isset($authorized_currencies[$currency['id_currency']]))
                $currencies_used[] = $currencies[$key];

        $smarty->assign('currencies_used', $currencies_used);

        $products = $cart->getProducts();
        foreach ($products as $key => $product) {
            $products[$key]['name'] = str_replace('"', '\'', $product['name']);
            $products[$key]['name'] = htmlentities(utf8_decode($product['name']));
        }

        $CheckoutUrl = 'https://www.2checkout.com/checkout/spurchase';
        $x_receipt_link_url = 'http://' . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__ . 'modules/checkout/validation.php';
        $sid = Configuration::get('CHECKOUT_SID');
        $total = number_format($cart->getOrderTotal(true, 3), 0, '.', '');
        $cart_order_id = $cart->id;
        $email = $customer->email;
        $secure_key = $customer->secure_key;

        $demo = "Y"; // Change to "Y" for demo mode
        $outside_state = "XX"; // This will pre-select Outside USA and Canada, if state does not exist
        // Invoice Parameters
        $card_holder_name = $invoice->firstname . ' ' . $invoice->lastname;
        $street_address = $invoice->address1;
        $street_address2 = $invoice->address2;
        $phone = $invoice->phone_mobile;
        $city = $invoice->city;
        $state = (Validate::isLoadedObject($invoice) AND $invoice->id_state) ? new State(intval($invoice->id_state)) : false;
        $zip = $invoice->postcode;
        $country = $invoice->country;

        // Shipping Parameters
        $ship_name = $delivery->firstname . ' ' . $invoice->lastname;
        $ship_street_address = $delivery->address1;
        $ship_street_address2 = $delivery->address2;
        $ship_city = $delivery->city;
        $ship_state = (Validate::isLoadedObject($delivery) AND $delivery->id_state) ? new State(intval($delivery->id_state)) : false;
        $ship_zip = $delivery->postcode;
        $ship_country = $delivery->country;

        if ($cart->id_currency != 2) {
            $total = Tools::convertPrice($total, $cart->id_currency, false);
            $this_currency = CurrencyCore::getCurrency($cart->id_currency);
            $curr_conversion_msg = "<p>Dear Customer, we do not accept payments in <b>{$this_currency['name']}</b>, we will process the equivalent amount of <b>". Tools::displayPrice($total,2)."</b> in USD(United States Dollar).</p> <p>The currency conversion rates are provided by openexchangerates.org</p>";
            $smarty->assign("curr_conversion_msg",$curr_conversion_msg);
        }
        $total = round($total);

        $smarty->assign(array(
            'CheckoutUrl' => $CheckoutUrl,
            'return_url' => $return_url,
            'sid' => $sid,
            'total' => $total,
            'cart_order_id' => $cart_order_id,
            'email' => $email,
            'demo' => $demo,
            'outside_state' => $outside_state,
            'secure_key' => $secure_key,
            'card_holder_name' => $card_holder_name,
            'street_address' => $street_address,
            'street_address2' => $street_address2,
            'phone' => $phone,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
            'country' => $country,
            'ship_name' => $ship_name,
            'ship_street_address' => $ship_street_address,
            'ship_street_address2' => $ship_street_address2,
            'ship_city' => $ship_city,
            'ship_state' => $ship_state,
            'ship_zip' => $ship_zip,
            'ship_country' => $ship_country,
            'products' => $products,
            'x_receipt_link_url' => $x_receipt_link_url,
            'TotalAmount' => number_format($total),
            'this_path' => $this->_path,
            'this_path_ssl' => Configuration::get('PS_FO_PROTOCOL') . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__ . "modules/{$this->name}/"));

        /* Complementos */
        $cart = new Cart($cookie->id_cart);

        $address = new Address($cart->id_address_delivery, intval($cookie->id_lang));
        $state = State::getNameById($address->id_state);
        $state = ($state ? '(' . $state . ')' : '');
        $str_address = ($address->company ? $address->company . '<br>' : '') .
                $address->firstname . ' ' . $address->lastname . '<br>' .
                $address->address1 . '<br>' . ($address->address2 ? $address->address2 . '<br>' : '') .
                $address->postcode . ' ' . $address->city . '<br>' .
                $address->country . $state;
        $smarty->assign('address', $str_address);

        $carrier = Carrier::getCarriers(intval($cookie->id_lang));
        if ($carrier) {
            foreach ($carrier as $c) {
                if ($cart->id_carrier == $c[id_carrier]) {
                    $smarty->assign('carrier', $c['name']);
                    break;
                }
            }
        }
        /* FIN Complementos */

        return $this->display(__FILE__, 'payment_execution.tpl');
    }

    function hookPayment($params) {
        global $smarty, $cart;

        return $this->execPayment($cart);
        /*
          $smarty->assign(array(
          'this_path' 		=> $this->_path,
          'this_path_ssl' 	=> Configuration::get('PS_FO_PROTOCOL').$_SERVER['HTTP_HOST'].__PS_BASE_URI__."modules/{$this->name}/"));

          return $this->display(__FILE__, 'payment.tpl'); */
    }

    function hookPaymentReturn($params) {
        global $smarty;
        $state = $params['objOrder']->getCurrentState();
        if ($state == _PS_OS_OUTOFSTOCK_ or $state == _PS_OS_PAYMENT_)
            $smarty->assign(array(
                'total_to_pay' => Tools::displayPrice($params['total_to_pay'], $params['currencyObj'], false, false),
                'status' => 'ok',
                'id_order' => $params['objOrder']->id
            ));
        else
            $smarty->assign('status', 'failed');

        return $this->display(__FILE__, 'payment_return.tpl');
    }

    private function _postValidation() {
        if (isset($_POST['btnSubmit'])) {
            if (empty($_POST['SID']))
                $this->_postErrors[] = $this->l('Your Vendor Account Number is required.');
        }
        elseif (isset($_POST['currenciesSubmit'])) {
            $currencies = Currency::getCurrencies();
            $authorized_currencies = array();
            foreach ($currencies as $currency)
                if (isset($_POST['currency_' . $currency['id_currency']]) AND $_POST['currency_' . $currency['id_currency']])
                    $authorized_currencies[] = $currency['id_currency'];
            if (!sizeof($authorized_currencies))
                $this->_postErrors[] = $this->l('at least one currency is required.');
        }
    }

    private function _postProcess() {
        if (isset($_POST['btnSubmit'])) {
            Configuration::updateValue('CHECKOUT_SID', $_POST['SID']);
            Configuration::updateValue('CHECKOUT_SECRET', $_POST['SECRET']);
        } elseif (isset($_POST['currenciesSubmit'])) {
            $currencies = Currency::getCurrencies();
            $authorized_currencies = array();
            foreach ($currencies as $currency)
                if (isset($_POST['currency_' . $currency['id_currency']]) AND $_POST['currency_' . $currency['id_currency']])
                    $authorized_currencies[] = $currency['id_currency'];
            Configuration::updateValue('CHECKOUT_CURRENCIES', implode(',', $authorized_currencies));
        }
        $ok = $this->l('Ok');
        $updated = $this->l('Settings Updated');
        $this->_html .= "<div class='conf confirm'><img src='../img/admin/ok.gif' alt='{$ok}' />{$updated}</div>";
    }

    private function _displaycheckout() {
        $modDesc = $this->l('This module allows you to accept payments using 2Checkout merchant services.');
        $modStatus = $this->l('2Checkout\'s online banking service could be the right solution for you');
        $modconfirm = $this->l('');
        $this->_html .= "<img src='../modules/checkout/2Checkout.gif' style='float:left; margin-right:15px;' />
						<b>{$modDesc}</b>
						<br />
						<br />
						{$modStatus}
						<br />
						{$modconfirm}
						<br />
						<br />
						<br />";
    }

    private function _displayForm() {
        $modcheckout = $this->l('2Checkout Setup');
        $modcheckoutDesc = $this->l('Please specify the 2Checkout account number and secret word.');

        $modClientLabelSid = $this->l('2Checkout Account Number');
        $modClientValueSid = $this->SID;

        $modClientLabelSecret = $this->l('Secret Word');
        $modClientValueSecret = $this->SECRET;

        $modCurrencies = $this->l('Currencies');
        $modUpdateSettings = $this->l('Update settings');
        $modCurrenciesDescription = $this->l('Currencies authorized for 2Checkout payment');
        $modAuthorizedCurrencies = $this->l('Authorized currencies');

        $this->_html .=
                "<form action='{$_SERVER['REQUEST_URI']}' method='post'>
			<fieldset>
			<legend><img src='../img/admin/access.png' />{$modcheckout}</legend>
				<table border='0' width='500' cellpadding='0' cellspacing='0' id='form'>
					<tr>
						<td colspan='2'>
							{$modcheckoutDesc}<br /><br />
						</td>
					</tr>
					<tr>
						<td width='130'>{$modClientLabelSid}</td>
						<td>
							<input type='text' name='SID' value='{$modClientValueSid}' style='width: 300px;' />
						</td>
					</tr>
					<tr>
						<td width='130'>{$modClientLabelSecret}</td>
						<td>
							<input type='text' name='SECRET' value='{$modClientValueSecret}' style='width: 300px;' />
						</td>
					</tr>
					<tr>
						<td colspan='2' align='center'>
							<input class='button' name='btnSubmit' value='{$modUpdateSettings}' type='submit' />
						</td>
					</tr>
				</table>
			</fieldset>
		</form>
		<br />
		<br />
		<form action='{$_SERVER['REQUEST_URI']}' method='post'>
			<fieldset>
			<legend><img src='../img/t/15.gif' />{$modAuthorizedCurrencies}</legend>
				<table border='0' width='500' cellpadding='0' cellspacing='0' id='form'>
					<tr>
						<td colspan='2'>
							{$modCurrenciesDescription}
							<br />
							<br />
						</td>
					</tr>
					<tr>
						<td width='130' style='height: 35px; vertical-align:top'>{$modCurrencies}</td>
						<td>";
        $currencies = Currency::getCurrencies();
        $authorized_currencies = array_flip(explode(',', Configuration::get('CHECKOUT_CURRENCIES')));
        foreach ($currencies as $currency)
            $this->_html .= '<label style="float:none; "><input type="checkbox" value="true" name="currency_' . $currency['id_currency'] . '"' . (isset($authorized_currencies[$currency['id_currency']]) ? ' checked="checked"' : '') . ' />&nbsp;<span style="font-weight:bold;">' . $currency['name'] . '</span> (' . $currency['sign'] . ')</label><br />';
        $this->_html .="
						</td>
					</tr>
					<tr>
						<td colspan='2' align='center'>
							<br />
							<input class='button' name='currenciesSubmit' value='{$modUpdateSettings}' type='submit' />
						</td>
					</tr>
				</table>
			</fieldset>
		</form>";
    }

}

?>
