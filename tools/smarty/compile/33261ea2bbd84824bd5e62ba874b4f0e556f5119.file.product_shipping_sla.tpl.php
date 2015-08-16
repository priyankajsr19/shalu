<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 13:00:00
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/./product_shipping_sla.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14705567035562cf78774e74-14563974%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '33261ea2bbd84824bd5e62ba874b4f0e556f5119' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/./product_shipping_sla.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14705567035562cf78774e74-14563974',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('product')->value['shipping_sla']=="1"){?>
    <div style="text-align:left;color:#008500">Shipped in 24 hours</div>
<?php }elseif(sprintf("%d",$_smarty_tpl->getVariable('product')->value['shipping_sla'])<=5){?>
    <div style="text-align:left;color:#008500">Shipped in <?php echo $_smarty_tpl->getVariable('product')->value['shipping_sla'];?>
 days</div>
<?php }?>
