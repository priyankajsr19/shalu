<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 12:59:56
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/category.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5674147485562cf744aff81-21883099%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0e6b842a026cc66349836c3c543c18d75d50c742' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/category.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5674147485562cf744aff81-21883099',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/tools/smarty/plugins/modifier.escape.php';
?>
<div id="categoryContent">
   
	<?php if (isset($_smarty_tpl->getVariable('category',null,true,false)->value)){?>
		<?php if ($_smarty_tpl->getVariable('category')->value->id&&$_smarty_tpl->getVariable('category')->value->active){?>
			<h1 id="productsHeading"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('category')->value->name,'htmlall','UTF-8');?>

			</h1>
	         <?php if (isset($_smarty_tpl->getVariable('fetch_error',null,true,false)->value)&&$_smarty_tpl->getVariable('fetch_error')->value){?>
                <p class="warning">Could not bring the products. Please try after some time.</p>
	        <?php }?>
			<?php if ($_smarty_tpl->getVariable('products')->value){?>
				<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./product_list_top.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('nbProducts',$_smarty_tpl->getVariable('nb_products')->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
				<?php if ($_smarty_tpl->getVariable('cookie')->value->image_size==1){?>
					<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./products-pane.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('products',$_smarty_tpl->getVariable('products')->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
				<?php }else{ ?>
					<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./products-pane-small.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('products',$_smarty_tpl->getVariable('products')->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
				<?php }?>
				<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./product_list_bottom.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('nbProducts',$_smarty_tpl->getVariable('nb_products')->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
					
			<?php }elseif(!isset($_smarty_tpl->getVariable('subcategories',null,true,false)->value)){?>
				<p class="warning"><?php echo smartyTranslate(array('s'=>'There are no products in this category.'),$_smarty_tpl);?>
</p>
			<?php }?>
		<?php }elseif($_smarty_tpl->getVariable('category')->value->id){?>
			<p class="warning"><?php echo smartyTranslate(array('s'=>'This category is currently unavailable.'),$_smarty_tpl);?>
</p>
		<?php }?>
	<?php }?>
	
	<?php if (isset($_smarty_tpl->getVariable('remarketing_code',null,true,false)->value)){?>
		<script type="text/javascript">
		/* <![CDATA[ */
		var google_conversion_id = 968757656;
		var google_conversion_language = "en";
		var google_conversion_format = "3";
		var google_conversion_color = "666666";
		var google_conversion_label = "<?php echo $_smarty_tpl->getVariable('remarketing_code')->value;?>
";
		var google_conversion_value = 0;
		/* ]]> */
		</script>
		<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
		</script>
		<noscript>
		<div style="display:inline;">
		<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/968757656/?label=<?php echo $_smarty_tpl->getVariable('remarketing_code')->value;?>
&amp;guid=ON&amp;script=0"/>
		</div>
		</noscript>	
	<?php }?>
</div>

