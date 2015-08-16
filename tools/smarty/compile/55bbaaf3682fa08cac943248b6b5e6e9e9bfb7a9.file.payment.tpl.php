<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 14:01:43
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/modules/bankwire/payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5449905555562ddef85ee53-33884060%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '55bbaaf3682fa08cac943248b6b5e6e9e9bfb7a9' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/modules/bankwire/payment.tpl',
      1 => 1431660622,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5449905555562ddef85ee53-33884060',
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