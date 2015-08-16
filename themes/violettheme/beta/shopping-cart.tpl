{include file="$tpl_dir./errors.tpl"}
{if isset($empty)}
	<p class="warning">{l s='Your shopping cart is empty.'}</p>
{elseif $PS_CATALOG_MODE}
	<p class="warning">{l s='This store has not accepted your new order.'}</p>
{else}
	<script type="text/javascript">
	// <![CDATA[
	var baseDir = '{$base_dir_ssl}';
	var currencySign = '{$currencySign|html_entity_decode:2:"UTF-8"}';
	var currencyRate = '{$currencyRate|floatval}';
	var currencyFormat = '{$currencyFormat|intval}';
	var currencyBlank = '{$currencyBlank|intval}';
	var txtProduct = "{l s='product'}";
	var txtProducts = "{l s='products'}";
	// ]]>
	</script>
	<p style="display:none" id="emptyCartWarning" class="warning">{l s='Your shopping cart is empty.'}</p>

{* MOD: remove last added product
*	
*	{if isset($lastProductAdded) AND $lastProductAdded}
*		{foreach from=$products item=product}
*			{if $product.id_product == $lastProductAdded.id_product AND (!$product.id_product_attribute OR ($product.id_product_attribute == $lastProductAdded.id_product_attribute))}
*				<div class="cart_last_product">
*					<div class="cart_last_product_header">
*						<div class="left">{l s='Last added product'}</div>
*					</div>
*					<a  class="cart_last_product_img" href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category)|escape:'htmlall':'UTF-8'}"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'small')}" alt="{$product.name|escape:'htmlall':'UTF-8'}"/></a>
*					<div class="cart_last_product_content">
*						<h5><a href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category)|escape:'htmlall':'UTF-8'}">{$product.name|escape:'htmlall':'UTF-8'}</a></h5>
*						{if isset($product.attributes) && $product.attributes}<a href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category)|escape:'htmlall':'UTF-8'}">{$product.attributes|escape:'htmlall':'UTF-8'}</a>{/if}
*					</div>
*					<br class="clear" />
*				</div>
*			{/if}
*		{/foreach}
*	{/if}
*}

