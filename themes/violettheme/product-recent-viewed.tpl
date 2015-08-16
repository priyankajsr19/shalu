
    {if isset($recently_viewed) && $recently_viewed|@count > 0}
        <div id="recent_products" class="sheets" style="padding:10px 0;float:left;width:100%">
            <div class="panel_title" style="width:80%;">
                RECENTLY VIEWED
            </div>
            <div  class="products_block_medium">
                <a class="prev browse left">Prev</a>
                <div class="scrollable">
                    <div class="items">
                        {foreach from=$recently_viewed item=productitem name=recentProducts}
                            {if $smarty.foreach.recentProducts.first == true || $smarty.foreach.recentProducts.index % 5 == 0}
                                <div>
                                    <ul>
                                    {/if}
                                    <li class="ajax_block_product" rel="{$productitem.id_product}" >
                                        <div class="product_card">
                                            {if !$productitem.inStock}
                                                <img alt="Out Of Stock" src="{$img_ps_dir}out_of_stock_vs.png" style="margin:0 0;position:absolute;left:1px; top:0px;"/>
                                            {/if}
                                            <a href="{$productitem.product_link}">
                                                <span class="product_image_medium" href="{$productitem.product_link}" title="{$productitem.name|escape:html:'UTF-8'}">
                                                    {if isset($lazy) && $lazy == 1}
                                                        <img src="{$img_ps_dir}blank.jpg" data-href="{$productitem.image_link_medium}" height="205" width="150" alt="{$productitem.name|escape:html:'UTF-8'}"  class="delaylazy"/>
                                                        <noscript>
                                                        <img src="{$productitem.image_link_medium}" height="205" width="150" alt="{$productitem.name|escape:html:'UTF-8'}" />
                                                        </noscript>
                                                    {else}
                                                        <img src="{$productitem.image_link_medium}" height="205" width="150" alt="{$productitem.name|escape:html:'UTF-8'}"/>
                                                    {/if}
                                                </span>
                                                <span class="product-list-name">
                                                    <h2 class="product_card_name">{$productitem.name|truncate:100:'...'|escape:'htmlall':'UTF-8'}</h2>
                                                </span>
                                                <span class="product_info">
                                                    <span class="product_info">
                                                        {if $price_tax_country == 110}
                                                            <span class="price">
                                                                {convertAndShow price=$productitem.offer_price_in}
                                                                <!--span class="price_inr">(Rs {round($productitem.offer_price_in * $conversion_rate)})</span-->
                                                            </span>
                                                            {if ($productitem.discount > 0)}
                                                                <span class="strike_price">{convertAndShow price=$productitem.mrp_in}</span>
                                                                <span class="clear" style="display:block;color:#DA0F00;">({$productitem.discount}% Off)</span>
                                                            {/if}
                                                        {else}
                                                            <span class="price">
                                                                {convertAndShow price=$productitem.offer_price}
                                                                <!--span class="price_inr">(Rs {round($productitem.offer_price * $conversion_rate)})</span-->
                                                            </span>
                                                            {if ($productitem.discount > 0)}
                                                                <span class="strike_price">{convertAndShow price=$productitem.mrp}</span>
                                                                <span class="clear" style="display:block;color:#DA0F00;">({$productitem.discount}% Off)</span>
                                                            {/if}
                                                        {/if}
                                                    </span>
                                                </span>
                                            </a>
                                        </div>
                                    </li>
                                    {if $smarty.foreach.recentProducts.index % 5 == 4 || $smarty.foreach.recentProducts.last == true}
                                    </ul>
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                </div>
                <a class="next browse right" style="display:block;">Next</a>
            </div>
        </div>
    {/if}
