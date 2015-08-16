<?php /* Smarty version Smarty-3.0.7, created on 2015-08-16 17:58:01
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/./product_list_bottom.tpl" */ ?>
<?php /*%%SmartyHeaderCode:85510586655d081d177ba65-11730793%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f77a7462e79b829d026ffe08abb85c0f100ddabe' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/./product_list_bottom.tpl',
      1 => 1437833293,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '85510586655d081d177ba65-11730793',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (isset($_smarty_tpl->getVariable('p',null,true,false)->value)&&$_smarty_tpl->getVariable('p')->value&&$_smarty_tpl->getVariable('start')->value!=$_smarty_tpl->getVariable('stop')->value){?>
<div class="search-nav-bar">
	<div class="nav-pagination">
		<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./pagination.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	</div>
</div>
<?php }?>