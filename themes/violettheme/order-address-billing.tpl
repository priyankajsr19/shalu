<script type="text/javascript">
// <![CDATA[
idSelectedCountry = {if isset($smarty.post.id_country)}{$smarty.post.id_country|intval}{else}{if isset($address->id_country)}{$address->id_country|intval}{else}false{/if}{/if};
countries = new Array();
countriesNeedIDNumber = new Array();
countriesNeedZipCode = new Array();
{foreach from=$countries item='country'}
	{if isset($country.states) && $country.contains_states}
		countries[{$country.id_country|intval}] = new Array();
		{foreach from=$country.states item='state' name='states'}
			countries[{$country.id_country|intval}].push({ldelim}'id' : '{$state.id_state}', 'name' : '{$state.name|escape:'htmlall':'UTF-8'}'{rdelim});
		{/foreach}
	{/if}
	{if $country.need_identification_number}
		countriesNeedIDNumber.push({$country.id_country|intval});
	{/if}
	{if isset($country.need_zip_code)}
		countriesNeedZipCode[{$country.id_country|intval}] = {$country.need_zip_code};
	{/if}
{/foreach}
$(function(){ldelim}
	$('.id_state option[value={if isset($smarty.post.id_state)}{$smarty.post.id_state}{else}{if isset($address->id_state)}{$address->id_state|escape:'htmlall':'UTF-8'}{/if}{/if}]').attr('selected', 'selected');
{rdelim});

{if isset($id_address) && isset($selected_country)}
var selectedCountry = {if isset($selected_country)}{$selected_country}{else}false{/if};
{else}
var selectedCountry = idSelectedCountry;
{/if}
{if isset($id_address) && isset($selected_state) && $selected_state}
var selectedState = {$selected_state};
{else}
var selectedState = false;
{/if}
$(document).ready(function(){ldelim}
	if(selectedCountry)
	{
		$('#id_country').val(selectedCountry);
		updateState();
		updateNeedIDNumber();
		updateZipCode();
	}
	if(selectedState)
	{
		$('.id_state').show();
		$('#id_state').val(selectedState);
	}
{rdelim});

{literal}
	$(document).ready(function() {
		// add the rule here
		 $.validator.addMethod("valueNotEquals", function(value, element, arg){
		  return arg != value;
		 }, "Value must not equal arg.");
		 
		$('#form_new_address').submit(function(e){
			var container = $('#error_container');
			// validate the form when it is submitted
			var validator = $("#form_new_address").validate({
				errorContainer: container,
				errorLabelContainer: $("ol", container),
				wrapper: 'li',
				meta: "validate",
				rules: {
					phone_mobile: {
					      required: {depends:function(){$(this).val($.trim($(this).val()));return true;} }
					},
					postcode: {
					      required: {depends:function(){$(this).val($.trim($(this).val()));return true;} }
					},
					id_country: { valueNotEquals: "0" }
				}
			});
			if(!validator.form())
				e.preventDefault();
			
		});
	});
	(function($){
	    $(function(){
	      $('#id_country').selectToAutocomplete();
	    });
	  })(jQuery);
{/literal}
//]]>
</script>

