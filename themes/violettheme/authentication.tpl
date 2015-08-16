<script type="text/javascript">
// <![CDATA[
idSelectedCountry = {if isset($smarty.post.id_state)}{$smarty.post.id_state|intval}{else}false{/if};
countries = new Array();
countriesNeedIDNumber = new Array();
countriesNeedZipCode = new Array();
{if isset($countries)}
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
{/if}
$(function(){ldelim}
	$('.id_state option[value={if isset($smarty.post.id_state)}{$smarty.post.id_state}{else}{if isset($address)}{$address->id_state|escape:'htmlall':'UTF-8'}{/if}{/if}]').attr('selected', 'selected');
{rdelim});
//]]>
{if $vat_management}
	{literal}
	$(document).ready(function() {
		$('#company').blur(function(){
			vat_number();
		});
		vat_number();
		function vat_number()
		{
			if ($('#company').val() != '')
				$('#vat_number').show();
			else
				$('#vat_number').hide();
		}
	});
	{/literal}
{/if}

	{literal}

	$(document).ready(function() {
		
		$('#create-account_form').submit(function(e){
			var containerCreate = $('#email_create_errors');
			// validate the form when it is submitted
			var validator = $("#create-account_form").validate({
				errorContainer: containerCreate,
				errorLabelContainer: $("ol", containerCreate),
				wrapper: 'li',
				meta: "validate"
			});
			if(!validator.form())
				e.preventDefault();
			
		});
		
		$('#login_form').submit(function(e){
			var containerCreate = $('#login_errors');
			// validate the form when it is submitted
			var validator = $("#login_form").validate({
				errorContainer: containerCreate,
				errorLabelContainer: $("ol", containerCreate),
				wrapper: 'li',
				meta: "validate"
			});
			if(!validator.form())
				e.preventDefault();
			
		});
		
		$('#account-creation_form').submit(function(e){
			var containerAccount = $('#account_error_container');
			// validate the form when it is submitted
			var validator = $("#account-creation_form").validate({
				errorContainer: containerAccount,
				errorLabelContainer: $("ol", containerAccount),
				wrapper: 'li',
				meta: "validate",
				rules: {
					retype_passwd: {equalTo:"#passwd"}
				}
			});
			if(!validator.form())
				e.preventDefault();
			
		});
	});
{/literal}
</script>
{*<h1>{if !isset($email_create)}{l s='Log in'}{else}{l s='Create your account'}{/if}</h1>*}
{*
{assign var='current_step' value='login'}
{include file="$tpl_dir./order-steps.tpl"}
*}
{include file="$tpl_dir./errors.tpl"}
{assign var='stateExist' value=false}

