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
 *  @version  Release: $Revision: 7086 $
 *  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

/* Class FreeOrder to use PaymentModule (abstract class, cannot be instancied) */

class FreeOrder extends PaymentModule {

}

class ParentOrderControllerCore extends FrontController {

    public $nbProducts;

    public function __construct() {
        $this->ssl = true;
        parent::__construct();

        /* Disable some cache related bugs on the cart/order */
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    }

    public function init() {
        parent::init();
        $this->nbProducts = self::$cart->nbProducts();
    }

    public function preProcess() {
        global $isVirtualCart, $cookie;

        parent::preProcess();

        // Redirect to the good order process
        if (Configuration::get('PS_ORDER_PROCESS_TYPE') == 0 AND (strpos($_SERVER['PHP_SELF'], 'order.php') === false AND strpos($_SERVER['PHP_SELF'], 'cart-summary-large.php') === false))
            Tools::redirect('order.php');
        if (Configuration::get('PS_ORDER_PROCESS_TYPE') == 1 AND strpos($_SERVER['PHP_SELF'], 'order-opc.php') === false) {
            if (isset($_GET['step']) AND $_GET['step'] == 3)
                Tools::redirect('order-opc.php?isPaymentStep=true');
            Tools::redirect('order-opc.php');
        }

        if (Configuration::get('PS_CATALOG_MODE'))
            $this->errors[] = Tools::displayError('This store has not accepted your new order.');

        if (Tools::isSubmit('submitReorder') AND $id_order = (int) Tools::getValue('id_order')) {
            $oldCart = new Cart(Order::getCartIdStatic((int) $id_order, (int) self::$cookie->id_customer));
            $duplication = $oldCart->duplicate();
            if (!$duplication OR !Validate::isLoadedObject($duplication['cart']))
                $this->errors[] = Tools::displayError('Sorry, we cannot renew your order.');
            elseif (!$duplication['success'])
                $this->errors[] = Tools::displayError('Missing items - we are unable to renew your order');
            else {
                self::$cookie->id_cart = $duplication['cart']->id;
                self::$cookie->write();
                if (Configuration::get('PS_ORDER_PROCESS_TYPE') == 1)
                    Tools::redirect('order-opc.php');
                Tools::redirect('order.php');
            }
        }

        if (Tools::isSubmit('submit_instructions')) {
            $instructions = Tools::getValue('special_instructions');
            self::$cart->gift_message = pSQL($instructions);
            self::$cart->update();
            Tools::redirect('order?step=3');
        }

        if ($this->nbProducts) {
            /* check discount validity */
            $cartDiscounts = self::$cart->getDiscounts();
            $discountInvalid = false;
            foreach ($cartDiscounts AS $k => $cartDiscount) {
                if ($error = self::$cart->checkDiscountValidity(new Discount((int) ($cartDiscount['id_discount'])), $cartDiscounts, self::$cart->getOrderTotal(true, Cart::ONLY_PRODUCTS_WITHOUT_SHIPPING), self::$cart->getProducts())) {
                    self::$cart->deleteDiscount((int) ($cartDiscount['id_discount']));
                    $discountInvalid = true;
                }
            }
            if ($discountInvalid)
                Tools::redirect('order-opc.php');

            if (Tools::getValue('redeem_points')) {
                $points = (int) Tools::getValue('redeem_points');
                if ($points < 1) {
                    self::$smarty->assign('redeem_points', $points);
                    $this->errors[] = Tools::displayError('You can redeem minimum of 1 coin in an order.');
                }
        $orderTotal = self::$cart->getOrderTotal(true, Cart::ONLY_PRODUCTS);
                $redemption_status = VBRewards::checkPointsValidity($cookie->id_customer, $points + self::$cart->getPoints(), $orderTotal);
                if ($redemption_status === CAN_REDEEM_COINS) {
                    self::$cart->addPoints($points);
                    self::$smarty->assign('redeem_points', (int)self::$cart->getPoints() );
                } else {

                    if ($redemption_status === INSUFFICIENT_VALID_ORDERS)
                        $this->errors[] = Tools::displayError('Coins can be redeemed from second purchase onwards.');
                    else if ($redemption_status === MIN_CRITERIA_NOT_MET)
                        $this->errors[] = Tools::displayError('Order value should be more than 100 USD to redeem coins');
                }

                $this->adjustPoints();
            }
            elseif (Tools::getValue('deletePoints')) {
                self::$cart->deletePoints();
            }

            if (Tools::isSubmit('submitAddDiscount') AND Tools::getValue('discount_name')) {
                $discountName = Tools::getValue('discount_name');
                if (!Validate::isDiscountName($discountName))
                    $this->errors[] = Tools::displayError('Voucher name invalid.');
                else {
                    $discount = new Discount((int) (Discount::getIdByName($discountName)));
                    if (Validate::isLoadedObject($discount)) {
                        if ($tmpError = self::$cart->checkDiscountValidity($discount, self::$cart->getDiscounts(), self::$cart->getOrderTotal(), self::$cart->getProducts(), true)) {
	                	$this->errors[] = $tmpError;
			}
                    }
                    else
                        $this->errors[] = Tools::displayError('Voucher name invalid.');
                    if (!sizeof($this->errors)) {
                        self::$cart->addDiscount((int) ($discount->id));
                        Tools::redirect('order-opc.php');
                    }
                }
                self::$smarty->assign(array(
                    'errors' => $this->errors,
                    'discount_name' => Tools::safeOutput($discountName)
                ));
                $this->adjustPoints();
            } elseif (isset($_GET['deleteDiscount']) AND Validate::isUnsignedId($_GET['deleteDiscount'])) {
                self::$cart->deleteDiscount((int) ($_GET['deleteDiscount']));
                Tools::redirect('order-opc.php');
            }

            /* Is there only virtual product in cart */
            if ($isVirtualCart = self::$cart->isVirtualCart())
                $this->_setNoCarrier();
        }

	//if enough stock, show free gift message
	$free_products = array(66254, 66255, 66256);
	$sql = "select quantity from ps_product where id_product in (".implode(",",$free_products).")";
	$result = Db::getInstance()->ExecuteS($sql);
	$free_gift_stock =  $has_free_gift = false;
	foreach($result as $row) {
		if( intval($row['quantity']) > 0 ) {
			$free_gift_stock =  true;
			break;
		}	
	}
	$total_products_wt = self::$cart->getOrderTotal(true, Cart::ONLY_PRODUCTS);
	$cv = Tools::convertPrice($total_products_wt,(int)self::$cookie->id_currency, false);
	if( $cv > 50) {	
		if( $free_gift_stock ) {
			$cart_products = self::$cart->getProducts();
			foreach($cart_products as $cproduct) {
				$id_product = $cproduct['id_product'];
				if( in_array($id_product, $free_products )) {
					$has_free_gift = true;
					break;	
				}
			}
		}
		if( !$has_free_gift && $free_gift_stock ) {
			// self::$smarty->assign("spl_voucher_message","Here is the free <a href='/1222-free-gifts'>gift product</a> for you.Valid still stock lasts. Read <a href='/content/30-womens-day-special-discount'>T&C</a> here");
		}
	} else {
		$free_products = array(66254, 66255, 66256);
		foreach($free_products as $p)
			self::$cart->deleteProduct($p);
		// self::$smarty->assign("spl_voucher_message","We have a free <a href='/1222-free-gifts'>gift product</a> for you if the shopping cart value is atleast USD 50.");
	}
        self::$smarty->assign('back', Tools::safeOutput(Tools::getValue('back')));

        if (self::$cart->gift_message) {
            self::$smarty->assign('cart_instructions', 1);
            self::$smarty->assign('special_instructions', self::$cart->gift_message);
        }
        
        //buy1 get 1
        /*
        $products = self::$cart->getProducts(true);
        $nB1G1Products = 0;
        
        // this is a very interesting array, keeps as many rows as there are items in your cart
        // if there is an item with quantity 2, it will have two rows in that array, 
        // ie item will have as many rows as the quantity of the item in cart.
        $b1g1products = array();
        foreach($products as $product) {   
            $productObj = new Product($product['id_product'], true);
            $tags = $productObj->getTags(1);
            if(in_array('buy1get1', $tags)){
                self::$smarty->assign("spl_voucher_message", "You are eligible for Buy 2 Get 3 Offer");
                //counting the b1g1 products
                $nB1G1Products = $nB1G1Products + $product['cart_quantity'];
                
                //adding rows to interesting array $b1g1products
                for($q = 0; $q < $product['cart_quantity']; $q++){
                    array_push($b1g1products, $product);
                }  
            }
        }

        
        //sorting products in ascending order of price
        usort($b1g1products, function($prod1, $prod2){
            return $prod1['price'] - $prod2['price'] ;
        });

        $noB1G1AdvantageAvailable = (int)($nB1G1Products/2);
        //print_r($noB1G1AdvantageAvailable);
        $discount = 0;
        for($p = 0; $p < $noB1G1AdvantageAvailable; $p++){
            $discount = $discount + $b1g1products[$p]['price'];
        }

        if((int)self::$cart->id_currency != 2){
            $discount = Tools::convertPrice($discount, (int)self::$cart->id_currency, false);
        }
        
        $discount = round($discount, 2);

        $b1g1DiscountInCart = null;
        $allCartDiscounts = self::$cart->getDiscounts();

        foreach ($allCartDiscounts as $cartDiscount) {
            if(strpos($cartDiscount['name'], 'B1G1') === 0){
                $b1g1DiscountInCart = new Discount((int) (Discount::getIdByName($cartDiscount['name'])));
            }
        }
        
	

        if($discount > 0 && empty($b1g1DiscountInCart)){
            $new_discount = new Discount();
            $new_discount->id_discount_type = 2;
            $new_discount->value = $discount; // coupon value
            $new_discount->name = "B1G1" . Tools::rand_string(5);
            $new_discount->id_currency = 2;
            $new_discount->quantity = 1;
            $new_discount->quantity_per_user = 100;
            $new_discount->date_from = date('Y-m-d H:i:s');
            $new_discount->date_to = '2015-09-10 20:00:00'; //validity
            $new_discount->cumulable_reduction = 1;
            $languages = Language::getLanguages();
            foreach ($languages as $language)
                $new_discount->description[$language['id_lang']] = "Buy1 Get1"; // coupon description
            
            $new_discount->add();
            $id_discount = Discount::getIdByName($new_discount->name);
            self::$cart->addDiscount($id_discount);
            
        }else if(!empty($b1g1DiscountInCart)){
            $b1g1DiscountInCart->value = (float) $discount; // coupon value
            if($b1g1DiscountInCart->value > 0)
                $b1g1DiscountInCart->update();
            else
                $b1g1DiscountInCart->delete();
        }


*/
        //end of buy1get1


         //pick3 pay2 
        $products = self::$cart->getProducts(true);
        $nP3P2Products = 0;
        
        // this is a very interesting array, keeps as many rows as there are items in your cart
        // if there is an item with quantity 2, it will have two rows in that array, 
        // ie item will have as many rows as the quantity of the item in cart.
        $p3p2products = array();
        foreach($products as $product) {   
            $productObj = new Product($product['id_product'], true);
            //$tags = $productObj->getTags(1);
            //if(in_array('buy1get1', $tags)){
                self::$smarty->assign("spl_voucher_message", "Pick 3 and Pay for 2 Offer");
                //counting the b1g1 products
                $nP3P2Products = $nP3P2Products + $product['cart_quantity'];
                
                //adding rows to interesting array $p3p2products
                for($q = 0; $q < $product['cart_quantity']; $q++){
                    array_push($p3p2products, $product);
                //}  
            }
        }


        
        //sorting products in ascending order of price
        usort($p3p2products, function($prod1, $prod2, $prod3 ){
            return $prod1['price'] - ($prod2['price'] + $prod3['price']) ;
        });

        $noP3P2AdvantageAvailable = (int)($nP3P2Products/3);
        print_r($noP3P2AdvantageAvailable);
        $discount = 0;
        for($p = 0; $p < $noP3P2AdvantageAvailable; $p++){
            $discount = $discount + $p3p2products[$p]['price'];
        }

        if((int)self::$cart->id_currency != 2){
            $discount = Tools::convertPrice($discount, (int)self::$cart->id_currency, false);
        }
        
        $discount = round($discount, 2);

        $p3p2DiscountInCart = null;
        $allCartDiscounts = self::$cart->getDiscounts();

        foreach ($allCartDiscounts as $cartDiscount) {
            if(strpos($cartDiscount['name'], 'P3P2') === 0){
                $p3p2DiscountInCart = new Discount((int) (Discount::getIdByName($cartDiscount['name'])));
            }
        }
        
    

        if($discount > 0 && empty($p3p2DiscountInCart)){
            $new_discount = new Discount();
            $new_discount->id_discount_type = 2;
            $new_discount->value = $discount; // coupon value
            $new_discount->name = "P3P2" . Tools::rand_string(5);
            $new_discount->id_currency = 2;
            $new_discount->quantity = 1;
            $new_discount->quantity_per_user = 100;
            $new_discount->date_from = date('Y-m-d H:i:s');
            $new_discount->date_to = '2015-09-10 20:00:00'; //validity
            $new_discount->cumulable_reduction = 1;
            $languages = Language::getLanguages();
            foreach ($languages as $language)
                $new_discount->description[$language['id_lang']] = "Pick3 Pay2"; // coupon description
            
            $new_discount->add();
            $id_discount = Discount::getIdByName($new_discount->name);
            self::$cart->addDiscount($id_discount);
            
        }else if(!empty($p3p2DiscountInCart)){
            $p3p2DiscountInCart->value = (float) $discount; // coupon value
            if($p3p2DiscountInCart->value > 0)
                $p3p2DiscountInCart->update();
            else
                $p3p2DiscountInCart->delete();
        }
    }

