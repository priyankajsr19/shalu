<?php
abstract class rule_base{
	/**
	 * @param Db $db
	 * @param Mixed $event
	 */
	abstract public function processEvent($db, $event);
	
	/**
	 * @param Db $db
	 * @param Mixed $event
	 */
	abstract public function processCancel($db, $event);
	
	/**
	 * @param Db $db
	 */
	abstract public function init($db);
	
	public static function rewardExistsForReference($id_customer, $id_event, $id_rule, $reference)
	{
		if(!$reference)
			return false;
			
		$result = Db::getInstance()->getRow('
			SELECT id_reward
			FROM vb_customer_rewards
			WHERE id_customer = ' . $id_customer .
			' AND id_event = ' . $id_event .
			' AND id_rule = ' . $id_rule .
			' AND reference = ' . $reference);

		if (!$result)
			return false;
		else
			return true;
	}
	
	public static function getReward($id_customer, $id_event, $id_rule, $reference)
	{
		if(!$reference)
			return null;
			
		$result = Db::getInstance()->getRow('
			SELECT id_reward, points_awarded, points_deducted
			FROM vb_customer_rewards
			WHERE id_customer = ' . $id_customer .
			' AND id_event = ' . $id_event .
			' AND id_rule = ' . $id_rule .
			' AND reference = ' . $reference );

		if (!$result)
			return null;
		else
			return $result;
	}
}

class RewardRules
{
	const REGISTRATION_POINTS = 1;
	const VALID_ORDER_POINTS = 2;
	const VALID_ORDER_BONUS_FIRST = 3;
	//const VALID_ORDER_BONUS_1000 = 4;
	const VALID_ORDER_BONUS_2500 = 5;
	const VALID_ORDER_BONUS_5000 = 6;
	const APPROVED_REVIEW_POINTS = 7;
	const APPROVED_REVIEW_BONUS_FIRST = 8;
	const FACEBOOK_LIKE_POINTS = 9;
	const GOOGLE_PLUS_CLICK_POINTS = 10;
	const REFERRAL_FIRST_ORDER_POINTS = 11;
	const REFERRAL_ORDER_BONUS_10 = 12;
	const REFERRAL_ORDER_BONUS_25 = 13;
	const ONLINE_PAY_BONUS = 14;
        const ORDER_FEEDBACK_POINTS = 15;
        const WRITE_TESTIMONIAL_POINTS = 16;
        const ORDER_FACEBOOK_SHARE_POINTS = 17;
        const VALID_ORDER_BONUS_1500 = 18;
	const VALID_ORDER_BONUS_1000 = 19;
	const VALID_ORDER_BONUS_750 = 20;
        const VALID_ORDER_BONUS_500 = 21;
        const VALID_ORDER_BONUS_250 = 22;
        const VALID_ORDER_BONUS_150 = 23;
	const WISHLIST_PRODUCT_FACEBOOK_SHARE_POINTS = 24;
        const FACEBOOK_PAGE_LIKE_POINTS = 25;
	
    /**
     * @param unknown_type $type
     * @return rule_base 
     */
    public static function getRule($type)
    {
        if (include_once $type . '.php') {
            $classname = $type;
            return new $classname;
        } else {
            echo 'class not found';
        }
    }
}
?>