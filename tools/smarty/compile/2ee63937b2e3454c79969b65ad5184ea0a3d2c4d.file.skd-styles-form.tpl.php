<?php /* Smarty version Smarty-3.0.7, created on 2015-06-18 12:14:22
         compiled from "/var/www/html/indusdiva/themes/violettheme/skd-styles-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:852025866558268c6e98240-68762622%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2ee63937b2e3454c79969b65ad5184ea0a3d2c4d' => 
    array (
      0 => '/var/www/html/indusdiva/themes/violettheme/skd-styles-form.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '852025866558268c6e98240-68762622',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="style-container" rel="text-headline" style="height:920px;background:#F4F2F3;">
	<div class="panel" id="panel"  style="float:left;margin:0px;border:1px dashed #cacaca;height:840px;width:960px;">
		<div style="border-bottom:1px dashed #cacaca">
			<h1>CLICK TO SELECT A STYLE</h1>
		</div>
		<div style="position:relative">
		<?php  $_smarty_tpl->tpl_vars['style'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('styles')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['style']->key => $_smarty_tpl->tpl_vars['style']->value){
?>
			<div class="style-select" rel="<?php echo $_smarty_tpl->tpl_vars['style']->value['id_style'];?>
" data-image="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
styles/<?php echo $_smarty_tpl->tpl_vars['style']->value['style_image_small'];?>
">
				<div class="style-name"><?php echo $_smarty_tpl->tpl_vars['style']->value['style_name'];?>
</div>
				<div><img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
styles/<?php echo $_smarty_tpl->tpl_vars['style']->value['style_image'];?>
" width="200" height="160"></div>
				<div style="line-height:1.2em; text-align:left;"><?php echo $_smarty_tpl->tpl_vars['style']->value['description'];?>
</div>
			</div>
		<?php }} ?>
		</div>
	</div>	
</div>