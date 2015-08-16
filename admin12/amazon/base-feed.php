<?php

class BaseFeed {
    protected $config; 
    protected $db;
    protected $date_res;

    protected $id_feed;
    protected $id_prod_feed;
    protected $id_price_feed;
    protected $id_inv_feed;
    protected $id_image_feed;

    protected $productFeed;
    protected $priceFeed;
    protected $inventoryFeed;
    protected $imageFeed;

    protected $id_affiliate;

    public function __construct($purgeOld = false) {
        $this->config = MarketplaceWebService_Config::getConfig();
        $this->db = Db::getInstance(_PS_USE_SQL_SLAVE_);
	$this->id_affiliate = 1; //Amazon US
        $this->resetFeed();

        if( $purgeOld ) {
            $files = glob('xmlfeeds/*'); // get all file names
            foreach($files as $file){ // iterate files
                if(is_file($file))
                    unlink($file); // delete file
            }
            $this->db->ExecuteS("truncate table ps_affiliate_feed");
            $this->db->ExecuteS("truncate table ps_affiliate_subfeed");
            $this->db->ExecuteS("truncate table ps_affiliate_feed_product");
            $this->db->ExecuteS("truncate table ps_affiliate_subfeed_product");
            $this->db->ExecuteS("truncate table ps_affiliate_feed_product_info");
        }
    }
    protected function resetFeed() {
        $this->id_feed = null;
        $this->id_prod_feed = null;
        $this->id_price_feed = null;
        $this->id_inv_feed = null;
        $this->id_image_feed = null;
        $this->id_rel_feed = null;

        $this->productFeed = null;
        $this->priceFeed = null;
        $this->inventoryFeed = null;
        $this->imageFeed = null;
        $this->relFeed = null;
    }
    
    protected function initMainFeed() {
        if( empty($this->id_feed) )
            $this->id_feed = MarketplaceWebService_DB::newFeed();
    }
    
    protected function initSubFeed($type) {
        if( empty($this->id_feed) )
            $this->initMainFeed();

        if( $type === MarketplaceWebService_DB::$PRODUCT_FEED ) {
            if( empty($this->id_prod_feed))
                $this->id_prod_feed = MarketplaceWebService_DB::newSubFeed($this->id_feed, MarketplaceWebService_DB::$PRODUCT_FEED);
            return $this->id_prod_feed; 
        } elseif( $type === MarketplaceWebService_DB::$PRICE_FEED ) {
            if( empty($this->id_price_feed) )
                $this->id_price_feed = MarketplaceWebService_DB::newSubFeed($this->id_feed, MarketplaceWebService_DB::$PRICE_FEED);
            return $this->id_price_feed;
        } elseif( $type === MarketplaceWebService_DB::$INVENTORY_FEED ) {
            if( empty($this->id_inv_feed) )
                $this->id_inv_feed = MarketplaceWebService_DB::newSubFeed($this->id_feed, MarketplaceWebService_DB::$INVENTORY_FEED);
            return $this->id_inv_feed;
        } elseif( $type === MarketplaceWebService_DB::$IMAGE_FEED ) {
            if( empty($this->id_image_feed) )
                $this->id_image_feed = MarketplaceWebService_DB::newSubFeed($this->id_feed, MarketplaceWebService_DB::$IMAGE_FEED);
            return $this->id_image_feed;
        } elseif( $type === MarketplaceWebService_DB::$RELATIONSHIP_FEED ) {
            if( empty($this->id_rel_feed) )
                $this->id_rel_feed = MarketplaceWebService_DB::newSubFeed($this->id_feed, MarketplaceWebService_DB::$RELATIONSHIP_FEED);
            return $this->id_rel_feed;
        }
    }

    protected function initFeedObject($type) {
        if( $type === 'Inventory') {
            if(empty($this->inventoryFeed))
                $this->inventoryFeed = new MarketplaceWebService_XML_Feed_Inventory($this->config, 'Inventory');
        } 
        if( $type === 'Price') {
            if(empty($this->priceFeed))
                $this->priceFeed = new MarketplaceWebService_XML_Feed_Price($this->config, 'Price');
        } 
        if( $type === 'ProductImage') {
            if(empty($this->imageFeed))
                $this->imageFeed = new MarketplaceWebService_XML_Feed_Image($this->config, 'ProductImage');
        }
        if( $type === 'Relationship') {
            if(empty($this->relFeed))
                $this->relFeed = new MarketplaceWebService_XML_Feed_Relationship($this->config,'Relationship');
        }
    }

    protected function echomsg($message, $alert = false) {
        $tnow = date('Y-m-d H:i:s');
        echo "$tnow - $message\n";
    }

