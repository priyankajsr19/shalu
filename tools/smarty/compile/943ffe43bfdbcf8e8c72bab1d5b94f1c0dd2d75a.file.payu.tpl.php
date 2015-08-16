<?php /* Smarty version Smarty-3.0.7, created on 2015-08-14 17:09:40
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/modules/payu/payu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:124924801155cdd37c8f3608-45821375%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '943ffe43bfdbcf8e8c72bab1d5b94f1c0dd2d75a' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/modules/payu/payu.tpl',
      1 => 1437832707,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '124924801155cdd37c8f3608-45821375',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<p id="pay-payu" class="payment_module" <?php if ($_smarty_tpl->getVariable('cookie')->value->id_currency==4){?>checked<?php }?>>
    <input type="radio" name="payMethod" value="payu" style="margin-left:30px;font-size:15px;"/>
    Credit Card/ Debit Card/ NetBanking
    <span style="width:100px; display:inline-block;vertical-align:middle;overflow:hidden">
    	<img src="http://www.indusdiva.com/img/card-types.jpg" alt="card-types" style="vertical-align:middle"/>
    </span>
</p>
<form action="<?php echo $_smarty_tpl->getVariable('action')->value;?>
" method="post" id="payu_form" name="payu_form" >
	<input type="hidden" name="key" value="<?php echo $_smarty_tpl->getVariable('key')->value;?>
" />
	<input type="hidden" name="txnid" value="<?php echo $_smarty_tpl->getVariable('txnid')->value;?>
" />
	<input type="hidden" name="amount" value="<?php echo $_smarty_tpl->getVariable('amount')->value;?>
" />
	<input type="hidden" name="productinfo" value="<?php echo $_smarty_tpl->getVariable('productinfo')->value;?>
" />
	<input type="hidden" name="firstname" value="<?php echo $_smarty_tpl->getVariable('firstname')->value;?>
" />
	<input type="hidden" name="Lastname" value="<?php echo $_smarty_tpl->getVariable('Lastname')->value;?>
" />
	<input type="hidden" name="address1" value="<?php echo $_smarty_tpl->getVariable('deliveryAddress')->value->address1;?>
" />
	<input type="hidden" name="city" value="<?php echo $_smarty_tpl->getVariable('deliveryAddress')->value->city;?>
" />
	<input type="hidden" name="state" value="<?php echo $_smarty_tpl->getVariable('deliveryAddress')->value->state;?>
" />
	<input type="hidden" name="country" value="<?php echo $_smarty_tpl->getVariable('deliveryAddress')->value->country;?>
" />
	<input type="hidden" name="Zipcode" value="<?php echo $_smarty_tpl->getVariable('Zipcode')->value;?>
" />
	<input type="hidden" name="email" value="<?php echo $_smarty_tpl->getVariable('email')->value;?>
" />
	<input type="hidden" name="phone" value="<?php echo $_smarty_tpl->getVariable('phone')->value;?>
" />
	<input type="hidden" name="surl" value="<?php echo $_smarty_tpl->getVariable('surl')->value;?>
" />
	<input type="hidden" name="Furl" value="<?php echo $_smarty_tpl->getVariable('Furl')->value;?>
" />
	<input type="hidden" name="curl" value="<?php echo $_smarty_tpl->getVariable('curl')->value;?>
" />
	<input type="hidden" name="Hash" value="<?php echo $_smarty_tpl->getVariable('Hash')->value;?>
" />
	<input type="hidden" name="Pg" value="<?php echo $_smarty_tpl->getVariable('Pg')->value;?>
" />
</form>	