    public function adjustPoints() {
        $order_total = self::$cart->getOrderTotal(true, Cart::ONLY_PRODUCTS);
        $order_discounts = self::$cart->getOrderTotal(true, Cart::ONLY_DISCOUNTS);

        $total_with_discount = $order_total + $order_discounts;
        if ($total_with_discount >= 0)
            return;

        $cart_points = self::$cart->getPoints();
        $points_to_cash = Tools::getPointsToCash(self::$cart->id_currency);
        $points_to_delete = (int) ((int) $total_with_discount / $points_to_cash) * -1;
        self::$cart->deletePoints();
        self::$cart->addPoints($cart_points - $points_to_delete);
    }

    public function setMedia() {
        parent::setMedia();

        // Adding CSS style sheet
        //Tools::addCSS(_THEME_CSS_DIR_.'addresses.css');
        // Adding JS files
        //Tools::addJS(_THEME_JS_DIR_.'tools.js');
        /* if ((Configuration::get('PS_ORDER_PROCESS_TYPE') == 0 AND Tools::getValue('step') == 1) OR Configuration::get('PS_ORDER_PROCESS_TYPE') == 1)
          Tools::addJS(_THEME_JS_DIR_.'order-address.js');

          if ((int)(Configuration::get('PS_BLOCK_CART_AJAX')) OR Configuration::get('PS_ORDER_PROCESS_TYPE') == 1)
          {
          Tools::addJS(_THEME_JS_DIR_.'cart-summary.js');
          Tools::addJS(_PS_JS_DIR_.'jquery/jquery-typewatch.pack.js');
          }

          if(Tools::getValue('summary') == 1)
          {
          Tools::addJS(_THEME_JS_DIR_.'cart-summary.js');
          Tools::addJS(_PS_JS_DIR_.'jquery/jquery-typewatch.pack.js');
          }
         */
    }

