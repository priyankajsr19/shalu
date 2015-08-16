<?php

@ini_set('max_execution_time', 0);

class AdminProductImport extends AdminTab {

    public function preProcess() {

    }

    public function postProcess() {
        global $currentIndex, $cookie, $smarty;

        $smarty->assign('currentIndex', $currentIndex);
        $smarty->assign('token', $this->token);

        if (Tools::getValue('product_upload')) {
            $this->handleUpload();
        } elseif (Tools::getValue('product_update')) {
            $this->handleUpload(true);
        }

        if (Tools::getValue('confirm_import')) {
            $this->handleConfirm();
        }

        if (Tools::getValue('confirm_update')) {
            $this->handleConfirm(true);
        }

        if (Tools::getValue('related_product_update')) {
            $this->handleRelated();
        }

	    if( Tools::getValue('product_style_mapping')) {
	        $this->handleProductStyleMapping();
	    }

        if (Tools::getValue('updateSearchRanks'))
            $this->updateSearchRankings();

        if (Tools::getValue('setOOS'))
            $this->setOOS();

        if (Tools::getValue('setB1G1Tag'))
            $this->setB1G1Tag();

        if (Tools::getValue('removeB1G1Tag'))
            $this->removeB1G1Tag();
    }

    public function setOOS() {
        global $currentIndex, $cookie, $smarty;

        $target_path = _PS_ADMIN_DIR_ . "/product-uploads/";

        /* Add the original filename to our target path */
        $target_path = $target_path . basename($_FILES['oos_products_file']['name']) . $_SERVER['REQUEST_TIME'];

        if (move_uploaded_file($_FILES['oos_products_file']['tmp_name'], $target_path)) {
            $f = fopen($target_path, 'r');
            //read header to get the search strings
            $line = fgetcsv($f);

            $lines = array();
            while ($line = fgetcsv($f)) {
                $lines[] = $line;
            }

            $productIDs = array();

            foreach ($lines as $line) {
                $productId = (int) $line[0];
                $productObj = new Product($productId);

                $productObj->deleteProductAttributes();
                $productObj->quantity = -3;
                $productObj->update();

                $productIDs[] = $productId;
            }

            SolrSearch::updateProducts($productIDs);

            $smarty->assign('updated_oos', count($productIDs));
        }
    }

    public function setB1G1Tag() {
        global $smarty;

        $target_path = _PS_ADMIN_DIR_ . "/product-uploads/";

        /* Add the original filename to our target path */
        $target_path = $target_path . basename($_FILES['b1g1_tag_file']['name']);
        if (move_uploaded_file($_FILES['b1g1_tag_file']['tmp_name'], $target_path)) {
            $f = fopen($target_path, 'r');
            //read header to get the search strings
            $line = fgetcsv($f);

            $lines = array();
            while ($line = fgetcsv($f)) {
                $lines[] = $line;
            }
            
            $productIDs = array();
            foreach ($lines as $line) {
                $productId = (int) $line[0];
                $productObj = new Product($productId, true);
                $tags = $productObj->tags;
                if(!in_array('buy1get1', $tags[1])){
                    $productObj->addTag('buy1get1');
                    $productIDs[] = $productId;
                }
            }

            SolrSearch::updateProducts($productIDs);

            $smarty->assign('updated_b1g1_tags', count($productIDs));
        }else{
            print_r("file could not be uploaded");
        }
    }

