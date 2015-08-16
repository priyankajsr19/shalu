<?php

if (!defined('_PS_VERSION_'))
    exit;

class payu extends PaymentModule {

    public function __construct() {
        $this->name = 'payu';
        $this->tab = 'payments_gateways';
        $this->version = '1.2';
        $this->author = 'PrestaShop';

        $this->currencies = true;
        $this->currencies_mode = 'radio';

        parent::__construct();
        $this->_errors = array();
        $this->page = basename(__FILE__, '.php');
        $this->displayName = $this->l('Payu Checkout');
        $this->description = $this->l('Payu Checkout API implementation');

        if (!sizeof(Currency::checkPaymentCurrencies($this->id)))
            $this->warning = $this->l('No currency set for this module');

        /* For 1.4.3 and less compatibility */
        $updateConfig = array('PS_OS_CHEQUE' => 1, 'PS_OS_PAYMENT' => 2, 'PS_OS_PREPARATION' => 3, 'PS_OS_SHIPPING' => 4, 'PS_OS_DELIVERED' => 5, 'PS_OS_CANCELED' => 6,
            'PS_OS_REFUND' => 7, 'PS_OS_ERROR' => 8, 'PS_OS_OUTOFSTOCK' => 9, 'PS_OS_BANKWIRE' => 10, 'PS_OS_PAYPAL' => 11, 'PS_OS_WS_PAYMENT' => 12);
        foreach ($updateConfig as $u => $v)
            if (!Configuration::get($u) || (int) Configuration::get($u) < 1) {
                if (defined('_' . $u . '_') && (int) constant('_' . $u . '_') > 0)
                    Configuration::updateValue($u, constant('_' . $u . '_'));
                else
                    Configuration::updateValue($u, $v);
            }
    }

