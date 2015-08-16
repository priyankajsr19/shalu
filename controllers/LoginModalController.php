<?php


class LoginModalControllerCore extends FrontController
{
	public function __construct()
	{
		$this->auth = false;
		$this->php_self = 'login_modal.php';
	
		parent::__construct();
	}
	
	public function run()
	{
		global $cookie;
		$this->init();
		$this->preProcess();
		
		self::$smarty->display(_PS_THEME_DIR_.'login_modal.tpl');
	}
	
	public function displayContent()
	{
		
	}
}