    public function removeB1G1Tag(){
	global $smarty;
        $target_path = _PS_ADMIN_DIR_ . "/product-uploads/";
        $target_path = $target_path . basename($_FILES['b1g1_tag_file']['name']);
        
        $get_tag_query = "select id_tag from `"._DB_PREFIX_."tag` "."where name = 'buy1get1'";
        $result = Db::getInstance()->ExecuteS($get_tag_query);
        if(count($result) > 0){
            $id_tag = $result[0]['id_tag'];
        
        if (move_uploaded_file($_FILES['b1g1_tag_file']['tmp_name'], $target_path)) {
            $f = fopen($target_path, 'r');
            //read header to get the search strings
            $line = fgetcsv($f);

            $lines = array();
            while ($line = fgetcsv($f)) {
                $lines[] = $line;
            }
            
            $productIDs = array();
            foreach ($lines as $line) {
                $productId = (int) $line[0];
                $productIDs[] = $productId;
                $del_query = "delete from `"._DB_PREFIX_."product_tag` where id_tag=".$id_tag ." and id_product=".$productId;
                $result = Db::getInstance()->Execute($del_query);
            }

            SolrSearch::updateProducts($productIDs);
            $smarty->assign('updated_b1g1_tags', count($productIDs));
        }else{
            $already_tagged_products_sql = "select id_product from `"._DB_PREFIX_."product_tag"."` WHERE id_tag=".(int)$id_tag;
            $already_tagged_products = Db::getInstance()->ExecuteS($already_tagged_products_sql);
            $already_tagged_products = array_map(function($item){
                return $item['id_product'];
            }, $already_tagged_products);
            //  print_r('will reindex these products');print_r($already_tagged_products);
            SolrSearch::updateProducts($already_tagged_products);

            $del_query = "delete from `"._DB_PREFIX_."product_tag` where id_tag=".$id_tag;
            $result = Db::getInstance()->Execute($del_query);
            $smarty->assign('deleted_b1g1_tags', count($already_tagged_products));
            }
        }
    }

    public function updateSearchRankings() {
        global $currentIndex, $cookie, $smarty;

        $target_path = _PS_ADMIN_DIR_ . "/product-uploads/";

        /* Add the original filename to our target path.
          Result is "uploads/filename.extension" */
        $target_path = $target_path . basename($_FILES['ranking_products_file']['name']) . $_SERVER['REQUEST_TIME'];

        if (move_uploaded_file($_FILES['ranking_products_file']['tmp_name'], $target_path)) {
            $f = fopen($target_path, 'r');
            //read header to get the search strings
            $line = fgetcsv($f);

            $indexes = array();
            $totalCols = count($line);
            for ($i = 1; $i < $totalCols; $i++) {
                $word = trim(strtolower($line[$i]));
                $indexes[$i] = $word;
            }

            $lines = array();
            while ($line = fgetcsv($f)) {
                $lines[] = $line;
            }

            $productDescriptions = array();
            $productIDs = array();

            foreach ($lines as $line) {
                $productId = $line[0];
                $indexedString = '';

                for ($i = 1; $i < $totalCols; $i++) {
                    $wordCount = 7 - $line[$i];
                    for ($j = 0; $j < $wordCount; $j++)
                        $indexedString = $indexedString . ' ' . $indexes[$i];
                }

                $productDescriptions[] = array('id' => $productId, 'text' => $indexedString);
                $productIDs[] = $productId;
            }

            foreach ($productDescriptions as $productDescription) {
                $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("UPDATE ps_product_lang SET description_short = '" . $productDescription['text'] . "' WHERE id_product = " . $productDescription['id']);
            }

            SolrSearch::updateProducts($productIDs);

            $smarty->assign('updated_ranks', count($productIDs));
        }
    }

