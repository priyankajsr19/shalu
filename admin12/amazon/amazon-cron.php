<?php

define('_PS_ADMIN_DIR_', getcwd().'/..');
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');
include(PS_ADMIN_DIR.'/functions.php');
if (!defined('_PS_BASE_URL_'))
        define('_PS_BASE_URL_', Tools::getShopDomain(true));

require_once(_PS_ADMIN_DIR_.'/amazon/amazon_init.php');
//Feed
require_once(_PS_ADMIN_DIR_.'/amazon/base-feed.php');
require_once(_PS_ADMIN_DIR_.'/amazon/clothing-feed.php');
require_once(_PS_ADMIN_DIR_.'/amazon/jewelry-feed.php');
//Feeder
require_once(_PS_ADMIN_DIR_.'/amazon/product-feed.php');

//check for image feed, price feed and quantity feed ( associated with the product feed sent in the last cron)

//$jFeed = new JewelryFeed();
$feed = new ClothingFeed();

$feeder = new AmazonFeeder();

$result = false;

do {
    echo "\nPrice Feed\n";
    $result = $feeder->submitPendingFeeds(MarketplaceWebService_DB::$PRICE_FEED);
    sleep(5);
} while( $result === 'success');

if ( $result === 'wait' )
    return;

do {
    echo "\nImage Feed\n";
    $result = $feeder->submitPendingFeeds(MarketplaceWebService_DB::$IMAGE_FEED);
    sleep(5);
} while( $result === 'success');

if ( $result === 'wait' )
    return;

do {
    echo "\nInventory Feed\n";
    $result = $feeder->submitPendingFeeds(MarketplaceWebService_DB::$INVENTORY_FEED);
    sleep(5);
} while( $result === 'success');

do {
    echo "\Relationship Feed\n";
    $result = $feeder->submitPendingFeeds(MarketplaceWebService_DB::$RELATIONSHIP_FEED);
    sleep(5);
} while( $result === 'success');

if ( $result === 'wait' )
    return;

//prepare feeds for any new products added / updated / deleted (inactive)
//$jFeed->prepareFeed();
$feed->prepareFeed();

// If the feed is prepared, submit only product feed
// The associated image, price, inventory and relationship feeds will be submitted when the cron is fired again 
do {
    echo "\nProduct Feed\n";
    $result = $feeder->submitPendingFeeds(MarketplaceWebService_DB::$PRODUCT_FEED);
    sleep(5);
} while( $result === 'success');

?>
