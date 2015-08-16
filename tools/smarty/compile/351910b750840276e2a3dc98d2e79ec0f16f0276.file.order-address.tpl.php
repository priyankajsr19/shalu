<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 14:01:21
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/order-address.tpl" */ ?>
<?php /*%%SmartyHeaderCode:483409595562ddd9240419-70753855%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '351910b750840276e2a3dc98d2e79ec0f16f0276' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/order-address.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '483409595562ddd9240419-70753855',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/tools/smarty/plugins/modifier.escape.php';
?><script type="text/javascript" charset="utf-8">
// <![CDATA[
var idSelectedCountry = <?php if (isset($_POST['id_country'])){?><?php echo intval($_POST['id_country']);?>
<?php }else{ ?><?php if (isset($_smarty_tpl->getVariable('address',null,true,false)->value->id_country)){?><?php echo intval($_smarty_tpl->getVariable('address')->value->id_country);?>
<?php }else{ ?>false<?php }?><?php }?>;
var idSelectedState = <?php if (isset($_POST['id_state'])){?><?php echo intval($_POST['id_state']);?>
<?php }else{ ?><?php if (isset($_smarty_tpl->getVariable('address',null,true,false)->value->id_state)){?><?php echo intval($_smarty_tpl->getVariable('address')->value->id_state);?>
<?php }else{ ?>false<?php }?><?php }?>;
countries = new Array();
countriesNeedIDNumber = new Array();
countriesNeedZipCode = new Array();
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
$(function(){
	$('.id_state option[value=<?php if (isset($_POST['id_state'])){?><?php echo $_POST['id_state'];?>
<?php }else{ ?><?php if (isset($_smarty_tpl->getVariable('address',null,true,false)->value->id_state)){?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('address')->value->id_state,'htmlall','UTF-8');?>
<?php }?><?php }?>]').attr('selected', 'selected');
});

<?php if (isset($_smarty_tpl->getVariable('id_address',null,true,false)->value)&&isset($_smarty_tpl->getVariable('selected_country',null,true,false)->value)){?>
	var selectedCountry = <?php if (isset($_smarty_tpl->getVariable('selected_country',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('selected_country')->value;?>
<?php }else{ ?>false<?php }?>;
<?php }else{ ?>
var selectedCountry = idSelectedCountry;
<?php }?>
<?php if (isset($_smarty_tpl->getVariable('id_address',null,true,false)->value)&&isset($_smarty_tpl->getVariable('selected_state',null,true,false)->value)&&$_smarty_tpl->getVariable('selected_state')->value){?>
	var selectedState = <?php echo $_smarty_tpl->getVariable('selected_state')->value;?>
;
<?php }else{ ?>
	var selectedState = idSelectedState;
<?php }?>
	$(document).ready(function(){
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
	});
	




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

		/*$('#country-selector').change(function(){
			//$(location).reload();
		});*/
	});

	(function($){
	    $(function(){
	      $('#id_country').selectToAutocomplete();
	    });
	  })(jQuery);

//]]>
</script>

<div id="co_content">
	<div id="co_left_column">
		<div>
			<?php $_smarty_tpl->tpl_vars['current_step'] = new Smarty_variable('address', null, null);?>
			<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./order-steps.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
		</div>
		<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./errors.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
		
		<div style="width:210px; float:right;"></div>
		<div id="new_address" class="new_address" >
			<div id="new_address_form" style="display:<?php if ((isset($_smarty_tpl->getVariable('addresses',null,true,false)->value)&&count($_smarty_tpl->getVariable('addresses')->value)>0)&&!((isset($_smarty_tpl->getVariable('errors',null,true,false)->value)&&$_smarty_tpl->getVariable('errors')->value)||(isset($_smarty_tpl->getVariable('id_address',null,true,false)->value)&&$_smarty_tpl->getVariable('id_address')->value))){?>none<?php }else{ ?>block<?php }?>;width:650px;margin:auto;">
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
				<form id="form_new_address" action="<?php echo $_smarty_tpl->getVariable('base_dir_ssl')->value;?>
order.php" method="post" class="std">
					<fieldset>
						<h1 style="padding:10px 0; text-align:center;border-bottom:1px dashed #cacaca">Shipping Address</h1>
						<div style="padding: 10px 0;text-align:center">
							<span id="new_shipaddress_label" style="display:block">Please enter a shipping address</span>
							<span style="display:block">Your order will be delivered here</span>
						</div>
						<p class="required text">
						<input type="hidden" name="token" value="<?php echo $_smarty_tpl->getVariable('token')->value;?>
