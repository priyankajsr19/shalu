<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 14:01:56
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/shopping-cart.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19818178035562ddfcdea2d4-56460059%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b48aa5f65230fd8bc4f41de228b0fbf23d02a59' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/shopping-cart.tpl',
      1 => 1432286773,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19818178035562ddfcdea2d4-56460059',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/tools/smarty/plugins/modifier.escape.php';
?><?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./errors.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<?php if (isset($_smarty_tpl->getVariable('empty',null,true,false)->value)){?>
    <p class="warning"><?php echo smartyTranslate(array('s'=>'Your shopping cart is empty.'),$_smarty_tpl);?>
</p>
<?php }elseif($_smarty_tpl->getVariable('PS_CATALOG_MODE')->value){?>
    <p class="warning"><?php echo smartyTranslate(array('s'=>'This store has not accepted your new order.'),$_smarty_tpl);?>
</p>
<?php }else{ ?>
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
    <p style="display: none" id="emptyCartWarning" class="warning"><?php echo smartyTranslate(array('s'=>'Your shopping cart is empty.'),$_smarty_tpl);?>
</p>
    <div id="co_content" class="clearfix">
	<?php if ((($tmp = @$_smarty_tpl->getVariable('spl_voucher_message')->value)===null||$tmp==='' ? '' : $tmp)!=''){?>
        <div style="width: 100%;padding: 10px 0px 10px 0px;border: 1px solid #ccc;font-size: 14px;text-align: center;font-weight: bold;border:1px solid #ccc;color: #a34321;">
		<?php echo $_smarty_tpl->getVariable('spl_voucher_message')->value;?>

	</div>
	<?php }?>
        <div id="co_left_column" style="width: 757px;">
            <div id="order-detail-content" class="table_block" style="width: 750px; margin: 0 7px;">
                <table id="cart_summary" class="std">
                    <thead>
                        <tr>
                            <th class="cart_product first_item"><?php echo smartyTranslate(array('s'=>'Product'),$_smarty_tpl);?>
</th>
                            <th
                                class="cart_description item"
                                style="text-align: left;"><?php echo smartyTranslate(array('s'=>'Description'),$_smarty_tpl);?>
</th> 
                            <th class="cart_availability item"><?php echo smartyTranslate(array('s'=>'Availablity'),$_smarty_tpl);?>
</th>
                            <th
                                class="cart_unit item"
                                style="text-align: right;"><?php echo smartyTranslate(array('s'=>'Unit price'),$_smarty_tpl);?>
</th>
                            <th class="cart_quantity item"><?php echo smartyTranslate(array('s'=>'Qty'),$_smarty_tpl);?>
</th>
                            <th
                                class="cart_total last_item"
                                style="text-align: right;"><?php echo smartyTranslate(array('s'=>'Sub Total'),$_smarty_tpl);?>
</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <?php if ($_smarty_tpl->getVariable('use_taxes')->value){?>
                            <?php if ($_smarty_tpl->getVariable('priceDisplay')->value){?>
                                <tr
                                    class="cart_total_price"
                                    style="border-top: 1px solid #BDC2C9;">
                                    <td colspan="5">
                                        <?php echo smartyTranslate(array('s'=>'Sub Total'),$_smarty_tpl);?>
<?php if ($_smarty_tpl->getVariable('display_tax_label')->value){?> <?php echo smartyTranslate(array('s'=>'(tax excl.)'),$_smarty_tpl);?>
<?php }?><?php echo smartyTranslate(array('s'=>':'),$_smarty_tpl);?>
</td>
                                    <td
                                        class="price"
                                        id="total_product"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('total_products')->value),$_smarty_tpl);?>
</td>
                                </tr>
                            <?php }else{ ?>
                                <tr
                                    class="cart_total_price"
                                    style="border-top: 1px solid #BDC2C9;">
                                    <td colspan="5">
                                        <?php echo smartyTranslate(array('s'=>'Sub Total'),$_smarty_tpl);?>
<?php echo smartyTranslate(array('s'=>':'),$_smarty_tpl);?>
</td>
                                    <?php if (isset($_smarty_tpl->getVariable('customization',null,true,false)->value)&&$_smarty_tpl->getVariable('customization')->value>0){?>
                                        <td
                                            class="price"
                                            id="total_product"><?php echo Tools::displayPriceSmarty(array('price'=>($_smarty_tpl->getVariable('total_products_wt')->value-$_smarty_tpl->getVariable('customization')->value)),$_smarty_tpl);?>
</td>
                                    <?php }else{ ?>
                                        <td
                                            class="price"
                                            id="total_product"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('total_products_wt')->value),$_smarty_tpl);?>
</td>
                                    <?php }?>
                                </tr>
                            <?php }?>
                        <?php }else{ ?>
                            <tr class="cart_total_price">
                                <td colspan="5"><?php echo smartyTranslate(array('s'=>'Total:'),$_smarty_tpl);?>
</td>
                                <td
                                    class="price"
                                    id="total_product"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('total_products')->value),$_smarty_tpl);?>
