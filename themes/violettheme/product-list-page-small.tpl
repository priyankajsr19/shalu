{if isset($products)}
    {if $autoload}
        <li style="font-size:0px;line-height:0px;border-top:1px solid #D1A6E0;border-bottom:1px solid #D1A6E0;clear:both; margin:5px 25px;width:740px;height:2px;padding:0;"></li>
        {/if}
        {foreach from=$products item=product name=products}
        <li class="ajax_block_product" rel="{$product.id_product}">
            {assign var='productitem' value=$product}
            {include file="$tpl_dir./product_card_small.tpl"}
        </li>
        {if $smarty.foreach.products.index % 4 == 3}
            <li style="font-size:0px;line-height:0px;border-top:1px solid #D1A6E0;border-bottom:1px solid #D1A6E0;clear:both; margin:15px 25px;width:740px;height:2px;padding:0;"></li>
            {/if}
        {/foreach}
    <!-- /Products list -->
{/if}
