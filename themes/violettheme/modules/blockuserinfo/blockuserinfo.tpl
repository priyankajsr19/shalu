{if $page_name!='order' && !isset($hide_header)}
<!-- Block user information module HEADER -->
{*
<div id="fconnect-panel">
{if isset($fblogin_url)}
	<a rel="nofollow" href="{$fblogin_url}" class="fconnect-button">
		<img src="{$img_ps_dir}facebook-btn.jpg" alt="login with facebook" height="20px"/>
	</a>
{/if}

</div>
*}
<!--a href="/products/blackfridayfinal" style="float:left; width:50px;" class="salebtn">SALE</a-->
<div id="header_user">
{*
	 {literal} 
		<script type="text/javascript">

			(function($) {
				$.fn.hoverIntent = function(f,g) {
					var cfg = {
						sensitivity: 7,
						interval: 100,
						timeout: 0
					};
					cfg = $.extend(cfg, g ? { over: f, out: g } : f );
	
					var cX, cY, pX, pY;
	
					var track = function(ev) {
						cX = ev.pageX;
						cY = ev.pageY;
					};
	
					var compare = function(ev,ob) {
						ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
						if ( ( Math.abs(pX-cX) + Math.abs(pY-cY) ) < cfg.sensitivity ) {
							$(ob).unbind("mousemove",track);
							ob.hoverIntent_s = 1;
							return cfg.over.apply(ob,[ev]);
						} else {
							pX = cX; pY = cY;
							ob.hoverIntent_t = setTimeout( function(){compare(ev, ob);} , cfg.interval );
						}
					};
	
					var delay = function(ev,ob) {
						ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
						ob.hoverIntent_s = 0;
						return cfg.out.apply(ob,[ev]);
					};
	
					var handleHover = function(e) {
						var ev = jQuery.extend({},e);
						var ob = this;
	
						if (ob.hoverIntent_t) { ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t); }
	
						if (e.type == "mouseenter") {
							pX = ev.pageX; pY = ev.pageY;
							$(ob).bind("mousemove",track);
							if (ob.hoverIntent_s != 1) { ob.hoverIntent_t = setTimeout( function(){compare(ev,ob);} , cfg.interval );}
	
						} else {
							$(ob).unbind("mousemove",track);
							if (ob.hoverIntent_s == 1) { ob.hoverIntent_t = setTimeout( function(){delay(ev,ob);} , cfg.timeout );}
						}
					};
	
					return this.bind('mouseenter',handleHover).bind('mouseleave',handleHover);
				};
			})(jQuery);
			function makeTall(e){
                $("#cart_block").slideDown("slow");
            }
			function makeSmall(e){
                $("#cart_block").slideUp("slow");
            }
			
       		$(document).ready(function() {
       			var config = {    
       			     over: makeTall,     
       			     timeout: 100,     
       			     out: makeSmall, 
       			     sensitivity: 1,
       			     interval:100
       			};
	            $("#header_user").hoverIntent(config);
	            config = {    
	       			     over: function(e){
		       					id=$(this).attr('rel');
		       					$('#ajax_id_product_'+id).fadeIn('slow');
		       					},
	       			     timeout: 500,    
	       			     out: function hideButton(){
			       					id=$(this).attr('rel');
			       					$('#ajax_id_product_'+id).hide();;
			       				}, 
	       			     sensitivity: 3,
	       			     interval:100
	       			};
	            $('.ajax_block_product').hoverIntent(config);
        	});
		
		</script>
		
	{/literal}
*}	
	<div id="header_nav" class="clearfix">
		<div id="shopping-bag" class="clearfix" style="float:right">
		{*<div style="text-align: right; float: left; padding-top: 11px;color:#939393">YOUR<br/>SHOPPING BAG</div>*}
		{if !$PS_CATALOG_MODE}
			<a rel="nofollow" id="lnk_shopping_bag" class="lnk_shopping_bag" href="{$link->getPageLink("$order_process.php", true)}" >
				<div style="width:150px" class="clearfix">
					<div class="sbagtxt">
						Shopping Bag {if $cart_qties > 0}({$cart_qties}){/if}
					</div>
					<img alt="shopping bag" sytle="float:right" src="{$img_dir}diva_sbag.png" width="24px" height="35px"/>
				</div>
			</a>
		{/if}
		</div>
	</div>
	{if $ajax_allowed}