" />
						<input type="hidden" name="id_carrier" value="<?php echo $_smarty_tpl->getVariable('id_carrier')->value;?>
" />
							<label for="firstname"><?php echo smartyTranslate(array('s'=>'First name'),$_smarty_tpl);?>
<sup>*</sup></label>
							<input class="text required" type="text" name="firstname" id="firstname" value="<?php if (isset($_POST['firstname'])){?><?php echo $_POST['firstname'];?>
<?php }else{ ?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('address')->value->firstname,'htmlall','UTF-8');?>
<?php }?>" />
						</p>
						<p class="required text">
							<label for="lastname"><?php echo smartyTranslate(array('s'=>'Last name'),$_smarty_tpl);?>
<sup>*</sup></label>
							<input class="text required" type="text" id="lastname" name="lastname" value="<?php if (isset($_POST['lastname'])){?><?php echo $_POST['lastname'];?>
<?php }else{ ?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('address')->value->lastname,'htmlall','UTF-8');?>
<?php }?>" />
						</p>
						<p class="required text">
							<label for="address1"><?php echo smartyTranslate(array('s'=>'Address'),$_smarty_tpl);?>
<sup>*</sup></label>
							<textarea class="text required" rows="4" type="text" id="address1" name="address1" value="<?php if (isset($_POST['address1'])){?><?php echo $_POST['address1'];?>
<?php }else{ ?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('address')->value->address1,'htmlall','UTF-8');?>
<?php }?>"><?php if (isset($_POST['address1'])){?><?php echo $_POST['address1'];?>
<?php }else{ ?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('address')->value->address1,'htmlall','UTF-8');?>
<?php }?></textarea>
						</p>
						<p class="required text">
							<label for="city"><?php echo smartyTranslate(array('s'=>'City'),$_smarty_tpl);?>
<sup>*</sup></label>
							<input class="text required" type="text" name="city" id="city" value="<?php if (isset($_POST['city'])){?><?php echo $_POST['city'];?>
<?php }else{ ?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('address')->value->city,'htmlall','UTF-8');?>
<?php }?>" maxlength="64" />
						</p>
						<p class="required text">
							<label for="postcode"><?php echo smartyTranslate(array('s'=>'Post/Zip code'),$_smarty_tpl);?>
<sup>*</sup></label>
							<input class="text required" type="text" id="postcode" name="postcode" value="<?php if (isset($_POST['postcode'])){?><?php echo $_POST['postcode'];?>
<?php }else{ ?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('address')->value->postcode,'htmlall','UTF-8');?>
<?php }?>" />
						</p>
						<div class="required text">
							<label for="id_country"><?php echo smartyTranslate(array('s'=>'Country'),$_smarty_tpl);?>
</label>
							<select name="id_country" id="id_country" autofocus="autofocus" autocorrect="off" autocomplete="off" class="id_country">
							    <option value="0" selected="selected"></option>
                                <?php  $_smarty_tpl->tpl_vars['country'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('country_names')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['country']->key => $_smarty_tpl->tpl_vars['country']->value){
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['country']->value['id_country'];?>
" data-alternative-spellings="<?php echo $_smarty_tpl->tpl_vars['country']->value['alternate_name'];?>
" data-relevancy-booster="<?php echo $_smarty_tpl->tpl_vars['country']->value['boost'];?>
"><?php echo $_smarty_tpl->tpl_vars['country']->value['country'];?>
</option>
								<?php }} ?>
							</select>
						</div>
						
						<p class="required id_state select">
							<label for="id_state"><?php echo smartyTranslate(array('s'=>'State'),$_smarty_tpl);?>
<sup>*</sup></label>
							<select name="id_state" id="id_state">
								<option value="">-</option>
							</select>
						</p>
						<p class="required text">
							<label for="phone_mobile"><?php echo smartyTranslate(array('s'=>'Phone'),$_smarty_tpl);?>
<sup>*</sup></label>
							<input class="text required" type="text" id="phone_mobile" name="phone_mobile" value="<?php if (isset($_POST['phone_mobile'])){?><?php echo $_POST['phone_mobile'];?>
<?php }else{ ?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('address')->value->phone_mobile,'htmlall','UTF-8');?>
<?php }?>" />
							<span style="color:#a6a6a6;float:right; display:inline-block;padding:0 0 0 15px;width:125px;text-align:left">We'll contact you here for delivery confirmations</span>
						</p>
						<p class="required text" id="adress_alias" style="display:none;">
							<label for="alias" ><?php echo smartyTranslate(array('s'=>'Address book title'),$_smarty_tpl);?>
