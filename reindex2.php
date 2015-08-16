<?php

include(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');


ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');
$config = array(
        'adapteroptions' => array(
                'host' => SOLR_SERVER,
                'port' => 8080,
                'path' => '/solr/',
        )
);

// create a client instance
$client = new Solarium_Client($config);


function addProducts($client, $ids = array())
{ 
    //update currency
    //update_currency();


    $default_tz = date_default_timezone_get();
    date_default_timezone_set('UTC');
    $category = new Category(1, 1);
    $sql = "select p.id_product, DATEDIFF(NOW(), p.`date_add`) as 'age'
            from ps_product p
            where p.price > 0 and p.active = 1";

    $productScores = array();
    $products = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);

    foreach($products as $product)
        $productScores[$product['id_product']] = array('age' => $product['age'], 'week_sold' => 0, 'month_sales' => 0, 'year_sales' => 0);

    $sql = "select p.`id_product`, sum(od.product_quantity) as 'quantity'
            from `ps_product` p
            inner join `ps_order_detail` od on od.product_id = p.id_product
            inner join ps_orders o on o.id_order = od.id_order
            where p.price > 0 
            and p.active = 1
            and o.date_add > now() - INTERVAL 7 DAY
            group by p.id_product";
    $week_quantities = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);
    foreach($week_quantities as $week_quantity)
         $productScores[$week_quantity['id_product']]['week_sold'] = $week_quantity['quantity'];

    $sql = "select p.`id_product`, round(sum(od.product_quantity * od.product_price * 55 / o.`conversion_rate`)) as 'month_revenue'
            from `ps_product` p
            inner join `ps_order_detail` od on od.product_id = p.id_product
            inner join ps_orders o on o.id_order = od.id_order
            where p.price > 0 and p.active = 1
            and o.date_add > now() - INTERVAL 30 DAY
            group by p.id_product";
    $month_sales = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);
    foreach($month_sales as $month_sale)
        $productScores[$month_sale['id_product']]['month_sales'] = $month_sale['month_revenue'];

    $sql = "select p.`id_product`, round(sum(od.product_quantity * od.product_price * 55 / o.`conversion_rate`)) as 'year_revenue'
            from `ps_product` p
            inner join `ps_order_detail` od on od.product_id = p.id_product
            inner join ps_orders o on o.id_order = od.id_order
            where p.price > 0 and p.active = 1
            and o.date_add > now() - INTERVAL 365 DAY
            group by p.id_product";
    $year_sales = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);
    foreach($year_sales as $year_sale)
        $productScores[$year_sale['id_product']]['year_sales'] = $year_sale['year_revenue'];

    foreach($products as $product)
    {
        $productScores[$product['id_product']]['score'] = getWeekSalesScore($productScores[$product['id_product']]['week_sold']) + getAgeScore($productScores[$product['id_product']]['age']) +  getMonthScore($productScores[$product['id_product']]['month_sales']) + getYearScore($productScores[$product['id_product']]['year_sales']);
    }

    $docs = array();
    $link = new Link();
    $count = 0;
    $update = $client->createUpdate();
    foreach($products as $product)
    {
	if(!empty($ids) && !in_array((int)$product['id_product'], $ids))
            continue;

        $productObj = new Product((int)$product['id_product'], true, 1);
        
        if(!$productObj->active)
        {
            deleteProduct($productObj->id, $client);
            continue;
        }
        
        $doc = $update->createDocument();
        $doc->id_product = $productObj->id;
        $doc->reference = $productObj->reference;
        $doc->name = $productObj->name;
        $doc->description = preg_replace('@[\x00-\x08\x0B\x0C\x0E-\x1F]@', ' ', $productObj->description);
        $doc->description_short = preg_replace('@[\x00-\x08\x0B\x0C\x0E-\x1F]@', ' ', $productObj->description_short);
        $doc->brand_id = $productObj->id_manufacturer;
        $doc->brand_name = $productObj->manufacturer_name;
        $doc->style_tips = $productObj->description_short;
        $doc->alphaNameSort = $productObj->name;
        $dbresult = $productObj->getWsCategories();
        $catIds = array();
        foreach($dbresult as $catIdRow)
            $catIds[] = $catIdRow['id'];
        $category_names = array();

        foreach($catIds as $catID)
        {
            $category = new Category((int)$catID);
            $category_names[] = $category->getName(1);
        }

        $doc->cat_name = $category_names;
        $doc->cat_id = $catIds;
        $doc->tags = $productObj->getTags(1);
        $doc->shipping_sla = $productObj->shipping_sla ? $productObj->shipping_sla : 0;
        $doc->weight = $productObj->weight ? $productObj->weight : 0.5;
        
        if(isset($productObj->work_type))
            $doc->work_type = preg_replace('@[\x00-\x08\x0B\x0C\x0E-\x1F]@', ' ', ($productObj->work_type ? $productObj->work_type : ''));
        
        if(isset($productObj->garment_type))
            $doc->garment_type = preg_replace('@[\x00-\x08\x0B\x0C\x0E-\x1F]@', ' ', ($productObj->garment_type ? $productObj->garment_type : ''));
        
        if(isset($productObj->blouse_length))
            $doc->blouse_length = $productObj->blouse_length ? $productObj->blouse_length : '';
        $doc->height = $productObj->height;
        $doc->width = $productObj->width;
        
        $atributeQty = Attribute::getAttributeQty($productObj->id);
        if(($productObj->quantity > 0) || ($atributeQty > 0))
            $doc->inStock = true;
        else
            $doc->inStock = false;

        $doc->isPlusSize = ($productObj->is_plussize)?true:false;
        $doc->isRTS = ($productObj->is_rts)?true:false;

        $doc->quantity = $productObj->quantity ? $productObj->quantity : ($atributeQty ? $atributeQty : 0);
        
        //Indian Price
        $doc->offer_price_in = Product::getPriceStatic($productObj->id, true, NULL, 6, NULL, false, true, 1, false, NULL, NULL, IND_ADDRESS_ID);
        $doc->offer_price_in_rs = Tools::convertPrice($doc->offer_price_in, 4);
        
        $doc->mrp_in = Product::getPriceStatic($productObj->id, true, NULL, 6, NULL, false, false, 1, false, NULL, NULL, IND_ADDRESS_ID);
        if($doc->mrp_in > $doc->offer_price_in)
        {
            $doc->discount_in = Tools::ps_round((($doc->mrp_in - $doc->offer_price_in)/$doc->mrp_in)*100);
        }
        
        //Worldwide Price
        $doc->offer_price = $productObj->getPrice();
        $doc->offer_price_rs = Tools::convertPrice($doc->offer_price, 4);
        $doc->mrp = $productObj->getPriceWithoutReduct();
        if($doc->mrp > $doc->offer_price)
        {
            $doc->discount = Tools::ps_round((($doc->mrp - $doc->offer_price)/$doc->mrp)*100);
        }
        
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $productObj->date_add);
        $doc->date_add = $date->format("Y-m-d\TG:i:s\Z");

        $doc->product_link = $productObj->getLink();
        $idImage = $productObj->getCoverWs();
        if($idImage)
            $idImage = $productObj->id.'-'.$idImage;
        else
            $idImage = Language::getIsoById(1).'-default';

        $doc->image_link_list = $link->getImageLink($productObj->link_rewrite,$idImage, 'list');
        $doc->image_link_medium = $link->getImageLink($productObj->link_rewrite,$idImage, 'medium');
        $doc->image_link_large = $link->getImageLink($productObj->link_rewrite,$idImage, 'large');
        
        $images = $productObj->getImages(1);
        $productImages = array();
        foreach ($images AS $k => $image)
        {
            $productImages[] = $link->getImageLink($productObj->link_rewrite,$image['id_image'], 'large');
        }
        $doc->image_links = $productImages;

        $doc->sales = $productScores[$product['id_product']]['score'];
        
        $productObj->fabric = trim($productObj->fabric);
        $productObj->fabric = preg_replace('/\s+/', '-',$productObj->fabric);
        $doc->fabric = strtolower($productObj->fabric);
        
        $doc->is_customizable = $productObj->is_customizable;
        
        if(isset($productObj->generic_color) && !empty($productObj->generic_color))
        {
            $colors = explode(',', $productObj->generic_color);
        
            $indexed_colors = array();
            foreach($colors as $color)
            {
                $indexed_colors[] = strtolower(preg_replace('/\s+/', '-',trim($color)));
            }
            
            $doc->color = $indexed_colors;
        }
        
        if(isset($productObj->stone) && !empty($productObj->stone))
        {
            $stones = explode(',', $productObj->stone);
        
            $indexed_stones = array();
            foreach($stones as $stone)
            {
                $indexed_stones[] = strtolower(preg_replace('/\s+/', '-',trim($stone)));
            }
                
            $doc->stone = $indexed_stones;
        }
        
        if(isset($productObj->plating) && !empty($productObj->plating)) {
            $platings = explode(',', $productObj->plating);
            $indexed_platings = array();
            foreach($platings as $plating) {
                $indexed_platings[] = strtolower(preg_replace('/\s+/', '-',trim($plating)));
            }
            $doc->plating = $indexed_platings;
        }
        
        if(isset($productObj->material) && !empty($productObj->material))
        {
            $materials = explode(',', $productObj->material);
        
            $indexed_materials = array();
            foreach($materials as $material)
            {
                $indexed_materials[] = strtolower(preg_replace('/\s+/', '-',trim($material)));
            }
                
            $doc->material = $indexed_materials;
        }
        
        if(isset($productObj->look) && !empty($productObj->look))
        {
            $looks = explode(',', $productObj->look);
        
            $indexed_looks = array();
            foreach($looks as $look)
            {
                $indexed_looks[] = strtolower(preg_replace('/\s+/', '-',trim($look)));
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
        foreach ($combinaisons AS $k => $combinaison)
        {
            if($combinaison['group_name'] == 'size' || $combinaison['group_name'] == 'Size')
                $indexed_sizes[] = $combinaison['attribute_name'];
        }
        $doc->size = $indexed_sizes;
	$doc->cashback_percentage = $productObj->cashback_percentage;

        $docs[] = $doc;

        if(++$count == 300)
        {
            $update->addDocuments($docs);

            $result = $client->update($update);

            echo 'Update query executed'.PHP_EOL;
            echo 'Query status: ' . $result->getStatus() . PHP_EOL;
            echo 'Query time: ' . $result->getQueryTime() . PHP_EOL;

            $count = 0;
            $docs = array();
            $update = $client->createUpdate();
        }
    }
    $update->addDocuments($docs);
    date_default_timezone_set($default_tz);

    $result = $client->update($update);

    $sql = "update ps_product set indexed = 1 where indexed = 0";
    Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);

}

 function deleteProduct($id_product, $client)
{
    // get an update query instance
    $update = $client->createUpdate();

    // add the delete query and a commit command to the update query
    $update->addDeleteById($id_product);

    // this executes the query and returns the result
    $result = $client->update($update);
}