</td>
                            </tr>
                        <?php }?>
                        <tr
                            class="cart_total_voucher"
                            <?php if ($_smarty_tpl->getVariable('total_discounts')->value==0){?>style="display: none;"<?php }?>>
                            <td colspan="5"><?php if ($_smarty_tpl->getVariable('use_taxes')->value){?> <?php if ($_smarty_tpl->getVariable('priceDisplay')->value){?> <?php echo smartyTranslate(array('s'=>'Total vouchers/discounts'),$_smarty_tpl);?>
<?php if ($_smarty_tpl->getVariable('display_tax_label')->value){?> <?php echo smartyTranslate(array('s'=>'(tax excl.)'),$_smarty_tpl);?>
<?php }?><?php echo smartyTranslate(array('s'=>':'),$_smarty_tpl);?>
 <?php }else{ ?> <?php echo smartyTranslate(array('s'=>'Total vouchers/discounts'),$_smarty_tpl);?>
<?php if ($_smarty_tpl->getVariable('display_tax_label')->value){?> <?php echo smartyTranslate(array('s'=>'(tax incl.)'),$_smarty_tpl);?>
<?php }?><?php echo smartyTranslate(array('s'=>':'),$_smarty_tpl);?>
 <?php }?> <?php }else{ ?> <?php echo smartyTranslate(array('s'=>'Total vouchers:'),$_smarty_tpl);?>
 <?php }?></td>
                            <td
                                class="price-discount"
                                id="total_discount"><?php if ($_smarty_tpl->getVariable('use_taxes')->value){?> <?php if ($_smarty_tpl->getVariable('priceDisplay')->value){?> <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('total_discounts_tax_exc')->value),$_smarty_tpl);?>
 <?php }else{ ?> <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('total_discounts')->value),$_smarty_tpl);?>
 <?php }?> <?php }else{ ?> <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('total_discounts_tax_exc')->value),$_smarty_tpl);?>
 <?php }?></td>
                        </tr>
                        <tr
                            class="cart_total_voucher"
                            <?php if ($_smarty_tpl->getVariable('total_wrapping')->value==0){?>style="display: none;"<?php }?>>
                            <td colspan="5"><?php if ($_smarty_tpl->getVariable('use_taxes')->value){?> <?php if ($_smarty_tpl->getVariable('priceDisplay')->value){?> <?php echo smartyTranslate(array('s'=>'Total gift-wrapping'),$_smarty_tpl);?>
<?php if ($_smarty_tpl->getVariable('display_tax_label')->value){?> <?php echo smartyTranslate(array('s'=>'(tax excl.)'),$_smarty_tpl);?>
<?php }?><?php echo smartyTranslate(array('s'=>':'),$_smarty_tpl);?>
 <?php }else{ ?> <?php echo smartyTranslate(array('s'=>'Total gift-wrapping'),$_smarty_tpl);?>
<?php if ($_smarty_tpl->getVariable('display_tax_label')->value){?> <?php echo smartyTranslate(array('s'=>'(tax incl.)'),$_smarty_tpl);?>
<?php }?><?php echo smartyTranslate(array('s'=>':'),$_smarty_tpl);?>
 <?php }?> <?php }else{ ?> <?php echo smartyTranslate(array('s'=>'Total gift-wrapping:'),$_smarty_tpl);?>
 <?php }?></td>
                            <td
                                class="price-discount"
                                id="total_wrapping"><?php if ($_smarty_tpl->getVariable('use_taxes')->value){?> <?php if ($_smarty_tpl->getVariable('priceDisplay')->value){?> <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('total_wrapping_tax_exc')->value),$_smarty_tpl);?>
 <?php }else{ ?> <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('total_wrapping')->value),$_smarty_tpl);?>
 <?php }?> <?php }else{ ?> <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('total_wrapping_tax_exc')->value),$_smarty_tpl);?>
 <?php }?></td>
                        </tr>



                        <?php if (isset($_smarty_tpl->getVariable('customization',null,true,false)->value)&&$_smarty_tpl->getVariable('customization')->value>0){?>
                            <tr class="cart_total_delivery">
                                <td colspan="5"><?php echo smartyTranslate(array('s'=>'Stitching & Customization:'),$_smarty_tpl);?>
</td>
                                <td
                                    class="price"
                                    id="total_customization"><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->getVariable('customization')->value),$_smarty_tpl);?>
</td>
                            </tr>
                        <?php }?>

                        <?php if ($_smarty_tpl->getVariable('use_taxes')->value){?>
                            <tr class="cart_total_price">
                                <td colspan="5" style="font-size: 15px;">
                                    <?php if ($_smarty_tpl->getVariable('display_tax_label')->value){?>
                                        <?php echo smartyTranslate(array('s'=>'Order Total (tax incl.):'),$_smarty_tpl);?>

                                    <?php }else{ ?>
                                        <?php echo smartyTranslate(array('s'=>'Total:'),$_smarty_tpl);?>

                                    <?php }?>
                                </td>
                                <td class="price ajax_cart_total" id="total_price">
                                    <?php echo Tools::displayPriceSmarty(array('price'=>($_smarty_tpl->getVariable('total_price')->value-$_smarty_tpl->getVariable('shippingCost')->value)),$_smarty_tpl);?>

                                </td>
                            </tr>
                            <?php if ((($tmp = @$_smarty_tpl->getVariable('spl_voucher_message')->value)===null||$tmp==='' ? '' : $tmp)!=''){?>
                                <tr>
                                    <td colspan="6" style="font-weight:bold; font-size:1.3em; background-color:#F1F2F4;border-bottom:2px solid #BDC2C9;text-align:center; color:#a34231"><?php echo $_smarty_tpl->getVariable('spl_voucher_message')->value;?>
</td>
                                </tr>
                            <?php }?>
                            <tr class="cart_total_delivery">
                                <td colspan="6" style="background-color:#F1F2F4;border-bottom:2px solid #BDC2C9;text-align:center">
                                    <a href="#shipping-charges" class="shipping_link span_link">Know more about your shipping charges</a>
                                </td>
                            </tr>
                        <?php }else{ ?>
                            <tr class="cart_total_price">
                                <td colspan="5" style="font-size: 15px;"><?php echo smartyTranslate(array('s'=>'Total:'),$_smarty_tpl);?>
</td>
                                <td class="price" id="total_price">
                                    <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('total_price_without_tax')->value),$_smarty_tpl);?>

                                </td>
                            </tr>
                        <?php }?>
                    </tfoot>
                    <tbody>
                        <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['productLoop']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['productLoop']['index']++;
?>
                            <?php $_smarty_tpl->tpl_vars['productId'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['id_product'], null, null);?>
                            <?php $_smarty_tpl->tpl_vars['productAttributeId'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['id_product_attribute'], null, null);?>
                            <?php $_smarty_tpl->tpl_vars['quantityDisplayed'] = new Smarty_variable(0, null, null);?>
                            <tr id="product_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
" class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['productLoop']['index']%2==0){?>alternate_item <?php }?>cart_item">
                                <td class="cart_product">
                                    <a href="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('link')->value->getProductLink($_smarty_tpl->tpl_vars['product']->value['id_product'],$_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['category']),'htmlall','UTF-8');?>
">
                                        <img
                                            src="<?php echo $_smarty_tpl->getVariable('link')->value->getImageLink($_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['id_image'],'small');?>
"
                                            alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['name'],'htmlall','UTF-8');?>
"
                                            height="116"
                                            width="85" />
                                    </a>
                                </td>
                                <td class="cart_description" style="text-align: left;">
                                    <h5>
                                        <a href="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('link')->value->getProductLink($_smarty_tpl->tpl_vars['product']->value['id_product'],$_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['category']),'htmlall','UTF-8');?>
">
                                            <?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['name'],'htmlall','UTF-8');?>

                                        </a>
                                    </h5>
                                    <?php if (isset($_smarty_tpl->tpl_vars['product']->value['attributes'])&&$_smarty_tpl->tpl_vars['product']->value['attributes']){?>
                                        <a href="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('link')->value->getProductLink($_smarty_tpl->tpl_vars['product']->value['id_product'],$_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['category']),'htmlall','UTF-8');?>
">
                                            <?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['attributes'],'htmlall','UTF-8');?>

                                        </a>
                                    <?php }?>
                                </td>
                                <td class="cart_availability">
                                    <?php if ($_smarty_tpl->tpl_vars['product']->value['active']&&($_smarty_tpl->tpl_vars['product']->value['allow_oosp']||($_smarty_tpl->tpl_vars['product']->value['quantity']<=$_smarty_tpl->tpl_vars['product']->value['stock_quantity']))&&$_smarty_tpl->tpl_vars['product']->value['available_for_order']&&!$_smarty_tpl->getVariable('PS_CATALOG_MODE')->value){?>
                                        <img src="<?php echo $_smarty_tpl->getVariable('img_dir')->value;?>
icon/available.gif"
                                             alt="<?php echo smartyTranslate(array('s'=>'Available'),$_smarty_tpl);?>
"
                                             width="14"
                                             height="14" />
                                    <?php }else{ ?>
                                        <img src="<?php echo $_smarty_tpl->getVariable('img_dir')->value;?>
icon/unavailable.gif"
                                             alt="<?php echo smartyTranslate(array('s'=>'Out of stock'),$_smarty_tpl);?>
"
                                             width="14"
                                             height="14" />
                                    <?php }?>
                                </td>
                                <td class="cart_unit">
                                    <span class="price" id="product_price_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
