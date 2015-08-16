<?php
include_once('rules_base.php');
class order_value_bonus extends rule_base {
	
	public static $order_value_bonus_150 = null;
	public static $order_value_bonus_250 = null;
	public static $order_value_bonus_500 = null;
	public static $order_value_bonus_750 = null;
        public static $order_value_bonus_1000 = null;
        public static $order_value_bonus_1500 = null;
	public static $id_rule = 8;
	
	public function init($db)
	{
		if(self::$order_value_bonus_1000) return;
		
		$rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::VALID_ORDER_BONUS_150);
		self::$order_value_bonus_150 = $rulesConfigs[0]["value"];
		
		$rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::VALID_ORDER_BONUS_250);
		self::$order_value_bonus_250 = $rulesConfigs[0]["value"];
		
		$rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::VALID_ORDER_BONUS_500);
		self::$order_value_bonus_500 = $rulesConfigs[0]["value"];
                
                $rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::VALID_ORDER_BONUS_750);
		self::$order_value_bonus_750 = $rulesConfigs[0]["value"];
                
                $rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::VALID_ORDER_BONUS_1000);
		self::$order_value_bonus_1000 = $rulesConfigs[0]["value"];
                
                $rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::VALID_ORDER_BONUS_1500);
		self::$order_value_bonus_1500 = $rulesConfigs[0]["value"];
	}
	
	public function processEvent($db, $message) {
		echo "processing order_value_bonus : " . 
                        self::$order_value_bonus_150 . " : " . 
                        self::$order_value_bonus_250 . " : " . 
                        self::$order_value_bonus_500 . " : " . 
                        self::$order_value_bonus_750 . " : " . 
                        self::$order_value_bonus_1000 . " : " . 
                        self::$order_value_bonus_1500;
		
		$id_customer = $message['id_customer'];
		$id_event = $message['id_event'];
		
		if(self::rewardExistsForReference($id_customer, $id_event, self::$id_rule, $message['reference']))
		{	
			echo 'skipping processed reward' . PHP_EOL;
			return;
		}
		
		$date_add = $message['date_event'];
		$order = new Order((int)$message['reference']);
		
		$points_added = 0;
		$description = '';
                $actual_paid = ($order->total_paid_real/$order->conversion_rate);
		if( $actual_paid >= 1500 )
		{
		    $description = 'Order Value Bonus (Above 1,500) - Order no ' . $order->id;
		    $points_added = self::$order_value_bonus_1500;
		}
		else if($actual_paid >= 1000)
		{
		    $description = 'Order Value Bonus (Above 1,000) - Order no ' . $order->id;
			$points_added = self::$order_value_bonus_1000;
		}
		else if($actual_paid >= 750)
		{
		    $description = 'Order Value Bonus (Above 750) - Order no ' . $order->id;
		    $points_added = self::$order_value_bonus_750;
		}
                else if($actual_paid >= 500)
		{
		    $description = 'Order Value Bonus (Above 500) - Order no ' . $order->id;
		    $points_added = self::$order_value_bonus_500;
		}
                else if($actual_paid >= 250)
		{
		    $description = 'Order Value Bonus (Above 250) - Order no ' . $order->id;
		    $points_added = self::$order_value_bonus_250;
		}
                else if($actual_paid >= 150)
		{
		    $description = 'Order Value Bonus (Above 150) - Order no ' . $order->id;
		    $points_added = self::$order_value_bonus_150;
		}
		
		if($points_added)
			VBRewards::addRewardPoints($id_customer, $id_event, self::$id_rule, $points_added, $description, $order->id, $date_add);
	}
	
	public function processCancel($db, $message)
	{
		echo "processing cancel order_value_bonus : " . PHP_EOL;
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
		
		if($points_removed)
		VBRewards::removeRewardPoints($id_customer, $id_event, self::$id_rule, $points_removed, 'Order Cancelled - Value Bonus reverted', $reference, $date_add);
	}
	
}
?>