{if !isset($email_create)}
	<div style="margin:50px auto;float:left">
		<div style="width:350px;float:left;margin:30px 63px 50px">
			<div id="email_create_errors" class="error_container">
				<h4>There are errors:</h4>
				<ol>
					<li><label for="email_create" class="error">Please enter a valid email</label></li>
				</ol>
			</div>
			<form action="{$link->getPageLink('authentication.php', true)}?back={$back}" method="post" id="create-account_form" class="std">
				<fieldset>
					<h3>{l s='Create your account'}</h3>
					<h4>{l s='Enter your e-mail address to create an account'}.</h4>
					<p class="text">
						<label for="email_create">{l s='E-mail address'}</label>
						<span><input type="text" id="email_create" name="email_create" value="{if isset($smarty.post.email_create)}{$smarty.post.email_create|escape:'htmlall':'UTF-8'|stripslashes}{/if}" class="auth_account_input required email" /></span>
					</p>
					<p class="submit" style="padding:10px 0 0 0 !important;">
						{if isset($back)}<input type="hidden" class="hidden" name="back" value="{$back|escape:'htmlall':'UTF-8'}" />{/if}
						<input type="submit" id="SubmitCreate" name="SubmitCreate" class="button_large" value="{l s='CREATE ACCOUNT'}" />
						<input type="hidden" class="hidden" name="SubmitCreate" value="{l s='Create your account'}" />
					</p>
				</fieldset>
			</form>
		</div>
		<div style="height:300px;width:10px;float:left;">
			
			<div style="height:300px;width:1px;margin:12px auto;border-right:1px solid #cacaca;"></div>
			OR
		</div>
		<div style="width:350px;float:left;margin:30px 63px 50px;">
			<div id="login_errors" class="error_container">
				<h4>There are errors:</h4>
				<ol>
					<li><label for="email" class="error">Please enter your email</label></li>
					<li><label for="passwd" class="error">Please enter your password</label></li>
				</ol>
			</div>
			<form action="{$link->getPageLink('authentication.php', true)}" method="post" id="login_form" class="std">
				<fieldset>
					<h3>{l s='Already registered ?'}</h3>
					<p class="text">
						<label for="email">{l s='E-mail address'}</label>
						<span><input type="text" id="email" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email|escape:'htmlall':'UTF-8'|stripslashes}{/if}" class="auth_account_input required email" /></span>
					</p>
					<p class="text">
						<label for="passwd">{l s='Password'}</label>
						<span><input type="password" id="passwd" name="passwd" value="{if isset($smarty.post.passwd)}{$smarty.post.passwd|escape:'htmlall':'UTF-8'|stripslashes}{/if}" class="auth_account_input required" /></span>
					</p>
					<p class="submit" style="padding:10px 0 0 0 !important;">
						{if isset($back)}<input type="hidden" class="hidden" name="back" value="{$back|escape:'htmlall':'UTF-8'}" />{/if}
						<input type="submit" id="SubmitLogin" name="SubmitLogin" class="button" value="{l s='LOG IN'}" />
					</p>
					<p class="lost_password"><a href="{$link->getPageLink('password.php')}">{l s='Forgot your password?'}</a></p>
				</fieldset>
			</form>
		</div>
		{*
		{if isset($fblogin_url)}
		 <p style="text-align: center">
			<a href="{$fblogin_url}" class="fconnect-button">
				<img src="{$base_dir}img/fconnect-large.jpg" alt="login with facebook" />
			</a>
		 </p>
		{/if}
		*}
	</div>
	<div>
	{if isset($inOrderProcess) && $inOrderProcess && $PS_GUEST_CHECKOUT_ENABLED}
		<form action="{$link->getPageLink('authentication.php', true)}?back={$back}" method="post" id="new_account_form" class="std">
			<fieldset>
				<h3>{l s='Instant Checkout'}</h3>
				<div id="opc_account_form" style="display: block; ">
					<!-- Account -->
					<p class="required text">
						<label for="email">{l s='E-mail address'}</label>
						<input type="text" class="text required email" id="guest_email" name="guest_email" value="{if isset($smarty.post.guest_email)}{$smarty.post.guest_email}{/if}">
					</p>
					<p class="radio required">
						<span>{l s='Title'}</span>
						<input type="radio" name="id_gender" id="id_gender1" value="1" {if isset($smarty.post.id_gender) && $smarty.post.id_gender == '1'}checked="checked"{/if}>
						<label for="id_gender1" class="top">{l s='Mr.'}</label>
						<input type="radio" name="id_gender" id="id_gender2" value="2" {if isset($smarty.post.id_gender) && $smarty.post.id_gender == '2'}checked="checked"{/if}>
						<label for="id_gender2" class="top">{l s='Ms.'}</label>
					</p>
										<p class="required text">
						<label for="firstname">{l s='First name'}</label>
						<input type="text" class="text" id="firstname" name="firstname" onblur="$('#customer_firstname').val($(this).val());" value="{if isset($smarty.post.firstname)}{$smarty.post.firstname}{/if}">
						<input type="hidden" class="text" id="customer_firstname" name="customer_firstname" value="{if isset($smarty.post.firstname)}{$smarty.post.firstname}{/if}">
					</p>
					<p class="required text">
						<label for="lastname">{l s='Last name'}</label>
						<input type="text" class="text" id="lastname" name="lastname" onblur="$('#customer_lastname').val($(this).val());" value="{if isset($smarty.post.lastname)}{$smarty.post.lastname}{/if}">
						<input type="hidden" class="text" id="customer_lastname" name="customer_lastname" value="{if isset($smarty.post.lastname)}{$smarty.post.lastname}{/if}">
					</p>
					<p class="select">
						<span>{l s='Date of Birth'}</span>
						<select id="days" name="days">
							<option value="">-</option>
							{foreach from=$days item=day}
								<option value="{$day|escape:'htmlall':'UTF-8'}" {if ($sl_day == $day)} selected="selected"{/if}>{$day|escape:'htmlall':'UTF-8'}&nbsp;&nbsp;</option>
							{/foreach}
						</select>
						{*
							{l s='January'}
							{l s='February'}
							{l s='March'}
							{l s='April'}
							{l s='May'}
							{l s='June'}
							{l s='July'}
							{l s='August'}
							{l s='September'}
							{l s='October'}
							{l s='November'}
							{l s='December'}
						*}
						<select id="months" name="months">
							<option value="">-</option>
							{foreach from=$months key=k item=month}
								<option value="{$k|escape:'htmlall':'UTF-8'}" {if ($sl_month == $k)} selected="selected"{/if}>{l s="$month"}&nbsp;</option>
							{/foreach}
						</select>
						<select id="years" name="years">
							<option value="">-</option>
							{foreach from=$years item=year}
								<option value="{$year|escape:'htmlall':'UTF-8'}" {if ($sl_year == $year)} selected="selected"{/if}>{$year|escape:'htmlall':'UTF-8'}&nbsp;&nbsp;</option>
							{/foreach}
						</select>
					</p>
					{if $newsletter}
						<p class="checkbox">
							<input type="checkbox" name="newsletter" id="newsletter" value="1" {if isset($smarty.post.newsletter) && $smarty.post.newsletter == '1'}checked="checked"{/if}>
							<label for="newsletter">{l s='Sign up for our newsletter'}</label>
						</p>
						<p class="checkbox">
							<input type="checkbox" name="optin" id="optin" value="1" {if isset($smarty.post.optin) && $smarty.post.optin == '1'}checked="checked"{/if}>
							<label for="optin">{l s='Receive special offers from our partners'}</label>
						</p>
					{/if}
					<h3>{l s='Delivery address'}</h3>
					{foreach from=$dlv_all_fields item=field_name}
						{if $field_name eq "company"}
						<p class="text">
							<label for="company">{l s='Company'}</label>
							<input type="text" class="text" id="company" name="company" value="{if isset($smarty.post.company)}{$smarty.post.company}{/if}" />
						</p>
						{elseif $field_name eq "vat_number"}
						<div id="vat_number" style="display:none;">
							<p class="text">
								<label for="vat_number">{l s='VAT number'}</label>
								<input type="text" class="text" name="vat_number" value="{if isset($smarty.post.vat_number)}{$smarty.post.vat_number}{/if}" />
							</p>
						</div>
						{elseif $field_name eq "address1"}
						<p class="required text">
							<label for="address1">{l s='Address'}</label>
							<input type="text" class="text" name="address1" id="address1" value="{if isset($smarty.post.address1)}{$smarty.post.address1}{/if}">
							<sup>*</sup>
						</p>
						{elseif $field_name eq "postcode"}
						<p class="required postcode text">
							<label for="postcode">{l s='Zip / Postal Code'}</label>
							<input type="text" class="text" name="postcode" id="postcode" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{/if}" onblur="$('#postcode').val($('#postcode').val().toUpperCase());">
							<sup>*</sup>
						</p>
						{elseif $field_name eq "city"}
						<p class="required text">
							<label for="city">{l s='City'}</label>
							<input type="text" class="text" name="city" id="city" value="{if isset($smarty.post.city)}{$smarty.post.city}{/if}">
							<sup>*</sup>
						</p>
							<!--
								if customer hasn't update his layout address, country has to be verified
								but it's deprecated
							-->
						{elseif $field_name eq "Country:name" || $field_name eq "country"}
						<p class="required select">
							<label for="id_country">{l s='Country'}</label>
							<select name="id_country" id="id_country">
								<option value="">-</option>
								{foreach from=$countries item=v}
								<option value="{$v.id_country}" {if ($sl_country == $v.id_country)} selected="selected"{/if}>{$v.name|escape:'htmlall':'UTF-8'}</option>
								{/foreach}
							</select>
							<sup>*</sup>
						</p>
						{elseif $field_name eq "State:name"}
						{assign var='stateExist' value=true}

						<p class="required id_state select">
							<label for="id_state">{l s='State'}</label>
							<select name="id_state" id="id_state">
								<option value="">-</option>
							</select>
							<sup>*</sup>
						</p>
						{elseif $field_name eq "phone"}
						<p class="text">
							<label for="phone">{l s='Phone'}</label>
							<input type="text" class="text" name="phone" id="phone" value="{if isset($smarty.post.phone)}{$smarty.post.phone}{/if}"> <sup style="color:red;">*</sup>
						</p>
						{/if}
					{/foreach}
					{if $stateExist eq false}
					<p class="required id_state select">
						<label for="id_state">{l s='State'}</label>
						<select name="id_state" id="id_state">
							<option value="">-</option>
						</select>
						<sup>*</sup>
					</p>
					{/if}
					<input type="hidden" name="alias" id="alias" value="{l s='My address'}">
					<input type="hidden" name="is_new_customer" id="is_new_customer" value="0">
					<!-- END Account -->
				</div>
			</fieldset>
			<fieldset class="account_creation dni">
				<h3>{l s='Tax identification'}</h3>

				<p class="required text">
					<label for="dni">{l s='Identification number'}</label>
					<input type="text" class="text" name="dni" id="dni" value="{if isset($smarty.post.dni)}{$smarty.post.dni}{/if}" />
					<span class="form_info">{l s='DNI / NIF / NIE'}</span>
					<sup>*</sup>
				</p>
			</fieldset>
			<p class="cart_navigation required submit">
				<span class="required"><sup>*</sup>{l s='Required field'}</span>
				<input type="submit" class="button" name="submitGuestAccount" id="submitGuestAccount" style="float:right" value="{l s='Continue'}">
			</p>
		</form>
	{/if}
	</div>
{else}
<div style="width:700px; margin:auto;">
<div id="account_error_container" class="error_container">
	<h4>There are errors:</h4>
	<ol>
		<li><label for="customer_firstname" class="error">Please enter your first name</label></li>
		<li><label for="customer_lastname" class="error">Please enter your last name</label></li>
		<li><label for="email" class="error">Please enter a valid email</label></li>
		<li><label for="passwd" class="error">Please select a password</label></li>
		<li><label for="retype_passwd" class="error">Password and confirmation don't match!</label></li>
	</ol>