function getWeekSalesScore($quantity)
{
    $quantity = (int)$quantity;
    if($quantity >= 6) return 10;
    if($quantity >= 5) return 9;
    if($quantity >= 4) return 8;
    if($quantity >= 2) return 7;
    if($quantity >= 1) return 6;
    return 0;
}

function getAgeScore($age)
{
    $age = (int)$age;
    if($age >= 365) return 0;
    if($age >= 180) return 1;
    if($age >= 90) return 2;
    if($age >= 60) return 3;
    if($age >= 45) return 4;
    if($age >= 35) return 5;
    if($age >= 28) return 6;
    if($age >= 21) return 7;
    if($age >= 14) return 8;
    if($age >= 7) return 9;
    if($age >= 2) return 10;
    if($age >= 1) return 11;
    return 12;
}

function getMonthScore($revenue)
{
    $revenue = (int)$revenue;
    if($revenue >= 100000) return 10;
    if($revenue >= 75000) return 9;
    if($revenue >= 50000) return 8;
    if($revenue >= 40000) return 7;
    if($revenue >= 30000) return 6;
    if($revenue >= 20000) return 5;
    if($revenue >= 10000) return 4;
    if($revenue >= 5000) return 3;
    if($revenue >= 2500) return 2;
    if($revenue >= 1000) return 1;
    return 0;
}

