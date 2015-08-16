<?php

class BulkEnquiryControllerCore extends FrontController
{
	public function __construct()
	{
		$this->auth = true;
		$this->php_self = 'bulkenquiries.php';
		$this->authRedirection = 'bulkenquiries.php';
		$this->ssl = true;
	
		parent::__construct();
	}
	
	public function preProcess()
	{
		parent::preProcess();
		
		$id_customer = self::$cookie->id_customer;
		$customer = new Customer($id_customer);
		
		$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
		//self::$smarty->assign('display_thanks', 1);
		
		if(!Tools::isSubmit('submitEnquiry')) return;
		
		$phone = Tools::getValue('phone');
		$country = Tools::getValue('country');
		$enquiry = Tools::getValue('enquiry');
		$enquiry = pSQL($enquiry);
		
		$query = 'INSERT INTO `ps_bulk_enquiries`(id_customer, phone, country, enquiry) values(
		'. $id_customer . ', 
		"'. $phone . '", 
		"'. $country . '", 
		"'. $enquiry . '" 
		)';
		
		$db->Execute($query);
		
		Mail::Send(1, 'bulkenquiry', Mail::l('New Bulk Enquiry'),
				array('{customer_name}' => $customer->firstname. ' '. $customer->lastname . ' ('.$customer->email.')', 
						'{phone}' => $phone,
						'{country}' => $country,
						'{enquiry}' => $enquiry), array('orderenquiries@indusdiva.com', 'care@indusdiva.com'), 'IndusDiva Bulk Enquiry');
		
		self::$smarty->assign('display_thanks', 1);
	}
	
	public function setMedia()
	{
		parent::setMedia();
	}
	
	public function displayContent()
	{
		parent::displayContent();
		self::$smarty->display(_PS_THEME_DIR_.'bulk-enquiry.tpl');
	}
	
	public function displayHeader()
	{
		self::$smarty->assign('nobots', 1);
		parent::displayHeader();
	}
}


