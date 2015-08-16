{if isset($op) && $op != 0}
<div id="pay-online" class="payment_module">
	<input type="radio" name="payMethod" value="ONLINE" style="margin-left:30px;font-size:15px;" {if isset($cod) && $cod == 0}checked{/if}/> 
	Secure online payment <span style="color:#EE8C3B; font-weight:bold">(+100 Bonus Violet Coins!)</span>
	{*<p >
		<a href="javascript:$('#EBS_form').submit();" title="{l s='Pay online' mod='EBS'}">
			<img src="{$module_dir}payment.jpeg" alt="{l s='Pay online.' mod='EBS'}" />
			{l s='Pay online over secure connection.' mod='EBS'}
		</a>
	</p>*}
</div>

<form action="{$EBSUrl}" method="post" id="EBS_form" class="hidden">
	<input type="hidden" name="account_id" value="{$account_id}" />
	<input type="hidden" name="reference_no" value="{$cartID}" />
	<input name="amount" type="hidden" value="{$total}" />
	<input name="description" type="hidden" value="Test Order Description" />
	<input name="name" type="hidden" value="{$address->firstname}" />
    <input name="address" type="hidden" value="{$address->address1}" />
	<input name="city" type="hidden" value="{$address->city}" />
	<input name="state" type="hidden" value="{$state}" />
	<input name="postal_code" type="hidden" value="{$address->postcode}" />
	<input name="country" type="hidden" value="{$country->iso_code}" />
	<input name="email" type="hidden" value="{$customer->email}" />
	<input name="phone" type="hidden" value="{$address->phone_mobile}" />
	<input name="ship_name" type="hidden" value="{$address->firstname}" />
	<input name="ship_address" type="hidden" value="{$address->address1}" />
	<input name="ship_city" type="hidden" value="{$address->city}" />
	<input name="ship_state" type="hidden" value="{$state}" />
	<input name="ship_postal_code" type="hidden" value="{$address->postcode}" />
	<input name="ship_country" type="hidden" value="{$country->iso_code}" />
	<input name="ship_phone" type="hidden" value="{$address->phone_mobile}" />
	<input name="return_url" type="hidden" size="60" value="{$return_url}" />
	<input name="mode" type="hidden" size="60" value="{$mode}" />
	<input name="secure_hash" type="hidden" value="{$secure_hash}" />
</form>
{/if}