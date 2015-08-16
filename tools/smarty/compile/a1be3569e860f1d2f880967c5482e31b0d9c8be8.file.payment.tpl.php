<?php /* Smarty version Smarty-3.0.7, created on 2015-08-14 17:09:40
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/modules/bankwire/payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:103151981555cdd37c924f50-45767090%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a1be3569e860f1d2f880967c5482e31b0d9c8be8' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/modules/bankwire/payment.tpl',
      1 => 1437832794,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '103151981555cdd37c924f50-45767090',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<p class="payment_module" style="line-height:33px;">
    <input type="radio" name="payMethod" value="wire" style="margin-left:30px;font-size:15px;"/>
    Pay by Bank Wire Transfer 
    <a href="<?php echo $_smarty_tpl->getVariable('this_path_ssl')->value;?>
payment.php" title="" id="wire-transfer-link" style="display:none">
		Pay by bank wire (order process will be longer)
	</a>
</p>