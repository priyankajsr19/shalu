{include file="$tpl_dir./errors.tpl"}
{if isset($empty)}
    <p class="warning">{l s='Your shopping cart is empty.'}</p>
{elseif $PS_CATALOG_MODE}
    <p class="warning">{l s='This store has not accepted your new order.'}</p>
{else}
    <script type="text/javascript">
        // <![CDATA[
        var baseDir = '{$base_dir_ssl}';
                var currencySign = '{$currencySign|html_entity_decode:2:"UTF-8"}';
                var currencyRate = '{$currencyRate|floatval}';
                var currencyFormat = '{$currencyFormat|intval}';
                var currencyBlank = '{$currencyBlank|intval}';
                var txtProduct = "{l s='product'}";
                var txtProducts = "{l s='products'}";
                // ]]>
    </script>
    <p style="display: none" id="emptyCartWarning" class="warning">{l s='Your shopping cart is empty.'}</p>
    <div id="co_content" class="clearfix">
	{if $spl_voucher_message|default:'' neq ''}
        <div style="width: 100%;padding: 10px 0px 10px 0px;border: 1px solid #ccc;font-size: 14px;text-align: center;font-weight: bold;border:1px solid #ccc;color: #a34321;">
		{$spl_voucher_message}
	</div>
	{/if}
        <div id="co_left_column" style="width: 757px;">
            <div id="order-detail-content" class="table_block" style="width: 750px; margin: 0 7px;">
                <table id="cart_summary" class="std">
                    <thead>
                        <tr>
                            <th class="cart_product first_item">{l s='Product'}</th>
                            <th
                                class="cart_description item"
                                style="text-align: left;">{l s='Description'}</th> {*<th class="cart_ref item">{l s='Ref.'}</th>*}
                            <th class="cart_availability item">{l s='Availablity'}</th>
                            <th
                                class="cart_unit item"
                                style="text-align: right;">{l s='Unit price'}</th>
                            <th class="cart_quantity item">{l s='Qty'}</th>
                            <th
                                class="cart_total last_item"
                                style="text-align: right;">{l s='Sub Total'}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        {if $use_taxes}
                            {if $priceDisplay}
                                <tr
                                    class="cart_total_price"
                                    style="border-top: 1px solid #BDC2C9;">
                                    <td colspan="5">
                                        {l s='Sub Total'}{if $display_tax_label} {l s='(tax excl.)'}{/if}{l s=':'}</td>
                                    <td class="price" id="total_product">
                                        {displayPrice price=$total_products}
                                    </td>
                                </tr>
                            {else}
                                <tr class="cart_total_price" style="border-top: 1px solid #BDC2C9;">
                                    <td colspan="5">
                                        {l s='Sub Total'}{l s=':'}
                                    </td>
                                    {if isset($customization) && $customization > 0}
                                        <td class="price" id="total_product">
                                            {displayPrice price=($total_products_wt-$customization)}</td>
                                    {else}
                                        <td class="price" id="total_product">
                                            {displayPrice price=$total_products_wt}
                                        </td>
                                    {/if}
                                </tr>
                            {/if}
                        {else}
                            <tr class="cart_total_price">
                                <td colspan="5">{l s='Total:'}</td>
                                <td class="price" id="total_product">
                                    {displayPrice price=$total_products}
                                </td>
                            </tr>
                        {/if}

                        <tr class="cart_total_voucher" {if $total_discounts==0} style="display: none;"{/if}>
                            <td colspan="5">
                                {if $use_taxes} {if $priceDisplay} {l s='Total vouchers/discounts'}{if $display_tax_label} {l s='(tax excl.)'}{/if}{l s=':'} {else} {l s='Total vouchers/discounts'}{if $display_tax_label} {l s='(tax incl.)'}{/if}{l s=':'} {/if} {else} {l s='Total vouchers:'} {/if}
                            </td>
                            <td class="price-discount" id="total_discount">
                                {if $use_taxes} {if $priceDisplay} {displayPrice price=$total_discounts_tax_exc} {else} {displayPrice price=$total_discounts} {/if} {else} {displayPrice price=$total_discounts_tax_exc} {/if}
                            </td>
                        </tr>
                        <tr class="cart_total_voucher" {if $total_wrapping==0} style="display: none;"{/if} >
                            <td colspan="5">
                                {if $use_taxes} {if $priceDisplay} {l s='Total gift-wrapping'}{if $display_tax_label} {l s='(tax excl.)'}{/if}{l s=':'} {else} {l s='Total gift-wrapping'}{if $display_tax_label} {l s='(tax incl.)'}{/if}{l s=':'} {/if} {else} {l s='Total gift-wrapping:'} {/if}</td>
                            <td class="price-discount" id="total_wrapping">
                                {if $use_taxes} {if $priceDisplay} {displayPrice price=$total_wrapping_tax_exc} {else} {displayPrice price=$total_wrapping} {/if} {else} {displayPrice price=$total_wrapping_tax_exc} {/if}
                            </td>
                        </tr>

                        {if isset($customization) && $customization > 0}
                            <tr class="cart_total_delivery">
                                <td colspan="5">{l s='Stitching & Customization:'}</td>
                                <td
                                    class="price"
                                    id="total_customization">{convertPrice price=$customization}</td>
                            </tr>
                        {/if}

                        {if $use_taxes}
                            {* MOD: remove tax
                            <tr class="cart_total_price">
                            <td colspan="5">
                            {if $display_tax_label}
                            {l s='Total (tax excl.):'}
                            {else}
                            {l s='Subtotal:'}
                            {/if}
                            </td>
                            <td class="price" id="total_price_without_tax">
                            {displayPrice price=$total_price_without_tax}
                            </td>
                            </tr>
                            <tr class="cart_total_tax">
                            <td colspan="5">
                            {if $display_tax_label}
                            {l s='Total tax:'}
                            {else}
                            {l s='Estimated Sales Tax:'}
                            {/if}
                            </td>
                            <td class="price" id="total_tax">
                            {displayPrice price=$total_tax}
                            </td>
                            </tr> *}
                            <tr class="cart_total_price">
                                <td colspan="5" style="font-size: 15px;">
                                    {if $display_tax_label}
                                        {l s='Order Total (tax incl.):'}
                                    {else}
                                        {l s='Total:'}
                                    {/if}
                                </td>
                                <td class="price ajax_cart_total" id="total_price">
                                    {displayPrice price=($total_price-$shippingCost)}
                                </td>
                            </tr>
                            {if $spl_voucher_message|default:'' neq ''}
                                <tr>
                                    <td colspan="6" style="font-weight:bold; font-size:1.3em; background-color:#F1F2F4;border-bottom:2px solid #BDC2C9;text-align:center; color:#a34231">{$spl_voucher_message}</td>
                                </tr>
                            {/if}
                            <tr class="cart_total_delivery">
                                <td colspan="6" style="background-color:#F1F2F4;border-bottom:2px solid #BDC2C9;text-align:center">
                                    <a href="#shipping-charges" class="shipping_link span_link">Know more about your shipping charges</a>
                                </td>
                                {*<td class="price" id="total_shipping" >
                                {displayPrice price=$shippingCost}
                                </td>*}
                            </tr>
                        {else}
                            <tr class="cart_total_price">
                                <td colspan="5" style="font-size: 15px;">{l s='Total:'}</td>
                                <td class="price" id="total_price">
                                    {displayPrice price=$total_price_without_tax}
                                </td>
                            </tr>
                        {/if}
                        {*
                        <tr class="cart_free_shipping" {if $free_ship <= 0 || $isVirtualCart} style="display: none;" {/if}>
                        <td colspan="5" style="white-space: normal;">
                        {l s='Remaining amount to be added to your cart in order to obtain free shipping:'}</td>
                        <td id="free_shipping" class="price">
                        {displayPrice price=$free_ship}
                        </td>
                        </tr> *}
                    </tfoot>
                    <tbody>
                        {foreach from=$products item=product name=productLoop}
                            {assign var='productId' value=$product.id_product}
                            {assign var='productAttributeId' value=$product.id_product_attribute}
                            {assign var='quantityDisplayed' value=0}
                            {* Display the product line *}
                            <tr id="product_{$product.id_product}_{$product.id_product_attribute}" class="{if $smarty.foreach.productLoop.index % 2 == 0}alternate_item {/if}cart_item">
                                <td class="cart_product">
                                    <a href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category)|escape:'htmlall':'UTF-8'}">
                                        <img
                                            src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'small')}"
                                            alt="{$product.name|escape:'htmlall':'UTF-8'}"
                                            height="116"
                                            width="85" />
                                    </a>
                                </td>
                                <td class="cart_description" style="text-align: left;">
                                    <h5>
                                        <a href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category)|escape:'htmlall':'UTF-8'}">
                                            {$product.name|escape:'htmlall':'UTF-8'}
                                        </a>
                                    </h5>
                                    {if isset($product.attributes) && $product.attributes}
                                        <a href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category)|escape:'htmlall':'UTF-8'}">
                                            {$product.attributes|escape:'htmlall':'UTF-8'}
                                        </a>
                                    {/if}
                                </td>
                                {*
                                <td class="cart_ref">
                                {if $product.reference}
                                {$product.reference|escape:'htmlall':'UTF-8'}
                                {else}
                                --
                                {/if}
                                </td>
                                *}
                                <td class="cart_availability">
                                    {if $product.active AND ($product.allow_oosp OR ($product.quantity <= $product.stock_quantity)) AND $product.available_for_order AND !$PS_CATALOG_MODE}
                                        <img src="{$img_dir}icon/available.gif"
                                             alt="{l s='Available'}"
                                             width="14"
                                             height="14" />
                                    {else}
                                        <img src="{$img_dir}icon/unavailable.gif"
                                             alt="{l s='Out of stock'}"
                                             width="14"
                                             height="14" />
                                    {/if}
                                </td>
                                <td class="cart_unit">
                                    <span class="price" id="product_price_{$product.id_product}_{$product.id_product_attribute}">
                                        {if !$priceDisplay}
                                            {convertPrice price=$product.price_wt}
                                        {else}
                                            {convertPrice price=$product.price}
                                        {/if}
                                    </span>
                                </td>
                                <td style="text-align:center" class="cart_quantity"
                                    {if isset($customizedDatas.$productId.$productAttributeId) AND $quantityDisplayed==0}
                                    {/if} style="text-align: center;">
                                    {if isset($customizedDatas.$productId.$productAttributeId) AND $quantityDisplayed == 0}
                                        <span id="cart_quantity_custom_{$product.id_product}_{$product.id_product_attribute}">
                                            {$product.customizationQuantityTotal}
                                        </span>
                                    {/if}
                                    {if !isset($customizedDatas.$productId.$productAttributeId) OR $quantityDisplayed > 0}
                                        <div id="cart_quantity_button" class="qty_spinner">
                                            {if $quantityDisplayed == 0 AND isset($customizedDatas.$productId.$productAttributeId)}
                                                {assign var=qty_btn_value value=$customizedDatas.$productId.$productAttributeId|@count}
                                            {else}
                                                {assign var=qty_btn_value value=$product.cart_quantity-$quantityDisplayed}
                                            {/if}

                                            <input type="hidden" value="{$qty_btn_value}" name="quantity_{$product.id_product}_{$product.id_product_attribute}_hidden" />
                                            <input type="hidden" class="cart_quantity_input" value="{$qty_btn_value}" name="quantity_{$product.id_product}_{$product.id_product_attribute}" />
                                            <span>{$qty_btn_value}</span>
                                            {*
                                            <a rel="nofollow" class="cart_quantity_up btn_spinner_up" id="cart_quantity_up_{$product.id_product}_{$product.id_product_attribute}"
                                            href="{$link->getPageLink('cart.php', true)}?add&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;token={$token_cart}"
                                            title="{l s='Add'}"></a>
                                            <br />
                                            {if $product.minimal_quantity < ($product.cart_quantity-$quantityDisplayed) OR $product.minimal_quantity <= 1}
                                            <a rel="nofollow"
                                            class="cart_quantity_down btn_spinner_down"
                                            id="cart_quantity_down_{$product.id_product}_{$product.id_product_attribute}"
                                            href="{$link->getPageLink('cart.php', true)}?add&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;op=down&amp;token={$token_cart}"
                                            title="{l s='Subtract'}"></a>
                                            {else}
                                            <a class="cart_quantity_down btn_spinner_down"
                                            style="opacity: 0.3;"
                                            href="#"
                                            id="cart_quantity_down_{$product.id_product}_{$product.id_product_attribute}"
                                            title="{l s='You must purchase a minimum of '}{$product.minimal_quantity}{l s=' of this product.'}"></a>
                                            {/if}
                                            *}
                                        </div>
                                        <span style="font-size: 11px">
                                            <a rel="nofollow"
                                               class="cart_quantity_delete_noajax"
                                               id="{$product.id_product}_{$product.id_product_attribute}"
                                               href="{$link->getPageLink('cart.php', true)}?delete&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;token={$token_cart}"
                                               title="{l s='Delete'}"> <span>REMOVE</span></a>
                                        </span>
                                    {else}
                                        {if $quantityDisplayed == 0 AND isset($customizedDatas.$productId.$productAttributeId)}
                                            {*{$customizedDatas.$productId.$productAttributeId|@count}*}
                                        {else}
                                            {$product.cart_quantity-$quantityDisplayed}
                                        {/if}
                                    {/if}
                                </td>
                                <td class="cart_total">
                                    <span class="price" id="total_product_price_{$product.id_product}_{$product.id_product_attribute}">
                                        {if $quantityDisplayed == 0 AND isset($customizedDatas.$productId.$productAttributeId)}
                                            {if !$priceDisplay}
                                                {displayPrice price=$product.total_customization_wt}
                                            {else}
                                                {displayPrice price=$product.total_customization}
                                            {/if}
                                        {else}
                                            {if !$priceDisplay}
                                                {displayPrice price=$product.total_wt}
                                            {else}
                                                {displayPrice price=$product.total}
                                            {/if}
                                        {/if}
                                    </span>
                                </td>
                            </tr>

                            {* Then the customized datas ones*}
                            {if isset($customizedDatas.$productId.$productAttributeId)}
                                {foreach from=$customizedDatas.$productId.$productAttributeId key='id_customization' item='customization'}
                                    <tr id="product_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}"
                                        class="{if $smarty.foreach.productLoop.index % 2 == 0}alternate_item {/if}cart_item">
                                        <td colspan="4">
                                            {foreach from=$customization.datas key='type' item='datas'}
                                                {if $type == $CUSTOMIZE_FILE}
                                                    <div class="customizationUploaded">
                                                        <ul class="customizationUploaded">
                                                            {foreach from=$datas item='picture'}
                                                                <li>
                                                                    <img
                                                                        src="{$pic_dir}{$picture.value}_small"
                                                                        alt=""
                                                                        class="customizationUploaded" width="90px"/>
                                                                </li>
                                                            {/foreach}
                                                        </ul>
                                                    </div>
                                                {elseif $type == $CUSTOMIZE_TEXTFIELD}
                                                    <ul class="typedText">
                                                        {foreach from=$datas item='textField' name='typedText'}
                                                            <li style="padding-top: 10px;">
                                                                {if $textField.index == 13}
                                                                    <span style="display: inline-block; width: 350px; line-height: 1.2em; vertical-align: top; ">
                                                                        Style: <span style="text-transform: capitalize;">{$customization.choli_style}</span>
                                                                    </span>
                                                                    <span style="display: inline-block; width: 350px; line-height: 1.2em; vertical-align: top; ">
                                                                        Size: <span style="text-transform: capitalize;">{$customization.choli_size}</span>
                                                                    </span>
                                                                {/if}
                                                                {if $textField.index == 21}
                                                                    Friend's Name:  {$customization.friends_name}
                                                                {/if}
                                                                {if $textField.index == 22}
                                                                    Friend's email:  {$customization.friends_email}
                                                                {/if}
                                                                {if $textField.index == 23}
                                                                    Gift Message: {$customization.gift_message}
                                                                {/if}
                                                                {if $textField.index == 10}
                                                                    + Long choli.
                                                                {/if}
                                                                {if $textField.index == 11}
                                                                    + Long sleeves.
                                                                {/if}
                                                                {if $textField.index == 9}
                                                                    Garment fabric.
                                                                {/if}
                                                                {if $textField.index == 8}
                                                                    {if $customization.fall_piko eq "1"}
                                                                        Saree with unstitched blouse and fall/pico work.
                                                                    {else}
                                                                        Saree with unstitched blouse and without fall/pico work.
                                                                    {/if}
                                                                {/if}
                                                                {if $textField.index == 1}
                                                                    Pre-stitched saree with unstitched blouse and fall/pico work.
                                                                {/if}
                                                                {if $textField.index == 2}
                                                                    <span style="width: 137px; display: inline-block; text-align: center;">
                                                                        <img src="{$img_ps_dir}styles/{$customization.blouse_style_image}" width="90px"/>
                                                                        <span style="font-family: Abel; font-size: 14px; display: block; width: 100%; line-height: 1em">
                                                                            {$customization.blouse_style_name}
                                                                        </span>
                                                                    </span>
                                                                    <span style="display: inline-block; width: 150px; line-height: 1.2em; vertical-align: top; padding-top: 10px;">
                                                                        Stitched to measure blouse
                                                                        <br />
                                                                        Measurement for: <span style="text-transform: capitalize;">{$customization.blouse_measurement}</span><br/>
                                                                        {if $customization.fall_piko eq "1"}
                                                                            <span>With fall/piko work</span>
                                                                        {else}
                                                                            <span>Without fall/piko work</span>
                                                                        {/if}
                                                                    </span>
                                                                {/if}
                                                                {if $textField.index == 3}
                                                                    <span style="width: 137px; display: inline-block; text-align: center;">
                                                                        <img src="{$img_ps_dir}styles/{$customization.inskirt_style_image}" width="90px"/>
                                                                        <span style="font-family: Abel; font-size: 14px; display: block; width: 100%; line-height: 1em">
                                                                            {$customization.inskirt_style_name}
                                                                        </span>
                                                                    </span>
                                                                    <span style="display: inline-block; width: 150px; line-height: 1.2em; vertical-align: top; padding-top: 10px;">
                                                                        Stitched to measure in-skirt
                                                                        <br />
                                                                        Measurement for: <span style="text-transform: capitalize;">{$customization.inskirt_measurement}</span><br/>
                                                                        {if $customization.fall_piko eq "1"}
                                                                            <span>With fall/piko work</span>
                                                                        {else}
                                                                            <span>Without fall/piko work</span>
                                                                        {/if}
                                                                    </span>
                                                                {/if}
                                                                {if $textField.index == 4}
                                                                    <span style="display: inline-block; width: 350px; line-height: 1.2em; vertical-align: top; padding-top: 10px;">
                                                                        Stitched to measure kurta
                                                                        <br />
                                                                        Measurement for: <span style="text-transform: capitalize;">{$customization.kurta_measurement}</span>
                                                                    </span>
                                                                    <span style="display: inline-block; width: 350px; line-height: 1.2em; vertical-align: top; padding-top: 10px;">
                                                                        Stitched to measure salwar
                                                                        <br />
                                                                        Measurement for: <span style="text-transform: capitalize;">{$customization.salwar_measurement}</span>
                                                                    </span>
                                                                {/if}
                                                                {if $textField.index == 24}
                                                                    {if isset($customization.kurta_style_name) && !empty($customization.kurta_style_name)}
                                                                        <span style="width: 137px; display: inline-block; text-align: center;">
                                                                            <img src="{$img_ps_dir}styles/{$customization.kurta_style_image}" width="90px"/>
                                                                            <span style="font-family: Abel; font-size: 14px; display: block; width: 100%; line-height: 1em">
                                                                                {$customization.kurta_style_name}
                                                                            </span>
                                                                        </span>
                                                                        <span style="display: inline-block; width: 150px; line-height: 1.2em; vertical-align: top; padding-top: 10px;">
                                                                            Stitched to measure Kurta
                                                                            <br />
                                                                            Measurement for: <span style="text-transform: capitalize;">{$customization.kurta_measurement}</span>
                                                                        </span>
                                                                        <br />
                                                                    {/if}
                                                                    {if isset($customization.salwar_style_name) && !empty($customization.salwar_style_name)}
                                                                        <span style="width: 137px; display: inline-block; text-align: center;">
                                                                            <img src="{$img_ps_dir}styles/{$customization.salwar_style_image}" width="90px"/>
                                                                            <span style="font-family: Abel; font-size: 14px; display: block; width: 100%; line-height: 1em">
                                                                                {$customization.salwar_style_name}
                                                                            </span>
                                                                        </span>
                                                                        <span style="display: inline-block; width: 150px; line-height: 1.2em; vertical-align: top; padding-top: 10px;">
                                                                            Stitched to measure Salwar
                                                                            <br />
                                                                            Measurement for: <span style="text-transform: capitalize;">{$customization.salwar_measurement}</span>
                                                                       </span>
                                                                    {/if}
                                                                {/if}
                                                                {if $textField.index == 5}
                                                                    <span style="width: 137px; display: inline-block; text-align: center;">
                                                                        <img src="{$img_ps_dir}styles/{$customization.choli_style_image}" width="90px"/>
                                                                        <span style="font-family: Abel; font-size: 14px; display: block; width: 100%; line-height: 1em">
                                                                            {$customization.choli_style_name}
                                                                        </span>
                                                                    </span>
                                                                    <span style="display: inline-block; width: 150px; line-height: 1.2em; vertical-align: top; padding-top: 10px;">
                                                                        Stitched to measure choli
                                                                        <br />
                                                                        Measurement for: <span style="text-transform: capitalize;">{$customization.choli_measurement}</span>
                                                                    </span>
                                                                    <br />
                                                                    <span style="width: 137px; display: inline-block; text-align: center;">
                                                                        <img src="{$img_ps_dir}styles/{$customization.lehenga_style_image}" width="90px"/>
                                                                        <span style="font-family: Abel; font-size: 14px; display: block; width: 100%; line-height: 1em">
                                                                            {$customization.lehenga_style_name}
                                                                        </span>
                                                                    </span>
                                                                    <span style="display: inline-block; width: 150px; line-height: 1.2em; vertical-align: top; padding-top: 10px;">
                                                                        Stitched to measure lehenga
                                                                        <br />
                                                                        Measurement for: <span style="text-transform: capitalize;">{$customization.lehenga_measurement}</span>
                                                                    </span>
                                                                {/if}
                                                            </li>
                                                        {/foreach}
                                                    </ul>
                                                {/if}
                                            {/foreach}
                                        </td>
                                        <td class="cart_quantity" style="vertical-align: top; padding-top: 10px;text-align:center">
                                            <div id="cart_quantity_button" class="qty_spinner">
                                                <input
                                                    type="hidden"
                                                    value="{$customization.quantity}"
                                                    name="quantity_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}_hidden" /> <input
                                                    size="2"
                                                    type="hidden"
                                                    value="{$customization.quantity}"
                                                    class="cart_quantity_input"
                                                    name="quantity_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}" />
                                                <span>{$customization.quantity}</span>
                                                {*<a rel="nofollow" class="cart_quantity_up btn_spinner_up" id="cart_quantity_up_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}"
                                                href="{$link->getPageLink('cart.php', true)}?add&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;id_customization={$id_customization}&amp;token={$token_cart}" title="{l s='Add'}"> </a> <br /> {if $product.minimal_quantity <
                                                ($customization.quantity -$quantityDisplayed) OR $product.minimal_quantity <= 1} <a rel="nofollow" class="cart_quantity_down btn_spinner_down" id="cart_quantity_down_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}" href="{$link->getPageLink('cart.php',
                                                true)}?add&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;id_customization={$id_customization}&amp;op=down&amp;token={$token_cart}" title="{l s='Subtract'}"> </a> {else} <a class="cart_quantity_down btn_spinner_down" style="opacity: 0.3;"
                                                id="cart_quantity_down_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}" href="#" title="{l s='Subtract'}"> </a> {/if} *}
                                            </div>
                                            <span style="font-size: 11px">
                                                <a rel="nofollow"
                                                   class="cart_quantity_delete"
                                                   id="{$product.id_product}_{$product.id_product_attribute}_{$id_customization}"
                                                   href="{$link->getPageLink('cart.php', true)}?delete&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;id_customization={$id_customization}&amp;token={$token_cart}">
                                                    {*<img src="{$img_dir}icon/delete.gif" alt="{l s='Delete'}" title="{l s='Delete this customization'}" width="11" height="13" class="icon" />*}
                                                    <span>REMOVE</span>
                                                </a>
                                            </span>
                                        </td>
                                        <td class="cart_total">
                                        </td>
                                    </tr>
                                    {assign var='quantityDisplayed' value=$quantityDisplayed+$customization.quantity}
                                {/foreach}
                                {* If it exists also some uncustomized products *}
                                {if $product.quantity-$quantityDisplayed > 0}
                                    {include file="$tpl_dir./shopping-cart-product-line.tpl"}
                                {/if}
                            {/if}
                        {/foreach}
                    </tbody>
                    {if sizeof($discounts) || isset($cart_points_discount) && $cart_points_discount > 0}
                        <tbody>
                            {foreach from=$discounts item=discount name=discountLoop}

                                {if $smarty.foreach.discountLoop.last}
                                    {assign var=trclass value='last_item'}
                                {elseif $smarty.foreach.discountLoop.first}
                                    {assign var=trclass value='first_item'}
                                {else}
                                    {assign var=trclass value='item'}
                                {/if}
                                
                                {*if strpos('B1G1', $discount.name) != 0*}
                                <tr class="cart_discount {$trclass}" id="cart_discount_{$discount.id_discount}">
                                    <td class="cart_discount_name" colspan="4" style="text-align: right">        
                                            {$discount.name}:{$discount.description}
                                    </td>
                                    {*if $discount.description != ''} : {$discount.description} {/if*}
                                    <!--td class="cart_discount_description" colspan="2" style="text-align:right">
                                    {$discount.description}
                                    </td-->
                                    
                                    <td class="cart_discount_delete">
                                        <a href="{if $opc}{$link->getPageLink('order-opc.php', true)}{else}{$link->getPageLink('order.php', true)}{/if}?deleteDiscount={$discount.id_discount}"
                                           title="{l s='Delete'}">
                                            <img src="{$img_dir}icon/delete.gif" alt="{l s='Delete'}"
                                                 class="icon" width="11" height="13" />
                                        </a>
                                    </td>
                                    <td class="cart_discount_price">
                                        <span class="price-discount">
                                            {if $discount.value_real > 0}
                                                {if !$priceDisplay}
                                                    {displayPrice price=$discount.value_real*-1}
                                                {else}
                                                    {displayPrice price=$discount.value_tax_exc*-1}
                                                {/if}
                                            {/if}
                                        </span>
                                    </td>
                                </tr>
                                {*/if*}
                            {/foreach}
                            {if isset($cart_points_discount) && $cart_points_discount > 0}
                                <tr class="cart_discount" id="cart_points">
                                    <td class="cart_discount_name" colspan="4" style="text-align:right">
                                        Diva Coins redeemed: {$cart_redeem_points}
                                    </td>
                                    <td class="cart_discount_delete">
                                        <a href="{$link->getPageLink('order.php', true)}?deletePoints=1" title="{l s='Delete'}">
                                            <img src="{$img_dir}icon/delete.gif" alt="{l s='Delete'}" class="icon" width="11" height="13" />
                                        </a>
                                    </td>
                                    <td class="cart_discount_price">
                                        <span class="price-discount"> {displayPrice price=$cart_points_discount*-1} </span>
                                    </td>
                                </tr>
                            {/if}
                        </tbody>
                    {/if}
                </table>
            </div>
            {if $voucherAllowed}
                <div id="cart_redeem" style="padding: 10px 0 30px 0">
                    {if isset($errors_discount) && $errors_discount}
                        <ul class="error">
                            {foreach from=$errors_discount key=k item=error}
                                <li>
                                    {$error|escape:'htmlall':'UTF-8'}
                                </li>
                            {/foreach}
                        </ul>
                    {/if}
                    <div style="text-align: right; padding-right: 0.7em;">
            {if $displayVouchers || isset($can_redeem_points) && (isset($balance_points) && $balance_points > 0) || isset($redeem_points) && $redeem_points > 0}
                {assign var='check' value="checked='checked'"}
                {assign var='display' value='block'}
                {assign var='show_redemption' value=true}
            {else}
                {assign var='check' value=""}
                {assign var='display' value='none'}
                {assign var='show_redemption' value=false}
            {/if}
                        <input type="checkbox" id="chk_redeem" class="redeem_check" {$check}>
                        <label for="chk_redeem" style="font-size: 12px; display: inline-block">
                            {l s='Redeem vouchers'}
                        </label>
                    </div>
                    <form action="{if $opc}{$link->getPageLink('order-opc.php', true)}{else}{$link->getPageLink('order.php', true)}{/if}"
                          method="post"
                          id="voucher">
                        <fieldset>
                            <div style="padding: 20px 200px 20px 150px; border-top: 1px dashed #cacaca; border-bottom: 1px dashed #cacaca; display: {$display}; float:left; width:52%"
                                 class="redemption_control">
                                {if isset($can_redeem_points) && (isset($balance_points) && $balance_points > 0) || isset($redeem_points) && $redeem_points > 0}
                                    <div style="text-align: left">
                                        <span style="font-size:15px;display:inline-block;{if !isset($can_redeem_points)}color:#939393{/if}">
                                            {l s='Redeem Diva Coins'}
                                            <span style="font-size:12px;color:#939393;">
                                                [{$balance_points - $cart_redeem_points} Redeemable 
                                                {if isset($balance_cash) && !empty($balance_cash)}
                                                    (Equals to <b>{displayPrice price=$balance_cash}</b>)]
                                                {/if}
                                            </span>
                                        </span>
                                        {if isset($redeem_points) && $redeem_points > 0}
                                            <p style="font-size:12px;color:#939393;">You redeemed {$redeem_points} Coins in this order.</p>
                                        {else}
                                            {if $redemption_status eq 2}
                                                <input type="text" id="redeem_points" name="redeem_points" value="{if isset($redeem_points) && $redeem_points}{$redeem_points}{/if}" />
                                            {else}
                                                <p style="font-size:12px;color:#939393;">{$redemption_status_message}</p>
                                            {/if}
                                        {/if}
                                    </div>
                                {/if}
                                <div style="text-align: left">
                                    <span style="font-size: 15px; width: 150px; display: block">{l s='Voucher Code'}</span>
                                    <input type="text"
                                           id="discount_name"
                                           name="discount_name"
                                           value="{if isset($discount_name) && $discount_name}{$discount_name}{/if}" />
                                </div>
                                <div class="submit" style="text-align: left; padding:15px 0 15px 8px">
                                    <input
                                        type="hidden"
                                        name="submitDiscount" />
                                    <input
                                        type="submit"
                                        name="submitAddDiscount"
                                        value="{l s='Redeem!'}"
                                        class="button"
                                        style="display: inline-block;" />
                                </div>
                                {if $displayVouchers}
                                    <h4 style="padding-left:10px;">{l s='Vouchers in your account:'}</h4>
                                    <div id="display_cart_vouchers" style="padding-left:10px;">
                                        {foreach from=$displayVouchers item=voucher}
                                            <span onclick="$('#discount_name').val('{$voucher.name}'); return false;" class="voucher_name">
                                                {$voucher.name}
                                            </span> - {$voucher.description}
                                            <br />
                                        {/foreach}
                                    </div>
                                {/if}
                            </div>
                        </fieldset>
                    </form>
                </div>
            {/if}
            <div id="HOOK_SHOPPING_CART">
                {$HOOK_SHOPPING_CART}
            </div>
            <div id="cart_navigation" class="cart_navigation">
                {if !$opc}
                    {if $cookie->isLogged()}
                        {if isset($cart->id_address_delivery) && $cart->id_address_delivery > 0 && isset($cart->id_address_invoice) && $cart->id_address_invoice > 0}
                            <a id="place_order_button"
                               rel="nofollow"
                               href="{$link->getPageLink('order.php', true)}?step=3{if $back}&amp;back={$back}{/if}"
                               class="placeorder place_order_button"></a>
                        {else}
                            <a id="place_order_button"
                               rel="nofollow"
                               href="{$link->getPageLink('order.php', true)}?step=1{if $back}&amp;back={$back}{/if}"
                               class="placeorder place_order_button"></a>
                        {/if}
                    {else}
                        <a
                            id="place_order_button"
                            rel="nofollow"
                            href="#login_modal_panel"
                            class="placeorder place_order_button"></a>
                    {/if}
                {/if}
                <a rel="nofollow"
                   href="{if (isset($smarty.server.HTTP_REFERER) && strstr($smarty.server.HTTP_REFERER, 'order.php')) || !isset($smarty.server.HTTP_REFERER)}{$link->getPageLink('index.php')}{else}{$smarty.server.HTTP_REFERER|escape:'htmlall':'UTF-8'|secureReferrer}{/if}"
                   class="secondary"
                   title="{l s='Continue shopping'}"
                   style="width: 151px; margin-top: 5px; float: left; margin-bottom: 5px;">
                    &laquo; {l s='Continue Shopping'}
                </a>
            </div>
            <div class="clear"></div>

            <p class="cart_navigation_extra">
                <span id="HOOK_SHOPPING_CART_EXTRA">{$HOOK_SHOPPING_CART_EXTRA}</span>
            </p>
        {/if}
    </div>
    {if !isset($summary_only) && !isset($empty)}
        <div id="co_rht_col" style="padding-top:0px;width:210px;">
            <div class="co_rht_box" style="margin-left:10px; border:1px solid #cacaca; -moz-border-radius: 5px; -webkit-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px; margin-bottom:20px;">
                <div id="order_summary_title" class="rht_box_heading" style="background:#EDEDED; padding: 5px 0">
                    Order Summary
                </div>
                <div id="order_summary_content" class="rht_box_info">
                    <table>
                        <tbody>
                            {if $productNumber > 0}
                                <tr>
                                    <td class="row_title">Items</td>
                                    <td>:</td>
                                    <td class="row_val">
                                        <span class="ajax_cart_quantity" style="font-size: 12px;">
                                            {$productNumber}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="row_title">Products Total</td>
                                    <td>:</td>
                                    <td class="row_val">
                                        <span class="ajax_products_total">
                                            {displayPrice price=$total_products_wt}
                                        </span>
                                    </td>
                                </tr>
                                {if $total_discounts != 0}
                                    <tr>
                                        <td class="row_title">Discounts</td>
                                        <td>:</td>
                                        <td class="row_val">
                                            <span class="ajax_cart_discounts">
                                                {displayPrice price=$total_discounts}
                                            </span>
                                        </td>
                                    </tr>
                                {/if}
                                <tr>
                                    <td class="row_title">Sub Total</td>
                                    <td>:</td>
                                    <td class="row_val">
                                        <span class="ajax_cart_total">
                                            {displayPrice price=($total_price-$shippingCost)}
                                        </span>
                                    </td>
                                </tr>
                                {*
                                <tr>
                                <td class="row_title">Shipping</td>
                                <td>:</td> {if $shippingCost > 0}
                                <td class="row_val"><span
                                class="ajax_cart_shipping_cost"
                                id="rht_bar_shipping">{displayPrice price=$shippingCost}</span></td>
                                <td class="row_val"><span
                                class="ajax_cart_shipping_cost"
                                id="rht_bar_shipping">Extra</span></td>{else}
                                <td class="row_val"><span id="rht_bar_shipping"> FREE (India)</span></td> {/if}
                                </tr>*}
                                <tr>
                                    <td colspan="3" style="text-align:center;padding:5px 20px">
                                        {if $cookie->isLogged()}
                                            {if isset($cart->id_address_delivery) && $cart->id_address_delivery > 0 && isset($cart->id_address_invoice) && $cart->id_address_invoice > 0}
                                                <a rel="nofollow"
                                                   class="button exclusive small place_order_button"
                                                   href="{$link->getPageLink('order.php', true)}?step=3{if $back}&amp;back={$back}{/if}"
                                                   style="margin:auto" title="Place Order">Place Order</a>
                                            {else}
                                                <a rel="nofollow" class="button exclusive small place_order_button"
                                                   href="{$link->getPageLink('order.php', true)}?step=1{if $back}&amp;back={$back}{/if}"
                                                   style="margin:auto" title="Place Order">Place Order</a>
                                            {/if}
                                        {else}
                                            <a rel="nofollow"
                                               class="button exclusive small place_order_button"
                                               href="#login_modal_panel"
                                               style="margin:auto" title="Place Order">Place Order</a>
                                        {/if}
                                    </td>
                                </tr>
                                {*<tr>
                                <td class="row_title"><span style="font-weight: bold; color: #5f5f5f;">Order Total</span></td>
                                <td>:</td>
                                <td class="row_val"><span
                                style="font-weight: bold;"
                                class="ajax_block_cart_total">{displayPrice price=$total_price}</span></td>
                                </tr>*}
                            {/if}
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="co_rht_box" style="margin-left:10px; border:1px solid #cacaca; -moz-border-radius: 5px; -webkit-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px; margin-bottom:20px;">
                <div id="order_summary_title" class="rht_box_heading" style="padding: 5px 0">
                    Shop With Confidence
                </div>
                <div id="order_summary_content" class="rht_box_info">
                    <table>
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    Its completely safe to shop with us. We partner with the most trusted online payment solution providers. <br />
                                    <table width="135" border="0" cellpadding="2" cellspacing="0" title="Click to Verify - This site chose Symantec SSL for secure e-commerce and confidential communications.">
                                        <tr>
                                            <td width="135" align="center" valign="top">
                                                <script type="text/javascript" src="https://seal.verisign.com/getseal?host_name=www.indusdiva.com&amp;size=L&amp;use_flash=YES&amp;use_transparent=YES&amp;lang=en"></script><br />
                                                <a href="http://www.symantec.com/ssl-certificates" target="_blank"  style="color:#000000; text-decoration:none; font:bold 7px verdana,sans-serif; letter-spacing:.5px; text-align:center; margin:0px; padding:0px;">ABOUT SSL CERTIFICATES</a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="co_rht_box" style="margin-left:10px; border:1px solid #cacaca; -moz-border-radius: 5px; -webkit-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px; margin-bottom:20px;">
                <div id="order_summary_title" class="rht_box_heading" style="padding: 5px 0">
                    Questions? Just ask!
                </div>
                <div
                    id="order_summary_content"
                    class="rht_box_info" style="text-align:center">
                    <span id="asksupportlink" class="span_link" style="color:#A41E21">
                        Ask our live support
                    </span>
                </div>
            </div>
            
        </div>
    {/if}
    <script type="text/javascript">
        {if !$cookie->isLogged()}
                var orderStepURL = '{$link->getPageLink('order.php', true)}?step=1{if $back}&amp;back={$back}{/if}';
        {else}
                var orderStepURL = false;
        {/if}
                var vouchersAvailable = false;
        {if $show_redemption}
                vouchersAvailable = true;
        {/if}
        var blinkc = 0;
        {literal}
            $(document).ready(function() {
                    $('#asksupportlink').click(function() {
                    $zopim.livechat.window.show();
                            $zopim.livechat.say('I need help with checkout!')
                    });
                            if (!vouchersAvailable)
                            $('#chk_redeem').removeAttr('checked');
                            if ($('#redeem_points').val() || $('#discount_name').val())
                    {
                    $('#chk_redeem').attr('checked', 'checked');
                            $(".redemption_control").show();
                    }

                    $('#chk_redeem').click(function() {
                    if ($("#chk_redeem ").is(':checked'))
                            $(".redemption_control").show();
                            else
                            $(".redemption_control").hide();
                    });
                            $('.place_order_button').click(function(e) {
                    if ($('#redeem_points').val() || $('#discount_name').val())
                    {
                    if (!confirm('Continue place order without redeeming?'))
                            e.preventDefault();
                    }

                    if (orderStepURL)
                    {
                    requestURI = orderStepURL;
                            $('#id_back').val('order.php?step=1');
                            $.fancybox.open({
                    href: '#login_modal_panel'
                    });
                    }
                    try {
                    _sokAddtoCartPixel();
                    } catch (err) {
                    }
                    });
                    });{/literal}        </script>
        <!-- sokrati -->
        <script type="text/javascript">
                            <!--
        _sokClient = '249';
                            //-->
        </script>
        <script type="text/javascript">
                            var sokhost = ("https:" == document.location.protocol) ? "https://tracking.sokrati.com" : "http://cdn.sokrati.com";
                            var sokratiJS = sokhost + '/javascripts/tracker.js';
                            document.write(unescape("%3Cscript src='" + sokratiJS + "' type='text/javascript'%3E%3C/script%3E"));</script>
        <script type="text/javascript">
                            var paramList = {};
                            paramList['lead_step'] = 'Add2Bag';</script>
        <script type="text/javascript">
                            try {
    sokrati.trackSaleParams("0", "0", "{$total_price}", "{$productNumber}", paramList);
                    }
                    catch (err) {
                    }
        </script>
    </div>
