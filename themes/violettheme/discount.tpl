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
*  @version  Release: $Revision: 6599 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<script type="text/javascript">
//<![CDATA[
	var baseDir = '{$base_dir_ssl}';
//]]>
</script>

<div style="width:970px;">
        {assign var='selitem' value='vouchers'}
	{include file="$tpl_dir./myaccount_menu.tpl"}
	<div class="vtab-content">
		<div style="border: 1px solid #D0D3D8;box-shadow: 0 1px 3px 0 black;margin-bottom: 1em;padding-bottom: 1em;margin-top:15px;min-height:400px;float:left;width:100%">
		<h1 style="padding:10px 0;text-align:center;border-bottom:1px dashed #cacaca">Your Vouchers</h1>
		{if isset($discount) && count($discount) && $nbDiscounts}
		<table class="discount std">
			<thead>
				<tr>
					<th class="discount_code first_item">Code</th>
					<th class="discount_description item">Description</th>
					<th class="discount_quantity item">Quantity</th>
					<th class="discount_value item">Value</th>
					<th class="discount_minimum item">{l s='Minimum'}</th>			
					<th class="discount_expiration_date last_item">{l s='Expiration date'}</th>
				</tr>
			</thead>
			<tbody>
			{foreach from=$discount item=discountDetail name=myLoop}
				<tr class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if} {if $smarty.foreach.myLoop.index % 2}alternate_item{/if}">
					<td class="discount_code">{$discountDetail.name}</td>
					<td class="discount_description">{$discountDetail.description}</td>
					<td class="discount_quantity" style="text-align:center">{$discountDetail.quantity_for_user}</td>
					<td class="discount_value" style="text-align:center">
						{if $discountDetail.id_discount_type == 1 || $discountDetail.id_discount_type == 5}
							{$discountDetail.value|escape:'htmlall':'UTF-8'}%
						{elseif $discountDetail.id_discount_type == 2 || $discountDetail.id_discount_type == 4}
							{convertPrice price=$discountDetail.value}
						{else}
							{l s='Free shipping'}
						{/if}
					</td>
					<td class="discount_minimum" style="text-align:center">
						{if $discountDetail.minimal == 0}
							{l s='none'}
						{else}
							{convertPrice price=$discountDetail.minimal}
						{/if}
					</td>
					
					<td class="discount_expiration_date" style="text-align:center">{dateFormat date=$discountDetail.date_to}</td>
				</tr>
			{/foreach}
			</tbody>
		</table>
		<p>
			*{l s='Tax included'}
		</p>
		{else}
			 <p style="font-size:18px;text-align:center;color:#cacaca">You do not have any vouchers</p>
		{/if}
	</div>
	</div>
</div>