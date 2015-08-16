<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 14:01:43
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/order-payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12691179665562ddefe41553-35455434%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '293110c0f921dd269186cb801f0e69f0151747f7' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/order-payment.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12691179665562ddefe41553-35455434',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/tools/smarty/plugins/modifier.escape.php';
?>
<script>
var youPayDefault = <?php echo $_smarty_tpl->getVariable('total_price')->value;?>
;

</script>


<script>
	$(document).ready(function()
	{
		var buildUrl = function(url, key, value) {
			var params = '';
			if( url.split("?")[1] != undefined)
    				params = url.split("?")[1].split("&");
			var newparams = [];
			if( Object.prototype.toString.call( params ) === '[object Array]' && params[0] != '') {
				var found = false;
				for(i=0;i<params.length;i++) {
					var param = params[i];
					var kv = param.split('=');
					if( kv[0] != key ) {
						var newkv = kv.join('=');
						newparams.push(newkv);
					} else {
						found = true;
						newparams.push(key+"="+value);
					}
				}
				if( !found ) {
					newparams.push(key+"="+value);
				}
				newparams = newparams.join("&");
			} else {
				newparams.push(key+"="+value);
			}
			var url = window.location.protocol + "//" + document.location.host + document.location.pathname + "?" + newparams;
			return url;
		}

		$("#donation").click(function(){
			var url = buildUrl(window.location.href,"step",3);
			if($(this).is(':checked'))
				window.location.href = buildUrl(url,"donate","yes");
			else
				window.location.href = buildUrl(url, "donate","no");
		});
		$("#donate_btn").click(function(){
			var amount = parseInt($("#donation_amount").val());
			if( isNaN(amount) || amount < 1) {
				alert("Minimum value needed for donation is atleast 1");
				return false;
			}
			var url = buildUrl(window.location.href,"step",3);
			window.location.href = buildUrl(url,"donate_amt",amount);
		});
		$('#select_pay_button').click(function () {
			var selectedMethod =  $("input[name=payMethod]:checked").val();
			if(selectedMethod == "EBS")
				$('#EBS_form').submit();
			else if(selectedMethod == "PayPal")
				$('#paypal_form').submit();
			else if(selectedMethod == "payu")
				$('#payu_form').submit();
			else if(selectedMethod == "twoco")
				$('#twoco-form').submit();
			else if(selectedMethod == "mb")
				$('#mb-form').submit();
			else if(selectedMethod == "wire")
			{
				window.location = $('#wire-transfer-link').attr('href');
			}
		});
	});
	
</script>

<div id="co_content">
	<div id="co_left_column">
		<script type="text/javascript">
			// <![CDATA[
			var baseDir = '<?php echo $_smarty_tpl->getVariable('base_dir_ssl')->value;?>
';
			var currencySign = '<?php echo html_entity_decode($_smarty_tpl->getVariable('currencySign')->value,2,"UTF-8");?>
';
			var currencyRate = '<?php echo floatval($_smarty_tpl->getVariable('currencyRate')->value);?>
';
			var currencyFormat = '<?php echo intval($_smarty_tpl->getVariable('currencyFormat')->value);?>
';
			var currencyBlank = '<?php echo intval($_smarty_tpl->getVariable('currencyBlank')->value);?>
';
			var txtProduct = "<?php echo smartyTranslate(array('s'=>'product'),$_smarty_tpl);?>
";
			var txtProducts = "<?php echo smartyTranslate(array('s'=>'products'),$_smarty_tpl);?>
";
			// ]]>
		</script>
		<?php $_smarty_tpl->tpl_vars['current_step'] = new Smarty_variable('payment', null, null);?>
		<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./order-steps.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
		<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./errors.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
		
		<div id="payment_confirm" style="margin:20px 160px;float:left">
			<h1 style="border-bottom:1px dashed #cacaca;padding:10px;text-align:center">Order Summary</h1>
	   		<div id="order_summary" style="float:left;padding:0 0 0px 0;width:650px;border-bottom:1px dashed #cacaca;">
	   		<div id="order_summary_content" class="rht_box_info" style="padding:20px 30px;float:left">
		   		<table width="173" style="width:173px">
 		   			<tbody>
			   			<?php if ($_smarty_tpl->getVariable('productNumber')->value>0){?>
			   			<tr>
			   				<td class="row_title">Total Items</td>
			   				<td>:</td>
			   				<td class="row_val"><?php echo $_smarty_tpl->getVariable('productNumber')->value;?>
</td>
			   			</tr>
			   			<tr>
			   				<td class="row_title">Items Total</td>
			   				<td>:</td>
			   				<td class="row_val"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('total_products_wt')->value),$_smarty_tpl);?>
</td>
			   			</tr>
						<?php if ($_smarty_tpl->getVariable('donation_amount')->value>0){?>
						<tr>
							<td class="row_title" style="color:#a43a21; font-weight:bold">Donation</td>
							<td>:</td>
							<td class="row_val"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('donation_amount')->value),$_smarty_tpl);?>
