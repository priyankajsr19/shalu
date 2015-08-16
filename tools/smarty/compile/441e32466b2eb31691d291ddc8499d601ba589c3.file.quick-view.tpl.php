<?php /* Smarty version Smarty-3.0.7, created on 2015-05-19 18:56:18
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/quick-view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1226693738555b39fa41a996-50203941%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '441e32466b2eb31691d291ddc8499d601ba589c3' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/quick-view.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1226693738555b39fa41a996-50203941',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div style="width:760px;">
	<div style="width:450px;float:left">
		
			<?php if ($_smarty_tpl->getVariable('imagelink')->value){?>
				<img src="<?php echo $_smarty_tpl->getVariable('imagelink')->value;?>
" width="450px" height="615"/>
			<?php }else{ ?>
				<img src="<?php echo $_smarty_tpl->getVariable('img_prod_dir')->value;?>
<?php echo $_smarty_tpl->getVariable('lang_iso')->value;?>
-default-large.jpg" width="450px" height="615"/>
			<?php }?>
		
	</div>
	<div style="width:265px;float:left;padding:10px;">
		<h1><?php echo $_smarty_tpl->getVariable('product')->value->name;?>
</h1>
		<p class="price">
						
			<?php if (!$_smarty_tpl->getVariable('priceDisplay')->value||$_smarty_tpl->getVariable('priceDisplay')->value==2){?>
				<?php $_smarty_tpl->tpl_vars['productPrice'] = new Smarty_variable($_smarty_tpl->getVariable('product')->value->getPrice(true,@NULL,2), null, null);?>
				<?php $_smarty_tpl->tpl_vars['productPriceWithoutRedution'] = new Smarty_variable($_smarty_tpl->getVariable('product')->value->getPriceWithoutReduct(false,@NULL), null, null);?>
			<?php }elseif($_smarty_tpl->getVariable('priceDisplay')->value==1){?>
				<?php $_smarty_tpl->tpl_vars['productPrice'] = new Smarty_variable($_smarty_tpl->getVariable('product')->value->getPrice(false,@NULL,2), null, null);?>
				<?php $_smarty_tpl->tpl_vars['productPriceWithoutRedution'] = new Smarty_variable($_smarty_tpl->getVariable('product')->value->getPriceWithoutReduct(true,@NULL), null, null);?>
			<?php }?>
			<?php if ($_smarty_tpl->getVariable('product')->value->specificPrice&&$_smarty_tpl->getVariable('product')->value->specificPrice['reduction']){?>
			<span id="old_price">
				<?php if ($_smarty_tpl->getVariable('priceDisplay')->value>=0&&$_smarty_tpl->getVariable('priceDisplay')->value<=2){?>
					<?php if ($_smarty_tpl->getVariable('productPriceWithoutRedution')->value>$_smarty_tpl->getVariable('productPrice')->value){?>
						<span id="old_price_display"><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->getVariable('productPriceWithoutRedution')->value),$_smarty_tpl);?>
</span>
					<?php }?>
				<?php }?>
			</span>
			<?php }?>
			
			<?php if ($_smarty_tpl->getVariable('priceDisplay')->value>=0&&$_smarty_tpl->getVariable('priceDisplay')->value<=2){?>
				<span id="our_price_display"><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->getVariable('productPrice')->value),$_smarty_tpl);?>
</span>
			<?php }?>
			
			<span style="border-left:1px solid #cacaca;padding:5px">Code:  <?php echo $_smarty_tpl->getVariable('product')->value->reference;?>
</span>
		</p>
		<p style="padding:20px 0;">
			<a class="button" href="<?php echo $_smarty_tpl->getVariable('productlink')->value;?>
" rel="nofollow">View Product Details</a>
		</p>
		
		<p style="padding-top:10px;text-align:center">
		<?php if (isset($_smarty_tpl->getVariable('in_wishlist',null,true,false)->value)&&$_smarty_tpl->getVariable('in_wishlist')->value){?>
    			<a href="/wishlist.php" class="span_link" rel="no-follow">
    			    <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
heart-disabled.jpg" height="18" width="18" style="vertical-align:middle"/>
    			    <span style="color:#939393">IN YOUR WISHLIST</span>
    			</a>
		<?php }else{ ?>
		    <?php if ($_smarty_tpl->getVariable('cookie')->value->isLogged()){?>
		    	<p>OR</p>
				<a href="/wishlist.php?add=<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
" class="span_link" rel="no-follow" >
					<img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
heart.jpg" height="18" width="18" style="vertical-align:middle"/>
					<span style="">ADD TO WISHLIST</span>
    			</a>
			<?php }?>
		<?php }?>
		</p>
	</div>
</div>