    protected function getProductsSQL() {
        $sql = "select max(date_add) last_date_add from ps_affiliate_feed";
        $this->date_res = $this->db->getRow($sql); 

 
        $cat_sql = array();
        // sarees
        $sql = "select cp.id_product from ps_category_product cp inner join ps_product p on p.id_product = cp.id_product  where cp.id_category = ".CAT_SAREE;
        if ( isset($this->date_res) && !empty($this->date_res['last_date_add'])  ) 
            $sql .= " and (p.date_upd >= '".$this->date_res['last_date_add']."' OR p.date_add >= '".$this->date_res['last_date_add']."')";
        $cat_sql[] = $sql;

        // cholis
        $sql = "select cp.id_product from ps_category_product cp inner join ps_product p on p.id_product = cp.id_product  where cp.id_category = ".CAT_CHOLIS;
        if ( isset($this->date_res) && !empty($this->date_res['last_date_add'])  ) 
            $sql .= " and (p.date_upd >= '".$this->date_res['last_date_add']."' OR p.date_add >= '".$this->date_res['last_date_add']."')";
        $cat_sql[] = $sql;

        // skd
        $sql = "select cp.id_product from ps_category_product cp inner join ps_product p on p.id_product = cp.id_product  where cp.id_category = ".CAT_SKD." and p.is_customizable = 0 ";
        if ( isset($this->date_res) && !empty($this->date_res['last_date_add'])  ) 
            $sql .= " and (p.date_upd >= '".$this->date_res['last_date_add']."' OR p.date_add >= '".$this->date_res['last_date_add']."')";
        $cat_sql[] = $sql;

        //kurtis
        $sql = "select cp.id_product from ps_category_product cp inner join ps_product p on p.id_product = cp.id_product  where cp.id_category = ".CAT_KURTI." and p.is_customizable = 0";
        if ( isset($this->date_res) && !empty($this->date_res['last_date_add'])  ) 
            $sql .= " and (p.date_upd >= '".$this->date_res['last_date_add']."' OR p.date_add >= '".$this->date_res['last_date_add']."')";
        $cat_sql[] = $sql;

        // bottoms and dupattas
        $sql = "select cp.id_product from ps_category_product cp inner join ps_product p on p.id_product = cp.id_product  where cp.id_category = ".CAT_BOTTOMS;
        if ( isset($this->date_res) && !empty($this->date_res['last_date_add'])  ) 
            $sql .= " and (p.date_upd >= '".$this->date_res['last_date_add']."' OR p.date_add >= '".$this->date_res['last_date_add']."')";
        $cat_sql[] = $sql;

        //lehengas
        $sql = "select cp.id_product from ps_category_product cp inner join ps_product p on p.id_product = cp.id_product  where cp.id_category = ".CAT_LEHENGA." and p.is_customizable = 0";
        if ( isset($this->date_res) && !empty($this->date_res['last_date_add'])  ) 
            $sql .= " and (p.date_upd >= '".$this->date_res['last_date_add']."' OR p.date_add >= '".$this->date_res['last_date_add']."')";
        $cat_sql[] = $sql;


        //data on amazon vs data on indusdiva - brute force comparision ( some products are going missing in the feed if we depend only on product date_upd )
        //products with combinations(multiple skus)
        $sql = "select distinct a.id_product from (select id_product, id_sku, price, specific_price, quantity, concat('Ready to be shipped in ',shipping_sla,' days') shipping_sla, active, exclusive from ps_affiliate_feed_product_info where concat('ID-',id_product) != id_sku) a join (select pa.id_product, concat('ID-',pa.id_product,'-', al.`name`) AS id_sku, round((p.price + pa.`price`)) price, round(if( sp.price is NULL, p.price + pa.price, ((p.price+pa.price) - ((pa.price+p.price) * reduction)))) specific_price, pa.quantity, vl.value as shipping_sla, p.active, p.is_exclusive as exclusive        FROM  `ps_product_attribute` pa         LEFT JOIN `ps_product_attribute_combination` pac ON pac.`id_product_attribute` = pa.`id_product_attribute`         LEFT JOIN `ps_attribute` a ON a.`id_attribute` = pac.`id_attribute`         LEFT JOIN `ps_attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`         LEFT JOIN `ps_attribute_lang` al ON a.`id_attribute` = al.`id_attribute`         LEFT JOIN `ps_attribute_group_lang` agl ON ag.`id_attribute_group` = agl.`id_attribute_group`  LEFT JOIN ps_product p on p.id_product = pa.id_product LEFT JOIN ps_feature_product fp  on fp.id_product = p.id_product and fp.id_feature = 8 LEFT join ps_feature_value_lang vl on vl.id_feature_value = fp.id_feature_value and vl.id_lang =1    LEFT JOIN ps_specific_price sp on sp.id_product = p.id_product WHERE pa.`id_product` = (select id_product from ps_affiliate_feed_product_info where concat('ID-',id_product) = id_sku and id_product = p.id_product)  AND al.`id_lang` = 1         AND agl.`id_lang` = 1) i on a.id_sku = i.id_sku where a.price != i.price or a.specific_price != i.specific_price or cast(substr(trim(a.shipping_sla),24) as unsigned) != cast(substr(trim(i.shipping_sla),24) as unsigned) or a.quantity != i.quantity or a.active != i.active or a.exclusive != i.exclusive";
        $cat_sql[] = $sql;
        // products without combinations(single size)
        $sql = "select distinct a.id_product  from (select a.id_product, id_sku, price, specific_price, quantity, concat('Ready to be shipped in ',shipping_sla,' days') shipping_sla, active, exclusive from ps_affiliate_feed_product_info a join (select id_product from ps_affiliate_feed_product_info group by id_product having count(*) = 1) i on a.id_product = i.id_product) a join (select p.id_product, concat('ID-',p.id_product) AS id_sku, round(p.price) price, round(if( sp.price is NULL, p.price , (p.price - p.price * reduction))) specific_price, p.quantity, vl.value as shipping_sla, p.active, p.is_exclusive as exclusive        FROM  ps_product p  JOIN ps_feature_product fp  on fp.id_product = p.id_product and fp.id_feature = 8 join ps_feature_value_lang vl on vl.id_feature_value = fp.id_feature_value and vl.id_lang =1 JOIN (select id_product, count(*) skus from ps_affiliate_feed_product_info group by id_product having skus = 1) azp on azp.id_product = p.id_product    LEFT JOIN ps_specific_price sp on sp.id_product = p.id_product) i on a.id_sku = i.id_sku where (a.price != i.price or a.specific_price != i.specific_price or cast(substr(trim(a.shipping_sla),24) as unsigned) != cast(substr(trim(i.shipping_sla),24) as unsigned) or a.quantity != i.quantity or a.active != i.active or a.exclusive != i.exclusive)";
        $cat_sql[] = $sql;

	//$sql = "select id_product from temp";
        //$cat_sql[] = $sql;
        
	$sql = implode(" UNION ", $cat_sql);
        return $sql;
    }

