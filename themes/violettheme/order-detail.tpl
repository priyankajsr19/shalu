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
*  @version  Release: $Revision: 6784 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<script type="text/javascript">
// <![CDATA[
        
//]]>
</script>
<div style="width: 210px; float: right; margin-right:10px;padding:0px 10px">
    <div class="address_card_selected" style="height:200px">
        <div class="address_title underline" style="padding:3px 15px;display:block;">
            Delivery Address
        </div>
        <ul class="address item">
            <li class="address_name">{$address_delivery->firstname|addslashes} {$address_delivery->lastname|addslashes}</li>
            <li class="address_address1">{$address_delivery->address1|addslashes}</li>
            <li class="address_address2">{$address_delivery->state_name|addslashes}</li>
            <li class="address_city">{$address_delivery->city|addslashes}</li>
            <li class="address_pincode">{$address_delivery->postcode|addslashes}</li>
            <li class="address_pincode">{$address_delivery->country|addslashes}</li>
            <li class="address_country">Phone: {$address_delivery->phone_mobile|addslashes}</li>
        </ul>
    </div>
</div>

{*
<div id="reorder-form" style="width:400px;float:left;">
<form action="{if isset($opc) && $opc}{$link->getPageLink('order-opc.php', true)}{else}{$link->getPageLink('order.php', true)}{/if}" method="post" class="submit">
    <div>
        <input type="hidden" value="{$order->id}" name="id_order"/>
        <h4>
            {l s='Order placed on'} {dateFormat date=$order->date_add full=0}
            <input type="submit" value="{l s='Reorder'}" name="submitReorder" class="button exclusive" style="float:right"/>
        </h4>
    </div>
</form>
</div>
*}
{*
{if count($order_history)}
<div class="table_block" style="width:450px;margin:10px 0 0 10px;;">
    <h4>Order status:</h4>
    <table class="detail_step_by_step std">
        <thead>
            <tr>
                <th class="first_item">{l s='Date'}</th>
                <th class="last_item">{l s='Status'}</th>
            </tr>
        </thead>
        
        <tbody>
        {foreach from=$order_history item=state name="orderStates"}
            <tr class="{if $smarty.foreach.orderStates.first}first_item{elseif $smarty.foreach.orderStates.last}last_item{/if} {if $smarty.foreach.orderStates.index % 2}alternate_item{else}item{/if}">
                <td>{dateFormat date=$state.date_add full=1}</td>
                <td>{$state.ostate_name|escape:'htmlall':'UTF-8'}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>
</div>
{/if}
*}
<div style="width:450px; float:left;">
    {if isset($followup)}
    <p class="bold">{l s='Click the following link to track the delivery of your order'}</p>
    <a href="{$followup|escape:'htmlall':'UTF-8'}">{$followup|escape:'htmlall':'UTF-8'}</a>
    {/if}
    
    <p class="bold">{l s='Order:'} <span class="color-myaccount">{l s='#'}{$order->id|string_format:"%06d"}</span></p>
    {*{if $carrier->id}<p class="bold">{l s='Carrier:'} {if $carrier->name == "0"}{$shop_name|escape:'htmlall':'UTF-8'}{else}{$carrier->name|escape:'htmlall':'UTF-8'}{/if}</p>{/if}*}
    <p class="bold">{l s='Payment method:'} <span class="color-myaccount">{$order->payment|escape:'htmlall':'UTF-8'}</span></p>
    {if $invoice AND $invoiceAllowed}
    <p>
        <img src="{$img_dir}icon/pdf.gif" alt="" class="icon" />
        <a href="{$link->getPageLink('pdf-invoice.php', true)}?id_order={$order->id|intval}{if $is_guest}&secure_key={$order->secure_key}{/if}">{l s='Download your invoice as a .PDF file'}</a>
    </p>
    {/if}
    {if $order->recyclable}
    <p><img src="{$img_dir}icon/recyclable.gif" alt="" class="icon" />&nbsp;{l s='You have given permission to receive your order in recycled packaging.'}</p>
    {/if}
    {if $order->gift}
        <p><img src="{$img_dir}icon/gift.gif" alt="" class="icon" />&nbsp;{l s='You requested gift-wrapping for your order.'}</p>
        <p>{l s='Message:'} {$order->gift_message|nl2br}</p>
    {/if}
    <br />