<script type="text/javascript">
var CUSTOMIZE_TEXTFIELD = {$CUSTOMIZE_TEXTFIELD};
var customizationIdMessage = '{l s='Customization #' mod='blockcart' js=1}';
var removingLinkText = '{l s='remove this product from my bag' mod='blockcart' js=1}';
</script>
{/if}


<!-- MODULE Block cart -->
<div id="cart_block" class="block exclusive" style="display:none;">
	
	<div class="cart_popup">
	<!-- block summary -->
	<div id="cart_block_summary" class="{if isset($colapseExpandStatus) && $colapseExpandStatus eq 'expanded' || !$ajax_allowed || !isset($colapseExpandStatus)}collapsed{else}expanded{/if}">
		<span class="ajax_cart_quantity" {if $cart_qties <= 0}style="display:none;"{/if}>{$cart_qties}</span>
		<span class="ajax_cart_product_txt_s" {if $cart_qties <= 1}style="display:none"{/if}>{l s='products' mod='blockcart'}</span>
		<span class="ajax_cart_product_txt" {if $cart_qties > 1}style="display:none"{/if}>{l s='product' mod='blockcart'}</span>
		<span class="ajax_cart_total" {if $cart_qties <= 0}style="display:none"{/if}>{if $priceDisplay == 1}{convertPrice price=$cart->getOrderTotal(false)}{else}{convertPrice price=$cart->getOrderTotal(true)}{/if}</span>
		<span class="ajax_cart_no_product" {if $cart_qties != 0}style="display:none"{/if}>{l s='(empty)' mod='blockcart'}</span>
	</div>
	<!-- block list of products -->
	<div id="cart_block_list" class="{if isset($colapseExpandStatus) && $colapseExpandStatus eq 'expanded' || !$ajax_allowed || !isset($colapseExpandStatus)}expanded{else}collapsed{/if}">
	{if $products}
		<dl class="products">
		{foreach from=$products item='product' name='myLoop'}
			{assign var='productId' value=$product.id_product}
			{assign var='productAttributeId' value=$product.id_product_attribute}
			<dt id="cart_block_product_{$product.id_product}{if $product.id_product_attribute}_{$product.id_product_attribute}{/if}" class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if}">
				<a class="cart_block_product_name" href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category)}" title="{$product.name|escape:html:'UTF-8'}">
				{$product.name|truncate:100:'...'|escape:html:'UTF-8'}</a>
				<span class="quantity-formated"><span class="quantity">{$product.cart_quantity}</span></span>
				
				<span class="price">{if $priceDisplay == $smarty.const.PS_TAX_EXC}{displayWtPrice p="`$product.total`"}{else}{displayWtPrice p="`$product.total_wt`"}{/if}</span>
				{*<span class="remove_link">{if !isset($customizedDatas.$productId.$productAttributeId)}<a rel="nofollow" class="ajax_cart_block_remove_link" href="{$link->getPageLink('cart.php')}?delete&amp;id_product={$product.id_product}&amp;ipa={$product.id_product_attribute}&amp;token={$static_token}" title="{l s='remove this product from my cart' mod='blockcart'}">&nbsp;</a>{/if}</span>*}
			</dt>
			{if isset($product.attributes_small)}
			<dd id="cart_block_combination_of_{$product.id_product}{if $product.id_product_attribute}_{$product.id_product_attribute}{/if}" class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if}">
				<a href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category)}" title="{l s='Product detail'}">{$product.attributes_small}</a>
			{/if}

			<!-- Customizable datas -->
			{if isset($customizedDatas.$productId.$productAttributeId)}
				{if !isset($product.attributes_small)}<dd id="cart_block_combination_of_{$product.id_product}{if $product.id_product_attribute}_{$product.id_product_attribute}{/if}" class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if}">{/if}
				<ul class="cart_block_customizations" id="customization_{$productId}_{$productAttributeId}">
					{foreach from=$customizedDatas.$productId.$productAttributeId key='id_customization' item='customization' name='customizations'}
						<li name="customization">
							<div class="deleteCustomizableProduct" id="deleteCustomizableProduct_{$id_customization|intval}_{$product.id_product|intval}_{$product.id_product_attribute|intval}"><a class="ajax_cart_block_remove_link" href="{$link->getPageLink('cart.php')}?delete&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;id_customization={$id_customization}&amp;token={$static_token}"> </a></div>
							<span class="quantity-formated"><span class="quantity">{$customization.quantity}</span>x</span>{if isset($customization.datas.$CUSTOMIZE_TEXTFIELD.0)}
							{$customization.datas.$CUSTOMIZE_TEXTFIELD.0.value|escape:html:'UTF-8'|replace:"<br />":" "|truncate:28}
							{else}
							{l s='Customization #' mod='blockcart'}{$id_customization|intval}{l s=':' mod='blockcart'}
							{/if}
						</li>
					{/foreach}
				</ul>
				{if !isset($product.attributes_small)}</dd>{/if}
			{/if}

			{if isset($product.attributes_small)}</dd>{/if}

		{/foreach}
		</dl>
	{/if}
		<p {if $products}class="hidden"{/if} id="cart_block_no_products">{l s='No items' mod='blockcart'}</p>

		{if $discounts|@count > 0}<table id="vouchers">
			<tbody>
			{foreach from=$discounts item=discount}
				<tr class="bloc_cart_voucher" id="bloc_cart_voucher_{$discount.id_discount}">
					<td class="name" title="{$discount.description}">{$discount.name|cat:' : '|cat:$discount.description|truncate:24:'...'|escape:'htmlall':'UTF-8'}</td>
					<td class="price">-{if $discount.value_real != '!'}{if $priceDisplay == 1}{convertPrice price=$discount.value_tax_exc}{else}{convertPrice price=$discount.value_real}{/if}{/if}</td>
					<td class="delete"><a href="{$link->getPageLink("$order_process.php", true)}?deleteDiscount={$discount.id_discount}" title="{l s='Delete'}"><img src="{$img_dir}icon/delete.jpeg" alt="{l s='Delete'}" width="10" height="10" class="icon" /></a></td>
				</tr>
			{/foreach}
			</tbody>
		</table>
		{/if}

		<p id="cart-prices">
			{if $shipping_cost > 0}
			<span>{l s='Shipping Extra' mod='blockcart'}</span>
			{else}
			<span>Shipping Extra</span>
			{/if}
			<span id="cart_block_shipping_cost" class="price ajax_cart_shipping_cost" style="display:none">{$shipping_cost}</span>
			<br/>
			{if $show_wrapping}
				{assign var='blockcart_cart_flag' value='Cart::ONLY_WRAPPING'|constant}
				<span>{l s='Wrapping' mod='blockcart'}</span>
				<span id="cart_block_wrapping_cost" class="price cart_block_wrapping_cost">{if $priceDisplay == 1}{convertPrice price=$cart->getOrderTotal(false, $blockcart_cart_flag)}{else}{convertPrice price=$cart->getOrderTotal(true, $blockcart_cart_flag)}{/if}</span>
				<br/>
			{/if}
			{if $show_tax && isset($tax_cost)}
				<span>{l s='Tax' mod='blockcart'}</span>
				<span id="cart_block_tax_cost" class="price ajax_cart_tax_cost">{$tax_cost}</span>
				<br/>
			{/if}
			<span>{l s='Total products' mod='blockcart'}</span>
			<span id="cart_block_total" class="price ajax_block_cart_total">{$total_products}</span>
		</p>
		{if $use_taxes && $display_tax_label == 1 && $show_tax}
			{if $priceDisplay == 0}
				<p id="cart-price-precisions">
					{l s='Prices are tax included' mod='blockcart'}
				</p>
			{/if}
			{if $priceDisplay == 1}
				<p id="cart-price-precisions">
					{l s='Prices are tax excluded' mod='blockcart'}
				</p>
			{/if}
		{/if}
		<p id="cart-buttons">
			<a rel="nofollow" href="{$link->getPageLink("$order_process.php", true)}{if $order_process == 'order'}?step=0{/if}" id="button_order_cart" style="{if !$products}display:none{/if}" title="{l s='Place Order' mod='blockcart'}">{l s='Place Order' mod='blockcart'}</a>
		</p>
	</div>
	</div>
</div>
</div>
<!-- /Block user information module HEADER -->
{/if}
