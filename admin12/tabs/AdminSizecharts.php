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
*  @version  Release: $Revision: 6684 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class AdminSizecharts extends AdminTab
{

	public function __construct()
	{
		global $cookie;

		$this->table = 'sizechart';
		$this->className = 'Sizechart';
		$this->lang = false;
		$this->edit = true;
	 	$this->delete = true;

		$this->fieldsDisplay = array(
			'id_sizechart' => array('title' => $this->l('ID'), 'align' => 'center', 'width' => 25),
			'name' => array('title' => $this->l('Name'), 'width' => 200),
			'active' => array('title' => $this->l('Enabled'), 'width' => 25, 'align' => 'center', 'active' => 'status', 'type' => 'bool', 'orderby' => false)
		);

		parent::__construct();
	}


	public function displayForm($isMainTab = true)
	{
		global $currentIndex, $cookie;
		parent::displayForm();
		
		if (!($sizechart = $this->loadObject(true)))
			return;

		echo '
		<form action="'.$currentIndex.'&submitAdd'.$this->table.'=1&token='.$this->token.'" method="post" enctype="multipart/form-data">
		'.($sizechart->id ? '<input type="hidden" name="id_'.$this->table.'" value="'.$sizechart->id.'" />' : '').'
			<fieldset style="width: 905px;">
				<legend>'.$this->l('Sizecharts').'</legend>
				<label>'.$this->l('Name').'</label>
                                <div class="margin-form">
                                        <input type="text" size="40" name="name" value="'.htmlentities(Tools::getValue('name', $sizechart->name), ENT_COMPAT, 'UTF-8').'" /> <sup>*</sup>
                                        <span class="hint" name="help_box">'.$this->l('Invalid characters:').' <>;=#{}<span class="hint-pointer">&nbsp;</span></span>
                                </div>
		
				<br class="clear" /><br /> <br />
				<label>'.$this->l('Sizechart Data').'</label>
				<div class="margin-form">';
		foreach ($this->_languages as $language)
			echo '
							<div id="csizechart_data_'.$language['id_lang'].'" style="float: left;'.($language['id_lang'] != $this->_defaultFormLanguage ? 'display:none;' : '').'">
								<textarea class="rte" cols="48" rows="5" id="sizechart_data_'.$language['id_lang'].'" name="sizechart_data_'.$language['id_lang'].'">'.htmlentities(stripslashes($this->getFieldValue($sizechart, 'sizechart_data', $language['id_lang'])), ENT_COMPAT, 'UTF-8').'</textarea>
							</div>';
		$this->displayFlags($this->_languages, $this->_defaultFormLanguage, $langtags, 'csizechart_data');
		echo '		</div>';
		
		echo '		<br class="clear" /><br/><br/>
				<label>'.$this->l('Sizechart Template').'</label>
				<div class="margin-form">';
		foreach ($this->_languages as $language)
			echo '
							<div id="csizechart_'.$language['id_lang'].'" style="float: left;'.($language['id_lang'] != $this->_defaultFormLanguage ? 'display:none;' : '').'">
								<select  id="sizechart_'.$language['id_lang'].'" name="sizechart_'.$language['id_lang'].'">';
                                if( $this->getFieldValue($sizechart, 'sizechart', $language['id_lang']) === "$sizechart->id.tpl") {
                                    echo '<option value="'.$sizechart->id.'.tpl" selected>Specific</option>';
                                    echo '<option value="generic.tpl">Generic</option>';
                                    echo '<option value="generic_without_guide.tpl">Generic - No Guide</option>';
                                } elseif( $this->getFieldValue($sizechart, 'sizechart', $language['id_lang']) === 'generic.tpl') {
                                    echo '<option value="'.$sizechart->id.'.tpl">Specific</option>';
                                    echo '<option value="generic.tpl" selected>Generic</option>';
                                    echo '<option value="generic_without_guide.tpl">Generic - No Guide</option>';
                                } elseif( $this->getFieldValue($sizechart, 'sizechart', $language['id_lang']) === 'generic_without_guide.tpl') {
                                    echo '<option value="'.$sizechart->id.'.tpl">Specific</option>';
                                    echo '<option value="generic.tpl">Generic</option>';
                                    echo '<option value="generic_without_guide.tpl" selected>Generic - No Guide</option>';
                                } else {
                                    echo '<option value="'.$sizechart->id.'.tpl">Specific</option>';
                                    echo '<option value="generic.tpl">Generic</option>';
                                    echo '<option value="generic_without_guide.tpl">Generic - No Guide</option>';
                                }
			echo '				</select>
							</div>';
		$this->displayFlags($this->_languages, $this->_defaultFormLanguage, $langtags, 'csizechart');
		echo '		</div>';
		
		
		// TinyMCE
		global $cookie;
		$iso = Language::getIsoById((int)($cookie->id_lang));
		$isoTinyMCE = (file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/langs/'.$iso.'.js') ? $iso : 'en');
		$ad = dirname($_SERVER["PHP_SELF"]);
		echo '
			<script type="text/javascript">	
			var iso = \''.$isoTinyMCE.'\' ;
			var pathCSS = \''._THEME_CSS_DIR_.'\' ;
			var ad = \''.$ad.'\' ;
			</script>
			<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tiny_mce/tiny_mce.js"></script>
			<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tinymce.inc.js"></script>';
		echo '		<div class="clear"></div><br/>
				<label>'.$this->l('Enable:').' </label>
				<div class="margin-form">
					<input type="radio" name="active" id="active_on" value="1" '.($this->getFieldValue($sizechart, 'active') ? 'checked="checked" ' : '').'/>
					<label class="t" for="active_on"> <img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
					<input type="radio" name="active" id="active_off" value="0" '.(!$this->getFieldValue($sizechart, 'active') ? 'checked="checked" ' : '').'/>
					<label class="t" for="active_off"> <img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
				</div>
				<div class="margin-form">
					<input type="submit" value="'.$this->l('   Save   ').'" name="submitAdd'.$this->table.'" class="button" />
				</div>
				<div class="small"><sup>*</sup> '.$this->l('Required field').'</div>
			</fieldset>
		</form>';
	}

	public function viewsizechart()
	{
		$this->displayForm();
	}
}
