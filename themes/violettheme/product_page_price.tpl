	<div class="price-info">
                <!-- prices -->
                {if $product->show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}
                    <p class="price">

                        {if !$priceDisplay || $priceDisplay == 2}
                            {assign var='productPrice' value=$product->getPrice(true, $smarty.const.NULL, 2)}
                            {assign var='productPriceWithoutRedution' value=$product->getPriceWithoutReduct(false, $smarty.const.NULL)}
                        {elseif $priceDisplay == 1}
                            {assign var='productPrice' value=$product->getPrice(false, $smarty.const.NULL, 2)}
                            {assign var='productPriceWithoutRedution' value=$product->getPriceWithoutReduct(true, $smarty.const.NULL)}
                        {/if}
                        {if $product->specificPrice AND $product->specificPrice.reduction}
                            <span id="old_price">
                                {if $priceDisplay >= 0 && $priceDisplay <= 2}
                                    {if $productPriceWithoutRedution > $productPrice}
                                        <span id="old_price_display">{displayPrice price=$productPriceWithoutRedution}</span>
                                    {/if}
                                {/if}
                            </span>
                        {/if}

                        {if $priceDisplay >= 0 AND $priceDisplay <= 2}
                            <span id="our_price_display">
                                {displayPrice price=$productPrice}
                            </span>
                        {/if}

                        <span style="border-left:1px solid #cacaca;padding:5px">Product Code:  {$product->reference}</span>
                        {if $product->is_plussize}
                            <img src="{$img_ps_dir}plusize_m.png" alt="PlusSize Gargment" style="float:right"/>
                        {elseif $product->is_rts}
                            <img src="{$img_ps_dir}rts1.png" width="85px" height="41px" alt="Ready to stitch Gargment" style="float:right"/>
                        {/if}
                    </p>
                {/if}
            </div>
