<?php
include(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');

ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');



$codes = array('BLR0010192','BLR0010197','BLR0010217','BLR0010244','BLR0010245','BLR0010270','BLR0010271','BLR0010272','BLR0010274','BLR0010276','BLR0010277','BLR0010278','BLR0010279','BLR0050180','BLR0050207','BLR0050208','BLR0050210','BLR0050212','BLR0050213','BLR0050216','BLR0050217','BLR0050228','BLR0050232','BLR0050234','BLR0050239','BLR0050241','BLR0050246','BLR0050256','BLR0050264','BLR0050265','BLR0050268','BLR0050270','BLR0050281','BLR0050298','BLR0050300','BLR0050315','BLR0050325','BLR0050331','BLR0050333','BLR0050334','BLR0050335','BLR0050337','BLR0050341','BLR0050344');

foreach($codes as $code) {
	$productObj = Product::getByReference($code);
	$reference = $productObj->reference;
	$images = $productObj->getImages(1);
	$productImages = array();
	$count = 1;
	$failed = false;
	echo "For Product  : $code"; echo PHP_EOL; flush();
	foreach ($images AS $k => $image) {
		$image = $link->getImageLink($productObj->link_rewrite,$image['id_image'], 'thickbox');
		$image = (int) preg_replace('/\D/', '', $image);
		$str = str_split($image);
		$filepath = "/var/www/indusdiva.com/img/p/";
		$filepath = $filepath . implode("/",$str) . "/". $image . "-large.jpg";
		$new_filename = "{$reference}_M_{$count}_2x.jpg"; 
		$new_filename = "/var/www/indusdiva.com/snapdeal-images/".$new_filename;

		$source_gd_image = imagecreatefromjpeg($filepath);
                
		$new_width = 531;
		$new_height = 726;
		

		$dest_gd_image = resize_image($source_gd_image, $new_width, $new_height);	

		$background = imagecreatefromjpeg("/home/venu/snapdeal_bg.jpg");
		$result = imagecopymerge($background, $dest_gd_image,45,0, 0, 0, 531, 726, 100); 
                imagejpeg($background, $new_filename, 90);
                imagedestroy($source_gd_image);
                imagedestroy($dest_gd_image);
                imagedestroy($background);
		if( !$result ) {
			echo "Failed for $code"; echo PHP_EOL;
			break;
		}
		$count++;
	}
}

function resize_image($source_image, $destination_width, $destination_height, $type = 0) { 
    // $type (1=crop to fit, 2=letterbox) 
    $source_width = imagesx($source_image); 
    $source_height = imagesy($source_image); 
    $source_ratio = $source_width / $source_height; 
    $destination_ratio = $destination_width / $destination_height; 
    if ($type == 1) { 
        // crop to fit 
        if ($source_ratio > $destination_ratio) { 
            // source has a wider ratio 
            $temp_width = (int)($source_height * $destination_ratio); 
            $temp_height = $source_height; 
            $source_x = (int)(($source_width - $temp_width) / 2); 
            $source_y = 0; 
        } else { 
            // source has a taller ratio 
            $temp_width = $source_width; 
            $temp_height = (int)($source_width / $destination_ratio); 
            $source_x = 0; 
            $source_y = (int)(($source_height - $temp_height) / 2); 
        } 
        $destination_x = 0; 
        $destination_y = 0; 
        $source_width = $temp_width; 
        $source_height = $temp_height; 
        $new_destination_width = $destination_width; 
        $new_destination_height = $destination_height; 
    } else { 
        // letterbox 
        if ($source_ratio < $destination_ratio) { 
            // source has a taller ratio 
            $temp_width = (int)($destination_height * $source_ratio); 
            $temp_height = $destination_height; 
            $destination_x = (int)(($destination_width - $temp_width) / 2); 
            $destination_y = 0; 
        } else { 
            // source has a wider ratio 
            $temp_width = $destination_width; 
            $temp_height = (int)($destination_width / $source_ratio); 
            $destination_x = 0; 
            $destination_y = (int)(($destination_height - $temp_height) / 2); 
        } 
        $source_x = 0; 
        $source_y = 0; 
        $new_destination_width = $temp_width; 
        $new_destination_height = $temp_height; 
    } 
    $destination_image = imagecreatetruecolor($destination_width, $destination_height); 
    if ($type > 1) { 
        imagefill($destination_image, 0, 0, imagecolorallocate ($destination_image, 0, 0, 0)); 
    } 
    imagecopyresampled($destination_image, $source_image, $destination_x, $destination_y, $source_x, $source_y, $new_destination_width, $new_destination_height, $source_width, $source_height); 
    return $destination_image; 
} 
?>
