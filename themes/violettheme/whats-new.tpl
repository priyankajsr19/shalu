    {assign var=count value=0}
    {foreach from=$whats_new_products item=category key=name}
        {if $count eq 0}
	<div style="text-align: center;margin-top: 45px;border-bottom: 1px dashed #ccc;padding: 10px;">
        {else}
	<div style="text-align: center;margin-top: 45px;border-bottom: 1px dashed #ccc;border-top: 1px dashed #ccc;padding: 10px;">
        {/if}
		<div style="text-transform: uppercase;font-size: 20px;">NEW IN - {$name}</div>
		<div>Updated with our latest collection in {$name}</div>
	</div>
	<div class="products_block_medium clearfix">
		<ul class="clearfix product_list" style="width:100%">
			{section name=product loop=$category.products}
				<li class="ajax_block_product" style=" margin-left:15px; min-height:315px; overflow:hidden">
					{assign var='productitem' value=$category.products[product]}
					{assign var='product' value=$category.products[product]}
					{include file="$tpl_dir./product_card_small.tpl"}
				</li>
			{/section}
		</ul>
	</div>
	<div style="text-align:center">
		<a class="button" href="{$category.more_link}" style="display:inline-block;">View all {$name}</a>
	</div>
        {assign var=count value=$count+1}
    {/foreach}
