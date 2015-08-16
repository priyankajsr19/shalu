<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 12:59:56
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/./product-sort.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7436231015562cf74843408-32174242%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9fe304f61910d8a249d2996cf44fcd3dc8f66c53' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/./product-sort.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7436231015562cf74843408-32174242',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/tools/smarty/plugins/modifier.escape.php';
?><?php if (isset($_smarty_tpl->getVariable('orderby',null,true,false)->value)&&isset($_smarty_tpl->getVariable('orderway',null,true,false)->value)){?>
    <?php if (isset($_GET['id_category'])&&$_GET['id_category']){?>
    	<?php $_smarty_tpl->tpl_vars['request'] = new Smarty_variable($_smarty_tpl->getVariable('link')->value->getPaginationLink('category',$_smarty_tpl->getVariable('category')->value,false,true), null, null);?>
    <?php }elseif(isset($_GET['id_manufacturer'])&&$_GET['id_manufacturer']){?>
    	<?php $_smarty_tpl->tpl_vars['request'] = new Smarty_variable($_smarty_tpl->getVariable('link')->value->getPaginationLink('manufacturer',$_smarty_tpl->getVariable('manufacturer')->value,false,true), null, null);?>
    <?php }elseif(isset($_GET['id_supplier'])&&$_GET['id_supplier']){?>
    	<?php $_smarty_tpl->tpl_vars['request'] = new Smarty_variable($_smarty_tpl->getVariable('link')->value->getPaginationLink('supplier',$_smarty_tpl->getVariable('supplier')->value,false,true), null, null);?>
    <?php }else{ ?>
    	<?php $_smarty_tpl->tpl_vars['request'] = new Smarty_variable($_smarty_tpl->getVariable('link')->value->getPaginationLink(false,false,false,true), null, null);?>
    <?php }?>
    <div style="float:left">
    Sort By:
    <?php if ($_smarty_tpl->getVariable('orderby')->value!="hot"){?>
        <a class="lnk_sort hot" rel="hot:desc" href="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('link')->value->addSortDetails($_smarty_tpl->getVariable('request')->value,'hot','desc'),'htmlall','UTF-8');?>
" > Whats Hot</a>  
    <?php }else{ ?>
        <a class="lnk_sort hot currentsort" rel="hot:desc" href="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('link')->value->addSortDetails($_smarty_tpl->getVariable('request')->value,'hot','desc'),'htmlall','UTF-8');?>
" > Whats Hot</a>
    <?php }?>
    |
    <?php if ($_smarty_tpl->getVariable('orderby')->value!="new"){?>
        <a class="lnk_sort new" rel="new:desc" href="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('link')->value->addSortDetails($_smarty_tpl->getVariable('request')->value,'new','desc'),'htmlall','UTF-8');?>
" > Whats New</a>  
    <?php }else{ ?>
        <a class="lnk_sort new currentsort" rel="new:desc" href="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('link')->value->addSortDetails($_smarty_tpl->getVariable('request')->value,'new','desc'),'htmlall','UTF-8');?>
" > Whats New</a>
    <?php }?>
    |
    <?php if ($_smarty_tpl->getVariable('orderby')->value!="discount"){?>
        <a class="lnk_sort discount" rel="discount:desc" href="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('link')->value->addSortDetails($_smarty_tpl->getVariable('request')->value,'discount','desc'),'htmlall','UTF-8');?>
" > Discount</a>  
    <?php }else{ ?>
        <a class="lnk_sort discount currentsort" rel="discount:desc" href="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('link')->value->addSortDetails($_smarty_tpl->getVariable('request')->value,'discount','desc'),'htmlall','UTF-8');?>
" > Discount</a>
    <?php }?>
    |
    <?php if ($_smarty_tpl->getVariable('orderby')->value!="price"){?>
        <a class="lnk_sort price" style="font-size:1em;" rel="price:asc" href="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('link')->value->addSortDetails($_smarty_tpl->getVariable('request')->value,'price','asc'),'htmlall','UTF-8');?>
" > Price ↑</a> 
    <?php }else{ ?>
          <?php if ($_smarty_tpl->getVariable('orderway')->value=="asc"){?>
                 <a class="lnk_sort price currentsort" rel="price:asc" style="font-size:1em;" href="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('link')->value->addSortDetails($_smarty_tpl->getVariable('request')->value,'price','desc'),'htmlall','UTF-8');?>
" >  Price ↑</a>
          <?php }else{ ?>
                    <a class="lnk_sort currentsort" rel="price:desc" href="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('link')->value->addSortDetails($_smarty_tpl->getVariable('request')->value,'price','asc'),'htmlall','UTF-8');?>
" > Price ↓</a> 
          <?php }?>
    <?php }?>
    </div>
    
    <div style="float:right;padding:3px 0 0 10px;">
    
	<?php if ($_smarty_tpl->getVariable('cookie')->value->image_size==1){?>
    	<span class="image_size_large_selected"></span>
    	<a href="" class="toggle_size" rel="s"><span class="image_size_small"></span></a>
    <?php }else{ ?>
    	<a href="" class="toggle_size" rel="l"><span class="image_size_large"></span></a>
    	<span class="image_size_small_selected"></span>
    <?php }?>
    </div>
    <div style="float:right">Image Size:</div>
    
    
<script>
$(document).ready(function() {
	$('.toggle_size').click(function(e){
		e.preventDefault();
		var url = '';
		if(location.search.length == 0)
			url = location.pathname + '?is=' + $(this).attr('rel');
		else
			url = location.pathname + location.search.replace(/&?is=l|&?is=s/g, '') + '&is='+ $(this).attr('rel');
		window.location.href = url+location.hash;
	});
});
</script>

<?php }?>
