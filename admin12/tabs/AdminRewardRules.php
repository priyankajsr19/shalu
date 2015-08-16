<?php
class AdminRewardRules extends AdminTab
{
	public function postProcess()
	{
		global $currentIndex, $cookie, $smarty;
		
		if(Tools::getValue('editRules'))
		{
			$id_ruleConfig = Tools::getValue('editRuleConfigID');
			$ruleConfigValue = Tools::getValue('editRuleConfigValue');
			
			Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("update vb_rule_config set value = '".$ruleConfigValue."' where id=".$id_ruleConfig);
		}
		
		$rulesConfigs = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("SELECT id, name, value from vb_rule_config");
		
		$smarty->assign('ruleConfigs', $rulesConfigs);
		$smarty->assign('currentIndex', $currentIndex);
		$smarty->assign('token', $this->token);
	}
	
	public function display()
	{
		global $smarty;
		$smarty->display(_PS_THEME_DIR_.'admin/rewardRules.tpl');
	}
}






