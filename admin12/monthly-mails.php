<?php

define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');
include(PS_ADMIN_DIR.'/functions.php');

global $link;
$link = new Link();
if (!defined('_PS_BASE_URL_'))
	define('_PS_BASE_URL_', Tools::getShopDomain(true));

function sendWishlistMails() {
	
	global $link;
	
	$sql = "SELECT w.id_product, cc.email, cc.`firstname`, cc.id_customer
	FROM `ps_wishlist` w
	INNER JOIN ps_customer cc ON cc.`id_customer` = w.`id_customer`
	INNER JOIN ps_product p ON p.id_product = w.id_product
	LEFT JOIN ps_orders o ON o.`id_customer` = cc.`id_customer`
	WHERE o.id_customer IS NULL
	AND p.`quantity` > 0
	AND p.active = 1
	AND cc.newsletter = 0
	OR cc.id_customer = 1
	GROUP BY cc.`id_customer`";
	
	/*$sql = "SELECT w.id_product, cc.email, cc.`firstname`, cc.id_customer
	FROM `ps_wishlist` w
	INNER JOIN ps_customer cc ON cc.`id_customer` = w.`id_customer`
	INNER JOIN ps_product p ON p.id_product = w.id_product
	LEFT JOIN ps_orders o ON o.`id_customer` = cc.`id_customer`
	WHERE cc.id_customer in (1)
	AND p.`quantity` > 0
	AND p.active = 1
	GROUP BY cc.`id_customer`";*/

	$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);

	$count = 0;
	
	foreach($res as $row)
	{
		$count++;
		$id_product = $row['id_product'];
		$product = new Product($id_product, true, 1);

		$idImage = $product->getCoverWs();
		if($idImage)
			$idImage = $product->id.'-'.$idImage;
		else
			$idImage = Language::getIsoById(1).'-default';

		$templateVars = array();
		$templateVars['{firstname}'] = $row['firstname'];
		$templateVars['{product_url}'] = $product->getLink();
		$templateVars['{product_name}'] = $product->name;
		$templateVars['{image_link}'] = $link->getImageLink($product->link_rewrite,$idImage, 'list');

		$mailTo = $row['email'];
		echo "".$count." : ".$mailTo."\n";
		$subject = $row['firstname'] . ", Let your Wishlist Come True";
		@Mail::Send(1, 'wishlistreminder', $subject, $templateVars,$mailTo , $row['firstname'], 'care@indusdiva.com', 'Indusdiva.com', NULL, NULL, _PS_MAIL_DIR_, true);
		usleep(200000);
	}
}

sendWishlistMails();