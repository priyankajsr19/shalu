<?php /* Smarty version Smarty-3.0.7, created on 2015-07-25 19:49:35
         compiled from "/var/www/html/indusdiva/themes/violettheme/modules/blockuserinfo/blockuserinfo.tpl" */ ?>
<?php /*%%SmartyHeaderCode:151377150455b39af7c73696-53829350%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd0c9e25531967c0d816a6478ebda1d4ec1a134b3' => 
    array (
      0 => '/var/www/html/indusdiva/themes/violettheme/modules/blockuserinfo/blockuserinfo.tpl',
      1 => 1436950722,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '151377150455b39af7c73696-53829350',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/var/www/html/indusdiva/tools/smarty/plugins/modifier.escape.php';
if (!is_callable('smarty_modifier_replace')) include '/var/www/html/indusdiva/tools/smarty/plugins/modifier.replace.php';
?><?php if ($_smarty_tpl->getVariable('page_name')->value!='order'&&!isset($_smarty_tpl->getVariable('hide_header',null,true,false)->value)){?>
<!-- Block user information module HEADER -->
<!--a href="/products/blackfridayfinal" style="float:left; width:50px;" class="salebtn">SALE</a-->
<div id="header_user">	
	<div id="header_nav" class="clearfix">
		<div id="shopping-bag" class="clearfix" style="float:right">
		<?php if (!$_smarty_tpl->getVariable('PS_CATALOG_MODE')->value){?>
			<a rel="nofollow" id="lnk_shopping_bag" class="lnk_shopping_bag" href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink(($_smarty_tpl->getVariable('order_process')->value).".php",true);?>
" >
				<div style="width:150px" class="clearfix">
					<div class="sbagtxt">
						Shopping Bag <?php if ($_smarty_tpl->getVariable('cart_qties')->value>0){?>(<?php echo $_smarty_tpl->getVariable('cart_qties')->value;?>
)<?php }?>
					</div>
					<img alt="shopping bag" sytle="float:right" src="<?php echo $_smarty_tpl->getVariable('img_dir')->value;?>
diva_sbag.png" width="24px" height="35px"/>
				</div>
			</a>
		<?php }?>
		</div>
	</div>
	<?php if ($_smarty_tpl->getVariable('ajax_allowed')->value){?>
<script type="text/javascript">
var CUSTOMIZE_TEXTFIELD = <?php echo $_smarty_tpl->getVariable('CUSTOMIZE_TEXTFIELD')->value;?>
;
var customizationIdMessage = '<?php echo smartyTranslate(array('s'=>'Customization #','mod'=>'blockcart','js'=>1),$_smarty_tpl);?>
';
var removingLinkText = '<?php echo smartyTranslate(array('s'=>'remove this product from my bag','mod'=>'blockcart','js'=>1),$_smarty_tpl);?>
';
</script>
<?php }?>


<!-- MODULE Block cart -->
<div id="cart_block" class="block exclusive" style="display:none;">
	
	<div class="cart_popup">
	<!-- block summary -->
	<div id="cart_block_summary" class="<?php if (isset($_smarty_tpl->getVariable('colapseExpandStatus',null,true,false)->value)&&$_smarty_tpl->getVariable('colapseExpandStatus')->value=='expanded'||!$_smarty_tpl->getVariable('ajax_allowed')->value||!isset($_smarty_tpl->getVariable('colapseExpandStatus',null,true,false)->value)){?>collapsed<?php }else{ ?>expanded<?php }?>">
		<span class="ajax_cart_quantity" <?php if ($_smarty_tpl->getVariable('cart_qties')->value<=0){?>style="display:none;"<?php }?>><?php echo $_smarty_tpl->getVariable('cart_qties')->value;?>
</span>
		<span class="ajax_cart_product_txt_s" <?php if ($_smarty_tpl->getVariable('cart_qties')->value<=1){?>style="display:none"<?php }?>><?php echo smartyTranslate(array('s'=>'products','mod'=>'blockcart'),$_smarty_tpl);?>
</span>
		<span class="ajax_cart_product_txt" <?php if ($_smarty_tpl->getVariable('cart_qties')->value>1){?>style="display:none"<?php }?>><?php echo smartyTranslate(array('s'=>'product','mod'=>'blockcart'),$_smarty_tpl);?>
</span>
		<span class="ajax_cart_total" <?php if ($_smarty_tpl->getVariable('cart_qties')->value<=0){?>style="display:none"<?php }?>><?php if ($_smarty_tpl->getVariable('priceDisplay')->value==1){?><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->getVariable('cart')->value->getOrderTotal(false)),$_smarty_tpl);?>
<?php }else{ ?><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->getVariable('cart')->value->getOrderTotal(true)),$_smarty_tpl);?>
<?php }?></span>
		<span class="ajax_cart_no_product" <?php if ($_smarty_tpl->getVariable('cart_qties')->value!=0){?>style="display:none"<?php }?>><?php echo smartyTranslate(array('s'=>'(empty)','mod'=>'blockcart'),$_smarty_tpl);?>
</span>
	</div>
	<!-- block list of products -->
	<div id="cart_block_list" class="<?php if (isset($_smarty_tpl->getVariable('colapseExpandStatus',null,true,false)->value)&&$_smarty_tpl->getVariable('colapseExpandStatus')->value=='expanded'||!$_smarty_tpl->getVariable('ajax_allowed')->value||!isset($_smarty_tpl->getVariable('colapseExpandStatus',null,true,false)->value)){?>expanded<?php }else{ ?>collapsed<?php }?>">
	<?php if ($_smarty_tpl->getVariable('products')->value){?>
		<dl class="products">
		<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['product']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['product']->iteration=0;
 $_smarty_tpl->tpl_vars['product']->index=-1;
if ($_smarty_tpl->tpl_vars['product']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
 $_smarty_tpl->tpl_vars['product']->iteration++;
 $_smarty_tpl->tpl_vars['product']->index++;
 $_smarty_tpl->tpl_vars['product']->first = $_smarty_tpl->tpl_vars['product']->index === 0;
 $_smarty_tpl->tpl_vars['product']->last = $_smarty_tpl->tpl_vars['product']->iteration === $_smarty_tpl->tpl_vars['product']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['first'] = $_smarty_tpl->tpl_vars['product']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['last'] = $_smarty_tpl->tpl_vars['product']->last;
?>
			<?php $_smarty_tpl->tpl_vars['productId'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['id_product'], null, null);?>
			<?php $_smarty_tpl->tpl_vars['productAttributeId'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['id_product_attribute'], null, null);?>
			<dt id="cart_block_product_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
<?php if ($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']){?>_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
<?php }?>" class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['first']){?>first_item<?php }elseif($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['last']){?>last_item<?php }else{ ?>item<?php }?>">
				<a class="cart_block_product_name" href="<?php echo $_smarty_tpl->getVariable('link')->value->getProductLink($_smarty_tpl->tpl_vars['product']->value['id_product'],$_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['category']);?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['name'],'html','UTF-8');?>
">
				<?php echo smarty_modifier_escape(smarty_modifier_truncate($_smarty_tpl->tpl_vars['product']->value['name'],100,'...'),'html','UTF-8');?>
</a>
				<span class="quantity-formated"><span class="quantity"><?php echo $_smarty_tpl->tpl_vars['product']->value['cart_quantity'];?>
</span></span>
				
				<span class="price"><?php if ($_smarty_tpl->getVariable('priceDisplay')->value==@PS_TAX_EXC){?><?php echo Product::displayWtPrice(array('p'=>($_smarty_tpl->tpl_vars['product']->value['total'])),$_smarty_tpl);?>
<?php }else{ ?><?php echo Product::displayWtPrice(array('p'=>($_smarty_tpl->tpl_vars['product']->value['total_wt'])),$_smarty_tpl);?>
<?php }?></span>
			</dt>
			<?php if (isset($_smarty_tpl->tpl_vars['product']->value['attributes_small'])){?>
			<dd id="cart_block_combination_of_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
<?php if ($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']){?>_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
<?php }?>" class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['first']){?>first_item<?php }elseif($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['last']){?>last_item<?php }else{ ?>item<?php }?>">
				<a href="<?php echo $_smarty_tpl->getVariable('link')->value->getProductLink($_smarty_tpl->tpl_vars['product']->value['id_product'],$_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['category']);?>
" title="<?php echo smartyTranslate(array('s'=>'Product detail'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['product']->value['attributes_small'];?>
</a>
			<?php }?>

			<!-- Customizable datas -->
			<?php if (isset($_smarty_tpl->getVariable('customizedDatas',null,true,false)->value[$_smarty_tpl->getVariable('productId',null,true,false)->value][$_smarty_tpl->getVariable('productAttributeId',null,true,false)->value])){?>
				<?php if (!isset($_smarty_tpl->tpl_vars['product']->value['attributes_small'])){?><dd id="cart_block_combination_of_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
<?php if ($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']){?>_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
<?php }?>" class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['first']){?>first_item<?php }elseif($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['last']){?>last_item<?php }else{ ?>item<?php }?>"><?php }?>
				<ul class="cart_block_customizations" id="customization_<?php echo $_smarty_tpl->getVariable('productId')->value;?>
_<?php echo $_smarty_tpl->getVariable('productAttributeId')->value;?>
">
					<?php  $_smarty_tpl->tpl_vars['customization'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['id_customization'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('customizedDatas')->value[$_smarty_tpl->getVariable('productId')->value][$_smarty_tpl->getVariable('productAttributeId')->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['customization']->key => $_smarty_tpl->tpl_vars['customization']->value){
 $_smarty_tpl->tpl_vars['id_customization']->value = $_smarty_tpl->tpl_vars['customization']->key;
?>
						<li name="customization">
							<div class="deleteCustomizableProduct" id="deleteCustomizableProduct_<?php echo intval($_smarty_tpl->tpl_vars['id_customization']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']);?>
"><a class="ajax_cart_block_remove_link" href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('cart.php');?>
?delete&amp;id_product=<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
&amp;ipa=<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']);?>
&amp;id_customization=<?php echo $_smarty_tpl->tpl_vars['id_customization']->value;?>
&amp;token=<?php echo $_smarty_tpl->getVariable('static_token')->value;?>
"> </a></div>
							<span class="quantity-formated"><span class="quantity"><?php echo $_smarty_tpl->tpl_vars['customization']->value['quantity'];?>
</span>x</span><?php if (isset($_smarty_tpl->tpl_vars['customization']->value['datas'][$_smarty_tpl->getVariable('CUSTOMIZE_TEXTFIELD',null,true,false)->value][0])){?>
							<?php echo smarty_modifier_truncate(smarty_modifier_replace(smarty_modifier_escape($_smarty_tpl->tpl_vars['customization']->value['datas'][$_smarty_tpl->getVariable('CUSTOMIZE_TEXTFIELD')->value][0]['value'],'html','UTF-8'),"<br />"," "),28);?>

							<?php }else{ ?>
							<?php echo smartyTranslate(array('s'=>'Customization #','mod'=>'blockcart'),$_smarty_tpl);?>
<?php echo intval($_smarty_tpl->tpl_vars['id_customization']->value);?>
<?php echo smartyTranslate(array('s'=>':','mod'=>'blockcart'),$_smarty_tpl);?>

							<?php }?>
						</li>
					<?php }} ?>
				</ul>
				<?php if (!isset($_smarty_tpl->tpl_vars['product']->value['attributes_small'])){?></dd><?php }?>
			<?php }?>

			<?php if (isset($_smarty_tpl->tpl_vars['product']->value['attributes_small'])){?></dd><?php }?>

		<?php }} ?>
		</dl>
	<?php }?>
		<p <?php if ($_smarty_tpl->getVariable('products')->value){?>class="hidden"<?php }?> id="cart_block_no_products"><?php echo smartyTranslate(array('s'=>'No items','mod'=>'blockcart'),$_smarty_tpl);?>
</p>

		<?php if (count($_smarty_tpl->getVariable('discounts')->value)>0){?><table id="vouchers">
			<tbody>
			<?php  $_smarty_tpl->tpl_vars['discount'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('discounts')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['discount']->key => $_smarty_tpl->tpl_vars['discount']->value){
?>
				<tr class="bloc_cart_voucher" id="bloc_cart_voucher_<?php echo $_smarty_tpl->tpl_vars['discount']->value['id_discount'];?>
">
					<td class="name" title="<?php echo $_smarty_tpl->tpl_vars['discount']->value['description'];?>
"><?php echo smarty_modifier_escape(smarty_modifier_truncate((($_smarty_tpl->tpl_vars['discount']->value['name']).(' : ')).($_smarty_tpl->tpl_vars['discount']->value['description']),24,'...'),'htmlall','UTF-8');?>
</td>
					<td class="price">-<?php if ($_smarty_tpl->tpl_vars['discount']->value['value_real']!='!'){?><?php if ($_smarty_tpl->getVariable('priceDisplay')->value==1){?><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->tpl_vars['discount']->value['value_tax_exc']),$_smarty_tpl);?>
<?php }else{ ?><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->tpl_vars['discount']->value['value_real']),$_smarty_tpl);?>
<?php }?><?php }?></td>
					<td class="delete"><a href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink(($_smarty_tpl->getVariable('order_process')->value).".php",true);?>
?deleteDiscount=<?php echo $_smarty_tpl->tpl_vars['discount']->value['id_discount'];?>
" title="<?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->getVariable('img_dir')->value;?>
icon/delete.jpeg" alt="<?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>
" width="10" height="10" class="icon" /></a></td>
				</tr>
			<?php }} ?>
			</tbody>
		</table>
		<?php }?>

		<p id="cart-prices">
			<?php if ($_smarty_tpl->getVariable('shipping_cost')->value>0){?>
			<span><?php echo smartyTranslate(array('s'=>'Shipping Extra','mod'=>'blockcart'),$_smarty_tpl);?>
</span>
			<?php }else{ ?>
			<span>Shipping Extra</span>
			<?php }?>
			<span id="cart_block_shipping_cost" class="price ajax_cart_shipping_cost" style="display:none"><?php echo $_smarty_tpl->getVariable('shipping_cost')->value;?>
</span>
			<br/>
			<?php if ($_smarty_tpl->getVariable('show_wrapping')->value){?>
				<?php $_smarty_tpl->tpl_vars['blockcart_cart_flag'] = new Smarty_variable(constant('Cart::ONLY_WRAPPING'), null, null);?>
				<span><?php echo smartyTranslate(array('s'=>'Wrapping','mod'=>'blockcart'),$_smarty_tpl);?>
</span>
				<span id="cart_block_wrapping_cost" class="price cart_block_wrapping_cost"><?php if ($_smarty_tpl->getVariable('priceDisplay')->value==1){?><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->getVariable('cart')->value->getOrderTotal(false,$_smarty_tpl->getVariable('blockcart_cart_flag')->value)),$_smarty_tpl);?>
<?php }else{ ?><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->getVariable('cart')->value->getOrderTotal(true,$_smarty_tpl->getVariable('blockcart_cart_flag')->value)),$_smarty_tpl);?>
<?php }?></span>
				<br/>
			<?php }?>
			<?php if ($_smarty_tpl->getVariable('show_tax')->value&&isset($_smarty_tpl->getVariable('tax_cost',null,true,false)->value)){?>
				<span><?php echo smartyTranslate(array('s'=>'Tax','mod'=>'blockcart'),$_smarty_tpl);?>
</span>
				<span id="cart_block_tax_cost" class="price ajax_cart_tax_cost"><?php echo $_smarty_tpl->getVariable('tax_cost')->value;?>
</span>
				<br/>
			<?php }?>
			<span><?php echo smartyTranslate(array('s'=>'Total products','mod'=>'blockcart'),$_smarty_tpl);?>
</span>
			<span id="cart_block_total" class="price ajax_block_cart_total"><?php echo $_smarty_tpl->getVariable('total_products')->value;?>
</span>
		</p>
		<?php if ($_smarty_tpl->getVariable('use_taxes')->value&&$_smarty_tpl->getVariable('display_tax_label')->value==1&&$_smarty_tpl->getVariable('show_tax')->value){?>
			<?php if ($_smarty_tpl->getVariable('priceDisplay')->value==0){?>
				<p id="cart-price-precisions">
					<?php echo smartyTranslate(array('s'=>'Prices are tax included','mod'=>'blockcart'),$_smarty_tpl);?>

				</p>
			<?php }?>
			<?php if ($_smarty_tpl->getVariable('priceDisplay')->value==1){?>
				<p id="cart-price-precisions">
					<?php echo smartyTranslate(array('s'=>'Prices are tax excluded','mod'=>'blockcart'),$_smarty_tpl);?>

				</p>
			<?php }?>
		<?php }?>
		<p id="cart-buttons">
			<a rel="nofollow" href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink(($_smarty_tpl->getVariable('order_process')->value).".php",true);?>
<?php if ($_smarty_tpl->getVariable('order_process')->value=='order'){?>?step=0<?php }?>" id="button_order_cart" style="<?php if (!$_smarty_tpl->getVariable('products')->value){?>display:none<?php }?>" title="<?php echo smartyTranslate(array('s'=>'Place Order','mod'=>'blockcart'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Place Order','mod'=>'blockcart'),$_smarty_tpl);?>
</a>
		</p>
	</div>
	</div>
</div>
</div>
<!-- /Block user information module HEADER -->
<?php }?>
