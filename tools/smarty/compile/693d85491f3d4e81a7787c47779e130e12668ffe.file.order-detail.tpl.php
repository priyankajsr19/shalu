<?php /* Smarty version Smarty-3.0.7, created on 2015-05-21 16:51:24
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/order-detail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:778578171555dbfb4a54385-94270603%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '693d85491f3d4e81a7787c47779e130e12668ffe' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/order-detail.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '778578171555dbfb4a54385-94270603',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/tools/smarty/plugins/modifier.escape.php';
if (!is_callable('smarty_function_counter')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/tools/smarty/plugins/function.counter.php';
if (!is_callable('smarty_function_cycle')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/tools/smarty/plugins/function.cycle.php';
?>

<script type="text/javascript">
// <![CDATA[
        
//]]>
</script>
<div style="width: 210px; float: right; margin-right:10px;padding:0px 10px">
    <div class="address_card_selected" style="height:200px">
        <div class="address_title underline" style="padding:3px 15px;display:block;">
            Delivery Address
        </div>
        <ul class="address item">
            <li class="address_name"><?php echo addslashes($_smarty_tpl->getVariable('address_delivery')->value->firstname);?>
 <?php echo addslashes($_smarty_tpl->getVariable('address_delivery')->value->lastname);?>
</li>
            <li class="address_address1"><?php echo addslashes($_smarty_tpl->getVariable('address_delivery')->value->address1);?>
</li>
            <li class="address_address2"><?php echo addslashes($_smarty_tpl->getVariable('address_delivery')->value->state_name);?>
</li>
            <li class="address_city"><?php echo addslashes($_smarty_tpl->getVariable('address_delivery')->value->city);?>
</li>
            <li class="address_pincode"><?php echo addslashes($_smarty_tpl->getVariable('address_delivery')->value->postcode);?>
</li>
            <li class="address_pincode"><?php echo addslashes($_smarty_tpl->getVariable('address_delivery')->value->country);?>
</li>
            <li class="address_country">Phone: <?php echo addslashes($_smarty_tpl->getVariable('address_delivery')->value->phone_mobile);?>
</li>
        </ul>
    </div>
</div>
<div style="width:450px; float:left;">
    <?php if (isset($_smarty_tpl->getVariable('followup',null,true,false)->value)){?>
    <p class="bold"><?php echo smartyTranslate(array('s'=>'Click the following link to track the delivery of your order'),$_smarty_tpl);?>
</p>
    <a href="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('followup')->value,'htmlall','UTF-8');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('followup')->value,'htmlall','UTF-8');?>
</a>
    <?php }?>
    
    <p class="bold"><?php echo smartyTranslate(array('s'=>'Order:'),$_smarty_tpl);?>
 <span class="color-myaccount"><?php echo smartyTranslate(array('s'=>'#'),$_smarty_tpl);?>
<?php echo sprintf("%06d",$_smarty_tpl->getVariable('order')->value->id);?>
</span></p>
    <p class="bold"><?php echo smartyTranslate(array('s'=>'Payment method:'),$_smarty_tpl);?>
 <span class="color-myaccount"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->payment,'htmlall','UTF-8');?>
</span></p>
    <?php if ($_smarty_tpl->getVariable('invoice')->value&&$_smarty_tpl->getVariable('invoiceAllowed')->value){?>
    <p>
        <img src="<?php echo $_smarty_tpl->getVariable('img_dir')->value;?>
icon/pdf.gif" alt="" class="icon" />
        <a href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('pdf-invoice.php',true);?>
?id_order=<?php echo intval($_smarty_tpl->getVariable('order')->value->id);?>
<?php if ($_smarty_tpl->getVariable('is_guest')->value){?>&secure_key=<?php echo $_smarty_tpl->getVariable('order')->value->secure_key;?>
<?php }?>"><?php echo smartyTranslate(array('s'=>'Download your invoice as a .PDF file'),$_smarty_tpl);?>
</a>
    </p>
    <?php }?>
    <?php if ($_smarty_tpl->getVariable('order')->value->recyclable){?>
    <p><img src="<?php echo $_smarty_tpl->getVariable('img_dir')->value;?>
icon/recyclable.gif" alt="" class="icon" />&nbsp;<?php echo smartyTranslate(array('s'=>'You have given permission to receive your order in recycled packaging.'),$_smarty_tpl);?>
</p>
    <?php }?>
    <?php if ($_smarty_tpl->getVariable('order')->value->gift){?>
        <p><img src="<?php echo $_smarty_tpl->getVariable('img_dir')->value;?>
icon/gift.gif" alt="" class="icon" />&nbsp;<?php echo smartyTranslate(array('s'=>'You requested gift-wrapping for your order.'),$_smarty_tpl);?>
</p>
        <p><?php echo smartyTranslate(array('s'=>'Message:'),$_smarty_tpl);?>
 <?php echo nl2br($_smarty_tpl->getVariable('order')->value->gift_message);?>
</p>
    <?php }?>
    <br />
</div>



<?php echo $_smarty_tpl->getVariable('HOOK_ORDERDETAILDISPLAYED')->value;?>


<div style="float:left;">
<?php if (!$_smarty_tpl->getVariable('is_guest')->value){?><form action="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('order-follow.php',true);?>
" method="post"><?php }?>
<div id="order-detail-content" class="table_block">
    <p class="bold" style="font-family:Abel"><?php echo smartyTranslate(array('s'=>'Order details'),$_smarty_tpl);?>
</p>
    <div style="border-top:1px solid #cacaca;">
    <table class="std">
        <thead>
            <tr>
                <?php if ($_smarty_tpl->getVariable('return_allowed')->value){?><th class="first_item"><input type="checkbox" /></th><?php }?>
                <th class="item" style="text-align:left;"><?php echo smartyTranslate(array('s'=>'Product'),$_smarty_tpl);?>
</th>
                <th class="item"><?php echo smartyTranslate(array('s'=>'Quantity'),$_smarty_tpl);?>
</th>
                <th class="item" style="text-align:right;"><?php echo smartyTranslate(array('s'=>'Unit price'),$_smarty_tpl);?>
</th>
                <th class="last_item" style="text-align:right;"><?php echo smartyTranslate(array('s'=>'Total price'),$_smarty_tpl);?>
</th>
            </tr>
        </thead>
        <tfoot>
            <?php if ($_smarty_tpl->getVariable('order')->value->customization_fee>0){?>
            <tr class="item">
                <td colspan="4">
                    <?php echo smartyTranslate(array('s'=>'Stitching and customizations:'),$_smarty_tpl);?>
 <span class="price-shipping" style="padding-left:15px"><?php echo Product::displayWtPriceWithCurrency(array('price'=>$_smarty_tpl->getVariable('order')->value->customization_fee,'currency'=>$_smarty_tpl->getVariable('currency')->value),$_smarty_tpl);?>
</span>
                </td>
            </tr>
            <?php }?>
            <?php if ($_smarty_tpl->getVariable('priceDisplay')->value&&$_smarty_tpl->getVariable('use_tax')->value){?>
                <tr class="item">
                    <td colspan="<?php if ($_smarty_tpl->getVariable('return_allowed')->value){?>5<?php }else{ ?>4<?php }?>">
                        <?php echo smartyTranslate(array('s'=>'Subtotal:'),$_smarty_tpl);?>
 <span class="price"><?php echo Product::displayWtPriceWithCurrency(array('price'=>$_smarty_tpl->getVariable('order')->value->getTotalProductsWithoutTaxes(),'currency'=>$_smarty_tpl->getVariable('currency')->value),$_smarty_tpl);?>
</span>
                    </td>
                </tr>
            <?php }?>
            <tr class="item">
                <td colspan="<?php if ($_smarty_tpl->getVariable('return_allowed')->value){?>5<?php }else{ ?>4<?php }?>">
                    <?php echo smartyTranslate(array('s'=>'Subtotal'),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->getVariable('use_tax')->value){?><?php echo smartyTranslate(array('s'=>''),$_smarty_tpl);?>
<?php }?>: <span class="price" style="padding-left:15px"><?php echo Product::displayWtPriceWithCurrency(array('price'=>$_smarty_tpl->getVariable('order')->value->getTotalProductsWithTaxes(),'currency'=>$_smarty_tpl->getVariable('currency')->value),$_smarty_tpl);?>
</span>
                </td>
            </tr>
            <?php if ($_smarty_tpl->getVariable('order')->value->total_discounts>0){?>
            <tr class="item">
                <td colspan="<?php if ($_smarty_tpl->getVariable('return_allowed')->value){?>5<?php }else{ ?>4<?php }?>">
                    <?php echo smartyTranslate(array('s'=>'Vouchers / Discounts:'),$_smarty_tpl);?>
 <span class="price-discount" style="padding-left:15px"><?php echo Product::displayWtPriceWithCurrency(array('price'=>$_smarty_tpl->getVariable('order')->value->total_discounts,'currency'=>$_smarty_tpl->getVariable('currency')->value),$_smarty_tpl);?>
</span>
                </td>
            </tr>
            <?php }?>
            <?php if ($_smarty_tpl->getVariable('order')->value->total_wrapping>0){?>
            <tr class="item">
                <td colspan="<?php if ($_smarty_tpl->getVariable('return_allowed')->value){?>5<?php }else{ ?>4<?php }?>">
                    <?php echo smartyTranslate(array('s'=>'Total gift-wrapping:'),$_smarty_tpl);?>
 <span class="price-wrapping"><?php echo Product::displayWtPriceWithCurrency(array('price'=>$_smarty_tpl->getVariable('order')->value->total_wrapping,'currency'=>$_smarty_tpl->getVariable('currency')->value),$_smarty_tpl);?>
</span>
                </td>
            </tr>
            <?php }?>
            <?php if ($_smarty_tpl->getVariable('order')->value->total_cod>0){?>
            <tr class="item">
                <td colspan="4">
                    <?php echo smartyTranslate(array('s'=>'COD Charges:'),$_smarty_tpl);?>
 <span class="price-shipping" style="padding-left:15px"><?php echo Product::displayWtPriceWithCurrency(array('price'=>$_smarty_tpl->getVariable('order')->value->total_cod,'currency'=>$_smarty_tpl->getVariable('currency')->value),$_smarty_tpl);?>
</span>
                </td>
            </tr>
            <?php }?>
            
            <tr class="item">
                <td colspan="<?php if ($_smarty_tpl->getVariable('return_allowed')->value){?>5<?php }else{ ?>4<?php }?>">
                    <?php echo smartyTranslate(array('s'=>'Shipping'),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->getVariable('use_tax')->value){?><?php echo smartyTranslate(array('s'=>''),$_smarty_tpl);?>
<?php }?>: <span class="price-shipping" style="padding-left:15px"><?php echo Product::displayWtPriceWithCurrency(array('price'=>$_smarty_tpl->getVariable('order')->value->total_shipping,'currency'=>$_smarty_tpl->getVariable('currency')->value),$_smarty_tpl);?>
</span>
                </td>
            </tr>
	    <?php if ($_smarty_tpl->getVariable('order')->value->total_donation>0){?>
            <tr class="item">
                <td colspan="<?php if ($_smarty_tpl->getVariable('return_allowed')->value){?>5<?php }else{ ?>4<?php }?>">
                    <?php echo smartyTranslate(array('s'=>"Donation Amount"),$_smarty_tpl);?>
: <span style="padding-left:15px"><?php echo Product::displayWtPriceWithCurrency(array('price'=>$_smarty_tpl->getVariable('order')->value->total_donation,'currency'=>$_smarty_tpl->getVariable('currency')->value),$_smarty_tpl);?>
</span>
                </td>
            </tr>
	    <?php }?>
            <tr class="item">
                <td colspan="<?php if ($_smarty_tpl->getVariable('return_allowed')->value){?>5<?php }else{ ?>4<?php }?>">
                    <?php echo smartyTranslate(array('s'=>'Order Total:'),$_smarty_tpl);?>
 <span class="price" style="padding-left:15px"><?php echo Product::displayWtPriceWithCurrency(array('price'=>$_smarty_tpl->getVariable('order')->value->total_paid,'currency'=>$_smarty_tpl->getVariable('currency')->value),$_smarty_tpl);?>
</span>
                </td>
            </tr>
        </tfoot>
        <tbody>
        <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['index']++;
?>
            <?php if (!isset($_smarty_tpl->tpl_vars['product']->value['deleted'])){?>
                <?php $_smarty_tpl->tpl_vars['productId'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['product_id'], null, null);?>
                <?php $_smarty_tpl->tpl_vars['productAttributeId'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['product_attribute_id'], null, null);?>
                <?php if (isset($_smarty_tpl->getVariable('customizedDatas',null,true,false)->value[$_smarty_tpl->getVariable('productId',null,true,false)->value][$_smarty_tpl->getVariable('productAttributeId',null,true,false)->value])){?><?php $_smarty_tpl->tpl_vars['productQuantity'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['product_quantity']-$_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal'], null, null);?><?php }else{ ?><?php $_smarty_tpl->tpl_vars['productQuantity'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['product_quantity'], null, null);?><?php }?>
                <!-- Customized products -->
                <?php if (isset($_smarty_tpl->getVariable('customizedDatas',null,true,false)->value[$_smarty_tpl->getVariable('productId',null,true,false)->value][$_smarty_tpl->getVariable('productAttributeId',null,true,false)->value])){?>
                    <tr class="item">
                        <?php if ($_smarty_tpl->getVariable('return_allowed')->value){?><td class="order_cb"></td><?php }?>
                        <td class="bold" style="text-align:left;">
                            <label  for="cb_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['product_name'],'htmlall','UTF-8');?>
</label>
                        </td>
                        <td style="text-align:center;"><input class="order_qte_input"  name="order_qte_input[<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['products']['index'];?>
]" type="text" size="2" value="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal']);?>
" /><label for="cb_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
"><span class="order_qte_span editable"><?php echo intval($_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal']);?>
</span></label></td>
                        <td style="text-align:right">
                            <label for="cb_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
">
                                <?php if ($_smarty_tpl->getVariable('group_use_tax')->value){?>
                                    <?php echo Product::convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['product']->value['product_price_wt'],'currency'=>$_smarty_tpl->getVariable('currency')->value,'convert'=>0),$_smarty_tpl);?>

                                <?php }else{ ?>
                                    <?php echo Product::convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['product']->value['product_price'],'currency'=>$_smarty_tpl->getVariable('currency')->value,'convert'=>0),$_smarty_tpl);?>

                                <?php }?>
                            </label>
                        </td>
                        <td style="text-align:right">
                            <label for="cb_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
">
                                <?php if (isset($_smarty_tpl->getVariable('customizedDatas',null,true,false)->value[$_smarty_tpl->getVariable('productId',null,true,false)->value][$_smarty_tpl->getVariable('productAttributeId',null,true,false)->value])){?>
                                    <?php if ($_smarty_tpl->getVariable('group_use_tax')->value){?>
                                        <?php echo Product::convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['product']->value['total_customization_wt'],'currency'=>$_smarty_tpl->getVariable('currency')->value,'convert'=>0),$_smarty_tpl);?>

                                    <?php }else{ ?>
                                        <?php echo Product::convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['product']->value['total_customization'],'currency'=>$_smarty_tpl->getVariable('currency')->value,'convert'=>0),$_smarty_tpl);?>

                                    <?php }?>
                                <?php }else{ ?>
                                    <?php if ($_smarty_tpl->getVariable('group_use_tax')->value){?>
                                        <?php echo Product::convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['product']->value['total_wt'],'currency'=>$_smarty_tpl->getVariable('currency')->value,'convert'=>0),$_smarty_tpl);?>

                                    <?php }else{ ?>
                                        <?php echo Product::convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['product']->value['total_price'],'currency'=>$_smarty_tpl->getVariable('currency')->value,'convert'=>0),$_smarty_tpl);?>

                                    <?php }?>
                                <?php }?>
                            </label>
                        </td>
                    </tr>
                    <?php  $_smarty_tpl->tpl_vars['customization'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['customizationId'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('customizedDatas')->value[$_smarty_tpl->getVariable('productId')->value][$_smarty_tpl->getVariable('productAttributeId')->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['customization']->key => $_smarty_tpl->tpl_vars['customization']->value){
 $_smarty_tpl->tpl_vars['customizationId']->value = $_smarty_tpl->tpl_vars['customization']->key;
?>
                    <tr class="alternate_item">
                        <?php if ($_smarty_tpl->getVariable('return_allowed')->value){?><td class="order_cb"><input type="checkbox" id="cb_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
" name="customization_ids[<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
][]" value="<?php echo intval($_smarty_tpl->tpl_vars['customizationId']->value);?>
" /></td><?php }?>
                        <td colspan="1">
                        <?php  $_smarty_tpl->tpl_vars['datas'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['customization']->value['datas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['datas']->key => $_smarty_tpl->tpl_vars['datas']->value){
 $_smarty_tpl->tpl_vars['type']->value = $_smarty_tpl->tpl_vars['datas']->key;
?>
                            <?php if ($_smarty_tpl->tpl_vars['type']->value==$_smarty_tpl->getVariable('CUSTOMIZE_FILE')->value){?>
                            <ul class="customizationUploaded">
                                <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datas']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value){
?>
                                    <li><img src="<?php echo $_smarty_tpl->getVariable('pic_dir')->value;?>
<?php echo $_smarty_tpl->tpl_vars['data']->value['value'];?>
_small" alt="" class="customizationUploaded" /></li>
                                <?php }} ?>
                            </ul>
                            <?php }elseif($_smarty_tpl->tpl_vars['type']->value==$_smarty_tpl->getVariable('CUSTOMIZE_TEXTFIELD')->value){?>
                            <ul class="typedText"><?php echo smarty_function_counter(array('start'=>0,'print'=>false),$_smarty_tpl);?>

                                <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datas']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value){
?>
                                    <?php $_smarty_tpl->tpl_vars['customizationFieldName'] = new Smarty_variable(("Text #").($_smarty_tpl->tpl_vars['data']->value['id_customization_field']), null, null);?>
                                    <li style="padding-top:10px;">
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['index']==9){?>
                                            Garment fabric
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['index']==8){?>
                                            <?php if ($_smarty_tpl->tpl_vars['customization']->value['fall_piko']=="1"){?>
                                                Saree with unstitched blouse and fall/pico work.
                                            <?php }else{ ?>
                                                Saree with unstitched blouse and without fall/pico work.
                                            <?php }?>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['index']==1){?>
                                            Pre-stitched saree with unstitched blouse and fall/pico work.
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['index']==2){?>
                                            <span style="width:137px;display:inline-block;text-align:center;">
                                                <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
styles/<?php echo $_smarty_tpl->tpl_vars['customization']->value['blouse_style_image'];?>
" width="90" />
                                                <span style="font-family:Abel;font-size:14px;display:block;width:100%;line-height:1em"><?php echo $_smarty_tpl->tpl_vars['customization']->value['blouse_style_name'];?>
</span>
                                            </span>
                                            <span style="display:inline-block;width:150px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                Stitched to measure blouse <br />
                                                Measurement for: <span style="text-transform:capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['blouse_measurement'];?>
</span><br/>
                                                <?php if ($_smarty_tpl->tpl_vars['customization']->value['fall_piko']=="1"){?>
                                                    <span>With fall/piko work</span>
                                                <?php }else{ ?>
                                                    <span>Without fall/piko work</span>
                                                <?php }?>
                                            </span>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['index']==3){?>
                                            <span style="width:137px;display:inline-block;text-align:center;">
                                                <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
styles/<?php echo $_smarty_tpl->tpl_vars['customization']->value['inskirt_style_image'];?>
" height="90"/>
                                                <span style="font-family:Abel;font-size:14px;display:block;width:100%;line-height:1em"><?php echo $_smarty_tpl->tpl_vars['customization']->value['inskirt_style_name'];?>
</span>
                                            </span>
                                            <span style="display:inline-block;width:150px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                Stitched to measure in-skirt <br />
                                                Measurement for: <span style="text-transform:capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['inskirt_measurement'];?>
</span><br/>
                                                <?php if ($_smarty_tpl->tpl_vars['customization']->value['fall_piko']=="1"){?>
                                                    <span>With fall/piko work</span>
                                                <?php }else{ ?>
                                                    <span>Without fall/piko work</span>
                                                <?php }?>
                                            </span>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['index']==4){?>
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                Stitched to measure kurta <br />
                                                Measurement for: <span style="text-transform:capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['kurta_measurement'];?>
</span>
                                            </span>
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                Stitched to measure salwar <br />
                                                Measurement for: <span style="text-transform:capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['salwar_measurement'];?>
</span>
                                            </span>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['index']==5){?>
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                Stitched to measure Lehenga Choli <br />
                                                Lehenga Measurement for: <span style="text-transform:capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['lehenga_measurement'];?>
</span> <br />
                                                Choli Measurement for: <span style="text-transform:capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['choli_measurement'];?>
</span>
                                            </span>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['index']==10){?>
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                + Long Choli
                                            </span>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['index']==11){?>
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                + Long Sleeves
                                            </span>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['index']==13){?>
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                Style: <?php echo $_smarty_tpl->tpl_vars['customization']->value['choli_style'];?>
 <br />
                                                Size: <?php echo $_smarty_tpl->tpl_vars['customization']->value['choli_size'];?>

                                            </span>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['index']==24){?>
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                Stitched to measure Salwar Kameez <br />
                                                <?php if (isset($_smarty_tpl->tpl_vars['customization']->value['salwar_style_name'])&&!empty($_smarty_tpl->tpl_vars['customization']->value['salwar_style_name'])){?>
                                                    Salwar Measurement for: <span style="text-transform:capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['salwar_measurement'];?>
 , Style : <span> <?php echo $_smarty_tpl->tpl_vars['customization']->value['salwar_style_name'];?>
 </span> </span> <br />
                                                <?php }?>
                                                <?php if (isset($_smarty_tpl->tpl_vars['customization']->value['kurta_style_name'])&&!empty($_smarty_tpl->tpl_vars['customization']->value['kurta_style_name'])){?>
                                                    Kurta Measurement for: <span style="text-transform:capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['kurta_measurement'];?>
 , Style : <span> <?php echo $_smarty_tpl->tpl_vars['customization']->value['kurta_style_name'];?>
 </span></span>
                                                <?php }?>
                                            </span>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['index']==21){?>
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                <?php if (isset($_smarty_tpl->tpl_vars['customization']->value['friends_name'])&&!empty($_smarty_tpl->tpl_vars['customization']->value['friends_name'])){?>
                                                    To : <span style="text-transform:capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['friends_name'];?>
</span></br/>
                                                <?php }?>
                                            </span>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['index']==22){?>
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                <?php if (isset($_smarty_tpl->tpl_vars['customization']->value['friends_email'])&&!empty($_smarty_tpl->tpl_vars['customization']->value['friends_email'])){?>
                                                    Email : <span style="text-transform:none;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['friends_email'];?>
</span></br/>
                                                <?php }?>
                                            </span>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['index']==23){?>
                                            <span style="display:inline-block;width:350px;line-height:1.2em;vertical-align:top;padding-top:10px;">
                                                <?php if (isset($_smarty_tpl->tpl_vars['customization']->value['gift_message'])&&!empty($_smarty_tpl->tpl_vars['customization']->value['gift_message'])){?>
                                                    Gift Message : <span style="text-transform:capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['gift_message'];?>
</span></br/>
                                                <?php }?>
                                            </span>
                                        <?php }?>
                                    </li>
                                <?php }} ?>
                            </ul>
                            <?php }?>
                        <?php }} ?>
                        </td>
                        <td style="text-align:center">
                            <input class="order_qte_input" name="customization_qty_input[<?php echo intval($_smarty_tpl->tpl_vars['customizationId']->value);?>
]" type="text" size="2" value="<?php echo intval($_smarty_tpl->tpl_vars['customization']->value['quantity']);?>
" /><label for="cb_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
"><span class="order_qte_span editable"><?php echo intval($_smarty_tpl->tpl_vars['customization']->value['quantity']);?>
</span></label>
                        </td>
                        <td colspan="2"></td>
                    </tr>
                    <?php }} ?>
                <?php }?>
                <!-- Classic products -->
                <?php if ($_smarty_tpl->tpl_vars['product']->value['product_quantity']>$_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal']){?>
                    <tr style='background-color: <?php echo smarty_function_cycle(array('values'=>"#eeeeee,#d0d0d0"),$_smarty_tpl);?>
'>
                        <?php if ($_smarty_tpl->getVariable('return_allowed')->value){?><td class="order_cb"><input type="checkbox" id="cb_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
" name="ids_order_detail[<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
]" value="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
" /></td><?php }?>
                        <td class="bold">
                            <label class="order-detail-label" for="cb_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
">
                                <?php if ($_smarty_tpl->tpl_vars['product']->value['download_hash']&&$_smarty_tpl->getVariable('invoice')->value){?>
                                    <a href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('get-file.php',true);?>
?key=<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['filename'],'htmlall','UTF-8');?>
-<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['download_hash'],'htmlall','UTF-8');?>
<?php if (isset($_smarty_tpl->getVariable('is_guest',null,true,false)->value)&&$_smarty_tpl->getVariable('is_guest')->value){?>&id_order=<?php echo $_smarty_tpl->getVariable('order')->value->id;?>
&secure_key=<?php echo $_smarty_tpl->getVariable('order')->value->secure_key;?>
<?php }?>" title="<?php echo smartyTranslate(array('s'=>'download this product'),$_smarty_tpl);?>
">
                                        <img src="<?php echo $_smarty_tpl->getVariable('img_dir')->value;?>
icon/download_product.gif" class="icon" alt="<?php echo smartyTranslate(array('s'=>'Download product'),$_smarty_tpl);?>
" />
                                    </a>
                                    <a href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('get-file.php',true);?>
?key=<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['filename'],'htmlall','UTF-8');?>
-<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['download_hash'],'htmlall','UTF-8');?>
<?php if (isset($_smarty_tpl->getVariable('is_guest',null,true,false)->value)&&$_smarty_tpl->getVariable('is_guest')->value){?>&id_order=<?php echo $_smarty_tpl->getVariable('order')->value->id;?>
&secure_key=<?php echo $_smarty_tpl->getVariable('order')->value->secure_key;?>
<?php }?>" title="<?php echo smartyTranslate(array('s'=>'download this product'),$_smarty_tpl);?>
">
                                        <?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['product_name'],'htmlall','UTF-8');?>

                                    </a>
                                <?php }else{ ?>
                                    <?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['product_name'],'htmlall','UTF-8');?>

                                <?php }?>
                            </label>
                        </td>
                        <td style="text-align:center;"><input class="order_qte_input" name="order_qte_input[<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
]" type="text" size="2" value="<?php echo intval($_smarty_tpl->getVariable('productQuantity')->value);?>
" /><label for="cb_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
"><span class="order_qte_span editable"><?php echo intval($_smarty_tpl->getVariable('productQuantity')->value);?>
</span></label></td>
                        <td style="text-align:right;">
                            <label class="order-detail-label" for="cb_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
">
                            <?php if ($_smarty_tpl->getVariable('group_use_tax')->value){?>
                                <?php echo Product::convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['product']->value['product_price_wt'],'currency'=>$_smarty_tpl->getVariable('currency')->value,'convert'=>0),$_smarty_tpl);?>

                            <?php }else{ ?>
                                <?php echo Product::convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['product']->value['product_price'],'currency'=>$_smarty_tpl->getVariable('currency')->value,'convert'=>0),$_smarty_tpl);?>

                            <?php }?>
                            </label>
                        </td>
                        <td style="text-align:right;">
                            <label class="order-detail-label" for="cb_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
">
                            <?php if ($_smarty_tpl->getVariable('group_use_tax')->value){?>
                                <?php echo Product::convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['product']->value['total_wt'],'currency'=>$_smarty_tpl->getVariable('currency')->value,'convert'=>0),$_smarty_tpl);?>

                            <?php }else{ ?>
                                <?php echo Product::convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['product']->value['total_price'],'currency'=>$_smarty_tpl->getVariable('currency')->value,'convert'=>0),$_smarty_tpl);?>

                            <?php }?>
                            </label>
                        </td>
                    </tr>
                <?php }?>
            <?php }?>
        <?php }} ?>
        <?php  $_smarty_tpl->tpl_vars['discount'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('discounts')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['discount']->key => $_smarty_tpl->tpl_vars['discount']->value){
?>
            <tr class="item" style="font-size:12px;">
                <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['discount']->value['name'],'htmlall','UTF-8');?>
</td>
                <td><?php echo smartyTranslate(array('s'=>'Voucher:'),$_smarty_tpl);?>
 <?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['discount']->value['name'],'htmlall','UTF-8');?>
</td>
                <td><span class="order_qte_span editable">1</span></td>
                
                <td style="text-align:right;"><?php if ($_smarty_tpl->tpl_vars['discount']->value['value']!=0.00){?><?php echo smartyTranslate(array('s'=>'-'),$_smarty_tpl);?>
<?php }?><?php echo Product::convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['discount']->value['value'],'currency'=>$_smarty_tpl->getVariable('currency')->value,'convert'=>0),$_smarty_tpl);?>
</td>
                <?php if ($_smarty_tpl->getVariable('return_allowed')->value){?>
                <td>&nbsp;</td>
                <?php }?>
            </tr>
        <?php }} ?>
        </tbody>
    </table>
    </div>
</div>
<br />

<?php if (!$_smarty_tpl->getVariable('is_guest')->value){?>
    <?php if ($_smarty_tpl->getVariable('return_allowed')->value){?>
    <p class="bold"><?php echo smartyTranslate(array('s'=>'Merchandise return'),$_smarty_tpl);?>
</p>
    <p><?php echo smartyTranslate(array('s'=>'If you wish to return one or more products, please mark the corresponding boxes and provide an explanation for the return. Then click the button below.'),$_smarty_tpl);?>
</p>
    <p class="textarea">
        <textarea cols="67" rows="3" name="returnText"></textarea>
    </p>
    <p class="submit">
        <input type="submit" value="<?php echo smartyTranslate(array('s'=>'Make a RMA slip'),$_smarty_tpl);?>
" name="submitReturnMerchandise" class="button_large" />
        <input type="hidden" class="hidden" value="<?php echo intval($_smarty_tpl->getVariable('order')->value->id);?>
" name="id_order" />
    </p>
    <br />
    <?php }?>
    </form>
</div>
<?php }else{ ?>
<p><img src="<?php echo $_smarty_tpl->getVariable('img_dir')->value;?>
icon/infos.gif" alt="" class="icon" />&nbsp;<?php echo smartyTranslate(array('s'=>'You can\'t make a merchandise return with a guest account'),$_smarty_tpl);?>
</p>
<?php }?>
