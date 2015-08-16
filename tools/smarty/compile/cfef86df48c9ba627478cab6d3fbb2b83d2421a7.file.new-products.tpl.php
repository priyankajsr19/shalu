<?php /* Smarty version Smarty-3.0.7, created on 2015-07-21 14:33:26
         compiled from "/var/www/html/indusdiva/themes/violettheme/new-products.tpl" */ ?>
<?php /*%%SmartyHeaderCode:208995338955ae0ade9f27b0-36263394%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cfef86df48c9ba627478cab6d3fbb2b83d2421a7' => 
    array (
      0 => '/var/www/html/indusdiva/themes/violettheme/new-products.tpl',
      1 => 1436950699,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '208995338955ae0ade9f27b0-36263394',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="new_products" style="width:770px;float:left">
	<h1 id="productsHeading"><?php echo smartyTranslate(array('s'=>'New products'),$_smarty_tpl);?>
</h1>
	
	<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./errors.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	<?php if ($_smarty_tpl->getVariable('products')->value){?>
		<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./product_list_top.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
		<?php if ($_smarty_tpl->getVariable('cookie')->value->image_size==1){?>
			<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./products-pane.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('products',$_smarty_tpl->getVariable('products')->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
		<?php }else{ ?>
			<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./products-pane-small.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('products',$_smarty_tpl->getVariable('products')->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
		<?php }?>
		<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./product_list_bottom.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	<?php }else{ ?>
	    <?php if (isset($_smarty_tpl->getVariable('fetch_error',null,true,false)->value)&&$_smarty_tpl->getVariable('fetch_error')->value){?>
	        <p class="warning">Could not bring the products. Please try after some time.</p>
	    <?php }else{ ?>
		    <p class="warning"><?php echo smartyTranslate(array('s'=>'No new products.'),$_smarty_tpl);?>
</p>
		<?php }?>
	<?php }?>
</div>