    protected function getSKUs($products) {
        $skus = array();
        foreach($products as $product) {
            $id_product = $product['id_product'];
            $this->echomsg("Preparing SKUs for $id_product"); 
            $divaProduct = new Product($id_product,true,1);
           
            $found_skus = array(); 
            $attributesGroups = $divaProduct->getAttributesGroups(1);
            if( empty($attributesGroups) ) {
                
                $this_sku = array(
                    "id_product" => $id_product,
                    "id_sku" => "ID-$id_product",
                    "is_parent" => false, 
                    "attribute" => null
                );
                array_push($found_skus, $this_sku['id_sku']);
                array_push( $skus, $this_sku );
            } else {
                
                $this_sku = array(
                    "id_product" => $id_product, 
                    "id_sku" => "ID-$id_product",
                    "is_parent" => true, 
                    "attribute" => null
                );
                array_push($found_skus, $this_sku['id_sku']);
                array_push( $skus, $this_sku );

                foreach($attributesGroups as $attribute) {
                    $size = $attribute['attribute_name'];
                    $id_sku = "ID-$id_product-$size";
                    $this_sku = array(
                        "id_product" => $id_product,
                        "id_sku" => $id_sku,
                        "is_parent" => false, 
                        "attribute" => $attribute
                    );
                    array_push($found_skus, $this_sku['id_sku']);
                    array_push( $skus, $this_sku );
                }
            }
            //check if there are other SKUs for this product already on amazon but deleted in our system
            $csql = "select id_sku from ps_affiliate_feed_product_info where id_product = $id_product and concat('ID-',id_product) != id_sku";
            $cres = $this->db->ExecuteS($csql);
            if( !empty($cres) && count($cres) > 0 ) {
                foreach($cres as $c) {
                    if( in_array($c['id_sku'], $found_skus) )
                        continue;
                    $this_sku = array(
                        "id_product" => $id_product,
                        "id_sku" => $c['id_sku'],
                        "is_parent" => false, 
                        "attribute" => null,
                        "inactive" => true
                    );
                    array_push( $skus, $this_sku );
                }
            } 
            unset($divaProduct);
        }
        return $skus;
    }
    
