<?php
include_once(dirname(__FILE__).'/../config/config.inc.php');

abstract class PaymentModuleCore extends Module
{
	/** @var integer Current order's id */
	public	$currentOrder;
	public	$currencies = true;
	public	$currencies_mode = 'checkbox';

	public function install()
	{
		if (!parent::install())
			return false;

		// Insert currencies availability
		if ($this->currencies_mode == 'checkbox')
		{
			if (!Db::getInstance()->Execute('
			INSERT INTO `'._DB_PREFIX_.'module_currency` (id_module, id_currency)
			SELECT '.(int)($this->id).', id_currency FROM `'._DB_PREFIX_.'currency` WHERE deleted = 0'))
				return false;
		}
		elseif ($this->currencies_mode == 'radio')
		{
			if (!Db::getInstance()->Execute('
			INSERT INTO `'._DB_PREFIX_.'module_currency` (id_module, id_currency)
			VALUES ('.(int)($this->id).', -2)'))
				return false;
		}
		else
			Tools::displayError('No currency mode for payment module');

		// Insert countries availability
		$return = Db::getInstance()->Execute('
		INSERT INTO `'._DB_PREFIX_.'module_country` (id_module, id_country)
		SELECT '.(int)($this->id).', id_country FROM `'._DB_PREFIX_.'country` WHERE active = 1');
		// Insert group availability
		$return &= Db::getInstance()->Execute('
		INSERT INTO `'._DB_PREFIX_.'module_group` (id_module, id_group)
		SELECT '.(int)($this->id).', id_group FROM `'._DB_PREFIX_.'group`');

		return $return;
	}

	public function uninstall()
	{
		if (!Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'module_country` WHERE id_module = '.(int)($this->id))
			OR !Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'module_currency` WHERE id_module = '.(int)($this->id))
			OR !Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'module_group` WHERE id_module = '.(int)($this->id)))
			return false;
		return parent::uninstall();
	}

	/**
	* Validate an order in database
	* Function called from a payment module
	*
	* @param integer $id_cart Value
	* @param integer $id_order_state Value
	* @param float $amountPaid Amount really paid by customer (in the default currency)
	* @param string $paymentMethod Payment method (eg. 'Credit card')
	* @param string $message Message to attach to order
	*/
	public function validateOrder($id_cart, $id_order_state, $amountPaid, $paymentMethod = 'Unknown', $message = NULL, $extraVars = array(), $currency_special = NULL, $dont_touch_amount = false, $secure_key = false)
	{
		global $cart, $link, $cookie;
		
		$id_payment_state = _PS_PS_NOT_PAID_;
		$cart = new Cart((int)($id_cart));
		// Does order already exists ?
		if (Validate::isLoadedObject($cart) AND $cart->OrderExists() == false)
		{
			if ($secure_key !== false AND $secure_key != $cart->secure_key)
				die(Tools::displayError());

			// Copying data from cart
			$order = new Order();
			$order->id_carrier = (int)($cart->id_carrier);
			$order->id_customer = (int)($cart->id_customer);
			$order->id_address_invoice = (int)($cart->id_address_invoice);
			$order->id_address_delivery = (int)($cart->id_address_delivery);
			$vat_address = new Address((int)($order->id_address_delivery));
			$order->id_currency = ($currency_special ? (int)($currency_special) : (int)($cart->id_currency));
			$order->id_lang = (int)($cart->id_lang);
			$order->id_cart = (int)($cart->id);
			$customer = new Customer((int)($order->id_customer));
			$order->secure_key = ($secure_key ? pSQL($secure_key) : pSQL($customer->secure_key));
			$order->payment = $paymentMethod;
			if (isset($this->name))
				$order->module = $this->name;
			$order->recyclable = $cart->recyclable;
			$order->gift = (int)($cart->gift);
			$order->gift_message = $cart->gift_message;
			$currency = new Currency($order->id_currency);
			$order->conversion_rate = $currency->conversion_rate;
			$amountPaid = !$dont_touch_amount ? Tools::ps_round((float)($amountPaid), 2) : $amountPaid;
			$order->total_paid_real = $amountPaid;
			$order->total_products = (float)($cart->getOrderTotal(false, Cart::ONLY_PRODUCTS));
			$order->total_products_wt = (float)($cart->getOrderTotal(true, Cart::ONLY_PRODUCTS));
			$order->total_customization = $cart->getCartCustomizationCost();
			$order->total_donation = round($cookie->donation_amount);
                        unset($cookie->donation_amount);
			
			if(strpos($order->payment, 'COD') === false)
			{
				$order->total_discounts = (float)(abs($cart->getOrderTotal(true, Cart::ONLY_DISCOUNTS, true)));
				$order->total_paid = (float)(Tools::ps_round((float)($cart->getOrderTotal(true, Cart::BOTH, true))));	
			}
			else 
			{
				$order->total_discounts = (float)(abs($cart->getOrderTotal(true, Cart::ONLY_DISCOUNTS, false)));
				$order->total_paid = (float)(Tools::ps_round((float)($cart->getOrderTotal(true, Cart::BOTH, false))));
				$order->total_cod = COD_CHARGE;
			}
			$order->total_shipping = (float)($cart->getOrderShippingCost());
			$order->carrier_tax_rate = (float)Tax::getCarrierTaxRate($cart->id_carrier, (int)$cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
			$order->total_wrapping = (float)(abs($cart->getOrderTotal(true, Cart::ONLY_WRAPPING)));
			
			$order->invoice_date = '0000-00-00 00:00:00';
			$order->delivery_date = '0000-00-00 00:00:00';
			$shippingdate = $cart->getExpectedShippingDate();
			$order->expected_shipping_date = pSQL($shippingdate->format('Y-m-d H:i:s'));
                        $order->actual_expected_shipping_date  = pSQL($shippingdate->format('Y-m-d H:i:s'));
			// Amount paid by customer is not the right one -> Status = payment error
			// We don't use the following condition to avoid the float precision issues : http://www.php.net/manual/en/language.types.float.php
			// if ($order->total_paid != $order->total_paid_real)
			// We use number_format in order to compare two string
			if (number_format(round($order->total_paid)) != number_format(round($order->total_paid_real)))
			{
				$id_order_state = _PS_OS_ERROR_;
				$id_payment_state = _PS_PS_NOT_PAID_;	
			}
			else 
			{
				if(strpos($order->payment, 'COD') === false)
					$id_payment_state = _PS_PS_PAID_;
			}
			
			//update payment status
			
			// Creating order
			if ($cart->OrderExists() == false)
			{
			    $cart_value = $cart->getOrderTotal();
			    if($cart_value >= 1000)
			    {
			        //if(!$cart->containsProduct(FREE_GIFT_ID, NULL, NULL))
			            //$cart->updateQty(1, FREE_GIFT_ID, NULL, false, 'up', TRUE);
			    }
				$result = $order->add();                                
			}
			else
			{
				$errorMessage = Tools::displayError('An order has already been placed using this cart.');
				Logger::addLog($errorMessage, 4, '0000001', 'Cart', intval($order->id_cart));
				die($errorMessage);
			}

			// Next !
			if ($result AND isset($order->id))
			{
				if (!$secure_key)
					$message .= $this->l('Warning : the secure key is empty, check your payment account before validation');
				// Optional message to attach to this order
				if (isset($message) AND !empty($message))
				{
					$msg = new Message();
					$message = strip_tags($message, '<br>');
					if (Validate::isCleanHtml($message))
					{
						$msg->message = $message;
						$msg->id_order = intval($order->id);
						$msg->private = 1;
						$msg->add();
					}
				}

				// Insert products from cart into order_detail table
				$products = $cart->getProducts();
				$productsList = '';
				$db = Db::getInstance();
				$query = 'INSERT INTO `'._DB_PREFIX_.'order_detail`
					(`id_order`, `product_id`, `product_attribute_id`, `product_name`, `product_quantity`, `product_quantity_in_stock`, `product_price`, `reduction_percent`, `reduction_amount`, `group_reduction`, `product_quantity_discount`, `product_ean13`, `product_upc`, `product_reference`, `product_supplier_reference`, `product_weight`, `tax_name`, `tax_rate`, `ecotax`, `ecotax_tax_rate`, `discount_quantity_applied`, `download_deadline`, `download_hash`, `customization`)
				VALUES ';

				$customizedDatas = Product::getAllCustomizedDatas((int)($order->id_cart));
				Product::addCustomizationPrice($products, $customizedDatas);
				$outOfStock = false;
				foreach ($products AS $key => $product)
				{
					$productQuantity = (int)(Product::getQuantity((int)($product['id_product']), ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL)));
					$quantityInStock = ($productQuantity - (int)($product['cart_quantity']) < 0) ? $productQuantity : (int)($product['cart_quantity']);
					if ($id_order_state != _PS_OS_CANCELED_ AND $id_order_state != _PS_OS_ERROR_)
                                        {
						if (Product::updateQuantity($product, (int)$order->id))
							$product['stock_quantity'] -= $product['cart_quantity'];
						if ($product['stock_quantity'] < 0 && Configuration::get('PS_STOCK_MANAGEMENT'))
							$outOfStock = true;
						
						if ($product['stock_quantity'] < 1)
							SolrSearch::updateProduct((int)($product['id_product']));

						Product::updateDefaultAttribute($product['id_product']);
					}
					$price = Product::getPriceStatic((int)($product['id_product']), false, ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL), 6, NULL, false, true, $product['cart_quantity'], false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
					$price_wt = Product::getPriceStatic((int)($product['id_product']), true, ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL), 2, NULL, false, true, $product['cart_quantity'], false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
					// Add some informations for virtual products
					$deadline = '0000-00-00 00:00:00';
					$download_hash = NULL;
					if ($id_product_download = ProductDownload::getIdFromIdProduct((int)($product['id_product'])))
					{
						$productDownload = new ProductDownload((int)($id_product_download));
						$deadline = $productDownload->getDeadLine();
						$download_hash = $productDownload->getHash();
					}

					// Exclude VAT
					if (Tax::excludeTaxeOption())
					{
						$product['tax'] = 0;
						$product['rate'] = 0;
						$tax_rate = 0;
					}
					else
						$tax_rate = Tax::getProductTaxRate((int)($product['id_product']), $cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});

                    $ecotaxTaxRate = 0;
                    if (!empty($product['ecotax']))
                        $ecotaxTaxRate = Tax::getProductEcotaxRate($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});

					$quantityDiscount = SpecificPrice::getQuantityDiscount((int)$product['id_product'], Shop::getCurrentShop(), (int)$cart->id_currency, (int)$vat_address->id_country, (int)$customer->id_default_group, (int)$product['cart_quantity']);
					$unitPrice = Product::getPriceStatic((int)$product['id_product'], true, ($product['id_product_attribute'] ? intval($product['id_product_attribute']) : NULL), 2, NULL, false, true, 1, false, (int)$order->id_customer, NULL, (int)$order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
					$quantityDiscountValue = $quantityDiscount ? ((Product::getTaxCalculationMethod((int)$order->id_customer) == PS_TAX_EXC ? Tools::ps_round($unitPrice, 2) : $unitPrice) - $quantityDiscount['price'] * (1 + $tax_rate / 100)) : 0.00;
					$specificPrice = 0;
					$query .= '('.(int)($order->id).',
						'.(int)($product['id_product']).',
						'.(isset($product['id_product_attribute']) ? (int)($product['id_product_attribute']) : 'NULL').',
						\''.pSQL($product['name'].((isset($product['attributes']) AND $product['attributes'] != NULL) ? ' - '.$product['attributes'] : '')).'\',
						'.(int)($product['cart_quantity']).',
						'.$quantityInStock.',
						'.(float)(Product::getPriceStatic((int)($product['id_product']), false, ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL), (Product::getTaxCalculationMethod((int)($order->id_customer)) == PS_TAX_EXC ? 2 : 6), NULL, false, false, $product['cart_quantity'], false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}), $specificPrice, FALSE)).',
						'.(float)(($specificPrice AND $specificPrice['reduction_type'] == 'percentage') ? $specificPrice['reduction'] * 100 : 0.00).',
						'.(float)(($specificPrice AND $specificPrice['reduction_type'] == 'amount') ? (!$specificPrice['id_currency'] ? Tools::convertPrice($specificPrice['reduction'], $order->id_currency) : $specificPrice['reduction']) : 0.00).',
						'.(float)(Group::getReduction((int)($order->id_customer))).',
						'.$quantityDiscountValue.',
						'.(empty($product['ean13']) ? 'NULL' : '\''.pSQL($product['ean13']).'\'').',
						'.(empty($product['upc']) ? 'NULL' : '\''.pSQL($product['upc']).'\'').',
						'.(empty($product['reference']) ? 'NULL' : '\''.pSQL($product['reference']).'\'').',
						'.(empty($product['supplier_reference']) ? 'NULL' : '\''.pSQL($product['supplier_reference']).'\'').',
						'.(float)($product['id_product_attribute'] ? $product['weight_attribute'] : $product['weight']).',
						\''.(empty($tax_rate) ? '' : pSQL($product['tax'])).'\',
						'.(float)($tax_rate).',
						'.(float)Tools::convertPrice(floatval($product['ecotax']), intval($order->id_currency)).',
						'.(float)$ecotaxTaxRate.',
						'.(($specificPrice AND $specificPrice['from_quantity'] > 1) ? 1 : 0).',
						\''.pSQL($deadline).'\',
						\''.pSQL($download_hash).'\', '.$cart->getProductCustomizationCost($product['id_product']).'),';

					$customizationQuantity = 0;
					if (isset($customizedDatas[$product['id_product']][$product['id_product_attribute']]))
					{
						$customizationText = '';
						foreach ($customizedDatas[$product['id_product']][$product['id_product_attribute']] AS $customization)
						{
							if (isset($customization['datas'][_CUSTOMIZE_TEXTFIELD_]))
								foreach ($customization['datas'][_CUSTOMIZE_TEXTFIELD_] AS $text)
								{
									if($text['index'] == 8)
										$customizationText .= 'Saree with unstitched blouse and fall/pico work.' .'<br />';
									else if($text['index'] == 1)
										$customizationText .= 'Pre-stitched saree with unstitched blouse and fall/pico work.' .'<br />';
									else if($text['index'] == 2)
										$customizationText .= 'Stitched to measure blouse.' .'<br />';
									else if($text['index'] == 3)
										$customizationText .= 'Stitched to measure in-skirt.' .'<br />';
									else if($text['index'] == 4)
										$customizationText .= 'Stitched to measure kurta.' .'<br />';
									else if($text['index'] == 5)
										$customizationText .= 'Stitched to measure salwar.' .'<br />';
								}
							
							if (isset($customization['datas'][_CUSTOMIZE_FILE_]))
								$customizationText .= sizeof($customization['datas'][_CUSTOMIZE_FILE_]) .' '. Tools::displayError('image(s)').'<br />';
								
							$customizationText .= '---<br />';							
						}
						
						$customizationText = rtrim($customizationText, '---<br />');
						
						$customizationQuantity = (int)($product['customizationQuantityTotal']);
						$productsList .=
						'<tr style="background-color: '.($key % 2 ? '#DDE2E6' : '#EBECEE').';">
							<td style="padding: 0.6em 0.4em;">'.$product['reference'].'</td>
							<td style="padding: 0.6em 0.4em;"><strong>'.$product['name'].(isset($product['attributes_small']) ? ' '.$product['attributes_small'] : '').' - '.$this->l('Customized').(!empty($customizationText) ? ' - '.$customizationText : '').'</strong></td>
							<td style="padding: 0.6em 0.4em; text-align: right;">'.Tools::displayPrice(round(Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt), $currency, false).'</td>
							<td style="padding: 0.6em 0.4em; text-align: center;">'.$customizationQuantity.'</td>
							<td style="padding: 0.6em 0.4em; text-align: right;">'.Tools::displayPrice($customizationQuantity * (round(Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt)), $currency, false).'</td>
						</tr>';
					}

					if (!$customizationQuantity OR (int)$product['cart_quantity'] > $customizationQuantity)
						$productsList .=
						'<tr style="background-color: '.($key % 2 ? '#DDE2E6' : '#EBECEE').';">
							<td style="padding: 0.6em 0.4em;">'.$product['reference'].'</td>
							<td style="padding: 0.6em 0.4em;"><strong>'.$product['name'].(isset($product['attributes_small']) ? ' '.$product['attributes_small'] : '').'</strong></td>
							<td style="padding: 0.6em 0.4em; text-align: right;">'.Tools::displayPrice(round(Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt), $currency, false).'</td>
							<td style="padding: 0.6em 0.4em; text-align: center;">'.((int)($product['cart_quantity']) - $customizationQuantity).'</td>
							<td style="padding: 0.6em 0.4em; text-align: right;">'.Tools::displayPrice(((int)($product['cart_quantity']) - $customizationQuantity) * (round(Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt)), $currency, false).'</td>
						</tr>';
					
					
					//if giftcard, create voucher and send the mails now.
					$categories = Product::getProductCategories($product['id_product']);
					if(in_array(CAT_GIFTCARD, $categories))
					{
						$friendsName = '';
						$friendsEmail = '';
						$giftMessage = '';
						foreach ($customizedDatas[$product['id_product']][$product['id_product_attribute']] AS $customization)
						{
							if (isset($customization['datas'][_CUSTOMIZE_TEXTFIELD_]))
								foreach ($customization['datas'][_CUSTOMIZE_TEXTFIELD_] AS $text)
								{
									if($text['index'] == 21)
										$friendsName = $text['value'];
									else if($text['index'] == 22)
										$friendsEmail = $text['value'];
									else if($text['index'] == 23)
										$giftMessage = $text['value'];
									else if($text['index'] == 25)
										$couponCode = $text['value'];
								}
						}
						
						//$couponCode = "GC" . Tools::rand_string(8);
						
						// create discount
						$languages = Language::getLanguages($order);
						$voucher = new Discount();
						$voucher->id_discount_type = 2;
						foreach ($languages as $language)
							$voucher->description[$language['id_lang']] = $product['name'];
						$voucher->value = (float)$unitPrice;
						$voucher->name = $couponCode;
						$voucher->id_currency = 2; //USD
						$voucher->quantity = 1;
						$voucher->quantity_per_user = 1;
						$voucher->cumulable = 1;
						$voucher->cumulable_reduction = 1;
						$voucher->minimal = 0;
						$voucher->active = 1;
						$voucher->cart_display = 0;
						$now = time();
						$voucher->date_from = date('Y-m-d H:i:s', $now);
						$voucher->date_to = date('Y-m-d H:i:s', $now + (3600 * 24 * 365)); /* 365 days */
						$voucher->add();
						
						$productObj = new Product($product['id_product'], true, 1);
						
						$idImage = $productObj->getCoverWs();
						if($idImage)
							$idImage = $productObj->id.'-'.$idImage;
						else
							$idImage = Language::getIsoById(1).'-default';
						
						$params = array();
						$params['{voucher_code}'] = $voucher->name;
						$params['{freinds_name}'] = $friendsName;
						$params['{gift_message}'] = $giftMessage;
						$params['{product_name}'] = $product['name'];
						$params['{voucher_value}'] = $voucher->value;
						$params['{image_url}'] = _PS_BASE_URL_._PS_IMG_ . 'banners/' . $productObj->location;
						$params['{sender_name}'] = $customer->firstname . ' ' . $customer->lastname;
						
						$subject = $friendsName . ', You Have Received A $'.$voucher->value.' IndusDiva Gift Card';
						
						@Mail::Send(1, 'gift_card', $subject, $params, $friendsEmail, $friendsName, 'care@indusdiva.com', 'Indusdiva.com', NULL, NULL, _PS_MAIL_DIR_, true);
						@Mail::Send(1, 'gift_card', $subject, $params, $customer->email, $customer->firstname.' '.$customer->lastname, 'care@indusdiva.com', 'Indusdiva.com', NULL, NULL, _PS_MAIL_DIR_, true);
					}
				} // end foreach ($products)
				$query = rtrim($query, ',');
				$result = $db->Execute($query);

				// Insert discounts from cart into order_discount table
				$discounts = $cart->getDiscounts();
				$discountsList = '';
				$total_discount_value = 0;
				$shrunk = false;
				foreach ($discounts AS $discount)
				{
					$objDiscount = new Discount((int)$discount['id_discount'], $order->id_lang);
					$value = $objDiscount->getValue(sizeof($discounts), $cart->getOrderTotal(true, Cart::ONLY_PRODUCTS), $order->total_shipping, $cart->id);
					if (($objDiscount->id_discount_type == 2 || $objDiscount->id_discount_type == 4) AND in_array($objDiscount->behavior_not_exhausted, array(1,2)))
						$shrunk = true;

					if ($shrunk AND ($total_discount_value + $value) > ($order->total_products + $order->total_shipping + $order->total_wrapping))
					{
						$amount_to_add = ($order->total_products + $order->total_shipping + $order->total_wrapping) - $total_discount_value;
						if (($objDiscount->id_discount_type == 2 || $objDiscount->id_discount_type == 4) AND $objDiscount->behavior_not_exhausted == 2)
						{
							$voucher = new Discount();
							foreach ($objDiscount AS $key => $discountValue)
								$voucher->$key = $discountValue;
							$voucher->name = 'VSRK'.(int)$order->id_customer.'O'.(int)$order->id;
							$voucher->value = (float)$value - $amount_to_add;
							$voucher->add();
							$params['{voucher_amount}'] = Tools::displayPrice($voucher->value, $currency, false);
							$params['{voucher_num}'] = $voucher->name;
							@Mail::Send((int)$order->id_lang, 'voucher', Mail::l('New voucher regarding your order #').$order->id, $params, $customer->email, $customer->firstname.' '.$customer->lastname);
						}
					}
					else
						$amount_to_add = $value;
					$order->addDiscount($objDiscount->id, $objDiscount->name, $amount_to_add);
					$total_discount_value += $amount_to_add;
					if ($id_order_state != _PS_OS_ERROR_ AND $id_order_state != _PS_OS_CANCELED_)
						$objDiscount->quantity = $objDiscount->quantity - 1;
					$objDiscount->update();

					$discountsList .=
					'<tr style="background-color:#EBECEE;">
							<td colspan="4" style="padding: 0.6em 0.4em; text-align: right;">'.$this->l('Voucher code:').' '.$objDiscount->name.'</td>
							<td style="padding: 0.6em 0.4em; text-align: right;">'.($value != 0.00 ? '-' : '').Tools::displayPrice($value, $currency, false).'</td>
					</tr>';
				}

				// Specify order id for message
				$oldMessage = Message::getMessageByCartId((int)($cart->id));
				if ($oldMessage)
				{
					$message = new Message((int)$oldMessage['id_message']);
					$message->id_order = (int)$order->id;
					$message->update();
				}

				// Hook new order
				$orderStatus = new OrderState((int)$id_order_state, (int)$order->id_lang);
				if (Validate::isLoadedObject($orderStatus))
				{
					Hook::newOrder($cart, $order, $customer, $currency, $orderStatus);
					foreach ($cart->getProducts() AS $product)
						if ($orderStatus->logable)
							ProductSale::addProductSale((int)$product['id_product'], (int)$product['cart_quantity']);
				}

				if (isset($outOfStock) AND $outOfStock)
				{
					$history = new OrderHistory();
					$history->id_order = (int)$order->id;
					$history->changeIdOrderState(_PS_OS_OUTOFSTOCK_, (int)$order->id);
					$history->addWithemail();
				}

				// Set order state in order history ONLY even if the "out of stock" status has not been yet reached
				// So you migth have two order states
				$new_history = new OrderHistory();
				$new_history->id_order = (int)$order->id;
				$new_history->changeIdOrderState((int)$id_order_state, (int)$order->id);
				$new_history->addWithemail(true, $extraVars);
				
				//Payment status
				$paymentHistory = new OrderPaymentHistory();
				$paymentHistory->id_order = (int)$order->id;
				$paymentHistory->changeIdOrderPaymentState($id_payment_state, (int)$order->id);
				$paymentHistory->addState();
				
				// Order is reloaded because the status just changed
				$order = new Order($order->id);
				
				//Update tracking code for quantium
				if($order->id_carrier == QUANTIUM)
				{
					if(strpos($order->payment, 'COD') === false)
						$order->shipping_number = 'VBN'.$order->id;
					else 
						$order->shipping_number = 'VBC'.$order->id;
					$order->update();
				}
				else if($order->id_carrier == SABEXPRESS)
				{
				    $db = Db::getInstance();
				    $db->Execute('LOCK TABLES vb_awb_pool WRITE');
				    $res = $db->getRow("select min(id) as 'id', awb from vb_awb_pool where id_carrier = " . SABEXPRESS . " and assigned = 0");
				    $awb = $res['awb'];
				    $id = $res['id'];
				    $db->Execute("update vb_awb_pool set assigned = 1 where id = " . $id);
				    $db->Execute('UNLOCK TABLES');
				    $order->shipping_number = $awb;
				    $order->update();
				}
				else if($order->id_carrier == AFL)
				{
				    $db = Db::getInstance();
				    $db->Execute('LOCK TABLES vb_awb_pool WRITE');
				    $res = $db->getRow("select min(id) as 'id' , awb from vb_awb_pool where id_carrier = " . AFL . " and assigned = 0");
				    $awb = $res['awb'];
				    $id = $res['id'];
				    $db->Execute("update vb_awb_pool set assigned = 1 where id = " . $id);
				    $db->Execute('UNLOCK TABLES');
				    $order->shipping_number = $awb;
				    $order->update();
				}

				// Send an e-mail to customer
				if ($id_order_state != _PS_OS_ERROR_ AND $id_order_state != _PS_OS_CANCELED_ AND $customer->id AND $id_order_state != _PS_OS_OP_PAYEMENT_FAILED)
				{
				    //deduct reward points
				    $points_redeemed = $cart->getPoints();
				    if($points_redeemed)
				        VBRewards::removeRewardPoints($order->id_customer, EVENT_POINTS_REDEEMED, 0, $cart->getPoints(), 'Coins redeemed - Order no ' . $order->id, $order->id, $order->date_add);
				    
                                        /*
                                        if(strpos($order->payment, 'COD') === false && $order->total_paid_real > 0)
                                        {
                                            VBRewards::addRewardPoints($order->id_customer, ONLINE_ORDER, 0, 100, 'Online payment bonus - Order no ' . $order->id, $order->id, $order->date_add);
                                        }
                                        */

				    
					$invoice = new Address((int)($order->id_address_invoice));
					$delivery = new Address((int)($order->id_address_delivery));
					$carrier = new Carrier((int)($order->id_carrier), $order->id_lang);
					$delivery_state = $delivery->id_state ? new State((int)($delivery->id_state)) : false;
					$invoice_state = $invoice->id_state ? new State((int)($invoice->id_state)) : false;
					$shippingdate = new DateTime($order->expected_shipping_date);

					$data = array(
					'{firstname}' => $customer->firstname,
					'{shipping_date}' => $shippingdate->format("F j, Y"),
					'{lastname}' => $customer->lastname,
					'{email}' => $customer->email,
					'{delivery_block_txt}' => $this->_getFormatedAddress($delivery, "\n"),
					'{invoice_block_txt}' => $this->_getFormatedAddress($invoice, "\n"),
					'{delivery_block_html}' => $this->_getFormatedAddress($delivery, "<br />", 
						array(
							'firstname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>', 
							'lastname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>')),
						'{invoice_block_html}' => $this->_getFormatedAddress($invoice, "<br />", 
						array(
							'firstname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>',
							'lastname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>')),
					'{delivery_company}' => $delivery->company,
					'{delivery_firstname}' => $delivery->firstname,
					'{delivery_lastname}' => $delivery->lastname,
					'{delivery_address1}' => $delivery->address1,
					'{delivery_address2}' => $delivery->address2,
					'{delivery_city}' => $delivery->city,
					'{delivery_postal_code}' => $delivery->postcode,
					'{delivery_country}' => $delivery->country,
					'{delivery_state}' => $delivery->id_state ? $delivery_state->name : '',
					'{delivery_phone}' => ($delivery->phone) ? $delivery->phone : $delivery->phone_mobile,
					'{delivery_other}' => $delivery->other,
					'{invoice_company}' => $invoice->company,
					'{invoice_vat_number}' => $invoice->vat_number,
					'{invoice_firstname}' => $invoice->firstname,
					'{invoice_lastname}' => $invoice->lastname,
					'{invoice_address2}' => $invoice->address2,
					'{invoice_address1}' => $invoice->address1,
					'{invoice_city}' => $invoice->city,
					'{invoice_postal_code}' => $invoice->postcode,
					'{invoice_country}' => $invoice->country,
					'{invoice_state}' => $invoice->id_state ? $invoice_state->name : '',
					'{invoice_phone}' => ($invoice->phone) ? $invoice->phone : $invoice->phone_mobile,
					'{invoice_other}' => $invoice->other,
					'{order_name}' => sprintf("#%06d", (int)($order->id)),
					'{date}' => date("F j, Y, g:i a"),
					'{carrier}' => $carrier->name,
					'{payment}' => Tools::substr($order->payment, 0, 32),
					'{products}' => $productsList,
					'{discounts}' => $discountsList,
					'{total_paid}' => Tools::displayPrice($order->total_paid, $currency, false),
					'{total_products}' => Tools::displayPrice($order->total_paid - $order->total_shipping - $order->total_cod - $order->total_wrapping + $order->total_discounts, $currency, false),
					'{total_discounts}' => Tools::displayPrice($order->total_discounts, $currency, false),
					'{total_shipping}' => Tools::displayPrice($order->total_shipping, $currency, false),
					'{total_cod}' => Tools::displayPrice($order->total_cod, $currency, false),
					'{total_wrapping}' => Tools::displayPrice($order->total_wrapping, $currency, false));

					if (is_array($extraVars))
						$data = array_merge($data, $extraVars);

					// Join PDF invoice
					if ((int)(Configuration::get('PS_INVOICE')) AND Validate::isLoadedObject($orderStatus) AND $orderStatus->invoice AND $order->invoice_number)
					{
						$fileAttachment['content'] = PDF::invoice($order, 'S');
						$fileAttachment['name'] = $fileAttachment['name'] = 'IndusDiva Order #'.sprintf('%06d', (int)$order->id).'.pdf';
						$fileAttachment['mime'] = 'application/pdf';
					}
					else
						$fileAttachment = NULL;

					if (Validate::isEmail($customer->email))
						if($id_order_state == _PS_OS_BANKWIRE_) {
							Mail::Send((int)($order->id_lang), 'order_conf_bankwire', Mail::l('Your order #'.$order->id.' with IndusDiva.com is confirmed'), $data, $customer->email, $customer->firstname.' '.$customer->lastname, NULL, NULL, $fileAttachment);
						} else {
							$data['payment'] = 'Online Payment';
							Mail::Send((int)($order->id_lang), 'order_conf', Mail::l('Your order #'.$order->id.' with IndusDiva.com is confirmed'), $data, $customer->email, $customer->firstname.' '.$customer->lastname, NULL, NULL, $fileAttachment);	
						}
					//Send SMS
					//$smsText = 'Dear customer, your order #'.$order->id.' at IndusDiva.com is confirmed and will be delivered to you within 3-5 business days. www.indusdiva.com';
					//Tools::sendSMS($delivery->phone_mobile, $smsText);					
				}
				$this->currentOrder = (int)($order->id);
				return true;
			}
			else
			{
				$errorMessage = Tools::displayError('Order creation failed');
				Logger::addLog($errorMessage, 4, '0000002', 'Cart', intval($order->id_cart));
				die($errorMessage);
			}
		}
		else
		{
			$errorMessage = Tools::displayError('Cart can\'t be loaded or an order has already been placed using this cart');
			Logger::addLog($errorMessage, 4, '0000001', 'Cart', intval($cart->id));
			die($errorMessage);
		}
	}

	/**
	 * @param Object Address $the_address that needs to be txt formated
	 * @return String the txt formated address block
	 */
	private function _getTxtFormatedAddress($the_address)
	{
		$out = '';
		$adr_fields = AddressFormat::getOrderedAddressFields($the_address->id_country);
		$r_values = array();
		foreach($adr_fields as $fields_line)
		{
			$tmp_values = array();
			foreach (explode(' ', $fields_line) as $field_item)
			{
				$field_item = trim($field_item);
				$tmp_values[] = $the_address->{$field_item};
			}
			$r_values[] = implode(' ', $tmp_values);
		}

		$out = implode("\n", $r_values);
		return $out;
	}

	/**
	 * @param Object Address $the_address that needs to be txt formated
	 * @return String the txt formated address block
	 */

	private function _getFormatedAddress(Address $the_address, $line_sep, $fields_style = array())
	{
		return AddressFormat::generateAddress($the_address, array('avoid' => array()), $line_sep, ' ', $fields_style);
	}

	/**
	 * @param int $id_currency : this parameter is optionnal but on 1.5 version of Prestashop, it will be REQUIRED
	 * @return Currency
	 */
	public function getCurrency($current_id_currency = NULL)
	{
		if (!(int)$current_id_currency)
			global $cookie;

		if (!$this->currencies)
			return false;
		if ($this->currencies_mode == 'checkbox')
		{
			$currencies = Currency::getPaymentCurrencies($this->id);
			return $currencies;
		}
		elseif ($this->currencies_mode == 'radio')
		{
			$currencies = Currency::getPaymentCurrenciesSpecial($this->id);
			$currency = $currencies['id_currency'];
			if ($currency == -1)
			{
				// not use $cookie if $current_id_currency is set
				if ((int)$current_id_currency)
					$id_currency = (int)$current_id_currency;
				else
					$id_currency = (int)($cookie->id_currency);
			}
			elseif ($currency == -2)
				$id_currency = (int)(Configuration::get('PS_CURRENCY_DEFAULT'));
			else
				$id_currency = $currency;
		}
		if (!isset($id_currency) OR empty($id_currency))
			return false;
		return (new Currency($id_currency));
	}

}

