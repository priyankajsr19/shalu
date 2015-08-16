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
*  @version  Release: $Revision: 7046 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class BannerCore extends ObjectModel
{
	public 		$id;

	/** @var integer banner ID */
	public		$id_banner;

	/** @var string Name */
	public 		$title;

	
	public 		$url;

	
	public 		$date_add;

	
	public 		$image_path;

	
	public 		$display_order;

	
	public		$is_active;

 	protected 	$fieldsRequired = array('title','url','display_order','is_active');
 	protected 	$fieldsSize = array('title' => 64);
 	protected 	$fieldsValidate = array(
                            'title' => 'isCatalogName',
                        );

	protected 	$table = 'banner';
	protected 	$identifier = 'id_banner';

	
	public function __construct($id = NULL, $id_lang = NULL)
	{
		parent::__construct($id, $id_lang);
		$this->image_dir = _PS_SUPP_IMG_DIR_;
	}

	public function getLink()
	{
		return null;
	}

	public function getFields()
	{
		parent::validateFields();
		if (isset($this->id_banner))
			$fields['id_banner'] = (int)($this->id_banner);
		$fields['title'] = pSQL($this->title);
                $fields['url'] = pSQL($this->url);
                $fields['image_path'] = pSQL($this->image_path);
                $fields['display_order'] = pSQL($this->display_order);
                $fields['is_active'] = pSQL($this->is_active);
		$fields['date_add'] = pSQL($this->date_add);
		return $fields;
	}


	/**
	  * Return banners
	  *
	  * @return array Banners
	  */
	static public function getBanners()
	{
		if (!$id_lang)
			$id_lang = Configuration::get('PS_LANG_DEFAULT');
		$query = 'SELECT s.*';
		$query .= ' FROM `'._DB_PREFIX_.'banner` as s
		
		'.($active ? ' WHERE s.`active` = 1 ' : '');
		$query .= ' ORDER BY s.`title` ASC'.($p ? ' LIMIT '.(((int)($p) - 1) * (int)($n)).','.(int)($n) : '');
		$banners = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($query);
		if ($banners === false)
			return false;
		return $banners;
	}

	/*
	* Specify if a banner already in base
	*
	* @param $id_banner Banner id
	* @return boolean
	*/
	static public function bannerExists($id_banner)
	{
		$row = Db::getInstance()->getRow('
		SELECT `id_banner`
		FROM '._DB_PREFIX_.'banner s
		WHERE s.`id_banner` = '.(int)($id_banner));

		return isset($row['id_banner']);
	}
	
	public function delete()
	{
		if (parent::delete())
			return $this->deleteImage();
	}
}

