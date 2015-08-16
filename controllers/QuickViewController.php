<?php


class QuickViewControllerCore extends FrontController
{
	public function run()
	{
		$this->init();
		$this->preProcess();
		global $cookie, $link;
		
		$id_product = Tools::getValue('id');
		
		$product = new Product($id_product, true, 1);
		
		$id_customer = (isset(self::$cookie->id_customer) AND self::$cookie->id_customer) ? (int)(self::$cookie->id_customer) : 0;
		if($id_customer)
		{
			$sql = "select id from ps_wishlist where id_customer = " . $id_customer . " and id_product = " . $product->id;
			$res = Db::getInstance()->ExecuteS($sql);
			if($res)
				self::$smarty->assign("in_wishlist", true);
			else
				self::$smarty->assign("in_wishlist", false);
		}
		else
			self::$smarty->assign("in_wishlist", false);
		
		$idImage = $product->getCoverWs();
		if($idImage)
			$idImage = $productObj->id.'-'.$idImage;
		else
			$idImage = Language::getIsoById(1).'-default';
		
		$image_link = $link->getImageLink($productObj->link_rewrite,$idImage, 'thickbox');
		
		self::$smarty->assign('product', $product);
		self::$smarty->assign('imagelink', $image_link);
		self::$smarty->assign('productlink', $product->getLink());
		
		die(self::$smarty->display(_PS_THEME_DIR_.'quick-view.tpl'));
	}
}