">
                                        <?php if (!$_smarty_tpl->getVariable('priceDisplay')->value){?>
                                            <?php echo Product::convertPrice(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price_wt']),$_smarty_tpl);?>

                                        <?php }else{ ?>
                                            <?php echo Product::convertPrice(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price']),$_smarty_tpl);?>

                                        <?php }?>
                                    </span>
                                </td>
                                <td style="text-align:center" class="cart_quantity"
                                    <?php if (isset($_smarty_tpl->getVariable('customizedDatas',null,true,false)->value[$_smarty_tpl->getVariable('productId',null,true,false)->value][$_smarty_tpl->getVariable('productAttributeId',null,true,false)->value])&&$_smarty_tpl->getVariable('quantityDisplayed')->value==0){?>
                                    <?php }?> style="text-align: center;">
                                    <?php if (isset($_smarty_tpl->getVariable('customizedDatas',null,true,false)->value[$_smarty_tpl->getVariable('productId',null,true,false)->value][$_smarty_tpl->getVariable('productAttributeId',null,true,false)->value])&&$_smarty_tpl->getVariable('quantityDisplayed')->value==0){?>
                                        <span id="cart_quantity_custom_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
">
                                            <?php echo $_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal'];?>

                                        </span>
                                    <?php }?>
                                    <?php if (!isset($_smarty_tpl->getVariable('customizedDatas',null,true,false)->value[$_smarty_tpl->getVariable('productId',null,true,false)->value][$_smarty_tpl->getVariable('productAttributeId',null,true,false)->value])||$_smarty_tpl->getVariable('quantityDisplayed')->value>0){?>
                                        <div id="cart_quantity_button" class="qty_spinner">
                                            <?php if ($_smarty_tpl->getVariable('quantityDisplayed')->value==0&&isset($_smarty_tpl->getVariable('customizedDatas',null,true,false)->value[$_smarty_tpl->getVariable('productId',null,true,false)->value][$_smarty_tpl->getVariable('productAttributeId',null,true,false)->value])){?>
                                                <?php $_smarty_tpl->tpl_vars['qty_btn_value'] = new Smarty_variable(count($_smarty_tpl->getVariable('customizedDatas')->value[$_smarty_tpl->getVariable('productId')->value][$_smarty_tpl->getVariable('productAttributeId')->value]), null, null);?>
                                            <?php }else{ ?>
                                                <?php $_smarty_tpl->tpl_vars['qty_btn_value'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['cart_quantity']-$_smarty_tpl->getVariable('quantityDisplayed')->value, null, null);?>
                                            <?php }?>

                                            <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('qty_btn_value')->value;?>
" name="quantity_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
_hidden" />
                                            <input type="hidden" class="cart_quantity_input" value="<?php echo $_smarty_tpl->getVariable('qty_btn_value')->value;?>
" name="quantity_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
" />
                                            <span><?php echo $_smarty_tpl->getVariable('qty_btn_value')->value;?>
</span>
                                        </div>
                                        <span style="font-size: 11px">
                                            <a rel="nofollow"
                                               class="cart_quantity_delete_noajax"
                                               id="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
"
                                               href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('cart.php',true);?>
?delete&amp;id_product=<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
&amp;ipa=<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']);?>
&amp;token=<?php echo $_smarty_tpl->getVariable('token_cart')->value;?>
"
                                               title="<?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>
"> <span>REMOVE</span></a>
                                        </span>
                                    <?php }else{ ?>
                                        <?php if ($_smarty_tpl->getVariable('quantityDisplayed')->value==0&&isset($_smarty_tpl->getVariable('customizedDatas',null,true,false)->value[$_smarty_tpl->getVariable('productId',null,true,false)->value][$_smarty_tpl->getVariable('productAttributeId',null,true,false)->value])){?>
                                        <?php }else{ ?>
                                            <?php echo $_smarty_tpl->tpl_vars['product']->value['cart_quantity']-$_smarty_tpl->getVariable('quantityDisplayed')->value;?>

                                        <?php }?>
                                    <?php }?>
                                </td>
                                <td class="cart_total">
                                    <span class="price" id="total_product_price_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
">
                                        <?php if ($_smarty_tpl->getVariable('quantityDisplayed')->value==0&&isset($_smarty_tpl->getVariable('customizedDatas',null,true,false)->value[$_smarty_tpl->getVariable('productId',null,true,false)->value][$_smarty_tpl->getVariable('productAttributeId',null,true,false)->value])){?>
                                            <?php if (!$_smarty_tpl->getVariable('priceDisplay')->value){?>
                                                <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['product']->value['total_customization_wt']),$_smarty_tpl);?>

                                            <?php }else{ ?>
                                                <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['product']->value['total_customization']),$_smarty_tpl);?>

                                            <?php }?>
                                        <?php }else{ ?>
                                            <?php if (!$_smarty_tpl->getVariable('priceDisplay')->value){?>
                                                <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['product']->value['total_wt']),$_smarty_tpl);?>

                                            <?php }else{ ?>
                                                <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['product']->value['total']),$_smarty_tpl);?>

                                            <?php }?>
                                        <?php }?>
                                    </span>
                                </td>
                            </tr>
                            <?php if (isset($_smarty_tpl->getVariable('customizedDatas',null,true,false)->value[$_smarty_tpl->getVariable('productId',null,true,false)->value][$_smarty_tpl->getVariable('productAttributeId',null,true,false)->value])){?>
                                <?php  $_smarty_tpl->tpl_vars['customization'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['id_customization'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('customizedDatas')->value[$_smarty_tpl->getVariable('productId')->value][$_smarty_tpl->getVariable('productAttributeId')->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['customization']->key => $_smarty_tpl->tpl_vars['customization']->value){
 $_smarty_tpl->tpl_vars['id_customization']->value = $_smarty_tpl->tpl_vars['customization']->key;
?>
                                    <tr id="product_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_customization']->value;?>
"
                                        class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['productLoop']['index']%2==0){?>alternate_item <?php }?>cart_item">
                                        <td colspan="4">
                                            <?php  $_smarty_tpl->tpl_vars['datas'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['customization']->value['datas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['datas']->key => $_smarty_tpl->tpl_vars['datas']->value){
 $_smarty_tpl->tpl_vars['type']->value = $_smarty_tpl->tpl_vars['datas']->key;
?>
                                                <?php if ($_smarty_tpl->tpl_vars['type']->value==$_smarty_tpl->getVariable('CUSTOMIZE_FILE')->value){?>
                                                    <div class="customizationUploaded">
                                                        <ul class="customizationUploaded">
                                                            <?php  $_smarty_tpl->tpl_vars['picture'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datas']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['picture']->key => $_smarty_tpl->tpl_vars['picture']->value){
?>
                                                                <li>
                                                                    <img
                                                                        src="<?php echo $_smarty_tpl->getVariable('pic_dir')->value;?>
<?php echo $_smarty_tpl->tpl_vars['picture']->value['value'];?>
_small"
                                                                        alt=""
                                                                        class="customizationUploaded" width="90px"/>
                                                                </li>
                                                            <?php }} ?>
                                                        </ul>
                                                    </div>
                                                <?php }elseif($_smarty_tpl->tpl_vars['type']->value==$_smarty_tpl->getVariable('CUSTOMIZE_TEXTFIELD')->value){?>
                                                    <ul class="typedText">
                                                        <?php  $_smarty_tpl->tpl_vars['textField'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datas']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['textField']->key => $_smarty_tpl->tpl_vars['textField']->value){
?>
                                                            <li style="padding-top: 10px;">
                                                                <?php if ($_smarty_tpl->tpl_vars['textField']->value['index']==13){?>
                                                                    <span style="display: inline-block; width: 350px; line-height: 1.2em; vertical-align: top; ">
                                                                        Style: <span style="text-transform: capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['choli_style'];?>
</span>
                                                                    </span>
                                                                    <span style="display: inline-block; width: 350px; line-height: 1.2em; vertical-align: top; ">
                                                                        Size: <span style="text-transform: capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['choli_size'];?>
</span>
                                                                    </span>
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['textField']->value['index']==21){?>
                                                                    Friend's Name:  <?php echo $_smarty_tpl->tpl_vars['customization']->value['friends_name'];?>

                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['textField']->value['index']==22){?>
                                                                    Friend's email:  <?php echo $_smarty_tpl->tpl_vars['customization']->value['friends_email'];?>

                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['textField']->value['index']==23){?>
                                                                    Gift Message: <?php echo $_smarty_tpl->tpl_vars['customization']->value['gift_message'];?>

                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['textField']->value['index']==10){?>
                                                                    + Long choli.
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['textField']->value['index']==11){?>
                                                                    + Long sleeves.
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['textField']->value['index']==9){?>
                                                                    Garment fabric.
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['textField']->value['index']==8){?>
                                                                    <?php if ($_smarty_tpl->tpl_vars['customization']->value['fall_piko']=="1"){?>
                                                                        Saree with unstitched blouse and fall/pico work.
                                                                    <?php }else{ ?>
                                                                        Saree with unstitched blouse and without fall/pico work.
                                                                    <?php }?>
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['textField']->value['index']==1){?>
                                                                    Pre-stitched saree with unstitched blouse and fall/pico work.
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['textField']->value['index']==2){?>
                                                                    <span style="width: 137px; display: inline-block; text-align: center;">
                                                                        <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
styles/<?php echo $_smarty_tpl->tpl_vars['customization']->value['blouse_style_image'];?>
" width="90px"/>
                                                                        <span style="font-family: Abel; font-size: 14px; display: block; width: 100%; line-height: 1em">
                                                                            <?php echo $_smarty_tpl->tpl_vars['customization']->value['blouse_style_name'];?>

                                                                        </span>
                                                                    </span>
                                                                    <span style="display: inline-block; width: 150px; line-height: 1.2em; vertical-align: top; padding-top: 10px;">
                                                                        Stitched to measure blouse
                                                                        <br />
                                                                        Measurement for: <span style="text-transform: capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['blouse_measurement'];?>
</span><br/>
                                                                        <?php if ($_smarty_tpl->tpl_vars['customization']->value['fall_piko']=="1"){?>
                                                                            <span>With fall/piko work</span>
                                                                        <?php }else{ ?>
                                                                            <span>Without fall/piko work</span>
                                                                        <?php }?>
                                                                    </span>
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['textField']->value['index']==3){?>
                                                                    <span style="width: 137px; display: inline-block; text-align: center;">
                                                                        <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
styles/<?php echo $_smarty_tpl->tpl_vars['customization']->value['inskirt_style_image'];?>
" width="90px"/>
                                                                        <span style="font-family: Abel; font-size: 14px; display: block; width: 100%; line-height: 1em">
                                                                            <?php echo $_smarty_tpl->tpl_vars['customization']->value['inskirt_style_name'];?>

                                                                        </span>
                                                                    </span>
                                                                    <span style="display: inline-block; width: 150px; line-height: 1.2em; vertical-align: top; padding-top: 10px;">
                                                                        Stitched to measure in-skirt
                                                                        <br />
                                                                        Measurement for: <span style="text-transform: capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['inskirt_measurement'];?>
</span><br/>
                                                                        <?php if ($_smarty_tpl->tpl_vars['customization']->value['fall_piko']=="1"){?>
                                                                            <span>With fall/piko work</span>
                                                                        <?php }else{ ?>
                                                                            <span>Without fall/piko work</span>
                                                                        <?php }?>
                                                                    </span>
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['textField']->value['index']==4){?>
                                                                    <span style="display: inline-block; width: 350px; line-height: 1.2em; vertical-align: top; padding-top: 10px;">
                                                                        Stitched to measure kurta
                                                                        <br />
                                                                        Measurement for: <span style="text-transform: capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['kurta_measurement'];?>
</span>
                                                                    </span>
                                                                    <span style="display: inline-block; width: 350px; line-height: 1.2em; vertical-align: top; padding-top: 10px;">
                                                                        Stitched to measure salwar
                                                                        <br />
                                                                        Measurement for: <span style="text-transform: capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['salwar_measurement'];?>
</span>
                                                                    </span>
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['textField']->value['index']==24){?>
                                                                    <?php if (isset($_smarty_tpl->tpl_vars['customization']->value['kurta_style_name'])&&!empty($_smarty_tpl->tpl_vars['customization']->value['kurta_style_name'])){?>
                                                                        <span style="width: 137px; display: inline-block; text-align: center;">
                                                                            <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
styles/<?php echo $_smarty_tpl->tpl_vars['customization']->value['kurta_style_image'];?>
" width="90px"/>
                                                                            <span style="font-family: Abel; font-size: 14px; display: block; width: 100%; line-height: 1em">
                                                                                <?php echo $_smarty_tpl->tpl_vars['customization']->value['kurta_style_name'];?>

                                                                            </span>
                                                                        </span>
                                                                        <span style="display: inline-block; width: 150px; line-height: 1.2em; vertical-align: top; padding-top: 10px;">
                                                                            Stitched to measure Kurta
                                                                            <br />
                                                                            Measurement for: <span style="text-transform: capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['kurta_measurement'];?>
</span>
                                                                        </span>
                                                                        <br />
                                                                    <?php }?>
                                                                    <?php if (isset($_smarty_tpl->tpl_vars['customization']->value['salwar_style_name'])&&!empty($_smarty_tpl->tpl_vars['customization']->value['salwar_style_name'])){?>
                                                                        <span style="width: 137px; display: inline-block; text-align: center;">
                                                                            <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
styles/<?php echo $_smarty_tpl->tpl_vars['customization']->value['salwar_style_image'];?>
" width="90px"/>
                                                                            <span style="font-family: Abel; font-size: 14px; display: block; width: 100%; line-height: 1em">
                                                                                <?php echo $_smarty_tpl->tpl_vars['customization']->value['salwar_style_name'];?>

                                                                            </span>
                                                                        </span>
                                                                        <span style="display: inline-block; width: 150px; line-height: 1.2em; vertical-align: top; padding-top: 10px;">
                                                                            Stitched to measure Salwar
                                                                            <br />
                                                                            Measurement for: <span style="text-transform: capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['salwar_measurement'];?>
</span>
                                                                       </span>
                                                                    <?php }?>
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['textField']->value['index']==5){?>
                                                                    <span style="width: 137px; display: inline-block; text-align: center;">
                                                                        <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
styles/<?php echo $_smarty_tpl->tpl_vars['customization']->value['choli_style_image'];?>
" width="90px"/>
                                                                        <span style="font-family: Abel; font-size: 14px; display: block; width: 100%; line-height: 1em">
                                                                            <?php echo $_smarty_tpl->tpl_vars['customization']->value['choli_style_name'];?>

                                                                        </span>
                                                                    </span>
                                                                    <span style="display: inline-block; width: 150px; line-height: 1.2em; vertical-align: top; padding-top: 10px;">
                                                                        Stitched to measure choli
                                                                        <br />
                                                                        Measurement for: <span style="text-transform: capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['choli_measurement'];?>
</span>
                                                                    </span>
                                                                    <br />
                                                                    <span style="width: 137px; display: inline-block; text-align: center;">
                                                                        <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
styles/<?php echo $_smarty_tpl->tpl_vars['customization']->value['lehenga_style_image'];?>
" width="90px"/>
                                                                        <span style="font-family: Abel; font-size: 14px; display: block; width: 100%; line-height: 1em">
                                                                            <?php echo $_smarty_tpl->tpl_vars['customization']->value['lehenga_style_name'];?>

                                                                        </span>
                                                                    </span>
                                                                    <span style="display: inline-block; width: 150px; line-height: 1.2em; vertical-align: top; padding-top: 10px;">
                                                                        Stitched to measure lehenga
                                                                        <br />
                                                                        Measurement for: <span style="text-transform: capitalize;"><?php echo $_smarty_tpl->tpl_vars['customization']->value['lehenga_measurement'];?>
</span>
                                                                    </span>
                                                                <?php }?>
                                                            </li>
                                                        <?php }} ?>
                                                    </ul>
                                                <?php }?>
                                            <?php }} ?>
                                        </td>
                                        <td class="cart_quantity" style="vertical-align: top; padding-top: 10px;text-align:center">
                                            <div id="cart_quantity_button" class="qty_spinner">
                                                <input
                                                    type="hidden"
                                                    value="<?php echo $_smarty_tpl->tpl_vars['customization']->value['quantity'];?>
"
                                                    name="quantity_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_customization']->value;?>
_hidden" /> <input
                                                    size="2"
                                                    type="hidden"
                                                    value="<?php echo $_smarty_tpl->tpl_vars['customization']->value['quantity'];?>
"
                                                    class="cart_quantity_input"
                                                    name="quantity_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_customization']->value;?>
" />
                                                <span><?php echo $_smarty_tpl->tpl_vars['customization']->value['quantity'];?>
</span>
                                            </div>
                                            <span style="font-size: 11px">
                                                <a rel="nofollow"
                                                   class="cart_quantity_delete"
                                                   id="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_customization']->value;?>
"
                                                   href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('cart.php',true);?>
?delete&amp;id_product=<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
&amp;ipa=<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']);?>
&amp;id_customization=<?php echo $_smarty_tpl->tpl_vars['id_customization']->value;?>
&amp;token=<?php echo $_smarty_tpl->getVariable('token_cart')->value;?>
">
                                                    <span>REMOVE</span>
                                                </a>
                                            </span>
                                        </td>
                                        <td class="cart_total">
                                        </td>
                                    </tr>
                                    <?php $_smarty_tpl->tpl_vars['quantityDisplayed'] = new Smarty_variable($_smarty_tpl->getVariable('quantityDisplayed')->value+$_smarty_tpl->tpl_vars['customization']->value['quantity'], null, null);?>
                                <?php }} ?>
                                <?php if ($_smarty_tpl->tpl_vars['product']->value['quantity']-$_smarty_tpl->getVariable('quantityDisplayed')->value>0){?>
                                    <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./shopping-cart-product-line.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                                <?php }?>
                            <?php }?>
                        <?php }} ?>
                    </tbody>
                    <?php if (sizeof($_smarty_tpl->getVariable('discounts')->value)||isset($_smarty_tpl->getVariable('cart_points_discount',null,true,false)->value)&&$_smarty_tpl->getVariable('cart_points_discount')->value>0){?>
                        <tbody>
                            <?php  $_smarty_tpl->tpl_vars['discount'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('discounts')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['discount']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['discount']->iteration=0;
 $_smarty_tpl->tpl_vars['discount']->index=-1;
if ($_smarty_tpl->tpl_vars['discount']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['discount']->key => $_smarty_tpl->tpl_vars['discount']->value){
 $_smarty_tpl->tpl_vars['discount']->iteration++;
 $_smarty_tpl->tpl_vars['discount']->index++;
 $_smarty_tpl->tpl_vars['discount']->first = $_smarty_tpl->tpl_vars['discount']->index === 0;
 $_smarty_tpl->tpl_vars['discount']->last = $_smarty_tpl->tpl_vars['discount']->iteration === $_smarty_tpl->tpl_vars['discount']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['discountLoop']['first'] = $_smarty_tpl->tpl_vars['discount']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['discountLoop']['last'] = $_smarty_tpl->tpl_vars['discount']->last;
?>

                                <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['discountLoop']['last']){?>
                                    <?php $_smarty_tpl->tpl_vars['trclass'] = new Smarty_variable('last_item', null, null);?>
                                <?php }elseif($_smarty_tpl->getVariable('smarty')->value['foreach']['discountLoop']['first']){?>
                                    <?php $_smarty_tpl->tpl_vars['trclass'] = new Smarty_variable('first_item', null, null);?>
                                <?php }else{ ?>
                                    <?php $_smarty_tpl->tpl_vars['trclass'] = new Smarty_variable('item', null, null);?>
                                <?php }?>
                                
                                <?php if (strpos('B1G1',$_smarty_tpl->tpl_vars['discount']->value['name'])!=0){?>
                                <tr class="cart_discount <?php echo $_smarty_tpl->getVariable('trclass')->value;?>
" id="cart_discount_<?php echo $_smarty_tpl->tpl_vars['discount']->value['id_discount'];?>
">
                                    <td class="cart_discount_name" colspan="4" style="text-align: right">
                                        
                                            <?php echo $_smarty_tpl->tpl_vars['discount']->value['name'];?>

                                            <?php if ($_smarty_tpl->tpl_vars['discount']->value['description']!=''){?> : <?php echo $_smarty_tpl->tpl_vars['discount']->value['description'];?>
 <?php }?>
                                        
                                    </td>
                                    <td class="cart_discount_delete">
                                        <a href="<?php if ($_smarty_tpl->getVariable('opc')->value){?><?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('order-opc.php',true);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('order.php',true);?>
<?php }?>?deleteDiscount=<?php echo $_smarty_tpl->tpl_vars['discount']->value['id_discount'];?>
"
                                           title="<?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>
">
                                            <img src="<?php echo $_smarty_tpl->getVariable('img_dir')->value;?>
icon/delete.gif" alt="<?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>
"
                                                 class="icon" width="11" height="13" />
                                        </a>
                                    </td>
                                    <td class="cart_discount_price">
                                        <span class="price-discount">
                                            <?php if ($_smarty_tpl->tpl_vars['discount']->value['value_real']>0){?>
                                                <?php if (!$_smarty_tpl->getVariable('priceDisplay')->value){?>
                                                    <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['discount']->value['value_real']*-1),$_smarty_tpl);?>

                                                <?php }else{ ?>
                                                    <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['discount']->value['value_tax_exc']*-1),$_smarty_tpl);?>

                                                <?php }?>
                                            <?php }?>
                                        </span>
                                    </td>
                                </tr>
                                <?php }?>
                            <?php }} ?>
                            <?php if (isset($_smarty_tpl->getVariable('cart_points_discount',null,true,false)->value)&&$_smarty_tpl->getVariable('cart_points_discount')->value>0){?>
                                <tr class="cart_discount" id="cart_points">
                                    <td class="cart_discount_name" colspan="4" style="text-align:right">
                                        Diva Coins redeemed: <?php echo $_smarty_tpl->getVariable('cart_redeem_points')->value;?>

                                    </td>
                                    <td class="cart_discount_delete">
                                        <a href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('order.php',true);?>
?deletePoints=1" title="<?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>
">
                                            <img src="<?php echo $_smarty_tpl->getVariable('img_dir')->value;?>
icon/delete.gif" alt="<?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>
" class="icon" width="11" height="13" />
                                        </a>
                                    </td>
                                    <td class="cart_discount_price">
                                        <span class="price-discount"> <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('cart_points_discount')->value*-1),$_smarty_tpl);?>
 </span>
                                    </td>
                                </tr>
                            <?php }?>
                        </tbody>
                    <?php }?>
                </table>
            </div>
            <?php if ($_smarty_tpl->getVariable('voucherAllowed')->value){?>
                <div id="cart_redeem" style="padding: 10px 0 30px 0">
                    <?php if (isset($_smarty_tpl->getVariable('errors_discount',null,true,false)->value)&&$_smarty_tpl->getVariable('errors_discount')->value){?>
                        <ul class="error">
                            <?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('errors_discount')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['error']->key;
?>
                                <li>
                                    <?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['error']->value,'htmlall','UTF-8');?>

                                </li>
                            <?php }} ?>
                        </ul>
                    <?php }?>
                    <div style="text-align: right; padding-right: 0.7em;">
            <?php if ($_smarty_tpl->getVariable('displayVouchers')->value||isset($_smarty_tpl->getVariable('can_redeem_points',null,true,false)->value)&&(isset($_smarty_tpl->getVariable('balance_points',null,true,false)->value)&&$_smarty_tpl->getVariable('balance_points')->value>0)||isset($_smarty_tpl->getVariable('redeem_points',null,true,false)->value)&&$_smarty_tpl->getVariable('redeem_points')->value>0){?>
                <?php $_smarty_tpl->tpl_vars['check'] = new Smarty_variable("checked='checked'", null, null);?>
                <?php $_smarty_tpl->tpl_vars['display'] = new Smarty_variable('block', null, null);?>
                <?php $_smarty_tpl->tpl_vars['show_redemption'] = new Smarty_variable(true, null, null);?>
            <?php }else{ ?>
                <?php $_smarty_tpl->tpl_vars['check'] = new Smarty_variable('', null, null);?>
                <?php $_smarty_tpl->tpl_vars['display'] = new Smarty_variable('none', null, null);?>
                <?php $_smarty_tpl->tpl_vars['show_redemption'] = new Smarty_variable(false, null, null);?>
            <?php }?>
                        <input type="checkbox" id="chk_redeem" class="redeem_check" <?php echo $_smarty_tpl->getVariable('check')->value;?>