<div id="co_content">
	<div id="co_left_column">
		<div>
			{assign var='current_step' value='billing'}
			{include file="$tpl_dir./order-steps.tpl"}
		</div>
		{include file="$tpl_dir./errors.tpl"}
		
		<div style="width:210px; float:right;"></div>
		<div id="new_address" class="new_address" >
			<div id="new_address_form" style="display:{if (isset($addresses) AND $addresses|@count > 0) AND !((isset($errors) && $errors) || (isset($id_address) && $id_address))}none{else}block{/if};width:650px;margin:auto;">
				<div id="error_container" class="error_container">
				<h4>There are errors:</h4>
				<ol>
					<li><label for="firstname" class="error">Please enter your first name</label></li>
					<li><label for="lastname" class="error">Please enter your last name</label></li>
			
					<li><label for="address1" class="error">Please enter your address</label></li>
					<li><label for="postcode" class="error">Please enter a valid POST/ZIP code</label></li>
					<li><label for="city" class="error">Please enter your city</label></li>
					<li><label for="phone_mobile" class="error">Please enter your phone number (10 digits numeric)</label></li>
					<li><label for="id_country" class="error">Please select your country</label></li>
				</ol>
			</div>
				<form id="form_new_address" action="{$base_dir_ssl}order.php" method="post" class="std">
					<fieldset>
						<h1 style="padding:10px 0; text-align:center;border-bottom:1px dashed #cacaca">Billing Address</h1>
						<div style="padding: 10px 0;text-align:center">
							<span style="display:block">Enter the billing address as it appears on you Credit Card statement</span>
						</div>
						<p class="required text">
						<input type="hidden" name="token" value="{$token}" />
						<input type="hidden" name="id_carrier" value="{$id_carrier}" />
							<label for="firstname">{l s='First name'}</label>
							<input class="text required" type="text" name="firstname" id="firstname" value="{if isset($smarty.post.firstname)}{$smarty.post.firstname}{else}{$address->firstname|escape:'htmlall':'UTF-8'}{/if}" />
							<sup>*</sup>
						</p>
						<p class="required text">
							<label for="lastname">{l s='Last name'}</label>
							<input class="text required" type="text" id="lastname" name="lastname" value="{if isset($smarty.post.lastname)}{$smarty.post.lastname}{else}{$address->lastname|escape:'htmlall':'UTF-8'}{/if}" />
							<sup>*</sup>
						</p>
						<p class="required text">
							<label for="address1">{l s='Address'}</label>
							<textarea class="text required" rows="4" type="text" id="address1" name="address1" value="{if isset($smarty.post.address1)}{$smarty.post.address1}{else}{$address->address1|escape:'htmlall':'UTF-8'}{/if}">{if isset($smarty.post.address1)}{$smarty.post.address1}{else}{$address->address1|escape:'htmlall':'UTF-8'}{/if}</textarea>
							<sup>*</sup>
						</p>
						{*<p class="required text">
							<label for="address2">{l s='Address (2)'}</label>
							<input class="text" type="text" id="address2" name="address2" value="{if isset($smarty.post.address2)}{$smarty.post.address2}{else}{$address->address2|escape:'htmlall':'UTF-8'}{/if}" />
						</p>*}
						<p class="required text">
							<label for="city">{l s='City'}</label>
							<input class="text required" type="text" name="city" id="city" value="{if isset($smarty.post.city)}{$smarty.post.city}{else}{$address->city|escape:'htmlall':'UTF-8'}{/if}" maxlength="64" />
							<sup>*</sup>
						</p>
						<p class="required text">
							<label for="postcode">{l s='Post/Zip code'}</label>
							<input class="text required" type="text" id="postcode" name="postcode" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{else}{$address->postcode|escape:'htmlall':'UTF-8'}{/if}" />
							<sup>*</sup>
						</p>
						<div class="required text">
							<label for="id_country">{l s='Country'}</label>
							<select name="id_country" id="id_country" autofocus="autofocus" autocorrect="off" autocomplete="off" class="id_country">
							    <option value="0" selected="selected"></option>
								{foreach from=$country_names item=country}
									<option value="{$country.id_country}" data-alternative-spellings="{$country.alternate_name}" data-relevancy-booster="{$country.boost}">{$country.country}</option>
								{/foreach}
							</select>
						</div>
						<p class="required id_state select">
							<label for="id_state">{l s='State'}<sup>*</sup></label>
							<select name="id_state" id="id_state">
								<option value="">-</option>
							</select>
						</p>
						<p class="required text">
							<label for="phone_mobile">{l s='Phone'}</label>
							<input class="text required" type="text" id="phone_mobile" name="phone_mobile" value="{if isset($smarty.post.phone_mobile)}{$smarty.post.phone_mobile}{else}{$address->phone_mobile|escape:'htmlall':'UTF-8'}{/if}" />
							<sup>*</sup>
						</p>
						<p class="required text" id="adress_alias" style="display:none;">
							<label for="alias" >{l s='Address book title'}</label>
							<input class="text" type="text" id="alias" name="alias" value="{if isset($smarty.post.alias)}{$smarty.post.alias}{elseif $address->alias}{$address->alias|escape:'htmlall':'UTF-8'}{elseif isset($select_address)}{else}{l s='Address'}{$addresses|@count + 1}{/if}" />
							<sup>*</sup>
						</p>
						<p class="required" id="required_desc2" ><span style="width:30%;text-align:right;"><sup>*</sup>{l s='Required field'}</span></p>
					</fieldset>
					
					<p class="submit2" style="padding-left:0px">
					<input type="hidden" class="hidden" name="step" value="3" />
						{if isset($mod)}<input type="hidden" name="mod" value="{$mod}" />{/if}
						<input type="hidden" name="order_add_address_billing" value="1" />
						<input type="hidden" name="id_carrier" value="{$id_carrier}" />
						<input type="hidden" name="id_address" id="id_address" value="{$id_address}" />
						<input style="margin:0px 30px;float:right" type="submit" name="submitAddress" id="submitAddress" value="{l s='Save and Continue >>'}" class="button" />
						{if (isset($addresses) AND $addresses|@count > 0) AND !(isset($errors) && $errors)}<input style="margin:0px 30px;float:right;width:180px;" type="button" class="button_secondary" id="closeAddressBtn" value="{l s='<< Choose from existing'}" class="button" />{/if}
						
					</p>
				
				</form>
				<div style="padding-top:30px;"></div>
			</div>
			
		</div>
		{if (isset($addresses) AND $addresses|@count > 0) AND !(isset($errors) && $errors)}
			<div id="add_button_wrapper" style="width:100%">
				<span class="prev_shipaddress_label" style="display:block;padding:5px 10px;font-size:15px;{if isset($id_address) && $id_address}display:none{/if}">Please choose a billing address or enter a new address.</span>
				<span class="prev_shipaddress_label" style="padding-left:10px;{if isset($id_address) && $id_address}display:none{/if}">This should be as it appears on you Credit Card statement.</span> 
				{literal}
					<script>
					// <![CDATA[
						
						$(document).ready(function()
						{
							$('#new_address_card').click(function () {
								if ($("#new_address_form").is(":hidden")) {
									$("#address_wrapper").hide();
									$("#new_address_form").slideDown("slow");
									$(':text, textarea','#form_new_address').not(':button, :submit, :reset, :hidden').val('');
									$('#new_address_card').hide();
									$('.prev_shipaddress_label').hide();
								} else {
									$("#new_address_form").hide();
								}
							});
							$('#closeAddressBtn').click(function () {
									$("#new_address_form").slideUp();
									$("#address_wrapper").show();
									$('#new_address_card').show();
									$('.prev_shipaddress_label').show();
									$('.address_card').show();
							});

							$('.select_address_link').click(function(e){
								e.preventDefault();
								$('#selected_billing_address').val($(this).attr('rel'));
								$('#saved_addresses_form').submit();
							});
						});
						//]]
					</script>
				{/literal}
			</div>
		{/if}	
		<form action="{$link->getPageLink('order.php', true)}" method="post" id="saved_addresses_form">
				{if isset($addresses) AND $addresses|@count > 0}
					<div id="address_wrapper">
						<div id="new_address_card" class="new_address_card" style="cursor:pointer;display:{if ((isset($errors) && $errors) || (isset($id_address) && $id_address))}none{/if}">
							<span class="new_address_title">Add a billing address</span>
						</div>
						{foreach from=$addresses key=k item=address}
						<div id="address_link_{$address.id_address|intval}" rel="{$address.id_address|intval}" class="selectable address_card" style="{if isset($id_address) && $id_address && $id_address == $address.id_address}display:none{/if}">
							<div class="address_title underline" style="padding:3px 15px;display:block;">
							<span style="font-size:12px;"><a class="address_update" href="{$base_dir_ssl}order.php?step=2&id_address={$address.id_address|intval}" title="{l s='Update'}" rel="address_link_{$address.id_address|intval}">[{l s='Update'}]</a></span>
							</div>
							<a rel="{$address.id_address|intval}" class="select_address_link">
								<ul class="address item" id="address_{$address.id_address|intval}">
									<li style="display:none">{$address.alias|addslashes}</li>
									<li class="address_name">{$address.firstname|addslashes} {$address.lastname|addslashes}</li>
									<li class="first_name" style="display:none">{$address.firstname|addslashes}</li>
									<li class="last_name" style="display:none">{$address.lastname|addslashes}</li>
									<li class="address_address1">{$address.address1|addslashes}</li>
									<li class="address_city">{$address.city|addslashes}</li>
									{if $address.state != ''}
									<li class="address_state">{$address.state|addslashes}</li>
									{/if}
									<li class="address_pincode">{$address.postcode|addslashes}</li>
									<li class="address_country">{$address.country|addslashes}</li>
									<li class="address_phone">Phone: {$address.phone_mobile|addslashes}</li>
									
								</ul>
								<span class="clicktoship">Click to select</span>
							</a>
						</div>
						{/foreach}
				</div>
				{/if}
		<br class="clear" />
	
		<div style="width:700px;margin:auto;">	
			<p class="cart_navigation submit">
				<input type="hidden" class="hidden" name="step" value="3" />
				<input type="hidden" name="id_carrier" value="{$id_carrier}" />
				<input type="hidden" class="hidden" name="id_address_invoice" value="" id="selected_billing_address"/>
				<input type="hidden" name="back" value="{$back}" />
			</p>
		</div>
		</form>
	</div>
	{*<div id="co_rht_col">
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
	   				<td class="row_val"><span style="font-weight:bold">{displayPrice price=$total_price}</span></td>
	   			</tr>
	   			{/if}
			</tbody></table>
	   		</div>
	   	</div>
	   	
	</div>*}
</div>
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
paramList['lead_step'] = 'BillingAddressPage';
</script>
<script type="text/javascript">
    try { sokrati.trackSaleParams("0","0","{$total_price}", "{$productNumber}",paramList); }
    catch(err) { }
</script>
