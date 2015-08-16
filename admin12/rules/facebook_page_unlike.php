<?php
include_once ('rules_base.php');

class facebook_page_unlike extends rule_base
{

    public static $facebook_page_like_points = null;

    public static $id_rule = 20;

    public function init ($db)
    {
        if (self::$facebook_page_like_points)
            return;
        
        $rulesConfigs = $db->ExecuteS("SELECT id, name, value FROM vb_rule_config WHERE id = " . RewardRules::FACEBOOK_PAGE_LIKE_POINTS);
        
        self::$facebook_page_like_points = $rulesConfigs[0]["value"];
    }

    public function processEvent ($db, $message)
    {
        echo "processing facebook_page_unlike . " . self::$facebook_page_like_points . PHP_EOL;
        
        $id_customer = $message['id_customer'];
        $id_event = $message['id_event'];
        $date_add = $message['date_event'];
        $reference = $message['reference'];
        
        $result = $db->getRow(" select 
                                    count(*) as 'page_likes'
                                from 
                                    vb_customer_rewards
				where 
                                    id_customer = " . $id_customer . "
                                    and id_event = " . EVENT_FACEBOOK_PAGE_LIKE);
        $page_likes = (int)$result['page_likes'];
        $result = $db->getRow(" select 
                                    count(*) as 'page_unlikes'
                                from 
                                    vb_customer_rewards
				where 
                                    id_customer = " . $id_customer . "
                                    and id_event = " . EVENT_FACEBOOK_PAGE_UNLIKE);
        $page_unlikes = (int)$result['page_unlikes'];
        
        if( $page_likes - $page_unlikes === 1)
            VBRewards::removeRewardPoints($id_customer, $id_event, self::$id_rule, self::$facebook_page_like_points, 'Facebook Unlike of Indusdiva Page', $reference, $date_add);
           
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