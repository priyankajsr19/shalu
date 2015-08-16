<?php
/**
 * EBS payment module processor
 *
 *
 *
 *
 */


class EBS extends PaymentModule
{
	private	$_html = '';
	private $_postErrors = array();
	private $_responseReasonText = null;

	public function __construct()
	{
		$this->name = 'EBS';
		$this->tab = 'Payment';
		$this->version = '2.5';

        parent::__construct();
		$this->idOrderState = Configuration::get('EBS_ID_ORDER_STATE');
        /* The parent construct is required for translations */
		$this->page = basename(__FILE__, '.php');
        $this->displayName = $this->l('EBS');
        $this->description = $this->l('Accepts payments by EBS');
	}

	public function getEBSUrl()
	{
			return 'https://secure.ebs.in/pg/ma/sale/pay';
	}

	public function install()
	{

		if (parent::install())
		{

			$sid = $this->getOrderState();
			$fid =$this->getOrderState()+1;
			Configuration::updateValue('ACCOUNT_ID', '');
			Configuration::updateValue('SECRET_KEY', '');
			Configuration::updateValue('MODE', 'TEST');
			Configuration::updateValue('EBS_ID_ORDER_SUCCESS',$sid);
			Configuration::updateValue('EBS_ID_ORDER_FAILED',$fid);
			
			
			$this->registerHook('payment');
			
			Db::getInstance()->Execute
			('
				INSERT INTO `' . _DB_PREFIX_ . 'order_state`
			( `id_order_state`,`invoice`, `send_email`, `color`, `unremovable`, `logable`, `delivery`)
				VALUES
			('.$sid.',0, 0, \'#33FF99\', 0, 0,0);
			');
			Db::getInstance()->Execute
				('
					INSERT INTO `' . _DB_PREFIX_ . 'order_state_lang` 
				(`id_order_state`, `id_lang`, `name`, `template`) 
					VALUES 
				('.$sid.', 1, \'Payment accepted\', \'payment\')');
				
			
			Db::getInstance()->Execute
			('
				INSERT INTO `' . _DB_PREFIX_ . 'order_state`
			( `id_order_state`,`invoice`, `send_email`, `color`, `unremovable`, `logable`, `delivery`)
				VALUES
			('.$fid.',0, 0, \'#33FF99\', 0, 0,0);
			');
			Db::getInstance()->Execute
				('
					INSERT INTO `' . _DB_PREFIX_ . 'order_state_lang` 
				(`id_order_state`, `id_lang`, `name`, `template`) 
					VALUES 
				('.$fid.', 1, \'Payment Failed\', \'payment\')');
			
			
			
			
			
			
			return true;
		}
		else 
			return false;
	}

	public function uninstall()
	{

		
		Db::getInstance()->Execute
				('
					DELETE FROM `' . _DB_PREFIX_ . 'order_state_lang` 
					 WHERE id_order_state = '.Configuration::get('EBS_ID_ORDER_SUCCESS').' and id_lang = 1' );
		Db::getInstance()->Execute
				('
					DELETE FROM `' . _DB_PREFIX_ . 'order_state_lang` 
					 WHERE id_order_state = '.Configuration::get('EBS_ID_ORDER_FAILED').' and id_lang = 1');
				
		
		if (!Configuration::deleteByName('ACCOUNT_ID') OR
			!Configuration::deleteByName('SECRET_KEY') OR
			!Configuration::deleteByName('MODE') OR 
			!Configuration::deleteByName('EBS_ID_ORDER_SUCCESS') OR
			!Configuration::deleteByName('EBS_ID_ORDER_FAILED') OR
			!parent::uninstall())
			return false;
		return true;
	}
	public function getOrderState()
	{

			$id=Db::getInstance()->getRow
			('
				SELECT max(id_order_state) as id FROM `' . _DB_PREFIX_ . 'order_state`
			');

			$id['id']++;
			return $id['id'];

		
	}
	public function getContent()
	{
		$this->_html = '<h2>E-Billing Solution</h2>';
		if (isset($_POST['submitEBS']))
		{
			if (empty($_POST['account_id']))
				$this->_postErrors[] = $this->l('Account ID is required.');
			if (empty($_POST['secret_key']))
				$this->_postErrors[] = $this->l('EBS secret key is required.');
			if (empty($_POST['mode']))
			{
				$_POST['mode'] = "LIVE";
			}
			else
				$_POST['mode']="TEST";
				
			if (!sizeof($this->_postErrors))
			{
				Configuration::updateValue('ACCOUNT_ID', $_POST['account_id']);
				Configuration::updateValue('SECRET_KEY', $_POST['secret_key']);
				Configuration::updateValue('MODE', $_POST['mode']);
				$this->displayConf();
			}
			else
				$this->displayErrors();
		
		}
		$this->displayEBS();
		$this->displayFormSettings();
		return $this->_html;
	}

	public function displayConf()
	{
		$this->_html .= '
		<div class="conf confirm">
			<img src="../img/admin/ok.gif" alt="'.$this->l('Confirmation').'" />
			'.$this->l('Settings updated').'
		</div>';
	}

	public function displayErrors()
	{
		$nbErrors = sizeof($this->_postErrors);
		$this->_html .= '
		<div class="alert error">
			<h3>'.($nbErrors > 1 ? $this->l('There are') : $this->l('There is')).' '.$nbErrors.' '.($nbErrors > 1 ? $this->l('errors') : $this->l('error')).'</h3>
			<ol>';
		foreach ($this->_postErrors AS $error)
			$this->_html .= '<li>'.$error.'</li>';
		$this->_html .= '
			</ol>
		</div>';
	}


	public function displayEBS()
	{
		$this->_html .= '
		<img src="../modules/EBS/logo.gif" style="float:left; padding: 10px 0px; margin-right:15px;" />
		<b>'.$this->l('This module allows you to accept payments by EBS.').'</b><br /><br />
		'.$this->l('If the client chooses this payment mode, your EBS account will be automatically credited.').'<br />
		'.$this->l('You need to configure your EBS account first before using this module.').'
		<br /><br /><br />';
	}

	public function displayFormSettings()
	{
		$conf = Configuration::getMultiple(array('ACCOUNT_ID',
												'SECRET_KEY',
												'MODE'));
												
		$account_id = array_key_exists('account_id', $_POST) ? $_POST['account_id'] : (array_key_exists('ACCOUNT_ID', $conf) ? $conf['ACCOUNT_ID'] : '');
		$secret_key = array_key_exists('secret_key', $_POST) ? $_POST['secret_key'] : (array_key_exists('SECRET_KEY', $conf) ? $conf['SECRET_KEY'] : '');
		$mode =array_key_exists('mode', $_POST) ? $_POST['mode'] : (array_key_exists('EBS_mode', $conf) ? $conf['EBS_mode'] : '');
		
		
		if($mode=="LIVE")
			$mode="";
		else if($mode=="TEST")
			$mode="1";
		
		$currency = array_key_exists('currency', $_POST) ? $_POST['currency'] : (array_key_exists('EBS_CURRENCY', $conf) ? $conf['EBS_CURRENCY'] : 'prestashop');

		$this->_html .= '
		<form action="'.$_SERVER['REQUEST_URI'].'" name="submitEBS" method="post">
		<fieldset>
			<legend><img src="../img/admin/contact.gif" />'.$this->l('Settings').'</legend>
			<label>'.$this->l('Account ID').'</label>
			<div class="margin-form"><input type="text" name="account_id" value="'.$account_id.'" size="4" /></div>
			<label>'.$this->l('Secret Key').'</label>
			<div class="margin-form"><input type="text" size="33" name="secret_key" value="'.$secret_key.'" /></div>
			
			<label>'.$this->l('Test Mode').'</label>
			<div class="margin-form">
			
			<input type="checkbox" name="mode" "'.($mode ? 'checked="checked"' : '').' /> 
			 
			</div>
			<br /><center><input type="submit" name="submitEBS" value="'.$this->l('Update settings').'" class="button" /></center>
		</fieldset>
		</form><br /><br />
		';
	}

	public function hookPayment($params)
	{
		global $smarty,$cart, $isBetaUser;
		
		if ($cart->id_currency != 4)
			return ;
		
		$countryarray=array("IN"=>"IND","DE"=>"DEU","BR"=>"BRA","DE"=>"DEU","AT"=>"AUT","BE"=>"BEL","CA"=>"CAN","CN"=>"CHN","ES"=>"ESP","FI"=>"FIN","FR"=>"FRA","GR"=>"GRC","IT"=>"ITA","JP"=>"JPN","LU"=>"LUX","NL"=>"NLD","PL"=>"POL","PT"=>"PRT","CZ"=>"CZE","GB"=>"GBR","SE"=>"SWE","CH"=>"CHE","DK"=>"DNK","US"=>"USA","HK"=>"HKG","NO"=>"NOR","AU"=>"AUS","SG"=>"SGP","IE"=>"IRL","NZ"=>"NZL","KR"=>"KOR","IL"=>"ISR","ZA"=>"ZAF","NG"=>"NGA","CI"=>"CIV","TG"=>"TGO","BO"=>"BOL","MU"=>"MUS","RO"=>"ROU","SK"=>"SVK","DZ"=>"DZA","AS"=>"ASM","AD"=>"AND","AO"=>"AGO","AI"=>"AIA","AG"=>"ATG","AR"=>"ARG","AM"=>"ARM","AW"=>"ARW","AZ"=>"AZE","BS"=>"BHS","BH"=>"BHR","BD"=>"BGD","BB"=>"BRB","BY"=>"BLR","BZ"=>"BLZ","BJ"=>"BEN","BM"=>"BMU","BT"=>"BTN","BW"=>"BWA","BN"=>"BRN","BF"=>"BFA","MM"=>"MMR","BI"=>"BDI","KH"=>"KHM","CM"=>"CMR","CV"=>"CPV","CF"=>"CAF","TD"=>"TCD","CL"=>"CHL","CO"=>"COL","KM"=>"COM","CD"=>"COD","CG"=>"COG","CR"=>"CRI","HR"=>"HRV","CU"=>"CUB","CY"=>"CYP","DJ"=>"DJI","DM"=>"DMA","DO"=>"DOM","TL"=>"TLS","EC"=>"ECU","EG"=>"EGY","SV"=>"SLV","GQ"=>"GNQ","ER"=>"ERI","EE"=>"EST","ET"=>"ETH","FK"=>"FLK","FO"=>"FRO","FJ"=>"FJI","GA"=>"GAB","GM"=>"GMB","GE"=>"GEO","GH"=>"GHA","GD"=>"GRD","GL"=>"GRL","GI"=>"GIB","GP"=>"GLP","GU"=>"GUM","GT"=>"GTM","GG"=>"GGY","GN"=>"GIN","GP"=>"GLP","GW"=>"GNB","GY"=>"GUY","HT"=>"HTI","HM"=>"HMD","VA"=>"VAT","HN"=>"HND","IS"=>"ISL","ID"=>"IDN","IR"=>"IRN","IQ"=>"IRQ","IM"=>"IMN","JM"=>"JAM","JE"=>"JEY","JO"=>"JOR","KZ"=>"KAZ","KE"=>"KEN","KI"=>"KIR","KP"=>"PRK","KW"=>"KWT","KG"=>"KGZ","LA"=>"LAO","LV"=>"LVA","LB"=>"LBN","LS"=>"LSO","LR"=>"LBR","LS"=>"LSO","LR"=>"LBR","LY"=>"LBY","LI"=>"LIE","LT"=>"LTU","MO"=>"MAC","MK"=>"MKD","MG"=>"MDG","MW"=>"MWI","MY"=>"MYS","MV"=>"MDV","ML"=>"MLI","MT"=>"MLT","MH"=>"MHL","MQ"=>"MTQ","MR"=>"MRT","HU"=>"HUN","YT"=>"MYT","MX"=>"MEX","FM"=>"FSM","MD"=>"MDA","MC"=>"MCO","MN"=>"MNG","ME"=>"MNE","MS"=>"MSR","MA"=>"MAR","MZ"=>"MOZ","NA"=>"NAM","NR"=>"NRU","NP"=>"NPL","AN"=>"ANT","NC"=>"NCL","NI"=>"NIC","NE"=>"NER","NU"=>"NIU","NF"=>"NFK","MP"=>"MNP","OM"=>"OMN","PK"=>"PAK","PW"=>"PLW","PS"=>"PSE","PA"=>"PAN","PG"=>"PNG","PY"=>"PRY","PE"=>"PER","PH"=>"PHL","PN"=>"PCN","PR"=>"PRI","QA"=>"QAT","RE"=>"REU","RU"=>"RUS","RW"=>"RWA","BL"=>"BLM","KN"=>"KNA","LC"=>"LCA","MF"=>"MAF","PM"=>"SPM","VC"=>"VCT","WS"=>"WSM", "SM"=>"SMR", "ST"=>"STP","SA"=>"SAU", "SN"=>"SEN","RS"=>"SRB","SC"=>"SYC", "SL"=>"SLE","SI"=>"SVN","SB"=>"SLB","SO"=>"SOM","GS"=>"SGS","LK"=>"LKA","SD"=>"SDN","SR"=>"SUR","SJ"=>"SJM","SZ"=>"SWZ","SY"=>"SYR","TW"=>"TWN","TJ"=>"TJK","TZ"=>"TZA","TH"=>"THA","TK"=>"TKL","TO"=>"TON","TT"=>"TTO","TN"=>"TUN","TR"=>"TUR","TM"=>"TKM","TC"=>"TCA","TV"=>"TUV","UG"=>"UGA","UA"=>"UKR","AE"=>"ARE","UY"=>"URY","UZ"=>"UZB","VU"=>"VUT","VE"=>"VEN","VN"=>"VNM","VG"=>"VGB","VI"=>"VIR","WF"=>"WLF","EH"=>"ESH","YE"=>"YEM","ZM"=>"ZMB","ZW"=>"ZWE","AL"=>"ALB","AF"=>"AFG","AQ"=>"ATA","BA"=>"BIH","BV"=>"BVT","IO"=>"IOT","BG"=>"BGR","KY"=>"CYM","CX"=>"CXR","CC"=>"CCK","CK"=>"COK","GF"=>"GUF","PF"=>"PYF","TF"=>"ATF","AX"=>"ALA");
		$address = new Address(intval($params['cart']->id_address_invoice));
		$customer = new Customer(intval($params['cart']->id_customer));
		$secret_key = Configuration::get('SECRET_KEY');
		$account_id= Configuration::get('ACCOUNT_ID');
		$mode = Configuration::get('MODE');
		$id_currency = intval(Configuration::get('PS_CURRENCY_DEFAULT'));

		$currency = new Currency(intval($id_currency));
		$countryiso2=new Country(intval($address->id_country));
		$countryiso2->iso_code=$countryarray[$countryiso2->iso_code];
		$state=new State($address->id_state);
		if (!Validate::isLoadedObject($address) OR !Validate::isLoadedObject($customer))
			return $this->l('EBS error: (invalid address or customer)');

		if($isBetaUser)
		{
			$amount = Tools::convertPrice($params['cart']->getOrderTotal(true, 4, false), $currency);
			$total = Tools::convertPrice($params['cart']->getOrderTotal(true, 3, false), $currency);
		}
		else 
		{
			$amount = Tools::convertPrice($params['cart']->getOrderTotal(true, 4, true), $currency);
			$total = Tools::convertPrice($params['cart']->getOrderTotal(true, 3, true), $currency);
		}
		
		$amount = Tools::ps_round(floatval($amount), 0, true);
		$total = Tools::ps_round(floatval($total), 0, true);
		$total = number_format($total, 2, '.', '');
		
		$return_url = 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'modules/EBS/thank-you.php?DR={DR}&cart_id='.intval($cart->id);
		$hash = $secret_key ."|". $account_id. "|". $total . "|".intval($cart->id)."|".html_entity_decode($return_url)."|". $mode;
		
		$securehash = md5($hash);
		
		$smarty->assign(array(
            'this_path' => $this->_path,
			'account_id' => $account_id,
			'address' => $address,
			'country' => $countryiso2,
			'state'	=> $state->name,
			'customer' => $customer,
			'currency' => $currency,
			'mode'	=> $mode,
			'return_url'=> $return_url,
			'EBSUrl' => $this->getEBSUrl(),
			'amount' => $amount,
			'products' => $products,
			'total' => $total,
			'id_cart' => intval($params['cart']->id),
			'customer' => $customer,
			'currency' => $this->currency,
			'products' => $this->products,
			'cartID' => intval($cart->id),
            'this_path_ssl' => (Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://').htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'modules/'.$this->name.'/',
			'secure_hash' => $securehash
        ));

        if($isBetaUser)
        	return $this->display(__FILE__, 'beta/EBS.tpl');
        else
        	return $this->display(__FILE__, 'EBS.tpl');
    }
	
	
	/**
	 * Used outside of the payment hook to populate smarty vars
	 *
	 */
    public function populatePaymentVars()
    {
		global $smarty, $cart, $cookie;

		$address = new Address(intval($cart->id_address_invoice));
		$addressShip = new Address(intval($cart->id_address_delivery));
		$state = new State(intval($address->id_state));
		$address->state = $state->name;
		$state = new State(intval($addressShip->id_state));
		$addressShip->state = $state->name;

		$customer = new Customer(intval($cookie->id_customer));

		$account_id = Configuration::get('ACCOUNT_ID');

		$secret_key = Configuration::get('SECRET_KEY');
			
		$mode = Configuration::get('MODE');

		$id_currency = intval(Configuration::get('PS_CURRENCY_DEFAULT'));
		$this->currency = new Currency(intval($id_currency));

		$this->products = $cart->getProducts();


		foreach ($this->products as $key => $product)
		{
			$this->products[$key]['name'] = str_replace('"', '\'', $product['name']);
			if (isset($product['attributes']))
				$this->products[$key]['attributes'] = str_replace('"', '\'', $product['attributes']);
			$this->products[$key]['name'] = htmlentities(utf8_decode($product['name']));
			$this->products[$key]['EBSAmount'] = number_format(Tools::convertPrice($product['price_wt'], $this->currency), 2, '.', '');
		}
		
		$smarty->assign(array(
			'EBSUrl' => $this->getEBSUrl()
		));

    }

	/**
	 * Attempts to finalize an accepted transaction
	 *
	 * @result string Should be 'accepted' unless something has gone quite wrong
	 */
    public function finalizeOrder($response)
    {
    	global $smarty, $cart, $cookie;
		require(dirname(__FILE__).'/Rc43.php');
		
	

		$DR=$response;
		
		$secret_key = Configuration::get('SECRET_KEY');	 
		//print_r($secret_key);
		
			
		if(isset($DR)) {
		
			 $DR = preg_replace("/\s/","+",$DR);
			
			 $rc4 = new Crypt_RC4($secret_key);
		 	 $QueryString = base64_decode($DR);
			
			 $rc4->decrypt($QueryString);
			 $QueryString = split('&',$QueryString);
		
			 $response = array();
			 foreach($QueryString as $param){
			 	$param = split('=',$param);
				$response[$param[0]] = urldecode($param[1]);
				
			 }
		//print_r($response);
		
		}
	 
		$cartID=$response['MerchantRefNo'];
	
		$cart = new Cart($cartID);
		$deliveryAddress = new Address($cart->id_address_delivery);
		$op = $cod = 0;
		Carrier::getPreferredCarriers($deliveryAddress->postcode, $cod, $op);
		if($op > 0)
		{
			$cart->id_carrier = (int)$op;
			$cart->update();
		}
		
		if($response['ResponseCode'] == 0)
			$responseMsg="Your Order has Been Processed";
		else 
			$responseMsg="Transaction Failed, Retry!!";
	
			$cart = new Cart(intval($response['MerchantRefNo']));
	//echo "<pre>";print_r($cart);
			
			//if (!$cart->id)
			//	return $this->l('Cart not found');
				
				if($response['ResponseCode'] == 0)
					$status= _PS_OS_PREPARATION_;
				else 
					$status=Configuration::get('EBS_ID_ORDER_FAILED');

	
		
		$this->validateOrder($response['MerchantRefNo'], $status, $response['Amount'], $this->displayName, $this->l('EBS transaction ID: ') . $response['PaymentID'], $response['ResponseMessage']);
		$customer = new Customer((int)$cart->id_customer);
		if($response['ResponseCode'] == 0)
			Tools::redirectLink(__PS_BASE_URI__.'order-confirmation.php?key='.$customer->secure_key.'&id_cart='.(int)($cart->id).'&id_module='.(int)$this->id.'&id_order='.(int)$this->currentOrder);
		
		$smarty->assign(array('this_path' => $this->_path,
					'responseMsg'	=> $responseMsg,
					'this_path_ssl' => (Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://').htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'modules/'.$this->name.'/'
					));
		
    }

}
?>
