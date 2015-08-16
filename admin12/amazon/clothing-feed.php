<?php

class ClothingFeed extends BaseFeed {

    public function __construct($purgeOld = false) {
        parent::__construct($purgeOld);
    }

    protected function initFeedObject($type) {
        if( $type === 'Product' ) {
            if(empty($this->productFeed))
                $this->productFeed = new MarketplaceWebService_XML_Feed_Clothing($this->config, 'Product');
        } 
        parent::initFeedObject($type);
    }


    public function getProductObj($divaProduct, $sku) {
        
        $id_product = $sku["id_product"];
        $id_sku = $sku["id_sku"];
        $is_parent = $sku["is_parent"];
        $has_children = empty($sku["attribute"])?false:true;
        $size = empty($sku["attribute"])?"One Size":$sku["attribute"]["attribute_name"];

        $amazonProduct = new MarketplaceWebService_XML_Data_Clothing();
        
        $amazonProduct->setSKU($id_sku);
        
        $categories = $divaProduct->getCategories();
        if( in_array(CAT_SAREE, $categories) ) {
            $size_str = $size;
            $measurements = array();
            if( isset($divaProduct->width) ) { 
                $divaProduct->width = trim($divaProduct->width);
                if(!empty($divaProduct->width) )
                    array_push($measurements, "Length:".(string)$divaProduct->height." meter");
            }
            if( isset($divaProduct->height) ) {
                $divaProduct->height = trim($divaProduct->height);
                if( !empty($divaProduct->height) )
                    array_push($measurements, "Width:".(string)$divaProduct->width." inch");
            }
            if( isset($divaProduct->blouse_length)) {
                $divaProduct->blouse_length = trim($divaProduct->blouse_length);
                if( !empty($divaProduct->blouse_length) )
                    array_push($measurements, "Blouse Length:".(string)$divaProduct->blouse_length." cm");
            }
            if( !empty($measurements) ) {
                $amazonProduct->addBulletPoint(implode(" - ",$measurements));
            }
            $amazonProduct->addBulletPoint("Saree is an elegant Indian outfit,this Sari also comes with an unstitched attached blouse fabric.");
            $amazonProduct->addSearchTerms("sarees from india");    
            $amazonProduct->addSearchTerms("saree with blouse");    
            $amazonProduct->addSearchTerms("sareez");    
            $amazonProduct->addSearchTerms("sarees for women");    
            $amazonProduct->addSearchTerms("indian dress");    
        } else if(in_array(CAT_CHOLIS, $categories)) {
            //No specific attributes
            $size_str = "Bust : $size inch";
            $amazonProduct->addBulletPoint("Choli blouses from India, pair it with any saree or Lehenga skirt of your choice.");
            $amazonProduct->addSearchTerms("choli top");    
            $amazonProduct->addSearchTerms("choli dress");    
            $amazonProduct->addSearchTerms("choli blouse");    
            $amazonProduct->addSearchTerms("indian choli");    
            $amazonProduct->addSearchTerms("choli for lehenga");    
        } else if(in_array(CAT_SKD, $categories) || in_array(CAT_KURTI, $categories)) {
            $size_str = "Bust : $size inch";
            $styles = array();
            if( isset($divaProduct->kameez_style) ) {
                $divaProduct->kameez_style = trim($divaProduct->kameez_style);
                if( !empty($divaProduct->kameez_style) )
                    array_push($styles, "Kameez Style: ". (string)$divaProduct->kameez_style);
            }
            if( isset($divaProduct->salwar_style) ) {
                $divaProduct->salwar_style = trim($divaProduct->salwar_style);
                if( !empty($divaProduct->salwar_style) )
                    array_push($styles, "Salwar Style: ". (string)$divaProduct->salwar_style);
            }
            if( isset($divaProduct->sleeves) ) {
                $divaProduct->sleeves = trim($divaProduct->sleeves);
                if( !empty($divaProduct->sleeves) )
                    array_push($styles, "Sleeves: ". (string)$divaProduct->sleeves);
            }
            if( !empty($styles) )
                $amazonProduct->addBulletPoint(implode(" - ",$styles));
            if( in_array(CAT_SKD, $categories) ) {
                $amazonProduct->addBulletPoint("Our Salwar Kameez set is fit for all occasions, an ensemble that completes your wardrobe.");
                $amazonProduct->addSearchTerms("Salwar Kameez Readymade");    
                if( in_array(CAT_ANARKALI, $categories) )
                    $amazonProduct->addSearchTerms("Salwar Kameez Anarkali");
                else
                    $amazonProduct->addSearchTerms("Salwar Kameez Set");
                $amazonProduct->addSearchTerms("Salwar Kameez Women");
                $amazonProduct->addSearchTerms("Chiridar Salwar Kameez");
                $amazonProduct->addSearchTerms("Salwar Kameez from India");
            }
            if( in_array(CAT_KURTI, $categories) ) {
                $amazonProduct->addBulletPoint("A Kurti is trendy and easy to wear, the best from our kurtis and tunics collection."); 
                $amazonProduct->addSearchTerms("Kurti for Women");    
                $amazonProduct->addSearchTerms("Indian Kurti for Women");
                $amazonProduct->addSearchTerms("Kurti tops");
                $amazonProduct->addSearchTerms("Kurtis from India");
                $amazonProduct->addSearchTerms("Kurti Tunics"); 
            }   
        } else if(in_array(CAT_BOTTOMS, $categories)) {
            if( in_array(493, $categories)) {
                $size_str = $size;
            } else {
                $size_str = "Waist : $size inch";
            }
            $amazonProduct->addBulletPoint("Bottoms for Salwar Sets and Kurtis from India, casual and comfortable.");
            $amazonProduct->addSearchTerms("Bottoms Women");    
            $amazonProduct->addSearchTerms("Bottom Pants");    
            $amazonProduct->addSearchTerms("Indian Bottom");    
            $amazonProduct->addSearchTerms("Salwar Bottom");    
        } else if(in_array(CAT_LEHENGA, $categories)) {
            $size_str = "Bust : $size inch";
            $amazonProduct->addBulletPoint("Lehenga Choli Dresses from India are a style statement, the best Lehenga skirts for women are here.");
            $amazonProduct->addSearchTerms("Lehenga Choli for women");    
            $amazonProduct->addSearchTerms("Lehenga Skirt");    
            $amazonProduct->addSearchTerms("Lehenga Choli exotic India");    
            $amazonProduct->addSearchTerms("Lehenga Choli Skirt");    
            $amazonProduct->addSearchTerms("Lehenga Dress");    
        } else {
            throw new Exception("Product not falling in the allowed category list");
            return;
        }
        
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

        $amazonProduct->setItemType("Novelty Dresses");
        $amazonProduct->setIsGiftWrapAvailable(false);
        $amazonProduct->setIsGiftMessageAvailable(false);


        if( $is_parent === false && $has_children === false ) { 
            $amazonProduct->setSize($size_str);
            $amazon_size = MarketplaceWebService_AmazonDataMap::getAmazonSize($size);
            if( $amazon_size !== null )
                $amazonProduct->setSizeMap($amazon_size);
        } else {
            if( $is_parent ) {
                $amazonProduct->setParentage("parent");
                $amazonProduct->setVariationTheme("Size");
            } else {
                $amazonProduct->setParentage("child");
                $amazonProduct->setVariationTheme("Size");

                $amazonProduct->setSize($size_str);
                $amazon_size = MarketplaceWebService_AmazonDataMap::getAmazonSize($size);
                if( $amazon_size !== null )
                    $amazonProduct->setSizeMap($amazon_size);
            }
        } 
        
        if( isset($divaProduct->color) && !empty($divaProduct->color) )
            $amazonProduct->setColor((string)$divaProduct->color);
        if( isset($divaProduct->generic_color) && !empty($divaProduct->generic_color) ) {
            $amazon_color = MarketplaceWebService_AmazonDataMap::getAmazonColor((string)$divaProduct->generic_color);
            if( $amazon_color  !== null )   
                $amazonProduct->setColorMap($amazon_color);
        }

        $amazonProduct->setClothingType('Dress');
        $amazonProduct->addDepartment('womens');
        $model_number = "ID-$id_product";
        $amazonProduct->setModelNumber($id_sku);

        $wash_care = "Dry cleaning is the best method to wash";
        $amazonProduct->setFabricWash($wash_care);


        $amazonProduct->setTargetGender('female');

        if( isset($divaProduct->work_type) && !empty($divaProduct->work_type))
            $amazonProduct->addBulletPoint("Work type:".(string)$divaProduct->work_type);
        if( isset($divaProduct->garment_type) && !empty($divaProduct->garment_type))
            $amazonProduct->addBulletPoint("Garment type:".(string)$divaProduct->garment_type);
        

        /*if( is_array($divaProduct->tags) ) {
            $tt = 1;
            foreach($divaProduct->tags[1] as $tag) {
                $amazonProduct->addSearchTerms((string)$tag);
                $tt++;
                if( $tt ===  5)
                    break;
            }
        }*/
        
        if( isset($divaProduct->fabric) && !empty($divaProduct->fabric) )
            $amazonProduct->addMaterialAndFabric((string)$divaProduct->fabric);
        
        if( stripos((string)$divaProduct->fabric,'silk' ) !== false ) {
            $care_instructions = "For silk apparel, it is necessary that one keeps it covered by a cotton cloth, always.Being a pure natural fabric, they need abundant breathing and cotton is one of the few materials which allow this. Never wrap silk apparel in plastic and trap the moisture; this could change the color and quality of the fabric in no time. Additionally always keep it free from moths by using cedar sticks.";
            $amazonProduct->setCareInstructions($care_instructions);
        }

        return $amazonProduct;
    }
}
?>
