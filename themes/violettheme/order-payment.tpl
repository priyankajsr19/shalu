
<script>
var youPayDefault = {$total_price};

</script>

{literal}
<script>
	$(document).ready(function()
	{
		var buildUrl = function(url, key, value) {
			var params = '';
			if( url.split("?")[1] != undefined)
    				params = url.split("?")[1].split("&");
			var newparams = [];
			if( Object.prototype.toString.call( params ) === '[object Array]' && params[0] != '') {
				var found = false;
				for(i=0;i<params.length;i++) {
					var param = params[i];
					var kv = param.split('=');
					if( kv[0] != key ) {
						var newkv = kv.join('=');
						newparams.push(newkv);
					} else {
						found = true;
						newparams.push(key+"="+value);
					}
				}
				if( !found ) {
					newparams.push(key+"="+value);
				}
				newparams = newparams.join("&");
			} else {
				newparams.push(key+"="+value);
			}
			var url = window.location.protocol + "//" + document.location.host + document.location.pathname + "?" + newparams;
			return url;
		}

		$("#donation").click(function(){
			var url = buildUrl(window.location.href,"step",3);
			if($(this).is(':checked'))
				window.location.href = buildUrl(url,"donate","yes");
			else
				window.location.href = buildUrl(url, "donate","no");
		});
		$("#donate_btn").click(function(){
			var amount = parseInt($("#donation_amount").val());
			if( isNaN(amount) || amount < 1) {
				alert("Minimum value needed for donation is atleast 1");
				return false;
			}
			var url = buildUrl(window.location.href,"step",3);
			window.location.href = buildUrl(url,"donate_amt",amount);
		});
		$('#select_pay_button').click(function () {
			var selectedMethod =  $("input[name=payMethod]:checked").val();
			if(selectedMethod == "EBS")
				$('#EBS_form').submit();
			else if(selectedMethod == "PayPal")
				$('#paypal_form').submit();
			else if(selectedMethod == "payu")
				$('#payu_form').submit();
			else if(selectedMethod == "twoco")
				$('#twoco-form').submit();
			else if(selectedMethod == "mb")
				$('#mb-form').submit();
			else if(selectedMethod == "wire")
			{
				window.location = $('#wire-transfer-link').attr('href');
			}
		});
	});
	
