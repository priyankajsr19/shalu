<?php
include_once('rules_base.php');
class valid_order extends rule_base {
	
	public static $id_rule = 2;
	public static $valid_order_points = null;
	
	public function init($db)
	{
		if(self::$valid_order_points) return;
		
		$rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::VALID_ORDER_POINTS);
		
		self::$valid_order_points = $rulesConfigs[0]["value"];
	}
	
	public function processEvent($db, $message) {
                //Not processing this indusdiva
                return true;
		$id_customer = $message['id_customer'];
		$id_event = $message['id_event'];
		$date_add = $message['date_event'];
		$order = new Order((int)$message['reference']);
		
		if(self::rewardExistsForReference($id_customer, $id_event, self::$id_rule, $message['reference']))
		{	
			echo 'skipping processed reward' . PHP_EOL;
			return;
		}
		
		$points_added = $order->total_paid_real * self::$valid_order_points;
		
		VBRewards::addRewardPoints($id_customer, $id_event, self::$id_rule, $points_added, 'Order delivered - Order no ' . $order->id, $order->id, $date_add);
	}
	
	public function processCancel($db, $message)
	{
                return true;
		$id_customer = $message['id_customer'];
		$id_event = $message['id_event'];
		$date_add = $message['date_event'];
		$reference = $message['reference'];
		
		if(self::rewardExistsForReference($id_customer, $id_event, self::$id_rule, $message['reference']))
		{	
			echo 'skipping processed reward' . PHP_EOL;
			return;
		}
		
		$reward = self::getReward($id_customer, EVENT_ORDER_DELIVERED, self::$id_rule, $reference);
		
		if(!$reward) return;
		
		$points_removed = $reward['points_awarded'];
		
		VBRewards::removeRewardPoints($id_customer, $id_event, self::$id_rule, $points_removed, 'Order cancelled - Order no ' . $reference, $reference, $date_add);
	}
}
?>