<sup>*</sup></label>
							<input class="text" type="text" id="alias" name="alias" value="<?php if (isset($_POST['alias'])){?><?php echo $_POST['alias'];?>
<?php }elseif($_smarty_tpl->getVariable('address')->value->alias){?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('address')->value->alias,'htmlall','UTF-8');?>
<?php }elseif(isset($_smarty_tpl->getVariable('select_address',null,true,false)->value)){?><?php }else{ ?><?php echo smartyTranslate(array('s'=>'Address'),$_smarty_tpl);?>
<?php echo count($_smarty_tpl->getVariable('addresses')->value)+1;?>
<?php }?>" />
						</p>
						<p class="required" id="required_desc2" ><span style="width:30%;text-align:right;"><sup>*</sup><?php echo smartyTranslate(array('s'=>'Required field'),$_smarty_tpl);?>
</span></p>
					</fieldset>
					
					<p class="submit2" style="padding-left:0px">
					<input type="hidden" class="hidden" name="step" value="2" />
						<?php if (isset($_smarty_tpl->getVariable('mod',null,true,false)->value)){?><input type="hidden" name="mod" value="<?php echo $_smarty_tpl->getVariable('mod')->value;?>
" /><?php }?>
						<input type="hidden" name="order_add_address" value="1" />
						<input type="hidden" name="id_carrier" value="<?php echo $_smarty_tpl->getVariable('id_carrier')->value;?>
" />
						<input type="hidden" name="id_address" id="id_address" value="<?php echo $_smarty_tpl->getVariable('id_address')->value;?>
" />
						<input type="hidden" name="address_update" id="id_address" value="1" />
						<input style="margin:0px 30px;float:right" type="submit" name="submitAddress" id="submitAddress" value="<?php echo smartyTranslate(array('s'=>'Save and Continue >>'),$_smarty_tpl);?>
" class="button" />
						<?php if ((isset($_smarty_tpl->getVariable('addresses',null,true,false)->value)&&count($_smarty_tpl->getVariable('addresses')->value)>0)&&!(isset($_smarty_tpl->getVariable('errors',null,true,false)->value)&&$_smarty_tpl->getVariable('errors')->value)){?><input style="margin:0px 30px;float:right;width:180px;" type="button" class="button_secondary" id="closeAddressBtn" value="<?php echo smartyTranslate(array('s'=>'<< Choose from existing'),$_smarty_tpl);?>
" class="button" /><?php }?>
						
					</p>
				
				</form>
				<div style="padding-top:30px;"></div>
			</div>
			
		</div>
		<?php if ((isset($_smarty_tpl->getVariable('addresses',null,true,false)->value)&&count($_smarty_tpl->getVariable('addresses')->value)>0)&&!(isset($_smarty_tpl->getVariable('errors',null,true,false)->value)&&$_smarty_tpl->getVariable('errors')->value)){?>
			<div id="add_button_wrapper" style="width:100%">
				<span id="prev_shipaddress_label" style="width:570px;display:block;float:left;clear:both;padding:5px 10px;font-size:15px;<?php if (isset($_smarty_tpl->getVariable('id_address',null,true,false)->value)&&$_smarty_tpl->getVariable('id_address')->value){?>display:none<?php }?>">Please choose a shipping address or enter a new address.</span> 
				
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
									$('#prev_shipaddress_label').hide();
								} else {
									$("#new_address_form").hide();
								}
							});
							$('#closeAddressBtn').click(function () {
									$("#new_address_form").slideUp();
									$("#address_wrapper").show();
									$('#new_address_card').show();
									$('#prev_shipaddress_label').show();
									$('.address_card').show();
							});

							$('.select_address_link').click(function(e){
								e.preventDefault();
								$('#selected_delivery_address').val($(this).attr('rel'));
								$('#saved_addresses_form').submit();
							});
						});
						//]]
					</script>
				
			</div>
		<?php }?>	
		<form action="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('order.php',true);?>
