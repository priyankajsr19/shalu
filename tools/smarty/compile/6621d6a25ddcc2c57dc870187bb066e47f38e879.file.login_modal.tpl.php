<?php /* Smarty version Smarty-3.0.7, created on 2015-07-25 19:49:37
         compiled from "/var/www/html/indusdiva/themes/violettheme/./login_modal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:34143347955b39af929a782-46337345%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6621d6a25ddcc2c57dc870187bb066e47f38e879' => 
    array (
      0 => '/var/www/html/indusdiva/themes/violettheme/./login_modal.tpl',
      1 => 1436950699,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '34143347955b39af929a782-46337345',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/var/www/html/indusdiva/tools/smarty/plugins/modifier.escape.php';
?><?php if ($_smarty_tpl->getVariable('page_name')->value!='authentication'){?>
<div id="login_modal_panel" style="display:none;width: 760px; min-height: 280px; float:left">
    <?php if (isset($_smarty_tpl->getVariable('fblogin_url',null,true,false)->value)){?>
		 <p style="text-align: center">
			<a href="<?php echo $_smarty_tpl->getVariable('fblogin_url')->value;?>
" class="fconnect-button">
				<img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
fconnect-large.jpeg" alt="login with facebook" />
			</a>
		 </p>
		<?php }?>
	<p style="padding:10px;font-size:15px;border:1px dashed #cacaca;color:#000;background:#e5e5e5;clear:both;">Register and get $100 to shop <a href="<?php echo $_smarty_tpl->getVariable('base_dir')->value;?>
discount-terms.php" target="blank">(Terms & Conditions)</a></p>
	<div id="authentication" style="float:left">
		<div style="width:350px;float:left;margin:10px">
			<div id="email_create_errors" class="error_container">
				<h4>There are errors:</h4>
				<ol>
					<li><label for="email_create" class="error">Please enter a valid email</label></li>
				</ol>
			</div>
			<form action="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('authentication.php',true);?>
" method="post" id="create-account_form" class="std">
				<fieldset>
					<h3>NEW TO INDUSDIVA? REGISTER NOW!</h3>
					<p class="text">
						<label for="email_create"><?php echo smartyTranslate(array('s'=>'E-mail address'),$_smarty_tpl);?>
</label>
						<span><input type="text" id="email_create" name="email_create" value="<?php if (isset($_POST['email_create'])){?><?php echo stripslashes(smarty_modifier_escape($_POST['email_create'],'htmlall','UTF-8'));?>
<?php }?>" class="auth_account_input required email" /></span>
					</p>
					<p class="submit" style="padding:10px 0 0 0 !important;">
						<?php if (isset($_smarty_tpl->getVariable('back',null,true,false)->value)){?><input type="hidden" class="hidden" name="back" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('back')->value,'htmlall','UTF-8');?>
" /><?php }?>
						<input type="submit" id="SubmitCreate" name="SubmitCreate" class="button_large" value="<?php echo smartyTranslate(array('s'=>'CREATE ACCOUNT'),$_smarty_tpl);?>
" />
						<input type="hidden" class="hidden" name="SubmitCreate" value="<?php echo smartyTranslate(array('s'=>'Create your account'),$_smarty_tpl);?>
" />
						<input type="hidden" class="hidden" name="ajax" value="1" />
						<input id="id_back" type="hidden" class="hidden" name="back" value="<?php echo $_smarty_tpl->getVariable('request_uri')->value;?>
" />
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
			<form action="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('authentication.php',true);?>
" method="post" id="login_form" class="std">
				<fieldset>
				<h3>EXISTING USER? LOGIN NOW</h3>
					<p class="text">
						<label for="email"><?php echo smartyTranslate(array('s'=>'E-mail address'),$_smarty_tpl);?>
</label>
						<span><input type="text" id="email" name="email" value="" class="auth_account_input required email login-fields" /></span>
					</p>
					<p class="text">
						<label for="passwd"><?php echo smartyTranslate(array('s'=>'Password'),$_smarty_tpl);?>
</label>
						<span><input type="password" id="passwd" name="passwd" value="" class="auth_account_input required login-fields" /></span>
					</p>
					<p class="submit" style="padding:10px 0 0 0 !important;">
						<input type="hidden" class="hidden" name="ajax" value="1" />
						<input type="submit" id="SubmitLogin" name="SubmitLogin" class="button" value="<?php echo smartyTranslate(array('s'=>'Log in'),$_smarty_tpl);?>
" />
					</p>
					<p class="lost_password"><a href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('password.php');?>
"><?php echo smartyTranslate(array('s'=>'Forgot your password?'),$_smarty_tpl);?>
</a></p>
				</fieldset>
			</form>
		</div>
	</div>
<script type="text/javascript">
// <![CDATA[
	
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

</script>
</div>
<?php }?>