</script>
{/literal}
<div id="co_content">
	<div id="co_left_column">
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
		{assign var='current_step' value='payment'}
		{include file="$tpl_dir./order-steps.tpl"}
		{include file="$tpl_dir./errors.tpl"}
		
		<div id="payment_confirm" style="margin:20px 160px;float:left">
			<h1 style="border-bottom:1px dashed #cacaca;padding:10px;text-align:center">Order Summary</h1>
	   		<div id="order_summary" style="float:left;padding:0 0 0px 0;width:650px;border-bottom:1px dashed #cacaca;">
	   		<div id="order_summary_content" class="rht_box_info" style="padding:20px 30px;float:left">
		   		<table width="173" style="width:173px">
 		   			<tbody>
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
						{if $donation_amount > 0}
						<tr>
							<td class="row_title" style="color:#a43a21; font-weight:bold">Donation</td>
							<td>:</td>
							<td class="row_val">{displayPrice price=$donation_amount}</td>
						</tr>
						{/if}
			   			<tr>
							<td class="row_title">Discounts</td>
							<td>:</td>
							<td class="row_val"><span class="ajax_cart_discounts">{displayPrice price=$total_discounts}</span></td>
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
			   			<tr><td height="5px" colspan="3"></td></tr>
			   			<tr>
			   				<td class="row_title"><span style="font-weight:bold">Order Total</span></td>
			   				<td>:</td>
			   				<td class="row_val"><span id="order-total" style="font-weight:bold">{displayPrice price=$total_price}</span></td>
			   			</tr>
			   			<tr><td height="25px" colspan="3"></td></tr>				
						<tr>
							<td colspan="3">
								<a href="./help-an-orphan" target="__blank"><img src="{{$img_ps_dir}}giftco.jpg"/></a>
								
								<div class="clearfix">
									{if $donate eq "yes"}
										<input type="checkbox" value="yes" checked="checked" id="donation" name="donation">Help The Kids at Sneha Nilaya. Add More or Opt Out</input>
									{else}
										<input type="checkbox" value="no"  id="donation" name="donation">Help The Kids at Sneha Nilaya. Add More or Opt Out</input>
									{/if}
								</div>
								{if $donate eq "yes"}
								<div class="clearfix" style="margin-top:4px">
									<input align="center" style="text-align:center;font-size:12px; width:50px;height:29px; float:left" type="text" id="donation_amount" name="donation_amount" value="{{$donation_amount}}"/>
									<span style="padding-top:15px;float:left;font-size:12px; display:inline-block; width:30px; text-align:right">{{$mycurr->iso_code}}</span>
									<input type="button" id="donate_btn" class="exclusive_large" value="Donate" style="float:right;width:70px;background-color:#a43a21"></input>
								</div>
								{/if}
							</td>
						</tr>
			   			{/if}
					</tbody>
				</table>
	   		</div>
	   		{if $delivery}
		   	<div class="co_rht_box">
		   		<div id="cop_delivery_address" class="address_card_selected">
		   			<div class="address_title underline" style="padding:3px 15px;display:block;">
						Delivery Address
					</div>
						<ul class="address item">
							<li class="address_name">{$delivery->firstname|addslashes} {$delivery->lastname|addslashes}</li>
							<li class="address_address1">{$delivery->address1|addslashes}</li>
							<li class="address_city">{$delivery->city|addslashes}</li>
							{if isset($delivery->state)}
							    <li class="address_pincode">{$delivery->state|addslashes}</li>
							{/if}
							<li class="address_pincode">{$delivery->postcode|addslashes}</li>
							<li class="address_pincode">{$delivery->country|addslashes}</li>
							
							<li class="address_country">Phone: {$delivery->phone_mobile|addslashes}</li>
						</ul>
						<span class="updateaddress"><a class="address_update" href="{$base_dir_ssl}order.php?step=1&id_address={$delivery->id|intval}" title="{l s='Update'}" >{l s='Update'}</a></span>
				</div>
		   	</div>
		   	{/if}
		   	{if $invoice}
		   	<div class="co_rht_box">
		   		<div id="cop_delivery_address" class="address_card_selected">
		   			<div class="address_title underline" style="padding:3px 15px;display:block;">
						Billing Address
					</div>
						<ul class="address item">
							<li class="address_name">{$invoice->firstname|addslashes} {$invoice->lastname|addslashes}</li>
							<li class="address_address1">{$invoice->address1|addslashes}</li>
							<li class="address_city">{$invoice->city|addslashes}</li>
							{if isset($invoice->state)}
							    <li class="address_pincode">{$invoice->state|addslashes}</li>
							{/if}
							<li class="address_pincode">{$invoice->postcode|addslashes}</li>
							<li class="address_pincode">{$invoice->country|addslashes}</li>
							
							<li class="address_country">Phone: {$invoice->phone_mobile|addslashes}</li>
						</ul>
						<span class="updateaddress"><a class="address_update" href="{$base_dir_ssl}order.php?step=2&id_address={$invoice->id|intval}" title="{l s='Update'}" >{l s='Update'}</a></span>
				</div>
		   	</div>
		   	{/if}
                        {if isset($curr_conversion_msg) && !empty($curr_conversion_msg)}
                            <div class="curr_conversion_msg">
                                {*<div class="heading">Alert !! Currency Conversion</div>*}
                                <div class="message">{$curr_conversion_msg}</div>
                            </div>
                        {/if}
		   	</div>
		   	<div style="border-bottom:1px dashed #cacaca;clear:both;padding:10px 0">
		   		{if isset($special_instructions)}
		   		<div>
		   			<p style="font-family:Abel; font-size:15px">
   						<b>Special Instructions</b>
   					</p>
   					<p style="font-style:italic; color:#939393">
						{if isset($special_instructions)}{$special_instructions|escape:'htmlall':'UTF-8'}{/if}
   						<a class="add_instructions" class="span_link" style="padding:0px 10px;color:green" href="#special-instructions-popup" rel="nofollow">[EDIT INSTRUCTIONS]</a>
   					</p>
   					
   				</div>
   				{else}
   					<p>
   						No special instructions.
   						<a class="add_instructions button" style="display:inline-block" href="#special-instructions-popup" rel="nofollow">+ ADD INSTRUCTIONS</a>
   					</p>
   				{/if}
		   	</div>
		   	<div id="HOOK_PAYMENT" style="float:left;padding-top:10px;">
		   		<p style="font-family:Abel; font-size:15px"><b>Select method of payment</b></p>
				{$HOOK_PAYMENT}
			</div>
		   	<p class="cart_navigation" style="clear:both;border-top:1px dashed #cacaca;padding-top:20px;width:100%;float:left;" id="continue_btn">
				<input type="button" style="margin:0px 60px 10px 0px;" id="select_pay_button" class="exclusive_large" value="Continue Payment >>"></input>
			</p>
	   	</div>
			
		</div>
	</div>
	
</div>

<div id="special-instructions-popup" style="border:1px dashed #cacaca;padding:10px;width:500px;display:none">
   	<form action="{$base_dir_ssl}order.php?step=3" method="post" id="special_istructions_form" >
   		<p style="font-size:18px;font-family:Abel;padding:10px 0px;">SPECIAL INSTRUCTIONS FOR YOUR ORDER</p>
   		<p id="instructions_panel">
   			<textarea value="{if isset($special_instructions)}{$special_instructions|escape:'htmlall':'UTF-8'}{/if}" name="special_instructions" id="special_instructions" type="text" rows="4" class="text required" style="width:500px;font-size:13px">{if isset($special_instructions)}{$special_instructions|escape:'htmlall':'UTF-8'}{/if}</textarea>
   			<input type="submit" name="submit_instructions" id="submit_instructions" class="button" value="Save Instructions"></input>
   		</p>
   	</form>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$('.add_instructions').fancybox( {
		autoSize: true
	} );
} );
</script>
<script type="text/javascript">
    <!--
        _sokClient = '249';
    //-->
</script>
<script type="text/javascript">
    var sokhost = ("https:" == document.location.protocol) ? "https://tracking.sokrati.com" : "http://cdn.sokrati.com";
    var sokratiJS = sokhost + '/javascripts/tracker.js';
    document.write(unescape("%3Cscript src='" + sokratiJS + "' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var paramList = { };
paramList['lead_step'] = 'Payement_Page';
</script>
<script type="text/javascript">
    try { sokrati.trackSaleParams("0","0","{$total_price}", "{$productNumber}",paramList); }
    catch(err) { }
</script>

