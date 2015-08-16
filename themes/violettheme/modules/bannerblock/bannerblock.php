<?php

class BannerBlock extends Module
{
	public $adv_link;
	public $adv_img;
	public $adv_imgname;

	function __construct()
	{
		$this->name = 'bannerblock';
		$this->tab = 'Blocks';
		$this->version = 0.1;

		parent::__construct();

		$this->displayName = $this->l('BannerBlock');
		$this->description = $this->l('Adds a block of 4 banners at top of the home page');

		$this->adv_imgname = 'advertising_custom.jpg';

		if (!file_exists(dirname(__FILE__).'/'.$this->adv_imgname))
			$this->adv_img = _MODULE_DIR_.$this->name.'/advertising.jpg';
		else
			$this->adv_img = _MODULE_DIR_.$this->name.'/'.$this->adv_imgname;
		$this->adv_link = htmlentities(Configuration::get('BLOCKADVERT_LINK2'), ENT_QUOTES, 'UTF-8');
	}


	function install()
	{
		Configuration::updateValue('BLOCKADVERT_LINK2', 'http://www.prestashop.com');
		if (!parent::install())
			return false;
		if (!$this->registerHook('top'))
			return false;
		return true;
	}

	/**
	* Returns module content
	*
	* @param array $params Parameters
	* @return string Content
	*/
	function hooktop($params)
	{
		global $smarty, $protocol_content, $server_host, $link;

		$smarty->assign('image', $protocol_content.$server_host.$this->adv_img);
		$smarty->assign('adv_link', $this->adv_link);
		$smarty->assign('link', $link);

		return $this->display(__FILE__, 'bannerblock.tpl');
	}

}

?>