    /**
     * @return boolean
     */
    protected function _checkFreeOrder() {
        if (self::$cart->getOrderTotal() <= 0) {
            $order = new FreeOrder();
            $order->free_order_class = true;
            $order->validateOrder((int) (self::$cart->id), _PS_OS_COD_PENDING_CONFIRMATION, 0, Tools::displayError('Free order', false));
            return (int) Order::getOrderByCartId((int) self::$cart->id);
        }
        return false;
    }

    protected function _updateMessage($messageContent) {
        if ($messageContent) {
            if (!Validate::isMessage($messageContent))
                $this->errors[] = Tools::displayError('Invalid message');
            elseif ($oldMessage = Message::getMessageByCartId((int) (self::$cart->id))) {
                $message = new Message((int) ($oldMessage['id_message']));
                $message->message = htmlentities($messageContent, ENT_COMPAT, 'UTF-8');
                $message->update();
            } else {
                $message = new Message();
                $message->message = htmlentities($messageContent, ENT_COMPAT, 'UTF-8');
                $message->id_cart = (int) (self::$cart->id);
                $message->id_customer = (int) (self::$cart->id_customer);
                $message->add();
            }
        } else {
            if ($oldMessage = Message::getMessageByCartId((int) (self::$cart->id))) {
                $message = new Message((int) ($oldMessage['id_message']));
                $message->delete();
            }
        }
        return true;
    }

