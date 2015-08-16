<?php
include_once ('rules_base.php');

class google_plus_click extends rule_base
{

    public static $google_plus_click_points = null;

    public static $id_rule = 5;

    public function init ($db)
    {
        if (self::$google_plus_click_points)
            return;
        
        $rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::GOOGLE_PLUS_CLICK_POINTS);
        
        self::$google_plus_click_points = $rulesConfigs[0]["value"];
    }

    public function processEvent ($db, $message)
    {
        echo "processing google_plus_click : " . self::$google_plus_click_points;
        
        $id_customer = $message['id_customer'];
        $id_event = $message['id_event'];
        $date_add = $message['date_event'];
        $reference = $message['reference'];
        
        $result = $db->getRow(
                "select sum(points_awarded) as 'total_points'
								from vb_customer_rewards
								where id_customer = " . $id_customer . "
								and id_event = " . EVENT_GOOGLE_LIKE);
        
        if (! $result || $result['total_points'] == 0)
        {
            VBRewards::addRewardPoints($id_customer, $id_event, self::$id_rule, self::$google_plus_click_points, 'Google Plus Share', $reference, $date_add);
            return true;
        }
        else
            $points_awarded = (int) $result['total_points'];
        
        $result = $db->getRow(
                "select sum(points_deducted) as 'total_points'
								from vb_customer_rewards
								where id_customer = " . $id_customer . "
								and id_event = " . EVENT_GOOGLE_UNLIKE);
        
        if (! $result['total_points'] || $result['total_points'] == 0)
            $points_deducted = 0;
        else
            $points_deducted = (int) $result['total_points'];
        
        if ($points_awarded - $points_deducted >= 25 * self::$google_plus_click_points)
        {
            echo 'total points limit reached';
            return;
        }
        
        $todayPoints = $this->getTodaysGPlusPoints($db, $id_customer);
        
        if (! $todayPoints)
        {
            VBRewards::addRewardPoints($id_customer, $id_event, self::$id_rule, self::$google_plus_click_points, 'Google Plus Share', $reference, $date_add);
            return true;
        }
        
        $todayRewardId = (int) $todayPoints['id_reward'];
        $todayTotalPoints = (int) $todayPoints['points_awarded'] + self::$google_plus_click_points;
        $todayBalance = VBRewards::getCustomerPoints($id_customer) + self::$google_plus_click_points;
        
        $db->Execute(
                "UPDATE vb_customer_rewards 
						SET points_awarded = " . $todayTotalPoints . ", 
						balance = " . $todayBalance . "
						WHERE id_reward = " . $todayRewardId);
        
        $db->Execute("UPDATE vb_customer_reward_balance 
						SET balance = " . $todayBalance . "
						WHERE id_customer = " . (int) $id_customer);
        
        return true;
    }

    /**
     * @param Db $db
     * @param unknown_type $id_customer
     * @return number|Ambiguous
     */
    public function getTodaysGPlusPoints ($db, $id_customer)
    {
        // get todays
        $result = $db->getRow(
                "select id_reward, points_awarded, balance
								from vb_customer_rewards
								where id_customer = " . $id_customer . "
								and id_event = " . EVENT_GOOGLE_LIKE . "
								and date(date_add) = curdate()");
        if (! $result)
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