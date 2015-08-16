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
*  @version  Release: $Revision: 6594 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class OrderConfirmationControllerCore extends FrontController
{
	public $id_cart;
	public $id_module;
	public $id_order;
	public $secure_key;
	
	public function __construct()
	{
		$this->php_self = 'order-confirmation.php';
	
		parent::__construct();
	}
	
	public function preProcess()
	{
		parent::preProcess();
		
		$this->id_cart = (int)(Tools::getValue('id_cart', 0));
		
		/* check if the cart has been made by a Guest customer, for redirect link */
		if (Cart::isGuestCartByCartId($this->id_cart))
			$redirectLink = 'guest-tracking.php';
		else
			$redirectLink = 'history.php';
		
		if(Tools::getValue('id_module') != 'FreeOrder')
			$this->id_module = (int)(Tools::getValue('id_module', 0));
		else
			$this->id_module = 'FreeOrder';
	
		$this->id_order = Order::getOrderByCartId((int)($this->id_cart));
		$this->secure_key = Tools::getValue('key', false);
		if (!$this->id_order OR !$this->id_module OR !$this->secure_key OR empty($this->secure_key))
			Tools::redirect($redirectLink.(Tools::isSubmit('slowvalidation') ? '?slowvalidation' : ''));

		$order = new Order((int)($this->id_order));
		self::$smarty->assign('new_order', $order);
		if (!Validate::isLoadedObject($order) OR $order->id_customer != self::$cookie->id_customer OR $this->secure_key != $order->secure_key)
		{
			Tools::redirect($redirectLink);
		}
		
		if($this->id_module != 'FreeOrder')
		{
			$module = Module::getInstanceById((int)($this->id_module));
			if ($order->payment != $module->displayName)
			{
				Tools::redirect($redirectLink);	
			}
		}
		
	}
	
	public function process()
	{
		parent::process();
		self::$smarty->assign(array(
			'is_guest' => self::$cookie->is_guest,
			'HOOK_ORDER_CONFIRMATION' => Hook::orderConfirmation((int)($this->id_order)),
			'HOOK_PAYMENT_RETURN' => Hook::paymentReturn((int)($this->id_order), (int)($this->id_module))
		));
		
		if (self::$cookie->is_guest)
		{
			self::$smarty->assign(array(
				'id_order' => $this->id_order,
				'id_order_formatted' => sprintf('#%06d', $this->id_order)
			));
			/* If guest we clear the cookie for security reason */
			self::$cookie->logout();
		}
		else
		self::$smarty->assign(array(
						'id_order' => $this->id_order,
						'id_order_formatted' => sprintf('#%06d', $this->id_order)
		));
		
		//assign order details here
		
		$order = new Order($this->id_order);
		if (Validate::isLoadedObject($order) AND $order->id_customer == self::$cookie->id_customer)
		{
			$id_order_state = (int)($order->getCurrentState());
			$carrier = new Carrier((int)($order->id_carrier), (int)($order->id_lang));
			$addressInvoice = new Address((int)($order->id_address_invoice));
			$addressDelivery = new Address((int)($order->id_address_delivery));
			//	$stateInvoiceAddress = new State((int)$addressInvoice->id_state);
	
			$inv_adr_fields = AddressFormat::getOrderedAddressFields($addressInvoice->id_country);
			$dlv_adr_fields = AddressFormat::getOrderedAddressFields($addressDelivery->id_country);
	
			$invoiceAddressFormatedValues = AddressFormat::getFormattedAddressFieldsValues($addressInvoice, $inv_adr_fields);
			$deliveryAddressFormatedValues = AddressFormat::getFormattedAddressFieldsValues($addressDelivery, $dlv_adr_fields);
	
			if ($order->total_discounts > 0)
			self::$smarty->assign('total_old', (float)($order->total_paid - $order->total_discounts));
			self::$smarty->assign('order_total', Tools::ps_round($order->total_paid));
			self::$smarty->assign('order_total_usd', Tools::ps_round( Tools::convertPrice($order->total_paid,self::$cookie->id_currency,false)));
			$products = $order->getProducts();
	
			$customizedDatas = Product::getAllCustomizedDatas((int)($order->id_cart));
			Product::addCustomizationPrice($products, $customizedDatas);
	
			$customer = new Customer($order->id_customer);
			$order->customization_fee = Cart::getCustomizationCostStatic((int)($order->id_cart));
			
			$totalQuantity = 0;
			foreach ($products as $productRow)
			{
				$totalQuantity += $productRow['product_quantity'];
			}
	
			if(strpos($order->payment, 'COD') === false)
				self::$smarty->assign('paymentMethod', 'ONLINE');
			else
				self::$smarty->assign('paymentMethod', 'COD');
			
			$shippingdate = new DateTime($order->expected_shipping_date);
			self::$smarty->assign(array(
						'shipping_date' => $shippingdate->format("F j, Y"),
						'shop_name' => strval(Configuration::get('PS_SHOP_NAME')),
						'order' => $order,
						'return_allowed' => (int)($order->isReturnable()),
						'currency' => new Currency($order->id_currency),
						'order_state' => (int)($id_order_state),
						'invoiceAllowed' => (int)(Configuration::get('PS_INVOICE')),
						'invoice' => (OrderState::invoiceAvailable((int)($id_order_state)) AND $order->invoice_number),
						'order_history' => $order->getHistory((int)(self::$cookie->id_lang), false, true),
						'products' => $products,
						'discounts' => $order->getDiscounts(),
						'carrier' => $carrier,
						'address_invoice' => $addressInvoice,
						'invoiceState' => (Validate::isLoadedObject($addressInvoice) AND $addressInvoice->id_state) ? new State((int)($addressInvoice->id_state)) : false,
						'address_delivery' => $addressDelivery,
						'inv_adr_fields' => $inv_adr_fields,
						'dlv_adr_fields' => $dlv_adr_fields,
						'invoiceAddressFormatedValues' => $invoiceAddressFormatedValues,
						'deliveryAddressFormatedValues' => $deliveryAddressFormatedValues,
						'deliveryState' => (Validate::isLoadedObject($addressDelivery) AND $addressDelivery->id_state) ? new State((int)($addressDelivery->id_state)) : false,
						'is_guest' => false,
						'messages' => Message::getMessagesByOrderId((int)($order->id)),
						'CUSTOMIZE_FILE' => _CUSTOMIZE_FILE_,
						'CUSTOMIZE_TEXTFIELD' => _CUSTOMIZE_TEXTFIELD_,
						'use_tax' => Configuration::get('PS_TAX'),
						'group_use_tax' => (Group::getPriceDisplayMethod($customer->id_default_group) == PS_TAX_INC),
						'customizedDatas' => $customizedDatas,
						'totalQuantity' => $totalQuantity));
			if ($carrier->url AND $order->shipping_number)
			self::$smarty->assign('followup', str_replace('@', $order->shipping_number, $carrier->url));
			self::$smarty->assign('HOOK_ORDERDETAILDISPLAYED', Module::hookExec('orderDetailDisplayed', array('order' => $order)));
			Module::hookExec('OrderDetail', array('carrier' => $carrier, 'order' => $order));
	
                        //FB Share
                        //$products = $order->getProducts();
                        $orderProducts = array();
                        $productMaxVal = 0;
                        $productMaxId = null;
                        foreach($products as $product) {
                            array_push($orderProducts, $product['product_id']);
                            if( $product['product_price'] > $productMaxVal ) {
                                $productMaxId = $product['product_id'];
                                $productMaxVal = $product['product_price'];
                            }
                        }
                        $productObj = new Product($productMaxId, true, 1);
                        self::$smarty->assign('fbShareProductObject', $productObj->getLink());
                        self::$smarty->assign('fbShareProductObjectId', $productMaxId);
                        self::$smarty->assign('orderProducts', implode(",", $orderProducts));
                        self::$cookie->shareProductCode = md5(time().$productMaxId);
                        self::$cookie->write();
			unset($carrier);
			unset($addressInvoice);
			unset($addressDelivery);
		}
	}
	
	public function displayContent()
	{
		parent::displayContent();
		self::$smarty->display(_PS_THEME_DIR_.'order-confirmation.tpl');
	}
	
	public function setMedia()
	{
		parent::setMedia();
		//Tools::addCSS(_THEME_CSS_DIR_.'history.css');
		//Tools::addCSS(_THEME_CSS_DIR_.'addresses.css');
	}
}

