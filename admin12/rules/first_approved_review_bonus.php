<?php
include_once('rules_base.php');
class first_approved_review_bonus extends rule_base {
	
	public static $first_review_bonus = null;
	public static $id_rule = 9; 
	
	public function init($db)
	{
		if(self::$first_review_bonus) return;
		
		$rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::APPROVED_REVIEW_BONUS_FIRST);
		
		self::$first_review_bonus = $rulesConfigs[0]["value"];
	}
	
	public function processEvent($db, $message) {
               	return true; 
		echo "processing first_approved_review_bonus : ";
		
		$id_customer = $message['id_customer'];
		$id_event = $message['id_event'];
		$date_add = $message['date_event'];
		$reference = $message['reference'];
		
		if(self::rewardExistsForReference($id_customer, $id_event, self::$id_rule, $message['reference']))
		{	
			echo 'skipping processed reward' . PHP_EOL;
			return;
		}
		
		//get the number of approved reviews
		$result = Db::getInstance()->getRow("select count(*) as 'total_approved' from ps_product_comment where validate = 1 and id_customer = " . $id_customer);
		if($result['total_approved'] == 1)
		{
			$points_added = self::$first_review_bonus;
			VBRewards::addRewardPoints($id_customer, $id_event, self::$id_rule, $points_added, 'Product Review - First review bonus', $reference, $date_add);
		}
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
