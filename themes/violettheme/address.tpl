
<script type="text/javascript">
// <![CDATA[
	var baseDir = '{$base_dir_ssl}';
//]]>
</script>

<script type="text/javascript">
// <![CDATA[
idSelectedCountry = {if isset($smarty.post.id_country)}{$smarty.post.id_country|intval}{else}{if isset($address->id_country)}{$address->id_country|intval}{else}false{/if}{/if};
idSelectedState = {if isset($smarty.post.id_state)}{$smarty.post.id_state|intval}{else}{if isset($address->id_state)}{$address->id_state|intval}{else}false{/if}{/if};
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
{if isset($id_address) && isset($selected_state)}
var selectedState = {$selected_state};
{else}
var selectedState = idSelectedState;
{/if}

	$(document).ready(function(){ldelim}
	if(selectedCountry)
	{
		$('#id_country').val(selectedCountry);
		updateState();
		updateNeedIDNumber();
		updateZipCode();
	}
	else
		$('#id_country').val(0);
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
		 
		$('#address_form').submit(function(e){
			var container = $('#error_container');
			// validate the form when it is submitted
			var validator = $("#address_form").validate({
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

		(function($){
		    $(function(){
		      $('#id_country').selectToAutocomplete();
		    });
		  })(jQuery);
	});
{/literal}
//]]>
</script>
<style type="text/css">

</style>
<div style="width:980px;padding:15px 0">
<div class="vtab-bar">
		<ul id="my_account_links">
			<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}identity.php" title="{l s='Information'}">{l s='Personal Info'}</a></div></li>
			<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}history.php" title="{l s='Orders'}">{l s='Orders'}</a></li>
			{if isset($returnAllowed) && $returnAllowed}
				<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}order-follow.php" title="{l s='Merchandise returns'}">{l s='Returns'}</a></div></li>
			{/if}
			{* <li><div class="vtab-bar-link"><a href="{$base_dir_ssl}order-slip.php" title="{l s='Credit slips'}">{l s='Credit Slips'}</a></div></li> *}
			<li class="selected"><div class="vtab-bar-link"><a href="{$base_dir_ssl}addresses.php" title="{l s='My Address Book'}">{l s='My Address Book'}</a></div></li>
			
			{if isset($voucherAllowed) && $voucherAllowed}
				<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}discount.php" title="{l s='Vouchers'}">{l s='My vouchers'}</a></div></li>
			{/if}
			{*<li ><div class="vtab-bar-link"><a href="{$base_dir_ssl}vcoins.php" title="{l s='My Violet Coins'}">{l s='My Violet Coins'}</a></div></li>
			<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}referral.php" title="{l s='My Referrals'}">{l s='My Referrals'}</a></div></li>*}
		</ul>
	</div>
	<div class="vtab-content">
		{include file="$tpl_dir./errors.tpl"}
		<div style="width:700px;">
		<!-- our error container -->
		<div id="error_container" class="error_container">
			<h4>There are errors</h4>
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
		<form id="address_form" action="{$link->getPageLink('address.php', true)}" method="post" class="std">
			<fieldset>
				<h1 style="padding:10px 0; border-bottom:1px dashed #cacaca;text-align:center">{if isset($id_address)}{l s='Your address'}{else}{l s='New address'}{/if}</h1>
				
			{foreach from=$ordered_adr_fields item=field_name}
				
				{if $field_name eq 'firstname'}
				<p class="required text">
					<label for="firstname">{l s='First name'}</label>
					<input type="hidden" name="token" value="{$token}" />
					<input type="text" class="required text" name="firstname" id="firstname" value="{if isset($smarty.post.firstname)}{$smarty.post.firstname}{else}{if isset($address->firstname)}{$address->firstname|escape:'htmlall':'UTF-8'}{/if}{/if}" />
					<sup>*</sup>
				</p>
				{/if}
				{if $field_name eq 'lastname'}
				<p class="required text">
					<label for="lastname">{l s='Last name'}</label>
					<input type="text" class="required text" id="lastname" name="lastname" value="{if isset($smarty.post.lastname)}{$smarty.post.lastname}{else}{if isset($address->lastname)}{$address->lastname|escape:'htmlall':'UTF-8'}{/if}{/if}" />
					<sup>*</sup>
				</p>
				{/if}
				{if $field_name eq 'address1'}
				<p class="required text">
					<label for="address1">{l s='Address'}</label>
					<textarea id="address1" class="required text" name="address1" rows="3">{if isset($smarty.post.address1)}{$smarty.post.address1}{else}{if isset($address->address1)}{$address->address1|escape:'htmlall':'UTF-8'}{/if}{/if}</textarea>
					<sup>*</sup>
				</p>
				{/if}
				
				{if $field_name eq 'postcode'}
				<p class="required postcode text">
					<label for="postcode">{l s='Post/Zip Code'}</label>
					<input type="text" id="postcode" class="text" name="postcode" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{else}{if isset($address->postcode)}{$address->postcode|escape:'htmlall':'UTF-8'}{/if}{/if}" onkeyup="$('#postcode').val($('#postcode').val().toUpperCase());" />
					<sup>*</sup>
				</p>
				{/if}
				{if $field_name eq 'city'}
				<p class="required text">
					<label for="city">{l s='City'}</label>
					<input type="text" class="required text" name="city" id="city" value="{if isset($smarty.post.city)}{$smarty.post.city}{else}{if isset($address->city)}{$address->city|escape:'htmlall':'UTF-8'}{/if}{/if}" maxlength="64" />
					<sup>*</sup>
				</p>
				<!--
					if customer hasn't update his layout address, country has to be verified
					but it's deprecated
				-->
				{/if}
				{if $field_name eq 'Country:name' || $field_name eq 'country'}
				
				<div class="required text">
					<label for="id_country">{l s='Country'}</label>
					<select name="id_country" id="id_country" autofocus="autofocus" autocorrect="off" autocomplete="off">
						<option value="0" selected="selected"></option>
                        {foreach from=$country_names item=country}
							<option value="{$country.id_country}" data-alternative-spellings="{$country.alternate_name}" data-relevancy-booster="{$country.boost}">{$country.country}</option>
						{/foreach}
					</select>
				</div>
				
				{/if}
				
				{/foreach}
				<script type="text/javascript">
					var ajaxurl = '{$ajaxurl}';
					var selectedState = {$selected_state};
					
					$(document).ready(function(){ldelim}
								$('#id_state option[value={$selected_state}]').attr('selected', 'selected');
								{rdelim});
					
				</script>
				<p class="required id_state select">
							<label for="id_state">{l s='State'}<sup>*</sup></label>
							<select name="id_state" id="id_state">
								<option value="">-</option>
							</select>
						</p>
				<p class="text">
					<label for="phone_mobile">{l s='Mobile phone'}</label>
					<input type="text" id="phone_mobile" class="text" name="phone_mobile" value="{if isset($smarty.post.phone_mobile)}{$smarty.post.phone_mobile}{else}{if isset($address->phone_mobile)}{$address->phone_mobile|escape:'htmlall':'UTF-8'}{/if}{/if}" />
				</p>
				<p class="required text" id="address_alias" style="display:none">
					<label for="alias">{l s='Address book title'}</label>
					<input type="text" id="alias" class="text" name="alias" value="{if isset($smarty.post.alias)}{$smarty.post.alias}{else}{if isset($address->alias)}{$address->alias|escape:'htmlall':'UTF-8'}{else}Address{$address_count + 1}{/if}{/if}" />
					<sup>*</sup>
				</p>
				<p class="required"><span><sup>*</sup>{l s='Required field'}</span></p>
			</fieldset>
			<p class="submit2" style="padding:0">
				{if isset($id_address)}<input type="hidden" name="id_address" value="{$id_address|intval}" />{/if}
				{if isset($back)}<input type="hidden" name="back" value="{$back}" />{/if}
				{if isset($mod)}<input type="hidden" name="mod" value="{$mod}" />{/if}
				{if isset($select_address)}<input type="hidden" name="select_address" value="{$select_address|intval}" />{/if}
				<input type="submit" name="submitAddress" id="submitAddress" value="{l s='Save'}" class="button" style="margin:auto;width:150px;"/>
			</p>
			
		</form>
		</div>
		</div>
</div>
