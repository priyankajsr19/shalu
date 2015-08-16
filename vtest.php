<?php
ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');
include(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');

/*
$sproducts = array();

$sql = "select id_product,description_short from ps_product_lang where (description_short is not NULL or description_short != '')";
$result = Db::getInstance()->ExecuteS($sql);

foreach($result as $row) {
	$id_product = $row['id_product']; 
	$desc = $row['description_short'];
	if( !empty($desc) ) {
		$iarr = explode(",",$desc);
		$farr = array();
		foreach($iarr as $v) {
			$v = trim($v);
			if( strlen($v) !== 0 ) {
				
				if( in_array($v, array('menswearnew','plussize','dressyblouse','Brotherslist','Relativeslist','Colorblocking') )) {
					$farr[] =  $v;
				}
			}
		}
		if( count($farr) > 0 ) {
			$sarr = implode(",",$farr);
			if( strlen($sarr) > 4000 ) {
				echo $id_product;  echo PHP_EOL;
			} else {
				$sql = "update ps_product_lang set description_short = '$sarr' where id_product = $id_product";
				Db::getInstance()->ExecuteS($sql);
				$sproducts[] = $id_product;
			}
	
		} else {
				$sql = "update ps_product_lang set description_short = '' where id_product = $id_product";
				Db::getInstance()->ExecuteS($sql);
				$sproducts[] = $id_product;
		}
	}
}

SolrSearch::updateProducts($sproducts);
*/


$product = new Product(63140);
$product->description_short[1] = $product->description_short[1] . $product->description_short[1]; 
$fieldError = $product->validateFields(UNFRIENDLY_ERROR, true);
$langFieldError = $product->validateFieldsLang(UNFRIENDLY_ERROR, true);

var_dump( $fielError ); print_r( $langFieldError ); exit;

?>
