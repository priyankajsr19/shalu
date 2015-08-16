<?php
define('_PS_JSONAPI_DIR_', getcwd());
define('PS_JSONAPI_DIR', _PS_JSONAPI_DIR_); // Retro-compatibility

include(PS_JSONAPI_DIR.'/../config/config.inc.php');
include(PS_JSONAPI_DIR.'/../admin12/functions.php');

if( $_SERVER['REQUEST_METHOD'] === 'GET' ) {
	$email = Tools::getValue('email');
	$password = Tools::getValue('password');
	
	$db = Db::getInstance();
	if( empty($email) || empty($password) ) {
		$res = false;
                $token = null;
	}
	else {
		$emp = new Employee();
		$res = $emp->getByEmail($email,$password,true);
                
                if( $res ) {
                    $api_access = array("vineet.saxena@violetbag.com","savio.dsouza@violetbag.com","mahesh.bc@violetbag.com","zubair.ahmad@violetbag.com");
                    if( (int)$res->id_profile === 10 || in_array($email, $api_access)) {
                        $token = $emp->generateToken($email);
                    } else {
                        $res = false;
                        $token = null;
                    }
                }
                
	}
	$response = array(
                            'auth_status' => ($res ? 'success':'failure'),
                            'token' => $token
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
