<?php /* Smarty version Smarty-3.0.7, created on 2015-07-21 12:49:27
         compiled from "/var/www/html/indusdiva/modules/bankwire/payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:74542115655adf27f2cd2d1-11200619%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8591d61eef75ea3d84b6571af8dc3e502dc4fe10' => 
    array (
      0 => '/var/www/html/indusdiva/modules/bankwire/payment.tpl',
      1 => 1431660622,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '74542115655adf27f2cd2d1-11200619',
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