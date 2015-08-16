<?php /* Smarty version Smarty-3.0.7, created on 2015-05-19 18:40:15
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/whats-new.tpl" */ ?>
<?php /*%%SmartyHeaderCode:709369678555b36373d1333-09760833%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ae557436d69b0644043e773fe2b281e5b7df5dad' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/whats-new.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '709369678555b36373d1333-09760833',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
    <?php $_smarty_tpl->tpl_vars['count'] = new Smarty_variable(0, null, null);?>
    <?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('whats_new_products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['category']->key;
?>
        <?php if ($_smarty_tpl->getVariable('count')->value==0){?>
	<div style="text-align: center;margin-top: 45px;border-bottom: 1px dashed #ccc;padding: 10px;">
        <?php }else{ ?>
	<div style="text-align: center;margin-top: 45px;border-bottom: 1px dashed #ccc;border-top: 1px dashed #ccc;padding: 10px;">
        <?php }?>
		<div style="text-transform: uppercase;font-size: 20px;">NEW IN - <?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</div>
		<div>Updated with our latest collection in <?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</div>
	</div>
	<div class="products_block_medium clearfix">
		<ul class="clearfix product_list" style="width:100%">
			<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['product']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['product']['name'] = 'product';
$_smarty_tpl->tpl_vars['smarty']->value['section']['product']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['category']->value['products']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['product']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['product']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['product']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['product']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['product']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['product']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['product']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['product']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['product']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['product']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['product']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['product']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['product']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['product']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['product']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['product']['total']);
?>
				<li class="ajax_block_product" style=" margin-left:15px; min-height:315px; overflow:hidden">
					<?php $_smarty_tpl->tpl_vars['productitem'] = new Smarty_variable($_smarty_tpl->tpl_vars['category']->value['products'][$_smarty_tpl->getVariable('smarty')->value['section']['product']['index']], null, null);?>
					<?php $_smarty_tpl->tpl_vars['product'] = new Smarty_variable($_smarty_tpl->tpl_vars['category']->value['products'][$_smarty_tpl->getVariable('smarty')->value['section']['product']['index']], null, null);?>
					<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./product_card_small.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
				</li>
			<?php endfor; endif; ?>
		</ul>
	</div>
	<div style="text-align:center">
		<a class="button" href="<?php echo $_smarty_tpl->tpl_vars['category']->value['more_link'];?>
" style="display:inline-block;">View all <?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a>
	</div>
        <?php $_smarty_tpl->tpl_vars['count'] = new Smarty_variable($_smarty_tpl->getVariable('count')->value+1, null, null);?>
    <?php }} ?>
