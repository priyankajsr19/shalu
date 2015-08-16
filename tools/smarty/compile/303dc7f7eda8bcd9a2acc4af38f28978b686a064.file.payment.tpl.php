<?php /* Smarty version Smarty-3.0.7, created on 2015-08-14 17:09:40
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/modules/cashondelivery/payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:63494935455cdd37c8b39d0-13299495%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '303dc7f7eda8bcd9a2acc4af38f28978b686a064' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/modules/cashondelivery/payment.tpl',
      1 => 1437833022,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '63494935455cdd37c8b39d0-13299495',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="pay-cash" class="payment_module">
<?php if (isset($_smarty_tpl->getVariable('cod',null,true,false)->value)&&$_smarty_tpl->getVariable('cod')->value!=0){?>
<input type="radio" name="payMethod" value="COD" style="margin-left:30px;font-size:15px;"/> Cash on delivery payment
<a style="display:none" id="codLink" href="<?php echo $_smarty_tpl->getVariable('this_path_ssl')->value;?>
validation.php?back=order.php&cid=<?php echo $_smarty_tpl->getVariable('cod')->value;?>
" title="<?php echo smartyTranslate(array('s'=>'Pay with cash on delivery (COD)','mod'=>'cashondelivery'),$_smarty_tpl);?>
">		
    Pay cash on delivery.
</a>
<span style="color:#333333;">(Rs. 70 Extra)</span>
<?php }?>
</div>