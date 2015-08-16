<tr id="product_{$product.id_product}_{$product.id_product_attribute}" style="background-color: {cycle values="#eeeeee,#d0d0d0"}" class="{if $smarty.foreach.productLoop.last}last_item{elseif $smarty.foreach.productLoop.first}first_item{/if}{if isset($customizedDatas.$productId.$productAttributeId) AND $quantityDisplayed == 0}alternate_item{/if} cart_item">
	<td class="cart_product">
		<a href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category)|escape:'htmlall':'UTF-8'}">
			<img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'small')}" 
					alt="{$product.name|escape:'htmlall':'UTF-8'}"  height="116" width="85"/>
		</a>
	</td>
	<td class="cart_description" style="text-align: left;">
		<h5><a href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category)|escape:'htmlall':'UTF-8'}">{$product.name|escape:'htmlall':'UTF-8'}</a></h5>
		{if isset($product.attributes) && $product.attributes}<a href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category)|escape:'htmlall':'UTF-8'}">{$product.attributes|escape:'htmlall':'UTF-8'}</a>{/if}
	</td>
	{*<td class="cart_ref">{if $product.reference}{$product.reference|escape:'htmlall':'UTF-8'}{else}--{/if}</td>*}
	<td class="cart_availability">
		{if $product.active AND ($product.allow_oosp OR ($product.quantity <= $product.stock_quantity)) AND $product.available_for_order AND !$PS_CATALOG_MODE}
			<img src="{$img_dir}icon/available.gif" alt="{l s='Available'}" width="14" height="14" />
		{else}
			<img src="{$img_dir}icon/unavailable.gif" alt="{l s='Out of stock'}" width="14" height="14" />
		{/if}
	</td>
	<td class="cart_unit">
		<span class="price" id="product_price_{$product.id_product}_{$product.id_product_attribute}">
			{if !$priceDisplay}{convertPrice price=$product.price_wt}{else}{convertPrice price=$product.price}{/if}
		</span>
	</td>
	<td class="cart_quantity"{if isset($customizedDatas.$productId.$productAttributeId) AND $quantityDisplayed == 0} {/if} style="text-align: center;">
		{if isset($customizedDatas.$productId.$productAttributeId) AND $quantityDisplayed == 0}
			<span id="cart_quantity_custom_{$product.id_product}_{$product.id_product_attribute}" >{$product.customizationQuantityTotal}</span>
		{/if}
		{if !isset($customizedDatas.$productId.$productAttributeId) OR $quantityDisplayed > 0}
			<div style="float:right;width:16px;margin-left:10px;">
				<a rel="nofollow" class="cart_quantity_delete" id="{$product.id_product}_{$product.id_product_attribute}" href="{$link->getPageLink('cart.php', true)}?delete&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;token={$token_cart}" title="{l s='Delete'}">
					<img src="{$img_dir}icon/delete.png" alt="{l s='Delete'}" class="icon" width="16" height="16" />
				</a>
			</div>
			<div id="cart_quantity_button" style="position:relative;width:60px" class="qty_spinner">
				<input type="hidden" value="{if $quantityDisplayed == 0 AND isset($customizedDatas.$productId.$productAttributeId)}{$customizedDatas.$productId.$productAttributeId|@count}{else}{$product.cart_quantity-$quantityDisplayed}{/if}" name="quantity_{$product.id_product}_{$product.id_product_attribute}_hidden" />
				<input size="2" type="text" class="cart_quantity_input" value="{if $quantityDisplayed == 0 AND isset($customizedDatas.$productId.$productAttributeId)}{$customizedDatas.$productId.$productAttributeId|@count}{else}{$product.cart_quantity-$quantityDisplayed}{/if}"  name="quantity_{$product.id_product}_{$product.id_product_attribute}" />
				<a rel="nofollow" class="cart_quantity_up btn_spinner_up" id="cart_quantity_up_{$product.id_product}_{$product.id_product_attribute}" href="{$link->getPageLink('cart.php', true)}?add&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;token={$token_cart}" title="{l s='Add'}"></a>
				<br />
				{if $product.minimal_quantity < ($product.cart_quantity-$quantityDisplayed) OR $product.minimal_quantity <= 1}
					<a rel="nofollow" class="cart_quantity_down btn_spinner_down" id="cart_quantity_down_{$product.id_product}_{$product.id_product_attribute}" href="{$link->getPageLink('cart.php', true)}?add&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;op=down&amp;token={$token_cart}" title="{l s='Subtract'}"></a>
				{else}
					<a class="cart_quantity_down btn_spinner_down" style="opacity: 0.3;" href="#" id="cart_quantity_down_{$product.id_product}_{$product.id_product_attribute}" title="{l s='You must purchase a minimum of '}{$product.minimal_quantity}{l s=' of this product.'}"></a>
				{/if}
			</div>
			
		{else}
			
			{if $quantityDisplayed == 0 AND isset($customizedDatas.$productId.$productAttributeId)}
				{*{$customizedDatas.$productId.$productAttributeId|@count}*}
			{else}
				{$product.cart_quantity-$quantityDisplayed}
			{/if}
		{/if}
	</td>
	<td class="cart_total">
		<span class="price" id="total_product_price_{$product.id_product}_{$product.id_product_attribute}">
			{if $quantityDisplayed == 0 AND isset($customizedDatas.$productId.$productAttributeId)}
				{if !$priceDisplay}{displayPrice price=$product.total_customization_wt}{else}{displayPrice price=$product.total_customization}{/if}
			{else}
				{if !$priceDisplay}{displayPrice price=$product.total_wt}{else}{displayPrice price=$product.total}{/if}
			{/if}
		</span>
	</td>
</tr>
