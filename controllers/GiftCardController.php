<?php

class GiftCardControllerCore extends FrontController
{
	public function __construct()
	{
		$this->auth = false;
		$this->php_self = 'gift-cards.php';
		$this->authRedirection = 'gift-cards.php';
		$this->ssl = true;
	
		parent::__construct();
	}
	
	public function preProcess()
	{
		parent::preProcess();
	}
	
	public function displayContent()
	{
		parent::displayContent();
		self::$smarty->display(_PS_THEME_DIR_.'gift-cards.tpl');
	}
	
	public function displayHeader()
	{
		parent::displayHeader();
	}
}


