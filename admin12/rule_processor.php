<?php
define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');
include(PS_ADMIN_DIR.'/rules/rules_base.php');

echo "\nRule Processor Triggered";

//VBRewards::removeRewards(17, 7, 1, 210, 'testing delete', 12, $date = false);
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);

$sqs = new AmazonSQS();
$sqs->set_region(AmazonSQS::REGION_APAC_SE1);
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);

for($count = 1; $count < 10; $count++)
{
	$response = $sqs->receive_message(RULES_QUEUE);
	
	if(!$response->body->ReceiveMessageResult->Message) 
		sleep(0);
	else
	{
		if(processMessage($response, $db));
		{
			$handle = $response->body->ReceiveMessageResult->Message->ReceiptHandle;
			$sqs->delete_message(RULES_QUEUE, $handle);
		}
	}
}

function processMessage($response, $db)
{
	echo $response->body->ReceiveMessageResult->Message->Body . PHP_EOL;
	//$message = Tools::jsonDecode('{"id_event":5,"date_event":"2012-03-14 13:07:18","reference":"274","id_customer":"10687"}', true);
	$message = Tools::jsonDecode($response->body->ReceiveMessageResult->Message->Body, true);
	$id_event = $message['id_event'];
	
	$res = $db->ExecuteS("select le.id_event, le.name as 'event_name', r.id_rule, r.name as 'rule_name', re.execute_sequence
							from vb_rules r
							inner join vb_loyalty_rule_events re on (r.id_rule = re.id_rule)
							inner join vb_loyalty_events le on le.id_event = re.id_event
							where le.id_event = " . $message['id_event'] . " order by le.id_event, re.execute_sequence");
	foreach ($res as $rule_row)
	{
		$rewards_rule = RewardRules::getRule($rule_row['rule_name']);
		$rewards_rule->init($db);
		$rewards_rule->processEvent($db, $message);
		echo PHP_EOL;
	}
	
	return true;
}
