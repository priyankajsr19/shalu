<div id="co_content">
	<div id="co_left_column">
		{assign var='current_step' value='payment'}
		{include file="$tpl_dir./order-steps.tpl"}
		
	   	<div id="payment_confirm" style="margin:20px 160px;padding:0 0 20px 0;width:650px;float:left">
	   			<h1 style="border-bottom:1px dashed #cacaca;padding:10px;text-align:center">Confirm Payment</h1>
				<form action="{$this_path_ssl}{$mode}submit.php" method="post">
					{if isset($ppToken)}<input type="hidden" name="token" value="{$ppToken|escape:'htmlall'|stripslashes}" />{/if}
					{if isset($payerID)}<input type="hidden" name="payerID" value="{$payerID|escape:'htmlall'|stripslashes}" />{/if}
					<p style="margin-top:20px;">
						- {l s='The total amount of your order is' mod='paypal'}
							<span id="amount_{$currency->id}" class="price">{convertPriceWithCurrency price=$total currency=$currency}</span> {if $use_taxes == 1}{l s='(tax incl.)' mod='paypal'}{/if}
					</p>
					<p>
						- {l s='We accept the following currency to be sent by PayPal: ' mod='paypal'}{$currency.name}</b>
							<input type="hidden" name="currency_payement" value="{$currency->id}" />
					</p>
					<p>
						{*<b>{l s='Please confirm your order by clicking \'I confirm my order\'' mod='paypal'}.</b>*}
					</p>
					<p class="cart_navigation" style="width:630px;float:left;border-top:1px dashed #cacaca;padding-top:20px;">
						{if isset($paypalError)}
							<a href="{$link->getPageLink('order.php', true)}?step=3" class="button_large">{l s='Return' mod='paypal'}</a><br /><br />
							<span style="color: red;">{l s='Session expired, please go back and try again' mod='paypal'}</span>
						{else}
							<a href="{$link->getPageLink('order.php', true)}?step=3" class="button_large">{l s='Other payment methods' mod='paypal'}</a>
							<input type="submit" name="submitPayment" value="{l s='Pay with PayPal' mod='paypal'}" class="exclusive_large" />
						{/if}
					</p>
				</form>
		</div>
	</div>
</div>