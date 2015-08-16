<?php /* Smarty version Smarty-3.0.7, created on 2015-08-16 17:58:07
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/./product_page_price.tpl" */ ?>
<?php /*%%SmartyHeaderCode:177444108455d081d7544f09-90854767%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '43c9cac3eb282f63c16a31e56ba8f52fa0f5a43f' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/./product_page_price.tpl',
      1 => 1438764192,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '177444108455d081d7544f09-90854767',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
	<div class="price-info">
                <!-- prices -->
                <?php if ($_smarty_tpl->getVariable('product')->value->show_price&&!isset($_smarty_tpl->getVariable('restricted_country_mode',null,true,false)->value)&&!$_smarty_tpl->getVariable('PS_CATALOG_MODE')->value){?>
                    <p class="price">

                        <?php if (!$_smarty_tpl->getVariable('priceDisplay')->value||$_smarty_tpl->getVariable('priceDisplay')->value==2){?>
                            <?php $_smarty_tpl->tpl_vars['productPrice'] = new Smarty_variable($_smarty_tpl->getVariable('product')->value->getPrice(true,@NULL,2), null, null);?>
                            <?php $_smarty_tpl->tpl_vars['productPriceWithoutRedution'] = new Smarty_variable($_smarty_tpl->getVariable('product')->value->getPriceWithoutReduct(false,@NULL), null, null);?>
                        <?php }elseif($_smarty_tpl->getVariable('priceDisplay')->value==1){?>
                            <?php $_smarty_tpl->tpl_vars['productPrice'] = new Smarty_variable($_smarty_tpl->getVariable('product')->value->getPrice(false,@NULL,2), null, null);?>
                            <?php $_smarty_tpl->tpl_vars['productPriceWithoutRedution'] = new Smarty_variable($_smarty_tpl->getVariable('product')->value->getPriceWithoutReduct(true,@NULL), null, null);?>
                        <?php }?>
                        <?php if ($_smarty_tpl->getVariable('product')->value->specificPrice&&$_smarty_tpl->getVariable('product')->value->specificPrice['reduction']){?>
                            <span id="old_price">
                                <?php if ($_smarty_tpl->getVariable('priceDisplay')->value>=0&&$_smarty_tpl->getVariable('priceDisplay')->value<=2){?>
                                    <?php if ($_smarty_tpl->getVariable('productPriceWithoutRedution')->value>$_smarty_tpl->getVariable('productPrice')->value){?>
                                        <span id="old_price_display"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('productPriceWithoutRedution')->value),$_smarty_tpl);?>
</span>
                                    <?php }?>
                                <?php }?>
                            </span>
                        <?php }?>

                        <?php if ($_smarty_tpl->getVariable('priceDisplay')->value>=0&&$_smarty_tpl->getVariable('priceDisplay')->value<=2){?>
                            <span id="our_price_display">
                                <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->getVariable('productPrice')->value),$_smarty_tpl);?>

                            </span>
                        <?php }?>

                        <span style="border-left:1px solid #cacaca;padding:5px">Product Code:  <?php echo $_smarty_tpl->getVariable('product')->value->reference;?>
</span>
                        <?php if ($_smarty_tpl->getVariable('product')->value->is_plussize){?>
                            <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
plusize_m.png" alt="PlusSize Gargment" style="float:right"/>
                        <?php }elseif($_smarty_tpl->getVariable('product')->value->is_rts){?>
                            <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
rts1.png" width="85px" height="41px" alt="Ready to stitch Gargment" style="float:right"/>
                        <?php }?>
                    </p>
                <?php }?>
            </div>
