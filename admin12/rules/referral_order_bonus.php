<?php
include_once('rules_base.php');
class referral_order_bonus extends rule_base {
	
	public static $referral_order_bonus_10 = null;
	public static $referral_order_bonus_25 = null;
	public static $id_rule = 10;
	
	public function init($db)
	{
		if(self::$referral_order_bonus_10) return;
		
		$rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::REFERRAL_ORDER_BONUS_10);
		self::$referral_order_bonus_10 = $rulesConfigs[0]["value"];
		
		$rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::REFERRAL_ORDER_BONUS_25);
		self::$referral_order_bonus_25 = $rulesConfigs[0]["value"];
	}
	
	public function processEvent($db, $message) {
		echo "processing referral_order_bonus : " . self::$referral_order_bonus_10 . " : " . self::$referral_order_bonus_25;
		
		$id_customer = $message['id_customer'];
		$id_event = $message['id_event'];
		$reference = $message['reference'];
		$date_add = $message['date_event'];
		
		if(Customer::getTotalDeliveredForCustomer($id_customer) == 1)
		{
			$customer = new Customer($id_customer);
			if(!$customer->id_referrer)
				return;
			$id_referrer = $customer->id_referrer;
			
			//get total reffered order for this referrer
			$referrals = Customer::getCustomerReferrals($id_referrer);
			$countReferredOrders = 0;
			
			foreach($referrals as $referral)
			{
				if($referral['total_delivered'] > 0) $countReferredOrders++;
			}
			
			$points_added = 0;
			$description = '';
			if($countReferredOrders == 10)
			{
			    $description = 'Bonus Points - 10 friends referred';
			    $points_added = self::$referral_order_bonus_10;
			}
			/*else if($countReferredOrders == 25)
			{
			    $description = 'Bonus Points - 25 friends referred';
			    $points_added = self::$referral_order_bonus_25;
			}*/
			
			if(self::rewardExistsForReference($id_referrer, $id_event, self::$id_rule, $reference))
			{	
				echo 'skipping processed reward' . PHP_EOL;
				return;
			}
			
			if($points_added)
				VBRewards::addRewardPoints($id_referrer, $id_event, self::$id_rule, $points_added, $description, $reference, $date_add);
		}
	}
	
	public function processCancel($db, $message)
	{
		echo "processing cancel referral_order_bonus : " . PHP_EOL;
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
			
			//get total reffered order for this referrer
			$referrals = Customer::getCustomerReferrals($id_referrer);
			$countReferredOrders = 0;
			
			foreach($referrals as $referral)
			{
				if($referral['total_delivered'] > 0) $countReferredOrders++;
			}
			
			$points_removed = 0;
			if($countReferredOrders == 9)
				$points_removed = self::$referral_order_bonus_10;
			else if($countReferredOrders == 24)
				$points_removed = self::$referral_order_bonus_25;
			
			if(self::rewardExistsForReference($id_referrer, $id_event, self::$id_rule, $reference))
			{	
				echo 'skipping processed reward' . PHP_EOL;
				return;
			}
			
			$order = new Order((int)$reference);
			$referred_customer = new Customer($order->id_customer);
			
			if($points_removed)
				VBRewards::removeRewardPoints($id_referrer, $id_event, self::$id_rule, $points_removed, "First order by a friend cancelled - Bonus coins reverted -" . $referred_customer->email, $reference, $date_add);
		}
	}
	
}
?>