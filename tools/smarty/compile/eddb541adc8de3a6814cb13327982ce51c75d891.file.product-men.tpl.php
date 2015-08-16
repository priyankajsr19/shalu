<?php /* Smarty version Smarty-3.0.7, created on 2015-07-25 13:23:06
         compiled from "/var/www/html/indusdiva/themes/violettheme/product-men.tpl" */ ?>
<?php /*%%SmartyHeaderCode:54601715555b34062e68154-67706771%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eddb541adc8de3a6814cb13327982ce51c75d891' => 
    array (
      0 => '/var/www/html/indusdiva/themes/violettheme/product-men.tpl',
      1 => 1436974492,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '54601715555b34062e68154-67706771',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/var/www/html/indusdiva/tools/smarty/plugins/modifier.escape.php';
if (!is_callable('smarty_modifier_date_format')) include '/var/www/html/indusdiva/tools/smarty/plugins/modifier.date_format.php';
?><?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./errors.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./product_social_actions.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<?php if (count($_smarty_tpl->getVariable('errors')->value)==0){?>
    <script type="text/javascript">
        // <![CDATA[

        // PrestaShop internal settings
        var currencySign = '<?php echo html_entity_decode($_smarty_tpl->getVariable('currencySign')->value,2,"UTF-8");?>
';
        var currencyRate = '<?php echo floatval($_smarty_tpl->getVariable('currencyRate')->value);?>
';
        var currencyFormat = '<?php echo intval($_smarty_tpl->getVariable('currencyFormat')->value);?>
';
        var currencyBlank = '<?php echo intval($_smarty_tpl->getVariable('currencyBlank')->value);?>
';
        var taxRate = <?php echo floatval($_smarty_tpl->getVariable('tax_rate')->value);?>
;
        var jqZoomEnabled = <?php if ($_smarty_tpl->getVariable('jqZoomEnabled')->value){?>true<?php }else{ ?>false<?php }?>;

        //JS Hook
        var oosHookJsCodeFunctions = new Array();

        // Parameters
        var id_product = '<?php echo intval($_smarty_tpl->getVariable('product')->value->id);?>
';
        var productHasAttributes = <?php if (isset($_smarty_tpl->getVariable('groups',null,true,false)->value)){?>true<?php }else{ ?>false<?php }?>;
        var quantitiesDisplayAllowed = <?php if ($_smarty_tpl->getVariable('display_qties')->value==1){?>true<?php }else{ ?>false<?php }?>;
        var quantityAvailable = <?php if ($_smarty_tpl->getVariable('display_qties')->value==1&&$_smarty_tpl->getVariable('product')->value->quantity){?><?php echo $_smarty_tpl->getVariable('product')->value->quantity;?>
<?php }else{ ?>0<?php }?>;
        var allowBuyWhenOutOfStock = <?php if ($_smarty_tpl->getVariable('allow_oosp')->value==1){?>true<?php }else{ ?>false<?php }?>;
        var availableNowValue = '<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->available_now,'quotes','UTF-8');?>
';
        var availableLaterValue = '<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->available_later,'quotes','UTF-8');?>
';
        var productPriceTaxExcluded = <?php echo (($tmp = @$_smarty_tpl->getVariable('product')->value->getPriceWithoutReduct(true))===null||$tmp==='' ? 'null' : $tmp);?>
 - <?php echo $_smarty_tpl->getVariable('product')->value->ecotax;?>
;
        var reduction_percent = <?php if ($_smarty_tpl->getVariable('product')->value->specificPrice&&$_smarty_tpl->getVariable('product')->value->specificPrice['reduction']&&$_smarty_tpl->getVariable('product')->value->specificPrice['reduction_type']=='percentage'){?><?php echo $_smarty_tpl->getVariable('product')->value->specificPrice['reduction']*100;?>
<?php }else{ ?>0<?php }?>;
        var reduction_price = <?php if ($_smarty_tpl->getVariable('product')->value->specificPrice&&$_smarty_tpl->getVariable('product')->value->specificPrice['reduction']&&$_smarty_tpl->getVariable('product')->value->specificPrice['reduction_type']=='amount'){?><?php echo $_smarty_tpl->getVariable('product')->value->specificPrice['reduction'];?>
<?php }else{ ?>0<?php }?>;
        var specific_price = <?php if ($_smarty_tpl->getVariable('product')->value->specificPrice&&$_smarty_tpl->getVariable('product')->value->specificPrice['price']){?><?php echo $_smarty_tpl->getVariable('product')->value->specificPrice['price'];?>
<?php }else{ ?>0<?php }?>;
        var specific_currency = <?php if ($_smarty_tpl->getVariable('product')->value->specificPrice&&$_smarty_tpl->getVariable('product')->value->specificPrice['id_currency']){?>true<?php }else{ ?>false<?php }?>;
        var group_reduction = '<?php echo $_smarty_tpl->getVariable('group_reduction')->value;?>
';
        var default_eco_tax = <?php echo $_smarty_tpl->getVariable('product')->value->ecotax;?>
;
        var ecotaxTax_rate = <?php echo $_smarty_tpl->getVariable('ecotaxTax_rate')->value;?>
;
        var currentDate = '<?php echo smarty_modifier_date_format(time(),'%Y-%m-%d %H:%M:%S');?>
';
        var maxQuantityToAllowDisplayOfLastQuantityMessage = <?php echo $_smarty_tpl->getVariable('last_qties')->value;?>
;
        var noTaxForThisProduct = <?php if ($_smarty_tpl->getVariable('no_tax')->value==1){?>true<?php }else{ ?>false<?php }?>;
        var displayPrice = <?php echo $_smarty_tpl->getVariable('priceDisplay')->value;?>
;
        var productReference = '<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->reference,'htmlall','UTF-8');?>
';
        var productAvailableForOrder = <?php if ((isset($_smarty_tpl->getVariable('restricted_country_mode',null,true,false)->value)&&$_smarty_tpl->getVariable('restricted_country_mode')->value)||$_smarty_tpl->getVariable('PS_CATALOG_MODE')->value){?>'0'<?php }else{ ?>'<?php echo $_smarty_tpl->getVariable('product')->value->available_for_order;?>
'<?php }?>;
                var productShowPrice = '<?php if (!$_smarty_tpl->getVariable('PS_CATALOG_MODE')->value){?><?php echo $_smarty_tpl->getVariable('product')->value->show_price;?>
<?php }else{ ?>0<?php }?>';
        var productUnitPriceRatio = '<?php echo $_smarty_tpl->getVariable('product')->value->unit_price_ratio;?>
';
        var idDefaultImage = <?php if (isset($_smarty_tpl->getVariable('cover',null,true,false)->value['id_image_only'])){?><?php echo $_smarty_tpl->getVariable('cover')->value['id_image_only'];?>
<?php }else{ ?>0<?php }?>;

        // Customizable field
        var img_ps_dir = '<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
';
        var customizationFields = new Array();
        <?php $_smarty_tpl->tpl_vars['imgIndex'] = new Smarty_variable(0, null, null);?>
        <?php $_smarty_tpl->tpl_vars['textFieldIndex'] = new Smarty_variable(0, null, null);?>
        <?php  $_smarty_tpl->tpl_vars['field'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('customizationFields')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['customizationFields']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['field']->key => $_smarty_tpl->tpl_vars['field']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['customizationFields']['index']++;
?>
            <?php $_smarty_tpl->tpl_vars["key"] = new Smarty_variable("pictures_".($_smarty_tpl->getVariable('product')->value->id)."_".($_smarty_tpl->tpl_vars['field']->value['id_customization_field']), null, null);?>
        customizationFields[<?php echo intval($_smarty_tpl->getVariable('smarty')->value['foreach']['customizationFields']['index']);?>
] = new Array();
        customizationFields[<?php echo intval($_smarty_tpl->getVariable('smarty')->value['foreach']['customizationFields']['index']);?>
][0] = '<?php if (intval($_smarty_tpl->tpl_vars['field']->value['type'])==0){?>img<?php echo $_smarty_tpl->getVariable('imgIndex')->value++;?>
<?php }else{ ?>textField<?php echo $_smarty_tpl->getVariable('textFieldIndex')->value++;?>
<?php }?>';
        customizationFields[<?php echo intval($_smarty_tpl->getVariable('smarty')->value['foreach']['customizationFields']['index']);?>
][1] = <?php if (intval($_smarty_tpl->tpl_vars['field']->value['type'])==0&&isset($_smarty_tpl->getVariable('pictures',null,true,false)->value[$_smarty_tpl->getVariable('key',null,true,false)->value])&&$_smarty_tpl->getVariable('pictures')->value[$_smarty_tpl->getVariable('key')->value]){?>2<?php }else{ ?><?php echo intval($_smarty_tpl->tpl_vars['field']->value['required']);?>
<?php }?>;
        <?php }} ?>

        // Images
        var img_prod_dir = '<?php echo $_smarty_tpl->getVariable('img_prod_dir')->value;?>
';
        var combinationImages = new Array();

        <?php if (isset($_smarty_tpl->getVariable('combinationImages',null,true,false)->value)){?>
            <?php  $_smarty_tpl->tpl_vars['combination'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['combinationId'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('combinationImages')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['combination']->key => $_smarty_tpl->tpl_vars['combination']->value){
 $_smarty_tpl->tpl_vars['combinationId']->value = $_smarty_tpl->tpl_vars['combination']->key;
?>
        combinationImages[<?php echo $_smarty_tpl->tpl_vars['combinationId']->value;?>
] = new Array();
                <?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['combination']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['f_combinationImage']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['f_combinationImage']['index']++;
?>
        combinationImages[<?php echo $_smarty_tpl->tpl_vars['combinationId']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['f_combinationImage']['index'];?>
] = <?php echo intval($_smarty_tpl->tpl_vars['image']->value['id_image']);?>
;
                <?php }} ?>
            <?php }} ?>
        <?php }?>

        combinationImages[0] = new Array();
        <?php if (isset($_smarty_tpl->getVariable('images',null,true,false)->value)){?>
            <?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('images')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['f_defaultImages']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['f_defaultImages']['index']++;
?>
        combinationImages[0][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['f_defaultImages']['index'];?>
] = <?php echo $_smarty_tpl->tpl_vars['image']->value['id_image'];?>
;
            <?php }} ?>
        <?php }?>

        // Translations
        var doesntExist = '<?php echo smartyTranslate(array('s'=>'The product does not exist in this model. Please choose another.','js'=>1),$_smarty_tpl);?>
';
        var doesntExistNoMore = '<?php echo smartyTranslate(array('s'=>'This product is no longer in stock','js'=>1),$_smarty_tpl);?>
';
        var doesntExistNoMoreBut = '<?php echo smartyTranslate(array('s'=>'with those attributes but is available with others','js'=>1),$_smarty_tpl);?>
';
        var uploading_in_progress = '<?php echo smartyTranslate(array('s'=>'Uploading in progress, please wait...','js'=>1),$_smarty_tpl);?>
';
        var fieldRequired = '<?php echo smartyTranslate(array('s'=>'Please fill in all required fields, then save the customization.','js'=>1),$_smarty_tpl);?>
';

        $(document).ready(function() {
            $('#kurta_measurement_id').val(0);
            $('#salwar_measurement_id').val(0);

            $('#kurta_measurement_id').change(function() {
                if ($('#kurta_measurement_id option:selected').val() == -1)
                            {
        <?php if ($_smarty_tpl->getVariable('cookie')->value->isLogged()){?>
                                            $('#create_kurta_measurement').trigger('click');
        <?php }else{ ?>
                                            $('.login_link').trigger('click');
        <?php }?>
                                        }
                                    });

                                    $('#salwar_measurement_id').change(function() {
                                        if ($('#salwar_measurement_id option:selected').val() == -1)
                            {
        <?php if ($_smarty_tpl->getVariable('cookie')->value->isLogged()){?>
                                            $('#create_salwar_measurement').trigger('click');
        <?php }else{ ?>
                                            $('.login_link').trigger('click');
        <?php }?>
                                        }
                                    });

                                    $("input[name='skd-customization-option']").change(function() {
                                        if ($("input[name='skd-customization-option']:checked").val() == 2)
                                            $('#skd-customizations').fadeIn('slow');
                                        else
                                            $('#skd-customizations').fadeOut();
                                    });

                                    var options = {
                                        zoomType: 'standard',
                                        preloadImages: true,
                                        alwaysOn: false,
                                        zoomWidth: 480,
                                        zoomHeight: 530,
                                        xOffset: 10,
                                        yOffset: 0,
                                        position: 'right',
                                        title: false
                                    };
                                    $('.newzoom').jqzoom(options);
                                    $('#seeall').click(function() {
                                        $.scrollTo('#product-info', 500);
                                    });
                                    $('#tab-container').easytabs({
                                        updateHash: false
                                    });
                                    $('.measure_link').fancybox({
                                        fitToView: true,
                                        margin: 0,
                                        padding: 0
                                    });

                                    $('.sizeguide').fancybox({
                                        fitToView: true,
                                        margin: 0,
                                        padding: 0
                                    });

                                    $('.custom_options').click(function() {
                                        if ($('input:radio[name=sareetype]:checked').val() == 2 || $('input:radio[name=blousetype]:checked').val() == 2)
                                            $('#measurement_panel').fadeIn('slow');
                                        else
                                            $('#measurement_panel').fadeOut();
                                    });

                                    var $radios = $("input[name='skd-customization-option']");
                                    $radios.filter('[value=1]').attr('checked', true);


        <?php if ($_smarty_tpl->getVariable('product')->value->is_customizable){?>
                                    $('#buy_block').submit(function(e) {
                                        var isCustomizationSelected = $("input[name='skd-customization-option']:checked").val() == 2 ? true : false;

                                        if (!isCustomizationSelected) {
                                            $('#prestitched_skd').val(0);
                                            return true;
                                        }

                                        $('#prestitched_skd').val(1);

                                        var kurta_measurementID = $('#kurta_measurement_id option:selected').val();
                                        var salwar_measurementID = $('#salwar_measurement_id option:selected').val();

                                        if (kurta_measurementID)
                                            $('#id_kurta_measurement').val(kurta_measurementID);

                                        if (salwar_measurementID)
                                            $('#id_salwar_measurement').val(salwar_measurementID);

                                        if (kurta_measurementID < 1)
                                    {
                                                    e.preventDefault();
                                                    alert('Please select a kurta measurement');
                                                }

                                                if (salwar_measurementID < 1)
                                    {
                                                    e.preventDefault();
                                                    alert('Please select a salwar measurement');
                                                }
                                            });
        <?php }?>
                                        });

        <?php if (isset($_smarty_tpl->getVariable('groups',null,true,false)->value)){?>
                                        // Combinations
            <?php  $_smarty_tpl->tpl_vars['combination'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['idCombination'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('combinations')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['combination']->key => $_smarty_tpl->tpl_vars['combination']->value){
 $_smarty_tpl->tpl_vars['idCombination']->value = $_smarty_tpl->tpl_vars['combination']->key;
?>
                                        addCombination(<?php echo intval($_smarty_tpl->tpl_vars['idCombination']->value);?>
, new Array(<?php echo $_smarty_tpl->tpl_vars['combination']->value['list'];?>
), <?php echo $_smarty_tpl->tpl_vars['combination']->value['quantity'];?>
, <?php echo $_smarty_tpl->tpl_vars['combination']->value['price'];?>
, <?php echo $_smarty_tpl->tpl_vars['combination']->value['ecotax'];?>
, <?php echo $_smarty_tpl->tpl_vars['combination']->value['id_image'];?>
, '<?php echo addslashes($_smarty_tpl->tpl_vars['combination']->value['reference']);?>
', <?php echo $_smarty_tpl->tpl_vars['combination']->value['unit_impact'];?>
, <?php echo $_smarty_tpl->tpl_vars['combination']->value['minimal_quantity'];?>
);
            <?php }} ?>
                                        // Colors
            <?php if (count($_smarty_tpl->getVariable('colors')->value)>0){?>
            <?php if ($_smarty_tpl->getVariable('product')->value->id_color_default){?>var
id_color_default = <?php echo intval($_smarty_tpl->getVariable('product')->value->id_color_default);?>
;<?php }?>
        <?php }?>
    <?php }?>
                //]]>
</script>


<div style="width:700px;float:left;padding-top:5px;">
    <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./breadcrumb.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
</div>
<div class="breadcrumb" style="float:left;width:280px;text-align:right;padding-top:5px;">
</div>
<div itemscope itemtype="http://schema.org/Product" id="primary_block" class="clearfix" >

    <?php if (isset($_smarty_tpl->getVariable('adminActionDisplay',null,true,false)->value)&&$_smarty_tpl->getVariable('adminActionDisplay')->value){?>
        <div id="admin-action">
            <p><?php echo smartyTranslate(array('s'=>'This product is not visible to your customers.'),$_smarty_tpl);?>

                <input type="hidden" id="admin-action-product-id" value="<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
" />
                <input type="submit" value="<?php echo smartyTranslate(array('s'=>'Publish'),$_smarty_tpl);?>
" class="exclusive" onclick="submitPublishProduct('<?php echo $_smarty_tpl->getVariable('base_dir')->value;?>
<?php echo $_GET['ad'];?>
', 0)"/>
                <input type="submit" value="<?php echo smartyTranslate(array('s'=>'Back'),$_smarty_tpl);?>
" class="exclusive" onclick="submitPublishProduct('<?php echo $_smarty_tpl->getVariable('base_dir')->value;?>
<?php echo $_GET['ad'];?>
', 1)"/>
            </p>
            <div class="clear" ></div>
            <p id="admin-action-result"></p>
            </p>
        </div>
    <?php }?>

    <?php if (isset($_smarty_tpl->getVariable('confirmation',null,true,false)->value)&&$_smarty_tpl->getVariable('confirmation')->value){?>
        <p class="confirmation">
            <?php echo $_smarty_tpl->getVariable('confirmation')->value;?>

        </p>
    <?php }?>

    <div id="product-top">
        <!-- right infos-->
        <div id="pb-right-column">
            <div style="width:100px;float:left;">
                <?php if (isset($_smarty_tpl->getVariable('images',null,true,false)->value)&&count($_smarty_tpl->getVariable('images')->value)>0){?>
                    <!-- thumbnails -->
                    <div id="views_block" <?php if (isset($_smarty_tpl->getVariable('images',null,true,false)->value)&&count($_smarty_tpl->getVariable('images')->value)<1){?>class="hidden"<?php }?>>
                    <?php if (isset($_smarty_tpl->getVariable('images',null,true,false)->value)&&count($_smarty_tpl->getVariable('images')->value)>3){?><span class="view_scroll_spacer"><a id="view_scroll_left" class="hidden" title="<?php echo smartyTranslate(array('s'=>'Other views'),$_smarty_tpl);?>
" href="javascript:{}"><?php echo smartyTranslate(array('s'=>'Previous'),$_smarty_tpl);?>
</a></span><?php }?>
                    <div id="thumbs_list">
                        <ul id="thumbs_list_frame">
                            <?php if (isset($_smarty_tpl->getVariable('images',null,true,false)->value)){?>
                                <?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('images')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['image']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value){
 $_smarty_tpl->tpl_vars['image']->index++;
 $_smarty_tpl->tpl_vars['image']->first = $_smarty_tpl->tpl_vars['image']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['thumbnails']['first'] = $_smarty_tpl->tpl_vars['image']->first;
?>
                                    <?php $_smarty_tpl->tpl_vars['imageIds'] = new Smarty_variable(($_smarty_tpl->getVariable('product')->value->id)."-".($_smarty_tpl->tpl_vars['image']->value['id_image']), null, null);?>
                                    <li id="thumbnail_<?php echo $_smarty_tpl->tpl_vars['image']->value['id_image'];?>
" style="text-align:center;height:115px;">
                                        <a href="<?php echo $_smarty_tpl->getVariable('link')->value->getImageLink($_smarty_tpl->getVariable('product')->value->link_rewrite,$_smarty_tpl->getVariable('imageIds')->value,'thickbox');?>
"
                                           rel="other-views"
                                           class="thickbox <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['thumbnails']['first']){?>shown<?php }?>"
                                           title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['legend']);?>
"
                                           style="overflow:scroll"
                                           data-imgid="<?php echo $_smarty_tpl->tpl_vars['image']->value['id_image'];?>
">
                                            <img id="thumb_<?php echo $_smarty_tpl->tpl_vars['image']->value['id_image'];?>
" src="<?php echo $_smarty_tpl->getVariable('link')->value->getImageLink($_smarty_tpl->getVariable('product')->value->link_rewrite,$_smarty_tpl->getVariable('imageIds')->value,'small');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['legend']);?>
" height="93" />
                                            <span>View Full Size</span>
                                        </a>
                                    </li>
                                <?php }} ?>
                            <?php }?>
                        </ul>
                    </div>
                <?php if (isset($_smarty_tpl->getVariable('images',null,true,false)->value)&&count($_smarty_tpl->getVariable('images')->value)>3){?><a id="view_scroll_right" title="<?php echo smartyTranslate(array('s'=>'Other views'),$_smarty_tpl);?>
" href="javascript:{}"><?php echo smartyTranslate(array('s'=>'Next'),$_smarty_tpl);?>
</a><?php }?>
            </div>
        <?php }?>
    <?php if (isset($_smarty_tpl->getVariable('images',null,true,false)->value)&&count($_smarty_tpl->getVariable('images')->value)>1){?><p class="align_center clear"><span id="wrapResetImages" style="display: none;"><img src="<?php echo $_smarty_tpl->getVariable('img_dir')->value;?>
icon/cancel_16x18.gif" alt="<?php echo smartyTranslate(array('s'=>'Cancel'),$_smarty_tpl);?>
" width="16" height="18"/> <a id="resetImages" href="<?php echo $_smarty_tpl->getVariable('link')->value->getProductLink($_smarty_tpl->getVariable('product')->value);?>
" onclick="$('span#wrapResetImages').hide('slow');
                    return (false);"><?php echo smartyTranslate(array('s'=>'Display all pictures'),$_smarty_tpl);?>
</a></span></p><?php }?>
</div>
<!-- product img-->
<div id="image-block">
    <?php if ($_smarty_tpl->getVariable('have_image')->value){?>
        <ul>
            <?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('images')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['image']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value){
 $_smarty_tpl->tpl_vars['image']->index++;
 $_smarty_tpl->tpl_vars['image']->first = $_smarty_tpl->tpl_vars['image']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['thumbnails']['first'] = $_smarty_tpl->tpl_vars['image']->first;
?>
                <?php $_smarty_tpl->tpl_vars['imageIds'] = new Smarty_variable(($_smarty_tpl->getVariable('product')->value->id)."-".($_smarty_tpl->tpl_vars['image']->value['id_image']), null, null);?>
                <li id="bigpic_<?php echo $_smarty_tpl->tpl_vars['image']->value['id_image'];?>
" style="display:<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['thumbnails']['first']){?>block<?php }else{ ?>none<?php }?>" class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['thumbnails']['first']){?>visible<?php }?>">
                    <a href="<?php echo $_smarty_tpl->getVariable('link')->value->getImageLink($_smarty_tpl->getVariable('product')->value->link_rewrite,$_smarty_tpl->getVariable('imageIds')->value,'thickbox');?>
"
                       rel="other-views"
                       class="newzoom"
                       title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['legend']);?>
"
                       style="overflow:scroll">
                        <img id="largepic_<?php echo $_smarty_tpl->tpl_vars['image']->value['id_image'];?>
" src="<?php echo $_smarty_tpl->getVariable('link')->value->getImageLink($_smarty_tpl->getVariable('product')->value->link_rewrite,$_smarty_tpl->getVariable('imageIds')->value,'large');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['legend']);?>
" height="533" width="390" />
                    </a>
                </li>
            <?php }} ?>
        </ul>
    <?php }else{ ?>
        <img src="<?php echo $_smarty_tpl->getVariable('img_prod_dir')->value;?>
<?php echo $_smarty_tpl->getVariable('lang_iso')->value;?>
-default-large.jpg" id="bigpic" alt="" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name,'htmlall','UTF-8');?>
" width="<?php echo $_smarty_tpl->getVariable('largeSize')->value['width'];?>
" height="<?php echo $_smarty_tpl->getVariable('largeSize')->value['height'];?>
" />
    <?php }?>
</div>
</div>

<!-- left infos-->
<div id="pb-left-column" style="position:relative">
    <h1 itemprop="name"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name,'htmlall','UTF-8');?>
</h1>
     <?php if (in_array("buy1get1",$_smarty_tpl->getVariable('product')->value->tags[1])){?>
                   <span style="position:absolute;right:0;top:0">
                        <img alt="Buy1-Get1" src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
b1g1_50.png" style="margin:0 0;float: right;left:0px; top:1px;"/>
                   </span>
     <?php }?>

    <?php if (($_smarty_tpl->getVariable('product')->value->show_price&&!isset($_smarty_tpl->getVariable('restricted_country_mode',null,true,false)->value))||isset($_smarty_tpl->getVariable('groups',null,true,false)->value)||$_smarty_tpl->getVariable('product')->value->reference||(isset($_smarty_tpl->getVariable('HOOK_PRODUCT_ACTIONS',null,true,false)->value)&&$_smarty_tpl->getVariable('HOOK_PRODUCT_ACTIONS')->value)){?>
        <!-- add to cart form-->
        <form id="buy_block" <?php if ($_smarty_tpl->getVariable('PS_CATALOG_MODE')->value&&!isset($_smarty_tpl->getVariable('groups',null,true,false)->value)&&$_smarty_tpl->getVariable('product')->value->quantity>0){?>class="hidden"<?php }?> action="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('cart.php');?>
" method="post" style="float:left">

            <!-- hidden datas -->
            <p class="hidden">
                <input type="hidden" name="token" value="<?php echo $_smarty_tpl->getVariable('static_token')->value;?>
" />
                <input type="hidden" name="id_product" value="<?php echo intval($_smarty_tpl->getVariable('product')->value->id);?>
" id="product_page_product_id" />
                <input type="hidden" name="add" value="1" />
                <input type="hidden" name="id_product_attribute" id="idCombination" value="" />

                <?php if ($_smarty_tpl->getVariable('product')->value->is_customizable){?>
                    <input type="hidden" name="is_customized" id="is_customized" value="1" />
                    <input type="hidden" name="id_kurta_measurement" id="id_kurta_measurement" value="0" />
                    <input type="hidden" name="id_salwar_measurement" id="id_salwar_measurement" value="0" />
                    <input type="hidden" name="prestitched_skd" id="prestitched_skd" value="0" />
                    <input type="hidden" name="skd-fabric" id="skd-fabric" value="1" />
                <?php }?>
            </p>

            <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./product_page_price.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
            <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./product_page_social_love.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

            <input type="hidden" name="qty" style="width:40px;display:none;position:relative;height:20px;float:left" id="quantity_wanted" class="text" value="<?php if (isset($_smarty_tpl->getVariable('quantityBackup',null,true,false)->value)){?><?php echo intval($_smarty_tpl->getVariable('quantityBackup')->value);?>
<?php }else{ ?><?php if ($_smarty_tpl->getVariable('product')->value->minimal_quantity>1){?><?php echo $_smarty_tpl->getVariable('product')->value->minimal_quantity;?>
<?php }else{ ?>1<?php }?><?php }?>" <?php if ($_smarty_tpl->getVariable('product')->value->minimal_quantity>1){?>onkeyup="checkMinimalQuantity(<?php echo $_smarty_tpl->getVariable('product')->value->minimal_quantity;?>
);"<?php }?> />
            <div id="saree-customizations" style="margin-top:10px;">

                <?php if (isset($_smarty_tpl->getVariable('groups',null,true,false)->value)){?>
                    <!-- attributes -->
                    <div class="custom_group"  id="attributes" style="border-bottom:1px dashed #cacaca">
                        <span style="font-size:15px;margin-bottom:10px;">Make it your own</span>
                        <?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['id_attribute_group'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('groups')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
 $_smarty_tpl->tpl_vars['id_attribute_group']->value = $_smarty_tpl->tpl_vars['group']->key;
?>
                            <?php if (count($_smarty_tpl->tpl_vars['group']->value['attributes'])){?>
                                <p style="text-align:left;padding:9px 0">
                                    <label for="group_<?php echo intval($_smarty_tpl->tpl_vars['id_attribute_group']->value);?>
"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group']->value['name'],'htmlall','UTF-8');?>
 :</label>
                                    <?php $_smarty_tpl->tpl_vars["groupName"] = new Smarty_variable("group_".($_smarty_tpl->tpl_vars['id_attribute_group']->value), null, null);?>
                                    <select name="<?php echo $_smarty_tpl->getVariable('groupName')->value;?>
" id="group_<?php echo intval($_smarty_tpl->tpl_vars['id_attribute_group']->value);?>
" onchange="javascript:findCombination();<?php if (count($_smarty_tpl->getVariable('colors')->value)>0){?>$('#wrapResetImages').show('slow');<?php }?>;" style="padding:0;width:100px;">
                                        <?php  $_smarty_tpl->tpl_vars['group_attribute'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['id_attribute'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['group']->value['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['group_attribute']->key => $_smarty_tpl->tpl_vars['group_attribute']->value){
 $_smarty_tpl->tpl_vars['id_attribute']->value = $_smarty_tpl->tpl_vars['group_attribute']->key;
?>
                                            <option value="<?php echo intval($_smarty_tpl->tpl_vars['id_attribute']->value);?>
"<?php if ((isset($_GET[$_smarty_tpl->getVariable('groupName',null,true,false)->value])&&intval($_GET[$_smarty_tpl->getVariable('groupName')->value])==$_smarty_tpl->tpl_vars['id_attribute']->value)||$_smarty_tpl->tpl_vars['group']->value['default']==$_smarty_tpl->tpl_vars['id_attribute']->value){?> selected="selected"<?php }?> title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value,'htmlall','UTF-8');?>
">
                                                    Chest: <?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value,'htmlall','UTF-8');?>
″
                                            </option>
                                        <?php }} ?>
                                    </select>
                                    <?php if (isset($_smarty_tpl->getVariable('sizechart',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('sizechart',null,true,false)->value)){?>
                                        <a class="sizeguide span_link fancybox" style="color:#75B1DC;padding:0px 15px;" href="#size_chart">size chart</a>
                                    <?php }?>
                                </p>
                            <?php }?>
                        <?php }} ?>
                    </div>
                <?php }?>
		<?php if (isset($_smarty_tpl->getVariable('sizechart',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('sizechart',null,true,false)->value)){?>
                    <div id="size_chart" style="display:none">
                        <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."/brandsizes/".($_smarty_tpl->getVariable('sizechart')->value), $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                    </div>
                <?php }?>
                <?php if ($_smarty_tpl->getVariable('product')->value->is_customizable){?>
                    <div class="custom_group" style="border-top:1px dashed #cacaca;border-bottom:1px dashed #cacaca;">
                        <p style="font-size:14px;margin:0;">Make it your own</p>
                        <p style="margin-bottom:3px;">
                            <input type="radio" name="skd-customization-option" id="skd-fabric" value="1" checked/>
                            <label for="skd-fabric">Pick just the fabric</label>
                        </p>
                        <p style="margin-bottom:3px;">
                            <input type="radio" name="skd-customization-option" id="sc-pre-stitched-skd" value="2" />
                            <label for="sc-pre-stitched-skd">Customize to your size <span style="padding:0 15px;color:#E08323">+ <?php echo Product::convertAndShow(array('price'=>9),$_smarty_tpl);?>
</span></label>
                        </p>
                        <div id="skd-customizations" style="margin-bottom:10px;padding-bottom:10px;display:none">
                            <div id="kurta-measure-select" style="padding: 5px 20px 5px 20px;width:450px;display:inline-block;">
                                <span style="font-family:Abel;font-size:15px;display:inline-block;width:150px;vertical-align:top;padding:0px 0px;">1. Kurta Measurement:</span>
                                <div style="width:165px;display:inline-block">
                                    <select id="kurta_measurement_id" name="k_measurement_id" style="<?php if (!isset($_smarty_tpl->getVariable('kurta_measurement_info',null,true,false)->value)){?>display:none<?php }else{ ?>display:inline<?php }?>;width:150px;padding:0;">
                                        <option value="0" selected>Select a measurement</option>
                                        <?php if (isset($_smarty_tpl->getVariable('kurta_measurement_info',null,true,false)->value)){?>
                                            <?php  $_smarty_tpl->tpl_vars['measurement'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('kurta_measurement_info')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['measurement']->key => $_smarty_tpl->tpl_vars['measurement']->value){
?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['measurement']->value['id_measurement'];?>
">
                                                    <?php if (isset($_smarty_tpl->tpl_vars['measurement']->value['name_measurement'])){?>
                                                    <?php echo $_smarty_tpl->tpl_vars['measurement']->value['name_measurement'];?>
<?php if ($_smarty_tpl->tpl_vars['measurement']->value['is_std']==1){?>″<?php }?>
                                                <?php }else{ ?>
                                                <?php echo $_smarty_tpl->tpl_vars['measurement']->value['name'];?>
<?php if ($_smarty_tpl->tpl_vars['measurement']->value['is_std']==1){?>″<?php }?>
                                            <?php }?>
                                        </option>
                                    <?php }} ?>
                                <?php }?>
                                <option value="-1">Custom Measurement</option>
                            </select>
                            <?php if (!isset($_smarty_tpl->getVariable('kurta_measurement_info',null,true,false)->value)){?>
                                <span id="no_measurement_txt" style="<?php if (isset($_smarty_tpl->getVariable('kurta_measurement_info',null,true,false)->value)){?>display:none<?php }?>">No saved measurements.</span>
                            <?php }?>
                            <?php if (isset($_smarty_tpl->getVariable('is_anarkali',null,true,false)->value)&&$_smarty_tpl->getVariable('is_anarkali')->value){?>
                                <a id="create_kurta_measurement" class="measure_link span_link fancybox.ajax" style="color:#75B1DC;display:block" href="<?php echo $_smarty_tpl->getVariable('base_dir')->value;?>
measurement.php?&modal=1&m=1&type=5">size chart</a>
                            <?php }else{ ?>
                                <a id="create_kurta_measurement" class="measure_link span_link fancybox.ajax" style="color:#75B1DC;display:block" href="<?php echo $_smarty_tpl->getVariable('base_dir')->value;?>
measurement.php?&modal=1&m=1&type=3">size chart</a>
                            <?php }?>
                        </div>
                    </div>
                    <div id="salwar-measure-select" style="padding: 5px 0px 5px 20px;width:450px;display:inline-block;vertical-align:top;">
                        <span style="font-family:Abel;font-size:15px;display:inline-block;width:150px;vertical-align:top;padding:0px 0px;">2. Bottom Measurement:</span>
                        <div style="display:inline-block">
                            <select id="salwar_measurement_id" name="s_measurement_id" style="<?php if (!isset($_smarty_tpl->getVariable('salwar_measurement_info',null,true,false)->value)){?>display:none<?php }else{ ?>display:inline<?php }?>;width:150px;padding:0;">
                                <option value="0" selected>Select a measurement</option>
                                <?php if (isset($_smarty_tpl->getVariable('salwar_measurement_info',null,true,false)->value)){?>
                                    <?php  $_smarty_tpl->tpl_vars['measurement'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('salwar_measurement_info')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['measurement']->key => $_smarty_tpl->tpl_vars['measurement']->value){
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['measurement']->value['id_measurement'];?>
">
                                            <?php if (isset($_smarty_tpl->tpl_vars['measurement']->value['name_measurement'])){?>
                                            <?php echo $_smarty_tpl->tpl_vars['measurement']->value['name_measurement'];?>
<?php if ($_smarty_tpl->tpl_vars['measurement']->value['is_std']==1){?>″<?php }?>
                                        <?php }else{ ?>
                                        <?php echo $_smarty_tpl->tpl_vars['measurement']->value['name'];?>
<?php if ($_smarty_tpl->tpl_vars['measurement']->value['is_std']==1){?>″<?php }?>
                                    <?php }?>
                                </option>
                            <?php }} ?>
                        <?php }?>
                        <option value="-1">Custom Measurement</option>
                    </select>
                    <?php if (!isset($_smarty_tpl->getVariable('salwar_measurement_info',null,true,false)->value)){?>
                        <span id="no_measurement_txt" style="<?php if (isset($_smarty_tpl->getVariable('salwar_measurement_info',null,true,false)->value)){?>display:none<?php }?>">No saved measurements.</span>
                    <?php }?>
                    <a id="create_salwar_measurement" class="measure_link span_link fancybox.ajax" style="color:#75B1DC;display:block" href="<?php echo $_smarty_tpl->getVariable('base_dir')->value;?>
measurement.php?&modal=1&m=1&type=4">size chart</a>
                </div>
            </div>
        </div>

    </div>
<?php }?>
</div>


<!-- Out of stock hook -->
<p id="oosHook" style="<?php if ($_smarty_tpl->getVariable('product')->value->quantity>0){?> display: none;<?php }?> text-align:center; float:left; margin-left:115px;">
    <img alt="Out Of Stock" src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
out_of_stock_v.jpg" />
</p>
<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./product_detail_shipping_sla.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<?php if (isset($_smarty_tpl->getVariable('in_wishlist',null,true,false)->value)&&$_smarty_tpl->getVariable('in_wishlist')->value){?>
    <div style="float:left;padding:5px 5px 5px 0">
        <a href="/wishlist.php" class="span_link" rel="no-follow">
            <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
heart-disabled.jpg" height="18" width="18" style="vertical-align:middle"/>
            <span style="color:#939393">IN YOUR WISHLIST</span>
        </a>
    </div>
<?php }else{ ?>
    <?php if ($_smarty_tpl->getVariable('cookie')->value->isLogged()){?>
        <div style="float:left;padding:5px 5px 5px 0">
            <a href="/wishlist.php?add=<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
" class="span_link" rel="no-follow" >
                <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
heart.jpg" height="18" width="18" style="vertical-align:middle"/>
                <span style="">ADD TO WISHLIST</span>
            </a>
        </div>
    <?php }else{ ?>
        <div style="float:left;padding:5px 5px 5px 0">
            <a class="fancybox login_link" href="#login_modal_panel" rel="nofollow" >
                <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
heart.jpg" height="18" width="18" style="vertical-align:middle"/>
                <span style="">ADD TO WISHLIST</span>
            </a>
        </div>
    <?php }?>
<?php }?>
<div style="padding:5px 5px 5px 50px; float:right;<?php if ((!$_smarty_tpl->getVariable('allow_oosp')->value&&$_smarty_tpl->getVariable('product')->value->quantity<=0)||!$_smarty_tpl->getVariable('product')->value->available_for_order||(isset($_smarty_tpl->getVariable('restricted_country_mode',null,true,false)->value)&&$_smarty_tpl->getVariable('restricted_country_mode')->value)||$_smarty_tpl->getVariable('PS_CATALOG_MODE')->value){?> display: none;<?php }?>" id="add_to_cart" class="buttons_bottom_block">
    <input class="addtobag" type="submit" name="Submit" value="" />
</div>
<?php if (isset($_smarty_tpl->getVariable('HOOK_PRODUCT_ACTIONS',null,true,false)->value)&&$_smarty_tpl->getVariable('HOOK_PRODUCT_ACTIONS')->value){?><?php echo $_smarty_tpl->getVariable('HOOK_PRODUCT_ACTIONS')->value;?>
<?php }?>
<div class="clear">
</div>
</form>
<?php if (isset($_smarty_tpl->getVariable('relatedProducts',null,true,false)->value)&&$_smarty_tpl->getVariable('relatedProducts')->value&&count($_smarty_tpl->getVariable('relatedProducts')->value)>0){?>
    <div id="related_products" style="margin:10px 0;width:450px;clear:both;">
        <span style="font-size:14px;padding-bottom:5px;display:block;border-bottom:1px solid #E0E0E0">Other colors for this product:</span>
        <ul>
            <?php  $_smarty_tpl->tpl_vars['relatedProduct'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('relatedProducts')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['relatedProduct']->key => $_smarty_tpl->tpl_vars['relatedProduct']->value){
?>
                <li style="display:inline-block;width:100px;text-align:center;padding:0 5px;">
                    <a href="<?php echo $_smarty_tpl->getVariable('relatedProduct')->value->link;?>
">
                        <span class="product_image" href="<?php echo $_smarty_tpl->getVariable('relatedProduct')->value->link;?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('relatedProduct')->value->name,'html','UTF-8');?>
">
                            <?php if (isset($_smarty_tpl->getVariable('lazy',null,true,false)->value)&&$_smarty_tpl->getVariable('lazy')->value==1){?>
                                <img data-href="<?php echo $_smarty_tpl->getVariable('relatedProduct')->value->image_link;?>
" height="116" width="85" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('relatedProduct')->value->name,'html','UTF-8');?>
"  class="delaylazy"/>
                                <noscript>
                                <img src="<?php echo $_smarty_tpl->getVariable('relatedProduct')->value->image_link;?>
" height="116" width="85" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('relatedProduct')->value->name,'html','UTF-8');?>
" />
                                </noscript>
                            <?php }else{ ?>
                                <img src="<?php echo $_smarty_tpl->getVariable('relatedProduct')->value->image_link;?>
" height="116" width="85" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('relatedProduct')->value->name,'html','UTF-8');?>
" />
                            <?php }?>
                        </span>
                        <span style="display:inline-block;width:90px;text-transform:capitalize;">
                            <?php echo smarty_modifier_escape(smarty_modifier_truncate($_smarty_tpl->getVariable('relatedProduct')->value->color,100,'...'),'htmlall','UTF-8');?>

                        </span>
                    </a>
                </li>
            <?php }} ?>
        </ul>
    </div>
<?php }?>
<?php }?>
<?php if ($_smarty_tpl->getVariable('HOOK_EXTRA_RIGHT')->value){?><?php echo $_smarty_tpl->getVariable('HOOK_EXTRA_RIGHT')->value;?>
<?php }?>
</div>

</div>
<div id="product-info" style="float:left;width:100%">
    <!-- description and features -->
    <?php if ($_smarty_tpl->getVariable('product')->value->description||$_smarty_tpl->getVariable('features')->value){?>
        <div id="more_info_block">
            <div class="panel_title">PRODUCT DETAILS</div>
            <div id="tab-container" class="tab-container">
                <ul class='etabs'>
                    <li class='etab active'><a href="#tabs1">Product</a></li>
                    <li class='etab'><a href="#tabs2">More Details</a></li>
                    <li class='etab'><a href="#tabs3">Wash & Care</a></li>
                    <li class='etab'><a href="#tabs5">Shipping</a></li>
                </ul>
                <div id="tabs1" class='etab_content' style="height:300px;overflow:auto;-ms-overflow-x: hidden;overflow-x: hidden;">
                    <p><?php echo $_smarty_tpl->getVariable('product')->value->description;?>
</p>
                    <?php if ($_smarty_tpl->getVariable('product')->value->is_customizable){?>
                        <p>The design and pattern of the Salwar Kameez remains true to the image portrayed though there may be slight variations depending on the body figure chart of the customer. If at any point some measurements do not seem practical, our designer will take the final call to ensure the best fit and design.</p>
                    <?php }?>
                    <p>There may be slight variations with respect to patch patti or work border on the outfit. There may also be a slight variation in the indigenous weave structure, hand embroidery, prints, paintings if any on the body of the outfit ( For example - there could be a change in the ethnic motif or the paisley may take a creative twist) but the design concept, color combinations, thickness of the border and contrast will remain the same. This is because these unique designs are woven on a loom or hand done or printed in design batches, hence a creative license is given to the weaver or designer to make these slight cosmetic changes. Our motto shall always be to keep the spirit of the design, intact.</p>
                </div>
                <div id="tabs2" class='etab_content' style="height:300px;">
                    <ul>
                        <?php if (isset($_smarty_tpl->getVariable('product',null,true,false)->value->fabric)&&$_smarty_tpl->getVariable('product')->value->fabric!=''){?>
                            <li>
                                <span style="font-weight:bold;display:inline-block;width:90px;">Fabric:</span>
                                <span style="padding:0 10px;"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->fabric,'htmlall','UTF-8');?>
</span>
                            </li>
                        <?php }?>
                        <?php if (isset($_smarty_tpl->getVariable('product',null,true,false)->value->color)&&$_smarty_tpl->getVariable('product')->value->color!=''){?>
                            <li>
                                <span style="font-weight:bold;display:inline-block;width:90px;">Color:</span>
                                <span style="padding:0 10px;"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->color,'htmlall','UTF-8');?>
</span>
                            </li>
                        <?php }?>
                        <?php if (isset($_smarty_tpl->getVariable('product',null,true,false)->value->garment_type)&&$_smarty_tpl->getVariable('product')->value->garment_type!=''){?>
                            <li>
                                <span style="font-weight:bold;display:inline-block;width:90px;">Garment Type:</span>
                                <span style="padding:0 10px;"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->garment_type,'htmlall','UTF-8');?>
</span>
                            </li>
                        <?php }?>
                        <?php if (isset($_smarty_tpl->getVariable('product',null,true,false)->value->work_type)&&$_smarty_tpl->getVariable('product')->value->work_type!=''){?>
                            <li>
                                <span style="font-weight:bold;display:inline-block;width:90px;">Work Type:</span>
                                <span style="padding:0 10px;"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->work_type,'htmlall','UTF-8');?>
</span>
                            </li>
                        <?php }?>
                        <?php if (isset($_smarty_tpl->getVariable('product',null,true,false)->value->kameez_style)&&$_smarty_tpl->getVariable('product')->value->kameez_style!=''){?>
                            <li>
                                <span style="font-weight:bold;display:inline-block;width:90px;">Kameez Style:</span>
                                <span style="padding:0 10px;"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->kameez_style,'htmlall','UTF-8');?>
</span>
                            </li>
                        <?php }?>
                        <?php if (isset($_smarty_tpl->getVariable('product',null,true,false)->value->salwar_style)&&$_smarty_tpl->getVariable('product')->value->salwar_style){?>
                            <li>
                                <span style="font-weight:bold;display:inline-block;width:90px;">Salwar Style</span>
                                <span style="padding:0 10px;"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->salwar_style,'htmlall','UTF-8');?>
</span>
                            </li>
                        <?php }?>
                        <?php if (isset($_smarty_tpl->getVariable('product',null,true,false)->value->sleeves)&&$_smarty_tpl->getVariable('product')->value->sleeves){?>
                            <li>
                                <span style="font-weight:bold;display:inline-block;width:90px;">Sleeves</span>
                                <span style="padding:0 10px;"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->sleeves,'htmlall','UTF-8');?>
</span>
                            </li>
                        <?php }?>
                    </ul>
                </div>
                <div id="tabs3" class='etab_content' style="height:300px;">
                    <ul>
                        <?php if (isset($_smarty_tpl->getVariable('product',null,true,false)->value->wash_care)&&$_smarty_tpl->getVariable('product')->value->wash_care==1){?>
                            <li>
                                <span style="font-weight:bold;font-size:13px;display:block;">Dry Wash</span>
                                <span style="display:block;font-weight:bold">Dos</span>
                                <ul style="padding:5px 15px;">
                                    <li>1. Dry cleaning is the best method to wash an apparel made of soft and delicate material.</li>
                                    <li>2. For silk apparel, it is necessary that one keeps it covered by a cotton cloth, always.</li>
                                    <li>3. Being a pure natural fabric, they need abundant breathing and cotton is one of the few materials which allow this.</li>
                                </ul>
                                <span style="display:block;font-weight:bold">Donts</span>
                                <ul style="padding:5px 15px;">
                                    <li>1. Never wrap silk apparel in plastic and trap the moisture; this could change the color and quality of the fabric in no time.</li>
                                    <li>2. Additionally always keep it free from moths by using cedar sticks.</li>
                                </ul>
                            </li>
                        <?php }?>
                        <?php if (isset($_smarty_tpl->getVariable('product',null,true,false)->value->wash_care)&&$_smarty_tpl->getVariable('product')->value->wash_care==2){?>
                            <li>
                                Standard Wash and care 2
                            </li>
                        <?php }?>
                        <?php if (isset($_smarty_tpl->getVariable('product',null,true,false)->value->wash_care)&&$_smarty_tpl->getVariable('product')->value->wash_care==3){?>
                            <li>
                                Standard Wash and care 3
                            </li>
                        <?php }?>
                    </ul>
                </div>
                <div id="tabs5" class='etab_content' style="height:300px;">
                    <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./product_shipping_sla_detail.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                </div>
            </div>

        </div>
    <?php }?>
    <div id="help_links">
        <div class="panel_title" style="width:300px;">WHY CHOOSE US?</div>
        <ul style="padding:10px;">
            <li style="padding:5px">
                <span style="font-size:12px;font-weight:bold;display:block;">SHIPPING WORLD-WIDE</span>
                <span style="font-size:12px;display:block;">Have your order delivered to over 200 countries</span>
                <span style="font-size:12px;display:block;">
                    <a href="#shipping-charges" class="shipping_link span_link">FREE in India, unit charges world-wide</a>
                </span>
            </li>
            <li style="padding:5px">
                <span style="font-size:12px;font-weight:bold;display:block;">24X7 SUPPORT</span>
                <span style="font-size:12px;display:block;">+91-80-67309079</span>
            </li>
            <li style="padding:5px">
                <span style="font-size:12px;font-weight:bold;display:block;">ON TIME DELIVERIES</span>
            </li>
            <li style="padding:5px">
                <span style="font-size:12px;font-weight:bold;display:block;">PERFECT FIT</span>
                <span style="font-size:12px;display:block;">Custom tailoring services</span>
                <span style="font-size:12px;display:block;">Have the garments stitched to measure</span>
            </li>
            <li style="padding:5px">
                <span style="font-size:12px;font-weight:bold;display:block;">EASY RETURN POLICY</span>
            </li>
            <li style="padding:5px">
                <span style="font-size:12px;font-weight:bold;display:block;">DESIGN STUDIO SERVICES</span>
            </li>
            <li style="padding:5px">
                <span style="font-size:12px;font-weight:bold;display:block;">ECLECTIC CURATED COLLECTION</span>
            </li>
        </ul>
    </div>
</div>
<p style="clear:both;border-bottom: 1px dashed #CACACA;padding:5px 0">*There may be minor color variations because of the light and settings during photography and also the color settings and properties of various monitors.</p>
<?php echo $_smarty_tpl->getVariable('HOOK_PRODUCT_TAB_CONTENT')->value;?>

<div id="products_block" style="float:left;width:100%">
    <script>
                // execute your scripts when the DOM is ready. this is mostly a good habit
                $(function() {

                    // initialize scrollable
                    $(".scrollable").scrollable();

                });
    </script>
    <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."/product-recommendations.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
    <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."/product-recent-viewed.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
</div>
<?php }?>

<script type="text/javascript">
    (function(w, d, load) {
        var script,
                first = d.getElementsByTagName('SCRIPT')[0],
                n = load.length,
                i = 0,
                go = function() {
            for (i = 0; i < n; i = i + 1) {
                script = d.createElement('SCRIPT');
                script.type = 'text/javascript';
                script.async = true;
                script.src = load[i];
                first.parentNode.insertBefore(script, first);
            }
        }
        if (w.attachEvent) {
            w.attachEvent('onload', go);
        } else {
            w.addEventListener('load', go, false);
        }
    }(window, document,
            ['//assets.pinterest.com/js/pinit.js']
            ));
</script>

