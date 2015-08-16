<?php
include_once('rules_base.php');
class facebook_unlike extends rule_base {
	
	public static $facebook_like_points = null;
	public static $id_rule = 12;
	
	/* (non-PHPdoc)
	 * @see rule_base::init()
	 */
	public function init($db)
	{
		if(self::$facebook_like_points) return;
		
		$rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::FACEBOOK_LIKE_POINTS);
		
		self::$facebook_like_points = $rulesConfigs[0]["value"];
	}
	
	public function processEvent($db, $message) {
		echo "processing facebook_unlike : " . self::$facebook_like_points;
		
		$id_customer = $message['id_customer'];
		$id_event = $message['id_event'];
		$date_add = $message['date_event'];
		$reference = $message['reference'];
		
		$todayPoints = $this->getTodaysFacebookPoints($db, $id_customer);
		
		if(!$todayPoints)
		{
			VBRewards::removeRewardPoints($id_customer, $id_event, self::$id_rule, self::$facebook_like_points, 'Facebook Unlike', $reference, $date_add);
			return;
		}
		
		$todayRewardId = (int)$todayPoints['id_reward'];
		$todayTotalPoints = (int)$todayPoints['points_deducted']  + self::$facebook_like_points;
		$todayBalance = VBRewards::getCustomerPoints($id_customer)  - self::$facebook_like_points;
		
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
	 * @param int $id_customer
	 * @return number|Ambiguous
	 */
	public function getTodaysFacebookPoints($db, $id_customer)
	{
		//get todays
		$result = $db->getRow("select id_reward, points_deducted, balance
								from vb_customer_rewards
								where id_customer = " . $id_customer . "
								and id_event = " . EVENT_FACEBOOK_UNLIKE . "
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