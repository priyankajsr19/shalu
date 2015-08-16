{if isset($orderby) AND isset($orderway)}
    {if isset($smarty.get.id_category) && $smarty.get.id_category}
    	{assign var='request' value=$link->getPaginationLink('category', $category, false, true)}
    {elseif isset($smarty.get.id_manufacturer) && $smarty.get.id_manufacturer}
    	{assign var='request' value=$link->getPaginationLink('manufacturer', $manufacturer, false, true)}
    {elseif isset($smarty.get.id_supplier) && $smarty.get.id_supplier}
    	{assign var='request' value=$link->getPaginationLink('supplier', $supplier, false, true)}
    {else}
    	{assign var='request' value=$link->getPaginationLink(false, false, false, true)}
    {/if}
    <div style="float:left">
    Sort By:
    {if $orderby neq "hot"}
        <a class="lnk_sort hot" rel="hot:desc" href="{$link->addSortDetails($request, 'hot', 'desc')|escape:'htmlall':'UTF-8'}" > Whats Hot</a>  
    {else}
        <a class="lnk_sort hot currentsort" rel="hot:desc" href="{$link->addSortDetails($request, 'hot', 'desc')|escape:'htmlall':'UTF-8'}" > Whats Hot</a>
    {/if}
    |
    {if $orderby neq "new"}
        <a class="lnk_sort new" rel="new:desc" href="{$link->addSortDetails($request, 'new', 'desc')|escape:'htmlall':'UTF-8'}" > Whats New</a>  
    {else}
        <a class="lnk_sort new currentsort" rel="new:desc" href="{$link->addSortDetails($request, 'new', 'desc')|escape:'htmlall':'UTF-8'}" > Whats New</a>
    {/if}
    |
    {if $orderby neq "discount"}
        <a class="lnk_sort discount" rel="discount:desc" href="{$link->addSortDetails($request, 'discount', 'desc')|escape:'htmlall':'UTF-8'}" > Discount</a>  
    {else}
        <a class="lnk_sort discount currentsort" rel="discount:desc" href="{$link->addSortDetails($request, 'discount', 'desc')|escape:'htmlall':'UTF-8'}" > Discount</a>
    {/if}
    |
    {if $orderby neq "price"}
        <a class="lnk_sort price" style="font-size:1em;" rel="price:asc" href="{$link->addSortDetails($request, 'price', 'asc')|escape:'htmlall':'UTF-8'}" > Price ↑</a> 
    {else}
          {if $orderway eq "asc"}
                 <a class="lnk_sort price currentsort" rel="price:asc" style="font-size:1em;" href="{$link->addSortDetails($request, 'price', 'desc')|escape:'htmlall':'UTF-8'}" >  Price ↑</a>
          {else}
                    <a class="lnk_sort currentsort" rel="price:desc" href="{$link->addSortDetails($request, 'price', 'asc')|escape:'htmlall':'UTF-8'}" > Price ↓</a> 
          {/if}
    {/if}
    </div>
    
    <div style="float:right;padding:3px 0 0 10px;">
    
	{if $cookie->image_size == 1}
    	<span class="image_size_large_selected"></span>
    	<a href="" class="toggle_size" rel="s"><span class="image_size_small"></span></a>
    {else}
    	<a href="" class="toggle_size" rel="l"><span class="image_size_large"></span></a>
    	<span class="image_size_small_selected"></span>
    {/if}
    </div>
    <div style="float:right">Image Size:</div>
    
    {literal}
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
{/literal}
{/if}
