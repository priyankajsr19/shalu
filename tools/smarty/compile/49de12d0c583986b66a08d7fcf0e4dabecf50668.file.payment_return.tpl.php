<?php /* Smarty version Smarty-3.0.7, created on 2015-07-21 12:44:35
         compiled from "/var/www/html/indusdiva/modules/bankwire/payment_return.tpl" */ ?>
<?php /*%%SmartyHeaderCode:160879957755adf15bcc09f5-39387769%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '49de12d0c583986b66a08d7fcf0e4dabecf50668' => 
    array (
      0 => '/var/www/html/indusdiva/modules/bankwire/payment_return.tpl',
      1 => 1431660622,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '160879957755adf15bcc09f5-39387769',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('status')->value=='ok'){?>
	<p>Your order will be processed after the payment completion. Please mention the order ID (#<?php echo $_smarty_tpl->getVariable('id_order')->value;?>
) in the wire transfer comments. Here are the bank details for completing the order:</p>
	
	<table style="margin:0px 10px;width:90%; font-family:Verdana,sans-serif; font-size:11px; color:#374953;">
		<tr style="border-top:1px dashed #cacaca">
			<td style="border-top:1px dashed #cacaca; padding-top:10px">Order Amount</td>
			<td style="border-top:1px dashed #cacaca; padding-top:10px"><?php echo $_smarty_tpl->getVariable('total_to_pay')->value;?>
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
			<td>Airport Road Golden Tower, Kodihalli, Bangalore, Karnataka, INDIA.</td>
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
	<p>For any assistance, please talk to us in live chat or write to us at care@indusdiva.com </p>
<?php }else{ ?>
	<p class="warning">
		<?php echo smartyTranslate(array('s'=>'We noticed a problem with your order. If you think this is an error, you can contact our','mod'=>'bankwire'),$_smarty_tpl);?>
 
		<a href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('contact-form.php',true);?>
"><?php echo smartyTranslate(array('s'=>'customer support','mod'=>'bankwire'),$_smarty_tpl);?>
</a>.
	</p>
<?php }?>
