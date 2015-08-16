{if !$ajax}
<script type="text/javascript">
	var nextPage = {{$nextPage}};
	var srch_query = "tags:buy1get1 AND inStock:1";
        var brand,latest,sale,express_shipping,cat_id;
	var b1g1 = 1;
</script>

<div class="products_block_medium clearfix">
	<ul class="clearfix product_list" style="width:100%">
		{foreach from=$products item=product}
			<li class="ajax_block_product" style=" margin-left:15px; min-height:315px; overflow:hidden">
				{assign var='productitem' value=$product}
				{assign var='product' value=$product}
				{include file="$tpl_dir./product_card_small.tpl"}
			</li>
		{/foreach}
	</ul>
</div>

<div id="top-marker" style="height:1px; width:100%;"></div>
<div id="go-to-top" style="color:#ffffff; background: none repeat scroll 0 0 #A41E21;">
    Go To Top
</div>
{if isset($nextPage) && $nextPage}
	<div id="load_more">
        	<span id="see_more">See More</span>
                <span id="loading" style="display:none"><img alt="" src="http://static.violetbag.com/img/loader.gif"></span>
        </div>
{/if}
{/if}

{if $ajax}
 {foreach from=$products item=product}
     <li class="ajax_block_product" style=" margin-left:15px; min-height:315px; overflow:hidden">
        {assign var='productitem' value=$product}
        {assign var='product' value=$product}
        {include file="$tpl_dir./product_card_small.tpl"}
     </li>
 {/foreach}
{/if}