</div>



{$HOOK_ORDERDETAILDISPLAYED}

<div style="float:left;">
{if !$is_guest}<form action="{$link->getPageLink('order-follow.php', true)}" method="post">{/if}
<div id="order-detail-content" class="table_block">
    <p class="bold" style="font-family:Abel">{l s='Order details'}</p>
    <div style="border-top:1px solid #cacaca;">
    <table class="std">
        <thead>
            <tr>
                {if $return_allowed}<th class="first_item"><input type="checkbox" /></th>{/if}
                <th class="item" style="text-align:left;">{l s='Product'}</th>
                <th class="item">{l s='Quantity'}</th>
                <th class="item" style="text-align:right;">{l s='Unit price'}</th>
                <th class="last_item" style="text-align:right;">{l s='Total price'}</th>
            </tr>
        </thead>
        <tfoot>
            {if $order->customization_fee > 0}
            <tr class="item">
                <td colspan="4">
                    {l s='Stitching and customizations:'} <span class="price-shipping" style="padding-left:15px">{displayWtPriceWithCurrency price=$order->customization_fee currency=$currency}</span>
                </td>
            </tr>
            {/if}
            {if $priceDisplay && $use_tax}
                <tr class="item">
                    <td colspan="{if $return_allowed}5{else}4{/if}">
                        {l s='Subtotal:'} <span class="price">{displayWtPriceWithCurrency price=$order->getTotalProductsWithoutTaxes() currency=$currency}</span>
                    </td>
                </tr>
            {/if}
            <tr class="item">
                <td colspan="{if $return_allowed}5{else}4{/if}">
                    {l s='Subtotal'} {if $use_tax}{l s=''}{/if}: <span class="price" style="padding-left:15px">{displayWtPriceWithCurrency price=$order->getTotalProductsWithTaxes() currency=$currency}</span>
                </td>
            </tr>
            {if $order->total_discounts > 0}
            <tr class="item">
                <td colspan="{if $return_allowed}5{else}4{/if}">
                    {l s='Vouchers / Discounts:'} <span class="price-discount" style="padding-left:15px">{displayWtPriceWithCurrency price=$order->total_discounts currency=$currency}</span>
                </td>
            </tr>
            {/if}
            {if $order->total_wrapping > 0}
            <tr class="item">
                <td colspan="{if $return_allowed}5{else}4{/if}">
                    {l s='Total gift-wrapping:'} <span class="price-wrapping">{displayWtPriceWithCurrency price=$order->total_wrapping currency=$currency}</span>
                </td>
            </tr>
            {/if}
            {if $order->total_cod > 0}
            <tr class="item">
                <td colspan="4">
                    {l s='COD Charges:'} <span class="price-shipping" style="padding-left:15px">{displayWtPriceWithCurrency price=$order->total_cod currency=$currency}</span>
                </td>
            </tr>
            {/if}
            
            <tr class="item">
                <td colspan="{if $return_allowed}5{else}4{/if}">
                    {l s='Shipping'} {if $use_tax}{l s=''}{/if}: <span class="price-shipping" style="padding-left:15px">{displayWtPriceWithCurrency price=$order->total_shipping currency=$currency}</span>
                </td>
            </tr>
	    {if $order->total_donation > 0}
            <tr class="item">
                <td colspan="{if $return_allowed}5{else}4{/if}">
                    {l s="Donation Amount"}: <span style="padding-left:15px">{displayWtPriceWithCurrency price=$order->total_donation currency=$currency}</span>
                </td>
            </tr>
	    {/if}
            <tr class="item">
                <td colspan="{if $return_allowed}5{else}4{/if}">
                    {l s='Order Total:'} <span class="price" style="padding-left:15px">{displayWtPriceWithCurrency price=$order->total_paid currency=$currency}</span>
                </td>
            </tr>
        </tfoot>
        <tbody>
        {foreach from=$products item=product name=products}
            {if !isset($product.deleted)}
                {assign var='productId' value=$product.product_id}
                {assign var='productAttributeId' value=$product.product_attribute_id}
                {if isset($customizedDatas.$productId.$productAttributeId)}{assign var='productQuantity' value=$product.product_quantity-$product.customizationQuantityTotal}{else}{assign var='productQuantity' value=$product.product_quantity}{/if}
                <!-- Customized products -->
                {if isset($customizedDatas.$productId.$productAttributeId)}
                    <tr class="item">
                        {if $return_allowed}<td class="order_cb"></td>{/if}
                        <td class="bold" style="text-align:left;">
                            <label  for="cb_{$product.id_order_detail|intval}">{$product.product_name|escape:'htmlall':'UTF-8'}</label>
                        </td>
                        <td style="text-align:center;"><input class="order_qte_input"  name="order_qte_input[{$smarty.foreach.products.index}]" type="text" size="2" value="{$product.customizationQuantityTotal|intval}" /><label for="cb_{$product.id_order_detail|intval}"><span class="order_qte_span editable">{$product.customizationQuantityTotal|intval}</span></label></td>
                        <td style="text-align:right">
                            <label for="cb_{$product.id_order_detail|intval}">
                                {if $group_use_tax}
                                    {convertPriceWithCurrency price=$product.product_price_wt currency=$currency convert=0}
                                {else}
                                    {convertPriceWithCurrency price=$product.product_price currency=$currency convert=0}
                                {/if}
                            </label>
                        </td>
                        <td style="text-align:right">
                            <label for="cb_{$product.id_order_detail|intval}">
                                {if isset($customizedDatas.$productId.$productAttributeId)}
                                    {if $group_use_tax}
                                        {convertPriceWithCurrency price=$product.total_customization_wt currency=$currency convert=0}
                                    {else}
                                        {convertPriceWithCurrency price=$product.total_customization currency=$currency convert=0}
                                    {/if}
                                {else}
                                    {if $group_use_tax}
                                        {convertPriceWithCurrency price=$product.total_wt currency=$currency convert=0}
                                    {else}
                                        {convertPriceWithCurrency price=$product.total_price currency=$currency convert=0}
                                    {/if}
                                {/if}
                            </label>
                        </td>
                    </tr>
                    {foreach from=$customizedDatas.$productId.$productAttributeId item='customization' key='customizationId'}
                    <tr class="alternate_item">
                        {if $return_allowed}<td class="order_cb"><input type="checkbox" id="cb_{$product.id_order_detail|intval}" name="customization_ids[{$product.id_order_detail|intval}][]" value="{$customizationId|intval}" /></td>{/if}
                        <td colspan="1">
                        {foreach from=$customization.datas key='type' item='datas'}
                            {if $type == $CUSTOMIZE_FILE}
                            <ul class="customizationUploaded">
                                {foreach from=$datas item='data'}
                                    <li><img src="{$pic_dir}{$data.value}_small" alt="" class="customizationUploaded" /></li>
                                {/foreach}
                            </ul>
                            {elseif $type == $CUSTOMIZE_TEXTFIELD}
                            <ul class="typedText">{counter start=0 print=false}
                                {foreach from=$datas item='data'}
                                    {assign var='customizationFieldName' value="Text #"|cat:$data.id_customization_field}
                                    {*<li>{$data.name|default:$customizationFieldName}{l s=':'} {$data.value}</li>*}
                                    <li style="padding-top:10px;">
                                        {if $data.index == 9}
                                            Garment fabric
                                        {/if}
                                        {if $data.index == 8}
                                            {if $customization.fall_piko eq "1"}
                                                Saree with unstitched blouse and fall/pico work.
                                            {else}
                                                Saree with unstitched blouse and without fall/pico work.
                                            {/if}
                                        {/if}
                                        {if $data.index == 1}
                                            Pre-stitched saree with unstitched blouse and fall/pico work.
                                        {/if}
                                        {if $data.index == 2}
                                            <span style="width:137px;display:inline-block;text-align:center;">
                                                <img src="{$img_ps_dir}styles/{$customization.blouse_style_image}" width="90" />
                                                <span style="font-family:Abel;font-size:14px;display:block;width:100%;line-height:1em">{$customization.blouse_style_name}</span>
                                            </span>
                                            <span style="display:inline-block;width:150px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                Stitched to measure blouse <br />
                                                Measurement for: <span style="text-transform:capitalize;">{$customization.blouse_measurement}</span><br/>
                                                {if $customization.fall_piko eq "1"}
                                                    <span>With fall/piko work</span>
                                                {else}
                                                    <span>Without fall/piko work</span>
                                                {/if}
                                            </span>
                                        {/if}
                                        {if $data.index == 3}
                                            <span style="width:137px;display:inline-block;text-align:center;">
                                                <img src="{$img_ps_dir}styles/{$customization.inskirt_style_image}" height="90"/>
                                                <span style="font-family:Abel;font-size:14px;display:block;width:100%;line-height:1em">{$customization.inskirt_style_name}</span>
                                            </span>
                                            <span style="display:inline-block;width:150px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                Stitched to measure in-skirt <br />
                                                Measurement for: <span style="text-transform:capitalize;">{$customization.inskirt_measurement}</span><br/>
                                                {if $customization.fall_piko eq "1"}
                                                    <span>With fall/piko work</span>
                                                {else}
                                                    <span>Without fall/piko work</span>
                                                {/if}
                                            </span>
                                        {/if}
                                        {if $data.index == 4}
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                Stitched to measure kurta <br />
                                                Measurement for: <span style="text-transform:capitalize;">{$customization.kurta_measurement}</span>
                                            </span>
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                Stitched to measure salwar <br />
                                                Measurement for: <span style="text-transform:capitalize;">{$customization.salwar_measurement}</span>
                                            </span>
                                        {/if}
                                        {if $data.index == 5}
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                Stitched to measure Lehenga Choli <br />
                                                Lehenga Measurement for: <span style="text-transform:capitalize;">{$customization.lehenga_measurement}</span> <br />
                                                Choli Measurement for: <span style="text-transform:capitalize;">{$customization.choli_measurement}</span>
                                            </span>
                                        {/if}
                                        {if $data.index == 10}
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                + Long Choli
                                            </span>
                                        {/if}
                                        {if $data.index == 11}
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                + Long Sleeves
                                            </span>
                                        {/if}
                                        {if $data.index == 13}
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                Style: {$customization.choli_style} <br />
                                                Size: {$customization.choli_size}
                                            </span>
                                        {/if}
                                        {if $data.index == 24}
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                Stitched to measure Salwar Kameez <br />
                                                {if isset($customization.salwar_style_name) && !empty($customization.salwar_style_name)}
                                                    Salwar Measurement for: <span style="text-transform:capitalize;">{$customization.salwar_measurement} , Style : <span> {$customization.salwar_style_name} </span> </span> <br />
                                                {/if}
                                                {if isset($customization.kurta_style_name) && !empty($customization.kurta_style_name)}
                                                    Kurta Measurement for: <span style="text-transform:capitalize;">{$customization.kurta_measurement} , Style : <span> {$customization.kurta_style_name} </span></span>
                                                {/if}
                                            </span>
                                        {/if}
                                        {if $data.index == 21}
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                {if isset($customization.friends_name) && !empty($customization.friends_name)}
                                                    To : <span style="text-transform:capitalize;">{$customization.friends_name}</span></br/>
                                                {/if}
                                            </span>
                                        {/if}
                                        {if $data.index == 22}
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                {if isset($customization.friends_email) && !empty($customization.friends_email)}
                                                    Email : <span style="text-transform:none;">{$customization.friends_email}</span></br/>
                                                {/if}
                                            </span>
                                        {/if}
                                        {if $data.index == 23}
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                {if isset($customization.gift_message) && !empty($customization.gift_message)}
                                                    Gift Message : <span style="text-transform:capitalize;">{$customization.gift_message}</span></br/>
                                                {/if}
                                            </span>
                                        {/if}
                                        {*{if $textField.name}{$textField.name}{else}{l s='Text #'}{$smarty.foreach.typedText.index+1}{/if}{l s=':'} {$textField.value}*}
                                    </li>
                                {/foreach}
                            </ul>
                            {/if}
                        {/foreach}
                        </td>
                        <td style="text-align:center">
                            <input class="order_qte_input" name="customization_qty_input[{$customizationId|intval}]" type="text" size="2" value="{$customization.quantity|intval}" /><label for="cb_{$product.id_order_detail|intval}"><span class="order_qte_span editable">{$customization.quantity|intval}</span></label>
                        </td>
                        <td colspan="2"></td>
                    </tr>
                    {/foreach}
                {/if}
                <!-- Classic products -->
                {if $product.product_quantity > $product.customizationQuantityTotal}
                    <tr style='background-color: {cycle values="#eeeeee,#d0d0d0"}'>
                        {if $return_allowed}<td class="order_cb"><input type="checkbox" id="cb_{$product.id_order_detail|intval}" name="ids_order_detail[{$product.id_order_detail|intval}]" value="{$product.id_order_detail|intval}" /></td>{/if}
                        <td class="bold">
                            <label class="order-detail-label" for="cb_{$product.id_order_detail|intval}">
                                {if $product.download_hash && $invoice}
                                    <a href="{$link->getPageLink('get-file.php', true)}?key={$product.filename|escape:'htmlall':'UTF-8'}-{$product.download_hash|escape:'htmlall':'UTF-8'}{if isset($is_guest) && $is_guest}&id_order={$order->id}&secure_key={$order->secure_key}{/if}" title="{l s='download this product'}">
                                        <img src="{$img_dir}icon/download_product.gif" class="icon" alt="{l s='Download product'}" />
                                    </a>
                                    <a href="{$link->getPageLink('get-file.php', true)}?key={$product.filename|escape:'htmlall':'UTF-8'}-{$product.download_hash|escape:'htmlall':'UTF-8'}{if isset($is_guest) && $is_guest}&id_order={$order->id}&secure_key={$order->secure_key}{/if}" title="{l s='download this product'}">
                                        {$product.product_name|escape:'htmlall':'UTF-8'}
                                    </a>
                                {else}
                                    {$product.product_name|escape:'htmlall':'UTF-8'}
                                {/if}
                            </label>
                        </td>
                        <td style="text-align:center;"><input class="order_qte_input" name="order_qte_input[{$product.id_order_detail|intval}]" type="text" size="2" value="{$productQuantity|intval}" /><label for="cb_{$product.id_order_detail|intval}"><span class="order_qte_span editable">{$productQuantity|intval}</span></label></td>
                        <td style="text-align:right;">
                            <label class="order-detail-label" for="cb_{$product.id_order_detail|intval}">
                            {if $group_use_tax}
                                {convertPriceWithCurrency price=$product.product_price_wt currency=$currency convert=0}
                            {else}
                                {convertPriceWithCurrency price=$product.product_price currency=$currency convert=0}
                            {/if}
                            </label>
                        </td>
                        <td style="text-align:right;">
                            <label class="order-detail-label" for="cb_{$product.id_order_detail|intval}">
                            {if $group_use_tax}
                                {convertPriceWithCurrency price=$product.total_wt currency=$currency convert=0}
                            {else}
                                {convertPriceWithCurrency price=$product.total_price currency=$currency convert=0}
                            {/if}
                            </label>
                        </td>
                    </tr>
                {/if}
            {/if}
        {/foreach}
        {foreach from=$discounts item=discount}
            <tr class="item" style="font-size:12px;">
                <td>{$discount.name|escape:'htmlall':'UTF-8'}</td>
                <td>{l s='Voucher:'} {$discount.name|escape:'htmlall':'UTF-8'}</td>
                <td><span class="order_qte_span editable">1</span></td>
                
                <td style="text-align:right;">{if $discount.value != 0.00}{l s='-'}{/if}{convertPriceWithCurrency price=$discount.value currency=$currency convert=0}</td>
                {if $return_allowed}
                <td>&nbsp;</td>
                {/if}
            </tr>
        {/foreach}
        </tbody>
    </table>
    </div>
