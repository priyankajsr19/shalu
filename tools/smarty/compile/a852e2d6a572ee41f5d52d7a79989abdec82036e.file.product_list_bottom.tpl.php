<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 13:00:00
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/./product_list_bottom.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12310445965562cf78791425-78534926%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a852e2d6a572ee41f5d52d7a79989abdec82036e' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/./product_list_bottom.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12310445965562cf78791425-78534926',
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