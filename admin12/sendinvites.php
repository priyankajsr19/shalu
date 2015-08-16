<?php

define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');
include(PS_ADMIN_DIR.'/functions.php');

$sqs = new AmazonSQS();
$sqs->set_region(AmazonSQS::REGION_APAC_SE1);
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);

for($count = 1; $count < 10; $count++)
{
	$response = $sqs->receive_message(INVITE_QUEUE);
	
	if(!$response->body->ReceiveMessageResult->Message) 
		sleep(5);
	else
	{
		if(processMessage($response, $db));
		{
			$handle = $response->body->ReceiveMessageResult->Message->ReceiptHandle;
			$sqs->delete_message(INVITE_QUEUE, $handle);
		}
	}
}
	
/**
 * @param unknown_type $response
 * @param Db $db
 * @return boolean
 */
function processMessage($response, $db)
{
	echo $response->body->ReceiveMessageResult->Message->Body . PHP_EOL;
	
	$message = Tools::jsonDecode($response->body->ReceiveMessageResult->Message->Body, true);
	
	$id_customer = $message['id_customer'];
	$id_invite =  $message['id_invite'];
	
	$customer = new Customer((int)($id_customer));
	
	$res = $db->ExecuteS("SELECT email, name from vb_customer_referrals WHERE id_customer = " . $id_customer . " AND id_invite = " . $id_invite . " AND invite_sent is null");
	
	if(!count($res)) return true;
	
	foreach($res as $row)
	{
		$subject = "Your friend" . $customer->firstname . " has invited you";
	    $templateVars = array('{referrer_name}' => $customer->firstname, '{refer_code}' => $customer->id, '{name}'=> $row['name']);
	    
	    $subject = $customer->firstname . ' has given you 100 USD to shop at IndusDiva.com';
	    
	    @Mail::Send(1, 
	            'referral', 
	            $subject, 
	            $templateVars, 
	            $row['email'], 
	            $row['name'], 
	            'care@indusdiva.com', 
	            'Indusdiva.com');
	    
	    echo  "sent email to : " . $row['email'] . PHP_EOL;
	    sleep(2);
	    $res = $db->ExecuteS("UPDATE vb_customer_referrals SET invite_sent = 1 WHERE id_customer = " . $id_customer . " AND id_invite = " . $id_invite);
	}
	return true;
}

?>
