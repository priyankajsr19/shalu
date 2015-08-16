<?php /* Smarty version Smarty-3.0.7, created on 2015-05-21 10:42:20
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/authentication.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1812749904555d6934e32766-43686979%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '11994f117e73d01b2f6c5216f40d37b7041f20dd' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/authentication.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1812749904555d6934e32766-43686979',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/tools/smarty/plugins/modifier.escape.php';
?><script type="text/javascript">
// <![CDATA[
idSelectedCountry = <?php if (isset($_POST['id_state'])){?><?php echo intval($_POST['id_state']);?>
<?php }else{ ?>false<?php }?>;
countries = new Array();
countriesNeedIDNumber = new Array();
countriesNeedZipCode = new Array();
<?php if (isset($_smarty_tpl->getVariable('countries',null,true,false)->value)){?>
	<?php  $_smarty_tpl->tpl_vars['country'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('countries')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['country']->key => $_smarty_tpl->tpl_vars['country']->value){
?>
		<?php if (isset($_smarty_tpl->tpl_vars['country']->value['states'])&&$_smarty_tpl->tpl_vars['country']->value['contains_states']){?>
			countries[<?php echo intval($_smarty_tpl->tpl_vars['country']->value['id_country']);?>
] = new Array();
			<?php  $_smarty_tpl->tpl_vars['state'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['country']->value['states']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['state']->key => $_smarty_tpl->tpl_vars['state']->value){
?>
				countries[<?php echo intval($_smarty_tpl->tpl_vars['country']->value['id_country']);?>
].push({'id' : '<?php echo $_smarty_tpl->tpl_vars['state']->value['id_state'];?>
', 'name' : '<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['state']->value['name'],'htmlall','UTF-8');?>
'});
			<?php }} ?>
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['country']->value['need_identification_number']){?>
			countriesNeedIDNumber.push(<?php echo intval($_smarty_tpl->tpl_vars['country']->value['id_country']);?>
);
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['country']->value['need_zip_code'])){?>
			countriesNeedZipCode[<?php echo intval($_smarty_tpl->tpl_vars['country']->value['id_country']);?>
] = <?php echo $_smarty_tpl->tpl_vars['country']->value['need_zip_code'];?>
;
		<?php }?>
	<?php }} ?>
<?php }?>
$(function(){
	$('.id_state option[value=<?php if (isset($_POST['id_state'])){?><?php echo $_POST['id_state'];?>
<?php }else{ ?><?php if (isset($_smarty_tpl->getVariable('address',null,true,false)->value)){?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('address')->value->id_state,'htmlall','UTF-8');?>
<?php }?><?php }?>]').attr('selected', 'selected');
});
//]]>
<?php if ($_smarty_tpl->getVariable('vat_management')->value){?>
	
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
	
<?php }?>

	

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

</script>
<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./errors.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<?php $_smarty_tpl->tpl_vars['stateExist'] = new Smarty_variable(false, null, null);?>

<?php if (!isset($_smarty_tpl->getVariable('email_create',null,true,false)->value)){?>
	<div style="margin:50px auto;float:left">
		<div style="width:350px;float:left;margin:30px 63px 50px">
			<div id="email_create_errors" class="error_container">
				<h4>There are errors:</h4>
				<ol>
					<li><label for="email_create" class="error">Please enter a valid email</label></li>
				</ol>
			</div>
			<form action="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('authentication.php',true);?>
?back=<?php echo $_smarty_tpl->getVariable('back')->value;?>
" method="post" id="create-account_form" class="std">
				<fieldset>
					<h3><?php echo smartyTranslate(array('s'=>'Create your account'),$_smarty_tpl);?>
</h3>
					<h4><?php echo smartyTranslate(array('s'=>'Enter your e-mail address to create an account'),$_smarty_tpl);?>
.</h4>
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
			<form action="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('authentication.php',true);?>
" method="post" id="login_form" class="std">
				<fieldset>
					<h3><?php echo smartyTranslate(array('s'=>'Already registered ?'),$_smarty_tpl);?>
</h3>
					<p class="text">
						<label for="email"><?php echo smartyTranslate(array('s'=>'E-mail address'),$_smarty_tpl);?>
</label>
						<span><input type="text" id="email" name="email" value="<?php if (isset($_POST['email'])){?><?php echo stripslashes(smarty_modifier_escape($_POST['email'],'htmlall','UTF-8'));?>
<?php }?>" class="auth_account_input required email" /></span>
					</p>
					<p class="text">
						<label for="passwd"><?php echo smartyTranslate(array('s'=>'Password'),$_smarty_tpl);?>
</label>
						<span><input type="password" id="passwd" name="passwd" value="<?php if (isset($_POST['passwd'])){?><?php echo stripslashes(smarty_modifier_escape($_POST['passwd'],'htmlall','UTF-8'));?>
<?php }?>" class="auth_account_input required" /></span>
					</p>
					<p class="submit" style="padding:10px 0 0 0 !important;">
						<?php if (isset($_smarty_tpl->getVariable('back',null,true,false)->value)){?><input type="hidden" class="hidden" name="back" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('back')->value,'htmlall','UTF-8');?>
" /><?php }?>
						<input type="submit" id="SubmitLogin" name="SubmitLogin" class="button" value="<?php echo smartyTranslate(array('s'=>'LOG IN'),$_smarty_tpl);?>
" />
					</p>
					<p class="lost_password"><a href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('password.php');?>
"><?php echo smartyTranslate(array('s'=>'Forgot your password?'),$_smarty_tpl);?>
</a></p>
				</fieldset>
			</form>
		</div>
	</div>
	<div>
	<?php if (isset($_smarty_tpl->getVariable('inOrderProcess',null,true,false)->value)&&$_smarty_tpl->getVariable('inOrderProcess')->value&&$_smarty_tpl->getVariable('PS_GUEST_CHECKOUT_ENABLED')->value){?>
		<form action="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('authentication.php',true);?>
?back=<?php echo $_smarty_tpl->getVariable('back')->value;?>
" method="post" id="new_account_form" class="std">
			<fieldset>
				<h3><?php echo smartyTranslate(array('s'=>'Instant Checkout'),$_smarty_tpl);?>
</h3>
				<div id="opc_account_form" style="display: block; ">
					<!-- Account -->
					<p class="required text">
						<label for="email"><?php echo smartyTranslate(array('s'=>'E-mail address'),$_smarty_tpl);?>
</label>
						<input type="text" class="text required email" id="guest_email" name="guest_email" value="<?php if (isset($_POST['guest_email'])){?><?php echo $_POST['guest_email'];?>
<?php }?>">
					</p>
					<p class="radio required">
						<span><?php echo smartyTranslate(array('s'=>'Title'),$_smarty_tpl);?>
</span>
						<input type="radio" name="id_gender" id="id_gender1" value="1" <?php if (isset($_POST['id_gender'])&&$_POST['id_gender']=='1'){?>checked="checked"<?php }?>>
						<label for="id_gender1" class="top"><?php echo smartyTranslate(array('s'=>'Mr.'),$_smarty_tpl);?>
</label>
						<input type="radio" name="id_gender" id="id_gender2" value="2" <?php if (isset($_POST['id_gender'])&&$_POST['id_gender']=='2'){?>checked="checked"<?php }?>>
						<label for="id_gender2" class="top"><?php echo smartyTranslate(array('s'=>'Ms.'),$_smarty_tpl);?>
</label>
					</p>
										<p class="required text">
						<label for="firstname"><?php echo smartyTranslate(array('s'=>'First name'),$_smarty_tpl);?>
</label>
						<input type="text" class="text" id="firstname" name="firstname" onblur="$('#customer_firstname').val($(this).val());" value="<?php if (isset($_POST['firstname'])){?><?php echo $_POST['firstname'];?>
<?php }?>">
						<input type="hidden" class="text" id="customer_firstname" name="customer_firstname" value="<?php if (isset($_POST['firstname'])){?><?php echo $_POST['firstname'];?>
<?php }?>">
					</p>
					<p class="required text">
						<label for="lastname"><?php echo smartyTranslate(array('s'=>'Last name'),$_smarty_tpl);?>
</label>
						<input type="text" class="text" id="lastname" name="lastname" onblur="$('#customer_lastname').val($(this).val());" value="<?php if (isset($_POST['lastname'])){?><?php echo $_POST['lastname'];?>
<?php }?>">
						<input type="hidden" class="text" id="customer_lastname" name="customer_lastname" value="<?php if (isset($_POST['lastname'])){?><?php echo $_POST['lastname'];?>
<?php }?>">
					</p>
					<p class="select">
						<span><?php echo smartyTranslate(array('s'=>'Date of Birth'),$_smarty_tpl);?>
</span>
						<select id="days" name="days">
							<option value="">-</option>
							<?php  $_smarty_tpl->tpl_vars['day'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('days')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['day']->key => $_smarty_tpl->tpl_vars['day']->value){
?>
								<option value="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['day']->value,'htmlall','UTF-8');?>
" <?php if (($_smarty_tpl->getVariable('sl_day')->value==$_smarty_tpl->tpl_vars['day']->value)){?> selected="selected"<?php }?>><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['day']->value,'htmlall','UTF-8');?>
&nbsp;&nbsp;</option>
							<?php }} ?>
						</select>
						<select id="months" name="months">
							<option value="">-</option>
							<?php  $_smarty_tpl->tpl_vars['month'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('months')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['month']->key => $_smarty_tpl->tpl_vars['month']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['month']->key;
?>
								<option value="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['k']->value,'htmlall','UTF-8');?>
" <?php if (($_smarty_tpl->getVariable('sl_month')->value==$_smarty_tpl->tpl_vars['k']->value)){?> selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>($_smarty_tpl->tpl_vars['month']->value)),$_smarty_tpl);?>
&nbsp;</option>
							<?php }} ?>
						</select>
						<select id="years" name="years">
							<option value="">-</option>
							<?php  $_smarty_tpl->tpl_vars['year'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('years')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['year']->key => $_smarty_tpl->tpl_vars['year']->value){
?>
								<option value="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['year']->value,'htmlall','UTF-8');?>
" <?php if (($_smarty_tpl->getVariable('sl_year')->value==$_smarty_tpl->tpl_vars['year']->value)){?> selected="selected"<?php }?>><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['year']->value,'htmlall','UTF-8');?>
&nbsp;&nbsp;</option>
							<?php }} ?>
						</select>
					</p>
					<?php if ($_smarty_tpl->getVariable('newsletter')->value){?>
						<p class="checkbox">
							<input type="checkbox" name="newsletter" id="newsletter" value="1" <?php if (isset($_POST['newsletter'])&&$_POST['newsletter']=='1'){?>checked="checked"<?php }?>>
							<label for="newsletter"><?php echo smartyTranslate(array('s'=>'Sign up for our newsletter'),$_smarty_tpl);?>
</label>
						</p>
						<p class="checkbox">
							<input type="checkbox" name="optin" id="optin" value="1" <?php if (isset($_POST['optin'])&&$_POST['optin']=='1'){?>checked="checked"<?php }?>>
							<label for="optin"><?php echo smartyTranslate(array('s'=>'Receive special offers from our partners'),$_smarty_tpl);?>
</label>
						</p>
					<?php }?>
					<h3><?php echo smartyTranslate(array('s'=>'Delivery address'),$_smarty_tpl);?>
</h3>
					<?php  $_smarty_tpl->tpl_vars['field_name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dlv_all_fields')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['field_name']->key => $_smarty_tpl->tpl_vars['field_name']->value){
?>
						<?php if ($_smarty_tpl->tpl_vars['field_name']->value=="company"){?>
						<p class="text">
							<label for="company"><?php echo smartyTranslate(array('s'=>'Company'),$_smarty_tpl);?>
</label>
							<input type="text" class="text" id="company" name="company" value="<?php if (isset($_POST['company'])){?><?php echo $_POST['company'];?>
<?php }?>" />
						</p>
						<?php }elseif($_smarty_tpl->tpl_vars['field_name']->value=="vat_number"){?>
						<div id="vat_number" style="display:none;">
							<p class="text">
								<label for="vat_number"><?php echo smartyTranslate(array('s'=>'VAT number'),$_smarty_tpl);?>
</label>
								<input type="text" class="text" name="vat_number" value="<?php if (isset($_POST['vat_number'])){?><?php echo $_POST['vat_number'];?>
<?php }?>" />
							</p>
						</div>
						<?php }elseif($_smarty_tpl->tpl_vars['field_name']->value=="address1"){?>
						<p class="required text">
							<label for="address1"><?php echo smartyTranslate(array('s'=>'Address'),$_smarty_tpl);?>
</label>
							<input type="text" class="text" name="address1" id="address1" value="<?php if (isset($_POST['address1'])){?><?php echo $_POST['address1'];?>
<?php }?>">
							<sup>*</sup>
						</p>
						<?php }elseif($_smarty_tpl->tpl_vars['field_name']->value=="postcode"){?>
						<p class="required postcode text">
							<label for="postcode"><?php echo smartyTranslate(array('s'=>'Zip / Postal Code'),$_smarty_tpl);?>
</label>
							<input type="text" class="text" name="postcode" id="postcode" value="<?php if (isset($_POST['postcode'])){?><?php echo $_POST['postcode'];?>
<?php }?>" onblur="$('#postcode').val($('#postcode').val().toUpperCase());">
							<sup>*</sup>
						</p>
						<?php }elseif($_smarty_tpl->tpl_vars['field_name']->value=="city"){?>
						<p class="required text">
							<label for="city"><?php echo smartyTranslate(array('s'=>'City'),$_smarty_tpl);?>
</label>
							<input type="text" class="text" name="city" id="city" value="<?php if (isset($_POST['city'])){?><?php echo $_POST['city'];?>
<?php }?>">
							<sup>*</sup>
						</p>
							<!--
								if customer hasn't update his layout address, country has to be verified
								but it's deprecated
							-->
						<?php }elseif($_smarty_tpl->tpl_vars['field_name']->value=="Country:name"||$_smarty_tpl->tpl_vars['field_name']->value=="country"){?>
						<p class="required select">
							<label for="id_country"><?php echo smartyTranslate(array('s'=>'Country'),$_smarty_tpl);?>
</label>
							<select name="id_country" id="id_country">
								<option value="">-</option>
								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('countries')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id_country'];?>
" <?php if (($_smarty_tpl->getVariable('sl_country')->value==$_smarty_tpl->tpl_vars['v']->value['id_country'])){?> selected="selected"<?php }?>><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['v']->value['name'],'htmlall','UTF-8');?>
</option>
								<?php }} ?>
							</select>
							<sup>*</sup>
						</p>
						<?php }elseif($_smarty_tpl->tpl_vars['field_name']->value=="State:name"){?>
						<?php $_smarty_tpl->tpl_vars['stateExist'] = new Smarty_variable(true, null, null);?>

						<p class="required id_state select">
							<label for="id_state"><?php echo smartyTranslate(array('s'=>'State'),$_smarty_tpl);?>
</label>
							<select name="id_state" id="id_state">
								<option value="">-</option>
							</select>
							<sup>*</sup>
						</p>
						<?php }elseif($_smarty_tpl->tpl_vars['field_name']->value=="phone"){?>
						<p class="text">
							<label for="phone"><?php echo smartyTranslate(array('s'=>'Phone'),$_smarty_tpl);?>
</label>
							<input type="text" class="text" name="phone" id="phone" value="<?php if (isset($_POST['phone'])){?><?php echo $_POST['phone'];?>
<?php }?>"> <sup style="color:red;">*</sup>
						</p>
						<?php }?>
					<?php }} ?>
					<?php if ($_smarty_tpl->getVariable('stateExist')->value==false){?>
					<p class="required id_state select">
						<label for="id_state"><?php echo smartyTranslate(array('s'=>'State'),$_smarty_tpl);?>
</label>
						<select name="id_state" id="id_state">
							<option value="">-</option>
						</select>
						<sup>*</sup>
					</p>
					<?php }?>
					<input type="hidden" name="alias" id="alias" value="<?php echo smartyTranslate(array('s'=>'My address'),$_smarty_tpl);?>
">
					<input type="hidden" name="is_new_customer" id="is_new_customer" value="0">
					<!-- END Account -->
				</div>
			</fieldset>
			<fieldset class="account_creation dni">
				<h3><?php echo smartyTranslate(array('s'=>'Tax identification'),$_smarty_tpl);?>
</h3>

				<p class="required text">
					<label for="dni"><?php echo smartyTranslate(array('s'=>'Identification number'),$_smarty_tpl);?>
</label>
					<input type="text" class="text" name="dni" id="dni" value="<?php if (isset($_POST['dni'])){?><?php echo $_POST['dni'];?>
<?php }?>" />
					<span class="form_info"><?php echo smartyTranslate(array('s'=>'DNI / NIF / NIE'),$_smarty_tpl);?>
</span>
					<sup>*</sup>
				</p>
			</fieldset>
			<p class="cart_navigation required submit">
				<span class="required"><sup>*</sup><?php echo smartyTranslate(array('s'=>'Required field'),$_smarty_tpl);?>
</span>
				<input type="submit" class="button" name="submitGuestAccount" id="submitGuestAccount" style="float:right" value="<?php echo smartyTranslate(array('s'=>'Continue'),$_smarty_tpl);?>
">
			</p>
		</form>
	<?php }?>
	</div>
<?php }else{ ?>
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
<form action="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('authentication.php',true);?>
?back=<?php echo $_smarty_tpl->getVariable('back')->value;?>
" method="post" id="account-creation_form" class="std" style="padding:20px 0">
	<?php echo $_smarty_tpl->getVariable('HOOK_CREATE_ACCOUNT_TOP')->value;?>

	<fieldset class="account_creation">
		<h1 style="text-align:center;border-bottom:1px dashed #cacaca;padding:10px 0;margin:10px 0 20px;font-weight:bold;font-size:21px;">REGISTRATION - ABOUT YOU</h1>
		<p class="required text">
			<label for="customer_firstname"><?php echo smartyTranslate(array('s'=>'First name'),$_smarty_tpl);?>
</label>
			<input onkeyup="$('#firstname').val(this.value);" type="text" class="text required" id="customer_firstname" name="customer_firstname" value="<?php if (isset($_POST['customer_firstname'])){?><?php echo $_POST['customer_firstname'];?>
<?php }?>" />
		</p>
		<p class="required text">
			<label for="customer_lastname"><?php echo smartyTranslate(array('s'=>'Last name'),$_smarty_tpl);?>
</label>
			<input onkeyup="$('#lastname').val(this.value);" type="text" class="text required" id="customer_lastname" name="customer_lastname" value="<?php if (isset($_POST['customer_lastname'])){?><?php echo $_POST['customer_lastname'];?>
<?php }?>" />
		</p>
		<p class="required text">
			<label for="email"><?php echo smartyTranslate(array('s'=>'E-mail'),$_smarty_tpl);?>
</label>
			<input type="text" class="text required email" id="email" name="email" value="<?php if (isset($_POST['email'])){?><?php echo $_POST['email'];?>
<?php }?>" />
			<span style="color:#a6a6a6;float:right; display:inline-block;padding:0 50px 0 20px;width:130px;text-align:left">We'll send your order confirmation here</span>
		</p>
		<p class="required password">
			<label for="passwd"><?php echo smartyTranslate(array('s'=>'Your New Password'),$_smarty_tpl);?>
</label>
			<input type="password" class="text required" name="passwd" id="passwd" />
		</p>
		<p class="required password">
			<label for="retype_passwd"><?php echo smartyTranslate(array('s'=>'Retype Password'),$_smarty_tpl);?>
</label>
			<input type="password" class="text required" name="retype_passwd" id="retype_passwd" />
		</p>
		
		<?php if ($_smarty_tpl->getVariable('newsletter')->value){?>
		<p class="checkbox" >
			<input type="checkbox" name="newsletter" id="newsletter" value="1" <?php if (isset($_POST['newsletter'])&&$_POST['newsletter']==1){?> checked="checked"<?php }?> />
			<label for="newsletter"><?php echo smartyTranslate(array('s'=>'Sign up for our newsletter'),$_smarty_tpl);?>
</label>
		</p>
		<p class="checkbox" >
			<input type="checkbox"name="optin" id="optin" value="1" <?php if (isset($_POST['optin'])&&$_POST['optin']==1){?> checked="checked"<?php }?> />
			<label for="optin"><?php echo smartyTranslate(array('s'=>'Receive special offers from our partners'),$_smarty_tpl);?>
</label>
		</p>
		<?php }?>
		
		<p class="required submit" style="padding:20px 0px !important;text-align:center;">
			<input type="hidden" name="email_create" value="1" />
			<input type="hidden" name="is_new_customer" value="1" />
			<?php if (isset($_smarty_tpl->getVariable('back',null,true,false)->value)){?>
				<input type="hidden" class="hidden" name="back" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('back')->value,'htmlall','UTF-8');?>
" />
			<?php }?>
			<input type="submit" name="submitAccount" id="submitAccount" value="<?php echo smartyTranslate(array('s'=>'REGISTER'),$_smarty_tpl);?>
" class="button" style="margin:auto;width:200px;"/>
		</p>
	</fieldset>
	<?php echo $_smarty_tpl->getVariable('HOOK_CREATE_ACCOUNT_FORM')->value;?>


</form>
</div>
<?php }?>

