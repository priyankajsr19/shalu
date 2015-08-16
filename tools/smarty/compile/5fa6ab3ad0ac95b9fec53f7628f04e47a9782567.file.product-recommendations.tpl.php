<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 14:00:18
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme//product-recommendations.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6067406865562dd9a57f0b1-06071381%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5fa6ab3ad0ac95b9fec53f7628f04e47a9782567' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme//product-recommendations.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6067406865562dd9a57f0b1-06071381',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/tools/smarty/plugins/modifier.escape.php';
?>
    <?php if (isset($_smarty_tpl->getVariable('cat_products',null,true,false)->value)&&$_smarty_tpl->getVariable('cat_products')->value&&count($_smarty_tpl->getVariable('cat_products')->value)>0){?>
        <div id="category_products" class="sheets" style="padding:10px 0;float:left;width:100%">
            <div class="panel_title" style="width:80%;">WE RECOMMEND</div>
            <div  class="products_block_medium">
                <!-- "previous page" action -->
                <a class="prev browse left">Prev</a>

                <!-- root element for scrollable -->
                <div class="scrollable">

                    <!-- root element for the items -->
                    <div class="items">

                        <?php  $_smarty_tpl->tpl_vars['productitem'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('cat_products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['productitem']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['productitem']->iteration=0;
 $_smarty_tpl->tpl_vars['productitem']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['index']=-1;
if ($_smarty_tpl->tpl_vars['productitem']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['productitem']->key => $_smarty_tpl->tpl_vars['productitem']->value){
 $_smarty_tpl->tpl_vars['productitem']->iteration++;
 $_smarty_tpl->tpl_vars['productitem']->index++;
 $_smarty_tpl->tpl_vars['productitem']->first = $_smarty_tpl->tpl_vars['productitem']->index === 0;
 $_smarty_tpl->tpl_vars['productitem']->last = $_smarty_tpl->tpl_vars['productitem']->iteration === $_smarty_tpl->tpl_vars['productitem']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['first'] = $_smarty_tpl->tpl_vars['productitem']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['index']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['last'] = $_smarty_tpl->tpl_vars['productitem']->last;
?>
                            <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['first']==true||$_smarty_tpl->getVariable('smarty')->value['foreach']['products']['index']%5==0){?>
                                <div>
                                    <!-- Products list -->
                                    <ul>
                                    <?php }?>
                                    <li class="ajax_block_product" rel="<?php echo $_smarty_tpl->tpl_vars['productitem']->value['id_product'];?>
" <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['index']%5==0){?>style=" margin-left:15px"<?php }?>>
                                        <div class="product_card">
                                            <a href="<?php echo $_smarty_tpl->tpl_vars['productitem']->value['link'];?>
">
                                                <span class="product_image_medium" href="<?php echo $_smarty_tpl->tpl_vars['productitem']->value['link'];?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['productitem']->value['name'],'html','UTF-8');?>
">
                                                    <?php if (isset($_smarty_tpl->getVariable('lazy',null,true,false)->value)&&$_smarty_tpl->getVariable('lazy')->value==1){?>
                                                        <img data-href="<?php echo $_smarty_tpl->getVariable('link')->value->getImageLink($_smarty_tpl->tpl_vars['productitem']->value['link_rewrite'],$_smarty_tpl->tpl_vars['productitem']->value['id_image'],'medium');?>
" height="205" width="150" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['productitem']->value['name'],'html','UTF-8');?>
"  class="delaylazy"/>
                                                        <noscript>
                                                        <img src="<?php echo $_smarty_tpl->getVariable('link')->value->getImageLink($_smarty_tpl->tpl_vars['productitem']->value['link_rewrite'],$_smarty_tpl->tpl_vars['productitem']->value['id_image'],'medium');?>
" height="205" width="150" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['productitem']->value['name'],'html','UTF-8');?>
" />
                                                        </noscript>
                                                    <?php }else{ ?>
                                                        <img src="<?php echo $_smarty_tpl->getVariable('link')->value->getImageLink($_smarty_tpl->tpl_vars['productitem']->value['link_rewrite'],$_smarty_tpl->tpl_vars['productitem']->value['id_image'],'medium');?>
" height="205" width="150" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['productitem']->value['name'],'html','UTF-8');?>
" />
                                                    <?php }?>
                                                </span>
                                                <span class="product-list-name">
                                                    <h2 class="product_card_name"><?php echo smarty_modifier_escape(smarty_modifier_truncate($_smarty_tpl->tpl_vars['productitem']->value['name'],100,'...'),'htmlall','UTF-8');?>
</h2>
                                                </span>
                                                <span class="product_info">
                                                    <span class="price">
                                                        <?php if (!$_smarty_tpl->getVariable('priceDisplay')->value){?>
                                                            <?php echo Product::convertPrice(array('price'=>$_smarty_tpl->tpl_vars['productitem']->value['price']),$_smarty_tpl);?>

                                                        <?php }else{ ?>
                                                        <?php echo Product::convertPrice(array('price'=>$_smarty_tpl->tpl_vars['productitem']->value['price_tax_exc']),$_smarty_tpl);?>
<?php }?>
                                                        <!--span class="price_inr">
                                                            (Rs <?php echo round($_smarty_tpl->tpl_vars['productitem']->value['price']*$_smarty_tpl->getVariable('conversion_rate')->value);?>
)
                                                        </span-->
                                                    </span>
                                                    <?php if (($_smarty_tpl->tpl_vars['productitem']->value['price_without_reduction']-$_smarty_tpl->tpl_vars['productitem']->value['price']>1)){?>
                                                        <span class="clear" style="display:block;color:#DA0F00;">(<?php echo round((($_smarty_tpl->tpl_vars['productitem']->value['price_without_reduction']-$_smarty_tpl->tpl_vars['productitem']->value['price'])/$_smarty_tpl->tpl_vars['productitem']->value['price_without_reduction'])*100);?>
% Off)</span>
                                                    <?php }?>

                                                </span>
                                            </a>
                                        </div>
                                    </li>
                                    <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['index']%5==4||$_smarty_tpl->getVariable('smarty')->value['foreach']['products']['last']==true){?>
                                    </ul>
                                </div>
                            <?php }?>
                        <?php }} ?>

                        <!-- /Products list -->

                    </div>

                </div>

                <!-- "next page" action -->
                <a class="next browse right" style="display:block;">Next</a>
            </div>
        </div>
    <?php }?>
