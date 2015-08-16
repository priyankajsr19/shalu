<?php
define('_PS_JSONAPI_DIR_', getcwd());
define('PS_JSONAPI_DIR', _PS_JSONAPI_DIR_); // Retro-compatibility

include(PS_JSONAPI_DIR.'/../config/config.inc.php');
include(PS_JSONAPI_DIR.'/../admin12/functions.php');

if( $_SERVER['REQUEST_METHOD'] === 'GET' ) {

	$id_location = Tools::getValue('location_code');
        $token = Tools::getValue('token');
        $emp = new Employee();
        $t_email = $emp->retrieveToken($token);
        
        if( empty($t_email) ) {
            $status = 'ERROR';
            $message = 'Auth Failure';
            $locations = null;
        } else {
            $sql = 'select * from ps_locations';
            if( !empty($id_location) )
                    $sql .= " where id_location = '{$id_location}'";

            $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);

            $locations = new stdClass();
            $locations->locations = array();
            foreach($res as $row) {
                    array_push($locations->locations, (object)$row);
            }
            $status = 'OK';
            $message = 'Success';
        }    
	
	$response = array(
            'status' => $status,
            'message'  => $message,
            'locations' => $locations
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
