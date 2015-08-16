<?php
class MarketplaceWebService_AmazonDataMap
{
	private static $diva_amazon_size_map = array(
			);
	private static $diva_amazon_color_map = array(
				"Blue"=>"Blue",
				"Green"=>"Green",
				"Multicolor"=>"Multi",
				"Purple"=>"Purple",
				"Maroon"=>"Red",
				"Pink"=>"Pink",
				"Yellow"=>"Yellow",
				"Red"=>"Red",
				"Cream"=>"White",
				"Black"=>"Black",
				"Brown"=>"Brown",
				"White"=>"White",
				"Gold"=>"Gold",
				"Magenta"=>"Pink",
				"Orange"=>"Orange",
				"Beige"=>"Beige",
				"Grey"=>"Gray",
				"Off White"=>"Off White"
			);
	public static function getAmazonColor($diva_color) {
		if( isset(self::$diva_amazon_color_map[$diva_color]) )
			return self::$diva_amazon_color_map[$diva_color];
		return null;
	}
	public static function getAmazonSize($diva_size) {
		if( isset(self::$diva_amazon_size_map[$diva_size]) )
			return self::$diva_amazon_size_map[$diva_size];
		return null;
	}
}