    protected function _processCarrier() {
        self::$cart->recyclable = (int) (Tools::getValue('recyclable'));
        self::$cart->gift = (int) (Tools::getValue('gift'));
        if ((int) (Tools::getValue('gift'))) {
            if (!Validate::isMessage($_POST['gift_message']))
                $this->errors[] = Tools::displayError('Invalid gift message');
            else
                self::$cart->gift_message = strip_tags($_POST['gift_message']);
        }

        if (isset(self::$cookie->id_customer) AND self::$cookie->id_customer) {
            $address = new Address((int) (self::$cart->id_address_delivery));
            if (!($id_zone = Address::getZoneById($address->id)))
                $this->errors[] = Tools::displayError('No zone match with your address');
        }
        else
            $id_zone = Country::getIdZone((int) Configuration::get('PS_COUNTRY_DEFAULT'));

        $id_carrier = Tools::getValue('id_carrier');
        if (!$id_carrier)
            $id_carrier = self::$cart->id_carrier;

        if (Validate::isInt($id_carrier) AND sizeof(Carrier::checkCarrierZone((int) ($id_carrier), (int) ($id_zone)))) {
            self::$cart->id_carrier = (int) ($id_carrier);
        } elseif (!self::$cart->isVirtualCart() AND (int) (Tools::getValue('id_carrier')) == 0)
            $this->errors[] = Tools::displayError('Invalid carrier or no carrier selected');

        Module::hookExec('processCarrier', array('cart' => self::$cart));

        return self::$cart->update();
    }

