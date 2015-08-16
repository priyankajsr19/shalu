<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 14:02:08
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/modules/bankwire/payment_execution.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1436861735562de08b42ea3-13563291%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8c4f12be06f9df62abac9a781ab462d65d65aba7' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/modules/bankwire/payment_execution.tpl',
      1 => 1431660622,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1436861735562de08b42ea3-13563291',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_smarty_tpl->tpl_vars['current_step'] = new Smarty_variable('payment', null, null);?>
<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./order-steps.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<?php if ($_smarty_tpl->getVariable('nbProducts')->value<=0){?>
	<p class="warning"><?php echo smartyTranslate(array('s'=>'Your shopping cart is empty.'),$_smarty_tpl);?>
</p>
<?php }else{ ?>

<div id="co_content">
	<div id="co_left_column">
		<div id="payment_confirm" style="margin:20px 160px;float:left">
			<h1 style="border-bottom:1px dashed #cacaca;padding:10px;text-align:center">Bank Transfer Payment</h1>
			<form action="<?php echo $_smarty_tpl->getVariable('this_path_ssl')->value;?>
validation.php" method="post">
			<p>
				You have chosen to pay by wire transfer. Your order will be processed after the payment is completed.
				<br/><br />
			</p>
			<p>
				<?php if (count($_smarty_tpl->getVariable('currencies')->value)>1){?>
					<select id="currency_payement" name="currency_payement" onchange="setCurrency($('#currency_payement').val());" style="display:none">
						<?php  $_smarty_tpl->tpl_vars['currency'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('currencies')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['currency']->key => $_smarty_tpl->tpl_vars['currency']->value){
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['currency']->value['id_currency'];?>
" <?php if ($_smarty_tpl->tpl_vars['currency']->value['id_currency']==$_smarty_tpl->getVariable('cust_currency')->value){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['currency']->value['name'];?>
</option>
						<?php }} ?>
					</select>
				<?php }else{ ?>
					<?php echo smartyTranslate(array('s'=>'We accept the following currency to be sent by bank wire:','mod'=>'bankwire'),$_smarty_tpl);?>
&nbsp;<b><?php echo $_smarty_tpl->getVariable('currencies')->value[0]['name'];?>
</b>
					<input type="hidden" name="currency_payement" value="<?php echo $_smarty_tpl->getVariable('currencies')->value[0]['id_currency'];?>
" />
				<?php }?>
			</p>
			<table style="margin:0px 10px;width:90%; font-family:Verdana,sans-serif; font-size:11px; color:#374953;">
		<tr style="border-top:1px dashed #cacaca">
			<td style="border-top:1px dashed #cacaca; padding-top:10px">Order Amount</td>
			<td style="border-top:1px dashed #cacaca; padding-top:10px"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('total')->value),$_smarty_tpl);?>
</td>
		</tr>
		<tr>
			<td>Bank Name</td>
			<td>HDFC Bank </td>
		</tr>
		<tr>
			<td>Account Name</td>
			<td>Zing Ecommerce Private Limited</td>
		</tr>
		<tr>
			<td>Account No</td>
			<td>00758630000251</td>
		</tr>
		<tr>
			<td>Branch Code</td>
			<td>0075</td>
		</tr>
		<tr>
			<td>Account Branch</td>
			<td>Airport Road Golden Tower, Kodihalli, Bangalore, Karnataka, INDIA</td>
		</tr>
		<tr>
			<td>IFSC code/ Sort Code</td>
			<td>HDFC0000075</td>
		</tr>
		<tr>
			<td style="border-bottom:1px dashed #cacaca; padding-bottom:10px">SWIFT Code</td>
			<td style="border-bottom:1px dashed #cacaca; padding-bottom:10px">HDFCINBB</td>
		</tr>
	</table>
			<p class="cart_navigation" style="padding:10px;">
				<a href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('order.php',true);?>
?step=3" class="button_large hideOnSubmit"><?php echo smartyTranslate(array('s'=>'Other payment methods','mod'=>'bankwire'),$_smarty_tpl);?>
</a>
				<input type="submit" name="submit" value="Confirm Order" class="exclusive_large hideOnSubmit" />
			</p>
			</form>
		</div>
	</div>
</div>

<?php }?>
