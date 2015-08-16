<?php

class MarketplaceWebService_DB {

    public static $PRODUCT_FEED = 1;
    public static $PRICE_FEED = 2;
    public static $INVENTORY_FEED = 3;
    public static $IMAGE_FEED = 4;
    public static $RELATIONSHIP_FEED = 5;

    public static $STATUS_STARTED_PREP = 1;
    public static $STATUS_PREP_FAILED = 2;
    public static $STATUS_PREP_SUCCESS = 3;
    public static $STATUS_PREP_PARTIAL_SUCCESS = 8;
    public static $STATUS_AZN_SUBMITTED = 4;
    public static $STATUS_AZN_IN_PROGRESS= 5;
    public static $STATUS_AZN_FAILED = 6;
    public static $STATUS_AZN_SUCCESS = 7;
    public static $STATUS_AZN_TOBEUPDATED = 9;

    public static function newFeed() {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $date_add = date('Y-m-d H:i:s'); 
        $sql = "insert into ps_affiliate_feed(id_status,date_add) values(".self::$STATUS_STARTED_PREP.", '$date_add')";
        $db->ExecuteS($sql);
        return $db->Insert_ID();
    }
    public static function updateFeedStatus($id_feed, $status) {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $sql = "update ps_affiliate_feed set id_status=$status where id_feed = $id_feed";
        $db->ExecuteS($sql);
        return $id_feed;
    }
    public static function newSubFeed($id_feed, $id_type) {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $date_add = date('Y-m-d H:i:s'); 
        $sql = "insert into ps_affiliate_subfeed(id_type,id_feed, id_status, date_add) values($id_type, $id_feed, ".self::$STATUS_STARTED_PREP.", '$date_add')";
        $db->ExecuteS($sql);
        return $db->Insert_ID();
    }
    public static function updateSubFeedStatus($id_subfeed, $data) {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $updates = array();
        if( isset($data['status']) && !empty($data['status']) )
            array_push($updates, "id_status = ".$data['status']);
        if( isset($data['feed_file']) && !empty($data['feed_file']) )
            array_push($updates, "feed_file = '".mysql_real_escape_string($data['feed_file'])."'");
        $update_str = implode(",", $updates);
        $sql = "update ps_affiliate_subfeed set $update_str where id_subfeed = $id_subfeed";
        $db->ExecuteS($sql);
        return $id_subfeed;
    }
    public static function newFeedProduct($id_feed, $id_product, $id_sku) {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $date_add = date('Y-m-d H:i:s'); 
        $sql = "insert into ps_affiliate_feed_product(id_feed, id_product,id_sku, id_status, date_add) values($id_feed, $id_product, '$id_sku', ".self::$STATUS_STARTED_PREP.", '$date_add')";
        $db->ExecuteS($sql);
        return $db->Insert_ID();
    }
    public function updateFeedProduct($id_fp, $id_status ) {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $sql = "update ps_affiliate_feed_product set id_status = $id_status where id_fp = $id_fp";
        $db->ExecuteS($sql);
        return $id_fp;
    }
    public static function newSubFeedProduct($id_subfeed, $id_product, $id_sku, $op_type = 'U') {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $date_add = date('Y-m-d H:i:s'); 
        $sql = "insert into ps_affiliate_subfeed_product(id_subfeed, id_product,id_sku, id_status, op_type, date_add) values($id_subfeed, $id_product, '$id_sku', ".self::$STATUS_STARTED_PREP.", '$op_type','$date_add')";
        $db->ExecuteS($sql);
        return $db->Insert_ID();
    }
    public function updateSubFeedProduct($id_sfp, $id_status, $message = '' ) {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $message = mysql_real_escape_string($message);
        $sql = "update ps_affiliate_subfeed_product set id_status = $id_status,message = '$message'  where id_sfp = $id_sfp";
        $db->ExecuteS($sql);
        return $id_sfp;
    }
}

?>
