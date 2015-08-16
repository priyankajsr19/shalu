<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 12:48:52
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/product-list-page.tpl" */ ?>
<?php /*%%SmartyHeaderCode:534099165562ccdc94b466-55642492%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f0fee4575bf1c18f6de0b50cd477ac370a26e85' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/product-list-page.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '534099165562ccdc94b466-55642492',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (isset($_smarty_tpl->getVariable('products',null,true,false)->value)){?>
    <?php if ($_smarty_tpl->getVariable('autoload')->value){?>
        <li style="font-size:0px;line-height:0px;border-top:1px solid #D1A6E0;border-bottom:1px solid #D1A6E0;clear:both; margin:5px 25px;width:740px;height:2px;padding:0;"></li>
        <?php }?>
        <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['index']++;
?>
        <li class="ajax_block_product" rel="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
">
            <?php $_smarty_tpl->tpl_vars['productitem'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value, null, null);?>
            <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./product_card.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
        </li>
        <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['index']%3==2){?>
            <li style="font-size:0px;line-height:0px;border-top:1px solid #D1A6E0;border-bottom:1px solid #D1A6E0;clear:both; margin:15px 25px;width:740px;height:2px;padding:0;"></li>
            <?php }?>
        <?php }} ?>
    <!-- /Products list -->
<?php }?>
