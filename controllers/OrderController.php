<?php

/*
 * 2007-2011 PrestaShop
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
 *  @copyright  2007-2011 PrestaShop SA
 *  @version  Release: $Revision: 6823 $
 *  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

ControllerFactory::includeController('ParentOrderController');

class OrderControllerCore extends ParentOrderController {

    public $step;

    public function init() {
        parent::init();

        $this->step = (int) (Tools::getValue('step'));
        if (!$this->nbProducts)
            $this->step = -1;
    }

    public function preProcess() {
        global $isVirtualCart, $orderTotal;

        parent::preProcess();

        /* If some products have disappear */
        if (!self::$cart->checkQuantities()) {
            $this->step = 0;
            $this->errors[] = Tools::displayError('An item in your shopping bag is no longer available for this quantity, please remove it to proceed.');
        }

        /* Check minimal amount */
        $currency = Currency::getCurrency((int) self::$cart->id_currency);

        $orderTotal = self::$cart->getOrderTotal();
        $minimalPurchase = Tools::convertPrice((float) Configuration::get('PS_PURCHASE_MINIMUM'), $currency);
        if (self::$cart->getOrderTotal(false) < $minimalPurchase && $this->step != -1) {
            $this->step = 0;
            $this->errors[] = Tools::displayError('A minimum purchase total of') . ' ' . Tools::displayPrice($minimalPurchase, $currency) .
                    ' ' . Tools::displayError('is required in order to validate your order.');
        }

        if (!self::$cookie->isLogged(true) AND in_array($this->step, array(1, 2, 3)))
            Tools::redirect('authentication.php?back=' . urlencode('order.php?step=' . $this->step));

        if ($this->nbProducts)
            self::$smarty->assign('virtual_cart', $isVirtualCart);

        $this->_addAddress($this->step);

        if (self::$cookie->isLogged(true)) {
            $reward_points = VBRewards::getCustomerPoints(self::$cookie->id_customer);
            $redemption_status = VBRewards::checkPointsValidity(self::$cookie->id_customer, 0, self::$cart->getOrderTotal(true, Cart::ONLY_PRODUCTS));
            self::$smarty->assign('can_redeem_points', 1);
            self::$smarty->assign("redemption_status", $redemption_status);
            if ($redemption_status === CANNOT_REDEEM_COINS)
                self::$smarty->assign('can_redeem_points', 0);
            else if ($redemption_status === INSUFFICIENT_VALID_ORDERS)
                self::$smarty->assign('redemption_status_message', 'Coins can be redeemed from second purchase onwards.');
            else if ($redemption_status === MIN_CRITERIA_NOT_MET)
                self::$smarty->assign('redemption_status_message', 'Order value should be more than 100 USD to redeem coins');

            self::$smarty->assign('redeem_points', (int)self::$cart->getPoints() );
            self::$smarty->assign('balance_points', $reward_points);
            if($reward_points-(int)self::$cart->getPoints() > 0)
                self::$smarty->assign('balance_cash', (int)self::$cart->getPointsDiscounts($reward_points-(int)self::$cart->getPoints()));
        }
    }

    public function displayHeader() {
        self::$smarty->assign('nobots', 1);
        if (!Tools::getValue('ajax'))
            parent::displayHeader();
    }

    public function process() {
        parent::process();

        /* 4 steps to the order */
        switch ((int) $this->step) {
            case -1;
                self::$smarty->assign('empty', 1);
                break;
            case 1:
                $this->_assignAddress();
                break;
            case 2:
                if (Tools::getValue('id_address_delivery')) {
                    $this->processAddress(2);
                    if (sizeof($this->errors))
                        break;
                }
                $this->autoStep();
                $this->_assignCarrier();
                $this->autoStep();

                $this->_assignAddress();
                break;
            case 3:
                if (Tools::getValue('id_address_invoice')) {
                    $this->processAddress(3);
                    if (sizeof($this->errors))
                        break;
                }
                $this->autoStep();
                //MOD: bypass carrier selection. select default carrier
                $this->processCarrier();
                $this->autoStep();
                /* Bypass payment step if total is 0 */
                if (($id_order = $this->_checkFreeOrder()) AND $id_order) {
                    if (self::$cookie->is_guest) {
                        $email = self::$cookie->email;
                        self::$cookie->logout(); // If guest we clear the cookie for security reason
                        Tools::redirect('guest-tracking.php?id_order=' . (int) $id_order . '&email=' . urlencode($email));
                    } else {
                        $customer = new Customer((int) (self::$cookie->id_customer));
                        Tools::redirectLink(__PS_BASE_URI__ . 'order-confirmation.php?key='
                                . $customer->secure_key
                                . '&id_cart=' . (int) ($cart->id)
                                . '&id_module=FreeOrder'
                                . '&id_order=' . (int) $id_order);
                    }
                }
		self::$smarty->assign("mycurr",new Currency(intval(self::$cookie->id_currency)));

		$donate = Tools::getValue("donate", null);
		if( !empty($donate) )
			self::$cookie->donate = $donate;
		if( !isset(self::$cookie->donate) )
			self::$cookie->donate = "yes";
		if( self::$cookie->donate === "yes" ) {
			$donation_amount = intval(Tools::getValue("donate_amt", null));
			if( empty($donation_amount) || $donation_amount < 1 ) {
				$donation_amount = round(self::$cookie->donation_amount);
				if( empty($donation_amount) || $donation_amount < 1 )
					$donation_amount = 1;
			}
		} else {
			$donation_amount = 0;
		}
		self::$cookie->donation_amount = $donation_amount;
		self::$smarty->assign("donate", self::$cookie->donate);
		self::$smarty->assign("donation_amount",self::$cookie->donation_amount);
                $this->_assignPayment();
                break;
            default:
                break;
        }
        $this->_assignSummaryInformations();
    }

    private function processAddressFormat() {
        $addressDelivery = new Address((int) (self::$cart->id_address_delivery));
        $addressInvoice = new Address((int) (self::$cart->id_address_invoice));

        $invoiceAddressFields = AddressFormat::getOrderedAddressFields($addressInvoice->id_country);
        $deliveryAddressFields = AddressFormat::getOrderedAddressFields($addressDelivery->id_country);

        self::$smarty->assign(array(
            'inv_adr_fields' => $invoiceAddressFields,
            'dlv_adr_fields' => $deliveryAddressFields));
    }

    public function displayContent() {
        global $currency, $isBetaUser;

        parent::displayContent();

        self::$smarty->assign(array(
            'currencySign' => $currency->sign,
            'currencyRate' => $currency->conversion_rate,
            'currencyFormat' => $currency->format,
            'currencyBlank' => $currency->blank,
        ));

        switch ((int) $this->step) {
            case -1:
                if ($isBetaUser)
                    self::$smarty->display(_PS_THEME_DIR_ . 'beta/shopping-cart.tpl');
                else
                    self::$smarty->display(_PS_THEME_DIR_ . 'shopping-cart.tpl');
                break;
            case 1:
                $this->processAddressFormat();
                self::$smarty->display(_PS_THEME_DIR_ . 'order-address.tpl');
                break;
            case 2:
                self::$smarty->display(_PS_THEME_DIR_ . 'order-address-billing.tpl');
                break;
            case 3:
                self::$smarty->display(_PS_THEME_DIR_ . 'order-payment.tpl');
                break;
            default:
                if (Tools::getValue('summary') == 1) {
                    self::$smarty->assign('summary_only', 1);
                    self::$smarty->display(_PS_THEME_DIR_ . 'csrt-summary-large.tpl');
                } else
                if ($isBetaUser)
                    self::$smarty->display(_PS_THEME_DIR_ . 'beta/shopping-cart.tpl');
                else
                    self::$smarty->display(_PS_THEME_DIR_ . 'shopping-cart.tpl');
                break;
        }
    }

    public function displayFooter() {
        if (!Tools::getValue('ajax'))
            parent::displayFooter();
    }

    /* Order process controller */

    public function autoStep() {
        global $isVirtualCart;

        if ($this->step >= 2 AND (!self::$cart->id_address_delivery))
            Tools::redirect('order.php?step=1');
        if ($this->step >= 3 AND (!self::$cart->id_address_delivery OR !self::$cart->id_address_invoice))
            Tools::redirect('order.php?step=1');
        $delivery = new Address((int) (self::$cart->id_address_delivery));
        $invoice = new Address((int) (self::$cart->id_address_invoice));

        if ($delivery->deleted OR $invoice->deleted) {
            if ($delivery->deleted)
                unset(self::$cart->id_address_delivery);
            if ($invoice->deleted)
                unset(self::$cart->id_address_invoice);
            self::$cart->update();
            Tools::redirect('order.php?step=1');
        }
        elseif ($this->step >= 3 AND !self::$cart->id_carrier AND !$isVirtualCart)
            Tools::redirect('order.php?step=2');
    }

    /*
     * Manage address
     */

    public function processAddress($step) {
        if ($step == 2) {
            if (!Tools::isSubmit('id_address_delivery') OR !Address::isCountryActiveById((int) Tools::getValue('id_address_delivery')))
                $this->errors[] = Tools::displayError('This address is not in a valid area.');
            else {
                self::$cart->id_address_delivery = (int) (Tools::getValue('id_address_delivery'));
                if (!self::$cart->update())
                    $this->errors[] = Tools::displayError('An error occurred while updating your cart.');

                if (Tools::isSubmit('message'))
                    $this->_updateMessage(Tools::getValue('message'));
            }

            //validate pincode of this address here
            $deliveryAddress = new Address(self::$cart->id_address_delivery);
            $op = Carrier::getPreferredCarriers($deliveryAddress->id_country);
            if ($op == 0)
                $this->errors[] = 'We are sorry but we do not provide service to this region as of now. However, we keep adding new locations with time and would request you to check our website a few weeks later. We apologise for the inconvenience caused.';
            else {
                self::$cart->id_carrier = (int) ($op);
                self::$smarty->assign(array('op' => $op));
                if (!self::$cart->update())
                    $this->errors[] = Tools::displayError('An error occurred while updating your cart.');
            }

            if (sizeof($this->errors)) {
                if (Tools::getValue('ajax'))
                    die('{"hasError" : true, "errors" : ["' . implode('\',\'', $this->errors) . '"]}');
                $this->step = 1;
            }
        }
        else {
            self::$cart->id_address_invoice = (int) (Tools::getValue('id_address_invoice'));
            if (!self::$cart->update())
                $this->errors[] = Tools::displayError('An error occurred while updating your cart.');
        }
        if (Tools::getValue('ajax'))
            die(true);
    }

    /* Carrier step */

    protected function processCarrier() {
        global $orderTotal;

        parent::_processCarrier();

        if (sizeof($this->errors)) {
            self::$smarty->assign('errors', $this->errors);
            $this->_assignCarrier();
            $this->step = 0;
            $this->displayContent();
            include(dirname(__FILE__) . '/../footer.php');
            exit;
        }
        $orderTotal = self::$cart->getOrderTotal();
    }

    /* Address step */

    protected function _assignAddress() {
        parent::_assignAddress();

        self::$smarty->assign('cart', self::$cart);
        if (self::$cookie->is_guest)
            Tools::redirect('order.php?step=2');
    }

    /* Carrier step */

    protected function _assignCarrier() {
        global $defaultCountry;

        if (isset(self::$cookie->id_customer))
            $customer = new Customer((int) (self::$cookie->id_customer));
        else
            die(Tools::displayError('Fatal error: No customer'));
        // Assign carrier
        parent::_assignCarrier();
        // Assign wrapping and TOS
        $this->_assignWrappingAndTOS();

        self::$smarty->assign('is_guest', (isset(self::$cookie->is_guest) ? self::$cookie->is_guest : 0));
        self::$smarty->assign('cart', self::$cart);
    }

    /* Payment step */

    protected function _assignPayment() {
        global $orderTotal;
        $invoice_address = new Address((int) self::$cart->id_address_invoice);
        if ($invoice_address->id_country != 110) {
            include_once(_PS_MODULE_DIR_ . 'paypal/paypal.php');
            include_once(_PS_MODULE_DIR_ . 'paypal/payment/paypalpayment.php');
            include_once(_PS_MODULE_DIR_ . 'paypal/payment/submit.php');

            //GetPaypal stuff
            unset(self::$cookie->paypal_token);

            /*if (self::$cart->id_currency != $ppPayment->getCurrency((int) self::$cart->id_currency)->id) {
                self::$cart->id_currency = (int) ($ppPayment->getCurrency((int) self::$cart->id_currency)->id);
                self::$cookie->id_currency = (int) (self::$cart->id_currency);
                self::$cart->update();
                Tools::redirect('modules/' . $ppPayment->name . '/payment/submit.php');
            }*/
            
            $curr_sel_currency = CurrencyCore::getCurrency(self::$cart->id_currency);
            self::$smarty->assign(array(
                'cust_currency' => self::$cart->id_currency,
                'currency' => $curr_sel_currency,
                'total' => self::$cart->getOrderTotal(true, Cart::BOTH),
                'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $ppPayment->name . '/',
                'mode' => 'payment/'
            ));
        }
        // Redirect instead of displaying payment modules if any module are grefted on
        Hook::backBeforePayment('order.php?step=3');

        /* We may need to display an order summary */
        self::$smarty->assign(self::$cart->getSummaryDetails());
        self::$smarty->assign(array(
            'total_price' => Tools::ps_round((float) ($orderTotal)),
            'taxes_enabled' => (int) (Configuration::get('PS_TAX'))
        ));
        self::$cookie->checkedTOS = '1';

        parent::_assignPayment();
    }

    protected function _addAddress($step) {
        $id_address = (int) Tools::getValue('id_address', 0);
        if ($id_address && !Tools::getValue('address_update', 0)) {
            $address = new Address((int) $id_address);
            if (Validate::isLoadedObject($address) AND Customer::customerHasAddress((int) (self::$cookie->id_customer), (int) ($id_address))) {
                if (Tools::isSubmit('delete')) {
                    if (self::$cart->id_address_invoice == $address->id)
                        unset(self::$cart->id_address_invoice);
                    if (self::$cart->id_address_delivery == $address->id)
                        unset(self::$cart->id_address_delivery);
                    if ($address->delete())
                        Tools::redirect('order.php?step=1');
                    $this->errors[] = Tools::displayError('This address cannot be deleted.');
                }
                self::$smarty->assign(array('address' => $address, 'id_address' => (int) $id_address));
                if (Tools::isSubmit('id_state') AND Tools::getValue('id_state') != NULL AND is_numeric(Tools::getValue('id_state')))
                    $selected_state = Tools::getValue('id_state');
                elseif (isset($address) AND isset($address->id_state) AND !empty($address->id_state) AND isset($address->id_state))
                    $selected_state = $address->id_state;
                else
                    $selected_state = false; // default to karnataka.

                if (Tools::isSubmit('id_country') AND Tools::getValue('id_country') != NULL AND is_numeric(Tools::getValue('id_country')))
                    $selected_country = Tools::getValue('id_country');
                elseif (isset($address) AND isset($address->id_country) AND !empty($address->id_country) AND isset($address->id_state))
                    $selected_country = $address->id_country;
                else
                    $selected_country = false;
                self::$smarty->assign('selected_country', $selected_country);
                self::$smarty->assign('selected_state', $selected_state);
            }
        }

        if (Tools::isSubmit('submitAddress')) {
            $address = new Address();
            $this->errors = $address->validateControler();
            $address->id_customer = (int) (self::$cookie->id_customer);

            if (!Tools::getValue('phone') AND !Tools::getValue('phone_mobile'))
                $this->errors[] = Tools::displayError('Please add your mobile phone number.');
            if (!$country = new Country((int) $address->id_country) OR !Validate::isLoadedObject($country))
                die(Tools::displayError());

            //remove zipcode verification
            /*
              $zip_code_format = $country->zip_code_format;
              if ($country->need_zip_code)
              {
              if (($postcode = Tools::getValue('postcode')) AND $zip_code_format)
              {
              $zip_regexp = '/^'.$zip_code_format.'$/ui';
              $zip_regexp = str_replace(' ', '( |)', $zip_regexp);
              $zip_regexp = str_replace('-', '(-|)', $zip_regexp);
              $zip_regexp = str_replace('N', '[0-9]', $zip_regexp);
              $zip_regexp = str_replace('L', '[a-zA-Z]', $zip_regexp);
              $zip_regexp = str_replace('C', $country->iso_code, $zip_regexp);
              if (!preg_match($zip_regexp, $postcode))
              $this->errors[] = '<strong>'.Tools::displayError('Post/Zip Code mentioned is incorrect.').'</strong> ';
              }
              elseif ($zip_code_format)
              $this->errors[] = '<strong>'.Tools::displayError('Post/Zip Code mentioned is incorrect.').'</strong> ';
              elseif ($postcode AND !preg_match('/^[0-9a-zA-Z -]{4,9}$/ui', $postcode))
              $this->errors[] = '<strong>'.Tools::displayError('Post/Zip Code mentioned is incorrect.').'</strong> ';
              }
             */
            if (!Tools::isSubmit('order_add_address_billing')) {
                //validate pincode and assign possible payment options
                $op = 0;
                $op = Carrier::getPreferredCarriers($country->id);

                if ($op == 0)
                    $this->errors[] = 'We are sorry but we do not provide service to this region as of now. However, we keep adding new locations with time and would request you to check our website a few weeks later. We apologise for the inconvenience caused. ';
            }

            if (!$country->isNeedDni())
                $address->dni = NULL;
            if (Configuration::get('PS_TOKEN_ENABLE') == 1 AND
                    strcmp(Tools::getToken(false), Tools::getValue('token')) AND
                    self::$cookie->isLogged(true) === true)
                $this->errors[] = Tools::displayError('Invalid token');

            if ((int) ($country->contains_states) AND !(int) ($address->id_state))
                $this->errors[] = Tools::displayError('Please select a state.');

            if (!sizeof($this->errors)) {
                if (isset($id_address)) {
                    $country = new Country((int) ($address->id_country));
                    if (Validate::isLoadedObject($country) AND !$country->contains_states)
                        $address->id_state = 0;
                    $address_old = new Address((int) $id_address);
                    if (Validate::isLoadedObject($address_old) AND Customer::customerHasAddress((int) self::$cookie->id_customer, (int) $address_old->id)) {
                        if ($address_old->isUsed()) {
                            $address_old->delete();
                            if (!Tools::isSubmit('ajax')) {
                                $to_update = false;
                                if (self::$cart->id_address_invoice == $address_old->id) {
                                    $to_update = true;
                                    self::$cart->id_address_invoice = 0;
                                }
                                if (self::$cart->id_address_delivery == $address_old->id) {
                                    $to_update = true;
                                    self::$cart->id_address_delivery = 0;
                                }
                                if ($to_update)
                                    self::$cart->update();
                            }
                        }
                        else {
                            $address->id = (int) ($address_old->id);
                            $address->date_add = $address_old->date_add;
                        }
                    }
                }

                if ($result = $address->save()) {
                    if (Tools::isSubmit('order_add_address')) {
                        self::$cart->id_address_delivery = (int) ($address->id);
                        self::$cart->update();
                        self::$smarty->assign(array('op' => $op));
                    } else if (Tools::isSubmit('order_add_address_billing')) {
                        self::$cart->id_address_invoice = (int) ($address->id);
                        self::$cart->update();
                    }
                }
                else
                    $this->errors[] = Tools::displayError('An error occurred while updating your address.');
            }

            if (sizeof($this->errors)) {
                self::$smarty->assign('errors', $this->errors);
                $this->step = 1;
            }
        }
    }

}

