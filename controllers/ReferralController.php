<?php

class ReferralControllerCore extends FrontController
{
	public function __construct()
	{
		$this->auth = true;
		$this->php_self = 'referral.php';
		$this->authRedirection = 'referral.php';
		$this->ssl = true;
	
		parent::__construct();
	}
	
	public function preProcess()
	{
		global $cookie;
		
		$customer = new Customer((int)(self::$cookie->id_customer));
		
		if(Tools::getValue('ref_emails'))
		{
			$emails = Tools::getValue('ref_emails');
			
			$emails = str_replace("\n", "", $emails);
			$emails = trim($emails);
			
			$emailList = explode(",", $emails);
			$invited = false;
			
			$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
			
			$countInvited = 0;
			$countInvalid = 0;
			
			$invite_id = time();
			$date_invite = date('Y-m-d H:i:s');
			
			$pattern = '/<?([a-z0-9!#$%&\'*+\/=?^`{}|~_-]+[.a-z0-9!#$%&\'*+\/=?^`{}|~_-]*@[a-z0-9]+[._a-z0-9-]*\.[a-z0-9]+)>?$/i';
			
			foreach ($emailList as $email)
			{
				$email = trim($email);
				$emailId = '';
				$name = '';
				//see if it contains the name
				if(strpos($email, '<') === false)
				    $emailId = $email;
				else
				{
				    preg_match($pattern, $email, $matches);
				    $emailId = $matches[1];
				    $name = strstr($email, '<', true);
				}
				
				$name = trim($name);
				$emailId = trim($emailId);
				
				//echo $name . ' : ' . $emailId . '<br />';
				
				if(!Validate::isEmail($emailId) || Customer::customerExists($emailId))
				{
					++$countInvalid;
					continue;
				}
				
				//Add referral record for this customer
				//$result = $db->getRow("SELECT `id_customer` FROM vb_customer_referrals WHERE email = '".$email."'");
				//if(!isset($result['id_customer']))
				
				$db->ExecuteS("INSERT INTO vb_customer_referrals (id_customer, email, date_add, id_invite, name) VALUES (".$customer->id.", '".$emailId."', '".$date_invite."', ".$invite_id.", '" . $name . "')");
							
				++$countInvited;
			}
			
			if($countInvited)
			{
				Tools::sendSQSInviteMessage($invite_id, $customer->id);
			}
			
			self::$smarty->assign('countInvited', $countInvited);
			self::$smarty->assign('countInvalid', $countInvalid);
		}
		
		$res = Db::getInstance()->ExecuteS("select 
											c.id_customer, 
											concat(c.firstname, ' ', c.lastname) as 'name', 
											c.email, 
											c.total_delivered,
											r.date_add
											from ps_customer c 
											left join vb_customer_referrals r on (c.email = r.email) 
											where id_referrer = " . self::$cookie->id_customer . "
											group by c.email"); 
		
		self::$smarty->assign(array('referrals'=> $res, 'customer_id' => $customer->id));
		
		$res = Db::getInstance()->getRow("select count(*) as 'invited'
											from vb_customer_referrals
											where id_customer = " . self::$cookie->id_customer . "
											group by email"); 
		if($res && $res['invited'] > 0)
			self::$smarty->assign('referrals_invited', 1);
	}
	
	public function displayContent()
	{
		parent::displayContent();
		self::$smarty->display(_PS_THEME_DIR_.'referral.tpl');
	}
}