{*<p>{l s='Your shopping cart contains'} <span id="summary_products_quantity">{$productNumber} {if $productNumber == 1}{l s='product'}{else}{l s='products'}{/if}</span></p>*}
<div id="co_content">
	<div id="co_left_column">
		<div id="order-detail-content" class="table_block" style="width:750px;margin:0 7px;">
			<table id="cart_summary" class="std">
				<thead>
					<tr>
						<th class="cart_product first_item">{l s='Product'}</th>
						<th class="cart_description item" style="text-align:left;">{l s='Description'}</th>
						{*<th class="cart_ref item">{l s='Ref.'}</th>*}
						<th class="cart_availability item">{l s='Availablity'}</th>
						<th class="cart_unit item" style="text-align:right;">{l s='Unit price'}</th>
						<th class="cart_quantity item">{l s='Qty'}</th>
						<th class="cart_total last_item" style="text-align:right;">{l s='Sub Total'}</th>
					</tr>
				</thead>
				<tfoot>
					{if $use_taxes}
						{if $priceDisplay}
							<tr class="cart_total_price">
								<td colspan="5">{l s='Sub Total'}{if $display_tax_label} {l s='(tax excl.)'}{/if}{l s=':'}</td>
								<td class="price" id="total_product">{displayPrice price=$total_products}</td>
							</tr>
						{else}
							<tr class="cart_total_price">
								<td colspan="5">{l s='Sub Total'}{l s=':'}</td>
								<td class="price" id="total_product">{displayPrice price=$total_products_wt}</td>
							</tr>
						{/if}
					{else}
						<tr class="cart_total_price">
							<td colspan="5">{l s='Total:'}</td>
							<td class="price" id="total_product">{displayPrice price=$total_products}</td>
						</tr>
					{/if}
					<tr class="cart_total_voucher" {if $total_discounts == 0}style="display: none;"{/if}>
						<td colspan="5">
						{if $use_taxes}
							{if $priceDisplay}
								{l s='Total vouchers/discounts'}{if $display_tax_label} {l s='(tax excl.)'}{/if}{l s=':'}
							{else}
								{l s='Total vouchers/discounts'}{if $display_tax_label} {l s='(tax incl.)'}{/if}{l s=':'}
							{/if}
						{else}
							{l s='Total vouchers:'}
						{/if}
						</td>
						<td class="price-discount" id="total_discount">
						{if $use_taxes}
							{if $priceDisplay}
								{displayPrice price=$total_discounts_tax_exc}
							{else}
								{displayPrice price=$total_discounts}
							{/if}
						{else}
							{displayPrice price=$total_discounts_tax_exc}
						{/if}
						</td>
					</tr>
					<tr class="cart_total_voucher" {if $total_wrapping == 0}style="display: none;"{/if}>
						<td colspan="5">
						{if $use_taxes}
							{if $priceDisplay}
								{l s='Total gift-wrapping'}{if $display_tax_label} {l s='(tax excl.)'}{/if}{l s=':'}
							{else}
								{l s='Total gift-wrapping'}{if $display_tax_label} {l s='(tax incl.)'}{/if}{l s=':'}
							{/if}
						{else}
							{l s='Total gift-wrapping:'}
						{/if}
						</td>
						<td class="price-discount" id="total_wrapping">
						{if $use_taxes}
							{if $priceDisplay}
								{displayPrice price=$total_wrapping_tax_exc}
							{else}
								{displayPrice price=$total_wrapping}
							{/if}
						{else}
							{displayPrice price=$total_wrapping_tax_exc}
						{/if}
						</td>
					</tr>
					{if $use_taxes}
						{if $priceDisplay}
							<tr class="cart_total_delivery" {if $shippingCost <= 0} style="display:none;"{/if}>
								<td colspan="5">{l s='Shipping'}{if $display_tax_label} {l s='(tax excl.)'}{/if}{l s=':'}</td>
								<td class="price" id="total_shipping">{displayPrice price=$shippingCostTaxExc}</td>
							</tr>
						{else}
							<tr class="cart_total_delivery"{if $shippingCost <= 0} style="display:none;"{/if}>
								<td colspan="5">{l s='Shipping'}{l s=':'}</td>
								<td class="price" id="total_shipping" >{displayPrice price=$shippingCost}</td>
							</tr>
						{/if}
					{else}
						<tr class="cart_total_delivery"{if $shippingCost <= 0} style="display:none;"{/if}>
							<td colspan="5">{l s='Shipping:'}</td>
							<td class="price" id="total_shipping" >{displayPrice price=$shippingCostTaxExc}</td>
						</tr>
					{/if}
		
		
					{if $use_taxes}
		{* MOD: remove tax
					<tr class="cart_total_price">
						<td colspan="5">
							{if $display_tax_label}
								{l s='Total (tax excl.):'}
							{else}
								{l s='Subtotal:'}
							{/if}
						</td>
						<td class="price" id="total_price_without_tax">{displayPrice price=$total_price_without_tax}</td>
					</tr>
					<tr class="cart_total_tax">
						<td colspan="5">
							{if $display_tax_label}
								{l s='Total tax:'}
							{else}
								{l s='Estimated Sales Tax:'}
							{/if}
						</td>
						<td class="price" id="total_tax">{displayPrice price=$total_tax}</td>
					</tr>
		*}
					<tr class="cart_total_price">
						<td colspan="5" style="font-size: 15px;">
							{if $display_tax_label}
								{l s='Order Total (tax incl.):'}
							{else}
								{l s='Total:'}
							{/if}
						</td>
						<td class="price" id="total_price">{displayPrice price=$total_price}</td>
					</tr>
		
					{else}
					<tr class="cart_total_price">
						<td colspan="5" style="font-size: 15px;">{l s='Total:'}</td>
						<td class="price" id="total_price">{displayPrice price=$total_price_without_tax}</td>
					</tr>
					{/if}
					{*
					<tr class="cart_free_shipping" {if $free_ship <= 0 || $isVirtualCart} style="display: none;" {/if}>
							<td colspan="5" style="white-space: normal;">{l s='Remaining amount to be added to your cart in order to obtain free shipping:'}</td>
							<td id="free_shipping" class="price">{displayPrice price=$free_ship}</td>
						</tr>
					*}
				</tfoot>
				<tbody>
				{foreach from=$products item=product name=productLoop}
					{assign var='productId' value=$product.id_product}
					{assign var='productAttributeId' value=$product.id_product_attribute}
					{assign var='quantityDisplayed' value=0}
					{* Display the product line *}
					{include file="$tpl_dir./shopping-cart-product-line.tpl"}
					{* Then the customized datas ones*}
					{if isset($customizedDatas.$productId.$productAttributeId)}
						{foreach from=$customizedDatas.$productId.$productAttributeId key='id_customization' item='customization'}
							<tr id="product_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}" class="alternate_item cart_item">
								<td colspan="5">
									{foreach from=$customization.datas key='type' item='datas'}
										{if $type == $CUSTOMIZE_FILE}
											<div class="customizationUploaded">
												<ul class="customizationUploaded">
													{foreach from=$datas item='picture'}<li><img src="{$pic_dir}{$picture.value}_small" alt="" class="customizationUploaded" /></li>{/foreach}
												</ul>
											</div>
										{elseif $type == $CUSTOMIZE_TEXTFIELD}
											<ul class="typedText">
												{foreach from=$datas item='textField' name='typedText'}<li>{if $textField.name}{$textField.name}{else}{l s='Text #'}{$smarty.foreach.typedText.index+1}{/if}{l s=':'} {$textField.value}</li>{/foreach}
											</ul>
										{/if}
									{/foreach}
								</td>
								<td class="cart_quantity">
									<div style="float:right">
										<a rel="nofollow" class="cart_quantity_delete" id="{$product.id_product}_{$product.id_product_attribute}_{$id_customization}" href="{$link->getPageLink('cart.php', true)}?delete&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;id_customization={$id_customization}&amp;token={$token_cart}"><img src="{$img_dir}icon/delete.gif" alt="{l s='Delete'}" title="{l s='Delete this customization'}" width="11" height="13" class="icon" /></a>
									</div>
									<div id="cart_quantity_button" style="float:left">
									<a rel="nofollow" class="cart_quantity_up" id="cart_quantity_up_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}" href="{$link->getPageLink('cart.php', true)}?add&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;id_customization={$id_customization}&amp;token={$token_cart}" title="{l s='Add'}"><img src="{$img_dir}icon/quantity_up.gif" alt="{l s='Add'}" width="14" height="9" /></a><br />
									{if $product.minimal_quantity < ($customization.quantity -$quantityDisplayed) OR $product.minimal_quantity <= 1}
									<a rel="nofollow" class="cart_quantity_down" id="cart_quantity_down_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}" href="{$link->getPageLink('cart.php', true)}?add&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;id_customization={$id_customization}&amp;op=down&amp;token={$token_cart}" title="{l s='Subtract'}">
										<img src="{$img_dir}icon/quantity_down.gif" alt="{l s='Subtract'}" width="14" height="9" />
									</a>
									{else}
									<a class="cart_quantity_down" style="opacity: 0.3;" id="cart_quantity_down_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}" href="#" title="{l s='Subtract'}">
										<img src="{$img_dir}icon/quantity_down.gif" alt="{l s='Subtract'}" width="14" height="9" />
									</a>
									{/if}
									</div>
									<input type="hidden" value="{$customization.quantity}" name="quantity_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}_hidden"/>
									<input size="2" type="text" value="{$customization.quantity}" class="cart_quantity_input" name="quantity_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}"/>
								</td>
								<td class="cart_total"></td>
							</tr>
							{assign var='quantityDisplayed' value=$quantityDisplayed+$customization.quantity}
						{/foreach}
						{* If it exists also some uncustomized products *}
						{if $product.quantity-$quantityDisplayed > 0}{include file="$tpl_dir./shopping-cart-product-line.tpl"}{/if}
					{/if}
				{/foreach}
				</tbody>
			{if sizeof($discounts) || isset($cart_points_discount) && $cart_points_discount > 0}
				<tbody>
				{foreach from=$discounts item=discount name=discountLoop}
					<tr class="cart_discount {if $smarty.foreach.discountLoop.last}last_item{elseif $smarty.foreach.discountLoop.first}first_item{else}item{/if}" id="cart_discount_{$discount.id_discount}">
						<td class="cart_discount_name" colspan="4" style="text-align:right">
							{$discount.name}
							{if $discount.description != ''}
								: {$discount.description}
							{/if}
						</td>
						{*<td class="cart_discount_description" colspan="2" style="text-align:right">{$discount.description}</td>*}
						<td class="cart_discount_delete"><a href="{if $opc}{$link->getPageLink('order-opc.php', true)}{else}{$link->getPageLink('order.php', true)}{/if}?deleteDiscount={$discount.id_discount}" title="{l s='Delete'}"><img src="{$img_dir}icon/delete.gif" alt="{l s='Delete'}" class="icon" width="11" height="13" /></a></td>
						<td class="cart_discount_price"><span class="price-discount">
							{if $discount.value_real > 0}
								{if !$priceDisplay}{displayPrice price=$discount.value_real*-1}{else}{displayPrice price=$discount.value_tax_exc*-1}{/if}
							{/if}
						</span></td>
					</tr>
				{/foreach}
				{if isset($cart_points_discount) && $cart_points_discount > 0}
					<tr class="cart_discount" id="cart_points">
						<td class="cart_discount_name" colspan="4" style="text-align:right">
							Violet Coins redeemed: {$cart_redeem_points}
						</td>
						{*<td class="cart_discount_description" colspan="2" style="text-align:right">{$discount.description}</td>*}
						<td class="cart_discount_delete"><a href="{if $opc}{$link->getPageLink('order-opc.php', true)}{else}{$link->getPageLink('order.php', true)}{/if}?deletePoints=1" title="{l s='Delete'}"><img src="{$img_dir}icon/delete.gif" alt="{l s='Delete'}" class="icon" width="11" height="13" /></a></td>
						<td class="cart_discount_price">
							<span class="price-discount">
								{displayPrice price=$cart_points_discount*-1}
							</span>
						</td>
					</tr>
				{/if}
				</tbody>
			{/if}
			</table>
		</div>
		
		{if $voucherAllowed}
		<div id="cart_redeem" style="padding: 0 0 30px 0">
			{if isset($errors_discount) && $errors_discount}
				<ul class="error">
				{foreach from=$errors_discount key=k item=error}
					<li>{$error|escape:'htmlall':'UTF-8'}</li>
				{/foreach}
				</ul>
			{/if}
			<div style="text-align:right;padding-right:0.7em;">
				<input type="checkbox" id="chk_redeem" class="redeem_check" >
				<label for="chk_redeem" style="font-size:12px;display:inline-block">{l s='Redeem Violet Coins or vouchers'}</label>
			</div>
			<form action="{if $opc}{$link->getPageLink('order-opc.php', true)}{else}{$link->getPageLink('order.php', true)}{/if}" method="post" id="voucher">
				<fieldset>
					<div style="padding:20px 20px 20px 150px;border-top:1px dashed #cacaca;border-bottom:1px dashed #cacaca;display:none;" class="redemption_control">
						<p>
							<span style="font-size:15px;width:175px;display:inline-block;{if !isset($can_redeem_points)}color:#939393{/if}">{l s='Redeem Violet Coins'}</span>
							{if isset($can_redeem_points) && (isset($balance_points) && $balance_points > 0) || isset($redeem_points) && $redeem_points > 0}
								<input type="text" id="redeem_points" name="redeem_points" value="{if isset($redeem_points) && $redeem_points}{$redeem_points}{/if}" />
								    <span style="font-size:12px;color:#939393;">[{$balance_points - $cart_redeem_points} Redeemable]</span>
							{else}
								<span style="font-size:11px;color:#939393">(You can redeem coins from third valid order)</span>
							{/if}
						</p>
						<p>
							<span style="font-size:15px;width:175px;display:inline-block">{l s='Use voucher (if any)'}</span>
							<input type="text" id="discount_name" name="discount_name" value="{if isset($discount_name) && $discount_name}{$discount_name}{/if}" />
						</p>
						<p class="submit" style="padding-left:275px;">
							<input type="hidden" name="submitDiscount" /><input type="submit" name="submitAddDiscount" value="{l s='Redeem!'}" class="button"/>
						</p>
					</div>
					{if $displayVouchers}
						<h4>{l s='Take advantage of our offers:'}</h4>
						<div id="display_cart_vouchers">
						{foreach from=$displayVouchers item=voucher}
							<span onclick="$('#discount_name').val('{$voucher.name}');return false;" class="voucher_name">{$voucher.name}</span> - {$voucher.description} <br />
						{/foreach}
						</div>
					{/if}
				</fieldset>
			</form>
		</div>
		{/if}
		<div id="HOOK_SHOPPING_CART">{$HOOK_SHOPPING_CART}</div>
		
		{* MOD: remove addressess from bottom of cart
		*	{if (($carrier->id AND !isset($virtualCart)) OR $delivery->id OR $invoice->id) AND !$opc}
		*	<div class="order_delivery">
		*		{if $delivery->id}
		*		<ul id="delivery_address" class="address item">
		*			<li class="address_title">{l s='Delivery address'}</li>
		*			{if $delivery->company}<li class="address_company">{$delivery->company|escape:'htmlall':'UTF-8'}</li>{/if}
		*			<li class="address_name">{$delivery->firstname|escape:'htmlall':'UTF-8'} {$delivery->lastname|escape:'htmlall':'UTF-8'}</li>
		*			<li class="address_address1">{$delivery->address1|escape:'htmlall':'UTF-8'}</li>
		*			{if $delivery->address2}<li class="address_address2">{$delivery->address2|escape:'htmlall':'UTF-8'}</li>{/if}
		*			<li class="address_city">{$delivery->postcode|escape:'htmlall':'UTF-8'} {$delivery->city|escape:'htmlall':'UTF-8'}</li>
		*			<li class="address_country">{$delivery->country|escape:'htmlall':'UTF-8'} {if $delivery_state}({$delivery_state|escape:'htmlall':'UTF-8'}){/if}</li>
		*		</ul>
		*		{/if}
		*		{if $invoice->id}
		*		<ul id="invoice_address" class="address alternate_item">
		*			<li class="address_title">{l s='Invoice address'}</li>
		*			{if $invoice->company}<li class="address_company">{$invoice->company|escape:'htmlall':'UTF-8'}</li>{/if}
		*			<li class="address_name">{$invoice->firstname|escape:'htmlall':'UTF-8'} {$invoice->lastname|escape:'htmlall':'UTF-8'}</li>
		*			<li class="address_address1">{$invoice->address1|escape:'htmlall':'UTF-8'}</li>
		*			{if $invoice->address2}<li class="address_address2">{$invoice->address2|escape:'htmlall':'UTF-8'}</li>{/if}
		*			<li class="address_city">{$invoice->postcode|escape:'htmlall':'UTF-8'} {$invoice->city|escape:'htmlall':'UTF-8'}</li>
		*			<li class="address_country">{$invoice->country|escape:'htmlall':'UTF-8'} {if $invoice_state}({$invoice_state|escape:'htmlall':'UTF-8'}){/if}</li>
		*		</ul>
		*		{/if}
		*		{if $carrier->id AND !isset($virtualCart)}
		*		<div id="order_carrier">
		*			<h4>{l s='Carrier:'}</h4>
		*			{if isset($carrierPicture)}<img src="{$img_ship_dir}{$carrier->id}.jpg" alt="{l s='Carrier'}" />{/if}
		*			<span>{$carrier->name|escape:'htmlall':'UTF-8'}</span>
		*		</div>
		*		{/if}
		*	</div>
		*	{/if}
		*}
		
		<div id="cart_navigation" class="cart_navigation">
			{if !$opc}
			<a id="place_order_button" rel="nofollow" href="{$link->getPageLink('order.php', true)}?step=1{if $back}&amp;back={$back}{/if}" class="placeorder"></a>{/if}
			<a rel="nofollow" href="{if (isset($smarty.server.HTTP_REFERER) && strstr($smarty.server.HTTP_REFERER, 'order.php')) || !isset($smarty.server.HTTP_REFERER)}{$link->getPageLink('index.php')}{else}{$smarty.server.HTTP_REFERER|escape:'htmlall':'UTF-8'|secureReferrer}{/if}" 
				class="button" title="{l s='Continue shopping'}" style="width:151px;margin-top:5px;float:left;margin-bottom:5px;">&laquo; {l s='Continue Shopping'}</a>
		</div>
		
		<div class="clear"></div>
		<p class="cart_navigation_extra">
			<span id="HOOK_SHOPPING_CART_EXTRA">{$HOOK_SHOPPING_CART_EXTRA}</span>
		</p>
		{/if}
		</div>
	{if !isset($summary_only) && !isset($empty)}
	<div id="co_rht_col">
		<div class="co_rht_box">
	   		<div id="order_summary_title" class="rht_box_heading">Order Summary</div>
	   		<div id="order_summary_content" class="rht_box_info">
	   		<table><tbody>
	   			{if $productNumber > 0}
	   			<tr>
	   				<td class="row_title">Items</td>
	   				<td>:</td>
	   				<td class="row_val"><span class="ajax_cart_quantity" style="font-size:12px;">{$productNumber}</span></td>
	   			</tr>
	   			<tr>
	   				<td class="row_title">Sub Total</td>
	   				<td>:</td>
	   				<td class="row_val"><span class="ajax_cart_total">{displayPrice price=$total_products_wt}</span></td>
	   			</tr>
	   			<tr>
	   				<td class="row_title">Shipping</td>
	   				<td>:</td>
	   				{if $shippingCost > 0}
	   					<td class="row_val"><span class="ajax_cart_shipping_cost" id="rht_bar_shipping">{displayPrice price=$shippingCost}</span></td>
	   				{else}
	   					<td class="row_val"><span id="rht_bar_shipping"> FREE</span></td>
	   				{/if}
	   			</tr>
	   			<tr><td height="5px" colspan="2"></td></tr>
	   			<tr>
	   				<td class="row_title"><span style="font-weight: bold; color:#5f5f5f;">Order Total</span></td>
	   				<td>:</td>
	   				<td class="row_val"><span style="font-weight:bold;" class="ajax_block_cart_total">{displayPrice price=$total_price}</span></td>
	   			</tr>
	   			{/if}
			</tbody></table>
	   		</div>
	   	</div>
	   	
	   	<div class="co_rht_box">
	   		<div id="free_shipping_info" class="rht_box_info cart_free_shipping" style="{if $free_ship > 0 AND !$isVirtualCart}display:block;{else}display:none;{/if}">
	   			
	   			<span id="free_shipping_balance" style="font-size: 13px; padding:5px 0px 5px 0px;">{displayPrice price=$free_ship}</span>
	   			<span>away from free shipping on your order!</span>
	   			<div style="font-size: 15px; padding:0px 10px;"></div>
	   		</div>
	   	</div>
	</div>
	{/if}
	{literal}
		<script type="text/javascript">
			$(document).ready(function(){
				$('#chk_redeem').removeAttr('checked');

				if($('#redeem_points').val() || $('#discount_name').val()) 
				{
					$('#chk_redeem').attr('checked','checked');
					$(".redemption_control").show();
				}
				
				$('#chk_redeem').click(function(){
					if($("#chk_redeem ").is(':checked'))
						$(".redemption_control").show();
					else
						$(".redemption_control").hide();
				});

				$('#place_order_button').click(function(e){
					if($('#redeem_points').val() || $('#discount_name').val())
					{
						if(!confirm('Continue place order without redeeming?'))
							e.preventDefault();
					}
				});
			});

		</script>
	{/literal}
</div>

