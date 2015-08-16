<?php /* Smarty version Smarty-3.0.7, created on 2015-07-25 18:48:34
         compiled from "/var/www/html/indusdiva/themes/violettheme/blouse-styles-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:150067992455b38caaeff945-75492131%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '161c59e6a5b4f1e3b288b1737c7a26bf030f7723' => 
    array (
      0 => '/var/www/html/indusdiva/themes/violettheme/blouse-styles-form.tpl',
      1 => 1436950698,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '150067992455b38caaeff945-75492131',
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