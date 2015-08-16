{*
* 2007-2011 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 6909 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div id="products_block"  class="products_block">
    {if isset($products)}
        <!-- Products list -->
        <ul id="product_list" class="clear">
            {foreach from=$products item=product name=products}
                <li class="ajax_block_product" rel="{$product.id_product}" {if $smarty.foreach.products.index % 4 == 0}style=" margin-left:15px"{/if}>
                    <div class=" {if $smarty.foreach.products.index % 4 == 0} left_card {else}product_card{/if}">
                        {if !$product.inStock}
                            <img alt="Out Of Stock" src="{$img_ps_dir}out_of_stock_vs.png" style="margin:0 0;position:absolute;left:1px; top:0px;"/>
                        {/if}
                        <a href="{$product.link}">
                            <span class="product_image_large" href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}">
                                {if isset($lazy) && $lazy == 1}
                                    <img data-href="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home')}" height="129" alt="{$product.name|escape:html:'UTF-8'}"  class="lazy"/>
                                    <noscript>
                                    <img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home')}" height="129" alt="{$product.name|escape:html:'UTF-8'}" />
                                    </noscript>
                                {else}
                                    <img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home')}" height="129" alt="{$product.name|escape:html:'UTF-8'}" />
                                {/if}
                            </span>
                            <span class="product-list-name">
                                <h2 class="product_card_name">{$product.name|truncate:100:'...'|escape:'htmlall':'UTF-8'}</h2>
                            </span>
                            <span class="product_info">
                                <span class="price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span>
                                {if ($product.price_without_reduction - $product.price > 1)}
                                    <span class="strike_price">MRP {if !$priceDisplay}{convertPrice price=$product.price_without_reduction} {/if}</span>
                                    <span class="clear" style="display:block;color:#DA0F00;">({round((($product.price_without_reduction - $product.price)/$product.price_without_reduction)*100)}% Off)</span>

                                {/if}
                            </span>
                        </a>
                        {if ($product.quantity > 0 OR $product.allow_oosp) AND $product.customizable != 2}
                            <span id="ajax_id_product_{$product.id_product}" class="add2cart exclusive ajax_add_to_cart_button" idprod="ajax_id_product_{$product.id_product}" title="{l s='Add to Bag' mod='homefeatured'}">{l s='Add to Bag' mod='homefeatured'}</span>
                        {/if}
                    </div>
                </li>
                {if $smarty.foreach.products.index % 4 == 3 && $smarty.foreach.products.last == false}
                    <li style="font-size:0px;line-height:0px;border-top:1px solid #D1A6E0;border-bottom:1px solid #D1A6E0;clear:both; margin:5px 25px;width:740px;height:2px;padding:0;"></li>
                    {/if}
                {/foreach}
        </ul>
        <!-- /Products list -->
    {/if}
</div>
