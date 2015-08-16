<?php
include_once('rules_base.php');
class order_feedback extends rule_base {
	
    public static $id_rule = 15;
    public static $order_feedback_points = null;

    public function init($db)
    {
        if (self::$order_feedback_points)
            return;
        $rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::ORDER_FEEDBACK_POINTS);
        self::$order_feedback_points = $rulesConfigs[0]["value"];
    }

    public function processEvent($db, $message) {
            echo "processing order_feedback";

            $id_customer = $message['id_customer'];
            $id_event = $message['id_event'];
            $date_add = $message['date_event'];
            $reference = (int) $message['reference'];
            $order = new Order($reference);

            //this order feedback is not from the same customer who placed this order
            if( (int)$order->id_customer != (int)$id_customer )
                return false;

            $result = $db->getRow( "select 
                                        count(*) as processed
                                    from 
                                        vb_customer_rewards
                                    where 
                                        reference = " . $reference . "
                                        and id_customer = " . $id_customer . "
                                        and id_event = " . EVENT_ORDER_FEEDBACK);

            //Feedback reward for this order is already processed
            if( (int)$result['processed'] === 1)
                return false;

            // only one entry per day ( for multiple order feedbacks also ) 
            $todayPoints = $this->getTodaysOrderFeedbackPoints($db, $id_customer);

            if ( $todayPoints === 0) {
                VBRewards::addRewardPoints($id_customer, $id_event, self::$id_rule, self::$order_feedback_points, 'Order Feedback', $reference, $date_add);
                return true;
            }

            $todayRewardId = (int) $todayPoints['id_reward'];
            $todayTotalPoints = (int) $todayPoints['points_awarded'] + self::$order_feedback_points;
            $todayBalance = VBRewards::getCustomerPoints($id_customer) + self::$order_feedback_points;

            $db->Execute("  UPDATE
                                vb_customer_rewards 
                            SET 
                                points_awarded = " . $todayTotalPoints . ", balance = " . $todayBalance . "
                            WHERE 
                                id_reward = " . $todayRewardId);

            $db->Execute("  UPDATE 
                                vb_customer_reward_balance 
                            SET 
                                balance = " . $todayBalance . "
                            WHERE 
                                id_customer = " . (int) $id_customer);

            return true;
    }
        
    public function getTodaysOrderFeedbackPoints ($db, $id_customer) {
        // get todays
        $result = $db->getRow(" select
                                    id_reward, 
                                    points_awarded, 
                                    balance
                                from 
                                    vb_customer_rewards
				where   id_customer = " . $id_customer . " and 
                                        id_event = " . EVENT_ORDER_FEEDBACK . " and 
                                        date(date_add) = curdate()");
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
