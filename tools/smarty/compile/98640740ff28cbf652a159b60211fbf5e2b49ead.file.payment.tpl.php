<?php /* Smarty version Smarty-3.0.7, created on 2015-07-27 12:55:00
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/modules/paypal/payment/payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:206632439655b5dccc5a46f8-55117983%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '98640740ff28cbf652a159b60211fbf5e2b49ead' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/modules/paypal/payment/payment.tpl',
      1 => 1437832770,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '206632439655b5dccc5a46f8-55117983',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/tools/smarty/plugins/modifier.escape.php';
?>
<p class="payment_module" height="">
	
	<input type="radio" name="payMethod" value="PayPal" style="margin-left:30px;font-size:15px;" checked/>
	PayPal and Credit/Debit Cards
	<span style="width:200px; display:inline-block;vertical-align:middle">
    	<img src="http://www.indusdiva.com/img/card-types.jpg" alt="card-types" style="vertical-align:middle"/>
    </span>
	<form id="paypal_form" action="<?php echo $_smarty_tpl->getVariable('base_dir_ssl')->value;?>
modules/paypal/payment/submit.php" method="post">
    	<?php if (isset($_smarty_tpl->getVariable('ppToken',null,true,false)->value)){?><input type="hidden" name="token" value="<?php echo stripslashes(smarty_modifier_escape($_smarty_tpl->getVariable('ppToken')->value,'htmlall'));?>
" /><?php }?>
    	<?php if (isset($_smarty_tpl->getVariable('payerID',null,true,false)->value)){?><input type="hidden" name="payerID" value="<?php echo stripslashes(smarty_modifier_escape($_smarty_tpl->getVariable('payerID')->value,'htmlall'));?>
" /><?php }?>
    	<input type="hidden" name="currency_payement" value="<?php echo $_smarty_tpl->getVariable('currency')->value['id_currency'];?>
" />
    	<input type="hidden" name="submitPayment" value="Pay with PayPal or Credit Card" />
    	
	</form>
	<a id="paypal_link" href="<?php echo $_smarty_tpl->getVariable('base_dir_ssl')->value;?>
modules/paypal/payment/submit.php" title="<?php echo smartyTranslate(array('s'=>'Pay with PayPal','mod'=>'paypal'),$_smarty_tpl);?>
" style="display:none">
			<img src="<?php echo $_smarty_tpl->getVariable('logo')->value;?>
" alt="<?php echo smartyTranslate(array('s'=>'Pay with PayPal','mod'=>'paypal'),$_smarty_tpl);?>
" style="float:left;" />
	</a>
</p>