    protected function _assignSummaryInformations() {
        global $currency;

        if (file_exists(_PS_SHIP_IMG_DIR_ . (int) (self::$cart->id_carrier) . '.jpg'))
            self::$smarty->assign('carrierPicture', 1);
        $summary = self::$cart->getSummaryDetails();
        $customizedDatas = Product::getAllCustomizedDatas((int) (self::$cart->id));

        // override customization tax rate with real tax (tax rules)
        foreach ($summary['products'] AS &$productUpdate) {
            $productId = (int) (isset($productUpdate['id_product']) ? $productUpdate['id_product'] : $productUpdate['product_id']);
            $productAttributeId = (int) (isset($productUpdate['id_product_attribute']) ? $productUpdate['id_product_attribute'] : $productUpdate['product_attribute_id']);

            if (isset($customizedDatas[$productId][$productAttributeId]))
                $productUpdate['tax_rate'] = Tax::getProductTaxRate($productId, self::$cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
        }

        Product::addCustomizationPrice($summary['products'], $customizedDatas);

        if ($free_ship = Tools::convertPrice((float) (Configuration::get('PS_SHIPPING_FREE_PRICE')), new Currency((int) (self::$cart->id_currency)))) {
            $discounts = self::$cart->getDiscounts();
            $total_free_ship = $free_ship - ($summary['total_products_wt'] + $summary['total_discounts']);
            foreach ($discounts as $discount)
                if ($discount['id_discount_type'] == 3 || $discount['id_discount_type'] == 5 || $discount['id_discount_type'] == 4) {
                    $total_free_ship = 0;
                    break;
                }
            self::$smarty->assign('free_ship', $total_free_ship);
        }
        // for compatibility with 1.2 themes
        foreach ($summary['products'] AS $key => $product)
            $summary['products'][$key]['quantity'] = $product['cart_quantity'];

        self::$smarty->assign($summary);
        self::$smarty->assign(array(
            'cart_points_discount' => self::$cart->getPointsDiscounts(),
            'cart_redeem_points' => self::$cart->getPoints(),
            'token_cart' => Tools::getToken(false),
            'isVirtualCart' => self::$cart->isVirtualCart(),
            'productNumber' => self::$cart->nbProducts(),
            'voucherAllowed' => Configuration::get('PS_VOUCHERS'),
            'shippingCost' => self::$cart->getOrderTotal(true, Cart::ONLY_SHIPPING),
            'shippingCostTaxExc' => self::$cart->getOrderTotal(false, Cart::ONLY_SHIPPING),
            'customizedDatas' => $customizedDatas,
            'CUSTOMIZE_FILE' => _CUSTOMIZE_FILE_,
            'CUSTOMIZE_TEXTFIELD' => _CUSTOMIZE_TEXTFIELD_,
            'lastProductAdded' => self::$cart->getLastProduct(),
            'displayVouchers' => Discount::getVouchersToCartDisplay((int) (self::$cookie->id_lang), (isset(self::$cookie->id_customer) ? (int) (self::$cookie->id_customer) : 0)),
            'currencySign' => $currency->sign,
            'currencyRate' => $currency->conversion_rate,
            'currencyFormat' => $currency->format,
            'currencyBlank' => $currency->blank));
        self::$smarty->assign(array(
            'HOOK_SHOPPING_CART' => Module::hookExec('shoppingCart', $summary),
            'HOOK_SHOPPING_CART_EXTRA' => Module::hookExec('shoppingCartExtra', $summary)
        ));
    }

    protected function _assignAddress() {
        //if guest checkout disabled and flag is_guest  in cookies is actived
        if (Configuration::get('PS_GUEST_CHECKOUT_ENABLED') == 0 AND ((int) self::$cookie->is_guest != Configuration::get('PS_GUEST_CHECKOUT_ENABLED'))) {
            self::$cookie->logout();
            Tools::redirect('');
        } elseif (!Customer::getAddressesTotalById((int) (self::$cookie->id_customer))) {
            //Tools::redirect('address.php?back=order.php?step=1');
            //self::$smarty->assign('no_address', 1);
        }
        $customer = new Customer((int) (self::$cookie->id_customer));

        if (Validate::isLoadedObject($customer)) {
            /* Getting customer addresses */
            $customerAddresses = $customer->getAddresses((int) (self::$cookie->id_lang));

            // Getting a list of formated address fields with associated values
            $formatedAddressFieldsValuesList = array();
            foreach ($customerAddresses as $address) {
                $tmpAddress = new Address($address['id_address']);

                $formatedAddressFieldsValuesList[$address['id_address']]['ordered_fields'] = AddressFormat::getOrderedAddressFields($address['id_country']);
                $formatedAddressFieldsValuesList[$address['id_address']]['formated_fields_values'] = AddressFormat::getFormattedAddressFieldsValues(
                                $tmpAddress, $formatedAddressFieldsValuesList[$address['id_address']]['ordered_fields']);

                unset($tmpAddress);
            }
            self::$smarty->assign(array(
                'addresses' => $customerAddresses,
                'formatedAddressFieldsValuesList' => $formatedAddressFieldsValuesList));

            /* Setting default addresses for cart */
            if ((!isset(self::$cart->id_address_delivery) OR empty(self::$cart->id_address_delivery)) AND sizeof($customerAddresses)) {
                self::$cart->id_address_delivery = (int) ($customerAddresses[0]['id_address']);
                $update = 1;
            }
            if ((!isset(self::$cart->id_address_invoice) OR empty(self::$cart->id_address_invoice)) AND sizeof($customerAddresses)) {
                self::$cart->id_address_invoice = (int) ($customerAddresses[0]['id_address']);
                $update = 1;
            }
            /* Update cart addresses only if needed */
            if (isset($update) AND $update)
                self::$cart->update();

            /* If delivery address is valid in cart, assign it to Smarty */
            if (isset(self::$cart->id_address_delivery)) {
                $deliveryAddress = new Address((int) (self::$cart->id_address_delivery));
                if ($deliveryAddress->id_state) {
                    $deliveryAddress->state = State::getNameById($deliveryAddress->id_state);
                }
                if (Validate::isLoadedObject($deliveryAddress) AND ($deliveryAddress->id_customer == $customer->id))
                    self::$smarty->assign('delivery', $deliveryAddress);
            }

            /* If invoice address is valid in cart, assign it to Smarty */
            if (isset(self::$cart->id_address_invoice)) {
                $invoiceAddress = new Address((int) (self::$cart->id_address_invoice));

                if ($invoiceAddress->id_state) {
                    $invoiceAddress->state = State::getNameById($invoiceAddress->id_state);
                }

                if (Validate::isLoadedObject($invoiceAddress) AND ($invoiceAddress->id_customer == $customer->id))
                    self::$smarty->assign('invoice', $invoiceAddress);
            }

            //assign countries
            $countries = Country::getCountries(1);
            $country_names = Country::getActiveCountries();
            self::$smarty->assign('countries', $countries);
            self::$smarty->assign('country_names', $country_names);

            if (isset(self::$cookie->id_country))
                $id_current_country = self::$cookie->id_country;
            else
                $id_current_country = Tools::getValue('id_country', (int) $customer->id_country);

            self::$smarty->assign('current_country', $id_current_country);

            //default to USA
            if (!$id_current_country)
                $id_current_country = 21;
            //assign states
            $country = new Country($id_current_country);
            if ($country->contains_states) {
                $stateData = State::getStatesByIdCountry($customer->id_country);
                self::$smarty->assign('states', $stateData);
            }
        }
        if ($oldMessage = Message::getMessageByCartId((int) (self::$cart->id)))
            self::$smarty->assign('oldMessage', $oldMessage['message']);

        //Assign token for new address
        self::$smarty->assign('token', Tools::getToken(false));
        self::$smarty->assign('id_carrier', self::$cart->id_carrier);
    }

    protected function _assignCarrier() {
        $customer = new Customer((int) (self::$cookie->id_customer));
        $address = new Address((int) (self::$cart->id_address_delivery));
        $id_zone = Address::getZoneById((int) ($address->id));
        $carriers = Carrier::getCarriersForOrder($id_zone, $customer->getGroups());

        self::$smarty->assign(array(
            'checked' => $this->_setDefaultCarrierSelection($carriers),
            'carriers' => $carriers,
            'default_carrier' => (int) (Configuration::get('PS_CARRIER_DEFAULT')),
            'HOOK_EXTRACARRIER' => Module::hookExec('extraCarrier', array('address' => $address)),
            'HOOK_BEFORECARRIER' => Module::hookExec('beforeCarrier', array('carriers' => $carriers))
        ));
    }

    protected function _assignWrappingAndTOS() {
        // Wrapping fees
        $wrapping_fees = (float) (Configuration::get('PS_GIFT_WRAPPING_PRICE'));
        $wrapping_fees_tax = new Tax((int) (Configuration::get('PS_GIFT_WRAPPING_TAX')));
        $wrapping_fees_tax_inc = $wrapping_fees * (1 + (((float) ($wrapping_fees_tax->rate) / 100)));

        // TOS
        $cms = new CMS((int) (Configuration::get('PS_CONDITIONS_CMS_ID')), (int) (self::$cookie->id_lang));
        $this->link_conditions = self::$link->getCMSLink($cms, $cms->link_rewrite, true);
        if (!strpos($this->link_conditions, '?'))
            $this->link_conditions .= '?content_only=1';
        else
            $this->link_conditions .= '&content_only=1';

        self::$smarty->assign(array(
            'checkedTOS' => (int) (self::$cookie->checkedTOS),
            'recyclablePackAllowed' => (int) (Configuration::get('PS_RECYCLABLE_PACK')),
            'giftAllowed' => (int) (Configuration::get('PS_GIFT_WRAPPING')),
            'cms_id' => (int) (Configuration::get('PS_CONDITIONS_CMS_ID')),
            'conditions' => (int) (Configuration::get('PS_CONDITIONS')),
            'link_conditions' => $this->link_conditions,
            'recyclable' => (int) (self::$cart->recyclable),
            'gift_wrapping_price' => (float) (Configuration::get('PS_GIFT_WRAPPING_PRICE')),
            'total_wrapping_cost' => Tools::convertPrice($wrapping_fees_tax_inc, new Currency((int) (self::$cookie->id_currency))),
            'total_wrapping_tax_exc_cost' => Tools::convertPrice($wrapping_fees, new Currency((int) (self::$cookie->id_currency)))));
    }

    protected function _assignPayment() {
        //$delivery_address = new Address((int)(self::$cart->id_address_delivery));
        //self::$smarty->assign('delivery_address', $address);
        self::$smarty->assign(array(
            'HOOK_TOP_PAYMENT' => Module::hookExec('paymentTop'),
            'HOOK_PAYMENT' => Module::hookExecPayment()
        ));
    }

    /**
     * Set id_carrier to 0 (no shipping price)
     *
     */
    protected function _setNoCarrier() {
        self::$cart->id_carrier = 0;
        self::$cart->update();
    }

    /**
     * Decides what the default carrier is and update the cart with it
     *
     * @param array $carriers
     * @return number the id of the default carrier
     */
    protected function _setDefaultCarrierSelection($carriers) {
        if (sizeof($carriers)) {
            $defaultCarrierIsPresent = false;
            if ((int) self::$cart->id_carrier != 0)
                foreach ($carriers AS $carrier)
                    if ($carrier['id_carrier'] == (int) self::$cart->id_carrier)
                        $defaultCarrierIsPresent = true;
            if (!$defaultCarrierIsPresent)
                foreach ($carriers AS $carrier)
                    if ($carrier['id_carrier'] == (int) Configuration::get('PS_CARRIER_DEFAULT')) {
                        $defaultCarrierIsPresent = true;
                        self::$cart->id_carrier = (int) $carrier['id_carrier'];
                    }
            if (!$defaultCarrierIsPresent)
                self::$cart->id_carrier = (int) $carriers[0]['id_carrier'];
        }
        else
            self::$cart->id_carrier = 0;
        if (self::$cart->update())
            return self::$cart->id_carrier;
        return 0;
    }

}

