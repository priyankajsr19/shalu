
    {if isset($cat_products) && $cat_products && $cat_products|@count > 0}
        <div id="category_products" class="sheets" style="padding:10px 0;float:left;width:100%">
            <div class="panel_title" style="width:80%;">WE RECOMMEND</div>
            <div  class="products_block_medium">
                <!-- "previous page" action -->
                <a class="prev browse left">Prev</a>

                <!-- root element for scrollable -->
                <div class="scrollable">

                    <!-- root element for the items -->
                    <div class="items">

                        {foreach from=$cat_products item=productitem name=products}
                            {if $smarty.foreach.products.first == true || $smarty.foreach.products.index % 5 == 0}
                                <div>
                                    <!-- Products list -->
                                    <ul>
                                    {/if}
                                    <li class="ajax_block_product" rel="{$productitem.id_product}" {if $smarty.foreach.products.index % 5 == 0}style=" margin-left:15px"{/if}>
                                        <div class="product_card">
                                            {*{if !$productitem.inStock}
                                            <img alt="Out Of Stock" src="{$img_ps_dir}out_of_stock_vs.png" style="margin:0 0;position:absolute;left:1px; top:0px;"/>
                                            {/if}*}
                                            <a href="{$productitem.link}">
                                                <span class="product_image_medium" href="{$productitem.link}" title="{$productitem.name|escape:html:'UTF-8'}">
                                                    {if isset($lazy) && $lazy == 1}
                                                        <img data-href="{$link->getImageLink($productitem.link_rewrite, $productitem.id_image, 'medium')}" height="205" width="150" alt="{$productitem.name|escape:html:'UTF-8'}"  class="delaylazy"/>
                                                        <noscript>
                                                        <img src="{$link->getImageLink($productitem.link_rewrite, $productitem.id_image, 'medium')}" height="205" width="150" alt="{$productitem.name|escape:html:'UTF-8'}" />
                                                        </noscript>
                                                    {else}
                                                        <img src="{$link->getImageLink($productitem.link_rewrite, $productitem.id_image, 'medium')}" height="205" width="150" alt="{$productitem.name|escape:html:'UTF-8'}" />
                                                    {/if}
                                                </span>
                                                <span class="product-list-name">
                                                    <h2 class="product_card_name">{$productitem.name|truncate:100:'...'|escape:'htmlall':'UTF-8'}</h2>
                                                </span>
                                                <span class="product_info">
                                                    <span class="price">
                                                        {if !$priceDisplay}
                                                            {convertPrice price=$productitem.price}
                                                        {else}
                                                        {convertPrice price=$productitem.price_tax_exc}{/if}
                                                        <!--span class="price_inr">
                                                            (Rs {round($productitem.price * $conversion_rate)})
                                                        </span-->
                                                    </span>
                                                    {if ($productitem.price_without_reduction - $productitem.price > 1)}
                                                        {*<span class="strike_price">MRP {if !$priceDisplay}{convertPrice price=$productitem.price_without_reduction} {/if}</span>*}
                                                        <span class="clear" style="display:block;color:#DA0F00;">({round((($productitem.price_without_reduction - $productitem.price)/$productitem.price_without_reduction)*100)}% Off)</span>
                                                    {/if}

                                                </span>
                                            </a>
                                        </div>
                                    </li>
                                    {if $smarty.foreach.products.index % 5 == 4 || $smarty.foreach.products.last == true}
                                    </ul>
                                </div>
                            {/if}
                        {/foreach}

                        <!-- /Products list -->

                    </div>

                </div>

                <!-- "next page" action -->
                <a class="next browse right" style="display:block;">Next</a>
            </div>
        </div>
    {/if}