    public function prepareFeed() {
        
        $this->echomsg("Start - New Feed Preparation"); 
        
        // select all EXLUSIVE products added since the last feed
        $sql = $this->getProductsSQL();
        //echo $sql; exit;
        $products = $this->db->ExecuteS($sql);
        
        if( count($products) === 0 ) {
            $this->echomsg("No New Products pending to be added");
            $this->echomsg("End - Feed Preparation"); 
            return;
        }

        //Prepare SKUs
        $skus = $this->getSKUs($products);
        $prepareFeed = false;
        $atleastOneFailed = false;
        
        $atleastOneProdFailed = false;
        $atleastOnePriceFailed = false;
        $atleastOneInvFailed = false;
        $atleastOneImageFailed = false;
        $atleastOneProdSuccess = false;
        $atleastOnePriceSuccess = false;
        $atleastOneInvSuccess = false;
        $atleastOneImageSuccess = false;
        
        $newProductsAdded = array();
        foreach($skus as &$sku) {

            $id_product = $sku["id_product"];
            $id_sku = $sku['id_sku'];
            $is_parent = $sku["is_parent"];
            $has_children = empty($sku["attribute"])?false:true;
            $size = empty($sku["attribute"])?"One Size":$sku["attribute"]["attribute_name"];
            $force_inactive = (isset($sku['inactive']) && (int)$sku['inactive'] === 1)?true:false;

            $priceData = null;
            $inventoryData = null;
            $imageDataArray = null;
            $amazonProduct = null;
            $deleted = false;     
            $delete_list = array();
            $build_relationship_feed = false;
            
            $allSubFeedsSuccess = true;

            $divaProduct = new Product($id_product,true,1);
             
            $this->echomsg("SKU #$id_sku - Start"); 
            
            //check to see if the product is on amazon already
            $sql = "select * from ps_affiliate_feed_product_info where id_sku = '$id_sku'";
            $res = $this->db->getRow($sql);
            
            if( $is_parent === false && $has_children === false ) {
                $new_price = (int)round($divaProduct->getPriceWithoutReduct());
                $new_specific_price = (int)round($divaProduct->getAffiliatePrice($this->id_affiliate));
                $new_quantity = (int)Product::getQuantity($id_product);
            } else {
                if( $is_parent ) {
                    $new_price = (int)round($divaProduct->getPriceWithoutReduct());
                    $new_specific_price = (int)round($divaProduct->getAffiliatePrice($this->id_affiliate));
                    $new_quantity = (int)Product::getQuantity($id_product);
                } else {
                    $new_price = (int)round($divaProduct->getPriceWithoutReduct(false, $sku['attribute']['id_product_attribute']));
                    $new_specific_price = (int)round($divaProduct->getAffiliatePrice($this->id_affiliate,true, $sku['attribute']['id_product_attribute']));
                    $new_quantity = (int)Product::getQuantity($id_product, $sku['attribute']['id_product_attribute']);
                    $build_relationship_feed = true;
                }
            }
	
            if(!empty($res)) { 
                

                $new_shipping_sla = (int)$divaProduct->shipping_sla;
                $new_active = (int)$divaProduct->active;
                if($force_inactive)
                    $new_active = 0;
                $new_exclusive = (int)$divaProduct->is_exclusive;

                $old_price = (int)$res['price'];
                $old_specific_price = (int)$res['specific_price'];
                $old_quantity = (int)$res['quantity'];
                $old_shipping_sla = (int)$res['shipping_sla'];
                $old_active = (int)$res['active'];
                $old_exclusive = (int)$res['exclusive'];
               
                if( $new_exclusive === 0 ) {
                    
                    $this->echomsg("SKU #$id_sku - ... Preparing Delete product"); 
                    
                    $this->initMainFeed();
                    $id_fp = MarketplaceWebService_DB::newFeedProduct($this->id_feed, $id_product, $id_sku);
                    
                    $this->initSubFeed(MarketplaceWebService_DB::$PRODUCT_FEED);
                    $op_type = 'D';
                    $id_sfp = MarketplaceWebService_DB::newSubFeedProduct($this->id_prod_feed, $id_product, $id_sku, $op_type);

                    try {
                        $amazonProduct = $this->getDeleteObj($divaProduct, $sku);
                        MarketplaceWebService_DB::updateSubFeedProduct($id_sfp, MarketplaceWebService_DB::$STATUS_PREP_SUCCESS); 
                        $atleastOneProdSuccess = true;
                        $deleted = true;
                        $this->echomsg("SKU #$id_sku - ... Success"); 
                        $sql = "delete from ps_affiliate_feed_product_info where id_sku = '$id_sku'";
                        array_push($delete_list, "$id_sku");
                        $this->db->ExecuteS($sql);

                    } catch(Exception $ex) {
                        MarketplaceWebService_DB::updateSubFeedProduct($id_sfp, MarketplaceWebService_DB::$STATUS_PREP_FAILED, $ex->getMessage()); 
                        $atleastOneProdFailed = true;
                        $allSubFeedsSuccess = false;
                        $this->echomsg("SKU #$id_sku - ... Failed"); 
                    }

                } else {
                    $change = false;
                    if( $new_active === 0 || $new_quantity < 1) {
                        //make product quantity 0 (inactive on amazon)
                        $this->echomsg("SKU #$id_sku - ... Preparing Inventory Feed(Quantity 0)"); 
                   
                        $this->initMainFeed();
                        $id_fp = MarketplaceWebService_DB::newFeedProduct($this->id_feed, $id_product, $id_sku);
                    
                        $this->initSubFeed(MarketplaceWebService_DB::$INVENTORY_FEED);
                        $id_sfp = MarketplaceWebService_DB::newSubFeedProduct($this->id_inv_feed, $id_product, $id_sku);
                    
                        try {
                            $inventoryData = $this->getInventoryObj($divaProduct, $sku, $new_quantity, $new_shipping_sla,  true);
                            $date_upd = date('Y-m-d H:i:s');
                            $sql = "update ps_affiliate_feed_product_info set quantity = $new_quantity,active = $new_active,date_upd = '$date_upd' where id_sku = '$id_sku'";
                            $this->db->ExecuteS($sql);
                            MarketplaceWebService_DB::updateSubFeedProduct($id_sfp, MarketplaceWebService_DB::$STATUS_PREP_SUCCESS); 
                            $atleastOneInvSuccess = true;
                            $this->echomsg("SKU #$id_sku - ... Success"); 
                        
                        } catch (Exception $ex ) {
                            MarketplaceWebService_DB::updateSubFeedProduct($id_sfp, MarketplaceWebService_DB::$STATUS_PREP_FAILED, $ex->getMessage()); 
                            $allSubFeedsSuccess = false;
                            $atleastOneInvFailed = true;
                            $this->echomsg("SKU #$id_sku - ... Failed"); 
                        }
                        $change = true;

                    } 
                    $make_active = false;
                    if( $old_active === 0 && $new_active === 1 )
			$make_active = true;
                    if( $make_active || $old_price !== $new_price || $old_specific_price !== $new_specific_price || $old_quantity !== $new_quantity || $old_shipping_sla !== $new_shipping_sla ) {
                        // Price and Inventory data on Amazon should be updated
                        $this->initMainFeed();
                        $id_fp = MarketplaceWebService_DB::newFeedProduct($this->id_feed, $id_product, $id_sku);
                    
                        if( $old_price !== $new_price || $old_specific_price !== $new_specific_price ) {
                            $this->echomsg("SKU #$id_sku - ... Preparing Price Feed"); 
                            $this->initSubFeed(MarketplaceWebService_DB::$PRICE_FEED);
                            $id_sfp = MarketplaceWebService_DB::newSubFeedProduct($this->id_price_feed, $id_product, $id_sku);

                            try {
                                $priceData = $this->getPriceObj($divaProduct, $sku, $new_price, $new_specific_price);
                                $date_upd = date('Y-m-d H:i:s');
                                $sql = "update ps_affiliate_feed_product_info set price = $new_price, specific_price = $new_specific_price,date_upd='$date_upd' where id_sku = '$id_sku'";
                                $this->db->ExecuteS($sql);
                                MarketplaceWebService_DB::updateSubFeedProduct($id_sfp, MarketplaceWebService_DB::$STATUS_PREP_SUCCESS); 
                                $atleastOnePriceSuccess = true;
                                $this->echomsg("SKU #$id_sku - ... Success"); 
                            } catch( Exception $ex ) {
                                $allSubFeedsSuccess = false;
                                $atleastOnePriceFailed = true;
                                MarketplaceWebService_DB::updateSubFeedProduct($id_sfp, MarketplaceWebService_DB::$STATUS_PREP_FAILED, $ex->getMessage()); 
                                $this->echomsg("SKU #$id_sku - ... Failed"); 
                            }
                        }
                    
                        if( $make_active || $old_quantity !== $new_quantity || $old_shipping_sla !== $new_shipping_sla ) { 
                            $this->echomsg("SKU #$id_sku - ... Preparing Inventory Feed"); 
                            $this->initSubFeed(MarketplaceWebService_DB::$INVENTORY_FEED);
                            $id_sfp = MarketplaceWebService_DB::newSubFeedProduct($this->id_inv_feed, $id_product, $id_sku);
                    
                            try {
                                $inventoryData = $this->getInventoryObj($divaProduct, $sku, $new_quantity, $new_shipping_sla);
                                $date_upd = date('Y-m-d H:i:s');
                                if( $make_active )
                                    $csql = ",active = 1";
                                else
                                    $csql = "";
                                $sql = "update ps_affiliate_feed_product_info set quantity = $new_quantity, shipping_sla = $new_shipping_sla $csql, date_upd='$date_upd' where id_sku = '$id_sku'";
                                $this->db->ExecuteS($sql);
                                MarketplaceWebService_DB::updateSubFeedProduct($id_sfp, MarketplaceWebService_DB::$STATUS_PREP_SUCCESS); 
                                $atleastOneInvSuccess = true;
                                $this->echomsg("SKU #$id_sku - ... Success"); 
                            } catch (Exception $ex ) {
                                MarketplaceWebService_DB::updateSubFeedProduct($id_sfp, MarketplaceWebService_DB::$STATUS_PREP_FAILED, $ex->getMessage()); 
                                $allSubFeedsSuccess = false;
                                $atleastOneInvFailed = true;
                                $this->echomsg("SKU #$id_sku - ... Failed"); 
                            }
                        }
                        $change = true;
                    }
                    if( !$change ) {
                        $this->echomsg("SKU #$id_sku - ... No change in price and inventory - skip");
                        $this->echomsg("SKU #$id_sku - End");
                        continue;
                    }
                }
            } else {
                //this product is not on amazon - push full feed
                if( (((int)$divaProduct->active) === 0) || (((int)$divaProduct->is_exclusive) === 0) || ($divaProduct->quantity < 1) ) {
                    $this->echomsg("SKU #$id_sku - ... Not Active or Not Exclusive or Quantity < 1"); 
                    $this->echomsg("SKU #$id_sku - End"); 
                    continue;
                }

                $this->initMainFeed();
                $id_fp = MarketplaceWebService_DB::newFeedProduct($this->id_feed, $id_product, $id_sku);
            
                try {
                    $this->echomsg("SKU #$id_sku - ... Preparing Product Feed"); 
                    $this->initSubFeed(MarketplaceWebService_DB::$PRODUCT_FEED);
                    $id_sfp = MarketplaceWebService_DB::newSubFeedProduct($this->id_prod_feed, $id_product, $id_sku);
                    $amazonProduct = $this->getProductObj($divaProduct, $sku);
                    MarketplaceWebService_DB::updateSubFeedProduct($id_sfp, MarketplaceWebService_DB::$STATUS_PREP_SUCCESS); 
                    $atleastOneProdSuccess = true;
                    $this->echomsg("SKU #$id_sku - ... Success"); 
                } catch(Exception $ex) {
                    MarketplaceWebService_DB::updateSubFeedProduct($id_sfp, MarketplaceWebService_DB::$STATUS_PREP_FAILED, $ex->getMessage()); 
                    $allSubFeedsSuccess = false;
                    $atleastOneProdFailed = true;
                    $this->echomsg("SKU #$id_sku - ... Failed"); 
                }

                try {
                    $this->echomsg("SKU #$id_sku - ... Preparing Image Feed"); 
                    $this->initSubFeed(MarketplaceWebService_DB::$IMAGE_FEED);
                    $id_sfp = MarketplaceWebService_DB::newSubFeedProduct($this->id_image_feed, $id_product, $id_sku);
                    $imageDataArray = $this->getImageObj($divaProduct, $sku);
                    if( count($imageDataArray) === 0) {
                        throw new Exception("No Image(s) available for this Product");
                    }
                    MarketplaceWebService_DB::updateSubFeedProduct($id_sfp, MarketplaceWebService_DB::$STATUS_PREP_SUCCESS); 
                    $atleastOneImageSuccess = true;
                    $this->echomsg("SKU #$id_sku - ... Success"); 
                } catch( Exception $ex ) {
                    MarketplaceWebService_DB::updateSubFeedProduct($id_sfp, MarketplaceWebService_DB::$STATUS_PREP_FAILED, $ex->getMessage()); 
                    $allSubFeedsSuccess = false;
                    $atleastOneImageFailed = true;
                    $this->echomsg("SKU #$id_sku - ... Failed"); 
                }
            
                $price = null;
                $specific_price = null;
                try {
                    $this->echomsg("SKU #$id_sku - ... Preparing Price Feed"); 
                    $this->initSubFeed(MarketplaceWebService_DB::$PRICE_FEED);
                    $id_sfp = MarketplaceWebService_DB::newSubFeedProduct($this->id_price_feed, $id_product, $id_sku);
                    $priceData = $this->getPriceObj($divaProduct, $sku, $price, $specific_price);
                    MarketplaceWebService_DB::updateSubFeedProduct($id_sfp, MarketplaceWebService_DB::$STATUS_PREP_SUCCESS); 
                    $atleastOnePriceSuccess = true;
                    $this->echomsg("SKU #$id_sku - ... Success"); 
                } catch( Exception $ex ) {
                    MarketplaceWebService_DB::updateSubFeedProduct($id_sfp, MarketplaceWebService_DB::$STATUS_PREP_FAILED, $ex->getMessage()); 
                    $allSubFeedsSuccess = false;
                    $atleastOnePriceFailed = true;
                    $this->echomsg("SKU #$id_sku - ... Failed"); 
                }
                    
                $quantity = null;
                $shipping_sla = null;
                try {
                    $this->echomsg("SKU #$id_sku - ... Preparing Inventory Feed"); 
                    $this->initSubFeed(MarketplaceWebService_DB::$INVENTORY_FEED);
                    $id_sfp = MarketplaceWebService_DB::newSubFeedProduct($this->id_inv_feed, $id_product, $id_sku);
                    $inventoryData = $this->getInventoryObj($divaProduct, $sku, $quantity, $shipping_sla);
                    MarketplaceWebService_DB::updateSubFeedProduct($id_sfp, MarketplaceWebService_DB::$STATUS_PREP_SUCCESS); 
                    $atleastOneInvSuccess = true;
                    $this->echomsg("SKU #$id_sku - ... Success"); 
                } catch( Exception $ex ) {
                    MarketplaceWebService_DB::updateSubFeedProduct($id_sfp, MarketplaceWebService_DB::$STATUS_PREP_FAILED, $ex->getMessage()); 
                    $allSubFeedsSuccess = false;
                    $atleastOneInvFailed = true;
                    $this->echomsg("SKU #$id_sku - ... Failed"); 
                }
                
                if( $allSubFeedsSuccess ) {
                    if( !in_array($id_product,$newProductsAdded) )
                        array_push($newProductsAdded, $id_product);
                    //Make a note that this product is on amazon
                    $date_add = date('Y-m-d H:i:s');
                    $date_upd = date('Y-m-d H:i:s');
                    $sql = "insert into ps_affiliate_feed_product_info(id_product, id_sku, price, specific_price, quantity, shipping_sla, active, exclusive, date_add, date_upd) 
                        values($id_product, '$id_sku',$price,$specific_price,$quantity, $shipping_sla,1,1,'$date_add','$date_upd')";
                    $this->db->ExecuteS($sql); 

                }

            }
            if( $allSubFeedsSuccess ) {
                if( $amazonProduct !== null) {
                    $this->initFeedObject('Product');
                    if( $deleted )
                        $this->productFeed->addProduct($amazonProduct,'Delete');
                    else
                        $this->productFeed->addProduct($amazonProduct);
                }
                if( $inventoryData !== null) {
                    $this->initFeedObject('Inventory');
                    $this->inventoryFeed->addInventory($inventoryData);
                }
                if( $priceData !== null) {
                    $this->initFeedObject('Price');
                    $this->priceFeed->addPrice($priceData);
                }
                if( $imageDataArray !== null) {
                    $this->initFeedObject('ProductImage');  
                    foreach($imageDataArray as $imageData)
                        $this->imageFeed->addImage($imageData);
                }
                MarketplaceWebService_DB::updateFeedProduct($id_fp,MarketplaceWebService_DB::$STATUS_PREP_SUCCESS);
                $prepareFeed = true;
                $this->echomsg("SKU #$id_sku - ... All Feeds Success"); 
            } else {
                //Atleast one feed failed for this product
                //Do not push this product into XML Feed
                $atleastOneFailed = true;
                MarketplaceWebService_DB::updateFeedProduct($id_fp,MarketplaceWebService_DB::$STATUS_PREP_FAILED);
                $this->echomsg("SKU #$id_sku - ... Atleast One Feed Failed"); 
            }
            $this->echomsg("SKU #$id_sku - End"); 
            unset( $divaProduct );
        } // End foreach products

        $id = time().date('Y-m-d');
        if( $prepareFeed ) {
            $data = array();
            //Prepare Feed Files
            if( $this->productFeed instanceOf MarketplaceWebService_XML_Feed_Product ) {
                $productFeedFile = "xmlfeeds/products-$id.xml";
                $this->productFeed->save($productFeedFile);
                $data['feed_file'] = $productFeedFile;
                if( $atleastOneProdFailed )
                    $data['status'] = MarketplaceWebService_DB::$STATUS_PREP_PARTIAL_SUCCESS;
                else
                    $data['status'] = MarketplaceWebService_DB::$STATUS_PREP_SUCCESS;
                MarketplaceWebService_DB::updateSubFeedStatus($this->id_prod_feed, $data);
            }
            if( $this->priceFeed instanceOf MarketplaceWebService_XML_Feed_Price ) {
                $priceFeedFile = "xmlfeeds/products-price-$id.xml";
                $this->priceFeed->save($priceFeedFile);
                $data['feed_file'] = $priceFeedFile;
                if( $atleastOnePriceFailed )
                    $data['status'] = MarketplaceWebService_DB::$STATUS_PREP_PARTIAL_SUCCESS;
                else
                    $data['status'] = MarketplaceWebService_DB::$STATUS_PREP_SUCCESS;
                MarketplaceWebService_DB::updateSubFeedStatus($this->id_price_feed, $data);
            }
            if( $this->inventoryFeed instanceOf MarketplaceWebService_XML_Feed_Inventory  ) {
                $inventoryFeedFile = "xmlfeeds/products-inventory-$id.xml";
                $this->inventoryFeed->save($inventoryFeedFile);
                $data['feed_file'] = $inventoryFeedFile;
                if( $atleastOneInvFailed ) {
                    $data['status'] = MarketplaceWebService_DB::$STATUS_PREP_PARTIAL_SUCCESS;
                } else {
                    $data['status'] = MarketplaceWebService_DB::$STATUS_PREP_SUCCESS;
                }
                MarketplaceWebService_DB::updateSubFeedStatus($this->id_inv_feed, $data);
            }
            if( $this->imageFeed instanceOf MarketplaceWebService_XML_Feed_Image ) {
                $imageFeedFile = "xmlfeeds/products-images-$id.xml";
                $this->imageFeed->save($imageFeedFile);
                $data['feed_file'] = $imageFeedFile;
                if( $atleastOneImageFailed ) {
                    $data['status'] = MarketplaceWebService_DB::$STATUS_PREP_PARTIAL_SUCCESS;
                } else {
                    $data['status'] = MarketplaceWebService_DB::$STATUS_PREP_SUCCESS;
                }
                MarketplaceWebService_DB::updateSubFeedStatus($this->id_image_feed, $data);
            }

            if( $atleastOneFailed )
                MarketplaceWebService_DB::updateFeedStatus($this->id_feed,MarketplaceWebService_DB::$STATUS_PREP_PARTIAL_SUCCESS);
            else
                MarketplaceWebService_DB::updateFeedStatus($this->id_feed,MarketplaceWebService_DB::$STATUS_PREP_SUCCESS);
        } else {
            MarketplaceWebService_DB::updateFeedStatus($this->id_feed,MarketplaceWebService_DB::$STATUS_PREP_FAILED);
            MarketplaceWebService_DB::updateSubFeedStatus($this->id_prod_feed, array('status'=>MarketplaceWebService_DB::$STATUS_PREP_FAILED));
            MarketplaceWebService_DB::updateSubFeedStatus($this->id_price_feed, array('status'=>MarketplaceWebService_DB::$STATUS_PREP_FAILED));
            MarketplaceWebService_DB::updateSubFeedStatus($this->id_inv_feed, array('status'=>MarketplaceWebService_DB::$STATUS_PREP_FAILED));
            MarketplaceWebService_DB::updateSubFeedStatus($this->id_image_feed, array('status'=>MarketplaceWebService_DB::$STATUS_PREP_FAILED));
        }

        //If applicable, build relationship for this SKU
        if( count($newProductsAdded) > 0 ) {
            foreach($newProductsAdded as $id_product) {
                $csql = "select id_product, id_sku from ps_affiliate_feed_product_info where id_product = $id_product";
                $cres = $this->db->ExecuteS($csql);
                if( count($cres) > 1) {
                    $id_parent_sku = null;
                    $child_skus = array();
                    foreach($cres as $res) {
                        $id_parent_sku = "ID-".$res['id_product'];
                        $id_sku = $res['id_sku'];
                        if( $id_parent_sku !== $id_sku )
                            array_push($child_skus, $id_sku);
                    }
                    $relationshipData = null;
                    $this->echomsg("SKU #$id_parent_sku - ... Preparing Relationship Feed");
                    if( $id_parent_sku !== null && count($child_skus) > 0 ) {
                        $relationshipData = $this->getRelationshipObj($id_parent_sku, $child_skus);
                    }
                    $this->echomsg("SKU #$id_parent_sku - ... Success");
                    if( $relationshipData !== null) {
                        $this->initFeedObject('Relationship');
                        $this->relFeed->addRelationship($relationshipData);
                    }
                }
            }
            if( $this->relFeed instanceOf MarketplaceWebService_XML_Feed_Relationship ) {
                $this->initSubFeed(MarketplaceWebService_DB::$RELATIONSHIP_FEED);
                $relFeedFile = "xmlfeeds/products-relationship-$id.xml";
                $this->relFeed->save($relFeedFile);
                $data['feed_file'] = $relFeedFile;
                $data['status'] = MarketplaceWebService_DB::$STATUS_PREP_SUCCESS;
                MarketplaceWebService_DB::updateSubFeedStatus($this->id_rel_feed, $data);
            }
        }

	$n = false;

        //Notify all the updates
        $mail_text = "";
	if( count($delete_list) )
		$n = true;
        $mail_text .= "<h1>Deleted List</h1>";
        $mail_text .= "<ul><li>".implode("</li><li>", $delete_list) . "</li></ul>";
        
        $mail_text .= "<h1>Updated List</h1>";
        $sql = "select id_sku, price, specific_price,quantity, shipping_sla,active, exclusive from ps_affiliate_feed_product_info where date_upd > '". $this->date_res['last_date_add']. "' order by id_sku desc";
        $skus = $this->db->ExecuteS($sql); 
        $mail_text .= '<table border="1" style="border-collapse: collapse;">';
        $mail_text .= '<tr>';
        $mail_text .= '<td>SKU</td>';
        $mail_text .= '<td>Price</td>';
        $mail_text .= '<td>Discount Price</td>';
        $mail_text .= '<td>Quantity</td>';
        $mail_text .= '<td>Shipping SLA</td>';
        $mail_text .= '<td>Active</td>';
        $mail_text .= '<td>Exclusive</td>';
        $mail_text .= '</tr>';
        foreach($skus as $u) {
            $n = true;
            $mail_text .= '<tr>';
            $mail_text .= '<td>'.$u['id_sku'].'</td>';
            $mail_text .= '<td>'.$u['price'].'</td>';
            $mail_text .= '<td>'.$u['specific_price'].'</td>';
            $mail_text .= '<td>'.$u['quantity'].'</td>';
            $mail_text .= '<td>'.$u['shipping_sla'].'</td>';
            $mail_text .= '<td>'.$u['active'].'</td>';
            $mail_text .= '<td>'.$u['exclusive'].'</td>';
            $mail_text .= '</tr>';
        }
        $mail_text .= '</table>';
        $mail_text .= "<h1>New Additions</h1>";
        $sql = "select id_sku, price, specific_price,quantity, shipping_sla,active, exclusive from ps_affiliate_feed_product_info where date_add > '". $this->date_res['last_date_add'] . "' order by id_sku desc";
        $skus = $this->db->ExecuteS($sql); 
        $mail_text .= '<table border="1" style="border-collapse: collapse;">';
        $mail_text .= '<tr>';
        $mail_text .= '<td>SKU</td>';
        $mail_text .= '<td>Price</td>';
        $mail_text .= '<td>Discount Price</td>';
        $mail_text .= '<td>Quantity</td>';
        $mail_text .= '<td>Shipping SLA</td>';
        $mail_text .= '<td>Active</td>';
        $mail_text .= '<td>Exclusive</td>';
        $mail_text .= '</tr>';
        foreach($skus as $u) {
            $n = true;
            $mail_text .= '<tr>';
            $mail_text .= '<td>'.$u['id_sku'].'</td>';
            $mail_text .= '<td>'.$u['price'].'</td>';
            $mail_text .= '<td>'.$u['specific_price'].'</td>';
            $mail_text .= '<td>'.$u['quantity'].'</td>';
            $mail_text .= '<td>'.$u['shipping_sla'].'</td>';
            $mail_text .= '<td>'.$u['active'].'</td>';
            $mail_text .= '<td>'.$u['exclusive'].'</td>';
            $mail_text .= '</tr>';
        }
        $mail_text .= '</table>';
	if( $n ) {
            $templateVars = array(
                'event' => 'Amazon Stock Sync Updates',
                'description' => $mail_text
            );
            @Mail::Send(1, 'alert', Mail::l('Amazon Stock Sync Update'), $templateVars, array("venkatesh.padaki@violetbag.com","lekshmi.gopinathan@violetbag.com","vineet.saxena@violetbag.com","venugopal.annamaneni@violetbag.com"), null, 'care@indusdiva.com', 'Indusdiva Monitoring', NULL, NULL, _PS_MAIL_DIR_, false);
        }

    }
    
