<?php
// *************************
// Imagick helper functions
// *************************
function createImageFromFile( $imagepath ) {
	return new Imagick($imagepath);
}
function cloneImage($im) {
	return $im->clone();
}
function createImage($width,$height,$createJPG=false,$bgcolor='') {
	$im =  new Imagick();
	if( $createJPG ) {
		$im->newImage($width, $height,new ImagickPixel($bgcolor),"jpg");
	}
	else {
		if( empty($bgcolor) ) {
			$color = 'white'; $trans_color = 'white';
		} else {
			$color = $bgcolor; $trans_color = "";
		}
		$im->newImage($width, $height,new ImagickPixel($color));
		$im->setImageFormat('png');
		if( !empty($trans_color) )
			$im->transparentPaintImage(new ImagickPixel($trans_color),0,0,false);
	}
	return $im;
}
function mergeImages($background,$foreground,$const_composite,$x,$y,$const_gravity) {
	$fGeo = $foreground->getImageGeometry();	
	$bGeo = $background->getImageGeometry();
	switch($const_gravity)  // imagickmagick is not compiled against the latst vesio, setImageGravity function is not supported -so writing our own
	{
		case Imagick::GRAVITY_CENTER:
			$centerx = ($bGeo["width"]/2) - ($fGeo["width"]/2) + $x;
			$centery = ($bGeo["height"]/2) - ($fGeo["height"]/2) + $y;
			$background->compositeImage($foreground,$const_composite,$centerx,$centery);
			break;
		case Imagick::GRAVITY_NORTHWEST:
			$background->compositeImage($foreground,$const_composite,$x,$y);
			break;
		case Imagick::GRAVITY_NORTH:
			$centerx = ($bGeo["width"]/2) - ($fGeo["width"]/2) + $x;
			$background->compositeImage($foreground,$const_composite,$centerx,$y);
			break;
	}					
	return $background;
}

function isPortrait($im) {
	return $im->getImageWidth() < $im->getImageHeight() ? true : false;
}

function scaleImageToWidth($im,$width) {
	$sc = cloneImage($im);
	$sc->scaleImage($width,0);
	return $sc;
}

function scaleImageToHeight($im,$height) {
	$sc = cloneImage($im);
	$sc->scaleImage(0,$height);
	return $sc;
}


//thumbnail's width and height is always same
function createThumbNail($im,$dimension,$format) {

	if( $format === "png" )
		$thumb = createImage($dimension,$dimension);
	else
		$thumb = createImage($dimension,$dimension,true,"white");

	//$dimension = $dimension - 2; // as we add a border of 1px

	if( isPortrait($im) )  
		$resized = scaleImageToHeight($im,$dimension);
	else {
		$resized = scaleImageToWidth($im,$dimension);
	}

	//$resized = borderImage($resized,1);
	
	$final_thumb = mergeImages($thumb,$resized,Imagick::COMPOSITE_DEFAULT,0,0,Imagick::GRAVITY_CENTER);
	//$final_thumb = borderImage($final_thumb,1);
	//$thumb->destroy(); 
	//$resized->destroy();

	return $final_thumb;
}

function borderImage($im,$borderWidth) {
	$color = new ImagickPixel();
	$color->setColor("rgb(224,224,224)");
	$im->borderImage($color,$borderWidth,$borderWidth);
	$color->destroy();

	return $im;
}

function resizeImage($im,$width,$height) {
	$im->resizeImage($width,$height,Imagick::FILTER_LANCZOS,1);
	return $im;
}

function rotateImage($im,$rotateAngle) {
	$im->setImageFormat("png");
	$im->rotateImage(new ImagickPixel('white'), $rotateAngle);
	//$im->transparentPaintImage(new ImagickPixel('white'),0,0,false);
	return $im;
}

function distortImage($im,$control_points) {
	$im->distortImage(Imagick::DISTORTION_SHEPARDS, $control_points, true);
	return $im;
}
?>
