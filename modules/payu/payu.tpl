<p id="pay-payu" class="payment_module" {if $cookie->id_currency == 4}checked{/if}>
    <input type="radio" name="payMethod" value="payu" style="margin-left:30px;font-size:15px;"/>
    Credit Card/ Debit Card/ NetBanking
    <span style="width:100px; display:inline-block;vertical-align:middle;overflow:hidden">
    	<img src="http://www.indusdiva.com/img/card-types.jpg" alt="card-types" style="vertical-align:middle"/>
    </span>
</p>
<form action="{$action}" method="post" id="payu_form" name="payu_form" >
	<input type="hidden" name="key" value="{$key}" />
	<input type="hidden" name="txnid" value="{$txnid}" />
	<input type="hidden" name="amount" value="{$amount}" />
	<input type="hidden" name="productinfo" value="{$productinfo}" />
	<input type="hidden" name="firstname" value="{$firstname}" />
	<input type="hidden" name="Lastname" value="{$Lastname}" />
	<input type="hidden" name="address1" value="{$deliveryAddress->address1}" />
	<input type="hidden" name="city" value="{$deliveryAddress->city}" />
	<input type="hidden" name="state" value="{$deliveryAddress->state}" />
	<input type="hidden" name="country" value="{$deliveryAddress->country}" />
	<input type="hidden" name="Zipcode" value="{$Zipcode}" />
	<input type="hidden" name="email" value="{$email}" />
	<input type="hidden" name="phone" value="{$phone}" />
	<input type="hidden" name="surl" value="{$surl}" />
	<input type="hidden" name="Furl" value="{$Furl}" />
	<input type="hidden" name="curl" value="{$curl}" />
	<input type="hidden" name="Hash" value="{$Hash}" />
	<input type="hidden" name="Pg" value="{$Pg}" />
</form>	