    protected function getRelationshipObj($id_product, $skus) {

        $relationshipData = new MarketplaceWebService_XML_Data_Relationship();
        $relationshipData->setParentSKU($id_product);
        foreach($skus as $id_sku) {
            $relationshipData->addRelation(new MarketplaceWebService_XML_DataType_Relation($id_sku,'Variation'));
        }
        return $relationshipData;
    }
    
    protected function getInventoryObj($divaProduct, $sku, &$quantity, &$shipping_sla, $zero = false) {
        
        $id_product = $sku["id_product"];
        $is_parent = $sku["is_parent"];
        $has_children = empty($sku["attribute"])?false:true;
        $size = empty($sku["attribute"])?"One Size":$sku["attribute"]["attribute_name"];
        $id_sku = $sku['id_sku'];

        $inventoryData = new MarketplaceWebService_XML_Data_Inventory();
      	$inventoryData->setSKU($id_sku);

        if( $is_parent === false && $has_children === false) {   
            $quantity = (int)Product::getQuantity($id_product);
            if( $quantity < 0)
                $inventoryData->setQuantity(0);
            else
                $inventoryData->setQuantity($quantity);
        } else {
            if( $is_parent ) {
                $quantity = (int)Product::getQuantity($id_product);
                if( $quantity < 0)
                    $inventoryData->setQuantity(0);
                else
                    $inventoryData->setQuantity($quantity);
	        } else {
                $quantity = (int)Product::getQuantity($id_product, $sku['attribute']['id_product_attribute']);
                if( $quantity < 0)
                    $inventoryData->setQuantity(0);
                else
                    $inventoryData->setQuantity($quantity);
            }
        }
        if( $zero ) {
            $inventoryData->setQuantity(0);
        }
        $shipping_sla = (int)$divaProduct->shipping_sla;
        $inventoryData->setFulfillmentLatency($shipping_sla);

        return $inventoryData;
    }