>
                        <label for="chk_redeem" style="font-size: 12px; display: inline-block">
                            <?php echo smartyTranslate(array('s'=>'Redeem vouchers'),$_smarty_tpl);?>

                        </label>
                    </div>
                    <form action="<?php if ($_smarty_tpl->getVariable('opc')->value){?><?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('order-opc.php',true);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('order.php',true);?>
<?php }?>"
                          method="post"
                          id="voucher">
                        <fieldset>
                            <div style="padding: 20px 200px 20px 150px; border-top: 1px dashed #cacaca; border-bottom: 1px dashed #cacaca; display: <?php echo $_smarty_tpl->getVariable('display')->value;?>
; float:left; width:52%"
                                 class="redemption_control">
                                <?php if (isset($_smarty_tpl->getVariable('can_redeem_points',null,true,false)->value)&&(isset($_smarty_tpl->getVariable('balance_points',null,true,false)->value)&&$_smarty_tpl->getVariable('balance_points')->value>0)||isset($_smarty_tpl->getVariable('redeem_points',null,true,false)->value)&&$_smarty_tpl->getVariable('redeem_points')->value>0){?>
                                    <div style="text-align: left">
                                        <span style="font-size:15px;display:inline-block;<?php if (!isset($_smarty_tpl->getVariable('can_redeem_points',null,true,false)->value)){?>color:#939393<?php }?>">
                                            <?php echo smartyTranslate(array('s'=>'Redeem Diva Coins'),$_smarty_tpl);?>

                                            <span style="font-size:12px;color:#939393;">
                                                [<?php echo $_smarty_tpl->getVariable('balance_points')->value-$_smarty_tpl->getVariable('cart_redeem_points')->value;?>
 Redeemable 
                                                <?php if (isset($_smarty_tpl->getVariable('balance_cash',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('balance_cash',null,true,false)->value)){?>
                                                    (Equals to <b><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('balance_cash')->value),$_smarty_tpl);?>
</b>)]
                                                <?php }?>
                                            </span>
                                        </span>
                                        <?php if (isset($_smarty_tpl->getVariable('redeem_points',null,true,false)->value)&&$_smarty_tpl->getVariable('redeem_points')->value>0){?>
                                            <p style="font-size:12px;color:#939393;">You redeemed <?php echo $_smarty_tpl->getVariable('redeem_points')->value;?>
 Coins in this order.</p>
                                        <?php }else{ ?>
                                            <?php if ($_smarty_tpl->getVariable('redemption_status')->value==2){?>
                                                <input type="text" id="redeem_points" name="redeem_points" value="<?php if (isset($_smarty_tpl->getVariable('redeem_points',null,true,false)->value)&&$_smarty_tpl->getVariable('redeem_points')->value){?><?php echo $_smarty_tpl->getVariable('redeem_points')->value;?>
<?php }?>" />
                                            <?php }else{ ?>
                                                <p style="font-size:12px;color:#939393;"><?php echo $_smarty_tpl->getVariable('redemption_status_message')->value;?>
</p>
                                            <?php }?>
                                        <?php }?>
                                    </div>
                                <?php }?>
                                <div style="text-align: left">
                                    <span style="font-size: 15px; width: 150px; display: block"><?php echo smartyTranslate(array('s'=>'Voucher Code'),$_smarty_tpl);?>
