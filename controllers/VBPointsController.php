<?php

class VBPointsControllerCore extends FrontController
{
	public function __construct()
	{
		$this->auth = true;
		$this->php_self = 'vbpoints.php';
		$this->authRedirection = 'vbpoints.php';
		$this->ssl = true;
	
		parent::__construct();
	}
	
	public function preProcess()
	{
		parent::preProcess();
		
		$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
		$res = $db->ExecuteS("SELECT 
							description, 
							reference, 
							date_add, 
							points_awarded, 
							coalesce(points_deducted, '-') as `points_deducted`, 
							balance FROM vb_customer_rewards WHERE id_customer = " . self::$cookie->id_customer . "
							order by id_reward desc");
		
		self::$smarty->assign('vbpoints', $res);
		
		self::$smarty->assign('balance_points', VBRewards::getCustomerPoints(self::$cookie->id_customer));
		self::$smarty->assign('redeemed_points', VBRewards::getCustomerPointsRedeemed(self::$cookie->id_customer));
		self::$smarty->assign('earned_points', VBRewards::getCustomerPointsEarned(self::$cookie->id_customer));
		
		self::$smarty->assign('reviews_approved', Customer::getTotalApprovedReviews(self::$cookie->id_customer));
		self::$smarty->assign('social_points', $this->getSocialPoints());
		
		$referrals = Customer::getCustomerReferrals(self::$cookie->id_customer);
		if($referrals)
			self::$smarty->assign('total_referred', count($referrals));
	}
	
	public function setMedia()
	{
		parent::setMedia();
		//Tools::addCSS(_THEME_CSS_DIR_.'identity.css');
	}
	
	public function displayContent()
	{
		parent::displayContent();
		self::$smarty->display(_PS_THEME_DIR_.'vbpoints.tpl');
	}
	
	public function displayHeader()
	{
		self::$smarty->assign('nobots', 1);
		parent::displayHeader();
	}
	
	public function getSocialPoints()
	{
		$id_customer = self::$cookie->id_customer;
		$points_awarded = 0;
		$points_deducted = 0;
		$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
		
		$result = $db->getRow("select sum(points_awarded) as 'total_points'
								from vb_customer_rewards
								where id_customer = " . $id_customer . "
								and id_event in (" . EVENT_FACEBOOK_LIKE  . " , " . EVENT_GOOGLE_LIKE . ")");
		
		if(!$result || $result['total_points'] == 0)
		{
			return 0;
		}
		else 
			$points_awarded = (int)$result['total_points'];
			
		$result = $db->getRow("select sum(points_deducted) as 'total_points'
								from vb_customer_rewards
								where id_customer = " . $id_customer . "
								and id_event in (" . EVENT_FACEBOOK_UNLIKE . " , " . EVENT_GOOGLE_UNLIKE . ")");
		
		if(!$result['total_points'] || $result['total_points'] == 0)
			return $points_awarded;
		else 
			$points_deducted = (int)$result['total_points'];
		
		return $points_awarded - $points_deducted; 
	}
}