    public function handleProductStyleMapping() {
        global $currentIndex, $cookie, $smarty;

        $target_path = _PS_ADMIN_DIR_ . "/product-uploads/";

        /* Add the original filename to our target path.
          Result is "uploads/filename.extension" */
        $target_path = $target_path . basename($_FILES['product_style_mapping_file']['name']) . $_SERVER['REQUEST_TIME'];

        $is_rts = (Tools::getValue('product_type') === 'rts') ? 1: 0;
        $as_shown = (Tools::getValue('product_type') === 'as_shown') ? 1: 0;

        if (move_uploaded_file($_FILES['product_style_mapping_file']['tmp_name'], $target_path)) {
            $f = fopen($target_path, 'r');
            //discard header
            $line = fgetcsv($f);
            $product_styles_mapped = array();
            while ($line = fgetcsv($f)) {
                $id_product  = (int)$line[0];
                $top_styles = (string)$line[1];
                $bottom_styles = (string)$line[2];
                if( !empty($top_styles) || !empty($bottom_styles) ) {
                    $top_style_ids = explode(";", $top_styles);
                    $bottom_style_ids = explode(";",$bottom_styles);
                
                    $product = new Product($id_product);
                    if( Product::isProductOfCategory($id_product, CAT_SAREE) )
                        $product->is_rts = 0;
                    else
                        $product->is_rts = $is_rts;
                    $product->as_shown = $as_shown;

                    $sql = "delete from ps_product_style where id_product = {$id_product}";
                    Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql); 
                    $sql = "insert into ps_product_style values";
                    $default = 1;
                    $sqli = array();
                    foreach($top_style_ids as $style_id) {
                        if( !empty($style_id) ) {
                                array_push($sqli,"($id_product,$style_id,$default)");
                                $default = 0;
                        }
                    }
                    $default = 1;
                    foreach($bottom_style_ids as $style_id) {
                        if( !empty($style_id) ) {
                                array_push($sqli,"($id_product,$style_id,$default)");
                                $default = 0;
                        }
                    }
                    $sql = $sql . implode(",",$sqli);
                    Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql); 
                    if( Validate::isLoadedObject($product) )
                        $product->update();
                    array_push($product_styles_mapped,$id_product);
                    $smarty->assign("product_styles_mapped","Product Styles Mapped : ".count($product_styles_mapped) ." <br/>Product IDs : ". implode(",",$product_styles_mapped));
                } else {
                    $smarty->assign('error', "Product ID : {$id_product} has no styles mapped. Correct this and upload again");
                    return;
                }
            }
        }
    }

    public function handleRelated() {
        global $currentIndex, $cookie, $smarty;

        $target_path = _PS_ADMIN_DIR_ . "/product-uploads/";

        /* Add the original filename to our target path.
          Result is "uploads/filename.extension" */
        $target_path = $target_path . basename($_FILES['related_products_file']['name']) . $_SERVER['REQUEST_TIME'];

        if (move_uploaded_file($_FILES['related_products_file']['tmp_name'], $target_path)) {
            $f = fopen($target_path, 'r');
            //discard header
            $line = fgetcsv($f);
            while ($line = fgetcsv($f)) {
                $reference = $line[0];
                $related_references = explode(",", $line[1]);

                $product = Product::getByReference(trim($reference));
                $parent_groupID = $product->id;

                foreach ($related_references as $reference) {
                    if (empty($reference))
                        continue;
                    $product = Product::getByReference(trim($reference));
                    $product->id_group = $parent_groupID;

                    if (Validate::isLoadedObject($product))
                        $product->update();
                }
            }
        }
    }

    public function handleConfirm($update = false) {
        global $currentIndex, $cookie, $smarty;
        $products_to_import = array();
        $defaultLanguageId = (int) (Configuration::get('PS_LANG_DEFAULT'));
        $file_path = Tools::getValue('current_file');
        $overwrite_imgs = Tools::getValue("overwrite_imgs");
        //$file_path = '/Users/rohit/webroot/indusdiva/admin12/product-uploads/upload_sheet_1.csv';
        $f = fopen($file_path, 'r');
        $file_error = false;

        if ($f) {
            //discard header
            $line = fgetcsv($f);

            while ($line = fgetcsv($f)) {
		//ignore empty lines
		if( empty($line) )
			continue;
		//trim data
		foreach($line as $key=>$value)
			$line[$key] = trim($value);

                $id_product = $line[0];
                $images = $line[1];
                $product_name = $line[2];
                $fabric = $line[3];
                $color = $line[4];
                $mrp = $line[5];
                $supplier_code = $line[6];
                $reference = $line[7];
                $location = $line[8];
                $length = $line[9];
                $width = $line[10];
                $blouse_length = $line[11];
                $garment_type = $line[12];
                $work_type = $line[13];
                $weight = $line[14];
                $description = $line[15];
                $other_info = $line[16];
                $wash_care = $line[17];
                $shipping_estimate = $line[18];
                $supplier_price = $line[19];
                $manufacturer = $line[20];
                $categories = explode(",", $line[21]);
                $tax_rule = $line[22];
                $quantity = $line[23];
                $active = $line[24];
                $discount = $line[25];
                $tags = $line[26];
                $kameez_style = $line[27];
                $salwar_style = $line[28];
                $sleeves = $line[29];
                $customizable = $line[30];
                $generic_color = $line[31];
                $skirt_length = $line[32];
                $dupatta_length = $line[33];

                $stone = $line[34];
                $plating = $line[35];
                $material = $line[36];
                $dimensions = $line[37];
                $look = $line[38];
                $as_shown = (isset($line[39]) && !empty($line[39])) ? intval($line[39]) : 0;
                $id_sizechart = (isset($line[40]) && !empty($line[40])) ? intval($line[40]) : 0;
                $is_exclusive = (isset($line[41]) && !empty($line[41])) ? intval($line[41]) : 0;

                $handbag_occasion = (isset($line[42]) && !empty($line[42])) ? $line[42] : null;
                $handbag_style = (isset($line[43]) && !empty($line[43])) ? $line[43] : null;
                $handbag_material = (isset($line[44]) && !empty($line[44])) ? $line[44] : null;

                $images = explode(",", $images);

                $error = false;
                //validate fields
                if (!Validate::isFloat($mrp))
                    $error = 'MRP should be a number: ' . trim($reference);
                elseif (!Validate::isFloat($supplier_price))
                    $error = 'Supplier Price should be a number: ' . trim($reference);

                $importCategories = array();
                if (is_array($categories)) {
                    $categories = array_unique($categories);
                    foreach ($categories as $category) {
                        $category = intval(trim($category));
                        if (empty($category))
                            continue;
                        if (!is_numeric($category) || !Category::categoryExists($category))
                            $error = 'Category does not exist: ' . $category;

                        $importCategories[] = $category;
                    }
                }
                else
                    $error = 'Atleast one category required: ' . trim($reference);

                if (!Validate::isFloat($weight))
                    $error = 'Weight has to be a number: ' . trim($reference);

                if (!empty($manufacturer) && (!is_numeric($manufacturer) || !Manufacturer::manufacturerExists((int) ($manufacturer))))
                    $error = 'Manufacturer does not exist';

                if (($quantity && !is_numeric($quantity)) || ($discount && !is_numeric($discount)))
                    $error = 'Quantity and discount should be numbers: ' . trim($reference);

                if (!Validate::isLoadedObject(new TaxRulesGroup($tax_rule)))
                    $error = 'Tax rate invalid: ' . trim($reference);

                if (!$update) {
                    $sql = "SELECT `reference`
							FROM " . _DB_PREFIX_ . "product p
							WHERE p.`reference` = '" . $reference . "'";
                    $row = Db::getInstance()->getRow($sql);

                    if (isset($row['reference']))
                        $error = "Duplicate indusdiva code : " . trim($reference);
                }

                //check for souring price
                if ($supplier_price > ($mrp / 1.2))
                    $error = "MRP too low : " . trim($reference);

                //check for images
                if (!$update || $overwrite_imgs == "on")
                    foreach ($images AS $image_name) {
                        $image_name = trim($image_name);
                        $image_path = IMAGE_UPLOAD_PATH . $image_name;
                        if (!empty($image_name) && !file_exists($image_path)) {
                            $error = "Image not found for: " . trim($reference) . ", Image Name: " . $image_name;
                            break;
                        }
                    }

                $vendor_code = substr($reference, 0, 6);
                $sql = "select id_supplier from ps_supplier where code = '{$vendor_code}'";
                $row = Db::getInstance()->getRow($sql);
                if (!isset($row['id_supplier'])) {
                    $error = "Vendor Details not found for : " . trim($reference);
                } else {
                    $id_supplier = $row['id_supplier'];
                }

                //For sudarshan, supplier_code (vendor product code) is mandatory
                if (false) { //(int) $id_supplier === 2 ) {
                    if( empty($supplier_code) ) {
                    	$error = "Reference: $reference -- Supplier Code is Mandatory for Vendor {$vendor_code}";
                    } else if( strpos("::", $$supplier_code) === false ) {
                    	$error = "Reference: $reference -- Supplier Code:$supplier_code is not in DESIGN_NO::ITEM_CODE format for Vendor {$vendor_code}";
                    }
                }

                if (!$error) {
                    if ($update && !empty($id_product)) {
                        $product = new Product((int) $id_product);
                        if (!Validate::isLoadedObject($product)) {
                            $error = "Error loading the product: " . $id_product;
                            return;
                        }
                    } elseif (!$update)
                        $product = new Product();

                    $product->id_tax_rules_group = $tax_rule;
                    $product->reference = $reference;
                    $product->id_supplier = $id_supplier;
                    $product->location = $location;
                    $product->tax_rate = TaxRulesGroup::getTaxesRate((int) $product->id_tax_rules_group, Configuration::get('PS_COUNTRY_DEFAULT'), 0, 0);

                    if (isset($manufacturer) AND is_numeric($manufacturer) AND Manufacturer::manufacturerExists((int) ($manufacturer)))
                        $product->id_manufacturer = $manufacturer;
                    $product->price = (float) ($mrp);
                    $product->price = (float) (number_format($product->price / (1 + $product->tax_rate / 100), 6, '.', ''));
                    $product->id_category = $importCategories;
                    $product->id_category_default = 1;
                    $product->name = array();
                    $product->name[$defaultLanguageId] = $product_name;
                    $product->description_short = array();
                    $product->description_short[$defaultLanguageId] = $style_tips;
                    $product->description = array();
                    $product->description[$defaultLanguageId] = $description;
                    $link_rewrite = Tools::link_rewrite($product->name[$defaultLanguageId]);
                    $product->link_rewrite = array();
                    $product->link_rewrite[$defaultLanguageId] = $link_rewrite;
                    $product->quantity = $quantity ? intval($quantity) : 0;

                    if ($discount && is_numeric($discount))
                        $product->discount = $discount;

                    if (!empty($tags))
                        $product->tags = $tags;

                    $product->weight = is_numeric($weight) ? $weight : 0;
                    $product->width = is_numeric($width) ? $width : 0;
                    $product->height = is_numeric($length) ? $length : 0;
                    $product->supplier_reference = $supplier_code;
                    $product->wholesale_price = $supplier_price ? (float) ($supplier_price) : 0;
                    $product->active = ($active == 1) ? 1 : 0;

                    $product->images = $images;
                    $product->fabric = $fabric;
                    $product->color = $color;
                    $product->generic_color = $generic_color;
                    $product->garment_type = $garment_type;
                    $product->work_type = $work_type;
                    $product->blouse_length = $blouse_length ? $blouse_length : ' ';
                    $product->wash_care = $wash_care ? $wash_care : ' ';
                    $product->other_info = $other_info ? $other_info : ' ';
                    $product->shipping_estimate = $shipping_estimate ? $shipping_estimate : ' ';

                    $product->is_customizable = ($customizable == 1) ? 1 : 0;
                    $product->kameez_style = $kameez_style;
                    $product->salwar_style = $salwar_style;
                    $product->sleeves = $sleeves;
                    $product->skirt_length = $skirt_length;
                    $product->dupatta_length = $dupatta_length;

                    $product->stone = $stone;
                    $product->plating = $plating;
                    $product->material = $material;
                    $product->dimensions = $dimensions;
                    $product->look = $look;
                    $product->as_shown = $as_shown;
                    $product->id_sizechart = $id_sizechart;
                    $product->is_exclusive = $is_exclusive;

                    $product->handbag_occasion = $handbag_occasion;
                    $product->handbag_style = $handbag_style;
                    $product->handbag_material = $handbag_material;
                    $product->indexed = 0;

                    $products_to_import[] = $product;
                }
                else {
                    $smarty->assign('error', $error);
                    return;
                    $file_error = true;
                }
            }

            if (!$file_error) {
                $added_product_ids = array();
                foreach ($products_to_import as $product) {
                    $fieldError = $product->validateFields(UNFRIENDLY_ERROR, true);
                    $langFieldError = $product->validateFieldsLang(UNFRIENDLY_ERROR, true);
                    if ($fieldError === true AND $langFieldError === true) {
                        // check quantity
                        if ($product->quantity == NULL)
                            $product->quantity = 0;

                        // If no id_product or update failed
                        if ($update && $product->id)
                            $res = $product->update();
                        else
                            $res = $product->add();
                        $added_product_ids[] = $product->id;
                    }

                    if (isset($product->discount) && $product->discount > 0) {
                        SpecificPrice::deleteByProductId((int) ($product->id));

                        $specificPrice = new SpecificPrice();
                        $specificPrice->id_product = (int) ($product->id);
                        $specificPrice->id_shop = (int) (Shop::getCurrentShop());
                        $specificPrice->id_currency = 0;
                        $specificPrice->id_country = 0;
                        $specificPrice->id_group = 0;
                        $specificPrice->from_quantity = 1;
                        $specificPrice->reduction = $product->discount / 100;
                        $specificPrice->reduction_type = 'percentage';
                        $specificPrice->from = '2012-01-01 00:00:00';
                        $specificPrice->to = '2016-01-01 00:00:00';
                        $specificPrice->price = $product->price;
                        $specificPrice->add();
                    }

                    if (isset($product->tags) AND !empty($product->tags)) {
                        // Delete tags for this id product, for no duplicating error
                        Tag::deleteTagsForProduct($product->id);

                        $tag = new Tag();
                        $tag->addTags($defaultLanguageId, $product->id, $tags);
                    }

                    if (isset($product->images) AND is_array($product->images) AND sizeof($product->images) AND (!$update || $overwrite_imgs == "on")) {
                        $product->deleteImages();
                        $first_image = true;
                        foreach ($product->images AS $image_name) {
                            $image_name = trim($image_name);
                            $image_path = IMAGE_UPLOAD_PATH . $image_name;
                            if (!empty($image_name)) {
                                $image = new Image();
                                $image->id_product = (int) ($product->id);
                                $image->position = Image::getHighestPosition($product->id) + 1;
                                $image->cover = $first_image;
                                $image->legend[$defaultLanguageId] = $product->name[$defaultLanguageId];
                                if (($fieldError = $image->validateFields(false, true)) === true AND ($langFieldError = $image->validateFieldsLang(false, true)) === true AND $image->add()) {
                                    if (!self::copyImg($product->id, $image->id, $image_path))
                                        $_warnings[] = Tools::displayError('Error copying image: ') . $image_path;
                                    else {
                                        //delete the original image
                                        @unlink($image_path);
                                    }
                                }
                                else {
                                    $_warnings[] = $image->legend[$defaultLanguageId] . (isset($image->id_product) ? ' (' . $image->id_product . ')' : '') . ' ' . Tools::displayError('Cannot be saved');
                                    $_errors[] = ($fieldError !== true ? $fieldError : '') . ($langFieldError !== true ? $langFieldError : '') . mysql_error();
                                }
                            }
                            $first_image = false;
                        }
                    }

                    if (isset($product->id_category))
                        $product->updateCategories(array_map('intval', $product->id_category));

                    $this->addFeature($product->id, 'fabric', $product->fabric);
                    $this->addFeature($product->id, 'color', $product->color);
                    $this->addFeature($product->id, 'garment_type', $product->garment_type);
                    $this->addFeature($product->id, 'work_type', $product->work_type);
                    $this->addFeature($product->id, 'blouse_length', $product->blouse_length);
                    $this->addFeature($product->id, 'wash_care', $product->wash_care);
                    $this->addFeature($product->id, 'other_info', $product->other_info);
                    // to avoid type errors in the catalog sheet - construct the string here again
                    $shipping_sla = (int) preg_replace('/\D/', '', $product->shipping_estimate);
                    $shipping_estimate_str = "";
                    if( $shipping_sla > 0 ) {
                        $shipping_estimate_str = ($shipping_sla ===1)? "Ready to be shipped in 1 day" : "Ready to be shipped in $shipping_sla days";
                    }
                    $this->addFeature($product->id, 'shipping_estimate', $shipping_estimate_str);

                    $this->addFeature($product->id, 'kameez_style', $product->kameez_style);
                    $this->addFeature($product->id, 'salwar_style', $product->salwar_style);
                    $this->addFeature($product->id, 'sleeves', $product->sleeves);
                    $this->addFeature($product->id, 'generic_color', $product->generic_color);

                    $this->addFeature($product->id, 'skirt_length', $product->skirt_length);
                    $this->addFeature($product->id, 'dupatta_length', $product->dupatta_length);

                    $this->addFeature($product->id, 'stone', $product->stone);
                    $this->addFeature($product->id, 'plating', $product->plating);
                    $this->addFeature($product->id, 'material', $product->material);
                    $this->addFeature($product->id, 'dimensions', $product->dimensions);
                    $this->addFeature($product->id, 'look', $product->look);
                    
                    $this->addFeature($product->id, 'handbag_occasion', $product->handbag_occasion);
                    $this->addFeature($product->id, 'handbag_style', $product->handbag_style);
                    $this->addFeature($product->id, 'handbag_material', $product->handbag_material);
                }

                $smarty->assign("products_affected", $products_to_import);

                //reindex the products
                SolrSearch::updateProducts($added_product_ids);

                $smarty->assign("is_update", $update);
            }
            else
                $smarty->assign('file_error', 1);
        }
        else {
            $smarty->assign('error_reading', 1);
        }
    }

    public function addFeature($id_product, $feature_name, $feature_value) {
        if (empty($feature_value))
            return;
        $id_feature = Feature::addFeatureImport($feature_name);
        $id_feature_value = FeatureValue::addFeatureValueImport($id_feature, $feature_value);
        Product::addFeatureProductImport($id_product, $id_feature, $id_feature_value);
    }

    public function handleUpload($update = false) {
        global $currentIndex, $cookie, $smarty;

        //Get the uploaded file
        // Where the file is going to be placed
        $target_path = _PS_ADMIN_DIR_ . "/product-uploads/";

        /* Add the original filename to our target path.
          Result is "uploads/filename.extension" */
        $target_path = $target_path . basename($_FILES['products_file']['name']) . $_SERVER['REQUEST_TIME'];

        if (move_uploaded_file($_FILES['products_file']['tmp_name'], $target_path)) {
            $f = fopen($target_path, 'r');
            if ($f) {
                $count = 0;

                //discard the header
                $line = fgetcsv($f);

                $line = fgetcsv($f);

                $id_product = $line[0];

                if (!empty($id_product) && !$update) {
                    $smarty->assign('non_empty_product_id', 1);
                    return;
                }

                $images = $line[1];
                $product_name = $line[2];
                $fabric = $line[3];
                $color = $line[4];
                $mrp = $line[5];
                $supplier_code = $line[6];
                $reference = $line[7];
                $location = $line[8];
                $length = $line[9];
                $width = $line[10];
                $blouse_length = $line[11];
                $garment_type = $line[12];
                $work_type = $line[13];
                $weight = $line[14];
                $description = $line[15];
                //$style_tips = $line[15];
                $other_info = $line[16];
                $wash_care = $line[17];
                $shipping_estimate = $line[18];
                $supplier_price = $line[19];
                $manufacturer = $line[20];
                $categories = $line[21];
                $tax_rule = $line[22];
                $quantity = $line[23];
                $active = $line[24];
                $discount = $line[25];
                $tags = $line[26];
                $kameez_style = $line[27];
                $salwar_style = $line[28];
                $sleeves = $line[29];
                $customizable = $line[30];
                $generic_color = $line[31];
                $skirt_length = $line[32];
                $dupatta_length = $line[33];

                $stone = $line[34];
                $plating = $line[35];
                $material = $line[36];
                $dimensions = $line[37];
                $look = $line[38];
                $as_shown = (isset($line[39]) && !empty($line[39])) ? intval($line[39]) : 0;
                $id_sizechart = (isset($line[40]) && !empty($line[40])) ? intval($line[40]) : 0;
                $is_exclusive = (isset($line[41]) && !empty($line[41])) ? intval($line[41]) : 0;
                
                $handbag_occasion = (isset($line[42]) && !empty($line[42])) ? $line[42] : null;
                $handbag_style = (isset($line[43]) && !empty($line[43])) ? $line[43] : null;
                $handbag_material = (isset($line[44]) && !empty($line[44])) ? $line[44] : null;

                $smarty->assign('current_file', $target_path);
                $smarty->assign('product_name', $product_name);
                if ($update)
                    $smarty->assign('update', 1);
                $smarty->assign(array('images' => $images,
                    'product_name' => $product_name,
                    'fabric' => $fabric,
                    'color' => $color,
                    'mrp' => $mrp,
                    'supplier_code' => $supplier_code,
                    'size' => $size,
                    'length' => $length,
                    'width' => $width,
                    'blouse_length' => $blouse_length,
                    'garment_type' => $garment_type,
                    'work_type' => $work_type,
                    'weight' => $weight,
                    'description' => $description,
                    'style_tips' => $style_tips,
                    'other_info' => $other_info,
                    'wash_care' => $wash_care,
                    'shipping_estimate' => $shipping_estimate,
                    'supplier_price' => $supplier_price,
                    'manufacturer' => $manufacturer,
                    'categories' => $categories,
                    'tax_rule' => $tax_rule,
                    'quantity' => $quantity,
                    'active' => $active,
                    'discount' => $discount,
                    'tags' => $tags,
                    'kameez_style' => $kameez_style,
                    'salwar_style' => $salwar_style,
                    'sleeves' => $sleeves,
                    'customizable' => $customizable,
                    'generic_color' => $generic_color,
                    'skirt_length' => $skirt_length,
                    'dupatta_length' => $dupatta_length,
                    'stone' => $stone,
                    'plating' => $plating,
                    'material' => $material,
                    'dimensions' => $dimensions,
                    'look' => $look,
                    'as_shown' => $as_shown,
                    'id_sizechart' => $id_sizechart,
                    'is_exclusive' => $is_exclusive,
                    'handbag_occasion' => $handbag_occasion,
                    'handbag_style' => $handbag_style,
                    'handbag_material' => $handbag_material,
                ));

                fclose($f);
            }
            else {
                $smarty->assign('error_reading', 1);
            }
        } else {
            $smarty->assign('error_uploading', 1);
        }
    }

    public function display() {
        global $smarty;
        $smarty->display(_PS_THEME_DIR_ . 'admin/product_import.tpl');
    }

    private static function copyImg($id_entity, $id_image = NULL, $url, $entity = 'products') {
        $tmpfile = tempnam(_PS_TMP_IMG_DIR_, 'ps_import');

        $imageObj = new Image($id_image);
        $imageObj->createImgFolder();
        $path = _PS_PROD_IMG_DIR_ . $imageObj->getImgPath();

        if (copy(trim($url), $tmpfile)) {
            imageResize($tmpfile, $path . '.jpg');
            $imagesTypes = ImageType::getImagesTypes($entity);
            foreach ($imagesTypes AS $k => $imageType)
                imageResize($tmpfile, $path . '-' . stripslashes($imageType['name']) . '.jpg', $imageType['width'], $imageType['height']);
        } else {
            unlink($tmpfile);
            return false;
        }
        unlink($tmpfile);
        return true;
    }

}

