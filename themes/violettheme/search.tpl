
<div id="search-results" style="width:770px;">
<h1 {if isset($instantSearch) && $instantSearch}id="instant_search_results"{else}id="productsHeading"{/if}>
{if $nbProducts > 0}Products for "{if isset($smarty.get.search_query)}{$smarty.get.search_query|htmlentities:$ENT_QUOTES:'utf-8'|stripslashes}{elseif $search_tag}{$search_tag|escape:'htmlall':'UTF-8'}{elseif $ref}{$ref|escape:'htmlall':'UTF-8'}{/if}"{/if}
{if isset($instantSearch) && $instantSearch}<a href="#" class="close">{l s='Return to previous page'}</a>{/if}
</h1>

{include file="$tpl_dir./errors.tpl"}
{if isset($fetch_error) && $fetch_error}
    <p class="warning">Could not bring the products. Please try after some time.</p>
{elseif !$nbProducts}
	<p class="warning">
		{if isset($search_query) && $search_query && isset($ssResults) && $ssResults == 1}
			{l s='No results found for your search'}&nbsp;"{if isset($search_query)}{$search_query|htmlentities:$ENT_QUOTES:'utf-8'|stripslashes}{/if}". Related products:
		{elseif isset($search_query) && $search_query}
			{l s='No results found for your search'}&nbsp;"{if isset($search_query)}{$search_query|htmlentities:$ENT_QUOTES:'utf-8'|stripslashes}{/if}"
		{elseif isset($search_tag) && $search_tag}
			{l s='No results found for your search'}&nbsp;"{$search_tag|escape:'htmlall':'UTF-8'}"
		{else}
			{l s='Please type a search keyword'}
		{/if}
	</p>
{else}
	{if isset($search_query) && $search_query && isset($ssResults) && $ssResults == true}
	<p class="warning">
		{l s='No results found for your search'}&nbsp;"{if isset($search_query)}{$search_query|htmlentities:$ENT_QUOTES:'utf-8'|stripslashes}{/if}". Related products:
	</p>
	{/if}
	{include file="$tpl_dir./product_list_top.tpl"}
	{if $cookie->image_size == 1}
		{include file="$tpl_dir./products-pane.tpl" products=$search_products}
	{else}
		{include file="$tpl_dir./products-pane-small.tpl" products=$search_products}
	{/if}
	{include file="$tpl_dir./product_list_bottom.tpl"}
{/if}
</div>
{if isset($search_description) && $search_description}
<div id="seach-description" style="float:left;width:770px;padding-top:10px;clear:both;">
	{$search_description|stripslashes}
</div>
{/if}
