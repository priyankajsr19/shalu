<script>
{literal}
	$(document).ready(function() {
		
		$('#password_reset_form').submit(function(e){
			var containerAccount = $('#new_password_errors');
			// validate the form when it is submitted
			var validator = $("#password_reset_form").validate({
				errorContainer: containerAccount,
				errorLabelContainer: $("ol", containerAccount),
				wrapper: 'li',
				meta: "validate",
				rules: {
					retype_password: {equalTo:"#new_password"}
				}
			});
			if(!validator.form())
				e.preventDefault();
			
		});
		
		$('#email_form').submit(function(e){
			var containerAccount = $('#email_errors');
			// validate the form when it is submitted
			var validator = $("#email_form").validate({
				errorContainer: containerAccount,
				errorLabelContainer: $("ol", containerAccount),
				wrapper: 'li',
				meta: "validate"
			});
			if(!validator.form())
				e.preventDefault();
			
		});
	});
{/literal}
</script>
<div style="width:980px;padding:50px 0 0">
<div style="width:450px;margin:auto;">
	
	{include file="$tpl_dir./errors.tpl"}
	
	{if isset($confirmation) && $confirmation == 1}
		<p class="success">{l s='Your password has been successfully reset and has been sent to your e-mail address:'} {$email|escape:'htmlall':'UTF-8'}</p>
	{elseif isset($confirmation) && $confirmation == 2}
		<p class="success">{l s='A confirmation e-mail has been sent to your address:'} {$email|escape:'htmlall':'UTF-8'}</p>
	{elseif isset($password_reset) && $password_reset == 1}
		<p>{l s='Please enter your new password.'}</p>
		<div id="new_password_errors" class="error_container">
			<h4>There are errors:</h4>
			<ol>
				<li><label for="new_password" class="error">Please select a password</label></li>
				<li><label for="retype_password" class="error">Password and confirmation dont match!</label></li>
			</ol>
		</div>
		<form id="password_reset_form" action="{$request_uri|escape:'htmlall':'UTF-8'}" method="post" class="std">
			<fieldset>
				<h1>{l s='Forgot your password'}</h1>
				<p class="text">
					<label for="email">{l s='email:'}</label>
					<label for="email">{$email}</label>
					<input class="text" type="hidden" id="email" name="email" value="{$email}"/>
				</p>
				<p class="text">
					<label for="password">New Password</label>
					<input class="text required" type="password" id="new_password" name="new_password" style="width:236px"/>
				</p>
				<p class="text">
					<label for="retype_password">Retype New Password</label>
					<input class="text required" type="password" id="retype_password" name="retype_password" style="width:236px"/>
				</p>
				<p class="submit">
					<input type="submit" class="button_large" id="SubmitPassword" name="SubmitPassword" value="{l s='Reset and Login'}" />
				</p>
			</fieldset>
		</form>
	{else}
		<div id="email_errors" class="error_container">
			<h4>There are errors:</h4>
			<ol>
				<li><label for="email" class="error">Please enter a valid email</label></li>
			</ol>
		</div>
		<form id="email_form" action="{$request_uri|escape:'htmlall':'UTF-8'}" method="post" class="std">
			<fieldset>
			<h1 class="form_title" style="font-size:18px;">{l s='Forgot your password'}</h1>
				<p>{l s='Please enter the e-mail address used to register. We will e-mail you your new password.'}</p>
				<p class="text">
					<label for="email" style="width:87px">{l s='E-mail:'}</label>
					<input class="required email" type="text email" id="email" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email|escape:'htmlall':'UTF-8'|stripslashes}{/if}" />
				</p>
				<p class="submit" style="padding:0px !important;">
					<input type="submit" class="button_large" style="margin:auto" value="{l s='Retrieve Password'}" />
				</p>
			</fieldset>
		</form>
	{/if}
	<p class="clear">
		<a href="{$link->getPageLink('authentication.php')}" title="{l s='Back to Login'}">{l s='Back to Login'}</a>
	</p>
</div>
</div>