</div>
<form action="{$link->getPageLink('authentication.php', true)}?back={$back}" method="post" id="account-creation_form" class="std" style="padding:20px 0">
	{$HOOK_CREATE_ACCOUNT_TOP}
	<fieldset class="account_creation">
		<h1 style="text-align:center;border-bottom:1px dashed #cacaca;padding:10px 0;margin:10px 0 20px;font-weight:bold;font-size:21px;">REGISTRATION - ABOUT YOU</h1>
		<p class="required text">
			<label for="customer_firstname">{l s='First name'}</label>
			<input onkeyup="$('#firstname').val(this.value);" type="text" class="text required" id="customer_firstname" name="customer_firstname" value="{if isset($smarty.post.customer_firstname)}{$smarty.post.customer_firstname}{/if}" />
		</p>
		<p class="required text">
			<label for="customer_lastname">{l s='Last name'}</label>
			<input onkeyup="$('#lastname').val(this.value);" type="text" class="text required" id="customer_lastname" name="customer_lastname" value="{if isset($smarty.post.customer_lastname)}{$smarty.post.customer_lastname}{/if}" />
		</p>
		<p class="required text">
			<label for="email">{l s='E-mail'}</label>
			<input type="text" class="text required email" id="email" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email}{/if}" />
			<span style="color:#a6a6a6;float:right; display:inline-block;padding:0 50px 0 20px;width:130px;text-align:left">We'll send your order confirmation here</span>
		</p>
		<p class="required password">
			<label for="passwd">{l s='Your New Password'}</label>
			<input type="password" class="text required" name="passwd" id="passwd" />
		</p>
		<p class="required password">
			<label for="retype_passwd">{l s='Retype Password'}</label>
			<input type="password" class="text required" name="retype_passwd" id="retype_passwd" />
		</p>
		
		{if $newsletter}
		<p class="checkbox" >
			<input type="checkbox" name="newsletter" id="newsletter" value="1" {if isset($smarty.post.newsletter) AND $smarty.post.newsletter == 1} checked="checked"{/if} />
			<label for="newsletter">{l s='Sign up for our newsletter'}</label>
		</p>
		<p class="checkbox" >
			<input type="checkbox"name="optin" id="optin" value="1" {if isset($smarty.post.optin) AND $smarty.post.optin == 1} checked="checked"{/if} />
			<label for="optin">{l s='Receive special offers from our partners'}</label>
		</p>
		{/if}
		
		<p class="required submit" style="padding:20px 0px !important;text-align:center;">
			<input type="hidden" name="email_create" value="1" />
			<input type="hidden" name="is_new_customer" value="1" />
			{if isset($back)}
				<input type="hidden" class="hidden" name="back" value="{$back|escape:'htmlall':'UTF-8'}" />
			{/if}
			<input type="submit" name="submitAccount" id="submitAccount" value="{l s='REGISTER'}" class="button" style="margin:auto;width:200px;"/>
		</p>
	</fieldset>
	{$HOOK_CREATE_ACCOUNT_FORM}

</form>
</div>
{/if}

