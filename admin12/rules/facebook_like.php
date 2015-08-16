<?php
include_once ('rules_base.php');

class facebook_like extends rule_base
{

    public static $facebook_like_points = null;

    public static $id_rule = 4;

    public function init ($db)
    {
        if (self::$facebook_like_points)
            return;
        
        $rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::FACEBOOK_LIKE_POINTS);
        
        self::$facebook_like_points = $rulesConfigs[0]["value"];
    }

    public function processEvent ($db, $message)
    {
        echo "processing facebook_like . " . self::$facebook_like_points . PHP_EOL;
        
        $id_customer = $message['id_customer'];
        $id_event = $message['id_event'];
        $date_add = $message['date_event'];
        $reference = $message['reference'];
        
        $result = $db->getRow(
                "select sum(points_awarded) as 'total_points'
								from vb_customer_rewards
								where id_customer = " . $id_customer . "
								and id_event = " . EVENT_FACEBOOK_LIKE);
        
        if (! $result || $result['total_points'] == 0)
        {
            VBRewards::addRewardPoints($id_customer, $id_event, self::$id_rule, self::$facebook_like_points, 'Facebook Like', $reference, $date_add);
            return true;
        }
        else
            $points_awarded = (int) $result['total_points'];
        
        $result = $db->getRow(
                "select sum(points_deducted) as 'total_points'
								from vb_customer_rewards
								where id_customer = " . $id_customer . "
								and id_event = " . EVENT_FACEBOOK_UNLIKE);
        
        if (! $result['total_points'] || $result['total_points'] == 0)
            $points_deducted = 0;
        else
            $points_deducted = (int) $result['total_points'];
        
        if ($points_awarded - $points_deducted >= 25 * self::$facebook_like_points)
        {
            echo 'total points limit reached';
            return;
        }
        
        $todayPoints = $this->getTodaysFacebookPoints($db, $id_customer);
        
        if (! $todayPoints)
        {
            VBRewards::addRewardPoints($id_customer, $id_event, self::$id_rule, self::$facebook_like_points, 'Facebook Like', $reference, $date_add);
            return true;
        }
        
        $todayRewardId = (int) $todayPoints['id_reward'];
        $todayTotalPoints = (int) $todayPoints['points_awarded'] + self::$facebook_like_points;
        $todayBalance = VBRewards::getCustomerPoints($id_customer) + self::$facebook_like_points;
        
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
     *
     * @param $db Db           
     */
    public function getTodaysFacebookPoints ($db, $id_customer)
    {
        // get todays
        $result = $db->getRow(
                "select id_reward, points_awarded, balance
								from vb_customer_rewards
								where id_customer = " . $id_customer . "
								and id_event = " . EVENT_FACEBOOK_LIKE . "
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