</span>
                                    <input type="text"
                                           id="discount_name"
                                           name="discount_name"
                                           value="<?php if (isset($_smarty_tpl->getVariable('discount_name',null,true,false)->value)&&$_smarty_tpl->getVariable('discount_name')->value){?><?php echo $_smarty_tpl->getVariable('discount_name')->value;?>
<?php }?>" />
                                </div>
                                <div class="submit" style="text-align: left; padding:15px 0 15px 8px">
                                    <input
                                        type="hidden"
                                        name="submitDiscount" />
                                    <input
                                        type="submit"
                                        name="submitAddDiscount"
                                        value="<?php echo smartyTranslate(array('s'=>'Redeem!'),$_smarty_tpl);?>
"
                                        class="button"
                                        style="display: inline-block;" />
                                </div>
                                <?php if ($_smarty_tpl->getVariable('displayVouchers')->value){?>
                                    <h4 style="padding-left:10px;"><?php echo smartyTranslate(array('s'=>'Vouchers in your account:'),$_smarty_tpl);?>
</h4>
                                    <div id="display_cart_vouchers" style="padding-left:10px;">
                                        <?php  $_smarty_tpl->tpl_vars['voucher'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('displayVouchers')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['voucher']->key => $_smarty_tpl->tpl_vars['voucher']->value){
?>
                                            <span onclick="$('#discount_name').val('<?php echo $_smarty_tpl->tpl_vars['voucher']->value['name'];?>
'); return false;" class="voucher_name">
                                                <?php echo $_smarty_tpl->tpl_vars['voucher']->value['name'];?>

                                            </span> - <?php echo $_smarty_tpl->tpl_vars['voucher']->value['description'];?>

                                            <br />
                                        <?php }} ?>
                                    </div>
                                <?php }?>
                            </div>
                        </fieldset>
                    </form>
                </div>
            <?php }?>
            <div id="HOOK_SHOPPING_CART">
                <?php echo $_smarty_tpl->getVariable('HOOK_SHOPPING_CART')->value;?>

            </div>
            <div id="cart_navigation" class="cart_navigation">
                <?php if (!$_smarty_tpl->getVariable('opc')->value){?>
                    <?php if ($_smarty_tpl->getVariable('cookie')->value->isLogged()){?>
                        <?php if (isset($_smarty_tpl->getVariable('cart',null,true,false)->value->id_address_delivery)&&$_smarty_tpl->getVariable('cart')->value->id_address_delivery>0&&isset($_smarty_tpl->getVariable('cart',null,true,false)->value->id_address_invoice)&&$_smarty_tpl->getVariable('cart')->value->id_address_invoice>0){?>
                            <a id="place_order_button"
                               rel="nofollow"
                               href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('order.php',true);?>
?step=3<?php if ($_smarty_tpl->getVariable('back')->value){?>&amp;back=<?php echo $_smarty_tpl->getVariable('back')->value;?>
<?php }?>"
                               class="placeorder place_order_button"></a>
                        <?php }else{ ?>
                            <a id="place_order_button"
                               rel="nofollow"
                               href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('order.php',true);?>
?step=1<?php if ($_smarty_tpl->getVariable('back')->value){?>&amp;back=<?php echo $_smarty_tpl->getVariable('back')->value;?>
<?php }?>"
                               class="placeorder place_order_button"></a>
                        <?php }?>
                    <?php }else{ ?>
                        <a
                            id="place_order_button"
                            rel="nofollow"
                            href="#login_modal_panel"
                            class="placeorder place_order_button"></a>
                    <?php }?>
                <?php }?>
                <a rel="nofollow"
                   href="<?php if ((isset($_SERVER['HTTP_REFERER'])&&strstr($_SERVER['HTTP_REFERER'],'order.php'))||!isset($_SERVER['HTTP_REFERER'])){?><?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('index.php');?>
