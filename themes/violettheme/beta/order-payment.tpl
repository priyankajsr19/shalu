
<script>
var youPayCOD = {$total_price};
{if isset($op) && $op > 0}
var payDefault = 'online';
{else}
var payDefault = 'cod';
{/if}
</script>

{literal}
<script>
	$(document).ready(function()
	{
		$('#select_pay_button').click(function () {
			var selectedMethod =  $("input:checked").val();
			//alert(selectedMethod);
			if(selectedMethod == "ONLINE")
				$('#EBS_form').submit();
			else
				window.location = $('#codLink').attr('href');

		});
		
		var $radios = $('input:radio[name=payMethod]');
	    if($radios.is(':checked') === false) {
	    	if(payDefault == 'cod')
	        $radios.filter('[value=COD]').attr('checked', true);
	    }

	});
	
</script>
{/literal}
<div id="co_content">
	<div id="co_left_column">
		{if !$opc}
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
		
		{/if}
		
		
		
		{if !$opc}
			{assign var='current_step' value='payment'}
			{include file="$tpl_dir./order-steps.tpl"}
		
			{include file="$tpl_dir./errors.tpl"}
		{else}
			<div id="opc_payment_methods" class="opc-main-block">
				<div id="opc_payment_methods-overlay" class="opc-overlay" style="display: none;"></div>
		{/if}
		{*<div style="border:1px solid #cacaca;padding:10px;background: #BBCB9A">
			<span style="font-weight:bold; font-size:13px;">Save additional Rs. 20 on this order, pay online.</span>
		</div>*}
		{if !$opc}<h1>{l s='Choose your payment method'}</h1>{else}<h2>3. {l s='Choose your payment method'}</h2>{/if}
		
		<div id="HOOK_TOP_PAYMENT">{$HOOK_TOP_PAYMENT}</div>
		
		{if $HOOK_PAYMENT}
			{if $opc}<div id="opc_payment_methods-content">{/if}
				<div id="HOOK_PAYMENT">{$HOOK_PAYMENT}</div>
			{if $opc}</div>{/if}
		{else}
			<p class="warning">{l s='No payment modules have been installed.'}</p>
		{/if}
		
		{if !$opc}
		
			<p class="cart_navigation">
				<input type="button" style="margin:0px 60px 10px 0px;" id="select_pay_button" class="exclusive_large" value="Continue Payment >>"></input>
				
			</p>
		
		{else}
			</div>
		{/if}
	</div>
	<div id="co_rht_col">
	<div class="co_rht_box" style="padding-bottom:10px;">
		<div class="rht_box_heading">
			YOU PAY
		</div>
		<div id="youpay" class="rht_box_info" style="text-align: center;font-size:36px;">
			<span id="youpay-total">{displayPrice price=$total_price}</span>
		</div>
	</div>
		<div class="co_rht_box">
	   		<div id="order_summary_title" class="rht_box_heading">Order Summary</div>
	   		<div id="order_summary_content" class="rht_box_info" style="padding-left:30px;">
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
	   				<td class="row_title">Shipping</td>
	   				<td>:</td>
	   				{if $shippingCost > 0}
	   					<td class="row_val">{displayPrice price=$shippingCost}</td>
	   				{else}
	   					<td class="row_val"><span style="padding:0px;"> FREE</span></td>
	   				{/if}
	   			</tr>
	   			<tr><td height="5px" colspan="2"></td></tr>
	   			<tr>
	   				<td class="row_title"><span style="font-weight:bold">Order Total</span></td>
	   				<td>:</td>
	   				<td class="row_val"><span id="order-total" style="font-weight:bold">{displayPrice price=$total_price}</span></td>
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