    protected function getDeleteObj($divaProduct, $sku) {
        $id_sku = $sku["id_sku"];
        $amazonProduct = new MarketplaceWebService_XML_Data_Clothing();
        $amazonProduct->setSKU($id_sku);
        return $amazonProduct;
    }

    protected function getPriceObj($divaProduct, $sku, &$price, &$specific_price) {
	$this->id_affiliate = 1;
        $id_product = $sku["id_product"];
        $id_sku = $sku["id_sku"];
        $is_parent = $sku["is_parent"];
        $has_children = empty($sku["attribute"])?false:true;
        $size = empty($sku["attribute"])?"One Size":$sku["attribute"]["attribute_name"];

        if( $is_parent === false && $has_children === false ) {
            $price = (int)round($divaProduct->getPriceWithoutReduct());
            $specific_price = (int)round($divaProduct->getAffiliatePrice($this->id_affiliate));
        } else {
            if( $is_parent ) {
                $price = (int)round($divaProduct->getPriceWithoutReduct());
                $specific_price = (int)round($divaProduct->getAffiliatePrice($this->id_affiliate));
            } else {
                $price = (int)round($divaProduct->getPriceWithoutReduct(false, $sku['attribute']['id_product_attribute']));
                $specific_price = (int)round($divaProduct->getAffiliatePrice($this->id_affiliate, true, $sku['attribute']['id_product_attribute']));
            }
        }
        
        $priceData = new MarketplaceWebService_XML_Data_Price();
        
        $priceData->setSKU($id_sku);

        $standardPrice = new MarketplaceWebService_XML_DataType_Price($price, 'USD');
        $priceData->setStandardPrice($standardPrice);

        if( $price > $specific_price) {
            $saleStartDay = new DateTime();
            $saleEndDay = new DateTime();
            $saleEndDay->modify('+4 month');

            $discountPriceObj = new MarketplaceWebService_XML_DataType_Price( $specific_price, 'USD');
            $salePriceObj = new MarketplaceWebService_XML_DataType_Sale( $saleStartDay, $saleEndDay, $discountPriceObj);
            $priceData->setSale($salePriceObj);      
        }
        return $priceData;
    }

