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

class AdminBanners extends AdminTab
{
	protected $maxImageSize = 400000;

	public function __construct()
	{
	 	$this->table = 'banner';
	 	$this->className = 'Banner';
	 	$this->view = false;
	 	$this->edit = true;
	 	$this->delete = false;
		$this->image_dir = _PS_IMG_;
 		$this->fieldImageSettings = array('name' => 'banner_image', 'dir' => 'banners');
		
		$this->fieldsDisplay = array(
			'id_banner' => array('title' => $this->l('ID'), 'align' => 'center', 'width' => 25),
			'title' => array('title' => $this->l('Title'), 'width' => 120),
			'url' => array('title' => $this->l('URL'), 'width' => 120),
			'image_path' => array('title' => $this->l('Image Path'), 'align' => 'right','image' => 'file', 'orderby' => false, 'search' => false),
			'display_order' => array('title' => $this->l('Display Order'),'width' => 25, 'align' => 'center'),
			'is_active' => array('title' => $this->l('Enabled'), 'width' => 25, 'align' => 'center', 'is_active' => 'status', 'type' => 'bool', 'orderby' => false)
		);
	
		parent::__construct();
	}
	
	public function viewbanner()
	{
		$this->displayForm();
	}
	
	public function displayForm($isMainTab = true)
	{
		global $currentIndex;
		parent::displayForm();
		
		if (!($banner = $this->loadObject(true)))
			return;
                
                    //echo '<pre>'; print_r( $banner ); exit;

		echo '
		<form action="'.$currentIndex.'&submitAdd'.$this->table.'=1&token='.$this->token.'" method="post" enctype="multipart/form-data">
		'.($banner->id_banner ? '<input type="hidden" name="id_'.$this->table.'" value="'.$banner->id_banner.'" />' : '').'
			<fieldset>
                            <legend><img src="../img/admin/suppliers.gif" />'.$this->l('Banners').'</legend>
                                
				<label>'.$this->l('Title:').' </label>
				<div class="margin-form">
					<input type="text" size="40" name="title" value="'.htmlentities(Tools::getValue('title', $banner->title), ENT_COMPAT, 'UTF-8').'" /> <sup>*</sup>
					<span class="hint" name="help_box">'.$this->l('Invalid characters:').' <>;=#{}<span class="hint-pointer">&nbsp;</span></span>
				</div>
                                
				<label>'.$this->l('URL:').' </label>
				<div class="margin-form">
					<input type="text" size="40" name="url" value="'.htmlentities(Tools::getValue('url', $banner->url), ENT_COMPAT, 'UTF-8').'" /> <sup>*</sup>
					<span class="hint" name="help_box">'.$this->l('Invalid characters:').' <>;=#{}<span class="hint-pointer">&nbsp;</span></span>
				</div>
                                
				<label>'.$this->l('Image Path:').' </label>
				<div class="margin-form">
					<input type="hidden" name="image_path" value="'.htmlentities(Tools::getValue('image_path', $banner->image_path), ENT_COMPAT, 'UTF-8').'" />
					<input type="file" size="40" name="banner_image"/>';
					$image_path = Tools::getValue('image_path', $banner->image_path);
					if( !empty($image_path) ) {
						echo '<a href="http://'._MEDIA_SERVER_1_.$this->image_dir.Tools::getValue('image_path', $banner->image_path).'" target="__blank">';
						echo '	<img src="http://'._MEDIA_SERVER_1_.$this->image_dir.Tools::getValue('image_path', $banner->image_path).'" width="200px" />';
						echo '</a>';
					}
                
		echo		'</div>

				<label>'.$this->l('Display Order:').' </label>
				<div class="margin-form">
					<input type="text" size="40" name="display_order" value="'.htmlentities(Tools::getValue('display_order', $banner->display_order), ENT_COMPAT, 'UTF-8').'" />
					<span class="hint" name="help_box">'.$this->l('Invalid characters:').' <>;=#{}<span class="hint-pointer">&nbsp;</span></span>
				</div>

                                
                                <label>'.$this->l('Enable:').' </label>
                                <div class="margin-form">
                                        <input type="radio" name="is_active" id="active_on" value="1" '.($this->getFieldValue($banner, 'is_active') ? 'checked="checked" ' : '').'/>
                                        <label class="t" for="active_on"> <img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
                                        <input type="radio" name="is_active" id="active_off" value="0" '.(!$this->getFieldValue($banner, 'is_active') ? 'checked="checked" ' : '').'/>
                                        <label class="t" for="active_off"> <img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
                                </div>

				<div class="margin-form">
					<input type="submit" value="'.$this->l('   Save   ').'" name="submitAdd'.$this->table.'" class="button" />
				</div>
				<div class="small"><sup>*</sup> '.$this->l('Required field').'</div>
			</fieldset>
		</form>';
	}
	protected function uploadImage($id, $name, $dir, $ext = false)
	{
		if (isset($_FILES[$name]['tmp_name']) AND !empty($_FILES[$name]['tmp_name']))
		{
			// Delete old image
			if (Validate::isLoadedObject($object = $this->loadObject())) {
				//$object->deleteImage();
			}
			else
				return false;

			// Check image validity
			if ($error = checkImage($_FILES[$name], $this->maxImageSize))
				$this->_errors[] = $error;
			elseif (!$tmpName = tempnam(_PS_TMP_IMG_DIR_, 'PS') OR !move_uploaded_file($_FILES[$name]['tmp_name'], $tmpName))
				return false;
			else
			{
				$_FILES[$name]['tmp_name'] = $tmpName;
				// Copy new image
				if (!imageResize($tmpName, _PS_IMG_DIR_.$dir.$id.'-'.$_FILES[$name]['name'], NULL, NULL, ($ext ? $ext : $this->imageType)))
					$this->_errors[] = Tools::displayError('An error occurred while uploading image.');
				if (sizeof($this->_errors))
					return false;
				if ($this->afterImageUpload())
				{
					//update new image path in the object
					$object->image_path = $dir.$id.'-'.$_FILES[$name]['name'];
					$object->update();
					unlink($tmpName);
					return true;
				}
				return false;
			}
		}
		return true;
	}
}


