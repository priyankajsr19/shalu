<?php

define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');
include(PS_ADMIN_DIR.'/functions.php');
require_once(dirname(__FILE__).'/init.php');

function populateNumbers(&$aramexDetails, &$quantiumDetails, &$bluedartDetails, &$speedpostDetails, &$aflDetails, &$sabexDetails, $intervalStart, $intervalEnd, $slot)
{
	$startDate = '';
	$endDate = '';
	if($intervalEnd)
		$endDate = "and oh.`date_add` < subdate(now(), interval ".$intervalEnd." day)";
	if($intervalStart < 999)
		$startDate = "and oh.`date_add` > subdate(now(), interval ".$intervalStart." day)";
	$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("
				select o.`id_order`
				from ps_orders o
				inner join `ps_order_history` oh ON (oh.`id_order` = o.`id_order`) 
				where 1 
				".$startDate."
				".$endDate."
				and oh.`id_order_state` = 4
			");
	/*echo "
				select o.`id_order`
				from ps_orders o
				inner join `ps_order_history` oh ON (oh.`id_order` = o.`id_order`) 
				where 1 
				".$startDate."
				".$endDate."
				and oh.`id_order_state` = 4
			";*/
	//echo "<br>";
	$orderIds = array();
	foreach($res as $row)
		$orderIds[] = $row['id_order'];
	
	$res1 = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("
				select o.`id_order`, o.`id_carrier`, oh.`id_order_state`
				from ps_orders o
				inner join `ps_order_history` oh ON (oh.`id_order` = o.`id_order`) 
				where o.`id_order` in (".join(",", $orderIds).") 
				and oh.`id_order_state` = 4
	            group by o.id_order
			");
	$res2 = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("
				select o.`id_order`, o.`id_carrier`, oh.`id_order_state`
				from ps_orders o
				inner join `ps_order_history` oh ON (oh.`id_order` = o.`id_order`) 
				where o.`id_order` in (".join(",", $orderIds).") 
				and oh.`id_order_state` = 5
				and oh.`id_order_history` = (SELECT MAX(`id_order_history`) FROM `ps_order_history` moh WHERE moh.`id_order` = o.`id_order` GROUP BY moh.`id_order`)
			");
	$res3 = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("
				select o.`id_order`, o.`id_carrier`, oh.`id_order_state`
				from ps_orders o
				inner join `ps_order_history` oh ON (oh.`id_order` = o.`id_order`) 
				where o.`id_order` in (".join(",", $orderIds).") 
				and oh.`id_order_state` = 4
				and oh.`id_order_history` = (SELECT MAX(`id_order_history`) FROM `ps_order_history` moh WHERE moh.`id_order` = o.`id_order` GROUP BY moh.`id_order`)
	            group by o.id_order
			");
	
	
	foreach($res1 as $row)
	{
		if((int)$row['id_carrier'] == ARAMEX)
		{
			$aramexDetails[$slot]['shipped']++;
		}
		if((int)$row['id_carrier'] == QUANTIUM)
		{
			$quantiumDetails[$slot]['shipped']++;
		}
		if((int)$row['id_carrier'] == BLUEDART)
		{
			$bluedartDetails[$slot]['shipped']++;
		}
		if((int)$row['id_carrier'] == SPEEDPOST)
		{
			$speedpostDetails[$slot]['shipped']++;
		}
		if((int)$row['id_carrier'] == AFL)
		{
		    $aflDetails[$slot]['shipped']++;
		}
		if((int)$row['id_carrier'] == SABEXPRESS)
		{
		    $sabexDetails[$slot]['shipped']++;
		}
	}
	
	foreach($res2 as $row)
	{
		if((int)$row['id_carrier'] == ARAMEX)
		{
			$aramexDetails[$slot]['delivered']++;
		}
		if((int)$row['id_carrier'] == QUANTIUM)
		{
			$quantiumDetails[$slot]['delivered']++;
		}
		if((int)$row['id_carrier'] == BLUEDART)
		{
			$bluedartDetails[$slot]['delivered']++;
		}
		if((int)$row['id_carrier'] == SPEEDPOST)
		{
			$speedpostDetails[$slot]['delivered']++;
		}
		if((int)$row['id_carrier'] == AFL)
		{
		    $aflDetails[$slot]['delivered']++;
		}
		if((int)$row['id_carrier'] == SABEXPRESS)
		{
		    $sabexDetails[$slot]['delivered']++;
		}
	}
	foreach($res3 as $row)
	{
		if((int)$row['id_carrier'] == ARAMEX)
		{
			$aramexDetails[$slot]['undelivered']++;
		}
		if((int)$row['id_carrier'] == QUANTIUM)
		{
			$quantiumDetails[$slot]['undelivered']++;
		}
		if((int)$row['id_carrier'] == BLUEDART)
		{
			$bluedartDetails[$slot]['undelivered']++;
		}
		if((int)$row['id_carrier'] == SPEEDPOST)
		{
			$speedpostDetails[$slot]['undelivered']++;
		}
		if((int)$row['id_carrier'] == AFL)
		{
		    $aflDetails[$slot]['undelivered']++;
		}
		if((int)$row['id_carrier'] == SABEXPRESS)
		{
		    $sabexDetails[$slot]['undelivered']++;
		}
	}
}



global $smarty;

	$aramexDetails = array();
	$aramexDetails['twoday'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$aramexDetails['fourday'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$aramexDetails['sevenday'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$aramexDetails['longer'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$quantiumDetails = array();
	$quantiumDetails['twoday'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$quantiumDetails['fourday'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$quantiumDetails['sevenday'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$quantiumDetails['longer'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$bluedartDetails = array();
	$bluedartDetails['twoday'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$bluedartDetails['fourday'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$bluedartDetails['sevenday'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$bluedartDetails['longer'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$speedpostDetails = array();
	$speedpostDetails['twoday'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$speedpostDetails['fourday'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$speedpostDetails['sevenday'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$speedpostDetails['longer'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$aflDetails = array();
	$aflDetails['twoday'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$aflDetails['fourday'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$aflDetails['sevenday'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$aflDetails['longer'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$sabexDetails = array();
	$sabexDetails['twoday'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$sabexDetails['fourday'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$sabexDetails['sevenday'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	$sabexDetails['longer'] = array('shipped'=>0, 'delivered'=>0, 'undelivered'=>0);
	
	populateNumbers($aramexDetails, $quantiumDetails, $bluedartDetails, $speedpostDetails, $aflDetails, $sabexDetails, 2, 0,  'twoday');
	populateNumbers($aramexDetails, $quantiumDetails, $bluedartDetails, $speedpostDetails, $aflDetails, $sabexDetails, 4, 2, 'fourday');
	populateNumbers($aramexDetails, $quantiumDetails, $bluedartDetails, $speedpostDetails, $aflDetails, $sabexDetails, 7, 4, 'sevenday');
	populateNumbers($aramexDetails, $quantiumDetails, $bluedartDetails, $speedpostDetails, $aflDetails, $sabexDetails, 10000, 7, 'longer');
	

	$smarty->assign('current_theme_css', "themes/".$employee->bo_theme."/admin.css");
	$smarty->assign('admin_css', _PS_CSS_DIR_."admin.css");
	
	$smarty->assign('aramexDetails', $aramexDetails);
	$smarty->assign('quantiumDetails', $quantiumDetails);
	$smarty->assign('bluedartDetails', $bluedartDetails);
	$smarty->assign('speedpostDetails', $speedpostDetails);
	$smarty->assign('aflDetails', $aflDetails);
	$smarty->assign('sabexDetails', $sabexDetails);
	$smarty->display(_PS_THEME_DIR_.'admin/deliverystats.tpl');

if(Tools::getValue('getlist'))
{
	global $smarty;
	$carrierID = Tools::getValue('carrierid');
	$range1 = Tools::getValue('range1');
	$range2 = Tools::getValue('range2');
	$endDate ='';
	$startDate = '';
	
	if((int)$range2 > 0)
		$endDate = "and oh.`date_add` < subdate(now(), interval ".$range2." day)";
	
	if((int)$range1 < 999)
		$startDate = "and oh.`date_add` > subdate(now(), interval ".$range1." day)";
		
	$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("
				select o.`id_order`
				from ps_orders o
				inner join `ps_order_history` oh ON (oh.`id_order` = o.`id_order`) 
				where 1 
				".$startDate."
				".$endDate."
				and oh.`id_order_state` = 4
			");
	$orderIds = array();
	foreach($res as $row)
		$orderIds[] = $row['id_order'];
		
	$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("select o.`id_order` as 'OrderID', oh.`date_add` as 'ShippingDate', c.name as 'Carrier', o.shipping_number as 'TrackingCode', a.city
						from ps_orders o
						inner join `ps_order_history` oh ON (oh.`id_order` = o.`id_order`) 
						inner join `ps_address` a on (a.id_address = o.id_address_delivery)
						inner join `ps_carrier` c ON (o.id_carrier = c.id_carrier)
						where o.id_order in (".join(",", $orderIds).")
						and oh.`id_order_history` = (SELECT MAX(`id_order_history`) FROM `ps_order_history` moh WHERE moh.`id_order` = o.`id_order` GROUP BY moh.`id_order`) 
						and oh.`id_order_state` = 4
						and o.id_carrier = ".$carrierID."
						order by invoice_number");
	$smarty->assign('orders', $res);
	$smarty->display(_PS_THEME_DIR_.'admin/undelivered_orders.tpl');
}