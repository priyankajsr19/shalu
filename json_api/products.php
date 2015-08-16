<?php
define('_PS_JSONAPI_DIR_', getcwd());
define('PS_JSONAPI_DIR', _PS_JSONAPI_DIR_); // Retro-compatibility

include(PS_JSONAPI_DIR.'/../config/config.inc.php');
include(PS_JSONAPI_DIR.'/../admin12/functions.php');

$link =  new Link();
global $link;
$token = Tools::getValue('token');
$emp = new Employee();
$t_email = $emp->retrieveToken($token);

if( empty($t_email) ) {
    $status = 'ERROR';
    $message = 'Auth Failure';
    
    $response = array(
        'status' => $status,
        'message'  => $message,
        'products' => null
    );
    $response = Tools::jsonEncode($response);
    $callback = Tools::getValue('callback', false);
    if($callback) {
            $response = $callback . '(' . $response . ');';
    }
    echo $response; exit;
}


//PHP 0 :)
if( Tools::getValue('new_quantity', false) === '0' )
	$new_quantity = 'zero';
else
	$new_quantity = Tools::getValue('new_quantity', false);


if( !$new_quantity ){

	$id_location = Tools::getValue('location');
	$id_product = Tools::getValue('id_product');
	$reference = Tools::getValue('code');
	$sreference = Tools::getValue('scode');
	$id_supplier = Tools::getValue('id_vendor');
	$in_stock = Tools::getValue('in_stock');



	$sql = getProductQuery();
	$clauses = array();

	if( !empty($id_location) )
		array_push($clauses, "p.location = '{$id_location}'");
	if( !empty($id_product) )
		array_push($clauses, "p.id_product = {$id_product}");
	if( !empty($reference) )
		array_push($clauses, "p.reference = '{$reference}'");
	if( !empty($id_supplier) )
		array_push($clauses, "p.id_supplier = {$id_supplier}");
	if( !empty($sreference) )
		array_push($clauses, "p.supplier_reference = '{$sreference}'");
	if( !empty($in_stock) )
		array_push($clauses, "p.quantity > 0"); 
	if( count($clauses) > 0 )
		$sql = $sql . " where " . implode(" and ", $clauses);
	$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);

	$products = new stdClass();
	$products->products = array();
	foreach($res as $row) {
		$row["sourcing_price"] = number_format(Tools::convertPrice($row['sourcing_price'],4,2));
		array_push($products->products, (object)$row);
	}
        $response = array(
            'status' => "OK",
            'message'  => "Success",
            'products' => $products
        );
        
	$response = Tools::jsonEncode($response);
	
	$callback = Tools::getValue('callback', false);
	if($callback)
	{
		$response = $callback . '(' . $response . ');';
	}
	
	echo $response; exit;

} else {
	$id_product = intval(Tools::getValue('id_product'));

	
	$db = Db::getInstance();
	if( empty($id_product) || empty($new_quantity) ) {
		$error = true;
		$msg = "Mandatory parameters id_product and/or quantity are missing";
	}
	else {
		if( $new_quantity === 'zero' )
			$new_quantity = 0;

		$quantity = intval($new_quantity);

		$sql = "select id_employee from ps_employee where email = '$t_email'"; 
		$res = $db->ExecuteS($sql);
		$id_employee = $res[0]["id_employee"];

		$sql = "select quantity from ps_product where id_product = {$id_product}";
		$res = $db->ExecuteS($sql);
		$old_quantity = (int)$res[0]["quantity"];

		if( $old_quantity = $quantity ) {
			$error = true;
			$msg = "Quantity is not updated (May be the quantity is already up to date)";
		} else {
			$product =  new Product($id_product);
                	$product->quantity = (int)$quantity;
                	$product->update();
			$error = false;
			$msg = "Quantity is updated successfully";
			SolrSearch::updateProduct($id_product);
			$sql = "insert into stock_sync_data(id_product,old_quantity,new_quantity,id_employee,status) values($id_product,$old_quantity,$quantity,$id_employee,1)";
			$db->Execute($sql);
		}
	}
	$sql = getProductQuery();
	$sql = $sql . " where p.id_product = {$id_product} limit 1";
	$res = $db->ExecuteS($sql);
	$product = $res[0];
	$product["sourcing_price"] = number_format(Tools::convertPrice($product["sourcing_price"],4,2));	
	$response = array();
	$response['status'] = $error?'Error':'OK';
	$response['message'] = $msg;
	$response['product'] = $product;
	
	$response = Tools::jsonEncode($response);
	
	$callback = Tools::getValue('callback', false);
	if($callback)
	{
		$response = $callback . '(' . $response . ');';
	}

	//send notification
	if( !$error )	{
		$templateVars['{updated_by}'] = $t_email;
		$templateVars['{id_product}'] = $product["id"];
		$templateVars['{name}'] = $product['name'];
		$templateVars['{code}'] = $product['code'];
		$templateVars['{location}'] = $product['location'];
		$templateVars['{old_quantity}'] = $old_quantity;
		$templateVars['{quantity}'] = $product['quantity'];
		$templateVars['{sourcing_price}'] = "Rs.".number_format(Tools::convertPrice($product['sourcing_price'],4,2));
		$templateVars['{image_link}'] = $product['image_link'];
		$sql = "select email from ps_employee where id_location = {$id_location}";
		$res = $db->ExecuteS($sql);
		$pri_email = $res[0]['email'];
		$to = array(
			'rohit.modi@violetbag.com',
			'vineet.saxena@violetbag.com',
			'ramakant.sharma@violetbag.com',
			'venugopal.annamaneni@violetbag.com'
		);
		if(!empty($pri_email))
			array_push($to,$pri_email);

		$subject = "Product Stock Updated For Product # ".$product['id']." (".$product["name"].")";
		@Mail::Send(1, 'product_stock_update', $subject, $templateVars,$to ,null, 'care@indusdiva.com', 'Indusdiva.com', NULL, NULL, _PS_MAIL_DIR_, false);	
	}
	echo $response; exit;
}

function getProductQuery() {
	$sql = "select p.id_product id, pl.name, p.reference code,location, p.quantity,p.supplier_reference,p.wholesale_price sourcing_price, concat('http://cdn.indusdiva.com/',i.id_image,'-large','/',pl.link_rewrite,'.jpg') image_link from ps_product p inner join ps_product_lang pl on p.id_product = pl.id_product inner join ps_image i on (i.id_product = p.id_product and i.cover=1)";
	return $sql;
}


?>
