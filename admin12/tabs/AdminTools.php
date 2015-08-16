<?php
/*
* 2007-2011 PrestaShop 
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 6594 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class AdminTools extends AdminTab
{
	public function postProcess()
	{
		global $currentIndex, $cookie, $smarty;

		$statuses = OrderState::getOrderStates($cookie->id_lang);
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT COUNT(*) as nbOrders, (
			SELECT oh.id_order_state
			FROM '._DB_PREFIX_.'order_history oh
			WHERE oh.id_order = o.id_order
			ORDER BY oh.date_add DESC, oh.id_order_history DESC
			LIMIT 1
		) id_order_state
		FROM '._DB_PREFIX_.'orders o
		GROUP BY id_order_state');
		$statusStats = array();
		foreach ($result as $row)
			$statusStats[$row['id_order_state']] = $row['nbOrders'];
			
		$smarty->assign('statusStats', $statusStats);
		$smarty->assign('statuses', $statuses);
	}
	
	public function display()
	{
        global $smarty;
        includeDatepicker(array('datepickerFrom', 'datepickerTo'));
		$smarty->display(_PS_THEME_DIR_.'admin/violettools.tpl');
		
		echo '<fieldset><legend><img src="../img/admin/tab-tools.gif" />'.$this->l('Shop Tools').'</legend>';
		echo '<p>'.$this->l('Several tools are available to manage your shop.').'</p>';
		echo '<br />';
		echo '<p>'.$this->l('Please choose a tool by selecting a Tools sub-tab above.').'</p>';
		echo '</fieldset>';
	}
}



