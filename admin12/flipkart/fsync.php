<?php

define('_PS_ADMIN_DIR_', getcwd().'/..');
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');
include(PS_ADMIN_DIR.'/functions.php');
if (!defined('_PS_BASE_URL_'))
        define('_PS_BASE_URL_', Tools::getShopDomain(true));


$url = "https://api.flipkart.net/";
$username = "qbssyiexjyb659i4";
$password = "73432e3e-9c72-44ab-a8ff-8a44f42d614e";

$db = Db::getInstance(_PS_USE_SQL_SLAVE_);

$sql = getProductsSQL();
$products = $db->ExecuteS($sql);
if( count($products) === 0 ) {
    echomsg("No New Products pending to be added");
    echomsg("End - Feed Preparation"); 
    return;
}

$success = true;

$skus = getSKUs($products);
$updated_skus = array();

foreach($skus as $sku) {

    $id_product = $sku["id_product"];
    $id_sku = $sku['id_sku'];
    $is_parent = $sku["is_parent"];
    $has_children = empty($sku["attribute"])?false:true;
    $size = empty($sku["attribute"])?"One Size":$sku["attribute"]["attribute_name"];
    $force_inactive = (isset($sku['inactive']) && (int)$sku['inactive'] === 1)?true:false; 
    $divaProduct = new Product($id_product, true ,1 );
    echomsg("SKU #$id_sku - Start"); 
    
    if( $is_parent === false && $has_children === false ) {
        $id_product_attribute = null;
    } else {
        if( $is_parent ) {
            $id_product_attribute = null;
        } else {
            $id_product_attribute = $sku['attribute']['id_product_attribute'];
        }
    }
    
    $mrp_in = round(Product::getPriceStatic($divaProduct->id, true,$id_product_attribute , 6, NULL, false, false, 1, false, NULL, NULL, IND_ADDRESS_ID));
    $new_price = round(Tools::convertPrice($mrp_in,4));
    $offer_price_in = round(Product::getPriceStatic($divaProduct->id, true, $id_product_attribute, 6, NULL, false, true, 1, false, NULL, NULL, IND_ADDRESS_ID));
    $new_specific_price = round(Tools::convertPrice($offer_price_in, 4));
    $new_quantity = (int)Product::getQuantity($id_product, $id_product_attribute);
    $new_shipping_sla = (int)$divaProduct->shipping_sla;
    $new_active = (int)$divaProduct->active;
    if($force_inactive)
        $new_active = 0;
    /*$ex_sql = "select flipkart from ps_affiliate_product where id_product = $id_product";
    $ex_row = $db->getRow($ex_sql);*/
    $flipkart_exclusive = 1; //(int)$ex_row['flipkart'];
    $new_exclusive = (int)$divaProduct->is_exclusive;
    
    $exclude_from_flipkart = false;
    if( substr($divaProduct->reference,0,6) === 'BLR002' || $new_shipping_sla > 5 || !$new_active || !$new_exclusive || $new_quantity < 0 || !$flipkart_exclusive )
        $exclude_from_flipkart = true;
    
    //check to see if the product is on amazon already
    //$sql = "select * from ps_flipkart_feed_product_info where id_sku = '$id_sku'";
    //$res = $db->getRow($sql);

    //if( !empty($res) ) {
    if( false ) { // TODO - Capture original qty and shipping sla instead of 0 and 5 sent to flipkart and then remove this condition
        echomsg("SKU #$id_sku - ....Update SKU");
        $old_price = isset($res['price'])?(int)$res['price']:null;
        $old_specific_price = isset($res['specific_price'])?(int)$res['specific_price']:null;
        $old_quantity = isset($res['quantity'])?(int)$res['quantity']:null;
        $old_shipping_sla = isset($res['shipping_sla'])?(int)$res['shipping_sla']:null;

        $updates = array();
        if( $new_price !== $old_price ) {
            $updates['mrp'] = $new_price;
        }
        if( $new_quantity !== $old_quantity ) {
            if( $new_quantity < 0 )
                $new_quantity = 0;
            $updates["stock_count"] = $new_quantity;
        }
        if( $new_specific_price !== $old_specific_price ) {
            $updates["selling_price"] = $new_specific_price;
        }
        if( $new_shipping_sla !== $old_shipping_sla ) {
            if( $new_shipping_sla > 5 )
                $new_shipping_sla = 5;
            $updates["procurement_sla"] = $new_shipping_sla;
        }
        if( $exclude_from_flipkart === false )
            $updates["listing_status"] = "ACTIVE";
        else
            $updates["listing_status"] = "INACTIVE";

        if( count($updates) > 0 ) {
            $updated_skus[$id_sku] = $updates;
        }
    } else {
        echomsg("SKU #$id_sku - ....New SKU");
        $updates = array();
        $updates['mrp'] = $new_price;
        if( $new_quantity < 0 )
            $new_quantity = 0;
        $updates["stock_count"] = $new_quantity;
        $updates["selling_price"] = $new_specific_price;
        if( $new_shipping_sla > 5 )
            $new_shipping_sla = 5;
        $updates["procurement_sla"] = $new_shipping_sla;
        if( $exclude_from_flipkart === false )
            $updates["listing_status"] = "ACTIVE";
        else
            $updates["listing_status"] = "INACTIVE";
        $updated_skus[$id_sku] = $updates;
    }
    echomsg("SKU #$id_sku - End");
}

