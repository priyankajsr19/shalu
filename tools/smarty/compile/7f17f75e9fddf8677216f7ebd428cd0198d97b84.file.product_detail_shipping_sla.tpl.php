<?php /* Smarty version Smarty-3.0.7, created on 2015-08-16 17:58:07
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/./product_detail_shipping_sla.tpl" */ ?>
<?php /*%%SmartyHeaderCode:113240844555d081d75f6f07-10959088%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7f17f75e9fddf8677216f7ebd428cd0198d97b84' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/./product_detail_shipping_sla.tpl',
      1 => 1437833292,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '113240844555d081d75f6f07-10959088',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('product')->value->shipping_sla=="1"){?>
    <p style="border-bottom:1px dashed #cacaca;padding:5px 0;clear:both; font-weight:bold; color:#008500">
        <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
btruck.png" width="20px" height="20px" style="float:left"/>
        <span style="margin-left:10px">Shipped in 24 hours</span>
    </p>
<?php }else{ ?>
<!-- 
    <p style="border-bottom:1px dashed #cacaca;padding:5px 0;clear:both;font-weight:bold; color:#008500">
        <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
btruck.png" width="20px" height="20px" style="float:left"/>
        <span style="margin-left:10px">Shipped in <?php echo $_smarty_tpl->getVariable('product')->value->shipping_sla;?>
 days</span>
    </p>
 -->
<?php }?>