function getYearScore($revenue)
{
    $revenue = (int)$revenue;
    if($revenue >= 500000) return 10;
    if($revenue >= 250000) return 9;
    if($revenue >= 200000) return 8;
    if($revenue >= 150000) return 7;
    if($revenue >= 100000) return 6;
    if($revenue >= 75000) return 5;
    if($revenue >= 50000) return 4;
    if($revenue >= 25000) return 3;
    if($revenue >= 10000) return 2;
    if($revenue >= 5000) return 1;
    return 0;
}

function deleteIndex($client)
{
    // get an update query instance
    $update = $client->createUpdate();

    // add the delete query and a commit command to the update query
    $update->addDeleteQuery('*:*');
    $update->addCommit();

    // this executes the query and returns the result
    $result = $client->update($update);
}

function deleteByIds($client)
{
    // get an update query instance
    $update = $client->createUpdate();

    // add the delete query and a commit command to the update query
    $update->addDeleteQuery('+id_product:(7501 OR 7502 OR 7503)');
    $update->addCommit();

    // this executes the query and returns the result
    $result = $client->update($update);
}

function update_currency() {
    echomsg("Start Updating Currency Conversion Rates");
    try {
        $curr_list = file_get_contents("http://openexchangerates.org/api/latest.json?app_id=c8cbe15270254f4686d6b3f3a7a2af89");
        $curr = Tools::jsonDecode($curr_list);
      
        if( strtoupper((string)$curr->base) === 'USD') {
                    $update_clause = array();
                    $rates = $curr->rates;
            $currencies = CurrencyCore::getCurrencies(false,0);
                    foreach($currencies as $currency) {
                        $iso_code = $currency['iso_code'];
                        $this_rate = number_format((float)$rates->$iso_code, 2, '.', '');
                        if( (string)$iso_code === 'INR')
                            $inr_rate = $this_rate;
                        array_push($update_clause, "WHEN iso_code = '$iso_code' THEN '$this_rate'");
                    }
                    $sql = "update ps_currency set conversion_rate = CASE ";
                    $sql .= implode(" ", $update_clause);
                    $sql .= " END";
                    Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);
                    echomsg("All Currencies Conversions Updated Successfully");
                    //add USD to INR in history table
                    $today = date("Y-m-d 00:00:00");
                    $sql = "insert into ps_currency_rates values('$today','$inr_rate')";
                    Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);
        } else {
            echomsg("Base Currency not in US", true);
        }
    } catch(Exception $ex) {
        echomsg('Unable to retrieve currency conversion list', true);
    }
}
function echomsg($message, $alert=false) {
    $tnow = date('Y-m-d H:i:s');
    echo "\n$tnow - $message";
    if($alert) {
                $event = 'Currency Conversion Rates Update Failed';
        $templateVars = array();
        $templateVars['{event}'] = $event;
        $templateVars['{description}'] = $message;
        $to_email = array('venugopal.annamaneni@violetbag.com','vineet.saxena@violetbag.com','ramakant.sharma@violetbag.com'); 
        @Mail::Send(1, 'alert', $event, $templateVars, $to_email , null, 'care@indusdiva.com', 'Indusdiva.com', NULL, NULL, _PS_MAIL_DIR_, false);
    }
}
//deleteIndex($client);
//deleteByIds($client);
$sql = "select id_product from ps_product_tag where id_tag=4198";
$product_ids = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);
$product_ids = array_map(function($product){
	return $product['id_product'];
}, $product_ids);

$product_ids = array(63378, 63371, 63366, 63365, 63356, 63348, 63338, 63325, 59816 );
//print_r($product_ids);
//addProducts($client);
addProducts($client, $product_ids);
?>
