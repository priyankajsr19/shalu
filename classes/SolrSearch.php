<?php

class SolrSearch {

    private static $resultCache;

    /**
     * @return Solarium_Client
     */
    public static function getClient() {
        $config = array(
            'adapteroptions' => array(
                'host' => SOLR_SERVER,
                'port' => 8080,
                'path' => '/solr/',
            )
        );

        // create a client instance
        $client = new Solarium_Client($config);

        return $client;
    }

    private static function setSort($query, $express_shipping = false) {
        $orderby = Tools::getValue('orderby');
        $orderway = Tools::getValue('orderway');

        $query->addSort('inStock', Solarium_Query_Select::SORT_DESC);
        if ($orderby && $orderway) {
            $way = Solarium_Query_Select::SORT_DESC;
            if ($orderby == 'price') {
                $orderby = 'offer_price';
                if ($orderway == 'asc')
                    $way = Solarium_Query_Select::SORT_ASC;
                else
                    $way = Solarium_Query_Select::SORT_DESC;
            }
            elseif ($orderby == 'discount')
                $orderby = 'discount';
            elseif ($orderby == 'hot')
                $orderby = 'sales';
            elseif ($orderby == 'new')
                $orderby = 'date_add';

            if( $express_shipping )
                $query->addSort('shipping_sla', Solarium_Query_Select::SORT_ASC);
            $query->addSort($orderby, $way);
            /*if ($orderby != 'hot') {
                $query->addSort('sales', Solarium_Query_Select::SORT_DESC);
                $query->addSort('date_add', Solarium_Query_Select::SORT_DESC);
            }*/
        } else {
            if( $express_shipping )
                $query->addSort('shipping_sla', Solarium_Query_Select::SORT_ASC);
            else {
                /*$query->addSort('sales', Solarium_Query_Select::SORT_DESC);*/
                $query->addSort('date_add', Solarium_Query_Select::SORT_DESC);
            }
        }
    }

    /**
     * @param int $id_category
     * @param int $p
     * @param int $n
     * @return array
     */
    public static function getCategoryProducts($id_category, $brand_id = false, &$total_found, $p = 1, $n = 0) {
        if ($n == 0)
            $n = (int) Tools::getValue('n', Configuration::get('PS_PRODUCTS_PER_PAGE'));
        $client = self::getClient();

        $products = array();

        // get a select query instance
        $query = $client->createSelect();
        $query->setQuery('cat_id:' . $id_category);

        if ($brand_id)
            $manFilter = $query->createFilterQuery('man')->setQuery('+brand_id:' . $brand_id);

        // override the default row limit of 10 by setting rows to $n
        $query->setRows($n);
        $start = ($p - 1) * $n;
        $query->setStart($start);

        self::setSort($query);

        // this executes the query with default settings and returns the result
        $results = $client->select($query);

        $total_found = $results->getNumFound();

        $products = $results->getData();
        $products = $products['response']['docs'];

        self::cacheResult($query, $results);

        return $products;
    }

    public static function getNewProducts(&$total_found, $p = 1, $n = 0) {
        if ($n == 0)
            $n = (int) Tools::getValue('n', Configuration::get('PS_PRODUCTS_PER_PAGE'));

        $client = self::getClient();

        $products = array();

        // get a select query instance
        $query = $client->createSelect();
        $query->setQuery('date_add:[NOW/DAY-1MONTH/DAY TO *]');

        // override the default row limit of 10 by setting rows to $n
        $query->setRows($n);
        $start = ($p - 1) * $n;
        $query->setStart($start);
        self::setSort($query);

        // this executes the query with default settings and returns the result
        $results = $client->select($query);

        $total_found = $results->getNumFound();

        $products = $results->getData();
        $products = $products['response']['docs'];

        self::cacheResult($query, $results);

        return $products;
    }

    public static function getSaleProducts(&$total_found, $p = 1, $n = 0) {
        if ($n == 0)
            $n = (int) Tools::getValue('n', Configuration::get('PS_PRODUCTS_PER_PAGE'));

        $client = self::getClient();

        $products = array();

        // get a select query instance
        $query = $client->createSelect();
        $query->setQuery('discount:[1 TO *]');

        // override the default row limit of 10 by setting rows to $n
        $query->setRows($n);
        $start = ($p - 1) * $n;
        $query->setStart($start);
        self::setSort($query);

        // this executes the query with default settings and returns the result
        $results = $client->select($query);

        $total_found = $results->getNumFound();

        $products = $results->getData();
        $products = $products['response']['docs'];

        self::cacheResult($query, $results);

        return $products;
    }

