<?php

class WishListControllerCore extends FrontController
{
	public function __construct()
	{
		$this->auth = true;
		$this->php_self = 'wishlist.php';
		$this->authRedirection = 'wishlist.php';
		$this->ssl = true;
	
		parent::__construct();
	}
	
	public function preProcess()
	{
		parent::preProcess();
		
		$customer = new Customer((int)(self::$cookie->id_customer));

		if($idAdd = Tools::getValue('add'))
		{
		    $res = Db::getInstance()->ExecuteS("insert into ps_wishlist(id_customer, id_product) values(" . self::$cookie->id_customer . ", " . $idAdd . ")");
                    Tools::captureActivity(PSTAT_ADD_WL, $idAdd);
		    Tools::redirect('wishlist.php');
		}
		
		if($idDelete = Tools::getValue('delete'))
		{
		    $res = Db::getInstance()->ExecuteS("delete from ps_wishlist where id_customer = " . self::$cookie->id_customer . " and id_product = " . $idDelete);
                    Tools::captureActivity(PSTAT_DEL_WL, $idDelete);
		    Tools::redirect('wishlist.php');
		}
		
		$sql = "select id_product from ps_wishlist where id_customer = " . self::$cookie->id_customer;
		$res = Db::getInstance()->ExecuteS($sql);
		
		if($res)
		{
		    $productIds = array();
		    foreach ($res as $row)
		        $productIds[] = $row['id_product'];
		    
		    $total_found = 0;
		    try {
		        $wishlist_products = SolrSearch::getProductsForIDs($productIds, $total_found, 1, 100);
		        self::$smarty->assign('wishlist_products', $wishlist_products);
		    }catch (Exception $e) {
	        }
		}

	}
	
	public function displayContent()
	{
		parent::displayContent();
		self::$smarty->display(_PS_THEME_DIR_.'wishlist.tpl');
	}
	
	public function displayHeader()
	{
		self::$smarty->assign('nobots', 1);
		parent::displayHeader();
	}
}


