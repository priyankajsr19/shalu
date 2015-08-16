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

class SizechartCore extends ObjectModel
{
	public 		$id;

	/** @var integer sizechart ID */
	public		$id_sizechart;//FIXME is it really usefull...?

	public 		$name;

	/** @var string Object creation date */
	public 		$date_add;

	/** @var string Object last modification date */
	public 		$date_upd;

	/** @var string Object sizechart template */
	public 		$sizechart;
	
	/** @var string Object sizechart html string */
	public 		$sizechart_data;

	/** @var boolean active */
	public		$active;


 	protected 	$fieldsRequired = array('name');
 	protected 	$fieldsSize = array('name' => 64);
 	protected 	$fieldsValidate = array('name' => 'isCatalogName');
	protected	$fieldsSizeLang = array('short_description' => 254, 'meta_title' => 128, 'meta_description' => 255, 'meta_description' => 255, 'banner_img' => 255);
	protected	$fieldsValidateLang = array('description' => 'isString', 'short_description' => 'isString', 'meta_title' => 'isGenericName', 'meta_description' => 'isGenericName', 'meta_keywords' => 'isGenericName', 'isGenericName' => 255, 'sizechart' => 'isString', 'sizechart_data' => 'isString');

	protected 	$table = 'sizechart';
	protected 	$identifier = 'id_sizechart';


	public function __construct($id = NULL, $id_lang = NULL)
	{
		parent::__construct($id, $id_lang);
	}

	public function getFields()
	{
		parent::validateFields();
		if (isset($this->id))
			$fields['id_sizechart'] = (int)($this->id);
		$fields['name'] = pSQL($this->name);
		$fields['date_add'] = pSQL($this->date_add);
		$fields['date_upd'] = pSQL($this->date_upd);
		$fields['active'] = (int)($this->active);
		return $fields;
	}

	public function getTranslationsFieldsChild()
	{
		$fieldsArray = array('sizechart', 'sizechart_data');
		$fields = array();
		$languages = Language::getLanguages(false);
		$defaultLanguage = Configuration::get('PS_LANG_DEFAULT');
		foreach ($languages as $language)
		{
			$fields[$language['id_lang']]['id_lang'] = $language['id_lang'];
			$fields[$language['id_lang']][$this->identifier] = (int)($this->id);

			foreach ($fieldsArray as $field)
			{
				if (!Validate::isTableOrIdentifier($field))
					die(Tools::displayError());

				/* Check fields validity */
				if (isset($this->{$field}[$language['id_lang']]) AND !empty($this->{$field}[$language['id_lang']]))
					$fields[$language['id_lang']][$field] = pSQL($this->{$field}[$language['id_lang']], true);
				elseif (in_array($field, $this->fieldsRequiredLang))
					$fields[$language['id_lang']][$field] = pSQL($this->{$field}[$defaultLanguage]);
				else
					$fields[$language['id_lang']][$field] = '';

			}
		}
		return $fields;
	}

	static public function getSizecharts($id_lang = 0, $active = true, $p = false, $n = false, $all_group = false)
	{
		if (!$id_lang)
			$id_lang = (int)Configuration::get('PS_LANG_DEFAULT');
		$sql = 'SELECT s.id_sizechart, s.name, sl.sizechart, sl.sizechart_data, active, date_add, date_upd ';
		$sql.= ' FROM `'._DB_PREFIX_.'sizechart` s
		LEFT JOIN `'._DB_PREFIX_.'sizechart_lang` sl ON (s.`id_sizechart` = sl.`id_sizechart` AND sl.`id_lang` = '.(int)($id_lang).')
		'.($active ? ' WHERE m.`active` = 1' : '');
		$sql.= ($p ? ' LIMIT '.(((int)($p) - 1) * (int)($n)).','.(int)($n) : '');
		$sizecharts = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);
		if ($sizecharts === false)
			return false;
		return $sizecharts;
	}

}

