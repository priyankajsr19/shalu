<?php /* Smarty version Smarty-3.0.7, created on 2015-08-14 16:17:35
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/product-list-page.tpl" */ ?>
<?php /*%%SmartyHeaderCode:203548259555cdc74716d5d8-06729278%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '132b795024cb8d0ca636639ffa6e46b69cc6f75c' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/product-list-page.tpl',
      1 => 1437833297,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '203548259555cdc74716d5d8-06729278',
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
