<div class=" product_card">
    {if !$productitem.inStock}
        <img alt="Out Of Stock" src="{$img_ps_dir}out_of_stock_vs.png" style="margin:0 0;position:absolute;left:1px; top:1px;"/>
    {else}
                {if $productitem.isPlusSize}
        		    <img alt="plus size garment" src="{$img_ps_dir}plussize_s.png" style="margin:0 0;position:absolute;left:1px; top:1px;"/>
		        {else}
        		    {if $productitem.isRTS}
                		<img alt="Ready to stich garment" width="64px" height="31px" src="{$img_ps_dir}rts1.png" style="margin:0 0;position:absolute;left:1px; top:1px;"/>
		            {/if}           
		        {/if}
    {/if}
    <a href="{$productitem.product_link}">
        <span class="product_image_medium" href="{$productitem.product_link}" title="{$productitem.name|escape:html:'UTF-8'}">  {if in_array("buy1get1", $productitem.tags)}
                <img alt="Buy1-Get1" src="{$img_ps_dir}b1g1_50.png" style="margin:0 0;position:absolute;left:0px; top:1px;"/>
                {/if}
            {if isset($lazy) && $lazy == 1}
                <img src="{$img_ps_dir}blank.jpg" data-href="{$productitem.image_link_list}" height="205" width="150" alt="{$productitem.name|escape:html:'UTF-8'}"  class="lazy"/>
                <noscript>
                <img src="{$productitem.image_link_list}" height="205" width="150" alt="{$productitem.name|escape:html:'UTF-8'}" />
                </noscript>
            {else}
                <img src="{$productitem.image_link_list}" height="205" width="150" alt="{$productitem.name|escape:html:'UTF-8'}" />
            {/if}
        </span>
        <span class="product-list-name">
            <h2 class="product_card_name">{$productitem.name|truncate:100:'...'|escape:'htmlall':'UTF-8'}</h2>
        </span>
        <span class="product_info">
            {if $price_tax_country == 110}
                <span class="price">{convertAndShow price=$productitem.offer_price_in}</span>
                {if ($productitem.discount > 0)}
                    <span class="strike_price">{convertAndShow price=$productitem.mrp_in}</span>
                    <span class="clear" style="display:block;color:#DA0F00;">({$productitem.discount}% Off)</span>
                {/if}
            {else}
                <span class="price">{convertAndShow price=$productitem.offer_price}</span>
                {if ($productitem.discount > 0)}
                    <span class="strike_price">{convertAndShow price=$productitem.mrp}</span>
                    <span class="clear" style="display:block;color:#DA0F00;">({$productitem.discount}% Off)</span>
                {/if}
            {/if}
        </span>
        {include file="$tpl_dir./product_shipping_sla.tpl"}
    </a>
    <a id="ajax_id_product_{$productitem.id_product}" class="quick_view_link fancybox.ajax quickviewsmall" rel="nofollow" href="{$base_dir}quickview.php?id={$productitem.id_product}">QUICK VIEW</a>
</div>
