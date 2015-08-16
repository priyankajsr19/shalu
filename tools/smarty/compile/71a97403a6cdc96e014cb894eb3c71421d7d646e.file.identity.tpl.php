<?php /* Smarty version Smarty-3.0.7, created on 2015-07-31 17:26:27
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/identity.tpl" */ ?>
<?php /*%%SmartyHeaderCode:44171844955bb626b7f7739-84725144%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '71a97403a6cdc96e014cb894eb3c71421d7d646e' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/identity.tpl',
      1 => 1437833298,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '44171844955bb626b7f7739-84725144',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/tools/smarty/plugins/modifier.escape.php';
?>
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
        $("#newsletter").click(function(){
            if( $(this).is(":checked") ) {
                $(this).val(0);
                $(this).attr("checked","checked");
            }
            else {
                $(this).val(1);
                $(this).removeAttr("checked");
            }
        });
	});

//]]>
</script>


<div style="width:970px;">
        <?php $_smarty_tpl->tpl_vars['selitem'] = new Smarty_variable('identity', null, null);?>
	<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./myaccount_menu.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	<div class="vtab-content">
		<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./errors.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
		
		<?php if ($_smarty_tpl->getVariable('confirmation')->value){?>
			<p class="success">
				<?php echo smartyTranslate(array('s'=>'Your personal information has been successfully updated.'),$_smarty_tpl);?>

				<?php if ($_smarty_tpl->getVariable('pwd_changed')->value){?><br /><?php echo smartyTranslate(array('s'=>'Your password has been sent to your e-mail:'),$_smarty_tpl);?>
 <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('email')->value,'htmlall','UTF-8');?>
<?php }?>
			</p>
		<?php }else{ ?>
			<div id="account_error_container" class="error_container">
				<h4>There are errors:</h4>
				<ol>
					<li><label for="customer_firstname" class="error">Please enter your first name</label></li>
					<li><label for="customer_lastname" class="error">Please enter your last name</label></li>
					<li><label for="email" class="error">Please enter a valid email</label></li>
					<li><label for="passwd" class="error">Please select a password</label></li>
				</ol>
			</div>
			<form id="account_form" action="<?php echo $_smarty_tpl->getVariable('base_dir_ssl')->value;?>
account" method="post" class="std" style="padding-top:15px;">
				<fieldset>
				<h1 style="padding:10px 0;text-align:center;border-bottom:1px dashed #cacaca">About You</h1>
					<p class="radio">
						<span style="font-size:13px;margin-right:5px;"><?php echo smartyTranslate(array('s'=>'Gender'),$_smarty_tpl);?>
</span>
						<input type="radio" id="id_gender1" name="id_gender" value="1" <?php if ($_POST['id_gender']==1||!$_POST['id_gender']){?>checked="checked"<?php }?> />
						<label for="id_gender1"><?php echo smartyTranslate(array('s'=>'Mr.'),$_smarty_tpl);?>
</label>
						<input type="radio" id="id_gender2" name="id_gender" value="2" <?php if ($_POST['id_gender']==2){?>checked="checked"<?php }?> />
						<label for="id_gender2"><?php echo smartyTranslate(array('s'=>'Ms.'),$_smarty_tpl);?>
</label>
					</p>
					<p class="required text">
						<label for="firstname"><?php echo smartyTranslate(array('s'=>'First name'),$_smarty_tpl);?>
<sup>*</sup></label>
						<input type="text" class="text required" id="firstname" name="firstname" value="<?php echo $_POST['firstname'];?>
" style="width:236px"/>
					</p>
					<p class="required text">
						<label for="lastname"><?php echo smartyTranslate(array('s'=>'Last name'),$_smarty_tpl);?>
<sup>*</sup></label>
						<input type="text" class="text required" name="lastname" id="lastname" value="<?php echo $_POST['lastname'];?>
" style="width:236px"/>
					</p>
					<p class="required text">
						<label for="email"><?php echo smartyTranslate(array('s'=>'E-mail'),$_smarty_tpl);?>
<sup>*</sup></label>
						<input type="text" class="text required email" name="email" id="email" value="<?php echo $_POST['email'];?>
" style="width:236px"/>
					</p>
					<p class="required text">
						<label for="old_passwd"><?php echo smartyTranslate(array('s'=>'Current password'),$_smarty_tpl);?>
<sup>*</sup></label>
						<input type="password" class="text required" name="old_passwd" id="old_passwd" style="width:236px"/>
					</p>
					<p class="password">
						<label for="passwd"><?php echo smartyTranslate(array('s'=>'Password'),$_smarty_tpl);?>
</label>
						<input type="password" class="text" name="passwd" id="passwd" />
					</p>
					<p class="password">
						<label for="confirmation"><?php echo smartyTranslate(array('s'=>'Confirmation'),$_smarty_tpl);?>
</label>
						<input type="password" class="text" name="confirmation" id="confirmation" />
					</p>
					<p class="select">
						<label><?php echo smartyTranslate(array('s'=>'Birthday'),$_smarty_tpl);?>
</label>
						<select name="days" id="days" style="width:50px;font-size:13px;height:24px;padding:0">
							<option value="">-</option>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('days')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
?>
								<option value="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['v']->value,'htmlall','UTF-8');?>
" <?php if (($_smarty_tpl->getVariable('sl_day')->value==$_smarty_tpl->tpl_vars['v']->value)){?>selected="selected"<?php }?>><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['v']->value,'htmlall','UTF-8');?>
&nbsp;&nbsp;</option>
							<?php }} ?>
						</select>
						<select id="months" name="months" style="width:80px;font-size:13px;height:24px;padding:0">
							<option value="">-</option>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('months')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
								<option value="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['k']->value,'htmlall','UTF-8');?>
" <?php if (($_smarty_tpl->getVariable('sl_month')->value==$_smarty_tpl->tpl_vars['k']->value)){?>selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>($_smarty_tpl->tpl_vars['v']->value)),$_smarty_tpl);?>
&nbsp;</option>
							<?php }} ?>
						</select>
						<select id="years" name="years" style="width:60px;font-size:13px;height:24px;padding:0">
							<option value="">-</option>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('years')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
?>
								<option value="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['v']->value,'htmlall','UTF-8');?>
" <?php if (($_smarty_tpl->getVariable('sl_year')->value==$_smarty_tpl->tpl_vars['v']->value)){?>selected="selected"<?php }?>><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['v']->value,'htmlall','UTF-8');?>
&nbsp;&nbsp;</option>
							<?php }} ?>
						</select>
					</p>
					<?php if ($_smarty_tpl->getVariable('need_identification_number')->value){?>
					<p class="required text">
						<label for="dni"><?php echo smartyTranslate(array('s'=>'Identication number'),$_smarty_tpl);?>
</label>
						<input type="text" class="text" name="dni" id="dni" value="<?php if (isset($_POST['dni'])){?><?php echo $_POST['dni'];?>
<?php }?>" />
						<span class="form_info"><?php echo smartyTranslate(array('s'=>'DNI / NIF / NIE'),$_smarty_tpl);?>
</span>
					</p>
					<?php }?>
					<p class="checkbox">
						<input style="margin-left:30%" type="checkbox" id="newsletter" name="newsletter"  <?php if ($_POST['newsletter']==0){?> checked="checked" value="0" <?php }else{ ?> value="1" <?php }?> />
						<label for="newsletter"><?php echo smartyTranslate(array('s'=>'Sign up for our newsletter'),$_smarty_tpl);?>
</label>
					</p>
					<p class="required required_desc" style="width:30%; text-align:right;"><sup>*</sup><?php echo smartyTranslate(array('s'=>'Required field'),$_smarty_tpl);?>
</p>
					<p class="submit">
						<input type="submit" class="button" name="submitIdentity" value="<?php echo smartyTranslate(array('s'=>'Save'),$_smarty_tpl);?>
" style="width:200px"/>
					</p>
				</fieldset>
			</form>
			
		<?php }?>
		
		
	</div>
</div>