<?php }else{ ?><?php echo Tools::secureReferrer(smarty_modifier_escape($_SERVER['HTTP_REFERER'],'htmlall','UTF-8'));?>
<?php }?>"
                   class="secondary"
                   title="<?php echo smartyTranslate(array('s'=>'Continue shopping'),$_smarty_tpl);?>
"
                   style="width: 151px; margin-top: 5px; float: left; margin-bottom: 5px;">
                    &laquo; <?php echo smartyTranslate(array('s'=>'Continue Shopping'),$_smarty_tpl);?>

                </a>
            </div>
            <div class="clear"></div>

            <p class="cart_navigation_extra">
                <span id="HOOK_SHOPPING_CART_EXTRA"><?php echo $_smarty_tpl->getVariable('HOOK_SHOPPING_CART_EXTRA')->value;?>
</span>
            </p>
        <?php }?>
    </div>
    <?php if (!isset($_smarty_tpl->getVariable('summary_only',null,true,false)->value)&&!isset($_smarty_tpl->getVariable('empty',null,true,false)->value)){?>
        <div id="co_rht_col" style="padding-top:0px;width:210px;">
            <div class="co_rht_box" style="margin-left:10px; border:1px solid #cacaca; -moz-border-radius: 5px; -webkit-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px; margin-bottom:20px;">
                <div id="order_summary_title" class="rht_box_heading" style="background:#EDEDED; padding: 5px 0">
                    Order Summary
                </div>
                <div id="order_summary_content" class="rht_box_info">
                    <table>
                        <tbody>
                            <?php if ($_smarty_tpl->getVariable('productNumber')->value>0){?>
                                <tr>
                                    <td class="row_title">Items</td>
                                    <td>:</td>
                                    <td class="row_val">
                                        <span class="ajax_cart_quantity" style="font-size: 12px;">
                                            <?php echo $_smarty_tpl->getVariable('productNumber')->value;?>

                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="row_title">Products Total</td>
                                    <td>:</td>
                                    <td class="row_val">
                                        <span class="ajax_products_total">
                                            <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('total_products_wt')->value),$_smarty_tpl);?>

                                        </span>
                                    </td>
                                </tr>
                                <?php if ($_smarty_tpl->getVariable('total_discounts')->value!=0){?>
                                    <tr>
                                        <td class="row_title">Discounts</td>
                                        <td>:</td>
                                        <td class="row_val">
                                            <span class="ajax_cart_discounts">
                                                <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('total_discounts')->value),$_smarty_tpl);?>

                                            </span>
                                        </td>
                                    </tr>
                                <?php }?>
                                <tr>
                                    <td class="row_title">Sub Total</td>
                                    <td>:</td>
                                    <td class="row_val">
                                        <span class="ajax_cart_total">
                                            <?php echo Tools::displayPriceSmarty(array('price'=>($_smarty_tpl->getVariable('total_price')->value-$_smarty_tpl->getVariable('shippingCost')->value)),$_smarty_tpl);?>

                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align:center;padding:5px 20px">
                                        <?php if ($_smarty_tpl->getVariable('cookie')->value->isLogged()){?>
                                            <?php if (isset($_smarty_tpl->getVariable('cart',null,true,false)->value->id_address_delivery)&&$_smarty_tpl->getVariable('cart')->value->id_address_delivery>0&&isset($_smarty_tpl->getVariable('cart',null,true,false)->value->id_address_invoice)&&$_smarty_tpl->getVariable('cart')->value->id_address_invoice>0){?>
                                                <a rel="nofollow"
                                                   class="button exclusive small place_order_button"
                                                   href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('order.php',true);?>
?step=3<?php if ($_smarty_tpl->getVariable('back')->value){?>&amp;back=<?php echo $_smarty_tpl->getVariable('back')->value;?>
<?php }?>"
                                                   style="margin:auto" title="Place Order">Place Order</a>
                                            <?php }else{ ?>
                                                <a rel="nofollow" class="button exclusive small place_order_button"
                                                   href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('order.php',true);?>
?step=1<?php if ($_smarty_tpl->getVariable('back')->value){?>&amp;back=<?php echo $_smarty_tpl->getVariable('back')->value;?>
<?php }?>"
                                                   style="margin:auto" title="Place Order">Place Order</a>
                                            <?php }?>
                                        <?php }else{ ?>
                                            <a rel="nofollow"
                                               class="button exclusive small place_order_button"
                                               href="#login_modal_panel"
                                               style="margin:auto" title="Place Order">Place Order</a>
                                        <?php }?>
                                    </td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="co_rht_box" style="margin-left:10px; border:1px solid #cacaca; -moz-border-radius: 5px; -webkit-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px; margin-bottom:20px;">
                <div id="order_summary_title" class="rht_box_heading" style="padding: 5px 0">
                    Shop With Confidence
                </div>
                <div id="order_summary_content" class="rht_box_info">
                    <table>
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    Its completely safe to shop with us. We partner with the most trusted online payment solution providers. <br />
                                    <table width="135" border="0" cellpadding="2" cellspacing="0" title="Click to Verify - This site chose Symantec SSL for secure e-commerce and confidential communications.">
                                        <tr>
                                            <td width="135" align="center" valign="top">
                                                <script type="text/javascript" src="https://seal.verisign.com/getseal?host_name=www.indusdiva.com&amp;size=L&amp;use_flash=YES&amp;use_transparent=YES&amp;lang=en"></script><br />
                                                <a href="http://www.symantec.com/ssl-certificates" target="_blank"  style="color:#000000; text-decoration:none; font:bold 7px verdana,sans-serif; letter-spacing:.5px; text-align:center; margin:0px; padding:0px;">ABOUT SSL CERTIFICATES</a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="co_rht_box" style="margin-left:10px; border:1px solid #cacaca; -moz-border-radius: 5px; -webkit-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px; margin-bottom:20px;">
                <div id="order_summary_title" class="rht_box_heading" style="padding: 5px 0">
                    Questions? Just ask!
                </div>
                <div
                    id="order_summary_content"
                    class="rht_box_info" style="text-align:center">
                    <span id="asksupportlink" class="span_link" style="color:#A41E21">
                        Ask our live support
                    </span>
                </div>
            </div>
            
        </div>
    <?php }?>
    <script type="text/javascript">
        <?php if (!$_smarty_tpl->getVariable('cookie')->value->isLogged()){?>
                var orderStepURL = '<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('order.php',true);?>
?step=1<?php if ($_smarty_tpl->getVariable('back')->value){?>&amp;back=<?php echo $_smarty_tpl->getVariable('back')->value;?>
<?php }?>';
        <?php }else{ ?>
                var orderStepURL = false;
        <?php }?>
                var vouchersAvailable = false;
        <?php if ($_smarty_tpl->getVariable('show_redemption')->value){?>
                vouchersAvailable = true;
        <?php }?>
        var blinkc = 0;
        
            $(document).ready(function() {
                    $('#asksupportlink').click(function() {
                    $zopim.livechat.window.show();
                            $zopim.livechat.say('I need help with checkout!')
                    });
                            if (!vouchersAvailable)
                            $('#chk_redeem').removeAttr('checked');
                            if ($('#redeem_points').val() || $('#discount_name').val())
                    {
                    $('#chk_redeem').attr('checked', 'checked');
                            $(".redemption_control").show();
                    }

                    $('#chk_redeem').click(function() {
                    if ($("#chk_redeem ").is(':checked'))
                            $(".redemption_control").show();
                            else
                            $(".redemption_control").hide();
                    });
                            $('.place_order_button').click(function(e) {
                    if ($('#redeem_points').val() || $('#discount_name').val())
                    {
                    if (!confirm('Continue place order without redeeming?'))
                            e.preventDefault();
                    }

                    if (orderStepURL)
                    {
                    requestURI = orderStepURL;
                            $('#id_back').val('order.php?step=1');
                            $.fancybox.open({
                    href: '#login_modal_panel'
                    });
                    }
                    try {
                    _sokAddtoCartPixel();
                    } catch (err) {
                    }
                    });
                    });        </script>
        <!-- sokrati -->
        <script type="text/javascript">
                            <!--
        _sokClient = '249';
                            //-->
        </script>
        <script type="text/javascript">
                            var sokhost = ("https:" == document.location.protocol) ? "https://tracking.sokrati.com" : "http://cdn.sokrati.com";
                            var sokratiJS = sokhost + '/javascripts/tracker.js';
                            document.write(unescape("%3Cscript src='" + sokratiJS + "' type='text/javascript'%3E%3C/script%3E"));</script>
        <script type="text/javascript">
                            var paramList = {};
                            paramList['lead_step'] = 'Add2Bag';</script>
        <script type="text/javascript">
                            try {
    sokrati.trackSaleParams("0", "0", "<?php echo $_smarty_tpl->getVariable('total_price')->value;?>
", "<?php echo $_smarty_tpl->getVariable('productNumber')->value;?>
", paramList);
                    }
                    catch (err) {
                    }
        </script>
    </div>