    public static function getProductsForIDs($productsIDs, &$total_found, $p = 1, $n = 5) {
        $client = self::getClient();

        $products = array();

        // get a select query instance
        $query = $client->createSelect();
        $idQuery = '+id_product:(';
        $idSelected = array();

        $idQuery .= implode(" OR ", $productsIDs);

        $query->setQuery($idQuery . ")");

        // override the default row limit of 10 by setting rows to $n
        $query->setRows($n);
        $start = ($p - 1) * $n;
        $query->setStart($start);
        $query->addSort('inStock', Solarium_Query_Select::SORT_DESC);

        // this executes the query with default settings and returns the result
        $results = $client->select($query);

        $total_found = $results->getNumFound();

        $products = $results->getData();
        $products = $products['response']['docs'];

        self::cacheResult($query, $results);

        return $products;
    }

    public static function getBrandProducts($id_manufacturer, &$total_found, $p = 1, $n = 0) {
        if ($n == 0)
            $n = (int) Tools::getValue('n', Configuration::get('PS_PRODUCTS_PER_PAGE'));
        $client = self::getClient();

        $products = array();

        // get a select query instance
        $query = $client->createSelect();
        $query->setQuery('brand_id:' . $id_manufacturer);

	$id_categories = Tools::getValue('cat_id');
	if( !empty($id_categories) ) {
		$id_categories = explode("-",$id_categories);
		if( is_array($id_categories) ) {
			$id_categories = implode(" OR ",$id_categories);
			$query->createFilterQuery("des_cat")->setQuery("cat_id: ($id_categories)");
		}
	}
        // override the default row limit of 10 by setting rows to $n
        $query->setRows($n);
        $start = ($p - 1) * $n;
        $query->setStart($start);
        self::setSort($query);

        // this executes the query with default settings and returns the result
        $results = $client->select($query);

        $total_found = $results->getNumFound();

        $products = $results->getData();
        $products = $products['response']['docs'];

        self::cacheResult($query, $results);

        return $products;
    }

    /**
     * @param Solarium_Query_Select $query
     * @param Solarium_Result_Select $resultset
     */
    public static function cacheResult($query, $resultset) {
        if (!self::$resultCache)
            self::$resultCache = array();

        $cacheKey = self::getKey($query);

        self::$resultCache[$cacheKey] = $resultset;
    }

    /**
     * @param Solarium_Query_Select query
     */
    private static function getKey($query) {
        $filter_queries = $query->getFilterQueries();

        $query_strings = array();
        $query_strings[] = $query->getQuery();

        foreach ($filter_queries as $filter_query)
            $query_strings[] = $filter_query->getQuery();

        asort($query_strings);

        $cacheKey = implode("|", $query_strings);

        return $cacheKey;
    }

    /**
     * @param Solarium_Query_Select $query
     * @return multitype:Solarium_Result_Select|boolean
     */
    public static function getFromCache($query) {
        $key = self::getKey($query);
        if (isset(self::$resultCache[$key]))
            return self::$resultCache[$key];
        else
            return false;
    }

    /**
     * @param int $id_product
     */
    public static function updateProduct($id_product) {
        $default_tz = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $client = self::getClient();
        $update = $client->createUpdate();
        $link = new Link();

        $productObj = new Product($id_product, true, 1, false);

        if (!$productObj || !$productObj->id || !$productObj->active) {
            self::deleteProduct($id_product);
            return;
        }

        $doc = self::getProductDoc($update, $link, $productObj);

        $update->addDocument($doc);
        date_default_timezone_set($default_tz);

        $result = $client->update($update);
    }

    /**
     * @param int $id_product
     */
    public static function deleteProduct($id_product) {
        $client = self::getClient();
        // get an update query instance
        $update = $client->createUpdate();

        // add the delete query and a commit command to the update query
        $update->addDeleteById($id_product);

        // this executes the query and returns the result
        $result = $client->update($update);
    }

    /**
     * @param array $product_ids
     */
    public static function updateProducts($product_ids) {
        $default_tz = date_default_timezone_get();
        date_default_timezone_set('UTC');

        $client = self::getClient();
        $update = $client->createUpdate();

        $docs = array();
        $link = new Link();
        $count = 0;

        foreach ($product_ids as $id_product) {
            $productObj = new Product($id_product, true, 1, false);

            if (!$productObj || !$productObj->id || !$productObj->active) {
                self::deleteProduct($id_product);
                continue;
            }

            $doc = self::getProductDoc($update, $link, $productObj);

            $docs[] = $doc;

            //Add update every 300 products
            if (++$count == 300) {
                $update->addDocuments($docs);

                $result = $client->update($update);

                $count = 0;
                $docs = array();
                $update = $client->createUpdate();
            }
        }

        //add remaining products
        $update->addDocuments($docs);
        date_default_timezone_set($default_tz);

        $result = $client->update($update);
    }

