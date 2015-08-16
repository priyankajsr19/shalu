<?php /* Smarty version Smarty-3.0.7, created on 2015-07-23 04:41:54
         compiled from "/var/www/html/indusdiva/themes/violettheme/errors.tpl" */ ?>
<?php /*%%SmartyHeaderCode:104378442455b0233a282643-45781399%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '963c852b9898e5f77be3a725f55e48c7525eb00b' => 
    array (
      0 => '/var/www/html/indusdiva/themes/violettheme/errors.tpl',
      1 => 1436950698,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '104378442455b0233a282643-45781399',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<?php if (isset($_smarty_tpl->getVariable('errors',null,true,false)->value)&&$_smarty_tpl->getVariable('errors')->value){?>
	<div class="error">
		<p><?php if (count($_smarty_tpl->getVariable('errors')->value)>1){?><?php echo smartyTranslate(array('s'=>'There are'),$_smarty_tpl);?>
<?php }else{ ?><?php echo smartyTranslate(array('s'=>'There is'),$_smarty_tpl);?>
<?php }?> <?php echo count($_smarty_tpl->getVariable('errors')->value);?>
 <?php if (count($_smarty_tpl->getVariable('errors')->value)>1){?><?php echo smartyTranslate(array('s'=>'errors'),$_smarty_tpl);?>
<?php }else{ ?><?php echo smartyTranslate(array('s'=>'error'),$_smarty_tpl);?>
<?php }?> :</p>
		<ol>
		<?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('errors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['error']->key;
?>
			<li><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</li>
		<?php }} ?>
		</ol>
	</div>
<?php }?>