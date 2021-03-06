<?php

include_once('rules_base.php');

class wishlist_product_share extends rule_base {

    public static $id_rule = 18;
    public static $wishlist_product_facebook_share_points = null;

    public function init($db) {
        if (self::$wishlist_product_facebook_share_points)
            return;
        $rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::WISHLIST_PRODUCT_FACEBOOK_SHARE_POINTS);
        self::$wishlist_product_facebook_share_points = $rulesConfigs[0]["value"];
    }

    public function processEvent($db, $message) {
        echo "processing wishlist_product_facebook_share";

        $id_customer = $message['id_customer'];
        $id_event = $message['id_event'];
        $date_add = $message['date_event'];
        $reference = (int) $message['reference'];




        $result = $db->getRow("select 
                                        count(*) as processed
                                    from 
                                        vb_customer_rewards
                                    where 
                                        reference = " . $reference . "
                                        and id_customer = " . $id_customer . "
                                        and id_event = " . EVENT_WISHLIST_PRODUCT_FACEBOOK_SHARE);

        //Feedback reward for this order is already processed
        if ((int) $result['processed'] === 1)
            return false;

        $result = $db->getRow("select 
                                        sum(points_awarded) points_awarded, sum(points_deducted) points_deducted
                                    from 
                                        vb_customer_rewards
                                    where 
                                        id_customer = " . $id_customer . "
                                        and id_event = " . EVENT_WISHLIST_PRODUCT_FACEBOOK_SHARE );
        
        $points_awarded = (int) $result['points_awarded'];
        $points_deducted = (int) $result['points_deducted'];
        $total_points_awarded = $points_awarded - $points_deducted;
        
        //limit for points awarded is reached 
        if ($total_points_awarded >= (25 * self::$wishlist_product_facebook_share_points))
            return false;

        /*$todayPoints = $this->getTodaysWLSharePoints($db, $id_customer);

        if (!$todayPoints) {
            VBRewards::addRewardPoints($id_customer, $id_event, self::$id_rule, self::$wishlist_product_facebook_share_points, 'Wishlist Product Share', $reference, $date_add);
            return true;
        }

        $todayRewardId = (int) $todayPoints['id_reward'];
        $todayTotalPoints = (int) $todayPoints['points_awarded'] + self::$wishlist_product_facebook_share_points;
        $todayBalance = VBRewards::getCustomerPoints($id_customer) + self::$wishlist_product_facebook_share_points;

        $db->Execute(
                "UPDATE vb_customer_rewards 
						SET points_awarded = " . $todayTotalPoints . ", 
						balance = " . $todayBalance . "
						WHERE id_reward = " . $todayRewardId);

        $db->Execute("UPDATE vb_customer_reward_balance 
						SET balance = " . $todayBalance . "
						WHERE id_customer = " . (int) $id_customer);

                                               
         
         */
        VBRewards::addRewardPoints($id_customer, $id_event, self::$id_rule, self::$wishlist_product_facebook_share_points, 'Wishlist Product Share', $reference, $date_add);
        return true;
    }

    /* (non-PHPdoc)
     * @see rule_base::processCancel()
     */

    public function processCancel($db, $event) {
        // TODO Auto-generated method stub
    }
    
    public function getTodaysWLSharePoints ($db, $id_customer)
    {
        // get todays
        $result = $db->getRow(
                "select id_reward, points_awarded, balance
								from vb_customer_rewards
								where id_customer = " . $id_customer . "
								and id_event = " . EVENT_WISHLIST_PRODUCT_FACEBOOK_SHARE . "
								and date(date_add) = curdate()");
        if (! $result)
            return 0;
        
        return $result;
    }

}

?>