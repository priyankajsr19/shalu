<?php
include_once('rules_base.php');
class google_plus_remove_share extends rule_base {
	
	public static $google_plus_click_points = null;
	public static $id_rule = 13;
	
	public function init($db)
	{
		if(self::$google_plus_click_points) return;
		
		$rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::GOOGLE_PLUS_CLICK_POINTS);
		
		self::$google_plus_click_points = $rulesConfigs[0]["value"];
	}
	
	public function processEvent($db, $message) {
		echo "processing google_plus_click : " . self::$google_plus_click_points;
		
		$id_customer = $message['id_customer'];
		$id_event = $message['id_event'];
		$date_add = $message['date_event'];
		$reference = $message['reference'];
		
		$todayPoints = $this->getTodaysGPlusPoints($db, $id_customer);
		
		if(!$todayPoints)
		{
			VBRewards::removeRewardPoints($id_customer, $id_event, self::$id_rule, self::$google_plus_click_points, 'Google Plus unshare', $reference, $date_add);
			return;
		}
		
		$todayRewardId = (int)$todayPoints['id_reward'];
		$todayTotalPoints = (int)$todayPoints['points_deducted']  + self::$google_plus_click_points;
		$todayBalance = VBRewards::getCustomerPoints($id_customer)  - self::$google_plus_click_points;
		
		$db->Execute("UPDATE vb_customer_rewards 
						SET points_deducted = " . $todayTotalPoints . ", 
						balance = " . $todayBalance . "
						WHERE id_reward = " . $todayRewardId);
		
		$db->Execute("UPDATE vb_customer_reward_balance 
						SET balance = " . $todayBalance . "
						WHERE id_customer = " . $id_customer);
	}
	
	/**
	 * @param Db $db
	 * @param unknown_type $id_customer
	 * @return number|Ambiguous
	 */
	public function getTodaysGPlusPoints($db, $id_customer)
	{
		//get todays
		$result = $db->getRow("select id_reward, points_deducted, balance
								from vb_customer_rewards
								where id_customer = " . $id_customer . "
								and id_event = " . EVENT_GOOGLE_UNLIKE . "
								and date(date_add) = curdate()");
		if(!$result)
			return 0; 
		
		return $result;
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