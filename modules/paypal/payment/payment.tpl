{*if $cookie->id_currency == 2*}
<p class="payment_module" height="">
	
	<input type="radio" name="payMethod" value="PayPal" style="margin-left:30px;font-size:15px;" checked/>
	PayPal and Credit/Debit Cards
	<span style="width:200px; display:inline-block;vertical-align:middle">
    	<img src="http://www.indusdiva.com/img/card-types.jpg" alt="card-types" style="vertical-align:middle"/>
    </span>
	<form id="paypal_form" action="{$base_dir_ssl}modules/paypal/payment/submit.php" method="post">
    	{if isset($ppToken)}<input type="hidden" name="token" value="{$ppToken|escape:'htmlall'|stripslashes}" />{/if}
    	{if isset($payerID)}<input type="hidden" name="payerID" value="{$payerID|escape:'htmlall'|stripslashes}" />{/if}
    	<input type="hidden" name="currency_payement" value="{$currency.id_currency}" />
    	<input type="hidden" name="submitPayment" value="Pay with PayPal or Credit Card" />
    	
	</form>
	<a id="paypal_link" href="{$base_dir_ssl}modules/paypal/payment/submit.php" title="{l s='Pay with PayPal' mod='paypal'}" style="display:none">
			<img src="{$logo}" alt="{l s='Pay with PayPal' mod='paypal'}" style="float:left;" />
	</a>
</p>
{*/if*}