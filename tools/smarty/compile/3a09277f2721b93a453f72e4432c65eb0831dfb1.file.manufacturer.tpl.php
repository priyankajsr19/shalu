<?php /* Smarty version Smarty-3.0.7, created on 2015-06-22 20:28:39
         compiled from "/var/www/html/indusdiva/themes/violettheme/manufacturer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21071447845588229fa50176-61540757%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3a09277f2721b93a453f72e4432c65eb0831dfb1' => 
    array (
      0 => '/var/www/html/indusdiva/themes/violettheme/manufacturer.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21071447845588229fa50176-61540757',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/var/www/html/indusdiva/tools/smarty/plugins/modifier.escape.php';
?>

<div style="width:770px;">
<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./errors.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<?php if (!isset($_smarty_tpl->getVariable('errors',null,true,false)->value)||!sizeof($_smarty_tpl->getVariable('errors')->value)){?>
	<h1 id="productsHeading"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('manufacturer')->value->name,'htmlall','UTF-8');?>
 Products</h1>
	<?php if (isset($_smarty_tpl->getVariable('fetch_error',null,true,false)->value)&&$_smarty_tpl->getVariable('fetch_error')->value){?>
        <p class="warning">Could not bring the products. Please try after some time.</p>
	<?php }elseif($_smarty_tpl->getVariable('products')->value){?>
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
		<?php if (isset($_smarty_tpl->getVariable('show_details',null,true,false)->value)){?>
		<div style="clear:both;padding:10px 0px 0px 0px;">
			<h2 >About <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('manufacturer')->value->name,'htmlall','UTF-8');?>
</h2>
			<?php echo $_smarty_tpl->getVariable('manufacturer')->value->description;?>

		</div>
		<?php }?>
		<?php if ($_smarty_tpl->getVariable('topSalesProducts')->value){?>
		<div style="float:left;padding:0px 0px;width:100%;">
		<script>
			// execute your scripts when the DOM is ready. this is mostly a good habit
			$(function() {
			
				// initialize scrollable
				$(".scrollable").scrollable();
			
			});
		</script>
		<div id="top_products">
		<h2 class="panel_heading">Top Selling <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('manufacturer')->value->name,'htmlall','UTF-8');?>
 Products</h2>
		<div  class="products_block" style="padding-left:60px;">
			<!-- "previous page" action -->
			<a class="prev browse left">Prev</a>
			
			<!-- root element for scrollable -->
			<div class="scrollable" style="width:590px">   
			   <!-- root element for the items -->
			   <div class="items">
					<?php if (isset($_smarty_tpl->getVariable('topSalesProducts',null,true,false)->value)){?>
						<?php  $_smarty_tpl->tpl_vars['productitem'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('topSalesProducts')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['productitem']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['productitem']->iteration=0;
 $_smarty_tpl->tpl_vars['productitem']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['index']=-1;
if ($_smarty_tpl->tpl_vars['productitem']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['productitem']->key => $_smarty_tpl->tpl_vars['productitem']->value){
 $_smarty_tpl->tpl_vars['productitem']->iteration++;
 $_smarty_tpl->tpl_vars['productitem']->index++;
 $_smarty_tpl->tpl_vars['productitem']->first = $_smarty_tpl->tpl_vars['productitem']->index === 0;
 $_smarty_tpl->tpl_vars['productitem']->last = $_smarty_tpl->tpl_vars['productitem']->iteration === $_smarty_tpl->tpl_vars['productitem']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['first'] = $_smarty_tpl->tpl_vars['productitem']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['index']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['last'] = $_smarty_tpl->tpl_vars['productitem']->last;
?>
							<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['first']==true||$_smarty_tpl->getVariable('smarty')->value['foreach']['products']['index']%3==0){?>
					     		<div>
					     			<!-- Products list -->
									<ul>	
					  		<?php }?>
										<li class="ajax_block_product" rel="<?php echo $_smarty_tpl->tpl_vars['productitem']->value['id_product'];?>
" <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['index']%3==0){?>style=" margin-left:15px"<?php }?>>
											<div class=" <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['index']%3==0){?> left_card <?php }else{ ?>product_card<?php }?>">
												<?php if ($_smarty_tpl->tpl_vars['productitem']->value['quantity']<=0){?>
												<img alt="Out Of Stock" src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
out_of_stock_vs.png" style="margin:0 0;position:absolute;left:1px; top:0px;"/>
												<?php }?>
												<a href="<?php echo $_smarty_tpl->tpl_vars['productitem']->value['link'];?>
">
													<span class="product_image" href="<?php echo $_smarty_tpl->tpl_vars['productitem']->value['link'];?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['productitem']->value['name'],'html','UTF-8');?>
">
														<?php if (isset($_smarty_tpl->getVariable('lazy',null,true,false)->value)&&$_smarty_tpl->getVariable('lazy')->value==1){?>
															<img data-href="<?php echo $_smarty_tpl->getVariable('link')->value->getImageLink($_smarty_tpl->tpl_vars['productitem']->value['link_rewrite'],$_smarty_tpl->tpl_vars['productitem']->value['id_image'],'home');?>
" height="129" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['productitem']->value['name'],'html','UTF-8');?>
"  class="delaylazy"/>
															<noscript>
																<img src="<?php echo $_smarty_tpl->getVariable('link')->value->getImageLink($_smarty_tpl->tpl_vars['productitem']->value['link_rewrite'],$_smarty_tpl->tpl_vars['productitem']->value['id_image'],'home');?>
" height="129" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['productitem']->value['name'],'html','UTF-8');?>
" />
															</noscript>
														<?php }else{ ?>
															<img src="<?php echo $_smarty_tpl->getVariable('link')->value->getImageLink($_smarty_tpl->tpl_vars['productitem']->value['link_rewrite'],$_smarty_tpl->tpl_vars['productitem']->value['id_image'],'home');?>
" height="129" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['productitem']->value['name'],'html','UTF-8');?>
" />
														<?php }?>
													</span>
								                   <span class="product-list-name">
									                   <h2 class="product_card_name"><?php echo smarty_modifier_escape(smarty_modifier_truncate($_smarty_tpl->tpl_vars['productitem']->value['name'],100,'...'),'htmlall','UTF-8');?>
</h2>
								                  	</span>
													<span class="product_info">
								                       	<span class="price"><?php if (!$_smarty_tpl->getVariable('priceDisplay')->value){?><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->tpl_vars['productitem']->value['price']),$_smarty_tpl);?>
<?php }else{ ?><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->tpl_vars['productitem']->value['price_tax_exc']),$_smarty_tpl);?>
<?php }?></span>
								                       	<?php if (($_smarty_tpl->tpl_vars['productitem']->value['price_without_reduction']-$_smarty_tpl->tpl_vars['productitem']->value['price']>1)){?>
									                       	<span class="strike_price">MRP <?php if (!$_smarty_tpl->getVariable('priceDisplay')->value){?><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->tpl_vars['productitem']->value['price_without_reduction']),$_smarty_tpl);?>
 <?php }?></span>
									                       	<span class="clear" style="display:block;color:#DA0F00;">(<?php echo round((($_smarty_tpl->tpl_vars['productitem']->value['price_without_reduction']-$_smarty_tpl->tpl_vars['productitem']->value['price'])/$_smarty_tpl->tpl_vars['productitem']->value['price_without_reduction'])*100);?>
% Off)</span>
															
														<?php }?>
													</span>
												</a>
												<?php if (($_smarty_tpl->tpl_vars['productitem']->value['quantity']>0||$_smarty_tpl->tpl_vars['productitem']->value['allow_oosp'])&&$_smarty_tpl->tpl_vars['productitem']->value['customizable']!=2){?>
													<span id="ajax_id_product_<?php echo $_smarty_tpl->tpl_vars['productitem']->value['id_product'];?>
" class="add2cart exclusive ajax_add_to_cart_button" idprod="ajax_id_product_<?php echo $_smarty_tpl->tpl_vars['productitem']->value['id_product'];?>
" title="<?php echo smartyTranslate(array('s'=>'Add to Bag','mod'=>'homefeatured'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Add to Bag','mod'=>'homefeatured'),$_smarty_tpl);?>
</span>
												<?php }?>
											</div>
										</li>
							<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['index']%3==2||$_smarty_tpl->getVariable('smarty')->value['foreach']['products']['last']==true){?>
			     					</ul>
			     				</div>
			  				<?php }?>
						<?php }} ?>
						
						<!-- /Products list -->
					<?php }?>
			   
			   </div>
			   
			</div>
			
			<!-- "next page" action -->
			<a class="next browse right" style="display:block;">Next</a>
		</div>
		</div>
		</div>
		<?php }?>
		<?php if (isset($_smarty_tpl->getVariable('seo_keywords',null,true,false)->value)){?>
		<div style="clear:both;padding:10px 0px;;">
			<h2 class="panel_heading">Other popular products</h2>
			<?php  $_smarty_tpl->tpl_vars['keyword'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('seo_keywords')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['keyword']->key => $_smarty_tpl->tpl_vars['keyword']->value){
?>
				<span class="popular_products"><a title="<?php echo $_smarty_tpl->tpl_vars['keyword']->value['keyword'];?>
" href="http://<?php echo $_smarty_tpl->tpl_vars['keyword']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['keyword']->value['keyword'];?>
</a></span>
			<?php }} ?>
		</div>
		<?php }?>
	<?php }else{ ?>
		<p class="warning"><?php echo smartyTranslate(array('s'=>'No products for this manufacturer.'),$_smarty_tpl);?>
</p>
	<?php }?>
<?php }?>

<!-- Google Code for Master List Remarketing List -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 968757656;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "666666";
var google_conversion_label = "sYcMCJjCuwMQmKP4zQM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/968757656/?label=sYcMCJjCuwMQmKP4zQM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

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
