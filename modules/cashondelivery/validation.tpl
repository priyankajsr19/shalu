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
*  @version  Release: $Revision: 6594 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}


<div id="co_content">
	<div id="co_left_column">
		
		{assign var='current_step' value='payment'}
		{include file="$tpl_dir./order-steps.tpl"}
		
		<h2>{l s='Cash on delivery payment' mod='cashondelivery'}</h2>
		
		<form action="{$this_path_ssl}validation.php" method="post">
			<input type="hidden" name="confirm" value="1" />
			<input type="hidden" name="cid" value="{Tools::getValue('cid')}" />
			<p>
				{l s='You have chosen to pay by Cash on Delivery.' mod='cashondelivery'}
				<br/><br />
				{l s='The total amount payable for your order is' mod='cashondelivery'}
				<span id="amount_{$currencies.0.id_currency}" class="price" style="font-size:18px;">{convertPrice price=$total}.</span>
				Please confirm to proceed.
			</p>
			<p>
				<br /><br />
			</p>
			<div style="width:700px;margin:auto; padding-bottom:50px;">
				<p class="cart_navigation">
					{*<a href="{$link->getPageLink('order.php', true)}?step=2" class="button_large">{l s='<< Other payment methods' mod='cashondelivery'}</a>*}
					<input type="submit" name="submit" value="{l s='Confirm Order' mod='cashondelivery'}" class="exclusive_large" />
				</p>
			</div>
		</form>
	</div>
	<div id="co_rht_col">
		<div class="co_rht_box">
	   		<div id="order_summary_title" class="rht_box_heading">Order Summary</div>
	   		<div id="order_summary_content" class="rht_box_info">
	   		<table><tbody>
	   			{if $productNumber > 0}
	   			<tr>
	   				<td class="row_title">Total Items</td>
	   				<td>:</td>
	   				<td class="row_val">{$productNumber}</td>
	   			</tr>
	   			<tr>
	   				<td class="row_title">Items Total</td>
	   				<td>:</td>
	   				<td class="row_val">{displayPrice price=$total_products_wt}</td>
	   			</tr>
	   			<tr>
	   				<td class="row_title">COD Charges</td>
	   				<td>:</td>
	   				<td class="row_val">{displayPrice price=$codCharge}</td>
	   			</tr>
	   			<tr>
	   				<td class="row_title">Shipping</td>
	   				<td>:</td>
	   				{if $shippingCost > 0}
	   					<td class="row_val">{displayPrice price=$shippingCost}</td>
	   				{else}
	   					<td class="row_val"><span padding:0px;"> FREE</span></td>
	   				{/if}
	   			</tr>
	   			<tr><td height="5px" colspan="2"></td></tr>
	   			<tr>
	   				<td class="row_title"><span style="font-weight:bold">Order Total</span></td>
	   				<td>:</td>
	   				<td class="row_val"><span style="font-weight:bold">{displayPrice price=$total}</span></td>
	   			</tr>
	   			{/if}
			</tbody></table>
	   		</div>
	   	</div>
	   
	   	
	   	{if $delivery_address}
	   	<div class="co_rht_box">
	   		<div id="cop_delivery_address" class="address_card_selected">
	   			<div class="address_title underline" style="padding:3px 15px;display:block;">
					Delivery Address
				</div>
					<ul class="address item">
						<li class="address_name">{$delivery_address->firstname|addslashes} {$delivery_address->lastname|addslashes}</li>
						<li class="address_address1">{$delivery_address->address1|addslashes}</li>
						<li class="address_address2">{$delivery_address->state|addslashes}</li>
						<li class="address_city">{$delivery_address->city|addslashes}</li>
						<li class="address_pincode">{$delivery_address->postcode|addslashes}</li>
						<li class="address_country">Phone: {$delivery_address->phone_mobile|addslashes}</li>
					</ul>
					<span class="updateaddress"><a class="address_update" href="{$base_dir_ssl}order.php?step=1&id_address={$delivery_address->id|intval}" title="{l s='Update'}" >{l s='Update'}</a></span>
			</div>
	   	</div>
	   	{/if}
	</div>
</div>
		