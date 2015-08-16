<?php

class CuratedControllerCore extends FrontController
{
	public function __construct()
	{
		$this->auth = false;
		$this->php_self = 'curated.php';
		$this->authRedirection = 'curated.php';
		$this->ssl = true;
	
		parent::__construct();
	}
	
	public function preProcess()
	{
		parent::preProcess();
		
		try {
			$total_found = 0;
			$curated_products = SolrSearch::getCategoryProducts(CAT_CURATED, $brand_id = false, $total_found, $p = 1, $n = 500);
			
			$right_products = array_slice($curated_products, $total_found * 0.48);
			$left_products = array_slice($curated_products, 0, $total_found * 0.48);
			
			self::$smarty->assign('curated_products_right', $right_products);
			self::$smarty->assign('curated_products_left', $left_products);
		}catch (Exception $e) {
		}

	}
	
	public function displayContent()
	{
		parent::displayContent();
		self::$smarty->display(_PS_THEME_DIR_.'curated.tpl');
	}
	
	public function displayHeader()
	{
		self::$smarty->assign('nobots', 1);
		parent::displayHeader();
	}
}


