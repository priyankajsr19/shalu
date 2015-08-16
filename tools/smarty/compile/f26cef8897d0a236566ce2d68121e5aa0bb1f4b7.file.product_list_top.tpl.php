<?php /* Smarty version Smarty-3.0.7, created on 2015-07-25 09:34:27
         compiled from "/var/www/html/indusdiva/themes/violettheme/./product_list_top.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21807369855b30acbd44b69-14767095%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f26cef8897d0a236566ce2d68121e5aa0bb1f4b7' => 
    array (
      0 => '/var/www/html/indusdiva/themes/violettheme/./product_list_top.tpl',
      1 => 1436950700,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21807369855b30acbd44b69-14767095',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="search-nav-bar">
		<div class="nresults"><span class="big"><?php echo intval($_smarty_tpl->getVariable('nbProducts')->value);?>
</span>&nbsp;<?php if ($_smarty_tpl->getVariable('nbProducts')->value==1){?><?php echo smartyTranslate(array('s'=>'result'),$_smarty_tpl);?>
<?php }else{ ?><?php echo smartyTranslate(array('s'=>'results'),$_smarty_tpl);?>
<?php }?></div> 
<?php if (isset($_smarty_tpl->getVariable('p',null,true,false)->value)&&$_smarty_tpl->getVariable('p')->value){?>
	<div class="nav-pagination"><?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./pagination.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?></div>
<?php }?>
		<div class="search-sort"><?php if (!isset($_smarty_tpl->getVariable('instantSearch',null,true,false)->value)||(isset($_smarty_tpl->getVariable('instantSearch',null,true,false)->value)&&!$_smarty_tpl->getVariable('instantSearch')->value)){?><?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./product-sort.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?><?php }?></div>
</div>
	