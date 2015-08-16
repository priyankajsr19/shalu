<?php

class JewelryFeed extends BaseFeed {

    public function __construct($purgeOld = false) {
        parent::__construct($purgeOld);
    }

    protected function initFeedObject($type) {
        if( $type === 'Product' ) {
            if(empty($this->productFeed))
                $this->productFeed = new MarketplaceWebService_XML_Feed_Jewelry($this->config, 'Product');
        } 
        parent::initFeedObject($type);
    }

    protected function getProductsSQL() {
        $sql = "select max(date_add) last_date_add from ps_affiliate_feed";
        $date_res = $this->db->getRow($sql); 
        
        $cat_sql = array();
        //jewelry
        $sql = "select cp.id_product from ps_category_product cp inner join ps_product p on p.id_product = cp.id_product  where p.active = 1 and p.quantity > 0 and p.is_exclusive = 1 and  cp.id_category = ".CAT_JEWELRY;
        //if ( isset($date_res) && !empty($date_res['last_date_add'])  ) 
        //    $sql .= " and (p.date_upd >= '".$date_res['last_date_add']."' OR p.date_add >= '".$date_res['last_date_add']."')";
        $cat_sql[] = $sql;
        
        $sql = implode(" UNION ", $cat_sql) . " limit 10"; 
        return $sql;
    }

    public function getProductObj($divaProduct, $sku) {
        
        $id_product = $sku["id_product"];
        $id_sku = $sku["id_sku"];
        $is_parent = $sku["is_parent"];
        $has_children = empty($sku["attribute"])?false:true;
        $size = empty($sku["attribute"])?"One Size":$sku["attribute"]["attribute_name"];

        $amazonProduct = new MarketplaceWebService_XML_Data_Jewelry();
        $amazonProduct->setSKU($id_sku);
        
        // Prefix with IndusDiva Women's if possible
        $pretext = "IndusDiva Women's ";
        if( strlen($divaProduct->name) <= (80-strlen($pretext) ))
            $amazonProduct->setTitle($pretext.(string)$divaProduct->name);
        else {
            // Prefix with just IndusDiva atleast if possible
            $pretext = "IndusDiva ";
            if( strlen($divaProduct->name) <= (80-strlen($pretext)) )
                $amazonProduct->setTitle($pretext.(string)$divaProduct->name);
            else {
                // Add the Title as it is
                $amazonProduct->setTitle((string)$divaProduct->name);
            }
        }
        $amazonProduct->setBrand('IndusDiva');
        $amazonProduct->setDescription((string)$divaProduct->description);
        $amazonProduct->setMerchantCatalogNumber( (string)$divaProduct->reference );
        
        
        $condition =  new MarketplaceWebService_XML_DataType_Condition("New"); 
        $amazonProduct->setCondition($condition);
        
        $amazonProduct->setIsGiftWrapAvailable(false);
        $amazonProduct->setIsGiftMessageAvailable(false);
        
        $model_number = "ID-$id_product";
        $amazonProduct->setModelNumber($id_sku);

        
        if( isset($divaProduct->dimensions) && !empty($divaProduct->dimensions))
            $amazonProduct->addBulletPoint("Dimensions:".(string)$divaProduct->dimensions);
        if( isset($divaProduct->look) && !empty($divaProduct->look))
            $amazonProduct->addBulletPoint("Look:".(string)$divaProduct->look);

        $categories = $divaProduct->getCategories();
        $metal_type = null;
        $metal_types = array("2 Colour Gold","3 Colour Gold","Base Metal","Brass","Copper","Gold Plated","Oxidized Gold","Oxidized Silver","Palladium","Platinum","Platinum Plated","Rose Gold","Silver","Silver Plated","Stainless Steel","Titanium","Tungsten","Vermeil","White Gold","Yellow Gold");
        foreach($metal_types as $m) {
            if( stripos($m, $divaProduct->name) !== false || stripos($m, $divaProduct->description) !== false || stripos($m, $divaProduct->material) !== false) {
                $metal_type = $m;
                break;
            }
        }
        $item_shape = null;
        $item_shapes = array("Bangle","Bangle Set","Chain","Charm","Choker","Cuff & Kadaa","Mangalsutra","Multi-Strand","Pendant","Strand","Clip-On","Dangle & Drop","Hoop","Jhumki","Stud");
        foreach($item_shapes as $m) {
            if( stripos($m, $divaProduct->name) !== false || stripos($m, $divaProduct->description) !== false || stripos($m, $divaProduct->material) !== false) {
                $item_shape = $m;
                break;
            }
        }

        if( in_array(460, $categories) ) {
            $earring = new MarketplaceWebService_XML_DataType_FashionEarring();
            if( isset($divaProduct->generic_color) && !empty($divaProduct->generic_color) ) {
                $amazon_color = MarketplaceWebService_AmazonDataMap::getAmazonColor((string)$divaProduct->generic_color);
                if( $amazon_color  !== null )   
                    $earring->setColorMap($amazon_color);
            }
            $earring->addStone($divaProduct->stone);
            $earring->addMaterial($divaProduct->material);
            $earring->setDepartmentName('womens');
            $earring->setMetalType($metal_type);
            $earring->setItemShape($item_shape);
            $earring->setOccasionType($divaProduct->occasion);
            $amazonProduct->setProductType($earring);
        } elseif( in_array(455, $categories) || in_array(465, $categories)) {
            $neckwear = new MarketplaceWebService_XML_DataType_FashionNecklaceBraceletAnklet();
            if( isset($divaProduct->generic_color) && !empty($divaProduct->generic_color) ) {
                $amazon_color = MarketplaceWebService_AmazonDataMap::getAmazonColor((string)$divaProduct->generic_color);
                if( $amazon_color  !== null )   
                    $neckwear->setColorMap($amazon_color);
            }
            if( isset($divaProduct->stone) && !empty($divaProduct->stone))
                $neckwear->addStone($divaProduct->stone);
            if( isset($divaProduct->material) && !empty($divaProduct->material))
                $neckwear->addMaterial($divaProduct->material);
            $neckwear->setDepartmentName('womens');
            $neckwear->setMetalType($metal_type);
            $neckwear->setItemShape($item_shape);
            $neckwear->setOccasionType($divaProduct->occasion);
            $amazonProduct->setProductType($neckwear);
        } elseif( in_array(475, $categories) ) {
            $other = new MarketplaceWebService_XML_DataType_FashionOther();
            if( isset($divaProduct->generic_color) && !empty($divaProduct->generic_color) ) {
                $amazon_color = MarketplaceWebService_AmazonDataMap::getAmazonColor((string)$divaProduct->generic_color);
                if( $amazon_color  !== null )   
                    $other->setColorMap($amazon_color);
            }
            $other->addStone($divaProduct->stone);
            $other->addMaterial($divaProduct->material);
            $other->setDepartmentName('womens');
            $other->setMetalType($metal_type);
            $other->setItemShape($item_shape);
            $other->setOccasionType($divaProduct->occasion);
            $amazonProduct->setProductType($other);
        }
        
        return $amazonProduct;
    }
}
?>
