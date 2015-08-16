{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if $nbProducts <= 0}
	<p class="warning">{l s='Your shopping cart is empty.'}</p>
{else}

<div id="co_content">
	<div id="co_left_column">
		<div id="payment_confirm" style="margin:20px 160px;float:left">
			<h1 style="border-bottom:1px dashed #cacaca;padding:10px;text-align:center">Bank Transfer Payment</h1>
			<form action="{$this_path_ssl}validation.php" method="post">
			<p>
				You have chosen to pay by wire transfer. Your order will be processed after the payment is completed.
				<br/><br />
			</p>
			<p>
				{if $currencies|@count > 1}
					<select id="currency_payement" name="currency_payement" onchange="setCurrency($('#currency_payement').val());" style="display:none">
						{foreach from=$currencies item=currency}
							<option value="{$currency.id_currency}" {if $currency.id_currency == $cust_currency}selected="selected"{/if}>{$currency.name}</option>
						{/foreach}
					</select>
				{else}
					{l s='We accept the following currency to be sent by bank wire:' mod='bankwire'}&nbsp;<b>{$currencies.0.name}</b>
					<input type="hidden" name="currency_payement" value="{$currencies.0.id_currency}" />
				{/if}
			</p>
			<table style="margin:0px 10px;width:90%; font-family:Verdana,sans-serif; font-size:11px; color:#374953;">
		<tr style="border-top:1px dashed #cacaca">
			<td style="border-top:1px dashed #cacaca; padding-top:10px">Order Amount</td>
			<td style="border-top:1px dashed #cacaca; padding-top:10px">{displayPrice price=$total}</td>
		</tr>
		<tr>
			<td>Bank Name</td>
			<td>HDFC Bank </td>
		</tr>
		<tr>
			<td>Account Name</td>
			<td>Zing Ecommerce Private Limited</td>
		</tr>
		<tr>
			<td>Account No</td>
			<td>00758630000251</td>
		</tr>
		<tr>
			<td>Branch Code</td>
			<td>0075</td>
		</tr>
		<tr>
			<td>Account Branch</td>
			<td>Airport Road Golden Tower, Kodihalli, Bangalore, Karnataka, INDIA</td>
		</tr>
		<tr>
			<td>IFSC code/ Sort Code</td>
			<td>HDFC0000075</td>
		</tr>
		<tr>
			<td style="border-bottom:1px dashed #cacaca; padding-bottom:10px">SWIFT Code</td>
			<td style="border-bottom:1px dashed #cacaca; padding-bottom:10px">HDFCINBB</td>
		</tr>
	</table>
			<p class="cart_navigation" style="padding:10px;">
				<a href="{$link->getPageLink('order.php', true)}?step=3" class="button_large hideOnSubmit">{l s='Other payment methods' mod='bankwire'}</a>
				<input type="submit" name="submit" value="Confirm Order" class="exclusive_large hideOnSubmit" />
			</p>
			</form>
		</div>
	</div>
</div>

{/if}
