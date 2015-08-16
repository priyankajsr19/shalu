<?php
include_once('rules_base.php');
class order_cancelled extends rule_base {
	
	public static $id_rule = 14;
	public static $valid_order_points = null;
	
	public function init($db)
	{
		
	}
	
	public function processEvent($db, $message) {
		echo "processing order_cancelled";
		
		$id_customer = $message['id_customer'];
		$id_event = $message['id_event'];
		$date_add = $message['date_event'];
		$order = new Order((int)$message['reference']);
		
		//remove ordervalue reward
		$valid_order_rule = RewardRules::getRule('valid_order');
		$valid_order_rule->init($db);
		$valid_order_rule->processCancel($db, $message);
		
		//remove ordervalue reward
		$first_order_bonus_rule = RewardRules::getRule('first_order_bonus');
		$first_order_bonus_rule->init($db);
		$first_order_bonus_rule->processCancel($db, $message);
		
		//remove ordervalue reward
		$order_value_bonus_rule = RewardRules::getRule('order_value_bonus');
		$order_value_bonus_rule->init($db);
		$order_value_bonus_rule->processCancel($db, $message);
		
		//remove ordervalue reward
		$referral_order_points_rule = RewardRules::getRule('referral_order_points');
		$referral_order_points_rule->init($db);
		$referral_order_points_rule->processCancel($db, $message);
		
		//remove ordervalue reward
		$referral_order_bonus_rule = RewardRules::getRule('referral_order_bonus');
		$referral_order_bonus_rule->init($db);
		$referral_order_bonus_rule->processCancel($db, $message);
		
	}
/* (non-PHPdoc)
     * @see rule_base::processCancel()
     */
    public function processCancel ($db, $event)
    {
        // TODO Auto-generated method stub
        
    }

	
}
?>