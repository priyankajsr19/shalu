<div id="products_block"  class="products_block_medium">
    {if isset($products)}
        <!-- Products list -->
        <ul id="product_list_small" class="clear product_list clearfix">
            {foreach from=$products item=product name=products}
                <li class="ajax_block_product" rel="{$product.id_product}" >
                    {assign var='productitem' value=$product}
                    {include file="$tpl_dir./product_card_small.tpl"}
                </li>
                {if $smarty.foreach.products.index % 4 == 3}
                    <li style="font-size:0px;line-height:0px;border-top:1px solid #D1A6E0;border-bottom:1px solid #D1A6E0;clear:both; margin:15px 25px;width:740px;height:2px;padding:0;"></li>
                    {/if}
                {/foreach}
        </ul>
        <div id="bottom-placeholder" style="height:20px;padding:0;border:1px solid #333333;display:none;clear:both;"></div>
        {if isset($nextPage) && $nextPage}
            <div id="load_more">
                <span id="see_more">See More</span>
                <span id="loading" style="display:none"><img alt="" src="http://static.violetbag.com/img/loader.gif"></span>
            </div>
        {/if}
        <!-- /Products list -->
    {/if}
</div>
