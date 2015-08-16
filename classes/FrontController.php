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
*  @version  Release: $Revision: 6925 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class FrontControllerCore
{
	public $errors = array();
	protected static $smarty;
	protected static $cookie;
	protected static $link;
	protected static $cart;
	public $iso;

	public $orderBy;
	public $orderWay;
	public $p;
	public $n;

	public $auth = false;
	public $guestAllowed = false;
	public $authRedirection = false;
	public $ssl = false;
	
	public $facebook;

	protected $restrictedCountry = false;
	protected $maintenance = false;

	public static $initialized = false;

	protected static $currentCustomerGroups;

	public function __construct()
	{
		global $useSSL;

		$useSSL = $this->ssl;
	}

	public function run()
	{
		$this->init();
		$this->preProcess();
		$this->displayHeader();
		$this->process();
		$this->displayContent();
		$this->displayFooter();
	}

	public function init()
	{
		global $cookie, $smarty, $cart, $iso, $defaultCountry, $protocol_link, $protocol_content, $link, $css_files, $js_files;

		if (self::$initialized)
			return;
		self::$initialized = true;
		
		$css_files = array();
		$js_files = array();


		if ($this->ssl AND (empty($_SERVER['HTTPS']) OR strtolower($_SERVER['HTTPS']) == 'off') AND Configuration::get('PS_SSL_ENABLED'))
		{
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: '.Tools::getShopDomainSsl(true).$_SERVER['REQUEST_URI']);
			exit();
		}

		ob_start();
		
		/* Loading default country */
		$defaultCountry = new Country((int)Configuration::get('PS_COUNTRY_DEFAULT'), Configuration::get('PS_LANG_DEFAULT'));

		$cookie = new Cookie('ps');
		$link = new Link();

		if ($this->auth AND !$cookie->isLogged($this->guestAllowed))
			Tools::redirect('authentication.php'.($this->authRedirection ? '?back='.$this->authRedirection : ''));

		/* Theme is missing or maintenance */
		if (!is_dir(_PS_THEME_DIR_))
			die(Tools::displayError('Current theme unavailable. Please check your theme directory name and permissions.'));
		elseif (basename($_SERVER['PHP_SELF']) != 'disabled.php' AND !(int)(Configuration::get('PS_SHOP_ENABLE')))
			$this->maintenance = true;
		elseif (Configuration::get('PS_GEOLOCATION_ENABLED'))
		{
			if(!isset($cookie->iso_code_country))
			{
				if($cookie->logged)
				{
					$id_country = Customer::getCurrentCountry((int)$cookie->id_customer);
					$cookie->iso_code_country = Country::getIsoById($id_country);
				}
				else
					$this->geolocationManagement();
			}
			
			if(!isset($cookie->iso_code_country))
				$current_country_id = Customer::getCurrentCountry((int)$cookie->id_customer);
			else
				$current_country_id = Country::getByIso($cookie->iso_code_country);
			$current_country = new Country($current_country_id, 1);
			
			$cookie->id_country = $current_country->id;
			$smarty->assign('current_country', $current_country->name);
			$smarty->assign('current_country_id', $current_country->id);
			
			if($cookie->id_country == 110 && !isset($cookie->id_currency))
				$cookie->id_currency = 4;
		}
		
		//set imagesize if not set
		if(!isset($cookie->image_size))
		{
			$cookie->image_size = IMAGE_SIZE_LARGE;
			$cookie->write();
		}
		
		if(!isset($cookie->greetings) && !$cookie->logged)
		{
			$cookie->greetings = 1;
			$cookie->write();
			$smarty->assign('show_greetings', 1);
		}
		
		//echo $cookie->image_size;
		
		if($image_size = Tools::getValue("is"))
		{
			if($image_size == "s" && $cookie->image_size == IMAGE_SIZE_LARGE)
			{
				$cookie->image_size = IMAGE_SIZE_SMALL;
				$cookie->write();
			}
			else if($image_size == "l" && $cookie->image_size == IMAGE_SIZE_SMALL)
			{
				$cookie->image_size = IMAGE_SIZE_LARGE;
				$cookie->write();
			}
			
		}

		// Switch language if needed and init cookie language
		if ($iso = Tools::getValue('isolang') AND Validate::isLanguageIsoCode($iso) AND ($id_lang = (int)(Language::getIdByIso($iso))))
			$_GET['id_lang'] = $id_lang;

		Tools::switchLanguage();
		Tools::setCookieLanguage();

		/* attribute id_lang is often needed, so we create a constant for performance reasons */
		if (!defined('_USER_ID_LANG_'))
			define('_USER_ID_LANG_', (int)$cookie->id_lang);

		if (isset($_GET['logout']) OR ($cookie->logged AND Customer::isBanned((int)$cookie->id_customer)))
		{
			$cookie->logout();
			Tools::redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : NULL);
		}
		elseif (isset($_GET['mylogout']))
		{
			$this->logoutFacebook();
			$cookie->mylogout();
			Tools::redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : NULL);
		}
		
		if($source = Tools::getValue('utm_source'))
		{
			$cookie->last_source = $source;
			$cookie->write();
		}
		
		if($ref_source = Tools::getValue('vbref'))
		{
			$cookie->last_ref_source = $ref_source;
			$cookie->write();
		}
		/*else 
		{
			if(!isset($cookie->last_ref_source))
			{
				$cookie->last_ref_source = 0;
				$cookie->write();
			}
		}*/
		
		global $currency;
		$currency = Tools::setCurrency();

		$_MODULES = array();

		/* Cart already exists */
		if ((int)$cookie->id_cart)
		{
			$cart = new Cart((int)$cookie->id_cart);
			if ($cart->OrderExists())
				unset($cookie->id_cart, $cart, $cookie->checkedTOS);
			/* Delete product of cart, if user can't make an order from his country */
			elseif (intval(Configuration::get('PS_GEOLOCATION_ENABLED')) AND 
					!in_array(strtoupper($cookie->iso_code_country), explode(';', Configuration::get('PS_ALLOWED_COUNTRIES'))) AND 
					$cart->nbProducts() AND intval(Configuration::get('PS_GEOLOCATION_NA_BEHAVIOR')) != -1 AND
					!self::isInWhitelistForGeolocation())
				unset($cookie->id_cart, $cart);
			elseif ($cookie->id_customer != $cart->id_customer OR $cookie->id_lang != $cart->id_lang OR $cookie->id_currency != $cart->id_currency)
			{
				if ($cookie->id_customer)
					$cart->id_customer = (int)($cookie->id_customer);
				$cart->id_lang = (int)($cookie->id_lang);
				$cart->id_currency = (int)($cookie->id_currency);
				$cart->update();
			}
			/* Select an address if not set */
			if (isset($cart) && (!isset($cart->id_address_delivery) || $cart->id_address_delivery == 0 || 
				!isset($cart->id_address_invoice) || $cart->id_address_invoice == 0) && $cookie->id_customer)
			{
				$to_update = false;
				if (!isset($cart->id_address_delivery) || $cart->id_address_delivery == 0)
				{
					$to_update = true;
					$cart->id_address_delivery = (int)Address::getFirstCustomerAddressId($cart->id_customer);
				}
				if (!isset($cart->id_address_invoice) || $cart->id_address_invoice == 0)
				{
					$to_update = true;
					$cart->id_address_invoice = (int)Address::getFirstCustomerAddressId($cart->id_customer);
				}
				if ($to_update)
					$cart->update();
			}
		}

		if (!isset($cart) OR !$cart->id)
		{
			$this->checkIDS();
			$cart = new Cart();
			$cart->id_lang = (int)($cookie->id_lang);
			$cart->id_currency = (int)($cookie->id_currency);
			$cart->id_guest = (int)($cookie->id_guest);
			if ($cookie->id_customer)
			{
				$cart->id_customer = (int)($cookie->id_customer);
				$cart->id_address_delivery = (int)(Address::getFirstCustomerAddressId($cart->id_customer));
				$cart->id_address_invoice = $cart->id_address_delivery;
			}
			else
			{
				$cart->id_address_delivery = 0;
				$cart->id_address_invoice = 0;
			}
		}
		if (!$cart->nbProducts())
			$cart->id_carrier = NULL;

		$locale = strtolower(Configuration::get('PS_LOCALE_LANGUAGE')).'_'.strtoupper(Configuration::get('PS_LOCALE_COUNTRY').'.UTF-8');
		setlocale(LC_COLLATE, $locale);
		setlocale(LC_CTYPE, $locale);
		setlocale(LC_TIME, $locale);
		setlocale(LC_NUMERIC, 'en_US.UTF-8');

		if (Validate::isLoadedObject($currency))
			$smarty->ps_currency = $currency;
		if (Validate::isLoadedObject($ps_language = new Language((int)$cookie->id_lang)))
			$smarty->ps_language = $ps_language;

		/* get page name to display it in body id */
		$pathinfo = pathinfo(__FILE__);
		$page_name = basename($_SERVER['PHP_SELF'], '.'.$pathinfo['extension']);
		$page_name = (preg_match('/^[0-9]/', $page_name)) ? 'page_'.$page_name : $page_name;
		$smarty->assign(Tools::getMetaTags($cookie->id_lang, $page_name));
		$smarty->assign('request_uri', Tools::safeOutput(urldecode($_SERVER['REQUEST_URI'])));

		/* Breadcrumb */
		$navigationPipe = (Configuration::get('PS_NAVIGATION_PIPE') ? Configuration::get('PS_NAVIGATION_PIPE') : '>');
		$smarty->assign('navigationPipe', $navigationPipe);

		$protocol_link = (Configuration::get('PS_SSL_ENABLED') OR (!empty($_SERVER['HTTPS']) AND strtolower($_SERVER['HTTPS']) != 'off')) ? 'https://' : 'http://';
		$protocol_content = ((isset($useSSL) AND $useSSL AND Configuration::get('PS_SSL_ENABLED')) OR (!empty($_SERVER['HTTPS']) AND strtolower($_SERVER['HTTPS']) != 'off')) ? 'https://' : 'http://';
		if (!defined('_PS_BASE_URL_'))
			define('_PS_BASE_URL_', Tools::getShopDomain(true));
		if (!defined('_PS_BASE_URL_SSL_'))
			define('_PS_BASE_URL_SSL_', Tools::getShopDomainSsl(true));

		$link->preloadPageLinks();
		$this->canonicalRedirection();

		Product::initPricesComputation();

		$display_tax_label = $defaultCountry->display_tax_label;
		if ($cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')})
		{
			$infos = Address::getCountryAndState((int)($cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
			$country = new Country((int)$infos['id_country']);
			if (Validate::isLoadedObject($country))
				$display_tax_label = $country->display_tax_label;
		}
		
		global $isBetaUser, $conversion_rate_inr;
		$conversion_rate_inr = 55;
		if(!$cookie->isLogged())
		{
			$this->initFacebook();
		}
		else
		{
			$customer_groups = Customer::getGroupsStatic((int)($cookie->id_customer));
			
			if(in_array(2, $customer_groups))
				$smarty->assign('internal_vb_user', 1); 
			
			if(in_array(3, $customer_groups))
				$isBetaUser = true;
			else 
				$isBetaUser = false;

                        /*$reward_points = VBRewards::getCustomerPoints($cookie->id_customer);
			$can_redeem = VBRewards::checkPointsValidity($cookie->id_customer, 0);
			if($can_redeem)
                            $smarty->assign('can_redeem_points', 1);
			$smarty->assign('balance_points', $reward_points);*/
		}
		
		$smarty->assign('img_version', IMG_VERSION);
		
		$this->setRecaptchaHTML();

		if( $page_name === "index" ) {
			$sql = "select title,image_path,url from ps_banner where is_active = 1 order by display_order asc";
			$home_banners = Db::getInstance()->ExecuteS($sql);
			$smarty->assign("home_banners",$home_banners);
		}

		$smarty->assign(array(
		    'lazy' => 1,
			'link' => $link,
			'cart' => $cart,
			'currency' => $currency,
			'cookie' => $cookie,
			'page_name' => $page_name,
			'base_dir' => _PS_BASE_URL_.__PS_BASE_URI__,
			'base_dir_ssl' => $protocol_link.Tools::getShopDomainSsl().__PS_BASE_URI__,
			'content_dir' => $protocol_content.Tools::getShopDomain().__PS_BASE_URI__,
			'tpl_dir' => _PS_THEME_DIR_,
			'modules_dir' => _MODULE_DIR_,
			'mail_dir' => _MAIL_DIR_,
			'lang_iso' => $ps_language->iso_code,
			'come_from' => Tools::getHttpHost(true, true).Tools::htmlentitiesUTF8(str_replace('\'', '', urldecode($_SERVER['REQUEST_URI']))),
			'cart_qties' => (int)$cart->nbProducts(),
			'currencies' => Currency::getCurrencies(),
			'languages' => Language::getLanguages(),
			'priceDisplay' => Product::getTaxCalculationMethod(),
			'add_prod_display' => (int)Configuration::get('PS_ATTRIBUTE_CATEGORY_DISPLAY'),
			'shop_name' => Configuration::get('PS_SHOP_NAME'),
			'roundMode' => (int)Configuration::get('PS_PRICE_ROUND_MODE'),
			'use_taxes' => (int)Configuration::get('PS_TAX'),
			'display_tax_label' => (bool)$display_tax_label,
			'vat_management' => (int)Configuration::get('VATNUMBER_MANAGEMENT'),
			'opc' => (bool)Configuration::get('PS_ORDER_PROCESS_TYPE'),
			'PS_CATALOG_MODE' => (bool)Configuration::get('PS_CATALOG_MODE'),
			'conversion_rate' => $conversion_rate_inr
		));

		// Deprecated
		$smarty->assign(array(
			'id_currency_cookie' => (int)$currency->id,
			'logged' => $cookie->isLogged(),
			'customerName' => ($cookie->logged ? $cookie->customer_firstname.' '.$cookie->customer_lastname : false)
		));

		// TODO for better performances (cache usage), remove these assign and use a smarty function to get the right media server in relation to the full ressource name
		$assignArray = array(
			'img_ps_dir' => _PS_IMG_,
			'img_cat_dir' => _THEME_CAT_DIR_,
			'img_lang_dir' => _THEME_LANG_DIR_,
			'img_prod_dir' => _THEME_PROD_DIR_,
			'img_manu_dir' => _THEME_MANU_DIR_,
			'img_sup_dir' => _THEME_SUP_DIR_,
			'img_ship_dir' => _THEME_SHIP_DIR_,
			'img_store_dir' => _THEME_STORE_DIR_,
			'img_col_dir' => _THEME_COL_DIR_,
			'img_dir' => _THEME_IMG_DIR_,
			'css_dir' => _THEME_CSS_DIR_,
			'js_dir' => _THEME_JS_DIR_,
			'pic_dir' => _THEME_PROD_PIC_DIR_
		);

		foreach ($assignArray as $assignKey => $assignValue)
			if (substr($assignValue, 0, 1) == '/' OR $protocol_content == 'https://')
				$smarty->assign($assignKey, $protocol_content.Tools::getMediaServer($assignValue).$assignValue);
			else
				$smarty->assign($assignKey, $assignValue);

		// setting properties from global var
		self::$cookie = $cookie;
		self::$cart = $cart;
		self::$smarty = $smarty;
		self::$link = $link;

		if ($this->maintenance)
			$this->displayMaintenancePage();
		if ($this->restrictedCountry)
			$this->displayRestrictedCountryPage();

		//live edit
		if (Tools::isSubmit('live_edit') AND $ad = Tools::getValue('ad') AND (Tools::getValue('liveToken') == sha1(Tools::getValue('ad')._COOKIE_KEY_)))
			if (!is_dir(_PS_ROOT_DIR_.DIRECTORY_SEPARATOR.$ad))
				die(Tools::displayError());


		$this->iso = $iso;
		$this->setMedia();
               

		//For sokrati pixel
        	self::$smarty->assign("new_customer_regd", false);
        	if ((int) self::$cookie->new_reg === 1) {
            		self::$smarty->assign("new_customer_regd", true);
            		unset(self::$cookie->new_reg);
        	}
 
                if( self::$cookie->id_customer )
                    self::$smarty->assign("balance_points",VBRewards::getCustomerPoints(self::$cookie->id_customer));
	}

	/* Display a maintenance page if shop is closed */
	protected function displayMaintenancePage()
	{
		if (!in_array(Tools::getRemoteAddr(), explode(',', Configuration::get('PS_MAINTENANCE_IP'))))
		{
			header('HTTP/1.1 503 temporarily overloaded');
			self::$smarty->display(_PS_THEME_DIR_.'maintenance.tpl');
			exit;
		}
	}

	/* Display a specific page if the user country is not allowed */
	protected function displayRestrictedCountryPage()
	{
		global $smarty;

		header('HTTP/1.1 503 temporarily overloaded');
		$smarty->display(_PS_THEME_DIR_.'restricted-country.tpl');
		exit;
	}

	protected function canonicalRedirection()
	{
		global $link, $cookie;

		if (Configuration::get('PS_CANONICAL_REDIRECT'))
		{
			// Automatically redirect to the canonical URL if needed
			if (isset($this->php_self) AND !empty($this->php_self))
			{
				// $_SERVER['HTTP_HOST'] must be replaced by the real canonical domain
				$canonicalURL = $link->getPageLink($this->php_self, $this->ssl, $cookie->id_lang);
				if (!preg_match('/^'.Tools::pRegexp($canonicalURL, '/').'([&?].*)?$/', (($this->ssl AND Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']))
				{
					header('HTTP/1.0 301 Moved');
					$params = '';
					$excludedKey = array('isolang', 'id_lang');
					foreach ($_GET as $key => $value)
						if (!in_array($key, $excludedKey))
							$params .= ($params == '' ? '?' : '&').$key.'='.$value;
					if (defined('_PS_MODE_DEV_') AND _PS_MODE_DEV_ AND $_SERVER['REQUEST_URI'] != __PS_BASE_URI__)
						die('[Debug] This page has moved<br />Please use the following URL instead: <a href="'.$canonicalURL.$params.'">'.$canonicalURL.$params.'</a>');
					Tools::redirectLink($canonicalURL.$params);
				}
			}
		}
	}

	protected function geolocationManagement()
	{
		global $cookie, $smarty;

		if (!in_array($_SERVER['SERVER_NAME'], array('localhost', '127.0.0.1')))
		{
			/* Check if Maxmind Database exists */
			if (file_exists(_PS_GEOIP_DIR_.'GeoLiteCity.dat'))
			{
				if (!isset($cookie->iso_code_country) OR (isset($cookie->iso_code_country) AND !in_array(strtoupper($cookie->iso_code_country), explode(';', Configuration::get('PS_ALLOWED_COUNTRIES')))))
				{
          			include_once(_PS_GEOIP_DIR_.'geoipcity.inc');
					include_once(_PS_GEOIP_DIR_.'geoipregionvars.php');

					$gi = geoip_open(realpath(_PS_GEOIP_DIR_.'GeoLiteCity.dat'), GEOIP_STANDARD);
					$record = geoip_record_by_addr($gi, Tools::getRemoteAddr());

					if (is_object($record) AND !in_array(strtoupper($record->country_code), explode(';', Configuration::get('PS_ALLOWED_COUNTRIES'))) AND !self::isInWhitelistForGeolocation())
					{
						if (Configuration::get('PS_GEOLOCATION_BEHAVIOR') == _PS_GEOLOCATION_NO_CATALOG_)
							$this->restrictedCountry = true;
						elseif (Configuration::get('PS_GEOLOCATION_BEHAVIOR') == _PS_GEOLOCATION_NO_ORDER_)
							$smarty->assign(array(
								'restricted_country_mode' => true,
								'geolocation_country' => $record->country_name
							));
					}
					elseif (is_object($record))
					{
						$cookie->iso_code_country = strtoupper($record->country_code);
						$hasBeenSet = true;
					}
				}

				if (isset($cookie->iso_code_country) AND (int)($id_country = Country::getByIso(strtoupper($cookie->iso_code_country))))
				{
					/* Update defaultCountry */
					$defaultCountry = new Country($id_country);
					if (isset($hasBeenSet) AND $hasBeenSet)
						$cookie->id_currency = (int)(Currency::getCurrencyInstance($defaultCountry->id_currency ? (int)$defaultCountry->id_currency : Configuration::get('PS_CURRENCY_DEFAULT'))->id);
				}
				elseif (Configuration::get('PS_GEOLOCATION_NA_BEHAVIOR') == _PS_GEOLOCATION_NO_CATALOG_)
					$this->restrictedCountry = true;
				elseif (Configuration::get('PS_GEOLOCATION_NA_BEHAVIOR') == _PS_GEOLOCATION_NO_ORDER_)
					$smarty->assign(array(
						'restricted_country_mode' => true,
						'geolocation_country' => 'Undefined'
					));
			}
			/* If not exists we disabled the geolocation feature */
			else
				Configuration::updateValue('PS_GEOLOCATION_ENABLED', 0);
		}
	}

	public function preProcess()
	{
		if (Tools::isSubmit('SubmitLogin') || Tools::getValue('SubmitLogin'))
		{
			Module::hookExec('beforeAuthentication');
			$passwd = trim(Tools::getValue('passwd'));
			$email = trim(Tools::getValue('email'));
			if (empty($email))
				$this->errors[] = Tools::displayError('E-mail address required');
			elseif (!Validate::isEmail($email))
			$this->errors[] = Tools::displayError('Invalid e-mail address');
			elseif (empty($passwd))
			$this->errors[] = Tools::displayError('Password is required');
			elseif (Tools::strlen($passwd) > 32)
			$this->errors[] = Tools::displayError('Password is too long');
			elseif (!Validate::isPasswd($passwd))
			$this->errors[] = Tools::displayError('Invalid password');
			else
			{
				$customer = new Customer();
				$authentication = $customer->getByEmail(trim($email), trim($passwd));
				if (!$authentication OR !$customer->id)
				{
					/* Handle brute force attacks */
					sleep(1);
					$this->errors[] = Tools::displayError('Authentication failed');
				}
				else
				{
					self::$cookie->id_customer = (int)($customer->id);
					self::$cookie->customer_lastname = $customer->lastname;
					self::$cookie->customer_firstname = $customer->firstname;
					self::$cookie->logged = 1;
					self::$cookie->is_guest = $customer->isGuest();
					self::$cookie->passwd = $customer->passwd;
					self::$cookie->email = $customer->email;
					if (Configuration::get('PS_CART_FOLLOWING') AND (empty(self::$cookie->id_cart) OR Cart::getNbProducts(self::$cookie->id_cart) == 0))
						self::$cookie->id_cart = (int)(Cart::lastNoneOrderedCart((int)($customer->id)));
					/* Update cart address */
					self::$cart->id_carrier = 0;
					self::$cart->id_address_delivery = Address::getFirstCustomerAddressId((int)($customer->id));
					self::$cart->id_address_invoice = Address::getFirstCustomerAddressId((int)($customer->id));
					self::$cart->update();
					Module::hookExec('authentication');
					if (!Tools::isSubmit('ajax'))
					{
						if ($back = Tools::getValue('back'))
							Tools::redirect($back);
						Tools::redirect('history.php');
					}
				}
			}
			if (Tools::getValue('ajax'))
			{
				$return = array(
						'hasError' => !empty($this->errors),
						'errors' => $this->errors,
						'token' => Tools::getToken(false)
				);
				die(Tools::jsonEncode($return));
			}
		}
	}

	public function setMedia()
	{
		global $cookie;
		
		Tools::addJS(array(_PS_JS_DIR_.'jquery/jquery-1.7.2.min.js',_PS_JS_DIR_.'jquery/jquery.easing.1.3.js',_PS_JS_DIR_.'jquery/jquery-spin.js',_PS_JS_DIR_.'tools.js'));
		Tools::addJS(_PS_JS_DIR_.'jquery/jquery.cookie.js');
		Tools::addJS(_PS_JS_DIR_.'misc.js');
		Tools::addJS(_PS_JS_DIR_.'jquery/jquery.validate.min.js');
		Tools::addJS(_PS_JS_DIR_.'jquery/jquery.fancybox.pack.js');
		Tools::addJS(_PS_JS_DIR_.'jquery/jquery.cluetip.js');
		Tools::addJS(_THEME_JS_DIR_.'cart-summary.js');
		Tools::addJS(_PS_JS_DIR_.'jquery/jquery-typewatch.pack.js');
		Tools::addJS(_THEME_JS_DIR_.'tools.js');
		
		Tools::addJS(_PS_JS_DIR_.'jquery/jail.js');
		Tools::addJS(_PS_JS_DIR_.'jquery/jquery.tools.min.js');
		//Tools::addJS(_PS_JS_DIR_.'jquery/jquery.autocomplete.js');
		Tools::addJS(_PS_JS_DIR_.'jquery/jquery-ui-autocomplete.js');
		Tools::addJS(_PS_JS_DIR_.'jquery/jquery.select-to-autocomplete.js');
		Tools::addJS(_PS_JS_DIR_.'responsiveslides.min.js');
		//Product page
		Tools::addJS(array(
			_PS_JS_DIR_.'jquery/jquery.scrollTo-1.4.2-min.js',
			_PS_JS_DIR_.'jquery/jquery.serialScroll-1.2.2-min.js',
			_THEME_JS_DIR_.'product.js'));
			
		Tools::addJS(array(_THEME_JS_DIR_.'history.js'));
		
		if (Configuration::get('PS_DISPLAY_JQZOOM') == 1)
		{
			//Tools::addCSS(_PS_CSS_DIR_.'jqzoom.css', 'screen');
			Tools::addJS(_PS_JS_DIR_.'jquery/jquery.jqzoom.js');
		}
		
		//category page
		if (Configuration::get('PS_COMPARATOR_MAX_ITEM') > 0)
			Tools::addJS(_THEME_JS_DIR_.'products-comparison.js');
		Tools::addJS(_MODULE_DIR_.'blocklayered/blocklayered.js');
		Tools::addJS(_PS_JS_DIR_.'jquery/jquery.ba-hashchange.min.js');
		Tools::addJS(_PS_JS_DIR_.'jquery/jquery.easytabs.min.js');
		
		//order flow
		Tools::addJS(_THEME_JS_DIR_.'tools/statesManagement.js');
		Tools::addJS(_THEME_JS_DIR_.'order-address.js');
		
		Tools::addCSS(_PS_CSS_DIR_.'jquery.fancybox.css', 'screen');
		Tools::addCSS(_PS_CSS_DIR_.'jquery.cluetip.css', 'all');
		Tools::addCSS(_THEME_CSS_DIR_.'global.css', 'all');
		Tools::addCSS(_THEME_CSS_DIR_.'addresses.css');
		Tools::addCSS(_THEME_CSS_DIR_.'authentication.css');
		Tools::addCSS(_THEME_CSS_DIR_.'product_list.css');
		Tools::addCSS(array(_THEME_CSS_DIR_.'category.css' => 'all'));
		Tools::addCSS(_THEME_CSS_DIR_.'history.css');
		Tools::addCSS(_THEME_CSS_DIR_.'identity.css');
		Tools::addCSS(_THEME_CSS_DIR_.'my-account.css');
		Tools::addCSS(_THEME_CSS_DIR_.'product.css');
		if (Configuration::get('PS_DISPLAY_JQZOOM') == 1)
		{
			Tools::addCSS(_PS_CSS_DIR_.'jquery.jqzoom.css', 'screen');
			Tools::addJS(_PS_JS_DIR_.'jquery/jquery.jqzoom-core.js');
		}
		Tools::addCSS(_PS_CSS_DIR_.'jquery.autocomplete.css');
		
		if (Tools::isSubmit('live_edit') AND $ad = Tools::getValue('ad') AND (Tools::getValue('liveToken') == sha1(Tools::getValue('ad')._COOKIE_KEY_)))
		{
			Tools::addJS(array(
							_PS_JS_DIR_.'jquery/jquery-ui-1.8.10.custom.min.js',
							_PS_JS_DIR_.'hookLiveEdit.js')
							);
		}
	}

	public function process()
	{
	    $productsViewed = (isset(self::$cookie->viewed) AND !empty(self::$cookie->viewed)) ? array_slice(explode(',', self::$cookie->viewed), 0, 12) : array();
	    //$productsViewed = array(3866, 4553, 2338);
	    
	    global $cart;
	    if($cart->id_address_delivery)
	    {
	        $address = new Address($cart->id_address_delivery);
	        if ($address->id_country)
	        {
	            $id_country = $address->id_country;
	        }
	        elseif (isset($cookie->id_country))
	        {
	            $id_country = (int)$cookie->id_country;
	        }
	    }
	    else
	    {
	    	$id_country = self::$cookie->id_country;
	    }
	     
	    self::$smarty->assign('price_tax_country', $id_country);
	    
	    if (sizeof($productsViewed))
	    {
	        $total_found = 0;
	        try {
	            $recentlyViewed = SolrSearch::getProductsForIDs($productsViewed, $total_found, 1, 12);
	            self::$smarty->assign('recently_viewed', $recentlyViewed);
	        } catch (Exception $e) {
	        }
	    }
	}

	public function displayContent()
	{
		Tools::safePostVars();
		self::$smarty->assign('errors', $this->errors);
	}

	public function displayHeader()
	{
		global $css_files, $js_files, $isBetaUser;
		
		if (!self::$initialized)
			$this->init();

		// P3P Policies (http://www.w3.org/TR/2002/REC-P3P-20020416/#compact_policies)
		header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');

		/* Hooks are volontary out the initialize array (need those variables already assigned) */
		self::$smarty->assign(array(
			'time' => time(),
			'img_update_time' => Configuration::get('PS_IMG_UPDATE_TIME'),
			'static_token' => Tools::getToken(false),
			'token' => Tools::getToken(),
			'logo_image_width' => Configuration::get('SHOP_LOGO_WIDTH'),
			'logo_image_height' => Configuration::get('SHOP_LOGO_HEIGHT'),
			'priceDisplayPrecision' => _PS_PRICE_DISPLAY_PRECISION_,
			'content_only' => (int)Tools::getValue('content_only')
		));
		self::$smarty->assign(array(
			'HOOK_HEADER' => Module::hookExec('header'),
			'HOOK_TOP' => Module::hookExec('top'),
			'HOOK_LEFT_COLUMN' => Module::hookExec('leftColumn')
		));

		if ((Configuration::get('PS_CSS_THEME_CACHE') OR Configuration::get('PS_JS_THEME_CACHE')) AND is_writable(_PS_THEME_DIR_.'cache'))
		{
			// CSS compressor management
			if (Configuration::get('PS_CSS_THEME_CACHE'))
				Tools::cccCss();

			//JS compressor management
			if (Configuration::get('PS_JS_THEME_CACHE'))
				Tools::cccJs();
		}
		
		self::$smarty->assign('css_files', $css_files);
		self::$smarty->assign('js_files', array_unique($js_files));
		
		if($isBetaUser)
		    self::$smarty->display(_PS_THEME_DIR_.'beta/header.tpl');
		else
		    self::$smarty->display(_PS_THEME_DIR_.'header.tpl');
	}

	public function displayFooter()
	{
		global $cookie;
		if (!self::$initialized)
			$this->init();

		self::$smarty->assign(array(
			'HOOK_RIGHT_COLUMN' => Module::hookExec('rightColumn', array('cart' => self::$cart)),
			'HOOK_FOOTER' => Module::hookExec('footer'),
			'content_only' => (int)(Tools::getValue('content_only'))));
		self::$smarty->display(_PS_THEME_DIR_.'footer.tpl');
		//live edit
		if (Tools::isSubmit('live_edit') AND $ad = Tools::getValue('ad') AND (Tools::getValue('liveToken') == sha1(Tools::getValue('ad')._COOKIE_KEY_)))
		{
			self::$smarty->assign(array('ad' => $ad, 'live_edit' => true));
			self::$smarty->display(_PS_ALL_THEMES_DIR_.'live_edit.tpl');
		}
		else
			Tools::displayError();
	}

	public function productSort()
	{
		if (!self::$initialized)
			$this->init();

		$stock_management = (int)(Configuration::get('PS_STOCK_MANAGEMENT')) ? true : false; // no display quantity order if stock management disabled
		$this->orderBy = Tools::getProductsOrder('by', Tools::getValue('orderby'));
		$this->orderWay = Tools::getProductsOrder('way', Tools::getValue('orderway'));

		self::$smarty->assign(array(
			'orderby' => $this->orderBy,
			'orderway' => $this->orderWay,
			'orderbydefault' => Tools::getProductsOrder('by'),
			'orderwayposition' => Tools::getProductsOrder('way'), // Deprecated: orderwayposition
			'orderwaydefault' => Tools::getProductsOrder('way'),
			'stock_management' => (int)($stock_management)));
	}

	public function pagination($nbProducts = 10)
	{
		if (!self::$initialized)
			$this->init();

		$nArray = (int)(Configuration::get('PS_PRODUCTS_PER_PAGE')) != 10 ? array((int)(Configuration::get('PS_PRODUCTS_PER_PAGE')), 10, 20, 50) : array(10, 20, 50);
		asort($nArray);
		$this->n = abs((int)(Tools::getValue('n', ((isset(self::$cookie->nb_item_per_page) AND self::$cookie->nb_item_per_page >= 10) ? self::$cookie->nb_item_per_page : (int)(Configuration::get('PS_PRODUCTS_PER_PAGE'))))));
		$this->p = abs((int)(Tools::getValue('p', 1)));
		$range = 2; /* how many pages around page selected */

		if ($this->p < 0)
			$this->p = 0;

		if (isset(self::$cookie->nb_item_per_page) AND $this->n != self::$cookie->nb_item_per_page AND in_array($this->n, $nArray))
			self::$cookie->nb_item_per_page = $this->n;

		if ($this->p > ($nbProducts / $this->n))
			$this->p = ceil($nbProducts / $this->n);
		$pages_nb = ceil($nbProducts / (int)($this->n));

		$start = (int)($this->p - $range);
		if ($start < 1)
			$start = 1;
		$stop = (int)($this->p + $range);
		if ($stop > $pages_nb)
			$stop = (int)($pages_nb);
		self::$smarty->assign('nb_products', $nbProducts);
		
		$nextPage = $this->p + 1;
		if($this->p == $stop)
		    $nextPage = 0;
		
		$pagination_infos = array(
			'pages_nb' => (int)($pages_nb),
			'p' => (int)($this->p),
			'n' => (int)($this->n),
			'nArray' => $nArray,
			'range' => (int)($range),
			'start' => (int)($start),
			'stop' => (int)($stop),
		    'nextPage' => $nextPage
		);
		self::$smarty->assign($pagination_infos);
	}

	public static function getCurrentCustomerGroups()
	{
		if (!isset(self::$cookie) || !self::$cookie->id_customer)
			return array();
		if (!is_array(self::$currentCustomerGroups))
		{
			self::$currentCustomerGroups = array();
			$result = Db::getInstance()->ExecuteS('SELECT id_group FROM '._DB_PREFIX_.'customer_group WHERE id_customer = '.(int)self::$cookie->id_customer);
			foreach ($result as $row)
				self::$currentCustomerGroups[] = $row['id_group'];
		}
		return self::$currentCustomerGroups;
	}

	protected static function isInWhitelistForGeolocation()
	{
		$allowed = false;
		$userIp = Tools::getRemoteAddr();
		$ips = explode(';', Configuration::get('PS_GEOLOCATION_WHITELIST'));
		if (is_array($ips) AND sizeof($ips))
			foreach ($ips AS $ip)
				if (!empty($ip) AND strpos($userIp, $ip) === 0)
					$allowed = true;
		return $allowed;
	}
	
	protected function checkIDS()
	{
		return;
		$memcache = new Memcache();
		$cacheID = 'last-updated-cart-ids';
		if($memcache->connect('localhost', 11211))
		{
			$last_updated_IDS = $memcache->get($cacheID);
			if($last_updated_IDS && substr($last_updated_IDS, 0, 6) == date("ymd"))
			{
				return;
			}
			else 
			{
				//echo $last_updated_IDS;exit;
				$this->fixIDS();
				$memcache->set($cacheID, date("ymd"), false, 86400);
			}
		}
		else 
			$this->fixIDS();		
	}
	
	protected function fixIDS()
	{
		$order_res = Db::getInstance()->Execute("SHOW TABLE STATUS LIKE 'ps_orders'");
		$order_row = mysql_fetch_assoc($order_res);
		$order_nextautoid = $order_row['Auto_increment'];
		//mysql_close($order_res);
				
		if (substr($order_nextautoid, 0, 6) != date("ymd")) {
			Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.'orders` AUTO_INCREMENT = '.(int)(date("ymd").'0001'));
		}
	
		$cart_res = Db::getInstance()->Execute("SHOW TABLE STATUS LIKE 'ps_cart'");
		$cart_row = mysql_fetch_assoc($order_res);
		$cart_nextautoid = $cart_row['Auto_increment'];
		//mysql_close($cart_res);
	
		if (substr($cart_nextautoid, 0, 6) != date("ymd")) {
			Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.'cart` AUTO_INCREMENT = '.(int)(date("ymd").'0001'));
		}
	}
	
	public function initFacebook()
	{
		global $smarty, $cookie, $cart;
		//echo str_replace('//','/',dirname(__FILE__).'/') .'facebook.php'; exi
		require_once( str_replace('//','/',dirname(__FILE__).'/') .'facebook.php');
		
		// Create our Application instance
		$this->facebook = new Facebook(array(
		  'appId'  => FB_API_KEY,
		  'secret' => FB_SECRET,
		  'cookie' => true
		));
		
		//check if the user has logged in
		$fb_user = $this->facebook->getUser();
		// echo "<script>console.log("+$fb_user+")</script>";
		$userInfo = null;
		
		if ($fb_user) {
		  try {
		    // Proceed knowing you have a logged in user who's authenticated.
		    $customer = new Customer();
		    $customer = $customer->getByFacebookID($fb_user);
		    
		    if($customer)
		    {
		    	$this->loginCustomer($customer);
		    	if(Tools::getValue('fblogin') == 1)
					Tools::redirect('index.php');
				else
				return;
		    }
		    $userInfo = $this->facebook->api("/$fb_user");
		  } catch (FacebookApiException $e) {
		    $this->facebook->logout();
		    $fb_user = null;
		  }
		}
		
		$logoutUrl = $this->facebook->getLogoutUrl(array('next'=>_PS_BASE_URL_.__PS_BASE_URI__.'?mylogout=1'));
		$smarty->assign('fblogout_url', $logoutUrl);
		// Login or logout url will be needed depending on current user state.
		if ($fb_user && $userInfo && $userInfo['email']) 
		{
		  //print_r($userInfo);print_r('<br/>');
		  //dump fb data for this user first
		  $this->dumpFacebookData($fb_user, $userInfo);
			
		  //echo print_r($userInfo);exit;
		  $userEmail = $userInfo['email'];
		  
		  if (Customer::customerExists($userEmail))
		  {
		  	//customer is registered and not logged in
		  	$customer = new Customer();
		  	// print_r($customer);
		  	// print_r('<br/>');
		  	$customer = $customer->getByEmail($userEmail);
		  	// print_r('<br/>will get customer here by email: '.$userEmail);
		  	// print_r($customer);
		  	// print_r('<br/>');
		  	
		  	//check if she is connected
		  	if(!$customer->fbid || $customer->fbid == '')
		  	{
		  		$this->updateCustomerInfo($customer, $userInfo, $fb_user, false);
		  		//print_r($customer);
		  		$customer->update();
		  	}
		  	$this->loginCustomer($customer);
		  }
		  else
		  {
		  	//new customer. create and add this customer and log her in
		  	$customer = new Customer();
		  	
		  	$this->updateCustomerInfo($customer, $userInfo, $fb_user, true);
		  	
		  	if (!$customer->add())
				$this->errors[] = Tools::displayError('An error occurred while logging you in.');
			else
			{
                                //award registration points
                             
                                    
                                VBRewards::addRegistrationPoints($customer->id);
				Tools::addCoupons($customer->id);
				                $cookie->new_reg = 1;
                                $cookie->write();
                               
                                
			        $this->loginCustomer($customer);
				if( (int)self::$cookie->id_country === 110 ) {
					$subject = Mail::l("Welcome to IndusDiva, INR 2500 has been credited to your account");
					$amount = "INR 2500";
				} else {
					$subject = Mail::l("Welcome to IndusDiva, USD 100 has been credited to your account");
					$amount = "USD 100";
				}
				if (!Mail::Send((int)($cookie->id_lang), 'account', 
						$subject,
						array('{firstname}' => $customer->firstname, 
						'{lastname}' => $customer->lastname, 
						'{email}' => $customer->email, 
						'{passwd}' => Tools::getValue('passwd'),
						'{amount}' => $amount), 
						$customer->email, 
						$customer->firstname.' '.$customer->lastname))
					$this->errors[] = Tools::displayError('Cannot send email');
			}
		  }
		} 
		else 
		{
			$redirectURL = _PS_BASE_URL_.__PS_BASE_URI__;
			if(Tools::getValue('back'))
				$redirectURL = $redirectURL.Tools::getValue('back');
				
		 	$loginUrl = $this->facebook->getLoginUrl(
				            array(
				                'scope'         => 'email,user_location,user_birthday',
				                'redirect_uri'  => $redirectURL
				            )
					    );
		  	$smarty->assign('fblogin_url', $loginUrl);
		  	// echo "<script>alert('in')</script>";
		}
		
		if(Tools::getValue('fblogin') == 1){
			// echo "<script>alert('in 1')</script>";
			Tools::redirect('index.php');
		}
	}
	
	
	public function updateCustomerInfo(&$customer, $userInfo, $fbUserId, $all = false)
	{
		global $cookie, $cart;
		
		if($all)
		{
			$customer->firstname = $userInfo['first_name'];
			$customer->lastname = $userInfo['last_name'];
	  		$customer->email = $userInfo['email'];
	  		$customer->passwd = md5($this->facebook->getAccessToken());	
	  		$customer->active = 1;
		}
	  	
	  	$birthdayFields = explode('/', $userInfo['birthday']);
	  	if(sizeof($birthdayFields))
	  	{  // print_r($customer);
	  		$customer->years = $birthdayFields[2];
	  		$customer->months = $birthdayFields[0];
	  		$customer->days = $birthdayFields[1];
	  	}
	  	if($userInfo['gender'] == 'male')
	  		$customer->id_gender = 1;
	  	else if($userInfo['gender'] == 'female')
	  		$customer->id_gender = 2;
	  	
	  	$customer->fbid = $fbUserId;
	  	$customer->fbtoken = $this->facebook->getAccessToken();
	}
	
	public function loginCustomer($customer)
	{
		global $cookie, $cart;
		$cookie->id_customer = (int)($customer->id);
		$cookie->customer_lastname = $customer->lastname;
		$cookie->customer_firstname = $customer->firstname;
		$cookie->passwd = $customer->passwd;
		$cookie->logged = 1;
		$cookie->email = $customer->email;
		$cookie->is_guest = !Tools::getValue('is_new_customer', 1);
		$cart->secure_key = $customer->secure_key;
		if (Configuration::get('PS_CART_FOLLOWING') AND (empty($cookie->id_cart) OR Cart::getNbProducts($cookie->id_cart) == 0))
			$cookie->id_cart = (int)(Cart::lastNoneOrderedCart((int)($customer->id)));
		/* Update cart address */
		$cart->id_carrier = 0;
		$cart->id_address_delivery = Address::getFirstCustomerAddressId((int)($customer->id));
		$cart->id_address_invoice = Address::getFirstCustomerAddressId((int)($customer->id));
		$cart->update();
	}
	
	public function logoutFacebook()
	{
		require_once( str_replace('//','/',dirname(__FILE__).'/') .'facebook.php');

		// Create our Application instance
		$this->facebook = new Facebook(array(
		  'appId'  => FB_API_KEY,
		  'secret' => FB_SECRET
		));
		
		$this->facebook->logout();
	}
	
	public function dumpFacebookData($fbid, $userInfo)
	{
		$dataline = json_encode($userInfo) . "\n";
		$file = FB_DATA_FILE;
		file_put_contents($file, $dataline, FILE_APPEND | LOCK_EX);
	}
	
	public function setRecaptchaHTML()
	{
		global $smarty;
		require_once( str_replace('//','/',dirname(__FILE__).'/') .'recaptchalib.php');
		//require_once('recaptchalib.php');
        $publickey = "6Le-b9kSAAAAAFKiNjI9BL2nyxxVaGKSPbN8Zq7V";
        $smarty->assign('recaptchaHTML', recaptcha_get_html($publickey));
	}
}