    /**
     * @param Solarium_Query_Update $update
     * @param Link $link
     * @param Product $productObj
     * @return Solarium_Document_ReadWrite
     */
    private static function getProductDoc($update, $link, $productObj) {

        $doc = $update->createDocument();
        $doc->id_product = $productObj->id;
        $doc->reference = $productObj->reference;
        $doc->name = $productObj->name;
        //$doc->description = $productObj->description;
        $doc->description = preg_replace('@[\x00-\x08\x0B\x0C\x0E-\x1F]@', ' ', $productObj->description);
        $doc->description_short = preg_replace('@[\x00-\x08\x0B\x0C\x0E-\x1F]@', ' ', $productObj->description_short);
        $doc->brand_id = $productObj->id_manufacturer;
        $doc->brand_name = $productObj->manufacturer_name;
        $doc->style_tips = preg_replace('@[\x00-\x08\x0B\x0C\x0E-\x1F]@', ' ', $productObj->description_short);
        $doc->alphaNameSort = $productObj->name;
        $dbresult = $productObj->getWsCategories();
        $catIds = array();
        foreach ($dbresult as $catIdRow)
            $catIds[] = $catIdRow['id'];
        $category_names = array();

        foreach ($catIds as $catID) {
            $category = new Category((int) $catID);
            $category_names[] = $category->getName(1);
        }

        $doc->cat_name = $category_names;
        $doc->cat_id = $catIds;
        $doc->tags = $productObj->getTags(1);
        $doc->shipping_sla = $productObj->shipping_sla;
        $doc->weight = $productObj->weight ? $productObj->weight : 0.5;
	$doc->cashback_percentage = $productObj->cashback_percentage;

        if (isset($productObj->work_type))
            $doc->work_type = preg_replace('@[\x00-\x08\x0B\x0C\x0E-\x1F]@', ' ', ($productObj->work_type ? $productObj->work_type : ''));

        if (isset($productObj->garment_type))
            $doc->garment_type = preg_replace('@[\x00-\x08\x0B\x0C\x0E-\x1F]@', ' ', ($productObj->garment_type ? $productObj->garment_type : ''));

        if (isset($productObj->blouse_length))
            $doc->blouse_length = $productObj->blouse_length ? $productObj->blouse_length : '';
        $doc->height = $productObj->height;
        $doc->width = $productObj->width;

        $atributeQty = Attribute::getAttributeQty($productObj->id);
        if (($productObj->quantity > 0) || ($atributeQty > 0))
            $doc->inStock = true;
        else
            $doc->inStock = false;
        $doc->isPlusSize = ($productObj->is_plussize)?true:false;
        $doc->isRTS = ($productObj->is_rts)?true:false;

        $doc->quantity = $productObj->quantity ? $productObj->quantity : ($atributeQty ? $atributeQty : 0);

        $date = DateTime::createFromFormat('Y-m-d H:i:s', $productObj->date_add);
        $doc->date_add = $date->format("Y-m-d\TG:i:s\Z");

        $productObj->fabric = trim($productObj->fabric);
        $productObj->fabric = preg_replace('/\s+/', '-', $productObj->fabric);
        $doc->fabric = strtolower($productObj->fabric);

        $doc->is_customizable = $productObj->is_customizable;

        if (isset($productObj->generic_color) && !empty($productObj->generic_color)) {
            $colors = explode(',', $productObj->generic_color);

            $indexed_colors = array();
            foreach ($colors as $color) {
                $indexed_colors[] = strtolower(preg_replace('/\s+/', '-', trim($color)));
            }

            $doc->color = $indexed_colors;
        }

        if (isset($productObj->stone) && !empty($productObj->stone)) {
            $stones = explode(',', $productObj->stone);

            $indexed_stones = array();
            foreach ($stones as $stone) {
                $indexed_stones[] = strtolower(preg_replace('/\s+/', '-', trim($stone)));
            }

            $doc->stone = $indexed_stones;
        }

        if (isset($productObj->plating) && !empty($productObj->plating)) {
            $platings = explode(',', $productObj->plating);

            $indexed_platings = array();
            foreach ($platings as $plating) {
                $indexed_platings[] = strtolower(preg_replace('/\s+/', '-', trim($plating)));
            }

            $doc->plating = $indexed_platings;
        }

        if (isset($productObj->material) && !empty($productObj->material)) {
            $materials = explode(',', $productObj->material);

            $indexed_materials = array();
            foreach ($materials as $material) {
                $indexed_materials[] = strtolower(preg_replace('/\s+/', '-', trim($material)));
            }

            $doc->material = $indexed_materials;
        }

        if (isset($productObj->look) && !empty($productObj->look)) {
            $looks = explode(',', $productObj->look);

            $indexed_looks = array();
            foreach ($looks as $look) {
                $indexed_looks[] = strtolower(preg_replace('/\s+/', '-', trim($look)));
            }

            $doc->look = $indexed_looks;
        }
        
        if(isset($productObj->handbag_occasion) && !empty($productObj->handbag_occasion)) {
            $handbag_occasions = explode(',', $productObj->handbag_occasion);
            $indexed_handbag_occasions = array();
			foreach($handbag_occasions as $handbag_occasion) {
                $indexed_handbag_occasions[] = strtolower(preg_replace('/\s+/', '-',trim($handbag_occasion)));
            }
			$doc->handbag_occasion = $indexed_handbag_occasions;
        }
		
		if(isset($productObj->handbag_style) && !empty($productObj->handbag_style)) {
            $handbag_styles = explode(',', $productObj->handbag_style);
            $indexed_handbag_styles = array();
			foreach($handbag_styles as $handbag_style) {
                $indexed_handbag_styles[] = strtolower(preg_replace('/\s+/', '-',trim($handbag_style)));
            }
			$doc->handbag_style = $indexed_handbag_styles;
        }
		
		if(isset($productObj->handbag_material) && !empty($productObj->handbag_material)) {
            $handbag_materials = explode(',', $productObj->handbag_material);
            $indexed_handbag_materials = array();
			foreach($handbag_materials as $handbag_material) {
                $indexed_handbag_materials[] = strtolower(preg_replace('/\s+/', '-',trim($handbag_material)));
            }
			$doc->handbag_material = $indexed_handbag_materials;
        }
		
        $combinaisons = $productObj->getAttributeCombinaisons(1);
        $indexed_sizes = array();
        foreach ($combinaisons AS $k => $combinaison) {
            if ($combinaison['group_name'] == 'size' || $combinaison['group_name'] == 'Size')
                $indexed_sizes[] = $combinaison['attribute_name'];
        }
        $doc->size = $indexed_sizes;

        //Indian Price
        $doc->offer_price_in = Product::getPriceStatic($productObj->id, true, NULL, 6, NULL, false, true, 1, false, NULL, NULL, IND_ADDRESS_ID);
        $doc->offer_price_in_rs = Tools::convertPrice($doc->offer_price_in, 4);

        $doc->mrp_in = Product::getPriceStatic($productObj->id, true, NULL, 6, NULL, false, false, 1, false, NULL, NULL, IND_ADDRESS_ID);
        if ($doc->mrp_in > $doc->offer_price_in) {
            $doc->discount_in = Tools::ps_round((($doc->mrp_in - $doc->offer_price_in) / $doc->mrp_in) * 100);
        }

        //Worldwide Price
        $doc->offer_price = $productObj->getPrice();
        $doc->offer_price_rs = Tools::convertPrice($doc->offer_price, 4);
        $doc->mrp = $productObj->getPriceWithoutReduct();
        if ($doc->mrp > $doc->offer_price) {
            $doc->discount = Tools::ps_round((($doc->mrp - $doc->offer_price) / $doc->mrp) * 100);
        }

        $doc->product_link = $productObj->getLink();
        $idImage = $productObj->getCoverWs();
        if ($idImage)
            $idImage = $productObj->id . '-' . $idImage;
        else
            $idImage = Language::getIsoById(1) . '-default';

        $doc->image_link_list = $link->getImageLink($productObj->link_rewrite, $idImage, 'list');
        $doc->image_link_medium = $link->getImageLink($productObj->link_rewrite, $idImage, 'medium');
        $doc->image_link_large = $link->getImageLink($productObj->link_rewrite, $idImage, 'large');
        
        $images = $productObj->getImages(1);
        $productImages = array();
        foreach ($images AS $k => $image)
        {
        	$productImages[] = $link->getImageLink($productObj->link_rewrite,$image['id_image'], 'large');
        }
        $doc->image_links = $productImages;

        return $doc;
    }

    public static function index() {
        $db = Db::getInstance();
        $products = $db->ExecuteS('SELECT id_product FROM ' . _DB_PREFIX_ . 'product WHERE indexed = 0');

        if (count($products) < 1)
            return;
        $product_ids = array();

        foreach ($products as $row) {
            $product_ids[] = $row['id_product'];
        }

        self::updateProducts($product_ids);
    }

    public static function getExpressShippingProducts(&$total_found, $p = 1, $n = 0) {
        if ($n == 0)
            $n = (int) Tools::getValue('n', Configuration::get('PS_PRODUCTS_PER_PAGE'));

        $client = self::getClient();


        // get a select query instance
        $query = $client->createSelect();
        $query->setQuery('shipping_sla:[1 TO 2]');

        // override the default row limit of 10 by setting rows to $n
        $query->setRows($n);
        $start = ($p - 1) * $n;
        $query->setStart($start);
        self::setSort($query, true);
        // this executes the query with default settings and returns the result
        $results = $client->select($query);

        $total_found = $results->getNumFound();

        $productsData = $results->getData();
        $products = $productsData['response']['docs'];

        self::cacheResult($query, $results);

        return $products;
    }

}

?>
