<?php
include(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');

ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');

$codes = array('MUM0210116','MUM0210117','MUM0210119','MUM0210120','MUM0210122','MUM0210123','MUM0210126','MUM0210127','MUM0210130','MUM0130165','MUM0130166','MUM0130167','MUM0130168','MUM0130169','MUM0130170','MUM0130171','MUM0130172','MUM0130173','MUM0130174','MUM0130175','MUM0130176','MUM0130177','MUM0130178','MUM0130179','MUM0130180','MUM0130181','MUM0130182','MUM0130183','MUM0130184','MUM0130185','MUM0130186','MUM0130187','MUM0130188','MUM0130189','MUM0130190','MUM0130191','MUM0130192','MUM0130193','MUM0130194','MUM0130195','MUM0130196','MUM0130197');

foreach($codes as $code) {

	echo "For Product : $code"; echo PHP_EOL; flush();
	$productObj = Product::getByReference($code);
	$reference = $productObj->reference;
	$images = $productObj->getImages(1);
	$productImages = array();
	$count = 1;
	$failed = false;
	foreach ($images AS $k => $image) {
		$image = $link->getImageLink($productObj->link_rewrite,$image['id_image'], 'thickbox');
		$image = (int) preg_replace('/\D/', '', $image);
		$str = str_split($image);
		$filepath = "/var/www/indusdiva.com/img/p/";
		$filepath = $filepath . implode("/",$str) . "/". $image . "-thickbox.jpg";
		$new_filename = "{$reference}({$count}).jpg"; 
		$new_filename = "/var/www/indusdiva.com/jabong-images/".$new_filename;
		copy($filepath,$new_filename);
		$count++;
	}
}

?>
