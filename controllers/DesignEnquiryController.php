<?php

class DesignEnquiryControllerCore extends FrontController
{
	public function __construct()
	{
		$this->auth = false;
		$this->php_self = 'designenquiries.php';
		$this->authRedirection = 'designenquiries.php';
		$this->ssl = true;
	
		parent::__construct();
	}
	
	public function preProcess()
	{
		parent::preProcess();
		
		
		$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
		//self::$smarty->assign('display_thanks', 1);
		
		$phone = Tools::getValue('phone');
		$country = Tools::getValue('country');
		$enquiry = Tools::getValue('enquiry');
		$name = Tools::getValue('name');
		$email = Tools::getValue('email');
		$enquiry = pSQL($enquiry);
		
		$query = 'INSERT INTO `ps_design_enquiries`(name, email, phone, country, enquiry) values(
		"'. $name . '", 
		"'. $email . '", 
		"'. $phone . '", 
		"'. $country . '", 
		"'. $enquiry . '" 
		)';
		$db->Execute($query);
		
		Mail::Send(1, 'designenquiry', Mail::l('New Design Enquiry'),
				array(		'{name}' => $name,
						'{email}' => $email, 
						'{phone}' => $phone,
						'{country}' => $country,
						'{enquiry}' => $enquiry), array('orderenquiries@indusdiva.com', 'care@indusdiva.com'), 'IndusDiva Design Enquiry');
		echo "success"; exit;		
	}
}


