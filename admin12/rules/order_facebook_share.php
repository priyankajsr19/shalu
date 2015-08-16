<?php
include_once('rules_base.php');
class order_facebook_share extends rule_base {
	
    public static $id_rule = 17;
    public static $order_facebook_share_points = null;

    public function init($db)
    {
        if (self::$order_facebook_share_points)
            return;
        $rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::ORDER_FACEBOOK_SHARE_POINTS);
        self::$order_facebook_share_points = $rulesConfigs[0]["value"];
    }

    public function processEvent($db, $message) {
            echo "processing order_facebook_share";

            $id_customer = $message['id_customer'];
            $id_event = $message['id_event'];
            $date_add = $message['date_event'];
            $reference = (int) $message['reference'];
            $order = new Order($reference);

            //this order facebook share is not from the same customer who placed this order
            if( (int)$order->id_customer != (int)$id_customer )
                return false;

            
            $result = $db->getRow( "select 
                                        count(*) as processed
                                    from 
                                        vb_customer_rewards
                                    where 
                                        reference = " . $reference . "
                                        and id_customer = " . $id_customer . "
                                        and id_event = " . EVENT_ORDER_FACEBOOK_SHARE);
            
            //Feedback reward for this order is already processed
            if( (int)$result['processed'] === 1)
                return false;

            VBRewards::addRewardPoints($id_customer, $id_event, self::$id_rule, self::$order_facebook_share_points, "Share Order Products on Facebook (Order - {$reference})", $reference, $date_add);
            
            return true;
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