" method="post" id="saved_addresses_form">
				<?php if (isset($_smarty_tpl->getVariable('addresses',null,true,false)->value)&&count($_smarty_tpl->getVariable('addresses')->value)>0){?>
					<div id="address_wrapper">
						<div id="new_address_card" class="new_address_card" style="cursor:pointer;display:<?php if (((isset($_smarty_tpl->getVariable('errors',null,true,false)->value)&&$_smarty_tpl->getVariable('errors')->value)||(isset($_smarty_tpl->getVariable('id_address',null,true,false)->value)&&$_smarty_tpl->getVariable('id_address')->value))){?>none<?php }?>">
							<span class="new_address_title">Ship to a new address</span>
						</div>
						<?php  $_smarty_tpl->tpl_vars['address'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('addresses')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['address']->key => $_smarty_tpl->tpl_vars['address']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['address']->key;
?>
						<div id="address_link_<?php echo intval($_smarty_tpl->tpl_vars['address']->value['id_address']);?>
" class="selectable address_card" style="<?php if (isset($_smarty_tpl->getVariable('id_address',null,true,false)->value)&&$_smarty_tpl->getVariable('id_address')->value&&$_smarty_tpl->getVariable('id_address')->value==$_smarty_tpl->tpl_vars['address']->value['id_address']){?>display:none<?php }?>">
							<div class="address_title underline" style="padding:3px 15px;display:block;">
							<span style="font-size:12px;"><a class="address_update" href="<?php echo $_smarty_tpl->getVariable('base_dir_ssl')->value;?>
order.php?step=1&id_address=<?php echo intval($_smarty_tpl->tpl_vars['address']->value['id_address']);?>
" title="<?php echo smartyTranslate(array('s'=>'Update'),$_smarty_tpl);?>
" rel="address_link_<?php echo intval($_smarty_tpl->tpl_vars['address']->value['id_address']);?>
">[<?php echo smartyTranslate(array('s'=>'Update'),$_smarty_tpl);?>
]</a></span>
							</div>
							<a rel="<?php echo intval($_smarty_tpl->tpl_vars['address']->value['id_address']);?>
" class="select_address_link">
								<ul class="address item" id="address_<?php echo intval($_smarty_tpl->tpl_vars['address']->value['id_address']);?>
">
									<li style="display:none"><?php echo addslashes($_smarty_tpl->tpl_vars['address']->value['alias']);?>
</li>
									<li class="address_name"><?php echo addslashes($_smarty_tpl->tpl_vars['address']->value['firstname']);?>
 <?php echo addslashes($_smarty_tpl->tpl_vars['address']->value['lastname']);?>
</li>
									<li class="first_name" style="display:none"><?php echo addslashes($_smarty_tpl->tpl_vars['address']->value['firstname']);?>
</li>
									<li class="last_name" style="display:none"><?php echo addslashes($_smarty_tpl->tpl_vars['address']->value['lastname']);?>
</li>
									<li class="address_address1"><?php echo addslashes($_smarty_tpl->tpl_vars['address']->value['address1']);?>
</li>
									<li class="address_city"><?php echo addslashes($_smarty_tpl->tpl_vars['address']->value['city']);?>
</li>
									<?php if ($_smarty_tpl->tpl_vars['address']->value['state']!=''){?>
									<li class="address_state"><?php echo addslashes($_smarty_tpl->tpl_vars['address']->value['state']);?>
</li>
									<?php }?>
									<li class="address_pincode"><?php echo addslashes($_smarty_tpl->tpl_vars['address']->value['postcode']);?>
</li>
									<li class="address_country"><?php echo addslashes($_smarty_tpl->tpl_vars['address']->value['country']);?>
</li>
									<li class="address_phone">Phone: <?php echo addslashes($_smarty_tpl->tpl_vars['address']->value['phone_mobile']);?>
</li>
									
								</ul>
								<span class="clicktoship">Click to ship here</span>
							</a>
						</div>
						<?php }} ?>
				</div>
				<?php }?>
		<br class="clear" />
	
		<div style="width:700px;margin:auto;">	
			<p class="cart_navigation submit">
				<input type="hidden" class="hidden" name="step" value="2" />
				<input type="hidden" class="hidden" name="id_address_delivery" value="" id="selected_delivery_address"/>
				<input type="hidden" name="back" value="<?php echo $_smarty_tpl->getVariable('back')->value;?>
" />
			</p>
		</div>
		</form>
	</div>	
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
paramList['lead_step'] = 'ShippingAddressPage';
</script>
<script type="text/javascript">
    try { sokrati.trackSaleParams("0","0","<?php echo $_smarty_tpl->getVariable('total_price')->value;?>
", "<?php echo $_smarty_tpl->getVariable('productNumber')->value;?>
",paramList); }
    catch(err) { }
</script>
