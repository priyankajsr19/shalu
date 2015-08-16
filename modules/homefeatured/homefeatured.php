<?php
if (!defined('_CAN_LOAD_FILES_'))
	exit;

class HomeFeatured extends Module
{
	private $_html = '';
	private $_postErrors = array();

	function __construct()
	{
		$this->name = 'homefeatured';
		$this->tab = 'front_office_features';
		$this->version = '0.9';
		$this->author = 'PrestaShop';
		$this->need_instance = 0;

		parent::__construct();
		
		$this->displayName = $this->l('Featured Products on the homepage');
		$this->description = $this->l('Displays Featured Products in the middle of your homepage.');
	}

	function install()
	{
		if (!Configuration::updateValue('HOME_FEATURED_NBR', 8) OR !parent::install() OR !$this->registerHook('home'))
			return false;
		return true;
	}

	public function getContent()
	{
		$output = '<h2>'.$this->displayName.'</h2>';
		if (Tools::isSubmit('submitHomeFeatured'))
		{
			$nbr = (int)(Tools::getValue('nbr'));
			if (!$nbr OR $nbr <= 0 OR !Validate::isInt($nbr))
				$errors[] = $this->l('Invalid number of products');
			else
				Configuration::updateValue('HOME_FEATURED_NBR', (int)($nbr));
			if (isset($errors) AND sizeof($errors))
				$output .= $this->displayError(implode('<br />', $errors));
			else
				$output .= $this->displayConfirmation($this->l('Settings updated'));
		}
		return $output.$this->displayForm();
	}

	public function displayForm()
	{
		$output = '
		<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
			<fieldset><legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Settings').'</legend>
				<p>'.$this->l('In order to add products to your homepage, just add them to the "home" category.').'</p><br />
				<label>'.$this->l('Number of products displayed').'</label>
				<div class="margin-form">
					<input type="text" size="5" name="nbr" value="'.Tools::getValue('nbr', (int)(Configuration::get('HOME_FEATURED_NBR'))).'" />
					<p class="clear">'.$this->l('The number of products displayed on homepage (default: 10).').'</p>
					
				</div>
				<center><input type="submit" name="submitHomeFeatured" value="'.$this->l('Save').'" class="button" /></center>
			</fieldset>
		</form>';
		return $output;
	}

	function hookHome($params)
	{
	    //see if the html fragment is in memcache
		$memcache = new Memcache();
		if($memcache->connect('127.0.0.1', 11211))
		{
			$html_fragment = $memcache->get('fragment-home-featured-products');
			if($html_fragment) return $html_fragment;
			else 
			{
				$html_fragment = $this->getRenderedFragment($params);
				$memcache->set('fragment-home-featured-products', $html_fragment, false, 1800); //cache for 30 mins
				return $html_fragment;
			}
		}
		else 
		{
			return $this->getRenderedFragment($params);
		}
	}
	
	function getRenderedFragment($params)
	{
		global $smarty, $cookie;

		$smarty->assign('bags_products', $this->getProductsForGroup(2));
		$smarty->assign('jewelry_products', $this->getProductsForGroup(3));
		$smarty->assign('fragrances_products', $this->getProductsForGroup(4));
		$smarty->assign('makeup_products', $this->getProductsForGroup(5));
		$smarty->assign('new_products', $this->getProductsForGroup(6));
		
		return $this->display(__FILE__, 'homefeatured.tpl');
	}
	
	private function getProductsForGroup($id_group, $n_total = 5)
	{
		global $link;
		$sql = '
		SELECT p.id_product, p.out_of_stock, p.available_for_order, p.quantity, p.minimal_quantity, p.id_category_default, p.customizable, p.show_price, p.`weight`,
		p.ean13, pl.available_later, pl.description_short, pl.link_rewrite, pl.name, i.id_image, il.legend,  m.name manufacturer_name, p.condition, p.id_manufacturer,
		DATEDIFF(p.`date_add`, DATE_SUB(NOW(), INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY)) > 0 AS new
		FROM '._DB_PREFIX_.'product p
		LEFT JOIN '._DB_PREFIX_.'product_lang pl ON (pl.id_product = p.id_product)
		LEFT JOIN '._DB_PREFIX_.'image i ON (i.id_product = p.id_product AND i.cover = 1)
		LEFT JOIN '._DB_PREFIX_.'image_lang il ON (i.id_image = il.id_image AND il.id_lang = '.(int)($cookie->id_lang).')
		LEFT JOIN '._DB_PREFIX_.'manufacturer m ON (m.id_manufacturer = p.id_manufacturer)
		WHERE p.`active` = 1 AND
		p.id_product in (select id_product from vb_product_groups where id_group_type = 1 and id_group=' . $id_group .')
		limit ' . $n_total;
		 
		$products = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);
		$products = Product::getProductsProperties((int)$cookie->id_lang, $products);
		$display_products = array();
		foreach ($products as $product)
		{
			$display_product['name'] = $product['name'];
			$display_product['offer_price'] = round($product['price']);
			$display_product['mrp'] = round($product['price_without_reduction']);
			$display_product['discount'] = round((($product['price_without_reduction'] - $product['price'])/$product['price_without_reduction'])*100);
			$display_product['image_link'] = $link->getImageLink($product['link_rewrite'], $product['id_image'], 'home');
			$display_product['product_link'] = $product['link'];
			$display_product['quantity'] = $product['quantity'];
			$display_product['id_product'] = $product['id_product'];
			$display_products[] = $display_product;
		}
		 
		return $display_products;
	}
}
