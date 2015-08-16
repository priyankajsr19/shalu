<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 13:00:00
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/./product_card.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13078438475562cf78626352-75937206%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '37536972afb74052056d479384ed54b6feb4522d' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/./product_card.tpl',
      1 => 1432385541,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13078438475562cf78626352-75937206',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/tools/smarty/plugins/modifier.escape.php';
?><div class=" product_card">
    <?php if (!$_smarty_tpl->getVariable('productitem')->value['inStock']){?>
        <img alt="Out Of Stock" src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
out_of_stock_vs.png" style="margin:0 0;position:absolute;left:1px; top:1px;"/>
    <?php }else{ ?>
        <?php if (in_array("buy1get1",$_smarty_tpl->getVariable('productitem')->value['tags'])){?>
            <img alt="Buy1-Get1" src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
b1g1_50.png" style="margin:0 0;position:absolute;left:0px; top:1px;"/>
        <?php }else{ ?>
                        <?php if ($_smarty_tpl->getVariable('productitem')->value['isPlusSize']){?>
                            <img alt="plus size garment" src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
plussize_s.png" style="margin:0 0;position:absolute;left:1px; top:1px;"/>
                        <?php }else{ ?>
                            <?php if ($_smarty_tpl->getVariable('productitem')->value['isRTS']){?>
                                <img alt="Ready to stich garment" width="64px" height="31px" src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
rts1.png" style="margin:0 0;position:absolute;left:1px; top:1px;"/>
                            <?php }?>           
                        <?php }?>
                    <?php }?>
    <?php }?>
    <a href="<?php echo $_smarty_tpl->getVariable('productitem')->value['product_link'];?>
">
        <span class="product_image_large" href="<?php echo $_smarty_tpl->getVariable('productitem')->value['product_link'];?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('productitem')->value['name'],'html','UTF-8');?>
">
            <?php if (isset($_smarty_tpl->getVariable('lazy',null,true,false)->value)&&$_smarty_tpl->getVariable('lazy')->value==1){?>
                <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
blank.jpg" data-href="<?php echo $_smarty_tpl->getVariable('productitem')->value['image_link_list'];?>
" height="342" width="250" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('productitem')->value['name'],'html','UTF-8');?>
"  class="lazy"/>
                <noscript>
                <img src="<?php echo $_smarty_tpl->getVariable('productitem')->value['image_link_list'];?>
" height="342" width="250" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('productitem')->value['name'],'html','UTF-8');?>
" />
                </noscript>
            <?php }else{ ?>
                <img src="<?php echo $_smarty_tpl->getVariable('productitem')->value['image_link_list'];?>
" height="342" width="250" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('productitem')->value['name'],'html','UTF-8');?>
" />
            <?php }?>
        </span>
        <span class="product-list-name">
            <h2 class="product_card_name"><?php echo smarty_modifier_escape(smarty_modifier_truncate($_smarty_tpl->getVariable('productitem')->value['name'],100,'...'),'htmlall','UTF-8');?>
</h2>
        </span>
        <span class="product_info">
            <?php if ($_smarty_tpl->getVariable('price_tax_country')->value==110){?>
                <span class="price"><?php echo Product::convertAndShow(array('price'=>$_smarty_tpl->getVariable('productitem')->value['offer_price_in']),$_smarty_tpl);?>
</span>
                <?php if (($_smarty_tpl->getVariable('productitem')->value['discount']>0)){?>
                    <span class="strike_price"><?php echo Product::convertAndShow(array('price'=>$_smarty_tpl->getVariable('productitem')->value['mrp_in']),$_smarty_tpl);?>
</span>
                    <span style="color:#DA0F00;">(<?php echo $_smarty_tpl->getVariable('productitem')->value['discount'];?>
% Off)</span>
                <?php }?>
            <?php }else{ ?>
                <span class="price"><?php echo Product::convertAndShow(array('price'=>$_smarty_tpl->getVariable('productitem')->value['offer_price']),$_smarty_tpl);?>
</span>
                <?php if (($_smarty_tpl->getVariable('productitem')->value['discount']>0)){?>
                    <span class="strike_price"><?php echo Product::convertAndShow(array('price'=>$_smarty_tpl->getVariable('productitem')->value['mrp']),$_smarty_tpl);?>
</span>
                    <span style="color:#DA0F00;">(<?php echo $_smarty_tpl->getVariable('productitem')->value['discount'];?>
% Off)</span>
                <?php }?>
            <?php }?>
        </span>
        <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./product_shipping_sla.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
    </a>
    <a id="ajax_id_product_<?php echo $_smarty_tpl->getVariable('productitem')->value['id_product'];?>
" class="quick_view_link fancybox.ajax quickview" rel="nofollow" href="<?php echo $_smarty_tpl->getVariable('base_dir')->value;?>
quickview.php?id=<?php echo $_smarty_tpl->getVariable('productitem')->value['id_product'];?>
">QUICK VIEW</a>
</div>
