<?php
include_once('rules_base.php');
class referral_order_points extends rule_base {
	
	public static $referral_order_points = null;
	public static $id_rule = 6;
	
	public function init($db)
	{
		if(self::$referral_order_points) return;
		
		$rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::REFERRAL_FIRST_ORDER_POINTS);
		
		self::$referral_order_points = $rulesConfigs[0]["value"];
	}
	
	public function processEvent($db, $message) 
	{
		echo "processing referral_order_points : " . self::$referral_order_points;
		
		$id_customer = $message['id_customer'];
		$id_event = $message['id_event'];
		$reference = (int)$message['reference'];
		$date_add = $message['date_event'];
		
		if(Customer::getTotalDeliveredForCustomer($id_customer) == 1)
		{
			$customer = new Customer($id_customer);
			if(!$customer->id_referrer)
				return;
			$id_referrer = $customer->id_referrer;
			$points_added = self::$referral_order_points;
			
			if(self::rewardExistsForReference($id_referrer, $id_event, self::$id_rule, $reference))
			{	
				echo 'skipping processed reward referral bonus' . PHP_EOL;
				return;
			}
			$order = new Order((int)$reference);
			$referred_customer = new Customer($order->id_customer);
			
			VBRewards::addRewardPoints($id_referrer, $id_event, self::$id_rule, $points_added, "First order by a friend - " . $referred_customer->email, $reference, $date_add);
                        VBRewards::addRewardPoints($id_customer, $id_event, self::$id_rule, $points_added, "First order through referral", $reference, $date_add);
			
		}
	}
	
	public function processCancel($db, $message)
	{
		echo "processing cancel referral_order_bonus : " . PHP_EOL;
		//echo "processing cancel referral_order_bonus : " . PHP_EOL;
		$id_customer = $message['id_customer'];
		$id_event = $message['id_event'];
		$date_add = $message['date_event'];
		$reference = $message['reference'];
		
		if(self::rewardExistsForReference($id_customer, $id_event, self::$id_rule, $message['reference']))
		{	
			echo 'skipping processed reward' . PHP_EOL;
			return;
		}
		
		if(Customer::getTotalDeliveredForCustomer($id_customer) == 0)
		{
			$customer = new Customer($id_customer);
			if(!$customer->id_referrer)
				return;
			$id_referrer = $customer->id_referrer;
			
			$reward = self::getReward($id_referrer, EVENT_ORDER_DELIVERED, self::$id_rule, $reference);
			if(!$reward) return;
			
			$points_removed = $reward['points_awarded'];
			
			if(self::rewardExistsForReference($id_referrer, $id_event, self::$id_rule, $reference))
			{	
				echo 'skipping processed reward' . PHP_EOL;
				return;
			}
			
			$order = new Order((int)$reference);
			$referred_customer = new Customer($order->id_customer);
			
			if($points_removed) {
				VBRewards::removeRewardPoints($id_referrer, $id_event, self::$id_rule, $points_removed, "First order by a friend cancelled - " . $referred_customer->email, $reference, $date_add);
                                VBRewards::removeRewardPoints($id_customer, $id_event, self::$id_rule, $points_removed, "First order points through referral cancelled - " . $referred_customer->email, $reference, $date_add);
                        }
		}
	}
	
}
?>