</td>
						</tr>
						<?php }?>
			   			<tr>
							<td class="row_title">Discounts</td>
							<td>:</td>
							<td class="row_val"><span class="ajax_cart_discounts"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('total_discounts')->value),$_smarty_tpl);?>
</span></td>
						</tr>
			   			<tr>
			   				<td class="row_title">Shipping</td>
			   				<td>:</td>
			   				<?php if ($_smarty_tpl->getVariable('shippingCost')->value>0){?>
			   					<td class="row_val"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('shippingCost')->value),$_smarty_tpl);?>
</td>
			   				<?php }else{ ?>
			   					<td class="row_val"><span style="padding:0px;"> FREE</span></td>
			   				<?php }?>
			   			</tr>
			   			<tr><td height="5px" colspan="3"></td></tr>
			   			<tr>
			   				<td class="row_title"><span style="font-weight:bold">Order Total</span></td>
			   				<td>:</td>
			   				<td class="row_val"><span id="order-total" style="font-weight:bold"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('total_price')->value),$_smarty_tpl);?>
</span></td>
			   			</tr>
			   			<tr><td height="25px" colspan="3"></td></tr>				
						<tr>
							<td colspan="3">
								<a href="./help-an-orphan" target="__blank"><img src="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
giftco.jpg"/></a>
								
								<div class="clearfix">
									<?php if ($_smarty_tpl->getVariable('donate')->value=="yes"){?>
										<input type="checkbox" value="yes" checked="checked" id="donation" name="donation">Help The Kids at Sneha Nilaya. Add More or Opt Out</input>
									<?php }else{ ?>
										<input type="checkbox" value="no"  id="donation" name="donation">Help The Kids at Sneha Nilaya. Add More or Opt Out</input>
									<?php }?>
								</div>
								<?php if ($_smarty_tpl->getVariable('donate')->value=="yes"){?>
								<div class="clearfix" style="margin-top:4px">
									<input align="center" style="text-align:center;font-size:12px; width:50px;height:29px; float:left" type="text" id="donation_amount" name="donation_amount" value="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('donation_amount')->value;?>
<?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>
"/>
									<span style="padding-top:15px;float:left;font-size:12px; display:inline-block; width:30px; text-align:right"><?php ob_start();?><?php echo $_smarty_tpl->getVariable('mycurr')->value->iso_code;?>
<?php $_tmp3=ob_get_clean();?><?php echo $_tmp3;?>
</span>
									<input type="button" id="donate_btn" class="exclusive_large" value="Donate" style="float:right;width:70px;background-color:#a43a21"></input>
								</div>
								<?php }?>
							</td>
						</tr>
			   			<?php }?>
					</tbody>
				</table>
	   		</div>
	   		<?php if ($_smarty_tpl->getVariable('delivery')->value){?>
		   	<div class="co_rht_box">
		   		<div id="cop_delivery_address" class="address_card_selected">
		   			<div class="address_title underline" style="padding:3px 15px;display:block;">
						Delivery Address
					</div>
						<ul class="address item">
							<li class="address_name"><?php echo addslashes($_smarty_tpl->getVariable('delivery')->value->firstname);?>
 <?php echo addslashes($_smarty_tpl->getVariable('delivery')->value->lastname);?>
</li>
							<li class="address_address1"><?php echo addslashes($_smarty_tpl->getVariable('delivery')->value->address1);?>
</li>
							<li class="address_city"><?php echo addslashes($_smarty_tpl->getVariable('delivery')->value->city);?>
</li>
							<?php if (isset($_smarty_tpl->getVariable('delivery',null,true,false)->value->state)){?>
							    <li class="address_pincode"><?php echo addslashes($_smarty_tpl->getVariable('delivery')->value->state);?>
</li>
							<?php }?>
							<li class="address_pincode"><?php echo addslashes($_smarty_tpl->getVariable('delivery')->value->postcode);?>
</li>
							<li class="address_pincode"><?php echo addslashes($_smarty_tpl->getVariable('delivery')->value->country);?>
</li>
							
							<li class="address_country">Phone: <?php echo addslashes($_smarty_tpl->getVariable('delivery')->value->phone_mobile);?>
</li>
						</ul>
						<span class="updateaddress"><a class="address_update" href="<?php echo $_smarty_tpl->getVariable('base_dir_ssl')->value;?>
order.php?step=1&id_address=<?php echo intval($_smarty_tpl->getVariable('delivery')->value->id);?>
" title="<?php echo smartyTranslate(array('s'=>'Update'),$_smarty_tpl);?>
" ><?php echo smartyTranslate(array('s'=>'Update'),$_smarty_tpl);?>
</a></span>
				</div>
		   	</div>
		   	<?php }?>
		   	<?php if ($_smarty_tpl->getVariable('invoice')->value){?>
		   	<div class="co_rht_box">
		   		<div id="cop_delivery_address" class="address_card_selected">
		   			<div class="address_title underline" style="padding:3px 15px;display:block;">
						Billing Address
					</div>
						<ul class="address item">
							<li class="address_name"><?php echo addslashes($_smarty_tpl->getVariable('invoice')->value->firstname);?>
 <?php echo addslashes($_smarty_tpl->getVariable('invoice')->value->lastname);?>
</li>
							<li class="address_address1"><?php echo addslashes($_smarty_tpl->getVariable('invoice')->value->address1);?>
</li>
							<li class="address_city"><?php echo addslashes($_smarty_tpl->getVariable('invoice')->value->city);?>
</li>
							<?php if (isset($_smarty_tpl->getVariable('invoice',null,true,false)->value->state)){?>
							    <li class="address_pincode"><?php echo addslashes($_smarty_tpl->getVariable('invoice')->value->state);?>
</li>
							<?php }?>
							<li class="address_pincode"><?php echo addslashes($_smarty_tpl->getVariable('invoice')->value->postcode);?>
</li>
							<li class="address_pincode"><?php echo addslashes($_smarty_tpl->getVariable('invoice')->value->country);?>
</li>
							
							<li class="address_country">Phone: <?php echo addslashes($_smarty_tpl->getVariable('invoice')->value->phone_mobile);?>
</li>
						</ul>
						<span class="updateaddress"><a class="address_update" href="<?php echo $_smarty_tpl->getVariable('base_dir_ssl')->value;?>
order.php?step=2&id_address=<?php echo intval($_smarty_tpl->getVariable('invoice')->value->id);?>
" title="<?php echo smartyTranslate(array('s'=>'Update'),$_smarty_tpl);?>
" ><?php echo smartyTranslate(array('s'=>'Update'),$_smarty_tpl);?>
</a></span>
				</div>
		   	</div>
		   	<?php }?>
                        <?php if (isset($_smarty_tpl->getVariable('curr_conversion_msg',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('curr_conversion_msg',null,true,false)->value)){?>
                            <div class="curr_conversion_msg">
                                <div class="message"><?php echo $_smarty_tpl->getVariable('curr_conversion_msg')->value;?>
</div>
                            </div>
                        <?php }?>
		   	</div>
		   	<div style="border-bottom:1px dashed #cacaca;clear:both;padding:10px 0">
		   		<?php if (isset($_smarty_tpl->getVariable('special_instructions',null,true,false)->value)){?>
		   		<div>
		   			<p style="font-family:Abel; font-size:15px">
   						<b>Special Instructions</b>
   					</p>
   					<p style="font-style:italic; color:#939393">
						<?php if (isset($_smarty_tpl->getVariable('special_instructions',null,true,false)->value)){?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('special_instructions')->value,'htmlall','UTF-8');?>
<?php }?>
   						<a class="add_instructions" class="span_link" style="padding:0px 10px;color:green" href="#special-instructions-popup" rel="nofollow">[EDIT INSTRUCTIONS]</a>
   					</p>
   					
   				</div>
   				<?php }else{ ?>
   					<p>
   						No special instructions.
   						<a class="add_instructions button" style="display:inline-block" href="#special-instructions-popup" rel="nofollow">+ ADD INSTRUCTIONS</a>
   					</p>
   				<?php }?>
		   	</div>
		   	<div id="HOOK_PAYMENT" style="float:left;padding-top:10px;">
		   		<p style="font-family:Abel; font-size:15px"><b>Select method of payment</b></p>
				<?php echo $_smarty_tpl->getVariable('HOOK_PAYMENT')->value;?>

			</div>
		   	<p class="cart_navigation" style="clear:both;border-top:1px dashed #cacaca;padding-top:20px;width:100%;float:left;" id="continue_btn">
				<input type="button" style="margin:0px 60px 10px 0px;" id="select_pay_button" class="exclusive_large" value="Continue Payment >>"></input>
			</p>
	   	</div>
			
		</div>
	</div>
	
