{literal}
<script type="text/javascript">
//<![CDATA[
	var baseDir = '{$base_dir_ssl}';

	$(document).ready(function() {
		
		$('#account_form').submit(function(e){
			var containerAccount = $('#account_error_container');
			// validate the form when it is submitted
			var validator = $("#account_form").validate({
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

//]]>
</script>
{/literal}

<div style="width:970px;">
	<div class="vtab-bar">
		<ul id="my_account_links">
			<li class="selected"><div class="vtab-bar-link"><a href="{$base_dir_ssl}identity.php" title="{l s='Information'}">{l s='Personal Info'}</a></div></li>
			<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}history.php" title="{l s='Orders'}">{l s='Orders'}</a></li>
			{if isset($returnAllowed) && $returnAllowed}
				<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}order-follow.php" title="{l s='Merchandise returns'}">{l s='Returns'}</a></div></li>
			{/if}
			{* <li><div class="vtab-bar-link"><a href="{$base_dir_ssl}order-slip.php" title="{l s='Credit slips'}">{l s='Credit Slips'}</a></div></li> *}
			<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}addresses.php" title="{l s='My Address Book'}">{l s='My Address Book'}</a></div></li>
			
			{if isset($voucherAllowed) && $voucherAllowed}
				<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}discount.php" title="{l s='Vouchers'}">{l s='My vouchers'}</a></div></li>
			{/if}
			<li ><div class="vtab-bar-link"><a href="{$base_dir_ssl}vcoins.php" title="{l s='My Violet Coins'}">{l s='My Violet Coins'}</a></div></li>
			<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}referral.php" title="{l s='My Referrals'}">{l s='My Referrals'}</a></div></li>
		</ul>
	</div>
	<div class="vtab-content">
		<h2>{l s='Your personal information'}</h2>
		
		{include file="$tpl_dir./errors.tpl"}
		
		{if $confirmation}
			<p class="success">
				{l s='Your personal information has been successfully updated.'}
				{if $pwd_changed}<br />{l s='Your password has been sent to your e-mail:'} {$email|escape:'htmlall':'UTF-8'}{/if}
			</p>
		{else}
			<div id="account_error_container" class="error_container">
				<h4>There are errors:</h4>
				<ol>
					<li><label for="customer_firstname" class="error">Please enter your first name</label></li>
					<li><label for="customer_lastname" class="error">Please enter your last name</label></li>
					<li><label for="email" class="error">Please enter a valid email</label></li>
					<li><label for="passwd" class="error">Please select a password</label></li>
				</ol>
			</div>
			<form id="account_form" action="{$base_dir_ssl}account" method="post" class="std">
				<fieldset>
					<p class="radio">
						<span style="font-size:14px;margin-right:5px;">{l s='Gender'}</span>
						<input type="radio" id="id_gender1" name="id_gender" value="1" {if $smarty.post.id_gender == 1 OR !$smarty.post.id_gender}checked="checked"{/if} />
						<label for="id_gender1">{l s='Mr.'}</label>
						<input type="radio" id="id_gender2" name="id_gender" value="2" {if $smarty.post.id_gender == 2}checked="checked"{/if} />
						<label for="id_gender2">{l s='Ms.'}</label>
					</p>
					<p class="required text">
						<label for="firstname">{l s='First name'}<sup>*</sup></label>
						<input type="text" class="text required" id="firstname" name="firstname" value="{$smarty.post.firstname}" style="width:236px"/>
					</p>
					<p class="required text">
						<label for="lastname">{l s='Last name'}<sup>*</sup></label>
						<input type="text" class="text required" name="lastname" id="lastname" value="{$smarty.post.lastname}" style="width:236px"/>
					</p>
					<p class="required text">
						<label for="email">{l s='E-mail'}<sup>*</sup></label>
						<input type="text" class="text required email" name="email" id="email" value="{$smarty.post.email}" style="width:236px"/>
					</p>
					<p class="required text">
						<label for="old_passwd">{l s='Current password'}<sup>*</sup></label>
						<input type="password" class="text required" name="old_passwd" id="old_passwd" style="width:236px"/>
					</p>
					<p class="password">
						<label for="passwd">{l s='Password'}</label>
						<input type="password" class="text" name="passwd" id="passwd" />
					</p>
					<p class="password">
						<label for="confirmation">{l s='Confirmation'}</label>
						<input type="password" class="text" name="confirmation" id="confirmation" />
					</p>
					<p class="select">
						<label>{l s='Birthday'}</label>
						<select name="days" id="days">
							<option value="">-</option>
							{foreach from=$days item=v}
								<option value="{$v|escape:'htmlall':'UTF-8'}" {if ($sl_day == $v)}selected="selected"{/if}>{$v|escape:'htmlall':'UTF-8'}&nbsp;&nbsp;</option>
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
							{foreach from=$months key=k item=v}
								<option value="{$k|escape:'htmlall':'UTF-8'}" {if ($sl_month == $k)}selected="selected"{/if}>{l s="$v"}&nbsp;</option>
							{/foreach}
						</select>
						<select id="years" name="years">
							<option value="">-</option>
							{foreach from=$years item=v}
								<option value="{$v|escape:'htmlall':'UTF-8'}" {if ($sl_year == $v)}selected="selected"{/if}>{$v|escape:'htmlall':'UTF-8'}&nbsp;&nbsp;</option>
							{/foreach}
						</select>
					</p>
					{if $need_identification_number}
					<p class="required text">
						<label for="dni">{l s='Identication number'}</label>
						<input type="text" class="text" name="dni" id="dni" value="{if isset($smarty.post.dni)}{$smarty.post.dni}{/if}" />
						<span class="form_info">{l s='DNI / NIF / NIE'}</span>
					</p>
					{/if}
					{*<p class="checkbox">
						<input style="margin-left:30%" type="checkbox" id="newsletter" name="newsletter" value="1" {if $smarty.post.newsletter == 1} checked="checked"{/if} />
						<label for="newsletter">{l s='Sign up for our newsletter'}</label>
					</p>
					<p class="checkbox">
						<input style="margin-left:30%" type="checkbox" name="optin" id="optin" value="1" {if $smarty.post.optin == 1} checked="checked"{/if} />
						<label for="optin">{l s='Receive special offers from our partners'}</label>
					</p>*}
					<p class="required required_desc" style="width:30%; text-align:right;"><sup>*</sup>{l s='Required field'}</p>
					<p class="submit">
						<input type="submit" class="button" name="submitIdentity" value="{l s='Save'}" />
					</p>
				</fieldset>
			</form>
			
		{/if}
		
		
	</div>
</div>