    public function install() {


        if (!parent::install() OR !$this->registerHook('payment') OR !$this->registerHook('paymentReturn'))
            return false;


        Configuration::updateValue('PAYU_MERCHANT_ID', '');
        Configuration::updateValue('PAYU_SALT', '');
        Configuration::updateValue('PAYU_LOGS', '');
        Configuration::updateValue('PAYU_MODE', '');

        /* Set database */
        if (!Db::getInstance()->Execute('CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'payu_order` (
		  `id_order` int(10) unsigned NOT NULL,
		  `id_transaction` varchar(255) NOT NULL,
		  `payment_method` int(10) unsigned NOT NULL,
		  `payment_status` varchar(255) NOT NULL,
		  `order_date` timestamp default now(),
		   `payment_request` text,
		   `payment_response` text,
		  PRIMARY KEY (`id_order`)
		) ENGINE=' . _MYSQL_ENGINE_ . '  DEFAULT CHARSET=utf8'))
            return false;

        return true;
    }

    public function uninstall() {

        Configuration::deleteByName('PAYU_MERCHANT_ID');
        Configuration::deleteByName('PAYU_SALT');
        Configuration::deleteByName('PAYU_MODE');
        Configuration::deleteByName('PAYU_LOGS');
        return parent::uninstall();
    }

    /* public function hookPayment($params)
      {
      if (!$this->active)
      return;

      return $this->hook
      } */

    public function getContent() {
        global $currentIndex, $cookie;

        if (Tools::isSubmit('submitPayuCheckout')) {
            $errors = array();
            if (($merchant_id = Tools::getValue('payu_merchant_id')) AND $merchant_id != '')
                Configuration::updateValue('PAYU_MERCHANT_ID', $merchant_id);
            else
                $errors[] = '<div class="warning warn"><h3>' . $this->l('Enter the merchant id') . '</h3></div>';

            if (($payu_salt = Tools::getValue('payu_salt')) AND $payu_salt != '')
                Configuration::updateValue('PAYU_SALT', $payu_salt);
            else
                $errors[] = '<div class="warning warn"><h3>' . $this->l('Enter the salt') . '</h3></div>';

            if ($mode = (Tools::getValue('payu_mode') == 'real' ? 'real' : 'demo'))
                Configuration::updateValue('PAYU_MODE', $mode);

            if (Tools::getValue('payu_logs'))
                Configuration::updateValue('PAYU_LOGS', 1);
            else
                Configuration::updateValue('PAYU_LOGS', 0);



            if (!sizeof($errors))
                Tools::redirectAdmin($currentIndex . '&configure=payu&token=' . Tools::safeOutput(Tools::getValue('token')) . '&conf=4');
            foreach ($errors as $error)
                echo $error;
        }

        $html = '<h2>' . $this->displayName . '</h2>
		<form action="' . Tools::safeOutput($_SERVER['REQUEST_URI']) . '" method="post">
			<fieldset>
			<legend><img src="' . __PS_BASE_URI__ . 'modules/payu/payu-logo.gif" />' . $this->l('Settings') . '</legend>
			
				
				<label>
					' . $this->l('Mode') . '
				</label>
				<div class="margin-form">
					<select name="payu_mode">
						<option value="real"' . (Configuration::get('PAYU_MODE') == 'real' ? ' selected="selected"' : '') . '>' . $this->l('Real') . '&nbsp;&nbsp;</option>
						<option value="demo"' . (Configuration::get('PAYU_MODE') == 'demo' ? ' selected="selected"' : '') . '>' . $this->l('Demo') . '&nbsp;&nbsp;</option>
					</select>
				</div>
				
				
				<label>
					' . $this->l('Merchant ID') . '
				</label>
				<div class="margin-form">
					<input type="text" name="payu_merchant_id" value="' . Tools::safeOutput(Tools::getValue('payu_merchant_id', Configuration::get('PAYU_MERCHANT_ID'))) . '" />
				</div>
				<label>
					' . $this->l('SALT') . '
				</label>
				<div class="margin-form">
					<input type="text" name="payu_salt" value="' . Tools::safeOutput(Tools::getValue('payu_salt', Configuration::get('PAYU_SALT'))) . '" />
				</div>
				
					
				<label>
					' . $this->l('Logs') . '
				</label>
				<div class="margin-form" style="margin-top:5px">
				
				
				<input type="checkbox" name="payu_logs"' . (Tools::getValue("payu_logs", Configuration::get("PAYU_LOGS")) ? " checked=\"checked\"" : "") . ' />
				</div>
				<div class="clear center"><input type="submit" name="submitPayuCheckout" class="button" value="' . $this->l('   Save   ') . '" /></div>
			</fieldset>
		</form>';

        return $html;
    }

    public function hookPayment($params) {
        global $cart;
        global $smarty, $cart, $cookie;
        $invoice_address = new Address((int) $cart->id_address_invoice);

        $key = Configuration::get('PAYU_MERCHANT_ID');
        $salt = Configuration::get('PAYU_SALT');

        if (!$this->active)
            return;
        
        $mode = Configuration::get('PAYU_MODE');
        $log = Configuration::get('PAYU_LOGS');
        $amount = ($cart->getOrderTotal(true, Cart::BOTH));

        $curr_currency = CurrencyCore::getCurrency($cart->id_currency);
        
        if ($invoice_address->id_country == 110) {
            $key = 'VLBB6Z';
            $salt = 'KQUxLUkT';
            if ($cart->id_currency != 4) {
                //convert to USD(default)
                $amount = Tools::convertPrice($amount,$cart->id_currency, false);
                //convert to INT
                $amount = Tools::convertPrice($amount, 4);
                $inr_currency = CurrencyCore::getCurrency(4);
                $curr_conversion_msg = "<p>Dear Customer, any order with an Indian billing address entails processing of the order value in {$inr_currency['iso_code']} ({$inr_currency['name']}). The order value of <b>".Tools::displayPrice($amount,4)."</b> will be processed.</p><p>Currency conversion rates are provided by  openexchangerates.org</p>";
                $smarty->assign("curr_conversion_msg",$curr_conversion_msg);
            }
        } else if( (int)$curr_currency['paypal_support'] === 1 && $cart->id_currency != 2) {
            //For all Paypal supported curencies except USD, we dont show PayU
            return;
        } else if( $cart->id_currency != 2 ) {
            // Currency not supported by Paypal and not USD, convert to USD and proceed 
            $amount = Tools::convertPrice($amount,$cart->id_currency, false);
            $this_currency = CurrencyCore::getCurrency($cart->id_currency);
            $curr_conversion_msg = "<p>Unfortunately we are unable to accept payments in <b>{$this_currency['name']}</b>.</p> <p>An equivalent order value of USD <b>". Tools::displayPrice($amount,2)."</b> will be processed.</p>";
            $smarty->assign("curr_conversion_msg",$curr_conversion_msg);
        }
        $amount = round($amount);
        //else 
        //return;
        //convert to INR if the currency is not
        //if ($cart->id_currency != 4)
        //$amount = Tools::convertPrice($amount, 4, true);

        $customer = new Customer((int) ($cart->id_customer));

        $action = 'https://test.payu.in/_payment.php';

        $txnid = $cart->id;
        $productInfo = 'Payu product information';
        $firstname = $customer->firstname;
        $Lastname = $customer->lastname;
        $deloveryAddress = new Address((int) ($cart->id_address_invoice));

        $Zipcode = $deloveryAddress->postcode;
        $email = $customer->email;
        $phone = $deloveryAddress->phone;

        $deloveryAddress->country = Country::getNameById(1, $deloveryAddress->id_country);
        $deloveryAddress->state = State::getNameById($deloveryAddress->id_state);

        if ($mode == 'real') {
            $action = 'https://secure.payu.in/_payment.php';
        }

        $request = $key . '|' . $txnid . '|' . $amount . '|' . $productInfo . '|' . $firstname . '|' . $email . '|||||||||||' . $salt;

        $Hash = hash('sha512', $key . '|' . $txnid . '|' . $amount . '|' . $productInfo . '|' . $firstname . '|' . $email . '|||||||||||' . $salt);


        $baseUrl = Tools::getShopDomain(true, true) . __PS_BASE_URI__;


        if ($log == 1) {
            $query = "insert into ps_payu_order(id_order,payment_request) values($orderId,'$request')";
            Db::getInstance()->Execute($query);
        }

        $surl = $baseUrl . 'modules/' . $this->name . '/success.php';
        $curl = $baseUrl . 'modules/' . $this->name . '/failure.php';
        $Furl = $baseUrl . 'modules/' . $this->name . '/failure.php';
        $Pg = 'CC';

        $payuInfo = array('action' => $action,
            'key' => $key,
            'txnid' => $txnid,
            'amount' => $amount,
            'productinfo' => $productInfo,
            'firstname' => $firstname,
            'Lastname' => $Lastname,
            'Zipcode' => $Zipcode,
            'email' => $email,
            'phone' => $phone,
            'surl' => $surl,
            'Furl' => $Furl,
            'curl' => $curl,
            'Hash' => $Hash,
            'Pg' => $Pg,
            'deliveryAddress' => $deloveryAddress
        );


        $smarty->assign('Message', 'Please wait, you will be redirected to payu website');
        $smarty->assign($payuInfo);


        return $this->display(__FILE__, 'payu.tpl');
    }

}
