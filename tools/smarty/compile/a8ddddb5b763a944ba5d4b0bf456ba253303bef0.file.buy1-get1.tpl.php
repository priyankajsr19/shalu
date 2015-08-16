<?php /* Smarty version Smarty-3.0.7, created on 2015-07-21 14:32:35
         compiled from "/var/www/html/indusdiva/themes/violettheme/buy1-get1.tpl" */ ?>
<?php /*%%SmartyHeaderCode:31247575355ae0aab1f7733-12569471%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a8ddddb5b763a944ba5d4b0bf456ba253303bef0' => 
    array (
      0 => '/var/www/html/indusdiva/themes/violettheme/buy1-get1.tpl',
      1 => 1436950698,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '31247575355ae0aab1f7733-12569471',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$_smarty_tpl->getVariable('ajax')->value){?>
<script type="text/javascript">
	var nextPage = <?php ob_start();?><?php echo $_smarty_tpl->getVariable('nextPage')->value;?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
;
	var srch_query = "tags:buy1get1 AND inStock:1";
        var brand,latest,sale,express_shipping,cat_id;
	var b1g1 = 1;
</script>

<div class="products_block_medium clearfix">
	<ul class="clearfix product_list" style="width:100%">
		<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
?>
			<li class="ajax_block_product" style=" margin-left:15px; min-height:315px; overflow:hidden">
				<?php $_smarty_tpl->tpl_vars['productitem'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value, null, null);?>
				<?php $_smarty_tpl->tpl_vars['product'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value, null, null);?>
				<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./product_card_small.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
			</li>
		<?php }} ?>
	</ul>
</div>

<div id="top-marker" style="height:1px; width:100%;"></div>
<div id="go-to-top" style="color:#ffffff; background: none repeat scroll 0 0 #A41E21;">
    Go To Top
</div>
<?php if (isset($_smarty_tpl->getVariable('nextPage',null,true,false)->value)&&$_smarty_tpl->getVariable('nextPage')->value){?>
	<div id="load_more">
        	<span id="see_more">See More</span>
                <span id="loading" style="display:none"><img alt="" src="http://static.violetbag.com/img/loader.gif"></span>
        </div>
<?php }?>
<?php }?>

<?php if ($_smarty_tpl->getVariable('ajax')->value){?>
 <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
?>
     <li class="ajax_block_product" style=" margin-left:15px; min-height:315px; overflow:hidden">
        <?php $_smarty_tpl->tpl_vars['productitem'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value, null, null);?>
        <?php $_smarty_tpl->tpl_vars['product'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value, null, null);?>
        <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./product_card_small.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
     </li>
 <?php }} ?>
<?php }?>
