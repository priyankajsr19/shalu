<?php
include(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');
include(dirname(__FILE__).'/image_helper.php');

ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');


//$codes = array('MUM0550001','MUM0550002','MUM0550003','MUM0550004','MUM0550005','MUM0550006','MUM0550007','MUM0550008','MUM0550009','MUM0550010','MUM0550011','MUM0550012','MUM0550013');
$codes = array();


foreach($codes as $code) {
	$productObj = Product::getByReference($code);
	$reference = $productObj->reference;
	$images = $productObj->getImages(1);
	$id_product = $productObj->id;
	$productImages = array();
	$count = 1;
	$failed = false;
	echo "For Product  : $code"; echo PHP_EOL; flush();
	foreach ($images AS $k => $image) {
		$image = $link->getImageLink($productObj->link_rewrite,$image['id_image'], 'thickbox');
		$image = (int) preg_replace('/\D/', '', $image);
		$str = str_split($image);
		$filepath = "/var/www/indusdiva.com/img/p/";
		$filepath = $filepath . implode("/",$str) . "/". $image . "-thickbox.jpg";
		$new_filename = "{$id_product}_{$count}.jpg"; 
		$new_filename = "/var/www/indusdiva.com/gosf-images/".$new_filename;

		$source_gd_image = createImageFromFile($filepath);
                
		$new_width = 483;
		$new_height = 660;
		

		$dest_gd_image = scaleImageToHeight($source_gd_image, $new_height);	

		$background = createImage(990,660);
		$background = mergeImages($background, $dest_gd_image, Imagick::COMPOSITE_DEFAULT, 0, 0, Imagick::GRAVITY_CENTER); 
		$background->setImageFormat('jpg');
		$background->writeImage($new_filename);
		
		
                $source_gd_image->destroy();
                $dest_gd_image->destroy();
                $background->destroy();
		$count++;
	}

		
}
	//LOGO
	$filepath = "/home/venu/Logo.jpg";
	$source_gd_image = createImageFromFile($filepath);
	$dest_gd_image = scaleImageToWidth($source_gd_image, 990);
	$background = createImage(990,660);
	$background = mergeImages($background, $dest_gd_image, Imagick::COMPOSITE_DEFAULT, 0, 0, Imagick::GRAVITY_CENTER);
	$background->setImageFormat('jpg');
	$background->writeImage('/var/www/indusdiva.com/gosf-images/logo.jpg');

?>