    protected function getImageObj($divaProduct, $sku) {
        
        $id_product = $sku["id_product"];
        $id_sku = $sku["id_sku"];
        $is_parent = $sku["is_parent"];
        $has_children = empty($sku["attribute"])?false:true;
        $size = empty($sku["attribute"])?"One Size":$sku["attribute"]["attribute_name"];
        
        global $protocol_content;
        $protocol_content = (isset($useSSL) AND $useSSL AND Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';
        
        $link = new Link();
        $imageDataArray = array();
        
        $imageData = new MarketplaceWebService_XML_Data_Image();
        
        $imageData->setSKU($id_sku);
        $imageData->setImageType('Main');
        $idImage = $divaProduct->getCoverWs();
        if($idImage)
            $idImage = $divaProduct->id.'-'.$idImage;
        else
            $idImage = Language::getIsoById(1).'-default';

        $mainImage = $link->getImageLink($divaProduct->link_rewrite,$idImage, 'thickbox');
        $imageData->setImageLocation($mainImage);
        array_push($imageDataArray, $imageData); 
        $c=1;
        $images = $divaProduct->getImages(1);
        foreach($images as $image) {
            $oImage = $link->getImageLink($divaProduct->link_rewrite,$image['id_image'], 'thickbox');
            if( $mainImage !== $oImage ) {
                $imageData = new MarketplaceWebService_XML_Data_Image();
                $imageData->setSKU($id_sku);
                $imageData->setImageType('PT'.$c++);
                $imageData->setImageLocation($oImage);
                array_push($imageDataArray, $imageData); 
            }
        }
        return $imageDataArray;
    }
}
