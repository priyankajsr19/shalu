<?php
require_once(PS_ADMIN_DIR.'/rules/rules_base.php');
require_once(PS_ADMIN_DIR.'/rules/product_review_approved.php');
class AdminReferrals extends AdminTab
{
	public function postProcess()
	{
		global $currentIndex, $cookie, $smarty;
		
		if(Tools::getValue('getReferrerData'))
		{
		    $id_referrer = Tools::getValue('referrer');
		    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("
		            select o.id_order, concat(c.firstname, ' ', c.lastname) as 'name', concat(a.`address1`, a.`address2`) as 'address', a.`phone_mobile`, o.`total_paid`, date(c.date_add) as 'date_register'
                    from ps_orders o 
                    inner join ps_customer c on o.id_customer = c.id_customer
                    inner join ps_address a on a.`id_address` = o.`id_address_delivery`
                    where o.id_customer in (select id_customer from ps_customer where id_referrer = " . $id_referrer . ")
		            ");
		    $smarty->assign('referredOrders', $res);
		    
		    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("
		            select id_customer, concat(firstname, ' ', lastname) as 'name', date(date_add) as 'date_add' from ps_customer where id_referrer = " . $id_referrer);
		    $smarty->assign('referredCustomers', $res);
		    
		    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("
		            select concat(c.firstname, ' ', c.lastname) as 'name', count(*) as 'total_orders', sum(o.total_paid) as 'total_paid' from ps_orders o 
                    inner join `ps_order_history` oh on oh.id_order = o.id_order
                    inner join ps_customer c on c.id_customer = o.id_customer
                    where o.id_customer = " . $id_referrer . "
                    and oh.id_order_history = (select max(id_order_history) from ps_order_history where id_order = o.id_order)
                    and oh.id_order_state not in (6, 14, 20)
		            ");
		    $smarty->assign('referrer_details', $res[0]);
		    
		    $smarty->assign('orderToken', Tools::getAdminToken('AdminOrders'.(int)(Tab::getIdFromClassName('AdminOrders')).(int)($cookie->id_employee)));
		}
		
		$date_from = Tools::getValue('date_from', date('Y-n-j'));
	    $date_to = Tools::getValue('date_to', date('Y-n-j'));
		
		$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("
		        select c.id_customer `customerID`, concat(c.firstname, ' ', c.lastname) as `name`, 
                count(distinct(c2.id_customer)) as 'total_registered',
                count(o.id_order) as 'total_orders',
                count(distinct(o.id_customer)) as 'total_friends_orders',
                round(coalesce(avg(o.total_paid), 0)) as 'avg_order'
                from ps_customer c
                inner join ps_customer c2 on c.id_customer = c2.id_referrer
                left join ps_orders o on o.id_customer = c2.id_customer
		        inner join `ps_order_history` oh on oh.id_order = o.id_order
                where date(c2.`date_add`) between '" . $date_from . "' and '" . $date_to . "'
		        and  oh.id_order_history = (SELECT MAX(`id_order_history`) FROM `ps_order_history` moh WHERE moh.`id_order` = o.`id_order` GROUP BY moh.`id_order`)
				and oh.id_order_state not in (6,8,20)
                group by c.id_customer  
		        ");
		
		$friends_shopped = array();
		$avg_order = array();
		
		foreach ($res as $key => $row) {
		    $friends_shopped[$key]  = $row['total_friends_orders'];
		    $avg_order[$key] = $row['avg_order'];
		}
		
		array_multisort($friends_shopped, SORT_DESC, $avg_order, SORT_ASC, $res);
		
		$smarty->assign('date_from', $date_from);
		$smarty->assign('date_to', $date_to);
		$smarty->assign('referrals', $res);
		$smarty->assign('token', $this->token);
		$smarty->assign('customerToken', Tools::getAdminToken('AdminCustomers'.(int)(Tab::getIdFromClassName('AdminCustomers')).(int)($cookie->id_employee)));
	}
	
	public function display()
	{
		global $smarty;
		$smarty->display(_PS_THEME_DIR_.'admin/referrals.tpl');
	}
}






