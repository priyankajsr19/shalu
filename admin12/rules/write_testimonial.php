<?php
include_once('rules_base.php');
class write_testimonial extends rule_base {
	
    public static $id_rule = 15;
    public static $write_testimonial_points = null;

    public function init($db)
    {
        if (self::$write_testimonial_points)
            return;
        $rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::WRITE_TESTIMONIAL_POINTS);
        self::$write_testimonial_points = $rulesConfigs[0]["value"];
    }

    public function processEvent($db, $message) {
            echo "processing write_testimonial";

            $id_customer = $message['id_customer'];
            $id_event = $message['id_event'];
            $date_add = $message['date_event'];
            $reference = (int) $message['reference'];
            
            // only one entry per day ( for multiple order feedbacks also ) 
            $todayPoints = $this->getTodaysTestimonialPoints($db, $id_customer);

            if (! $todayPoints) {
                VBRewards::addRewardPoints($id_customer, $id_event, self::$id_rule, self::$write_testimonial_points, 'For Writing Testimonial', $reference, $date_add);
                return true;
            }

            $todayRewardId = (int) $todayPoints['id_reward'];
            $todayTotalPoints = (int) $todayPoints['points_awarded'] + self::$write_testimonial_points;
            $todayBalance = VBRewards::getCustomerPoints($id_customer) + self::$write_testimonial_points;

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
        
    public function getTodaysTestimonialPoints ($db, $id_customer) {
        // get todays
        $result = $db->getRow(" select
                                    id_reward, 
                                    points_awarded, 
                                    balance
                                from 
                                    vb_customer_rewards
				where   id_customer = " . $id_customer . " and 
                                        id_event = " . EVENT_WRITE_TESTIMONIAL . " and 
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