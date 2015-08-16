<?php
include_once('rules_base.php');
class first_order_bonus extends rule_base {
	
	public static $id_rule = 7;
	public static $first_order_bonus = null;
	
	public function init($db)
	{
		if(self::$first_order_bonus) return;
		
		$rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::VALID_ORDER_BONUS_FIRST);
		
		self::$first_order_bonus = $rulesConfigs[0]["value"];
	}
	
	public function processEvent($db, $message) {
		echo "processing first_order_bonus : " . self::$first_order_bonus;
		
		$id_customer = $message['id_customer'];
		$id_event = $message['id_event'];
		
		if(self::rewardExistsForReference($id_customer, $id_event, self::$id_rule, $message['reference']))
		{	
			echo 'skipping processed reward' . PHP_EOL;
			return;
		}
		
		$date_add = $message['date_event'];
		$order = new Order((int)$message['reference']);
		
		if(Customer::getTotalDeliveredForCustomer($id_customer) == 1)
		{
			$points_added = self::$first_order_bonus;
			VBRewards::addRewardPoints($id_customer, $id_event, self::$id_rule, $points_added, 'First Order Bonus - Order no ' . $order->id, $order->id, $date_add);
		}
	}
	
	public function processCancel($db, $message)
	{
		echo "processing cancel first_order_bonus : " . PHP_EOL;
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
		
		VBRewards::removeRewardPoints($id_customer, $id_event, self::$id_rule, $points_removed, 'First Order Cancellation - Bonus coins reverted', $reference, $date_add);
	}
	
}
?>