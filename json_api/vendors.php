<?php
define('_PS_JSONAPI_DIR_', getcwd());
define('PS_JSONAPI_DIR', _PS_JSONAPI_DIR_); // Retro-compatibility

include(PS_JSONAPI_DIR.'/../config/config.inc.php');
include(PS_JSONAPI_DIR.'/../admin12/functions.php');

if( $_SERVER['REQUEST_METHOD'] === 'GET' ) {

	$id_location = Tools::getValue('location');
	$id_supplier = Tools::getValue('id');
	$code = Tools::getValue('code');
	$token = Tools::getValue('token');
        $emp = new Employee();
        $t_email = $emp->retrieveToken($token);
        
        if( empty($t_email) ) {
            $status = 'ERROR';
            $message = 'Auth Failure';
            $vendors = null;
        } else {
            $sql = 'select id_supplier,name,code,id_location,contact_person,phone,email,address from ps_supplier';

            $clauses = array('active=1');

            if( !empty($id_location) )
                    array_push($clauses," id_location = '{$id_location}'");
            if( !empty($id_supplier) )
                    array_push($clauses," id_supplier = '{$id_supplier}'");
            if( !empty($code) )
                    array_push($clauses," code = '{$code}'");

            if( count($clauses) > 0 )
                    $sql = $sql . ' where ' .implode(" and ",$clauses);
            $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);

            $vendors = new stdClass();
            $vendors->vendors = array();
            foreach($res as $row) {
                    array_push($vendors->vendors, (object)$row);
            }
            $status = 'OK';
            $message = 'Success';
        }    
	
	$response = array(
            'status' => $status,
            'message'  => $message,
            'vendors' => $vendors
        );
        $response = Tools::jsonEncode($response);
        
	$callback = Tools::getValue('callback', false);
	if($callback)
	{
		$response = $callback . '(' . $response . ');';
	}
	
	echo $response; exit;
}
?>
