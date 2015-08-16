<?php

class SearchControllerCore extends FrontController
{
	public $instantSearch;
	public $ajaxSearch;
	
	public function __construct()
	{
		$this->php_self = 'search.php';
		
		parent::__construct();
		
		$this->instantSearch = Tools::getValue('instantSearch');
		$this->ajaxSearch = Tools::getValue('ajaxSearch');
	}
	
	public function preProcess()
	{
		parent::preProcess();
		
		$query = urldecode(Tools::getValue('q'));
		if ($this->ajaxSearch)
		{
			self::$link = new Link();
			$searchResults = Search::find((int)(Tools::getValue('id_lang')), $query, 1, 10, 'position', 'desc', true);
			foreach ($searchResults AS &$product)
				$product['product_link'] = self::$link->getProductLink($product['id_product'], $product['prewrite'], $product['crewrite']);
			die(Tools::jsonEncode($searchResults));
		}
		
		if ($this->instantSearch && !is_array($query))
		{
			$this->productSort();
			$this->n = abs((int)(Tools::getValue('n', Configuration::get('PS_PRODUCTS_PER_PAGE'))));
			$this->p = abs((int)(Tools::getValue('p', 1)));
			$search = Search::find((int)(self::$cookie->id_lang), $query, $this->p, $this->n, 'position', 'desc');
			Module::hookExec('search', array('expr' => $query, 'total' => $search['total']));
			$nbProducts = $search['total'];
			$this->pagination($nbProducts);
			self::$smarty->assign(array(
			'products' => $search['result'], // DEPRECATED (since to 1.4), not use this: conflict with block_cart module
			'search_products' => $search['result'],
			'nbProducts' => $search['total'],
			'search_query' => $query,
			'instantSearch' => $this->instantSearch,
			'homeSize' => Image::getSize('home')));
		}
		elseif ($query = Tools::getValue('search_query', Tools::getValue('ref')) AND !is_array($query))
		{
			$this->productSort();
			$this->n = abs((int)(Tools::getValue('n', Configuration::get('PS_PRODUCTS_PER_PAGE'))));
			$this->p = abs((int)(Tools::getValue('p', 1)));
			//$search = Search::find((int)(self::$cookie->id_lang), $query, $this->p, $this->n, 'position', 'desc');
			
			$other_results = false;
			
			try
			{
			    //get the right address for this cart
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
			    
			    $resultSet = Search::searchProducts($query, $this->p, $this->n, $other_results);
    			$products = $resultSet->getData();
    			$products = $products['response']['docs'];
    			$total_results = $resultSet->getNumFound();
			}
			catch(Exception $e)
			{
			    self::$smarty->assign('fetch_error', 1);
			}
			
			Module::hookExec('search', array('expr' => $query, 'total' => $total_results));
			
			$this->pagination($total_results);
			self::$smarty->assign(array(
			'products' => $products, // DEPRECATED (since to 1.4), not use this: conflict with block_cart module
			'search_products' => $products,
			'nbProducts' => $total_results,
			'search_query' => $query,
			'homeSize' => Image::getSize('home'),
			'ssResults' => $other_results));
			
			$generic_description = "Buy the widest range of sarees, salwar kameez, kurtis, tunics and ghaghra cholis by shopping online at IndusDiva.com, India's leading online store for buying #phrase#. All products are double-checked for quality before they get shipped and we take extra care to ensure the safety of your order. We deliver products all over the world through leading courier service providers to ensure timely and hassle-free deliveries.
									<br><br>
									To buy #phrase#, all you need to do is review your shopping cart and provide the address details and phone number at checkout. IndusDiva.com offers the best available price across all online shopping sites and provides the best collection of Indian wear online. Shopping for Indian saris, blouse and salwar kurta online just turned more fun as getting your hands on #phrase# has never been so easy.";
			$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("select description from ps_seo_keywords where keyword = '".$query."'");
			if(count($res) > 0)
				self::$smarty->assign('search_description', str_replace('#phrase#', $query, $res[0]['description']));
			else
				self::$smarty->assign('search_description', str_replace('#phrase#', $query, $generic_description));
		}
		elseif ($tag = urldecode(Tools::getValue('tag')) AND !is_array($tag))
		{
			$nbProducts = (int)(Search::searchTag((int)(self::$cookie->id_lang), $tag, true));
			$this->pagination($nbProducts);
			$result = Search::searchTag((int)(self::$cookie->id_lang), $tag, false, $this->p, $this->n, $this->orderBy, $this->orderWay);
			Module::hookExec('search', array('expr' => $tag, 'total' => sizeof($result)));
			self::$smarty->assign(array(
			'search_tag' => $tag,
			'products' => $result, // DEPRECATED (since to 1.4), not use this: conflict with block_cart module
			'search_products' => $result,
			'nbProducts' => $nbProducts,
			'homeSize' => Image::getSize('home')));
		}
		else
		{
			self::$smarty->assign(array(
			'products' => array(),
			'search_products' => array(),
			'pages_nb' => 1,
			'nbProducts' => 0));
		}
		self::$smarty->assign('add_prod_display', Configuration::get('PS_ATTRIBUTE_CATEGORY_DISPLAY'));
		self::$smarty->assign('lazy', 1);
	}
	
	public function displayHeader()
	{
		$query = urldecode(Tools::getValue('search_query'));
		
		$pageTitle = $query . ' | ' . 'Buy ' . $query . ' online in India - IndusDiva.com';
		$pageDescription =  'Shop for ' .$query. ' and get it delivered for free anywhere in India. Cash on Delivery available for all online purchases. Other than '.$query.', you can also choose from a wide range of perfumes, deodorants, cosmetics and skin or hair care products.';
		self::$smarty->assign('meta_title', $pageTitle);
		self::$smarty->assign('meta_description', $pageDescription);
		
		/*$canonicalurl = 'products/' . urlencode($query);
		if(Tools::getValue('p'))
			$canonicalurl = $canonicalurl . '?p=' . Tools::getValue('p');
		self::$smarty->assign('canonical_url', $canonicalurl);
		*/
		
		$paginationBaseUrl = _PS_BASE_URL_.__PS_BASE_URI__.'products/' . urlencode($query);
		self::$smarty->assign('paginationBaseUrl', $paginationBaseUrl);
		
		if(Tools::getValue('orderby', false))
			self::$smarty->assign('nobots', 1);
			
		if (!$this->instantSearch AND !$this->ajaxSearch)
			parent::displayHeader();
		else
			self::$smarty->assign('static_token', Tools::getToken(false));
	}
	
	public function displayContent()
	{
		parent::displayContent();
		self::$smarty->display(_PS_THEME_DIR_.'search.tpl');
	}
	
	public function displayFooter()
	{
		if (!$this->instantSearch AND !$this->ajaxSearch)
			parent::displayFooter();
	}
	
	public function setMedia()
	{
		parent::setMedia();
		
		//if (!$this->instantSearch AND !$this->ajaxSearch)
			//Tools::addCSS(_THEME_CSS_DIR_.'product_list.css');
	}
}

