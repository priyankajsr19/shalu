{if $page_name!='authentication'}
<div id="login_modal_panel" style="display:none;width: 760px; min-height: 280px; float:left">
    {if isset($fblogin_url)}
		 <p style="text-align: center">
			<a href="{$fblogin_url}" class="fconnect-button">
				<img src="{$img_ps_dir}fconnect-large.jpeg" alt="login with facebook" />
			</a>
		 </p>
		{/if}
	<p style="padding:10px;font-size:15px;border:1px dashed #cacaca;color:#000;background:#e5e5e5;clear:both;">Register and get $100 to shop <a href="{$base_dir}discount-terms.php" target="blank">(Terms & Conditions)</a></p>
	<div id="authentication" style="float:left">
		<div style="width:350px;float:left;margin:10px">
			<div id="email_create_errors" class="error_container">
				<h4>There are errors:</h4>
				<ol>
					<li><label for="email_create" class="error">Please enter a valid email</label></li>
				</ol>
			</div>
			<form action="{$link->getPageLink('authentication.php', true)}" method="post" id="create-account_form" class="std">
				<fieldset>
					<h3>NEW TO INDUSDIVA? REGISTER NOW!</h3>
					<p class="text">
						<label for="email_create">{l s='E-mail address'}</label>
						<span><input type="text" id="email_create" name="email_create" value="{if isset($smarty.post.email_create)}{$smarty.post.email_create|escape:'htmlall':'UTF-8'|stripslashes}{/if}" class="auth_account_input required email" /></span>
					</p>
					<p class="submit" style="padding:10px 0 0 0 !important;">
						{if isset($back)}<input type="hidden" class="hidden" name="back" value="{$back|escape:'htmlall':'UTF-8'}" />{/if}
						<input type="submit" id="SubmitCreate" name="SubmitCreate" class="button_large" value="{l s='CREATE ACCOUNT'}" />
						<input type="hidden" class="hidden" name="SubmitCreate" value="{l s='Create your account'}" />
						<input type="hidden" class="hidden" name="ajax" value="1" />
						<input id="id_back" type="hidden" class="hidden" name="back" value="{$request_uri}" />
					</p>
				</fieldset>
			</form>
		</div>
		<div style="width:350px;float:left;margin:10px;">
			<div id="login_errors" class="error_container">
				<h4>There are errors:</h4>
				<ol>
					<li><label for="email" class="error">Please enter your email</label></li>
					<li><label for="passwd" class="error">Please enter your password</label></li>
				</ol>
			</div>
			<div id="login_errors_auth" class="error_container">
				<h4>Invalid email or password</h4>
			</div>
			<form action="{$link->getPageLink('authentication.php', true)}" method="post" id="login_form" class="std">
				<fieldset>
				<h3>EXISTING USER? LOGIN NOW</h3>
					<p class="text">
						<label for="email">{l s='E-mail address'}</label>
						<span><input type="text" id="email" name="email" value="" class="auth_account_input required email login-fields" /></span>
					</p>
					<p class="text">
						<label for="passwd">{l s='Password'}</label>
						<span><input type="password" id="passwd" name="passwd" value="" class="auth_account_input required login-fields" /></span>
					</p>
					<p class="submit" style="padding:10px 0 0 0 !important;">
						<input type="hidden" class="hidden" name="ajax" value="1" />
						<input type="submit" id="SubmitLogin" name="SubmitLogin" class="button" value="{l s='Log in'}" />
					</p>
					<p class="lost_password"><a href="{$link->getPageLink('password.php')}">{l s='Forgot your password?'}</a></p>
				</fieldset>
			</form>
		</div>
	</div>
<script type="text/javascript">
// <![CDATA[
	{literal}
	$(document).ready(function() {
		$('#login_form').fadeTo('fast', 0.5);
		$('#email_create').click(function(){
			$('#login_form').fadeTo('fast', 0.5);
			$('#create-account_form').fadeTo('fast', 1);
		});
		$('.login-fields').click(function(){
			$('#create-account_form').fadeTo('fast', 0.5);
			$('#login_form').fadeTo('fast', 1);
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
			{
				e.preventDefault();
				$.fancybox.resize();
			}
			else
			{
				var dataString = $('#login_form').serialize();
				dataString = dataString + "&SubmitLogin=1";
				$.ajax(
						{
							type: 'POST',
							url: requestURI,
							data: dataString,
							dataType: 'json',
							success: function(result){
								if(result.hasError == false)
								{
									window.location = requestURI;
								}
								else if(result.hasError == true)
								{
									if(result.errors[0] == 'Authentication failed')
									{
										$('#login_errors_auth').fadeIn();
									}
									else
									{
										$('#login_errors ol').fadeIn();
										$('#login_errors').fadeIn();
									}
								}
							}
						});
				e.preventDefault();
			}
			
		});
		
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
			{
				$.fancybox.update();
				e.preventDefault();
			}
		});
	});
{/literal}
</script>
</div>
{/if}
