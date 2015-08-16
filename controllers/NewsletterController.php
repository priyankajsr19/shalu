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

class NewsletterControllerCore extends FrontController
{
	public function __construct()
    {
		$this->php_self = 'newsletter.php';
        parent::__construct();
	}
	
	public function preProcess()
    {
		parent::preProcess();
        $unsubscribe_key = Tools::getValue('unsub_key', null);
        $unsubscribe_key = filter_var($unsubscribe_key, FILTER_SANITIZE_STRING);
        $success = false;
        if( !empty($unsubscribe_key) ) {
            $customer = Customer::getCustomerByUnSubscribeKey($unsubscribe_key);
            if( !empty($customer) && Validate::isLoadedObject($customer) ) {
                if( isset(self::$cookie->id_customer) && (int)$customer->id !== (int)self::$cookie->id_customer )
                    $success = false;
                else {
                    $customer->newsletter = 1;
                    $customer->update();
                    $success = true;
                }
            }
        }
        if( !$success )
            Tools::redirect('page-not-found'); 
	}
	
	public function setMedia()
	{
		parent::setMedia();
		//Tools::addCSS(_THEME_CSS_DIR_.'identity.css');
	}

        
	public function displayContent()
	{
		global $isBetaUser;
        parent::displayContent();
		if($isBetaUser)
			self::$smarty->display(_PS_THEME_DIR_.'beta/newsletter.tpl');
		else 
			self::$smarty->display(_PS_THEME_DIR_.'newsletter.tpl');
	}
	
	public function displayHeader()
	{
		self::$smarty->assign('nobots', 1);
		parent::displayHeader();
	}
}


