<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 10:16:10
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/buy1-get1.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9847231435562a9129ea884-47892229%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '66d9719c5523566ebee305c8c36c5d68056dd4e9' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/buy1-get1.tpl',
      1 => 1432044051,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9847231435562a9129ea884-47892229',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="products_block_medium clearfix">
	<ul class="clearfix product_list" style="width:100%">
		<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
?>
			<li class="ajax_block_product" style=" margin-left:15px; min-height:315px; overflow:hidden">
				<?php $_smarty_tpl->tpl_vars['productitem'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value, null, null);?>
				<?php $_smarty_tpl->tpl_vars['product'] = new Smarty_variable('product', null, null);?>
				<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./product_card_small.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
			</li>
		<?php }} ?>
	</ul>
</div>