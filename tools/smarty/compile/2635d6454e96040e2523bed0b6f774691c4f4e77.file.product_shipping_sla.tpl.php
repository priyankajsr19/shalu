<?php /* Smarty version Smarty-3.0.7, created on 2015-07-25 09:34:28
         compiled from "/var/www/html/indusdiva/themes/violettheme/./product_shipping_sla.tpl" */ ?>
<?php /*%%SmartyHeaderCode:42356948455b30acc76a984-99109048%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2635d6454e96040e2523bed0b6f774691c4f4e77' => 
    array (
      0 => '/var/www/html/indusdiva/themes/violettheme/./product_shipping_sla.tpl',
      1 => 1436950700,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '42356948455b30acc76a984-99109048',
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
