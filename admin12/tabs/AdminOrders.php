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
*  @version  Release: $Revision: 7046 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class AdminOrders extends AdminTab
{
    public function __construct()
    {
        global $cookie;

         $this->table = 'order';
         $this->className = 'Order';
         $this->view = true;
        $this->colorOnBackground = true;
         $this->_select = '
            a.id_order AS id_pdf,
            CONCAT(LEFT(c.`firstname`, 1), \'. \', c.`lastname`) AS `customer`,
            cc.`iso_code` AS `iso_code`,
            osl.`name` AS `osname`,
            os.`color`,
            IF((SELECT COUNT(so.id_order) FROM `'._DB_PREFIX_.'orders` so WHERE so.id_customer = a.id_customer) > 1, 0, 1) as new,
            (SELECT COUNT(od.`id_order`) FROM `'._DB_PREFIX_.'order_detail` od WHERE od.`id_order` = a.`id_order` GROUP BY `id_order`) AS product_number';
         $this->_join = 'LEFT JOIN `'._DB_PREFIX_.'customer` c ON (c.`id_customer` = a.`id_customer`)
         LEFT JOIN `'._DB_PREFIX_.'order_history` oh ON (oh.`id_order` = a.`id_order`)
        LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = oh.`id_order_state`)
        LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = '.(int)($cookie->id_lang).')
        LEFT JOIN `'._DB_PREFIX_.'currency` cc  on (cc.`id_currency` = a.`id_currency`)';
        $this->_where = 'AND oh.`id_order_history` = (SELECT MAX(`id_order_history`) FROM `'._DB_PREFIX_.'order_history` moh WHERE moh.`id_order` = a.`id_order` GROUP BY moh.`id_order`)';

        $statesArray = array();
        $states = OrderState::getOrderStates((int)($cookie->id_lang));

        foreach ($states AS $state)
            $statesArray[$state['id_order_state']] = $state['name'];

        $currenciesArray = array();
        $currencies = Currency::getCurrencies(false,0);
        foreach($currencies as $currency)
            $currenciesArray[$currency['id_currency']] = $currency['iso_code'];

         $this->fieldsDisplay = array(
        'id_order' => array('title' => $this->l('ID'), 'align' => 'center', 'width' => 25),
        'new' => array('title' => $this->l('New'), 'width' => 25, 'align' => 'center', 'type' => 'bool', 'filter_key' => 'new', 'tmpTableFilter' => true, 'icon' => array(0 => 'blank.gif', 1 => 'news-new.gif'), 'orderby' => false),
        'customer' => array('title' => $this->l('Customer'), 'widthColumn' => 160, 'width' => 140, 'filter_key' => 'customer', 'tmpTableFilter' => true),
        'iso_code' => array('title' => $this->l('Currency'),'width' => 60,'align' => 'center', 'type' => 'select', 'select' => $currenciesArray, 'filter_key' => 'cc!id_currency', 'filter_type' => 'int'),
        'total_paid' => array('title' => $this->l('Total'), 'width' => 70, 'align' => 'right', 'prefix' => '<b>', 'suffix' => '</b>', 'price' => true, 'currency' => true),
        'payment' => array('title' => $this->l('Payment'), 'width' => 100),
        'osname' => array('title' => $this->l('Status'), 'widthColumn' => 230, 'type' => 'select', 'select' => $statesArray, 'filter_key' => 'os!id_order_state', 'filter_type' => 'int', 'width' => 200),
        'date_add' => array('title' => $this->l('Date'), 'width' => 35, 'align' => 'right', 'type' => 'datetime', 'filter_key' => 'a!date_add'),
        'id_pdf' => array('title' => $this->l('PDF'), 'callback' => 'printPDFIcons', 'orderby' => false, 'search' => false));
        parent::__construct();
    }

    /**
      * @global object $cookie Employee cookie necessary to keep trace of his/her actions
      */
    public function postProcess()
    {
        global $currentIndex, $cookie;

        /* Update shipping number */
        if (Tools::isSubmit('submitShippingNumber') AND ($id_order = (int)(Tools::getValue('id_order'))) AND Validate::isLoadedObject($order = new Order($id_order)))
        {
            if ($this->tabAccess['edit'] === '1')
            {
                if (!$order->hasBeenShipped())
                    die(Tools::displayError('The shipping number can only be set once the order has been shipped.'));
                $_GET['view'.$this->table] = true;

                $shipping_number = pSQL(Tools::getValue('shipping_number'));
                $order->shipping_number = $shipping_number;
                $order->update();
                if ($shipping_number)
                {
                    global $_LANGMAIL;
                    $customer = new Customer((int)($order->id_customer));
                    $carrier = new Carrier((int)($order->id_carrier));
                    if (!Validate::isLoadedObject($customer) OR !Validate::isLoadedObject($carrier))
                        die(Tools::displayError());
                    $templateVars = array(
                        '{order_amount}' => Tools::displayPrice($order->total_paid, $currency, false),
                        '{carrier_name}' => $carrier->name,
                        '{tracking_number}' => $order->shipping_number,
                        '{followup}' => str_replace('@', $order->shipping_number, $carrier->url),
                        '{firstname}' => $customer->firstname,
                        '{lastname}' => $customer->lastname,
                        '{id_order}' => (int)($order->id)
                    );
                    if(strpos($order->payment, 'COD') === false)
                        @Mail::Send((int)($order->id_lang), 'in_transit', Mail::l('Your order #'.$order->id.' with IndusDiva.com has been shipped'), $templateVars, $customer->email, $customer->firstname.' '.$customer->lastname);
                    else 
                        @Mail::Send((int)($order->id_lang), 'in_transit_cod', Mail::l('Your order #'.$order->id.' with IndusDiva.com has been shipped'), $templateVars, $customer->email, $customer->firstname.' '.$customer->lastname);
                
                    //Send SMS
                    $delivery = new Address((int)($order->id_address_delivery));
                    if(strpos($order->payment, 'COD') === false)
                        $smsText = 'Dear customer, your order #'.$order->id.' at IndusDiva.com has been shipped via '.$carrier->name.'. The airway bill no is '.$order->shipping_number.'. www.indusdiva.com';
                    else
                        $smsText = 'Dear customer, your order #'.$order->id.' at IndusDiva.com has been shipped. Carrier: '.$carrier->name.', AWB No. : '.$order->shipping_number.', Amount payable:'.Tools::displayPrice($order->total_paid, $currency, false).'. www.indusdiva.com';
                    Tools::sendSMS($delivery->phone_mobile, $smsText);
                }
            }
            else
                $this->_errors[] = Tools::displayError('You do not have permission to edit here.');
        }
        elseif(Tools::isSubmit('submitExpectedShippingDate') AND ($id_order = (int)(Tools::getValue('id_order'))) AND Validate::isLoadedObject($order = new Order($id_order)))
        {
            $dateshipping = new DateTime(Tools::getValue('expected_shipping_date'));
            $order->expected_shipping_date = pSQL($dateshipping->format('Y-m-d H:i:s'));
            $order->update();
            $order = new Order($id_order);
        }
        elseif (Tools::isSubmit('submitCarrier') AND ($id_order = (int)(Tools::getValue('id_order'))) AND Validate::isLoadedObject($order = new Order($id_order)))
        {
            $order->shipping_number = '';
            $order->id_carrier = ((int)Tools::getValue('id_carrier'));
            $order->update();
            $order = new Order($id_order);
        }

        /* Change order state, add a new entry in order history and send an e-mail to the customer if needed */
        elseif (Tools::isSubmit('submitState') AND ($id_order = (int)(Tools::getValue('id_order'))) AND Validate::isLoadedObject($order = new Order($id_order)))
        {
            if ($this->tabAccess['edit'] === '1')
            {
                $_GET['view'.$this->table] = true;
                if (!$newOrderStatusId = (int)(Tools::getValue('id_order_state')))
                    $this->_errors[] = Tools::displayError('Invalid new order status');
                else
                {
                    if($newOrderStatusId == _PS_OS_DELIVERED_ && strpos($order->payment, 'COD'))
                    {
                        $paymentHistory = new OrderPaymentHistory();
                        $paymentHistory->id_order = (int)$id_order;
                        $paymentHistory->id_employee = (int)($cookie->id_employee);
                        $paymentHistory->changeIdOrderPaymentState(_PS_PS_PAYMENT_WITH_CARRIER_, (int)$id_order);
                        $paymentHistory->addState();
                    }
                    
                    $history = new OrderHistory();
                    $history->id_order = (int)$id_order;
                    $history->id_employee = (int)($cookie->id_employee);
                    $history->changeIdOrderState((int)($newOrderStatusId), (int)($id_order));
                    $order = new Order((int)$order->id);
                    $carrier = new Carrier((int)($order->id_carrier), (int)($order->id_lang));
                    $templateVars = array();
                    if ($history->id_order_state == _PS_OS_SHIPPING_ AND $order->shipping_number)
                        $templateVars = array('{followup}' => str_replace('@', $order->shipping_number, $carrier->url));
                    elseif ($history->id_order_state == _PS_OS_CHEQUE_)
                        $templateVars = array(
                            '{cheque_name}' => (Configuration::get('CHEQUE_NAME') ? Configuration::get('CHEQUE_NAME') : ''),
                            '{cheque_address_html}' => (Configuration::get('CHEQUE_ADDRESS') ? nl2br(Configuration::get('CHEQUE_ADDRESS')) : ''));
                    elseif ($history->id_order_state == _PS_OS_BANKWIRE_)
                        $templateVars = array(
                            '{bankwire_owner}' => (Configuration::get('BANK_WIRE_OWNER') ? Configuration::get('BANK_WIRE_OWNER') : ''),
                            '{bankwire_details}' => (Configuration::get('BANK_WIRE_DETAILS') ? nl2br(Configuration::get('BANK_WIRE_DETAILS')) : ''),
                            '{bankwire_address}' => (Configuration::get('BANK_WIRE_ADDRESS') ? nl2br(Configuration::get('BANK_WIRE_ADDRESS')) : ''));
                    
                    if($history->id_order_state == _PS_OS_CANCELED_)
                        $this->cancelOrder($id_order);
                    
                    if ($history->addWithemail(true, $templateVars))
                        Tools::redirectAdmin($currentIndex.'&id_order='.$id_order.'&vieworder'.'&token='.$this->token);
                    
                    $this->_errors[] = Tools::displayError('An error occurred while changing the status or was unable to send e-mail to the customer.');
                    
                }
            }
            else
                $this->_errors[] = Tools::displayError('You do not have permission to edit here.');
        }

        /* Add a new message for the current order and send an e-mail to the customer if needed */
        elseif (isset($_POST['submitMessage']))
        {
            $_GET['view'.$this->table] = true;
             if ($this->tabAccess['edit'] === '1')
            {
                if (!($id_order = (int)(Tools::getValue('id_order'))) OR !($id_customer = (int)(Tools::getValue('id_customer'))))
                    $this->_errors[] = Tools::displayError('An error occurred before sending message');
                elseif (!Tools::getValue('message'))
                    $this->_errors[] = Tools::displayError('Message cannot be blank');
                else
                {
                    /* Get message rules and and check fields validity */
                    $rules = call_user_func(array('Message', 'getValidationRules'), 'Message');
                    foreach ($rules['required'] AS $field)
                        if (($value = Tools::getValue($field)) == false AND (string)$value != '0')
                            if (!Tools::getValue('id_'.$this->table) OR $field != 'passwd')
                                $this->_errors[] = Tools::displayError('field').' <b>'.$field.'</b> '.Tools::displayError('is required.');
                    foreach ($rules['size'] AS $field => $maxLength)
                        if (Tools::getValue($field) AND Tools::strlen(Tools::getValue($field)) > $maxLength)
                            $this->_errors[] = Tools::displayError('field').' <b>'.$field.'</b> '.Tools::displayError('is too long.').' ('.$maxLength.' '.Tools::displayError('chars max').')';
                    foreach ($rules['validate'] AS $field => $function)
                        if (Tools::getValue($field))
                            if (!Validate::$function(htmlentities(Tools::getValue($field), ENT_COMPAT, 'UTF-8')))
                                $this->_errors[] = Tools::displayError('field').' <b>'.$field.'</b> '.Tools::displayError('is invalid.');
                    if (!sizeof($this->_errors))
                    {
                        $message = new Message();
                        $message->id_employee = (int)($cookie->id_employee);
                        $message->message = htmlentities(Tools::getValue('message'), ENT_COMPAT, 'UTF-8');
                        $message->id_order = $id_order;
                        $message->private = Tools::getValue('visibility');
                        if (!$message->add())
                            $this->_errors[] = Tools::displayError('An error occurred while sending message.');
                        elseif ($message->private)
                            Tools::redirectAdmin($currentIndex.'&id_order='.$id_order.'&vieworder&conf=11'.'&token='.$this->token);
                        elseif (Validate::isLoadedObject($customer = new Customer($id_customer)))
                        {
                            $order = new Order((int)($message->id_order));
                            if (Validate::isLoadedObject($order))
                            {
                                $varsTpl = array('{lastname}' => $customer->lastname, '{firstname}' => $customer->firstname, '{id_order}' => $message->id_order, '{message}' => (Configuration::get('PS_MAIL_TYPE') == 2 ? $message->message : nl2br2($message->message)));
                                if (@Mail::Send((int)($order->id_lang), 'order_merchant_comment', Mail::l('New message regarding your order'), $varsTpl, $customer->email, $customer->firstname.' '.$customer->lastname))
                                    Tools::redirectAdmin($currentIndex.'&id_order='.$id_order.'&vieworder&conf=11'.'&token='.$this->token);
                            }
                        }
                        $this->_errors[] = Tools::displayError('An error occurred while sending e-mail to customer.');
                    }
                }
            }
            else
                $this->_errors[] = Tools::displayError('You do not have permission to delete here.');
        }

        /* Cancel product from order */
        elseif (Tools::isSubmit('cancelProduct') AND Validate::isLoadedObject($order = new Order((int)(Tools::getValue('id_order')))))
        {
             if ($this->tabAccess['delete'] === '1')
            {
                $productList = Tools::getValue('id_order_detail');
                $customizationList = Tools::getValue('id_customization');
                $qtyList = Tools::getValue('cancelQuantity');
                $customizationQtyList = Tools::getValue('cancelCustomizationQuantity');

                $full_product_list = $productList;
                $full_quantity_list = $qtyList;

                if ($customizationList)
                {
                    foreach ($customizationList as $key => $id_order_detail)
                    {
                        $full_product_list[$id_order_detail] = $id_order_detail;
                        $full_quantity_list[$id_order_detail] = $customizationQtyList[$key];
                    }
                }

                if ($productList OR $customizationList)
                {
                    if ($productList)
                    {
                        $id_cart = Cart::getCartIdByOrderId($order->id);
                        $customization_quantities = Customization::countQuantityByCart($id_cart);

                        foreach ($productList AS $key => $id_order_detail)
                        {
                            $qtyCancelProduct = abs($qtyList[$key]);
                            if (!$qtyCancelProduct)
                                $this->_errors[] = Tools::displayError('No quantity selected for product.');

                            // check actionable quantity
                            $order_detail = new OrderDetail($id_order_detail);
                            $customization_quantity = 0;
                            if (array_key_exists($order_detail->product_id, $customization_quantities) && array_key_exists($order_detail->product_attribute_id, $customization_quantities[$order_detail->product_id]))
                                $customization_quantity =  (int) $customization_quantities[$order_detail->product_id][$order_detail->product_attribute_id];

                            if (($order_detail->product_quantity - $customization_quantity - $order_detail->product_quantity_refunded - $order_detail->product_quantity_return) < $qtyCancelProduct)
                                $this->_errors[] = Tools::displayError('Invalid quantity selected for product.');

                        }
                    }
                    if ($customizationList)
                    {
                        $customization_quantities = Customization::retrieveQuantitiesFromIds(array_keys($customizationList));

                        foreach ($customizationList AS $id_customization => $id_order_detail)
                        {
                            $qtyCancelProduct = abs($customizationQtyList[$id_customization]);
                            $customization_quantity = $customization_quantities[$id_customization];

                            if (!$qtyCancelProduct)
                                $this->_errors[] = Tools::displayError('No quantity selected for product.');

                            if ($qtyCancelProduct > ($customization_quantity['quantity'] - ($customization_quantity['quantity_refunded'] + $customization_quantity['quantity_returned'])))
                                $this->_errors[] = Tools::displayError('Invalid quantity selected for product.');
                        }
                    }

                    if (!sizeof($this->_errors) AND $productList)
                        foreach ($productList AS $key => $id_order_detail)
                        {
                            $qtyCancelProduct = abs($qtyList[$key]);
                            $orderDetail = new OrderDetail((int)($id_order_detail));

                            // Reinject product
                            if (!$order->hasBeenDelivered() OR ($order->hasBeenDelivered() AND Tools::isSubmit('reinjectQuantities')))
                            {
                                $reinjectableQuantity = (int)($orderDetail->product_quantity) - (int)($orderDetail->product_quantity_reinjected);
                                $quantityToReinject = $qtyCancelProduct > $reinjectableQuantity ? $reinjectableQuantity : $qtyCancelProduct;
                                if (!Product::reinjectQuantities($orderDetail, $quantityToReinject))
                                    $this->_errors[] = Tools::displayError('Cannot re-stock product').' <span class="bold">'.$orderDetail->product_name.'</span>';
                                else
                                {
                                    $updProductAttributeID = !empty($orderDetail->product_attribute_id) ? (int)($orderDetail->product_attribute_id) : NULL;
                                    $newProductQty = Product::getQuantity((int)($orderDetail->product_id), $updProductAttributeID);
                                    $product = get_object_vars(new Product((int)($orderDetail->product_id), false, (int)($cookie->id_lang)));
                                    if (!empty($orderDetail->product_attribute_id))
                                    {
                                        $updProduct['quantity_attribute'] = (int)($newProductQty);
                                        $product['quantity_attribute'] = $updProduct['quantity_attribute'];
                                    }
                                    else
                                    {
                                        $updProduct['stock_quantity'] = (int)($newProductQty);
                                        $product['stock_quantity'] = $updProduct['stock_quantity'];
                                    }
                                    Hook::updateQuantity($product, $order);
                                }
                            }

                            // Delete product
                            if (!$order->deleteProduct($order, $orderDetail, $qtyCancelProduct))
                                $this->_errors[] = Tools::displayError('An error occurred during deletion of the product.').' <span class="bold">'.$orderDetail->product_name.'</span>';
                            Module::hookExec('cancelProduct', array('order' => $order, 'id_order_detail' => $id_order_detail));
                        }
                    if (!sizeof($this->_errors) AND $customizationList)
                        foreach ($customizationList AS $id_customization => $id_order_detail)
                        {
                            $orderDetail = new OrderDetail((int)($id_order_detail));
                            $qtyCancelProduct = abs($customizationQtyList[$id_customization]);
                            if (!$order->deleteCustomization($id_customization, $qtyCancelProduct, $orderDetail))
                                $this->_errors[] = Tools::displayError('An error occurred during deletion of product customization.').' '.$id_customization;
                        }
                    // E-mail params
                    if ((isset($_POST['generateCreditSlip']) OR isset($_POST['generateDiscount'])) AND !sizeof($this->_errors))
                    {
                        $customer = new Customer((int)($order->id_customer));
                        $params['{lastname}'] = $customer->lastname;
                        $params['{firstname}'] = $customer->firstname;
                        $params['{id_order}'] = $order->id;
                    }

                    // Generate credit slip
                    if (isset($_POST['generateCreditSlip']) AND !sizeof($this->_errors))
                    {
                        if (!OrderSlip::createOrderSlip($order, $full_product_list, $full_quantity_list, isset($_POST['shippingBack'])))
                            $this->_errors[] = Tools::displayError('Cannot generate credit slip');
                        else
                        {
                            Module::hookExec('orderSlip', array('order' => $order, 'productList' => $full_product_list, 'qtyList' => $full_quantity_list));
                            @Mail::Send((int)($order->id_lang), 'credit_slip', Mail::l('New credit slip regarding your order'), $params, $customer->email, $customer->firstname.' '.$customer->lastname);
                        }
                    }

                    // Generate voucher
                    if (isset($_POST['generateDiscount']) AND !sizeof($this->_errors))
                    {
                        if (!$voucher = Discount::createOrderDiscount($order, $full_product_list, $full_quantity_list, $this->l('Credit Slip concerning the order #'), isset($_POST['shippingBack'])))
                            $this->_errors[] = Tools::displayError('Cannot generate voucher');
                        else
                        {
                            $currency = new Currency(Configuration::get('PS_CURRENCY_DEFAULT'));
                            $params['{voucher_amount}'] = Tools::displayPrice($voucher->value, $currency, false);
                            $params['{voucher_num}'] = $voucher->name;
                            @Mail::Send((int)($order->id_lang), 'voucher', Mail::l('New voucher regarding your order'), $params, $customer->email, $customer->firstname.' '.$customer->lastname);
                        }
                    }
                }
                else
                    $this->_errors[] = Tools::displayError('No product or quantity selected.');

                // Redirect if no errors
                if (!sizeof($this->_errors))
                    Tools::redirectAdmin($currentIndex.'&id_order='.$order->id.'&vieworder&conf=24&token='.$this->token);
            }
            else
                $this->_errors[] = Tools::displayError('You do not have permission to delete here.');
        }
        elseif(Tools::isSubmit('updateOrder') AND Validate::isLoadedObject($order = new Order((int)(Tools::getValue('id_order')))))
        {
            $cart = Cart::getCartByOrderId($order->id);
            $update = false;
            if($discountValue = Tools::getValue('addDiscount'))
            {
                $discountVoucher = new Discount();
                $discountVoucher->name = 'ADMIND-'. $order->id . date('mdHis');
                $discountVoucher->id_discount_type = 2;
                $discountVoucher->id_customer = $order->id_customer;
                $discountVoucher->cumulable = 1;
                $discountVoucher->cumulable_reduction = 1;
                $discountVoucher->date_from = $order->date_add;
                $discountVoucher->date_to = date('Y-m-d', time()+86400);
                $discountVoucher->quantity = 1;
                $discountVoucher->quantity_per_user = 1;
                $discountVoucher->value = (float)$discountValue;
                $discountVoucher->minimal = 0;
                $discountVoucher->id_currency = 4;
                $discountVoucher->behavior_not_exhausted = 1;
                $discountVoucher->add(true);
            
                $cart->addDiscount($discountVoucher->id);
                $order->addDiscount($discountVoucher->id, $discountVoucher->name, $discountVoucher->value);
                $cart->update();
                $update = true;
            }
            
            //waive shipping, create a free shipping voucher, apply, reload the order object
            if(Tools::getValue('waiveShipping'))
            {
                $freeShipVoucher = new Discount();
                $freeShipVoucher->name = 'ADMINFS-'. $order->id . date('mdHis');
                $freeShipVoucher->id_discount_type = 3;
                $freeShipVoucher->id_customer = $order->id_customer;
                $freeShipVoucher->cumulable = 1;
                $freeShipVoucher->cumulable_reduction = 1;
                $freeShipVoucher->date_from = $order->date_add;
                $freeShipVoucher->date_to = date('Y-m-d', time()+86400);
                $freeShipVoucher->quantity = 0;
                $freeShipVoucher->quantity_per_user = 1;
                $freeShipVoucher->value = 0;
                $freeShipVoucher->add(true);
                
                $cart->addDiscount($freeShipVoucher->id);
                $order->addDiscount($freeShipVoucher->id, $freeShipVoucher->name, $freeShipVoucher->value);
                $cart->update();
                $update = true;
            }
            $id_product = false;
            if($id_product = Tools::getValue('addProductID'))
            {
                $product = new Product((int)$id_product, true, (int)($cookie->id_lang));
                if($product->quantity > 0 && $product->available_for_order)
                    $cart->updateQty(1, $id_product);
                
                $orderDetail = null;
                $db = Db::getInstance();
                $res = $db->getRow('select id_order_detail from ps_order_detail where id_order = ' . $order->id .' and product_id = ' . $id_product);
                
                $vat_address = new Address((int)($order->id_address_delivery));
                $customer = new Customer((int)($order->id_customer));
                $unitPrice = Product::getPriceStatic((int)$id_product, true, NULL, 2, NULL, false, true, 1, false, (int)$order->id_customer, NULL, (int)$order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
                
                if($res)
                {
                    $orderDetail = new OrderDetail($res['id_order_detail']);
                    $orderDetail->product_quantity = $orderDetail->product_quantity + 1;
                }
                else
                {
                    $productName = $product->name;
                    $orderDetail = new OrderDetail();
                    $orderDetail->product_quantity = 1;
                    $orderDetail->id_order = $order->id;
                    $orderDetail->product_id = $id_product;
                    $orderDetail->product_name = $productName;
                    $orderDetail->product_ean13 = $product->ean13;
                    $price = Product::getPriceStatic($id_product, false,  NULL, 6, NULL, false, true, $orderDetail->product_quantity, false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
                    $price_wt = Product::getPriceStatic((int)$id_product, true,  NULL, 2, NULL, false, true, $orderDetail->product_quantity, false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
                    
                    $tax_rate = Tax::getProductTaxRate((int)($id_product), $cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
                    
                    $specificPrice = 0;
                    $quantityDiscount = SpecificPrice::getQuantityDiscount((int)$id_product, Shop::getCurrentShop(), (int)$cart->id_currency, (int)$vat_address->id_country, (int)$customer->id_default_group, $orderDetail->product_quantity);
                    $orderDetail->product_price = (float)(Product::getPriceStatic((int)($id_product), false, NULL, (Product::getTaxCalculationMethod((int)($order->id_customer)) == PS_TAX_EXC ? 2 : 6), NULL, false, false, $orderDetail->product_quantity, false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}), $specificPrice, FALSE));
                    $orderDetail->product_quantity_discount = $quantityDiscount ? ((Product::getTaxCalculationMethod((int)$order->id_customer) == PS_TAX_EXC ? Tools::ps_round($unitPrice, 2) : $unitPrice) - $quantityDiscount['price'] * (1 + $tax_rate / 100)) : 0.00;
                    $orderDetail->reduction_percent = (float)(($specificPrice AND $specificPrice['reduction_type'] == 'percentage') ? $specificPrice['reduction'] * 100 : 0.00);
                    $orderDetail->reduction_percent = (float)(($specificPrice AND $specificPrice['reduction_type'] == 'amount') ? (!$specificPrice['id_currency'] ? Tools::convertPrice($specificPrice['reduction'], $order->id_currency) : $specificPrice['reduction']) : 0.00);
                    $orderDetail->tax_rate = $tax_rate;
                    $orderDetail->tax_name = 'default_tax';
                    $orderDetail->group_reduction = 0;
                    $orderDetail->product_quantity_in_stock = (int)(Product::getQuantity((int)($id_product), NULL));
                    $orderDetail->product_quantity_refunded = 0;
                    $orderDetail->product_quantity_reinjected = 0;
                    $orderDetail->ecotax = 0;
                    $orderDetail->ecotax_tax_rate = 0;
                    $orderDetail->discount_quantity_applied = 0;
                    $orderDetail->add(true, true);
                }
                
                $price = Product::getPriceStatic($id_product, false,  NULL, 6, NULL, false, true, $orderDetail->product_quantity, false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
                $price_wt = Product::getPriceStatic((int)$id_product, true,  NULL, 2, NULL, false, true, $orderDetail->product_quantity, false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
                
                $tax_rate = Tax::getProductTaxRate((int)($id_product), $cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
                
                $quantityDiscount = SpecificPrice::getQuantityDiscount((int)$id_product, Shop::getCurrentShop(), (int)$cart->id_currency, (int)$vat_address->id_country, (int)$customer->id_default_group, $orderDetail->product_quantity);
                $orderDetail->product_price = (float)(Product::getPriceStatic((int)($id_product), false, NULL, (Product::getTaxCalculationMethod((int)($order->id_customer)) == PS_TAX_EXC ? 2 : 6), NULL, false, false, $orderDetail->product_quantity, false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}), $specificPrice, FALSE));
                $orderDetail->product_quantity_discount = $quantityDiscount ? ((Product::getTaxCalculationMethod((int)$order->id_customer) == PS_TAX_EXC ? Tools::ps_round($unitPrice, 2) : $unitPrice) - $quantityDiscount['price'] * (1 + $tax_rate / 100)) : 0.00;
                $orderDetail->reduction_percent = (float)(($specificPrice AND $specificPrice['reduction_type'] == 'percentage') ? $specificPrice['reduction'] * 100 : 0.00);
                $orderDetail->reduction_amount = (float)(($specificPrice AND $specificPrice['reduction_type'] == 'amount') ? (!$specificPrice['id_currency'] ? Tools::convertPrice($specificPrice['reduction'], $order->id_currency) : $specificPrice['reduction']) : 0.00);
                $orderDetail->update();
                
                $product->addStockMvt(-1, _STOCK_MOVEMENT_ORDER_REASON_, NULL, $order->id, (int)($cookie->id_employee));
                
                $update = true;
            }
            
            if($update)
            { 
                //Recalculate product prices with and without tax from order detail
                $detailIds = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
                        SELECT id_order_detail
                        FROM `'._DB_PREFIX_.'order_detail` od
                        WHERE od.`id_order` = '.(int)($order->id));
                
                $totalProducts = 0.00;
                $totalProductsWT = 0.00;
                
                foreach($detailIds as $id)
                {
                    $reduction_amount = 0.00;
                    $orderDetail = new OrderDetail($id['id_order_detail']);
                    $price = $orderDetail->product_price * (1 + $orderDetail->tax_rate * 0.01);
                
                    if ($orderDetail->reduction_percent != 0.00)
                        $reduction_amount = $price * $orderDetail->reduction_percent / 100;
                    elseif ($orderDetail->reduction_amount != 0.00)
                    $reduction_amount = Tools::ps_round($orderDetail->reduction_amount, 2);
                    if (isset($reduction_amount) AND $reduction_amount)
                        $price = Tools::ps_round($price - $reduction_amount, 2);
                
                    $productPriceWithoutTax = $price / (1 + $orderDetail->tax_rate * 0.01);
                
                    //Update order
                    $totalProducts += ($orderDetail->product_quantity * $productPriceWithoutTax);
                    $totalProductsWT += ($orderDetail->product_quantity * $price);
                }
                
                $order->total_products = Tools::ps_round($totalProducts, 2);
                $order->total_products_wt = Tools::ps_round($totalProductsWT, 2);
                
                $order->total_shipping = $cart->getOrderShippingCost();
                //$order->total_products = $cart->getOrderTotal(false, Cart::ONLY_PRODUCTS);
                $order->total_discounts = abs($cart->getOrderTotal(true, Cart::ONLY_DISCOUNTS));
                $order->total_paid = $order->total_products_wt + $order->total_shipping - $order->total_discounts + $order->total_cod;
                $order->total_paid_real = $order->total_products_wt + $order->total_shipping - $order->total_discounts + $order->total_cod;
                //$order->total_products_wt = (float)($cart->getOrderTotal(true, Cart::ONLY_PRODUCTS));
                $order->update();
            }
            
            // Redirect if no errors
            if (!sizeof($this->_errors))
                Tools::redirectAdmin($currentIndex.'&id_order='.$order->id.'&vieworder&conf=24&token='.$this->token);
        }
        elseif (isset($_GET['messageReaded']))
        {
            Message::markAsReaded((int)($_GET['messageReaded']), (int)($cookie->id_employee));
        }
        parent::postProcess();
    }
    
    private function cancelOrder($id_order)
    {
        $order = new Order($id_order);
        $orderDetails = $order->getProductsDetail();
        //$orderDetails = $order->get
        foreach ($orderDetails as $order_product)
        {
            $orderDetail = new OrderDetail((int)($order_product['id_order_detail']));
        
            // Reinject product
            if (!$order->hasBeenDelivered())
            {
                $reinjectableQuantity = (int)($orderDetail->product_quantity) - (int)($orderDetail->product_quantity_reinjected);
                $quantityToReinject = $reinjectableQuantity;
                if (!Product::reinjectQuantities($orderDetail, $quantityToReinject))
                    $this->_errors[] = Tools::displayError('Cannot re-stock product').' <span class="bold">'.$orderDetail->product_name.'</span>';
            }
        
            Module::hookExec('cancelProduct', array('order' => $order, 'id_order_detail' => $order_product['id_order_detail']));
        }
    }

    private function displayCustomizedDatas(&$customizedDatas, &$product, &$currency, &$image, $tokenCatalog, $id_order_detail)
    {
        if (!($order = $this->loadObject()))
            return;

        if (is_array($customizedDatas) AND isset($customizedDatas[(int)($product['product_id'])][(int)($product['product_attribute_id'])]))
        {
            $imageObj = new Image($image['id_image']);
            echo '
            <tr>
                <td align="center">'.(isset($image['id_image']) ? cacheImage(_PS_IMG_DIR_.'p/'.$imageObj->getExistingImgPath().'.jpg',
                'product_mini_'.(int)($product['product_id']).(isset($product['product_attribute_id']) ? '_'.(int)($product['product_attribute_id']) : '').'.jpg', 45, 'jpg') : '--').'</td>
                <td><a href="index.php?tab=AdminCatalog&id_product='.$product['product_id'].'&updateproduct&token='.$tokenCatalog.'">
                    <span class="productName">'.$product['product_name'].' - '.$this->l('customized').'</span><br />
                    '.($product['product_reference'] ? $this->l('Ref:').' '.$product['product_reference'].'<br />' : '')
                    .($product['product_supplier_reference'] ? $this->l('Ref Supplier:').' '.$product['product_supplier_reference'] : '')
                    .'</a></td>
                <td align="center">'.Tools::displayPrice($product['product_price_wt'], $currency, false).'</td>
                <td align="center" class="productQuantity">'.$product['customizationQuantityTotal'].'</td>
                '.($order->hasBeenPaid() ? '<td align="center" class="productQuantity">'.$product['customizationQuantityRefunded'].'</td>' : '').'
                '.($order->hasBeenDelivered() ? '<td align="center" class="productQuantity">'.$product['customizationQuantityReturned'].'</td>' : '').'
                <td align="center" class="productQuantity"> - </td>
                <td align="center">'.Tools::displayPrice(Tools::ps_round($order->getTaxCalculationMethod() == PS_TAX_EXC ? $product['product_price'] : $product['product_price_wt'], 2) * $product['customizationQuantityTotal'], $currency, false).'</td>
                <td align="center" class="cancelCheck">--</td>
            </tr>';
            foreach ($customizedDatas[(int)($product['product_id'])][(int)($product['product_attribute_id'])] AS $customizationId => $customization)
            {
                echo '
                <tr>
                    <td colspan="2">';
                foreach ($customization['datas'] AS $type => $datas)
                    if ($type == _CUSTOMIZE_FILE_)
                    {
                        $i = 0;
                        echo '<ul style="margin: 4px 0px 4px 0px; padding: 0px; list-style-type: none;">';
                        foreach ($datas AS $data)
                            echo '<li style="display: inline; margin: 2px;">
                                    <a href="displayImage.php?img='.$data['value'].'&name='.(int)($order->id).'-file'.++$i.'" target="_blank"><img src="'._THEME_PROD_PIC_DIR_.$data['value'].'_small" alt="" /></a>
                                </li>';
                        echo '</ul>';
                    }
                    elseif ($type == _CUSTOMIZE_TEXTFIELD_)
                    {
                        $i = 0;
                        echo '<ul style="margin: 0px 0px 4px 0px; padding: 0px 0px 0px 6px; list-style-type: none;">';
                        foreach ($datas AS $data)
                        {
                            if( isset($data['customer_height']) && !empty($data['customer_height']) ) {
                                echo "<li> Customer's height : ".$data['customer_height']."</li>";
                            }
                            if($data['index'] == 1)
                            {
                                echo '<li>Pre-stitched saree.</li>';
                                echo '<li>Stitched Inskirt. Measurement: <a href="OMS.php?getMeasurement=1&id_measurement=' . $customization["inskirt_measurement_id"] . '&type=2">' . $customization["inskirt_measurement"]. '</a>, Style: ' . $customization["inskirt_style_name"] . '</li>';
                                echo '<li>With Fall/Piko work.</li>';
                            }
                            else if($data['index'] == 2) {
                                echo '<li>Stitched Blouse. Measurement: <a href="OMS.php?getMeasurement=1&id_measurement=' . $customization["blouse_measurement_id"] . '&type=1">' . $customization["blouse_measurement"]. '</a>, Style: ' . $customization["blouse_style_name"]. '</li>';
                                if( $customization['fall_piko'] == 1 )
                                    echo '<li>With Fall/Piko work</li>';
                                else
                                    echo '<li>Without Fall/Piko work</li>';
                            }
                            else if($data['index'] == 3) {
                                echo '<li>Stitched Inskirt. Measurement: <a href="OMS.php?getMeasurement=1&id_measurement=' . $customization["inskirt_measurement_id"] . '&type=2">' . $customization["inskirt_measurement"]. '</a>, Style: ' . $customization["inskirt_style_name"] . '</li>';
                                if( $customization['fall_piko'] == 1 )
                                    echo '<li>With Fall/Piko work</li>';
                                else
                                    echo '<li>Without Fall/Piko work</li>';
                            }
                            else if($data['index'] == 4)
                            {
                                echo '<li>Stitched Kurta. Measurement: <a href="OMS.php?getMeasurement=1&id_measurement=' . $customization["kurta_measurement_id"] . '&type=3">' . $customization["kurta_measurement"] . '</a></li>';
                                echo '<li>Stitched Salwar. Measurement: <a href="OMS.php?getMeasurement=1&id_measurement=' . $customization["salwar_measurement_id"] . '&type=4">' . $customization["salwar_measurement"] . '</a></li>';
                            }
                            else if($data['index'] == 5)
                            {
                                echo '<li>Stitched Lehenga choli</li>';
                                echo '<li>Lehenga Measurement: <a href="OMS.php?getMeasurement=1&id_measurement=' . $customization["lehenga_measurement_id"] . '&type=2">' . $customization["lehenga_measurement"] . '</a>, Style: ' . $customization["lehenga_style_name"] . '</li>';
                                echo '<li>Choli Measurement: <a href="OMS.php?getMeasurement=1&id_measurement=' . $customization["choli_measurement_id"] . '&type=1">' . $customization["choli_measurement"] . '</a>, Style: ' . $customization["choli_style_name"] . '</li>';
                            }
                            else if($data['index'] == 9)
                                echo '<li>Garment fabric</li>';
                            else if($data['index'] == 8) {
                                echo '<li>Standard saree</li>';
                                if( $customization['fall_piko'] == 1 )
                                    echo '<li>With Fall/Piko work</li>';
                                else
                                    echo '<li>Without Fall/Piko work</li>';
                            }
                            else if($data['index'] == 13)
                            {
                                echo '<li>Choli Style: ' . $customization["choli_style"] . '</li>';
                                echo '<li>Choli Size: ' . $customization["choli_size"] . '</li>';
                            }
                            else if($data['index'] == 10)
                                echo '<li>+ Long Choli</li>';
                            else if($data['index'] == 11)
                                echo '<li>+ Long Sleeves</li>';
                            else if($data['index'] == 24)
                            {
                                if( isset($customization["kurta_measurement"]) && !empty($customization["kurta_measurement"]) )
                                    echo '<li>Stitched Kurta. Measurement: <a href="OMS.php?getMeasurement=1&id_measurement=' . $customization["kurta_measurement_id"] . '&type=3">' . $customization["kurta_measurement"] . '</a>, Style: ' . $customization["kurta_style_name"] . '</li>';
                                if( isset($customization["salwar_measurement"]) && !empty($customization["salwar_measurement"]) )
                                    echo '<li>Stitched Salwar. Measurement: <a href="OMS.php?getMeasurement=1&id_measurement=' . $customization["salwar_measurement_id"] . '&type=4">' . $customization["salwar_measurement"] . '</a>, Style: ' . $customization["salwar_style_name"] . '</li>';
                            } else if($data['index'] == 21) {
                                if( isset($customization["friends_name"]) && !empty($customization["friends_name"]) )
                                    echo "<li>Name : ".$customization["friends_name"]."</li>";
                            } else if($data['index'] == 22) {
                                if( isset($customization["friends_email"]) && !empty($customization["friends_email"]) )
                                    echo "<li>Email : ".$customization["friends_email"]."</li>";
                            } else if($data['index'] == 23) {
                                if( isset($customization["gift_message"]) && !empty($customization["gift_message"]) )
                                    echo "<li>Message : ".$customization["gift_message"]."</li>";
                            } else if($data['index'] == 25) {
                                if( isset($customization["voucher_code"]) && !empty($customization["voucher_code"]) )
                                    echo "<li>Voucher Code : ".$customization["voucher_code"]."</li>";
                            }
                        }
                        echo '</ul>';
                    }
                echo '</td>
                    <td align="center">-</td>
                    <td align="center" class="productQuantity">'.$customization['quantity'].'</td>
                    '.($order->hasBeenPaid() ? '<td align="center">'.$customization['quantity_refunded'].'</td>' : '').'
                    '.($order->hasBeenDelivered() ? '<td align="center">'.$customization['quantity_returned'].'</td>' : '').'
                    <td align="center">-</td>
                    <td align="center">'.Tools::displayPrice(Tools::ps_round($order->getTaxCalculationMethod() == PS_TAX_EXC ? $product['product_price'] : $product['product_price_wt'], 2) * $customization['quantity'], $currency, false).'</td>
                    <td align="center" class="cancelCheck">
                        <input type="hidden" name="totalQtyReturn" id="totalQtyReturn" value="'.(int)($customization['quantity_returned']).'" />
                        <input type="hidden" name="totalQty" id="totalQty" value="'.(int)($customization['quantity']).'" />
                        <input type="hidden" name="productName" id="productName" value="'.$product['product_name'].'" />';
                if ((!$order->hasBeenDelivered() OR Configuration::get('PS_ORDER_RETURN')) AND (int)(($customization['quantity_returned']) < (int)($customization['quantity'])))
                    echo '
                        <input type="checkbox" name="id_customization['.$customizationId.']" id="id_customization['.$customizationId.']" value="'.$id_order_detail.'" onchange="setCancelQuantity(this, \''.$customizationId.'\', \''.$customization['quantity'].'\')" '.(((int)($customization['quantity_returned'] + $customization['quantity_refunded']) >= (int)($customization['quantity'])) ? 'disabled="disabled" ' : '').'/>';
                else
                    echo '--';
                echo '
                    </td>
                    <td class="cancelQuantity">';
                if ((int)($customization['quantity_returned'] + $customization['quantity_refunded']) >= (int)($customization['quantity']))
                    echo '<input type="hidden" name="cancelCustomizationQuantity['.$customizationId.']" value="0" />';
                elseif (!$order->hasBeenDelivered() OR Configuration::get('PS_ORDER_RETURN'))
                    echo '
                        <input type="text" id="cancelQuantity_'.$customizationId.'" name="cancelCustomizationQuantity['.$customizationId.']" size="2" onclick="selectCheckbox(this);" value="" /> ';
                echo ($order->hasBeenDelivered() ? (int)($customization['quantity_returned']).'/'.((int)($customization['quantity']) - (int)($customization['quantity_refunded'])) : ($order->hasBeenPaid() ? (int)($customization['quantity_refunded']).'/'.(int)($customization['quantity']) : '')).'
                    </td>';
                echo '
                </tr>';
            }
        }
    }

    private function getCancelledProductNumber(&$order, &$product)
    {
        $productQuantity = array_key_exists('customizationQuantityTotal', $product) ? $product['product_quantity'] - $product['customizationQuantityTotal'] : $product['product_quantity'];
        $productRefunded = $product['product_quantity_refunded'];
        $productReturned = $product['product_quantity_return'];
        $content = '0/'.$productQuantity;
        if ($order->hasBeenDelivered())
            $content = $productReturned.'/'.($productQuantity - $productRefunded);
        elseif ($order->hasBeenPaid())
            $content = $productRefunded.'/'.$productQuantity;
        return $content;
    }

    public function viewDetails()
    {
        global $currentIndex, $cookie, $link;
        $irow = 0;
        if (!($order = $this->loadObject()))
            return;

        $customer = new Customer($order->id_customer);
        $customerStats = $customer->getStats();
        $addressInvoice = new Address($order->id_address_invoice, (int)($cookie->id_lang));
        if (Validate::isLoadedObject($addressInvoice) AND $addressInvoice->id_state)
            $invoiceState = new State((int)($addressInvoice->id_state));
        $addressDelivery = new Address($order->id_address_delivery, (int)($cookie->id_lang));
        if (Validate::isLoadedObject($addressDelivery) AND $addressDelivery->id_state)
            $deliveryState = new State((int)($addressDelivery->id_state));
        $carrier = new Carrier($order->id_carrier);
        $history = $order->getHistory($cookie->id_lang);
        $products = $order->getProducts();
        $customizedDatas = Product::getAllCustomizedDatas((int)($order->id_cart));
        Product::addCustomizationPrice($products, $customizedDatas);
        $discounts = $order->getDiscounts();
        $messages = Message::getMessagesByOrderId($order->id, true);
        $states = OrderState::getOrderStates((int)($cookie->id_lang));
        $currency = new Currency($order->id_currency);
        $currentLanguage = new Language((int)($cookie->id_lang));
        $currentState = OrderHistory::getLastOrderState($order->id);
        $sources = ConnectionsSource::getOrderSources($order->id);
        $cart = Cart::getCartByOrderId($order->id);

        $row = array_shift($history);

        if ($prevOrder = Db::getInstance()->getValue('SELECT id_order FROM '._DB_PREFIX_.'orders WHERE id_order < '.(int)$order->id.' ORDER BY id_order DESC'))
            $prevOrder = '<a href="'.$currentIndex.'&token='.Tools::getValue('token').'&vieworder&id_order='.$prevOrder.'"><img style="width:24px;height:24px" src="../img/admin/arrow-left.png" /></a>';
        if ($nextOrder = Db::getInstance()->getValue('SELECT id_order FROM '._DB_PREFIX_.'orders WHERE id_order > '.(int)$order->id.' ORDER BY id_order ASC'))
            $nextOrder = '<a href="'.$currentIndex.'&token='.Tools::getValue('token').'&vieworder&id_order='.$nextOrder.'"><img style="width:24px;height:24px" src="../img/admin/arrow-right.png" /></a>';


        if ($order->total_paid != $order->total_paid_real)
            echo '<center><span class="warning" style="font-size: 16px">'.$this->l('Warning:').' '.Tools::displayPrice($order->total_paid_real, $currency, false).' '.$this->l('paid instead of').' '.Tools::displayPrice($order->total_paid, $currency, false).' !</span></center><div class="clear"><br /><br /></div>';

        // display bar code if module enabled
        $hook = Module::hookExec('invoice', array('id_order' => $order->id));
        if ($hook !== false)
        {
            echo '<div style="float: right; margin: -40px 40px 10px 0;">';
            echo $hook;
            echo '</div><br class="clear" />';
        }

        if (sizeof($messages))
        {
            echo '<h2 style="padding:10px;background:#FF9292;color:#A60000">Alert: There are messages in this order! </h2>';
        }
        // display order header
        echo '
        <div style="float:left" style="width:440px">';
        echo '<h2>
                '.$prevOrder.'
                '.(Validate::isLoadedObject($customer) ? $customer->firstname.' '.$customer->lastname.' - ' : '').$this->l('Order #').sprintf('%06d', $order->id).'
                '.$nextOrder.'
            </h2>
            <div style="width:429px">
                '.((($currentState->invoice OR $order->invoice_number) AND count($products))
                    ? '<a href="pdf.php?id_order='.$order->id.'&pdf"><img src="../img/admin/charged_ok.gif" alt="'.$this->l('View invoice').'" /> '.$this->l('View invoice').'</a>'
                    : '<img src="../img/admin/charged_ko.gif" alt="'.$this->l('No invoice').'" /> '.$this->l('No invoice')).' -
                '.(($currentState->delivery OR $order->delivery_number)
                    ? '<a href="pdf.php?id_delivery='.$order->delivery_number.'"><img src="../img/admin/delivery.gif" alt="'.$this->l('View delivery slip').'" /> '.$this->l('View delivery slip').'</a>'
                    : '<img src="../img/admin/delivery_ko.gif" alt="'.$this->l('No delivery slip').'" /> '.$this->l('No delivery slip')).' -
                <a href="javascript:window.print()"><img src="../img/admin/printer.gif" alt="'.$this->l('Print order').'" title="'.$this->l('Print order').'" /> '.$this->l('Print page').'</a>
            </div>
            <div class="clear">&nbsp;</div>';

        /* Display current status */
        echo '
            <table cellspacing="0" cellpadding="0" class="table" style="width: 429px">
                <tr>
                    <th>'.Tools::displayDate($row['date_add'], (int)($cookie->id_lang), true).'</th>
                    <th><img src="../img/os/'.$row['id_order_state'].'.gif" /></th>
                    <th>'.stripslashes($row['ostate_name']).'</th>
                    <th>'.((!empty($row['employee_lastname'])) ? '('.stripslashes(Tools::substr($row['employee_firstname'], 0, 1)).'. '.stripslashes($row['employee_lastname']).')' : '').'</th>
                </tr>';
            /* Display previous status */
            foreach ($history AS $row)
            {
                echo '
                <tr class="'.($irow++ % 2 ? 'alt_row' : '').'">
                    <td>'.Tools::displayDate($row['date_add'], (int)($cookie->id_lang), true).'</td>
                    <td><img src="../img/os/'.$row['id_order_state'].'.gif" /></td>
                    <td>'.stripslashes($row['ostate_name']).'</td>
                    <td>'.((!empty($row['employee_lastname'])) ? '('.stripslashes(Tools::substr($row['employee_firstname'], 0, 1)).'. '.stripslashes($row['employee_lastname']).')' : '').'</td>
                </tr>';
            }
        echo '
            </table>
            <br />';

        /* Display status form */
        echo '
            <form action="'.$currentIndex.'&view'.$this->table.'&token='.$this->token.'" method="post" style="text-align:center;">
                <select name="id_order_state">';
        $currentStateTab = $order->getCurrentStateFull($cookie->id_lang);
        foreach ($states AS $state)
            echo '<option value="'.$state['id_order_state'].'"'.(($state['id_order_state'] == $currentStateTab['id_order_state']) ? ' selected="selected"' : '').'>'.stripslashes($state['name']).'</option>';
        echo '
                </select>
                <input type="hidden" name="id_order" value="'.$order->id.'" />
                <input type="submit" name="submitState" value="'.$this->l('Change').'" class="button" />
            </form>';

        /* Display customer information */
        if (Validate::isLoadedObject($customer))
        {
            echo '<br />
            <fieldset style="width: 400px">
                <legend><img src="../img/admin/tab-customers.gif" /> '.$this->l('Customer information').'</legend>
                <span style="font-weight: bold; font-size: 14px;"><a href="?tab=AdminCustomers&id_customer='.$customer->id.'&viewcustomer&token='.Tools::getAdminToken('AdminCustomers'.(int)(Tab::getIdFromClassName('AdminCustomers')).(int)($cookie->id_employee)).'"> '.$customer->firstname.' '.$customer->lastname.'</a></span> ('.$this->l('#').$customer->id.')<br />
                (<a href="mailto:'.$customer->email.'">'.$customer->email.'</a>)<br /><br />';
            if ($customer->isGuest())
            {
                echo '
                '.$this->l('This order has been placed by a').' <b>'.$this->l('guest').'</b>';
                if(!Customer::customerExists($customer->email))
                {
                    echo '<form method="POST" action="index.php?tab=AdminCustomers&id_customer='.(int)$customer->id.'&token='.Tools::getAdminTokenLite('AdminCustomers').'">
                        <input type="hidden" name="id_lang" value="'.(int)$order->id_lang.'" />
                        <p class="center"><input class="button" type="submit" name="submitGuestToCustomer" value="'.$this->l('Transform to customer').'" /></p>
                        '.$this->l('This feature will generate a random password and send an e-mail to the customer').'
                    </form>';
                }
                else
                    echo '<div><b style="color:red;">'.$this->l('A registered customer account exists with the same email address').'</b></div>';
            }
            else
            {
                echo $this->l('Account registered:').' '.Tools::displayDate($customer->date_add, (int)($cookie->id_lang), true).'<br />
                '.$this->l('Valid orders placed:').' <b>'.$customerStats['nb_orders'].'</b><br />
                '.$this->l('Total paid since registration:').' <b>'.Tools::displayPrice(Tools::ps_round(Tools::convertPrice($customerStats['total_orders'], $currency), 2), $currency, false).'</b><br />';
            }
            echo '</fieldset>';
        }

        /* Display sources */
        if (sizeof($sources))
        {
            echo '<br />
            <fieldset style="width: 400px;"><legend><img src="../img/admin/tab-stats.gif" /> '.$this->l('Sources').'</legend><ul '.(sizeof($sources) > 3 ? 'style="overflow-y: scroll; height: 200px"' : '').'>';
            foreach ($sources as $source)
                echo '<li>
                        '.Tools::displayDate($source['date_add'], (int)($cookie->id_lang), true).'<br />
                        <b>'.$this->l('From:').'</b> <a href="'.$source['http_referer'].'">'.preg_replace('/^www./', '', parse_url($source['http_referer'], PHP_URL_HOST)).'</a><br />
                        <b>'.$this->l('To:').'</b> '.$source['request_uri'].'<br />
                        '.($source['keywords'] ? '<b>'.$this->l('Keywords:').'</b> '.$source['keywords'].'<br />' : '').'<br />
                    </li>';
            echo '</ul></fieldset>';
        }
        // display hook specified to this page : AdminOrder
        if (($hook = Module::hookExec('adminOrder', array('id_order' => $order->id))) !== false)
            echo $hook;

        echo '
        </div>
        <div style="float: left; margin-left: 40px">';

        /* Display invoice information */
        echo '<fieldset style="width: 400px">';
        if (($currentState->invoice OR $order->invoice_number) AND count($products))
            echo '<legend><a href="pdf.php?id_order='.$order->id.'&pdf"><img src="../img/admin/charged_ok.gif" /> '.$this->l('Invoice').'</a></legend>
                <a href="pdf.php?id_order='.$order->id.'&pdf">'.$this->l('Invoice #').'<b>'.Configuration::get('PS_INVOICE_PREFIX', (int)($cookie->id_lang)).sprintf('%06d', $order->invoice_number).'</b></a>
                <br />'.$this->l('Created on:').' '.Tools::displayDate($order->invoice_date, (int)$cookie->id_lang, true);
        else
            echo '<legend><img src="../img/admin/charged_ko.gif" />'.$this->l('Invoice').'</legend>
                '.$this->l('No invoice yet.');
        echo '</fieldset><br />';
        
        /* Display expected shipping information */
        echo '
        <fieldset style="width:400px">
        <legend><img src="../img/admin/delivery.gif" /> '.$this->l('Expected Shipping Date').'</legend>
        '.$this->l('Expected date of shipping:').' <b>'.Tools::displayDate($order->expected_shipping_date,(int)$cookie->id_lang, true).'</b><br />'.
        'Original Date of shipping: <b>'.Tools::displayDate($order->actual_expected_shipping_date,(int)$cookie->id_lang, true).'</b><br />';
        
        /* Display shipping number field */
        echo '
            <form action="'.$currentIndex.'&view'.$this->table.'&token='.$this->token.'" method="post" style="margin-top:10px;">
            <input type="text" id="expected_shipping_date" name="expected_shipping_date" value="'. $order->shipping_number.'" />
            <input type="hidden" name="id_order" value="'.$order->id.'" />
            <input type="submit" name="submitExpectedShippingDate" value="'.$this->l('Set expected shipping date').'" class="button" />
            </form>';
        
        
        echo '
        <script type="text/javascript" src="../js/jquery/jquery-ui-1.8.10.custom.min.js"></script>
        <script type="text/javascript">
            $(function() {
            $("#expected_shipping_date").datepicker({
                prevText:"",
                nextText:"",
                dateFormat:"yy-mm-dd"});
            });
        </script>
        </fieldset>';

        /* Display shipping infos */
        echo '
        <fieldset style="width:400px">
            <legend><img src="../img/admin/delivery.gif" /> '.$this->l('Shipping information').'</legend>
            '.$this->l('Total weight:').' <b>'.number_format($order->getTotalWeight(), 3).' '.Configuration::get('PS_WEIGHT_UNIT').'</b><br />
            '.$this->l('Carrier:').' <b>'.($carrier->name == '0' ? Configuration::get('PS_SHOP_NAME') : $carrier->name).'</b><br />
            '.(($currentState->delivery OR $order->delivery_number) ? '<br /><a href="pdf.php?id_delivery='.$order->delivery_number.'">'.$this->l('Delivery slip #').'<b>'.Configuration::get('PS_DELIVERY_PREFIX', (int)($cookie->id_lang)).sprintf('%06d', $order->delivery_number).'</b></a><br />' : '');
            if ($order->shipping_number)
                echo $this->l('Tracking number:').' <b>'.$order->shipping_number.'</b> '.(!empty($carrier->url) ? '(<a href="'.str_replace('@', $order->shipping_number, $carrier->url).'" target="_blank">'.$this->l('Track the shipment').'</a>)' : '');

            /* Carrier module */
            if ($carrier->is_module == 1)
            {
                $module = Module::getInstanceByName($carrier->external_module_name);
                if (method_exists($module, 'displayInfoByCart'))
                    echo call_user_func(array($module, 'displayInfoByCart'), $order->id_cart);
            }

            /* Display shipping number field */
            if ($carrier->url && $order->hasBeenShipped())
             echo '
                <form action="'.$currentIndex.'&view'.$this->table.'&token='.$this->token.'" method="post" style="margin-top:10px;">
                    <input type="text" name="shipping_number" value="'. $order->shipping_number.'" />
                    <input type="hidden" name="id_order" value="'.$order->id.'" />
                    <input type="submit" name="submitShippingNumber" value="'.$this->l('Set shipping number').'" class="button" />
                </form>';
             
             /* Display carrier field */
             
             echo '
                <form action="'.$currentIndex.'&view'.$this->table.'&token='.$this->token.'" method="post" style="margin-top:10px;">
                    <select name="id_carrier">';
            $carriers = array();
            $op = $cod = false;
            Carrier::getPreferredCarriers($addressDelivery->id_country, $carriers);
            
            $orderCarriers = false;
            if(strpos($order->payment, 'COD') === false)
                $orderCarriers = $carriers['service'];
            else 
                $orderCarriers = $carriers['cod'];
            foreach($orderCarriers as $cid)
            {
                if($cid == UPS)
                    echo '<option value="'.UPS.'" '.(($order->id_carrier == UPS) ? 'selected="selected"' : '').' >UPS</option>';
                if($cid == ARAMEX)
                    echo '<option value="'.ARAMEX.'" '.(($order->id_carrier == ARAMEX) ? 'selected="selected"' : '').' >Aramex</option>';
                if($cid == FEDEX)
                    echo '<option value="'.FEDEX.'" '.(($order->id_carrier == FEDEX) ? 'selected="selected"' : '').' >Fedex</option>';
                if($cid == BLUEDART)
                    echo '<option value="'.BLUEDART.'" '.(($order->id_carrier == BLUEDART) ? 'selected="selected"' : '').' >BlueDart</option>';
            }
                    
            echo'
                    </select>
                    <input type="hidden" name="id_order" value="'.$order->id.'" />
                    <input type="submit" name="submitCarrier" value="'.$this->l('Set Carrier').'" class="button" />
                </form>';
            echo '
        </fieldset>';

        /* Display summary order */
        echo '
        <br />
        <fieldset style="width: 400px">
            <legend><img src="../img/admin/details.gif" /> '.$this->l('Order details').'</legend>
            <label>'.$this->l('Original cart:').' </label>
            <div style="margin: 2px 0 1em 190px;"><a href="?tab=AdminCarts&id_cart='.$cart->id.'&viewcart&token='.Tools::getAdminToken('AdminCarts'.(int)(Tab::getIdFromClassName('AdminCarts')).(int)($cookie->id_employee)).'">'.$this->l('Cart #').sprintf('%06d', $cart->id).'</a></div>
            <label>'.$this->l('Payment mode:').' </label>
            <div style="margin: 2px 0 1em 190px;">'.Tools::substr($order->payment, 0, 32).' '.($order->module ? '('.$order->module.')' : '').'</div>
            <div style="margin: 2px 0 1em 50px;">
                <table class="table" width="300px;" cellspacing="0" cellpadding="0">
                    <tr><td width="150px;">'.$this->l('Products').'</td><td align="right">'.Tools::displayPrice($order->getTotalProductsWithTaxes(), $currency, false).'</td></tr>
                    '.($order->total_discounts > 0 ? '<tr><td>'.$this->l('Discounts').'</td><td align="right">-'.Tools::displayPrice($order->total_discounts, $currency, false).'</td></tr>' : '').'
                    '.($order->total_wrapping > 0 ? '<tr><td>'.$this->l('Wrapping').'</td><td align="right">'.Tools::displayPrice($order->total_wrapping, $currency, false).'</td></tr>' : '').'
                    <tr><td>'.$this->l('Shipping').'</td><td align="right">'.Tools::displayPrice($order->total_shipping, $currency, false).'</td></tr>
                    <tr><td>'.$this->l('COD Charge').'</td><td align="right">'.Tools::displayPrice($order->total_cod, $currency, false).'</td></tr>
                    <tr><td style="font-size:18px; color:red">'.$this->l('Donation Amount').'</td><td align="right">'.Tools::displayPrice($order->total_donation, $currency, false).'</td></tr>
                    <tr style="font-size: 20px"><td>'.$this->l('Total').'</td><td align="right">'.Tools::displayPrice($order->total_paid, $currency, false).($order->total_paid != $order->total_paid_real ? '<br /><font color="red">('.$this->l('Paid:').' '.Tools::displayPrice($order->total_paid_real, $currency, false, false).')</font>' : '').'</td></tr>
                </table>
            </div>
            <div style="float: left; margin-right: 10px; margin-left: 42px;">
                <span class="bold">'.$this->l('Recycled package:').'</span>
                '.($order->recyclable ? '<img src="../img/admin/enabled.gif" />' : '<img src="../img/admin/disabled.gif" />').'
            </div>
            <div style="float: left; margin-right: 10px;">
                <span class="bold">'.$this->l('Gift wrapping:').'</span>
                 '.($order->gift ? '<img src="../img/admin/enabled.gif" />
            </div>
            <div style="clear: left; margin: 0px 42px 0px 42px; padding-top: 2px;">
                '.(!empty($order->gift_message) ? '<div style="border: 1px dashed #999; padding: 5px; margin-top: 8px;"><b>'.$this->l('Message:').'</b><br />'.nl2br2($order->gift_message).'</div>' : '') : '<img src="../img/admin/disabled.gif" />').'
            </div>
        </fieldset>';

        echo '</div>
        <div class="clear">&nbsp;</div>';

        /* Display adresses : delivery & invoice */
        echo '<div class="clear">&nbsp;</div>
        <div style="float: left">
            <fieldset style="width: 400px;">
                <legend><img src="../img/admin/delivery.gif" alt="'.$this->l('Shipping address').'" />'.$this->l('Shipping address').'</legend>
                <div style="float: right">
                    <a href="?tab=AdminAddresses&id_address='.$addressDelivery->id.'&addaddress&realedit=1&id_order='.$order->id.($addressDelivery->id == $addressInvoice->id ? '&address_type=1' : '').'&token='.Tools::getAdminToken('AdminAddresses'.(int)(Tab::getIdFromClassName('AdminAddresses')).(int)($cookie->id_employee)).'&back='.urlencode($_SERVER['REQUEST_URI']).'"><img src="../img/admin/edit.gif" /></a>
                    <a href="http://maps.google.com/maps?f=q&hl='.$currentLanguage->iso_code.'&geocode=&q='.$addressDelivery->address1.' '.$addressDelivery->postcode.' '.$addressDelivery->city.($addressDelivery->id_state ? ' '.$deliveryState->name: '').'" target="_blank"><img src="../img/admin/google.gif" alt="" class="middle" /></a>
                </div>
                '.$this->displayAddressDetail($addressDelivery)
                .(!empty($addressDelivery->other) ? '<hr />'.$addressDelivery->other.'<br />' : '')
            .'</fieldset>
        </div>
        <div style="float: left; margin-left: 40px">
            <fieldset style="width: 400px;">
                <legend><img src="../img/admin/invoice.gif" alt="'.$this->l('Invoice address').'" />'.$this->l('Invoice address').'</legend>
                <div style="float: right"><a href="?tab=AdminAddresses&id_address='.$addressInvoice->id.'&addaddress&realedit=1&id_order='.$order->id.($addressDelivery->id == $addressInvoice->id ? '&address_type=2' : '').'&back='.urlencode($_SERVER['REQUEST_URI']).'&token='.Tools::getAdminToken('AdminAddresses'.(int)(Tab::getIdFromClassName('AdminAddresses')).(int)($cookie->id_employee)).'"><img src="../img/admin/edit.gif" /></a></div>
                '.$this->displayAddressDetail($addressInvoice)
                .(!empty($addressInvoice->other) ? '<hr />'.$addressInvoice->other.'<br />' : '')

            .'</fieldset>
        </div>
        <div class="clear">&nbsp;</div>';

        // List of products
        echo '
        <a name="products"><br /></a>
        <form action="'.$currentIndex.'&submitCreditSlip&vieworder&token='.$this->token.'" method="post" onsubmit="return orderDeleteProduct(\''.$this->l('Cannot return this product').'\', \''.$this->l('Quantity to cancel is greater than quantity available').'\');">
            <input type="hidden" name="id_order" value="'.$order->id.'" />
            <fieldset style="width: 868px; ">
                <legend><img src="../img/admin/cart.gif" alt="'.$this->l('Products').'" />'.$this->l('Products').'</legend>
                <div style="float:left;">
                    <p style="color:red">Special Instructions: '.$cart->gift_message.'</p>
                    <table style="width: 868px;" cellspacing="0" cellpadding="0" class="table" id="orderProducts">
                        <tr>
                            <th align="center" style="width: 60px">&nbsp;</th>
                            <th>'.$this->l('Product').'</th>
                            <th style="width: 80px; text-align: center">'.$this->l('UP').' <sup>*</sup></th>
                            <th style="width: 20px; text-align: center">'.$this->l('Qty').'</th>
                            '.($order->hasBeenPaid() ? '<th style="width: 20px; text-align: center">'.$this->l('Refunded').'</th>' : '').'
                            '.($order->hasBeenDelivered() ? '<th style="width: 20px; text-align: center">'.$this->l('Returned').'</th>' : '').'
                            <th style="width: 30px; text-align: center">'.$this->l('Stock').'</th>
                            <th style="width: 90px; text-align: center">'.$this->l('Total').' <sup>*</sup></th>
                            <th colspan="2" style="width: 120px;"><img src="../img/admin/delete.gif" alt="'.$this->l('Products').'" /> '.($order->hasBeenDelivered() ? $this->l('Return') : ($order->hasBeenPaid() ? $this->l('Refund') : $this->l('Cancel'))).'</th>';
        echo '
                        </tr>';
                        $tokenCatalog = Tools::getAdminToken('AdminCatalog'.(int)(Tab::getIdFromClassName('AdminCatalog')).(int)($cookie->id_employee));
                        foreach ($products as $k => $product)
                        {
                            if ($order->getTaxCalculationMethod() == PS_TAX_EXC)
                                $product_price = $product['product_price'] + $product['ecotax'];
                            else
                                $product_price = $product['product_price_wt'];

                            $image = array();
                            if (isset($product['product_attribute_id']) AND (int)($product['product_attribute_id']))
                                $image = Db::getInstance()->getRow('
                                SELECT id_image
                                FROM '._DB_PREFIX_.'product_attribute_image
                                WHERE id_product_attribute = '.(int)($product['product_attribute_id']));
                             if (!isset($image['id_image']) OR !$image['id_image'])
                                $image = Db::getInstance()->getRow('
                                SELECT id_image
                                FROM '._DB_PREFIX_.'image
                                WHERE id_product = '.(int)($product['product_id']).' AND cover = 1');
                             $stock = Db::getInstance()->getRow('
                            SELECT '.($product['product_attribute_id'] ? 'pa' : 'p').'.quantity
                            FROM '._DB_PREFIX_.'product p
                            '.($product['product_attribute_id'] ? 'LEFT JOIN '._DB_PREFIX_.'product_attribute pa ON p.id_product = pa.id_product' : '').'
                            WHERE p.id_product = '.(int)($product['product_id']).'
                            '.($product['product_attribute_id'] ? 'AND pa.id_product_attribute = '.(int)($product['product_attribute_id']) : ''));
                            if (isset($image['id_image']))
                            {
                                $target = _PS_TMP_IMG_DIR_.'product_mini_'.(int)($product['product_id']).(isset($product['product_attribute_id']) ? '_'.(int)($product['product_attribute_id']) : '').'.jpg';
                                if (file_exists($target))
                                    $products[$k]['image_size'] = getimagesize($target);
                            }
                            // Customization display
                            $this->displayCustomizedDatas($customizedDatas, $product, $currency, $image, $tokenCatalog, $k);

                            // Normal display
                            if ($product['product_quantity'] > $product['customizationQuantityTotal'])
                            {
                                $imageObj = new Image($image['id_image']);
                                echo '
                                <tr'.((isset($image['id_image']) AND isset($products[$k]['image_size'])) ? ' height="'.($products[$k]['image_size'][1] + 7).'"' : '').'>
                                    <td align="center">'.(isset($image['id_image']) ? cacheImage(_PS_IMG_DIR_.'p/'.$imageObj->getExistingImgPath().'.jpg',
                                    'product_mini_'.(int)($product['product_id']).(isset($product['product_attribute_id']) ? '_'.(int)($product['product_attribute_id']) : '').'.jpg', 45, 'jpg') : '--').'</td>
                                    <td><a href="index.php?tab=AdminCatalog&id_product='.$product['product_id'].'&updateproduct&token='.$tokenCatalog.'">
                                        <span class="productName">'.$product['product_name'].'</span><br />
                                        '.($product['product_reference'] ? $this->l('Ref:').' '.$product['product_reference'].'<br />' : '')
                                        .($product['product_supplier_reference'] ? $this->l('Ref Supplier:').' '.$product['product_supplier_reference'] : '')
                                        .'</a></td>
                                    <td align="center">'.Tools::displayPrice($product_price, $currency, false).'</td>
                                    <td align="center" class="productQuantity">'.((int)($product['product_quantity']) - $product['customizationQuantityTotal']).'</td>
                                    '.($order->hasBeenPaid() ? '<td align="center" class="productQuantity">'.(int)($product['product_quantity_refunded']).'</td>' : '').'
                                    '.($order->hasBeenDelivered() ? '<td align="center" class="productQuantity">'.(int)($product['product_quantity_return']).'</td>' : '').'
                                    <td align="center" class="productQuantity">'.(int)($stock['quantity']).'</td>
                                    <td align="center">'.Tools::displayPrice(Tools::ps_round($product_price, 2) * ((int)($product['product_quantity']) - $product['customizationQuantityTotal']), $currency, false).'</td>
                                    <td align="center" class="cancelCheck">
                                        <input type="hidden" name="totalQtyReturn" id="totalQtyReturn" value="'.(int)($product['product_quantity_return']).'" />
                                        <input type="hidden" name="totalQty" id="totalQty" value="'.(int)($product['product_quantity']).'" />
                                        <input type="hidden" name="productName" id="productName" value="'.$product['product_name'].'" />';
                                if ((!$order->hasBeenDelivered() OR Configuration::get('PS_ORDER_RETURN')) AND (int)($product['product_quantity_return']) < (int)($product['product_quantity']))
                                    echo '
                                        <input type="checkbox" name="id_order_detail['.$k.']" id="id_order_detail['.$k.']" value="'.$product['id_order_detail'].'" onchange="setCancelQuantity(this, '.(int)($product['id_order_detail']).', '.(int)($product['product_quantity_in_stock'] - $product['customizationQuantityTotal'] - $product['product_quantity_reinjected']).')" '.(((int)($product['product_quantity_return'] + $product['product_quantity_refunded']) >= (int)($product['product_quantity'])) ? 'disabled="disabled" ' : '').'/>';
                                else
                                    echo '--';
                                echo '
                                    </td>
                                    <td class="cancelQuantity">';
                                if ((int)($product['product_quantity_return'] + $product['product_quantity_refunded']) >= (int)($product['product_quantity']))
                                    echo '<input type="hidden" name="cancelQuantity['.$k.']" value="0" />';
                                elseif (!$order->hasBeenDelivered() OR Configuration::get('PS_ORDER_RETURN'))
                                    echo '
                                        <input type="text" id="cancelQuantity_'.(int)($product['id_order_detail']).'" name="cancelQuantity['.$k.']" size="2" onclick="selectCheckbox(this);" value="" /> ';
                                echo $this->getCancelledProductNumber($order, $product).'
                                    </td>
                                </tr>';
                            }
                        }
                    echo '
                    </table>
                    <div style="float:left; width:450px; margin-top:15px;"><sup>*</sup> '.$this->l('According to the group of this customer, prices are printed:').' '.($order->getTaxCalculationMethod() == PS_TAX_EXC ? $this->l('tax excluded.') : $this->l('tax included.')).(!Configuration::get('PS_ORDER_RETURN') ? '<br /><br />'.$this->l('Merchandise returns are disabled') : '').'</div>';
                    if (sizeof($discounts))
                    {
                        echo '
                    <div style="float:right; width:280px; margin-top:15px;">
                    <table cellspacing="0" cellpadding="0" class="table" style="width:100%;">
                        <tr>
                            <th><img src="../img/admin/coupon.gif" alt="'.$this->l('Discounts').'" />'.$this->l('Discount name').'</th>
                            <th align="center" style="width: 100px">'.$this->l('Value').'</th>
                        </tr>';
                        foreach ($discounts as $discount)
                            echo '
                        <tr>
                            <td>'.$discount['name'].'</td>
                            <td align="center">'.($discount['value'] != 0.00 ? '- ' : '').Tools::displayPrice($discount['value'], $currency, false).'</td>
                        </tr>';
                        echo '
                    </table></div>';
                    }
                echo '
                </div>';

                // Cancel product
                echo '
                <div style="clear:both; height:15px;">&nbsp;</div>
                <div style="float: right; width: 160px;">';
                if ($order->hasBeenDelivered() AND Configuration::get('PS_ORDER_RETURN'))
                    echo '
                    <input type="checkbox" id="reinjectQuantities" name="reinjectQuantities" class="button" />&nbsp;<label for="reinjectQuantities" style="float:none; font-weight:normal;">'.$this->l('Re-stock products').'</label><br />';
                if ((!$order->hasBeenDelivered() AND $order->hasBeenPaid()) OR ($order->hasBeenDelivered() AND Configuration::get('PS_ORDER_RETURN')))
                    echo '
                    <input type="checkbox" id="generateCreditSlip" name="generateCreditSlip" class="button" onclick="toogleShippingCost(this)" />&nbsp;<label for="generateCreditSlip" style="float:none; font-weight:normal;">'.$this->l('Generate a credit slip').'</label><br />
                    <input type="checkbox" id="generateDiscount" name="generateDiscount" class="button" onclick="toogleShippingCost(this)" />&nbsp;<label for="generateDiscount" style="float:none; font-weight:normal;">'.$this->l('Generate a voucher').'</label><br />
                    <span id="spanShippingBack" style="display:none;"><input type="checkbox" id="shippingBack" name="shippingBack" class="button" />&nbsp;<label for="shippingBack" style="float:none; font-weight:normal;">'.$this->l('Repay shipping costs').'</label><br /></span>';
                if (!$order->hasBeenDelivered() OR ($order->hasBeenDelivered() AND Configuration::get('PS_ORDER_RETURN')))
                    echo '
                    <div style="text-align:center; margin-top:5px;"><input type="submit" name="cancelProduct" value="'.($order->hasBeenDelivered() ? $this->l('Return products') : ($order->hasBeenPaid() ? $this->l('Refund products') : $this->l('Cancel products'))).'" class="button" style="margin-top:8px;" /></div>';
                echo '
                </div>';
            echo '
            </fieldset>';
        
        $employee = new Employee((int)$cookie->id_employee);
        //Add Order update form if not delivered or returned
        if ($employee->id_profile == 1 && ((!$order->hasBeenDelivered()) OR ($order->hasBeenDelivered() AND Configuration::get('PS_ORDER_RETURN'))))
        {
            echo'
        
            <fieldset style="width: 868px;margin-top:10px;">
                <legend><img src="../img/admin/cart.gif" alt="'.$this->l('Update Order').'" />'.$this->l('Update Order').'</legend>
                <div style="float:left;">';
                     if($order->total_shipping > 0)
                        echo '<p><input type="checkbox" id="waiveShipping" name="waiveShipping" class="button" />&nbsp;<label for="waiveShipping" style="float:none; font-weight:normal;">'.$this->l('Waive Shipping').'</label></p>';
                     echo '
                        <p><label style="float:none; font-weight:normal;">'.$this->l('Add Product (ID) :').'&nbsp;</label><input type="text" id="addProductID" name="addProductID"/></p>
                        <p><label for="addDiscount" style="float:none; font-weight:normal;">'.$this->l('Add Discount :').'&nbsp;</label><input type="text" id="addDiscount" name="addDiscount"/></p>
                        <div style="text-align:center; margin-top:5px;"><input type="submit" name="updateOrder" value="Update Order" class="button" style="margin-top:8px;" /></div>
                    
                
                </div>
            </fieldset>';
        }
        echo '
        </form>
        <div class="clear" style="height:20px;">&nbsp;</div>';

        /* Display send a message to customer & returns/credit slip*/
        $returns = OrderReturn::getOrdersReturn($order->id_customer, $order->id);
        $slips = OrderSlip::getOrdersSlip($order->id_customer, $order->id);
        echo '
        <div style="float: left">
            <form action="'.$_SERVER['REQUEST_URI'].'&token='.$this->token.'" method="post" onsubmit="if (getE(\'visibility\').checked == true) return confirm(\''.$this->l('Do you want to send this message to the customer?', __CLASS__, true, false).'\');">
            <fieldset style="width: 400px;">
                <legend style="cursor: pointer;" onclick="$(\'#message\').slideToggle();$(\'#message_m\').slideToggle();return false"><img src="../img/admin/email_edit.gif" /> '.$this->l('New message').'</legend>
                <div id="message_m" style="display: '.(Tools::getValue('message') ? 'none' : 'block').'">
                    <a href="#" onclick="$(\'#message\').slideToggle();$(\'#message_m\').slideToggle();return false"><b>'.$this->l('Click here').'</b> '.$this->l('to add a comment or send a message to the customer').'</a>
                </div>
                <div id="message" style="display: '.(Tools::getValue('message') ? 'block' : 'none').'">
                    <select name="order_message" id="order_message" onchange="orderOverwriteMessage(this, \''.$this->l('Do you want to overwrite your existing message?').'\')">
                        <option value="0" selected="selected">-- '.$this->l('Choose a standard message').' --</option>';
        $orderMessages = OrderMessage::getOrderMessages((int)($order->id_lang));
        foreach ($orderMessages AS $orderMessage)
            echo '        <option value="'.htmlentities($orderMessage['message'], ENT_COMPAT, 'UTF-8').'">'.$orderMessage['name'].'</option>';
        echo '        </select><br /><br />
                    <b>'.$this->l('Display to consumer?').'</b>
                    <input type="radio" name="visibility" id="visibility" value="0" /> '.$this->l('Yes').'
                    <input type="radio" name="visibility" value="1" checked="checked" /> '.$this->l('No').'
                    <p id="nbchars" style="display:inline;font-size:10px;color:#666;"></p><br /><br />
                    <textarea id="txt_msg" name="message" cols="50" rows="8" onKeyUp="var length = document.getElementById(\'txt_msg\').value.length; if (length > 600) length = \'600+\'; document.getElementById(\'nbchars\').innerHTML = \''.$this->l('600 chars max').' (\' + length + \')\';">'.htmlentities(Tools::getValue('message'), ENT_COMPAT, 'UTF-8').'</textarea><br /><br />
                    <input type="hidden" name="id_order" value="'.(int)($order->id).'" />
                    <input type="hidden" name="id_customer" value="'.(int)($order->id_customer).'" />
                    <input type="submit" class="button" name="submitMessage" value="'.$this->l('Send').'" />
                </div>
            </fieldset>
            </form>';
        /* Display list of messages */
        if (sizeof($messages))
        {
            echo '
            <br />
            <fieldset style="width: 400px;">
            <legend><img src="../img/admin/email.gif" /> '.$this->l('Messages').'</legend>';
            foreach ($messages as $message)
            {
                echo '<div style="overflow:auto; width:400px;" '.($message['is_new_for_me'] ?'class="new_message"':'').'>';
                if ($message['is_new_for_me'])
                    echo '<a class="new_message" title="'.$this->l('Mark this message as \'viewed\'').'" href="'.$_SERVER['REQUEST_URI'].'&token='.$this->token.'&messageReaded='.(int)($message['id_message']).'"><img src="../img/admin/enabled.gif" alt="" /></a>';
                echo $this->l('At').' <i>'.Tools::displayDate($message['date_add'], (int)($cookie->id_lang), true);
                echo '</i> '.$this->l('from').' <b>'.(($message['elastname']) ? ($message['efirstname'].' '.$message['elastname']) : ($message['cfirstname'].' '.$message['clastname'])).'</b>';
                echo ((int)($message['private']) == 1 ? '<span style="color:red; font-weight:bold;">'.$this->l('Private:').'</span>' : '');
                echo '<p>'.nl2br2($message['message']).'</p>';
                echo '</div>';
                echo '<br />';
            }
            echo '<p class="info">'.$this->l('When you read a message, please click on the green check.').'</p>';
            echo '</fieldset>';
        }
        echo '</div>';

        /* Display return product */
        echo '<div style="float: left; margin-left: 40px">
            <fieldset style="width: 400px;">
                <legend><img src="../img/admin/return.gif" alt="'.$this->l('Merchandise returns').'" />'.$this->l('Merchandise returns').'</legend>';
        if (!sizeof($returns))
            echo $this->l('No merchandise return for this order.');
        else
            foreach ($returns as $return)
            {
                $state = new OrderReturnState($return['state']);
                echo '('.Tools::displayDate($return['date_upd'], $cookie->id_lang).') :
                <b><a href="index.php?tab=AdminReturn&id_order_return='.$return['id_order_return'].'&updateorder_return&token='.Tools::getAdminToken('AdminReturn'.(int)(Tab::getIdFromClassName('AdminReturn')).(int)($cookie->id_employee)).'">'.$this->l('#').sprintf('%06d', $return['id_order_return']).'</a></b> -
                '.$state->name[$cookie->id_lang].'<br />';
            }
        echo '</fieldset>';

        /* Display credit slip */
        echo '
                <br />
                <fieldset style="width: 400px;">
                    <legend><img src="../img/admin/slip.gif" alt="'.$this->l('Credit slip').'" />'.$this->l('Credit slip').'</legend>';
        if (!sizeof($slips))
            echo $this->l('No slip for this order.');
        else
            foreach ($slips as $slip)
                echo '('.Tools::displayDate($slip['date_upd'], $cookie->id_lang).') : <b><a href="pdf.php?id_order_slip='.$slip['id_order_slip'].'">'.$this->l('#').sprintf('%06d', $slip['id_order_slip']).'</a></b><br />';
        echo '</fieldset>
        </div>';
        echo '<div class="clear">&nbsp;</div>';
        echo '<br /><br /><a href="'.$currentIndex.'&token='.$this->token.'"><img src="../img/admin/arrow2.gif" /> '.$this->l('Back to list').'</a><br />';
    }

    public function displayAddressDetail($addressDelivery)
    {
        // Allow to add specific rules
        $patternRules = array(
            'avoid' => array()
            //'avoid' => array('address2')
        );
        
        return AddressFormat::generateAddress($addressDelivery, $patternRules, '<br />');
    }

    public function display()
    {
        global $cookie;

        if (isset($_GET['view'.$this->table]))
            $this->viewDetails();
        else
        {
            $this->getList((int)($cookie->id_lang), !Tools::getValue($this->table.'Orderby') ? 'date_add' : NULL, !Tools::getValue($this->table.'Orderway') ? 'DESC' : NULL);
            $currency = new Currency((int)(Configuration::get('PS_CURRENCY_DEFAULT')));
            $this->displayList();
            echo '<h2 class="space" style="text-align:right; margin-right:44px;">'.$this->l('Total:').' '.Tools::displayPrice($this->getTotal(), $currency).'</h2>';
        }
    }

    private function getTotal()
    {
        $total = 0;
        foreach($this->_list AS $item)
            if ($item['id_currency'] == Configuration::get('PS_CURRENCY_DEFAULT'))
                $total += (float)($item['total_paid']);
            else
            {
                $currency = new Currency((int)($item['id_currency']));
                $total += Tools::ps_round((float)($item['total_paid']) / (float)($currency->conversion_rate), 2);
            }
        return $total;
    }
}

