<?php
include_once('rules_base.php');
class product_review_approved extends rule_base {
	
	public static $product_review_points = null;
	public static $id_rule = 3;
	
	public function init($db)
	{
		if(self::$product_review_points) return;
		
		$rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::APPROVED_REVIEW_POINTS);
		
		self::$product_review_points = $rulesConfigs[0]["value"];
	}
	
	public function processEvent($db, $message) {
		echo "processing product_review_approved : " . self::$product_review_points;
		
		$id_customer = $message['id_customer'];
		$id_event = $message['id_event'];
		$date_add = $message['date_event'];
		$reference = $message['reference'];
		
		/*
                if($this->getTotalReviewPoints($db, $id_customer) > 2500)
		    return;
		*/
		if(self::rewardExistsForReference($id_customer, $id_event, self::$id_rule, $message['reference']))
		{	
			echo 'skipping processed reward' . PHP_EOL;
			return;
		}
		
		$points_added = self::$product_review_points;
		
		$product_name = $this->getProductName($db, (int)$reference);
		
		VBRewards::addRewardPoints($id_customer, $id_event, self::$id_rule, $points_added, 'Product Review - ' . $product_name, $reference, $date_add);
	}
/* (non-PHPdoc)
     * @see rule_base::processCancel()
     */
    public function processCancel ($db, $event)
    {
        // TODO Auto-generated method stub
        
    }
    
    /**
     * @param Db $db
     * @param int $id_customer
     * @return number
     */
    public function getTotalReviewPoints ($db, $id_customer)
    {
        // get todays
        $result = $db->getRow(
                "select sum(points_awarded) as 'total_points'
                from vb_customer_rewards
                where id_customer = " . $id_customer . "
                and id_event = " . EVENT_REVIEW_APPROVED);
        if (! $result)
            return 0;
    
        return (int)$result['total_points'];
    }
    
    /**
     * @param Db $db
     * @param unknown_type $id_product
     */
    public function getProductName ($db, $id_product)
    {
        $res = $db->getRow("SELECT name FROM ps_product_lang WHERE id_product = " . $id_product);
        if(!$res) return "";
        
        return $res['name'];
    }
	
}
?>