<?php

class VBRewardsCore {

    public static function addRewardPoints($id_customer, $id_event, $id_rule, $points, $description = null, $reference = 0, $date = false) {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);

        $current_balance = self::getCustomerPoints($id_customer);
        $new_balance = $current_balance + $points;

        if (!$date)
            $date = date('Y-m-d H:i:s');

        $db->Execute("
					INSERT INTO vb_customer_rewards (id_customer, id_event, id_rule, description, reference, date_add, points_awarded, balance)
					VALUES (" . $id_customer . ",
					" . $id_event . ",
					" . $id_rule . ",
					'" . $description . "',
					" . $reference . ",
					'" . $date . "',
					" . $points . ",
					" . $new_balance . " )");

        self::setCustomerPoints($id_customer, $new_balance);
    }

    public static function removeRewardPoints($id_customer, $id_event, $id_rule, $points, $description = null, $reference = 0, $date = false) {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);

        $current_balance = self::getCustomerPoints($id_customer);
        $new_balance = $current_balance - $points;

        if (!$date)
            $date = date('Y-m-d H:i:s');

        $db->Execute("
					INSERT INTO vb_customer_rewards (id_customer, id_event, id_rule, description, reference, date_add, points_deducted, balance)
					VALUES (" . $id_customer . ",
					" . $id_event . ",
					" . $id_rule . ",
					'" . $description . "',
					" . $reference . ",
					'" . $date . "',
					" . $points . ",
					" . $new_balance . " )");

        self::setCustomerPoints($id_customer, $new_balance);
    }

    public static function getCustomerPoints($id_customer) {
        $result = Db::getInstance()->getRow('
		SELECT balance
		FROM vb_customer_reward_balance
		WHERE id_customer = ' . $id_customer);

        if (!$result) {
            Db::getInstance()->Execute("
					INSERT INTO vb_customer_reward_balance (id_customer, balance)
					VALUES (" . $id_customer . ", 0)");
            return false;
        }

        return (int) $result['balance'];
    }

    public static function getCustomerPointsRedeemed($id_customer) {
        $result = Db::getInstance()->getRow("
		SELECT sum(points_deducted) as 'redeemed'
		FROM vb_customer_rewards
		WHERE id_event = " . EVENT_POINTS_REDEEMED . " AND id_customer = " . $id_customer);

        return (int) $result['redeemed'];
    }

    public static function getCustomerPointsEarned($id_customer) {
        $result = Db::getInstance()->getRow("
		SELECT sum(points_awarded) as 'awarded', sum(points_deducted) as 'deducted'
		FROM vb_customer_rewards
		WHERE id_event <> " . EVENT_POINTS_REDEEMED . " AND id_customer = " . $id_customer);

        return (int) $result['awarded'] - (int) $result['deducted'];
    }

    public static function setCustomerPoints($id_customer, $points) {
        Db::getInstance()->Execute("
					UPDATE vb_customer_reward_balance
					SET balance = " . $points . "
					WHERE id_customer = " . $id_customer);
    }

    public static function checkPointsValidity($id_customer, $points, $orderTotal) {
        $valid_order_count = Customer::getValidOrders($id_customer);
        if ((int) $valid_order_count === 0)
            return INSUFFICIENT_VALID_ORDERS;
        if ($orderTotal < 100)
            return MIN_CRITERIA_NOT_MET;
        $points = (int) $points;
        $total_available_points = self::getCustomerPoints($id_customer);

        if ($total_available_points >= $points && $points >= 0) {
            return CAN_REDEEM_COINS;
        }

        return CANNOT_REDEEM_COINS;
    }

    public static function addRegistrationPoints($id_customer) {
        $result = Db::getInstance()->getRow("
                select count(*) as processed from vb_customer_rewards
		WHERE id_event = " . EVENT_REGISTRATION . " AND id_customer = " . $id_customer);
        if ((int) $result['processed'] === 0) {
            self::addRewardPoints($id_customer, EVENT_REGISTRATION, 0, 50, 'Registration/Sign-up', $id_customer, date('Y-m-d H:i:s'));
            return true;
        }
        return false;
    }

}

