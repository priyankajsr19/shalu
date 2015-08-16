<?php /* Smarty version Smarty-3.0.7, created on 2015-08-14 18:34:46
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/search.tpl" */ ?>
<?php /*%%SmartyHeaderCode:186272031755cde76e205012-74948411%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eae12600ba78be8728408e1ff5b4c3313cdece4c' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/search.tpl',
      1 => 1437833297,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '186272031755cde76e205012-74948411',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/tools/smarty/plugins/modifier.escape.php';
?>
<div id="search-results" style="width:770px;">
<h1 <?php if (isset($_smarty_tpl->getVariable('instantSearch',null,true,false)->value)&&$_smarty_tpl->getVariable('instantSearch')->value){?>id="instant_search_results"<?php }else{ ?>id="productsHeading"<?php }?>>
<?php if ($_smarty_tpl->getVariable('nbProducts')->value>0){?>Products for "<?php if (isset($_GET['search_query'])){?><?php echo stripslashes(htmlentities($_GET['search_query'],$_smarty_tpl->getVariable('ENT_QUOTES')->value,'utf-8'));?>
<?php }elseif($_smarty_tpl->getVariable('search_tag')->value){?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('search_tag')->value,'htmlall','UTF-8');?>
<?php }elseif($_smarty_tpl->getVariable('ref')->value){?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('ref')->value,'htmlall','UTF-8');?>
<?php }?>"<?php }?>
<?php if (isset($_smarty_tpl->getVariable('instantSearch',null,true,false)->value)&&$_smarty_tpl->getVariable('instantSearch')->value){?><a href="#" class="close"><?php echo smartyTranslate(array('s'=>'Return to previous page'),$_smarty_tpl);?>
</a><?php }?>
</h1>

<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./errors.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<?php if (isset($_smarty_tpl->getVariable('fetch_error',null,true,false)->value)&&$_smarty_tpl->getVariable('fetch_error')->value){?>
    <p class="warning">Could not bring the products. Please try after some time.</p>
<?php }elseif(!$_smarty_tpl->getVariable('nbProducts')->value){?>
	<p class="warning">
		<?php if (isset($_smarty_tpl->getVariable('search_query',null,true,false)->value)&&$_smarty_tpl->getVariable('search_query')->value&&isset($_smarty_tpl->getVariable('ssResults',null,true,false)->value)&&$_smarty_tpl->getVariable('ssResults')->value==1){?>
			<?php echo smartyTranslate(array('s'=>'No results found for your search'),$_smarty_tpl);?>
&nbsp;"<?php if (isset($_smarty_tpl->getVariable('search_query',null,true,false)->value)){?><?php echo stripslashes(htmlentities($_smarty_tpl->getVariable('search_query')->value,$_smarty_tpl->getVariable('ENT_QUOTES')->value,'utf-8'));?>
<?php }?>". Related products:
		<?php }elseif(isset($_smarty_tpl->getVariable('search_query',null,true,false)->value)&&$_smarty_tpl->getVariable('search_query')->value){?>
			<?php echo smartyTranslate(array('s'=>'No results found for your search'),$_smarty_tpl);?>
&nbsp;"<?php if (isset($_smarty_tpl->getVariable('search_query',null,true,false)->value)){?><?php echo stripslashes(htmlentities($_smarty_tpl->getVariable('search_query')->value,$_smarty_tpl->getVariable('ENT_QUOTES')->value,'utf-8'));?>
<?php }?>"
		<?php }elseif(isset($_smarty_tpl->getVariable('search_tag',null,true,false)->value)&&$_smarty_tpl->getVariable('search_tag')->value){?>
			<?php echo smartyTranslate(array('s'=>'No results found for your search'),$_smarty_tpl);?>
&nbsp;"<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('search_tag')->value,'htmlall','UTF-8');?>
"
		<?php }else{ ?>
			<?php echo smartyTranslate(array('s'=>'Please type a search keyword'),$_smarty_tpl);?>

		<?php }?>
	</p>
<?php }else{ ?>
	<?php if (isset($_smarty_tpl->getVariable('search_query',null,true,false)->value)&&$_smarty_tpl->getVariable('search_query')->value&&isset($_smarty_tpl->getVariable('ssResults',null,true,false)->value)&&$_smarty_tpl->getVariable('ssResults')->value==true){?>
	<p class="warning">
		<?php echo smartyTranslate(array('s'=>'No results found for your search'),$_smarty_tpl);?>
&nbsp;"<?php if (isset($_smarty_tpl->getVariable('search_query',null,true,false)->value)){?><?php echo stripslashes(htmlentities($_smarty_tpl->getVariable('search_query')->value,$_smarty_tpl->getVariable('ENT_QUOTES')->value,'utf-8'));?>
<?php }?>". Related products:
	</p>
	<?php }?>
	<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./product_list_top.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	<?php if ($_smarty_tpl->getVariable('cookie')->value->image_size==1){?>
		<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./products-pane.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('products',$_smarty_tpl->getVariable('search_products')->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	<?php }else{ ?>
		<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./products-pane-small.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('products',$_smarty_tpl->getVariable('search_products')->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	<?php }?>
	<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./product_list_bottom.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<?php }?>
</div>
<?php if (isset($_smarty_tpl->getVariable('search_description',null,true,false)->value)&&$_smarty_tpl->getVariable('search_description')->value){?>
<div id="seach-description" style="float:left;width:770px;padding-top:10px;clear:both;">
	<?php echo stripslashes($_smarty_tpl->getVariable('search_description')->value);?>

</div>
<?php }?>