echomsg("Updating the data to Flipkart");
$request = new stdClass;
$count = 0;
$request->listings = array();
foreach($updated_skus as $id_sku => $updates) {
    $this_listing = new stdClass;
    $this_listing->skuId = $id_sku;
    $attributeValues = new stdClass;
    foreach($updates as $key=>$value) {
        $attributeValues->$key = "$value";
    }
    $this_listing->attributeValues = $attributeValues;
    array_push($request->listings, $this_listing);
    $count++;
    if( $count === 10) {
        $res = postFeed($request);
        $success = $success && $res;
        $request = new stdClass;
        $count = 0;
        $request->listings = array();

    }
}
if( $count > 0 ) {
    $res = postFeed($request);
    $success = $success && $res;
} 
echomsg("End");

if( $success ) {
    $date_add = date('Y-m-d H:i:s');
    $db->ExecuteS("insert into ps_flipkart_feed(date_add) values('$date_add')"); 
}
function prettyPrint( $json )
{
    $result = '';
    $level = 0;
    $prev_char = '';
    $in_quotes = false;
    $ends_line_level = NULL;
    $json_length = strlen( $json );

    for( $i = 0; $i < $json_length; $i++ ) {
        $char = $json[$i];
        $new_line_level = NULL;
        $post = "";
        if( $ends_line_level !== NULL ) {
            $new_line_level = $ends_line_level;
            $ends_line_level = NULL;
        }
        if( $char === '"' && $prev_char != '\\' ) {
            $in_quotes = !$in_quotes;
        } else if( ! $in_quotes ) {
            switch( $char ) {
                case '}': case ']':
                    $level--;
                    $ends_line_level = NULL;
                    $new_line_level = $level;
                    break;

                case '{': case '[':
                    $level++;
                case ',':
                    $ends_line_level = $level;
                    break;

                case ':':
                    $post = " ";
                    break;

                case " ": case "\t": case "\n": case "\r":
                    $char = "";
                    $ends_line_level = $new_line_level;
                    $new_line_level = NULL;
                    break;
            }
        }
        if( $new_line_level !== NULL ) {
            $result .= "\n".str_repeat( "\t", $new_line_level );
        }
        $result .= $char.$post;
        $prev_char = $char;
    }

    return $result;
}
function postFeed($request) {
    global $db, $url, $username, $password;
    try {
        $end_point = $url . "sellers/skus/listings/bulk";
        $auth_token = base64_encode($username . '-' . $password);
        $body = json_encode($request);
	echo $json_string = prettyPrint($body);
        $ch = curl_init($end_point);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                          
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Indusdiva Flipkart StockSync Cron');
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_FAILONERROR, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $response = curl_exec($ch);
	echo $response;
        curl_close($ch);
        $response = json_decode($response);
        if( $response->status === 'success' ) {
            foreach($request->listings as $listing) {
                $id_sku = $listing->skuId;
                $attr_values = $listing->attributeValues;
                $mrp = $attr_values->mrp;
                $stock_count = $attr_values->stock_count;
                $selling_price = $attr_values->selling_price;
                $procurement_sla = $attr_values->procurement_sla;
                $listing_status = $attr_values->listing_status;

                $usql = "update ps_flipkart_feed_product_info set mrp = '$mrp', selling_price = '$selling_price', procurement_sla = '$procurement_sla', stock_count = '$stock_count', listing_status = '$listing_status', status = 1 where id_sku = '$id_sku'";
                $db->ExecuteS($usql); 
            }
            return true;
        } else {
            send_tech_mail('Stock Sync Flipkart Failure', json_encode($request->listings) );
            foreach($request->listings as $listing) {
                $id_sku = $listing->skuId;
                $usql = "update ps_flipkart_feed_product_info set status = 0 where id_sku = '$id_sku'";
                $db->ExecuteS($usql);
            }
            return false;
        }
    } catch(Exception $ex) {
        return false;
    }

}

