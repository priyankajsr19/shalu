<?php
include(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');

ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');

$products = array(17978,17975,17760,17712,8748,17981,17976,17764,17756,17714,17466,17460,17461,17352,17354,16630,16629,16619,16618,16639,13929,13917,13911,13130,13129,13128,13127,12796,11567,11566,10450,10202,2475,2476,466,467,510,18000,17999,17996,17988,17985,17974,17975,17966,17965,17967,17962,17763,17762,17761,17759,17757,17750,17715,17713,17457,17351,17353,17349,16623,16622,16631,15975,15966,15964);

foreach($products as $id_product) {
	$productObj =  new Product($id_product, true, 1);
	$reference = $productObj->reference;
	$images = $productObj->getImages(1);
	echo "For Product Id : $id_product"; echo PHP_EOL; flush();
	foreach ($images AS $k => $image) {
		$image = $link->getImageLink($productObj->link_rewrite,$image['id_image'], 'large');
		$image = (int) preg_replace('/\D/', '', $image);
		$str = str_split($image);
		$filepath = "/var/www/indusdiva.com/img/p/";
		$filepath = $filepath . implode("/",$str) . "/". $image . "-large.jpg";
		$new_filename = "divaimage-$reference.jpg"; 
		$new_filename = "/var/www/indusdiva.com/mvikarsha-images/".$new_filename;
		copy($filepath, $new_filename);
		break;
	}
}

?>
