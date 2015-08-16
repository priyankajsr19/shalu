<?php

class ManufacturerControllerCore extends FrontController
{
	protected $manufacturer;
	protected $pageProducts;
	
	public function setMedia()
	{
		parent::setMedia();
		//Tools::addCSS(_THEME_CSS_DIR_.'product_list.css');
	}
	
	public function preProcess()
	{
		if ($id_manufacturer = Tools::getValue('id_manufacturer'))
		{
			$this->productSort();
			$remarketing_code = false;
			switch($id_manufacturer)
			{
				case 116:
					$remarketing_code = "kl92CIiC5QMQmKP4zQM";
					break;
				case 95:
					$remarketing_code = "sNEZCJCB5QMQmKP4zQM";
					break;
				case 81:
					$remarketing_code = "NGiBCJiA5QMQmKP4zQM";
					break;
				case 122:
					$remarketing_code = "RCfKCKD_5AMQmKP4zQM";
					break;
				case 92:
					$remarketing_code = "0IK5CKj-5AMQmKP4zQM";
					break;
				case 80:
					$remarketing_code = "aJbDCLD95AMQmKP4zQM";
					break;
				case 71:
					$remarketing_code = "OusXCLj85AMQmKP4zQM";
					break;
				case 70:
					$remarketing_code = "QCzPCMD75AMQmKP4zQM";
					break;
				case 82:
					$remarketing_code = "U56cCMj65AMQmKP4zQM";
					break;
				case 74:
					$remarketing_code = "R5LhCND55AMQmKP4zQM";
					break;
				case 76:
					$remarketing_code = "DEchCKjAuwMQmKP4zQM";
					break;
				case 78:
					$remarketing_code = "Pgf6CKDBuwMQmKP4zQM";
					break;
				case 91:
					$remarketing_code = "_SisCMCoxwMQmKP4zQM";
					break;
				case 11:
					$remarketing_code = "2OGTCJCuxwMQmKP4zQM";
					break;
				case 18:
					$remarketing_code = "96c8CICwxwMQmKP4zQM";
					break;
				case 73:
					$remarketing_code = "IMWcCPiwxwMQmKP4zQM";
					break;
				case 79:
					$remarketing_code = "ONBTCPCxxwMQmKP4zQM";
					break;
				case 121:
					$remarketing_code = "l37kCND68QMQmKP4zQM";
					break;
				case 162:
					$remarketing_code = "DPxqCNj58QMQmKP4zQM";
					break;
				case 69:
					$remarketing_code = "Nj-6CPiD5QMQmKP4zQM";
					break;
				case 119:
					$remarketing_code = "mQJ6CICD5QMQmKP4zQM";
					break;
				case 132:
					$remarketing_code = "ptPzCMj78QMQmKP4zQM";
					break;
				case 153:
					$remarketing_code = "wplxCLD-8QMQmKP4zQM";
					break;
				case 135:
					$remarketing_code = "1FgSCMD88QMQmKP4zQM";
					break;
				case 94:
					$remarketing_code = "RvR3CLj98QMQmKP4zQM";
					break;
			}
			
			if($remarketing_code)
				self::$smarty->assign('remarketing_code', $remarketing_code);
			$this->manufacturer = new Manufacturer((int)$id_manufacturer, self::$cookie->id_lang);
			if (Validate::isLoadedObject($this->manufacturer) AND $this->manufacturer->active)
			{
				$nbProducts = 0;
				$this->n = (int)(Configuration::get('PS_PRODUCTS_PER_PAGE'));
				$this->p = abs((int)(Tools::getValue('p', 1)));
				
				try
				{
				    global $cart, $cookie;
				    $id_country = (int)Country::getDefaultCountryId();
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
				     
				    self::$smarty->assign('price_tax_country', $id_country);
				    
				    $products = SolrSearch::getBrandProducts((int)$id_manufacturer, $nbProducts);
				}
				catch(Exception $e)
				{
				    self::$smarty->assign('fetch_error', 1);
				}
				
				//$nbProducts = $this->manufacturer->getProducts((int)$id_manufacturer, NULL, NULL, NULL, $this->orderBy, $this->orderWay, true);
				$this->pagination((int)$nbProducts);
				$this->page_products = $products;
				self::$smarty->assign(array(
					'nb_products' => $nbProducts,
					'products' => $this->page_products,
					'path' => ($this->manufacturer->active ? Tools::safeOutput($this->manufacturer->name) : ''),
					'manufacturer' => $this->manufacturer));
				if($this->manufacturer->description)
					self::$smarty->assign('show_details', 1);
				self::$smarty->assign('lazy', 1);
			}
			else
			{
				header('HTTP/1.1 404 Not Found');
				header('Status: 404 Not Found');
				$this->errors[] = Tools::displayError('Manufacturer does not exist.');
			}
		}
		else
		{
			if (Configuration::get('PS_DISPLAY_SUPPLIERS'))
			{
				//$data = call_user_func(array('Manufacturer', 'getManufacturers'), true, (int)(self::$cookie->id_lang), true);
				
				//$this->pagination($nbProducts);
		
				$data = call_user_func(array('Manufacturer', 'getManufacturers'), true, (int)(self::$cookie->id_lang), true, $this->p, $this->n);
				$nbProducts = count($data);
				$imgDir = _PS_MANU_IMG_DIR_;
				
				/*
				$data = array('acute nightmare','agricultural clown',
					'banana','barry scott','beanie','Beechams ','big eyes','board pin ',
					'cable','calendar','catagorical','Cauliflower','chainlegs','cheese','chicken ','chicken flavoured sugar sip noodle puffs','chronological',
					'dance like michael barrymore','deep down in the desert','Dentalux','dillon','dingleberries','Dreadonaught','dumplings',
					'ejaculation','elastic band wagon','elastic face','extra long wizard sword',
					'facebook','fat goose blister','gammon','Garfunkle flan','gem nose','giggle','glistening old one','glory hole','glue','goldblend',
					'harry and the food of the world','hash brown','inbox','jim','kak','kettle','key licence','lecturer','little kangaroo pouch','little mouse','loin cloth','lovejuice','Love walrus',
					'makes you weird','mankini','nail stuff','nitro','no more','nostrillious','oblong','pad','pages','paper measure','pen on the new face of a legend',
					'radiator','sadomasakistic monk jack','square circle','squid climbing frame','strangers','sugar beet rat','sugar momma','suger plum hole','syndrome','syngenta',
					'tape','teddy','urinal','woolworths','you');
					*/
				$chars = range('A', 'Z');
				$brandsIndex = array();
				foreach($chars as $char)
					$brandsIndex[$char] = array();
				
				foreach($data as $brand)
				{
					$char = strtoupper(substr($brand['name'], 0, 1));
					array_push($brandsIndex[$char], $brand);
				}
				
				$colNumbers = array(0,1,2,3,4);
				$cols = array();
				
				foreach($colNumbers as $colNumber)
					$cols[$colNumber] = array();
				
				$totalGroupSize = 0;
				foreach($brandsIndex as $brandChar => $brandGroup)
				{
					$totalGroupSize = $totalGroupSize + 60 + count($brandGroup) * 18;
				}
				
				$maxColSize = ($totalGroupSize / 5) + 90;
				
				$curCol = 0; $curColSize = 0;
				foreach($brandsIndex as $brandChar => $brandGroup)
				{
					$curGroupSize = 60 + count($brandGroup) * 18;
					if(($curColSize + $curGroupSize) < $maxColSize)
					{
						$cols[$curCol][$brandChar] = $brandGroup;
						$curColSize = $curColSize + $curGroupSize;
					}
					else
					{
						$curCol++;
						$cols[$curCol][$brandChar] = $brandGroup;
						$curColSize = $curGroupSize;
					}
				}
				/*
				$chars = range('A', 'Z');
				$brandsIndex = array();
				foreach($chars as $char)
					$brandsIndex[$char] = array();
				
				foreach($data as $brand)
				{
					$char = strtoupper(substr($brand['name'], 0, 1));
					array_push($brandsIndex[$char], $brand);
				}
				
				foreach ($data AS &$item)
				{
					$item['image'] = (!file_exists($imgDir.'/'.$item['id_manufacturer'].'-medium.jpg')) ? 
						Language::getIsoById((int)(self::$cookie->id_lang)).'-default' :	$item['id_manufacturer'];
				}
				*/
				self::$smarty->assign(array(
				'cols' => $cols,
				'brandsIndex' => $brandsIndex,
				'nbManufacturers' => $nbProducts,
				'mediumSize' => Image::getSize('medium'),
				'manufacturers' => $data,
				'add_prod_display' => Configuration::get('PS_ATTRIBUTE_CATEGORY_DISPLAY'),
				));
			}
			else
				self::$smarty->assign('nbManufacturers', 0);
		}
	}
	