</div>

<div id="special-instructions-popup" style="border:1px dashed #cacaca;padding:10px;width:500px;display:none">
   	<form action="<?php echo $_smarty_tpl->getVariable('base_dir_ssl')->value;?>
order.php?step=3" method="post" id="special_istructions_form" >
   		<p style="font-size:18px;font-family:Abel;padding:10px 0px;">SPECIAL INSTRUCTIONS FOR YOUR ORDER</p>
   		<p id="instructions_panel">
   			<textarea value="<?php if (isset($_smarty_tpl->getVariable('special_instructions',null,true,false)->value)){?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('special_instructions')->value,'htmlall','UTF-8');?>
<?php }?>" name="special_instructions" id="special_instructions" type="text" rows="4" class="text required" style="width:500px;font-size:13px"><?php if (isset($_smarty_tpl->getVariable('special_instructions',null,true,false)->value)){?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('special_instructions')->value,'htmlall','UTF-8');?>
<?php }?></textarea>
   			<input type="submit" name="submit_instructions" id="submit_instructions" class="button" value="Save Instructions"></input>
   		</p>
   	</form>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$('.add_instructions').fancybox( {
		autoSize: true
	} );
} );
</script>
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
paramList['lead_step'] = 'Payement_Page';
</script>
<script type="text/javascript">
    try { sokrati.trackSaleParams("0","0","<?php echo $_smarty_tpl->getVariable('total_price')->value;?>
", "<?php echo $_smarty_tpl->getVariable('productNumber')->value;?>
",paramList); }
    catch(err) { }
</script>

