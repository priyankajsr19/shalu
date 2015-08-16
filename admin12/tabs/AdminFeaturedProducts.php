<?php
class AdminFeaturedProducts extends AdminTab
{
	public function postProcess()
	{
		global $currentIndex, $cookie, $smarty;
		$product_ids = Tools::getValue('product_ids');
		$group_id = 0;
		
		if($product_ids)
		{
		    $group_id = Tools::getValue('group_id');
		    $ids = explode(",", $product_ids);
		    
		    //update previous curated products
		    $sql = "SELECT group_concat(id_product) FROM vb_product_groups WHERE id_group_type = 1 AND id_group = 1";
		    $res = Db::getInstance()->ExecuteS($sql);
		     
		    $productIds = array();
		    foreach ($res as $row)
		    	$productIds[] = $row['id_product'];
		    
		    SolrSearch::updateProducts($productIds);
		    
		    Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute("
		            delete from vb_product_groups where id_group_type = 1 and id_group = " . $group_id);
		    Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute("
		    		delete from ps_category_product where id_category = ".CAT_CURATED);
		    foreach ($ids as $product_id)
		    {
		        if(!$product_id) continue;
		        Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute("
		                insert into vb_product_groups (id_group_type, id_group, id_product)
		                values (1, " . $group_id . ", ". $product_id .")
		                ");
		        Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute("
		        		insert into ps_category_product (id_category, id_product, position)
		        		values (".CAT_CURATED.", " . $product_id . ", 1)
		        		");
		        SolrSearch::updateProduct($product_id);
		    }
		}
		
		//home products
		$product_ids = $this->assign_products('curated_products', 'curated_product_ids', 1);
		
		$smarty->assign('productToken', Tools::getAdminToken('AdminCatalog'.(int)(Tab::getIdFromClassName('AdminCatalog')).(int)($cookie->id_employee)));
	}
	/**
     * 
     */
    private function assign_products ($products_group_name, $products_ids_name, $id_group)
    {
        global $smarty;
        $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("
		        select pl.id_product, pl.name, round(p.price) as 'price' from vb_product_groups pg 
		        inner join ps_product_lang pl on pg.id_product = pl.id_product
		        inner join ps_product p on p.id_product = pl.id_product
		        where pg.id_group_type = 1 and pg.id_group = " . $id_group);
		
	    $ids = array();
	    foreach($res as $product)
	        $ids[] = $product['id_product'];
	    $product_ids = implode(",", $ids);
	    
		$smarty->assign($products_group_name, $res);
		$smarty->assign($products_ids_name, $product_ids);
    }

	
	public function display()
	{
		global $smarty;
		$smarty->display(_PS_THEME_DIR_.'admin/featured.tpl');
	}
}






