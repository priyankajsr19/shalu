<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 14:00:18
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme//product-recent-viewed.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1502875935562dd9a66d571-63136151%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9c6c2fba9117a6fbad527251f1240ee0991acf2a' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme//product-recent-viewed.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1502875935562dd9a66d571-63136151',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/tools/smarty/plugins/modifier.escape.php';
?>
    <?php if (isset($_smarty_tpl->getVariable('recently_viewed',null,true,false)->value)&&count($_smarty_tpl->getVariable('recently_viewed')->value)>0){?>
        <div id="recent_products" class="sheets" style="padding:10px 0;float:left;width:100%">
            <div class="panel_title" style="width:80%;">
                RECENTLY VIEWED
            </div>
            <div  class="products_block_medium">
                <a class="prev browse left">Prev</a>
                <div class="scrollable">
                    <div class="items">
                        <?php  $_smarty_tpl->tpl_vars['productitem'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('recently_viewed')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['productitem']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['productitem']->iteration=0;
 $_smarty_tpl->tpl_vars['productitem']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['recentProducts']['index']=-1;
if ($_smarty_tpl->tpl_vars['productitem']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['productitem']->key => $_smarty_tpl->tpl_vars['productitem']->value){
 $_smarty_tpl->tpl_vars['productitem']->iteration++;
 $_smarty_tpl->tpl_vars['productitem']->index++;
 $_smarty_tpl->tpl_vars['productitem']->first = $_smarty_tpl->tpl_vars['productitem']->index === 0;
 $_smarty_tpl->tpl_vars['productitem']->last = $_smarty_tpl->tpl_vars['productitem']->iteration === $_smarty_tpl->tpl_vars['productitem']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['recentProducts']['first'] = $_smarty_tpl->tpl_vars['productitem']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['recentProducts']['index']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['recentProducts']['last'] = $_smarty_tpl->tpl_vars['productitem']->last;
?>
                            <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['recentProducts']['first']==true||$_smarty_tpl->getVariable('smarty')->value['foreach']['recentProducts']['index']%5==0){?>
                                <div>
                                    <ul>
                                    <?php }?>
                                    <li class="ajax_block_product" rel="<?php echo $_smarty_tpl->tpl_vars['productitem']->value['id_product'];?>
" >
                                        <div class="product_card">
                                            <?php if (!$_smarty_tpl->tpl_vars['productitem']->value['inStock']){?>
                                                <img alt="Out Of Stock" src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
out_of_stock_vs.png" style="margin:0 0;position:absolute;left:1px; top:0px;"/>
                                            <?php }?>
                                            <a href="<?php echo $_smarty_tpl->tpl_vars['productitem']->value['product_link'];?>
">
                                                <span class="product_image_medium" href="<?php echo $_smarty_tpl->tpl_vars['productitem']->value['product_link'];?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['productitem']->value['name'],'html','UTF-8');?>
">
                                                    <?php if (isset($_smarty_tpl->getVariable('lazy',null,true,false)->value)&&$_smarty_tpl->getVariable('lazy')->value==1){?>
                                                        <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
blank.jpg" data-href="<?php echo $_smarty_tpl->tpl_vars['productitem']->value['image_link_medium'];?>
" height="205" width="150" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['productitem']->value['name'],'html','UTF-8');?>
"  class="delaylazy"/>
                                                        <noscript>
                                                        <img src="<?php echo $_smarty_tpl->tpl_vars['productitem']->value['image_link_medium'];?>
" height="205" width="150" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['productitem']->value['name'],'html','UTF-8');?>
" />
                                                        </noscript>
                                                    <?php }else{ ?>
                                                        <img src="<?php echo $_smarty_tpl->tpl_vars['productitem']->value['image_link_medium'];?>
" height="205" width="150" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['productitem']->value['name'],'html','UTF-8');?>
"/>
                                                    <?php }?>
                                                </span>
                                                <span class="product-list-name">
                                                    <h2 class="product_card_name"><?php echo smarty_modifier_escape(smarty_modifier_truncate($_smarty_tpl->tpl_vars['productitem']->value['name'],100,'...'),'htmlall','UTF-8');?>
</h2>
                                                </span>
                                                <span class="product_info">
                                                    <span class="product_info">
                                                        <?php if ($_smarty_tpl->getVariable('price_tax_country')->value==110){?>
                                                            <span class="price">
                                                                <?php echo Product::convertAndShow(array('price'=>$_smarty_tpl->tpl_vars['productitem']->value['offer_price_in']),$_smarty_tpl);?>

                                                                <!--span class="price_inr">(Rs <?php echo round($_smarty_tpl->tpl_vars['productitem']->value['offer_price_in']*$_smarty_tpl->getVariable('conversion_rate')->value);?>
)</span-->
                                                            </span>
                                                            <?php if (($_smarty_tpl->tpl_vars['productitem']->value['discount']>0)){?>
                                                                <span class="strike_price"><?php echo Product::convertAndShow(array('price'=>$_smarty_tpl->tpl_vars['productitem']->value['mrp_in']),$_smarty_tpl);?>
</span>
                                                                <span class="clear" style="display:block;color:#DA0F00;">(<?php echo $_smarty_tpl->tpl_vars['productitem']->value['discount'];?>
% Off)</span>
                                                            <?php }?>
                                                        <?php }else{ ?>
                                                            <span class="price">
                                                                <?php echo Product::convertAndShow(array('price'=>$_smarty_tpl->tpl_vars['productitem']->value['offer_price']),$_smarty_tpl);?>

                                                                <!--span class="price_inr">(Rs <?php echo round($_smarty_tpl->tpl_vars['productitem']->value['offer_price']*$_smarty_tpl->getVariable('conversion_rate')->value);?>
)</span-->
                                                            </span>
                                                            <?php if (($_smarty_tpl->tpl_vars['productitem']->value['discount']>0)){?>
                                                                <span class="strike_price"><?php echo Product::convertAndShow(array('price'=>$_smarty_tpl->tpl_vars['productitem']->value['mrp']),$_smarty_tpl);?>
</span>
                                                                <span class="clear" style="display:block;color:#DA0F00;">(<?php echo $_smarty_tpl->tpl_vars['productitem']->value['discount'];?>
% Off)</span>
                                                            <?php }?>
                                                        <?php }?>
                                                    </span>
                                                </span>
                                            </a>
                                        </div>
                                    </li>
                                    <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['recentProducts']['index']%5==4||$_smarty_tpl->getVariable('smarty')->value['foreach']['recentProducts']['last']==true){?>
                                    </ul>
                                </div>
                            <?php }?>
                        <?php }} ?>
                    </div>
                </div>
                <a class="next browse right" style="display:block;">Next</a>
            </div>
        </div>
    <?php }?>