</div>
<br />

{if !$is_guest}
    {if $return_allowed}
    <p class="bold">{l s='Merchandise return'}</p>
    <p>{l s='If you wish to return one or more products, please mark the corresponding boxes and provide an explanation for the return. Then click the button below.'}</p>
    <p class="textarea">
        <textarea cols="67" rows="3" name="returnText"></textarea>
    </p>
    <p class="submit">
        <input type="submit" value="{l s='Make a RMA slip'}" name="submitReturnMerchandise" class="button_large" />
        <input type="hidden" class="hidden" value="{$order->id|intval}" name="id_order" />
    </p>
    <br />
    {/if}
    </form>
</div>
{* remove message block
{if count($messages)}
    
<div class="table_block" style="width:600px; float:left;">
    <p class="bold" >{l s='Messages'}</p>
    <div style="border-top:1px solid #cacaca;">
        <table class="detail_step_by_step std">
            <thead>
                <tr>
                    <th class="first_item" style="width:150px;text-align:left;">{l s='From'}</th>
                    <th class="last_item" style="text-align:left;">{l s='Message'}</th>
                </tr>
            </thead>
            <tbody>
            {foreach from=$messages item=message name="messageList"}
                <tr class="{if $smarty.foreach.messageList.first}first_item{elseif $smarty.foreach.messageList.last}last_item{/if} {if $smarty.foreach.messageList.index % 2}alternate_item{else}item{/if}">
                    <td>
                        {if isset($message.ename) && $message.ename}
                            {$message.efirstname|escape:'htmlall':'UTF-8'} {$message.elastname|escape:'htmlall':'UTF-8'}
                        {elseif $message.clastname}
                            {$message.cfirstname|escape:'htmlall':'UTF-8'} {$message.clastname|escape:'htmlall':'UTF-8'}
                        {else}
                            <b>{$shop_name|escape:'htmlall':'UTF-8'}</b>
                        {/if}
                        <br />
                        {dateFormat date=$message.date_add full=1}
                    </td>
                    <td>{$message.message|nl2br}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
        </div>
    </div>
    {/if}

    {if isset($errors) && $errors}
        <div class="error">
            <p>{if $errors|@count > 1}{l s='There are'}{else}{l s='There is'}{/if} {$errors|@count} {if $errors|@count > 1}{l s='errors'}{else}{l s='error'}{/if} :</p>
            <ol>
            {foreach from=$errors key=k item=error}
                <li>{$error}</li>
            {/foreach}
            </ol>
        </div>
    {/if}
    <form action="{$link->getPageLink('order-detail.php', true)}" method="post" class="std" id="sendOrderMessage">
        <p class="bold">{l s='Add a message:'}</p>
        <p>{l s='If you would like to add a comment about your order, please write it below.'}</p>
        <p class="textarea">
            <textarea cols="54" rows="3" name="msgText"></textarea>
        </p>
        <p class="submit" style="padding-left:0;">
            <input type="hidden" name="id_order" value="{$order->id|intval}" />
            <input type="submit" class="button" name="submitMessage" value="{l s='Send'}"/>
        </p>
    </form>
*}
{else}
<p><img src="{$img_dir}icon/infos.gif" alt="" class="icon" />&nbsp;{l s='You can\'t make a merchandise return with a guest account'}</p>
{/if}
