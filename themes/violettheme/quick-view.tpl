<div style="width:760px;">
	<div style="width:450px;float:left">
		
			{if $imagelink}
				<img src="{$imagelink}" width="450px" height="615"/>
			{else}
				<img src="{$img_prod_dir}{$lang_iso}-default-large.jpg" width="450px" height="615"/>
			{/if}
		
	</div>
	<div style="width:265px;float:left;padding:10px;">
		<h1>{$product->name}</h1>
		<p class="price">
						
			{if !$priceDisplay || $priceDisplay == 2}
				{assign var='productPrice' value=$product->getPrice(true, $smarty.const.NULL, 2)}
				{assign var='productPriceWithoutRedution' value=$product->getPriceWithoutReduct(false, $smarty.const.NULL)}
			{elseif $priceDisplay == 1}
				{assign var='productPrice' value=$product->getPrice(false, $smarty.const.NULL, 2)}
				{assign var='productPriceWithoutRedution' value=$product->getPriceWithoutReduct(true, $smarty.const.NULL)}
			{/if}
			{if $product->specificPrice AND $product->specificPrice.reduction}
			<span id="old_price">
				{if $priceDisplay >= 0 && $priceDisplay <= 2}
					{if $productPriceWithoutRedution > $productPrice}
						<span id="old_price_display">{convertPrice price=$productPriceWithoutRedution}</span>
					{/if}
				{/if}
			</span>
			{/if}
			
			{if $priceDisplay >= 0 && $priceDisplay <= 2}
				<span id="our_price_display">{convertPrice price=$productPrice}</span>
			{/if}
			
			<span style="border-left:1px solid #cacaca;padding:5px">Code:  {$product->reference}</span>
		</p>
		<p style="padding:20px 0;">
			<a class="button" href="{$productlink}" rel="nofollow">View Product Details</a>
		</p>
		
		<p style="padding-top:10px;text-align:center">
		{if isset($in_wishlist) && $in_wishlist}
    			<a href="/wishlist.php" class="span_link" rel="no-follow">
    			    <img src="{$img_ps_dir}heart-disabled.jpg" height="18" width="18" style="vertical-align:middle"/>
    			    <span style="color:#939393">IN YOUR WISHLIST</span>
    			</a>
		{else}
		    {if $cookie->isLogged()}
		    	<p>OR</p>
				<a href="/wishlist.php?add={$product->id}" class="span_link" rel="no-follow" >
					<img src="{$img_ps_dir}heart.jpg" height="18" width="18" style="vertical-align:middle"/>
					<span style="">ADD TO WISHLIST</span>
    			</a>
			{/if}
		{/if}
		</p>
	</div>
</div>