function send_tech_mail($event, $description) {
    $templateVars = array(
        'event' => $event,
        'description' => $description
    );
    @Mail::Send(1, 'alert', Mail::l('Flipkart Stock Sync Alarm'), $templateVars, array("venugopal.annamaneni@violetbag.com"), null, 'care@indusdiva.com', 'Indusdiva Monitoring', NULL, NULL, _PS_MAIL_DIR_, false);
}

function echomsg($message, $alert = false) {
    $tnow = date('Y-m-d H:i:s');
    echo "$tnow - $message\n";
}

function getSKUs($products) {
    global $db;
    $skus = array();
    foreach($products as $product) {
        $id_product = $product['id_product'];
        echomsg("Preparing SKUs for $id_product"); 
        $divaProduct = new Product($id_product,true,1);
   
        $found_skus = array(); 
        $attributesGroups = $divaProduct->getAttributesGroups(1);
        if( empty($attributesGroups) ) {

            $sql = "select * from ps_flipkart_feed_product_info where id_product = $id_product and concat('ID-', id_product) = id_sku";
            $row = $db->getRow($sql);
            if( !empty($row) ) {
        
                $this_sku = array(
                    "id_product" => $id_product,
                    "id_sku" => "ID-$id_product",
                    "is_parent" => false, 
                    "attribute" => null
                );
                array_push($found_skus, $this_sku['id_sku']);
                array_push( $skus, $this_sku );
            }

        } else {
        
            foreach($attributesGroups as $attribute) {
                $size = $attribute['attribute_name'];
                $id_sku = "ID-$id_product-$size";
                $csql = "select id_sku from ps_flipkart_feed_product_info where id_sku = '$id_sku'";
                $cres = $db->getRow($csql);
                if( !empty($cres) ) {
                    $this_sku = array(
                        "id_product" => $id_product,
                        "id_sku" => $id_sku,
                        "is_parent" => false, 
                        "attribute" => $attribute
                    );
                }
                array_push($found_skus, $this_sku['id_sku']);
                array_push( $skus, $this_sku );
            }
        }
        //check if there are other SKUs for this product already on amazon but deleted in our system
        $csql = "select id_sku from ps_flipkart_feed_product_info where id_product = $id_product and concat('ID-',id_product) != id_sku";
        $cres = $db->ExecuteS($csql);
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


function getProductsSQL() {
    global $db;
    $sql = "select max(date_add) last_date_add from ps_flipkart_feed";
    $date_res = $db->getRow($sql); 
    
    $sql = "select distinct f.id_product from ps_flipkart_feed_product_info f join ps_product p where p.id_product = f.id_product";

    if ( isset($date_res) && !empty($date_res['last_date_add'])  ) 
        $sql .= " and (p.date_upd >= '".$date_res['last_date_add']."' OR p.date_add >= '".$date_res['last_date_add']."')";

    $sql .= " union select id_product from ps_flipkart_feed_product_info where status = 0 ";
    //$sql .= " limit 10";
    return $sql;
}

?>