	public function getTopSalesProducts()
	{
		//see if the html fragment is in memcache
		$memcache = new Memcache();
		if($memcache->connect('127.0.0.1', 11211))
		{
			$topProducts = $memcache->get('brand-top-products-'.$this->manufacturer->id);
			if($topProducts) return $topProducts;
			else 
			{
				$topProducts = ProductSale::getBestSalesManufacturer((int)(self::$cookie->id_lang), $this->manufacturer->id, 0, 15, null, null, false);
				$memcache->set('brand-top-products-'.$this->manufacturer->id, $topProducts, false, 172800); //cache for 2 days
				return $topProducts;
			}
		}
		else 
		{
			return ProductSale::getBestSalesManufacturer((int)(self::$cookie->id_lang), $this->manufacturer->id, 0, 15, null, null, false);
		}
	}
	
	public function process()
	{
		self::$smarty->assign('products', $this->page_products);
		/*$ids = range(1,227);
		$this->SEOshuffle($ids, $this->manufacturer->id);
		$ids = array_slice($ids, 0, 20);
		$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("select keyword,url from ps_seo_keywords where id in (". implode(",", $ids) . ")");
		
		$topSalesProducts = $this->getTopSalesProducts();
		self::$smarty->assign('topSalesProducts', $topSalesProducts);
		
		self::$smarty->assign('seo_keywords', $res);*/
	}
	
