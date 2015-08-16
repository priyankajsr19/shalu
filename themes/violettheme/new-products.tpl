<div id="new_products" style="width:770px;float:left">
	<h1 id="productsHeading">{l s='New products'}</h1>
	
	{include file="$tpl_dir./errors.tpl"}
	{if $products}
		{include file="$tpl_dir./product_list_top.tpl"}
		{if $cookie->image_size == 1}
			{include file="$tpl_dir./products-pane.tpl" products=$products}
		{else}
			{include file="$tpl_dir./products-pane-small.tpl" products=$products}
		{/if}
		{include file="$tpl_dir./product_list_bottom.tpl"}
	{else}
	    {if isset($fetch_error) && $fetch_error}
	        <p class="warning">Could not bring the products. Please try after some time.</p>
	    {else}
		    <p class="warning">{l s='No new products.'}</p>
		{/if}
	{/if}
</div>