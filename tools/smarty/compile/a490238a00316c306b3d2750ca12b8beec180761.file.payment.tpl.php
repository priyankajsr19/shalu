<?php /* Smarty version Smarty-3.0.7, created on 2015-07-21 12:49:27
         compiled from "/var/www/html/indusdiva/modules/cashondelivery/payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:200807779555adf27f254e11-59565197%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a490238a00316c306b3d2750ca12b8beec180761' => 
    array (
      0 => '/var/www/html/indusdiva/modules/cashondelivery/payment.tpl',
      1 => 1431660622,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '200807779555adf27f254e11-59565197',
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