	function SEOshuffle(&$items, $seed=false) {
	  $original = md5(serialize($items));
	  mt_srand(crc32(($seed) ? $seed : $items[0]));
	  for ($i = count($items) - 1; $i > 0; $i--){
	    $j = @mt_rand(0, $i);
	    list($items[$i], $items[$j]) = array($items[$j], $items[$i]);
	  }
	  if ($original == md5(serialize($items))) {
	    list($items[count($items) - 1], $items[0]) = array($items[0], $items[count($items) - 1]);
	  }
	}
	
	public function displayHeader()
	{
		global $link;
		//self::$smarty->assign('show_banner', 1);
		if(Tools::getValue('orderby', false))
			self::$smarty->assign('nobots', 1);
			
		if ($id_manufacturer = Tools::getValue('id_manufacturer'))
		{
			$this->manufacturer = new Manufacturer((int)$id_manufacturer, self::$cookie->id_lang);
			if (Validate::isLoadedObject($this->manufacturer) AND $this->manufacturer->active)
			{
				$pageTitle = $this->manufacturer->name .' | Buy ' . $this->manufacturer->name . ' products online in India - IndusDiva.com';
				$pageDescription =  'Shop for 100% authentic '. $this->manufacturer->name .' products online at discounted rates! Free Shipping & Cash on Delivery anywhere in India.';
				
				self::$smarty->assign('meta_title', $pageTitle);
				self::$smarty->assign('meta_description', $pageDescription);
				//$bannername = str_replace(" ", "-", strtolower($this->manufacturer->name));
				//$bannername = str_replace("'", "", $bannername);
				$bannername = $this->manufacturer->banner_img;
				if ($bannername) {
	    			self::$smarty->assign('bannername', $bannername);
				}
				
				$paginationBaseUrl = $link->getmanufacturerLink($id_manufacturer, $this->manufacturer->link_rewrite);
				self::$smarty->assign('paginationBaseUrl', $paginationBaseUrl);
			}
		}
		parent::displayHeader();
	}
	
	public function displayContent()
	{
		parent::displayContent();
		if ($this->manufacturer)
			self::$smarty->display(_PS_THEME_DIR_.'manufacturer.tpl');
		else
			self::$smarty->display(_PS_THEME_DIR_.'manufacturer-list.tpl');
	}
	
}
