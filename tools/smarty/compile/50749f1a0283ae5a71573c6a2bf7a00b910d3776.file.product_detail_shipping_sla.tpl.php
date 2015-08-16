<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 14:00:18
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/./product_detail_shipping_sla.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4588384695562dd9a53b9c8-05793069%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '50749f1a0283ae5a71573c6a2bf7a00b910d3776' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/./product_detail_shipping_sla.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4588384695562dd9a53b9c8-05793069',
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
