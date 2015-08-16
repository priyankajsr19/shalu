<div id="products_block"  class="products_block" style="">
    {if isset($products)} 
        <!-- Products list -->
        <ul id="product_list" class="clear" style="width:980px;padding-top:0px;">
            {foreach from=$products item=product name=products}
                <li class="ajax_block_product" rel="{$product.id_product}" style="width:196px;">
                    <div class=" {if $smarty.foreach.products.index % 5 == 0} left_card {else}product_card{/if}">
                        {if !$product.inStock}
                            <img alt="Out Of Stock" src="{$img_ps_dir}out_of_stock_vs.png" style="margin:0 0;position:absolute;left:1px; top:0px;"/>
                        {/if}
                        <a href="{$product.product_link}">
                            <span class="product_image" href="{$product.product_link}" title="{$product.name|escape:html:'UTF-8'}">
                                {if isset($lazy) && $lazy == 1}
                                    <img src="{$img_ps_dir}blank.jpg" data-href="{$product.image_link}" height="129" width="129" alt="{$product.name|escape:html:'UTF-8'}"  class="lazy"/>
                                    <noscript>
                                    <img src="{$product.image_link}" height="129" alt="{$product.name|escape:html:'UTF-8'}" />
                                    </noscript>
                                {else}
                                    <img src="{$product.image_link}" height="129" alt="{$product.name|escape:html:'UTF-8'}"/>
                                {/if}
                            </span>
                            <span class="product-list-name">
                                <h2 class="product_card_name">{$product.name|truncate:100:'...'|escape:'htmlall':'UTF-8'}</h2>
                            </span>
                            <span class="product_info">
                                {if $price_tax_country == 110}
                                    <span class="price">
                                        {convertPrice price=$product.offer_price_in}
                                        <span class="price_inr">(Rs {round($product.offer_price_in * $conversion_rate)})</span>
                                    </span>
                                    {if ($product.discount > 0)}
                                        <span class="strike_price">{convertPrice price=$product.mrp_in}</span>
                                        <span class="clear" style="display:block;color:#DA0F00;">({$product.discount}% Off)</span>
                                    {/if}
                                {else}
                                    <span class="price">
                                        {convertPrice price=$product.offer_price}
                                        <span class="price_inr">(Rs {round($product.offer_price * $conversion_rate)})</span>
                                    </span>
                                    {if ($product.discount > 0)}
                                        <span class="strike_price">{convertPrice price=$product.mrp}</span>
                                        <span class="clear" style="display:block;color:#DA0F00;">({$product.discount}% Off)</span>
                                    {/if}
                                {/if}
                            </span>
                        </a>
                        {if $product.quantity > 0}
                            <span id="ajax_id_product_{$product.id_product}" class="add2cart exclusive ajax_add_to_cart_button" idprod="ajax_id_product_{$product.id_product}" title="{l s='Add to Bag' mod='homefeatured'}">{l s='Add to Bag' mod='homefeatured'}</span>
                        {/if}
                    </div>
                </li>
                {if $smarty.foreach.products.index % 5 == 4 && $smarty.foreach.products.last == false}
                    <li style="font-size:0px;line-height:0px;border-top:1px solid #D1A6E0;border-bottom:1px solid #D1A6E0;clear:both; margin:5px 25px;width:740px;height:2px;padding:0;"></li>
                    {/if}
                {/foreach}
        </ul>
        <!-- /Products list -->
    {/if}
</div>
