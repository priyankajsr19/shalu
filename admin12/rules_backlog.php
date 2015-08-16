<?php
define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');
include(PS_ADMIN_DIR.'/functions.php');
include(PS_ADMIN_DIR.'/rules/rules_base.php');

$file = fopen('backlog.txt', 'a');
$events = array();

logFirstDelivered();
#logOnlineOrder();
logRegistrations();
#logFirstReview();
logReviews();
logDelivered();

$date_array = array();

foreach($events as $key => $row)
{
	$date_array[$key] = $row['date'];
}

array_multisort($date_array, SORT_ASC, $events);

$db = Db::getInstance(_PS_USE_SQL_SLAVE_);

foreach($events as $event)
{
	processMessage($event['message'], $db);
}

/**
 * @param unknown_type $message
 * @param Db $db
 * @return void|boolean
 */
function processMessage($message, $db)
{
	//$message = Tools::jsonDecode('{"id_event":5,"date_event":"2012-03-14 13:07:18","reference":"274","id_customer":"10687"}', true);
	//$message = Tools::jsonDecode($response->body->ReceiveMessageResult->Message->Body, true);
	$message = Tools::jsonDecode($message, true);
	$id_event = $message['id_event'];
	if($id_event == ONLINE_ORDER)
	{
		VBRewards::addRewardPoints($message['id_customer'], $id_event, 0, 100, 'Online payment bonus - Order no ' . $message['reference'], $message['reference'], $message['date_event']);
		return;
	}
	if($id_event == EVENT_REGISTRATION)
	{
		VBRewards::addRewardPoints($message['id_customer'], $id_event, 0, 50, 'Registration/Sign-up', $message['reference'], $message['date_event']);
		return;
	}
	if(isset($message['first_order']) && $message['first_order'])
	{
	    VBRewards::addRewardPoints($message['id_customer'], $id_event, 7, 50, 'First Order Bonus - Order no ' . $message['reference'], $message['reference'], $message['date_event']);
	    return;
	}
	if(isset($message['first_review']) && $message['first_review'])
	{
	    VBRewards::addRewardPoints($message['id_customer'], $id_event, 9, 50, 'Product Review - First review bonus', $message['reference'], $message['date_event']);
	    return;
	}
	
	$res = $db->ExecuteS("select le.id_event, le.name as 'event_name', r.id_rule, r.name as 'rule_name', re.execute_sequence
							from vb_rules r
							inner join vb_loyalty_rule_events re on (r.id_rule = re.id_rule)
							inner join vb_loyalty_events le on le.id_event = re.id_event
							where le.id_event = " . $message['id_event'] . " order by le.id_event, re.execute_sequence");
	foreach ($res as $rule_row)
	{
	    if($rule_row['id_rule'] == 9 || $rule_row['id_rule'] == 7) continue;
		$rewards_rule = RewardRules::getRule($rule_row['rule_name']);
		$rewards_rule->init($db);
		$rewards_rule->processEvent($db, $message);
		echo PHP_EOL;
	}
	
	return false;
}
	
function logDelivered()
{
	global $events;
	$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
	$res = $db->ExecuteS("select o.id_order, h.date_add, o.id_customer,(SELECT MAX(`id_order_history`) FROM `ps_order_history` moh WHERE moh.`id_order` = o.`id_order` GROUP BY moh.`id_order`)
							from ps_orders o
							inner join `ps_order_history` h on o.id_order = h.id_order
							where h.`id_order_state` = 5
							and h.`id_order_history` = (SELECT MAX(`id_order_history`) FROM `ps_order_history` moh WHERE moh.`id_order` = o.`id_order` GROUP BY moh.`id_order`)
							order by h.date_add");
	
	foreach ($res as $row)
	{
		$message = array(
				'id_event' => EVENT_ORDER_DELIVERED,
				'date_event' => $row['date_add'],
				'reference' => $row['id_order'],
				'id_customer' => $row['id_customer']
		);
		$events[] = array('date' => date($row['date_add']), 'message' => Tools::jsonEncode($message));
	}

	echo (count($res));
}

function logFirstDelivered()
{
    global $events;
    $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
    $res = $db->ExecuteS("select o.id_order, h.date_add, o.id_customer,(SELECT MAX(`id_order_history`) FROM `ps_order_history` moh WHERE moh.`id_order` = o.`id_order` GROUP BY moh.`id_order`)
            from ps_orders o
            inner join `ps_order_history` h on o.id_order = h.id_order
            where h.`id_order_state` = 5
            and h.`id_order_history` = (SELECT MAX(`id_order_history`) FROM `ps_order_history` moh WHERE moh.`id_order` = o.`id_order` GROUP BY moh.`id_order`)
            group by o.id_customer
            order by h.date_add");

    foreach ($res as $row)
    {
        $message = array(
                'id_event' => EVENT_ORDER_DELIVERED,
                'date_event' => $row['date_add'],
                'reference' => $row['id_order'],
                'id_customer' => $row['id_customer'],
                'first_order' => true
        );
        $events[] = array('date' => date($row['date_add']), 'message' => Tools::jsonEncode($message));
    }

    echo (count($res));
}

function logCancelled()
{
	global $events;
	$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
	$res = $db->ExecuteS("select o.id_order, h.date_add, o.id_customer
			from ps_orders o
			inner join `ps_order_history` h on o.id_order = h.id_order
			where h.`id_order_state` = 6");
	foreach ($res as $row)
	{
		$message = array(
				'id_event' => EVENT_ORDER_CANCELLED,
				'date_event' => $row['date_add'],
				'reference' => $row['id_order'],
				'id_customer' => $row['id_customer']
		);
		$events[] = array('date' => date($row['date_add']), 'message' => Tools::jsonEncode($message));
		//echo Tools::jsonEncode($message) . PHP_EOL;
	}

}

function logRegistrations()
{
	global $events;
	$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
	$res = $db->ExecuteS("select id_customer, date_add from ps_customer order by id_customer desc");

	foreach ($res as $row)
	{
		$message = array(
				'id_event' => EVENT_REGISTRATION,
				'date_event' => $row['date_add'],
				'reference' => $row['id_customer'],
				'id_customer' => $row['id_customer']
		);
		
		$events[] = array('date' => date($row['date_add']), 'message' => Tools::jsonEncode($message));
		//echo Tools::jsonEncode($message) . PHP_EOL;
	}
}

function logOnlineOrder()
{
	global $events;
	$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
	$res = $db->ExecuteS("select o.id_customer, o.date_add, o.id_order from ps_orders o where payment = 'EBS'");

	foreach ($res as $row)
	{
		$message = array(
				'id_event' => ONLINE_ORDER,
				'date_event' => $row['date_add'],
				'reference' => $row['id_order'],
				'id_customer' => $row['id_customer']
		);
		
		$events[] = array('date' => date($row['date_add']), 'message' => Tools::jsonEncode($message));
		//echo Tools::jsonEncode($message) . PHP_EOL;
	}
}

function logReviews()
{
	global $events;
	$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
	$res = $db->ExecuteS("select id_customer, id_product, date_add from ps_product_comment where validate = 1");

	foreach ($res as $row)
	{
		$message = array(
				'id_event' => EVENT_REVIEW_APPROVED,
				'date_event' => $row['date_add'],
				'reference' => $row['id_product'],
				'id_customer' => $row['id_customer']
		);
		
		$events[] = array('date' => date($row['date_add']), 'message' => Tools::jsonEncode($message));
		//echo Tools::jsonEncode($message) . PHP_EOL;
	}
}

function logFirstReview()
{
    global $events;
    $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
    $res = $db->ExecuteS("select id_customer, id_product, date_add from ps_product_comment where validate = 1 group by id_customer");

    foreach ($res as $row)
    {
        $message = array(
                'id_event' => EVENT_REVIEW_APPROVED,
                'date_event' => $row['date_add'],
                'reference' => $row['id_product'],
                'id_customer' => $row['id_customer'],
                'first_review' => true
        );

        $events[] = array('date' => date($row['date_add']), 'message' => Tools::jsonEncode($message));
        //echo Tools::jsonEncode($message) . PHP_EOL;
    }
}

?>
