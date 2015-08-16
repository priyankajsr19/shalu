{include file="$tpl_dir./errors.tpl"}
{include file="$tpl_dir./product_social_actions.tpl"}
{if $errors|@count == 0}
    <script type="text/javascript">
        // <![CDATA[

        // PrestaShop internal settings
        var currencySign = '{$currencySign|html_entity_decode:2:"UTF-8"}';
        var currencyRate = '{$currencyRate|floatval}';
        var currencyFormat = '{$currencyFormat|intval}';
        var currencyBlank = '{$currencyBlank|intval}';
        var taxRate = {$tax_rate|floatval};
        var jqZoomEnabled = {if $jqZoomEnabled}true{else}false{/if};

        //JS Hook
        var oosHookJsCodeFunctions = new Array();

        // Parameters
        var id_product = '{$product->id|intval}';
        var productHasAttributes = {if isset($groups)}true{else}false{/if};
        var quantitiesDisplayAllowed = {if $display_qties == 1}true{else}false{/if};
        var quantityAvailable = {if $display_qties == 1 && $product->quantity}{$product->quantity}{else}0{/if};
        var allowBuyWhenOutOfStock = {if $allow_oosp == 1}true{else}false{/if};
        var availableNowValue = '{$product->available_now|escape:'quotes':'UTF-8'}';
        var availableLaterValue = '{$product->available_later|escape:'quotes':'UTF-8'}';
        var productPriceTaxExcluded = {$product->getPriceWithoutReduct(true)|default:'null'} - {$product->ecotax};
        var reduction_percent = {if $product->specificPrice AND $product->specificPrice.reduction AND $product->specificPrice.reduction_type == 'percentage'}{$product->specificPrice.reduction*100}{else}0{/if};
        var reduction_price = {if $product->specificPrice AND $product->specificPrice.reduction AND $product->specificPrice.reduction_type == 'amount'}{$product->specificPrice.reduction}{else}0{/if};
        var specific_price = {if $product->specificPrice AND $product->specificPrice.price}{$product->specificPrice.price}{else}0{/if};
        var specific_currency = {if $product->specificPrice AND $product->specificPrice.id_currency}true{else}false{/if};
        var group_reduction = '{$group_reduction}';
        var default_eco_tax = {$product->ecotax};
        var ecotaxTax_rate = {$ecotaxTax_rate};
        var currentDate = '{$smarty.now|date_format:'%Y-%m-%d %H:%M:%S'}';
        var maxQuantityToAllowDisplayOfLastQuantityMessage = {$last_qties};
        var noTaxForThisProduct = {if $no_tax == 1}true{else}false{/if};
        var displayPrice = {$priceDisplay};
        var productReference = '{$product->reference|escape:'htmlall':'UTF-8'}';
        var productAvailableForOrder = {if (isset($restricted_country_mode) AND $restricted_country_mode) OR $PS_CATALOG_MODE}'0'{else}'{$product->available_for_order}'{/if};
                var productShowPrice = '{if !$PS_CATALOG_MODE}{$product->show_price}{else}0{/if}';
        var productUnitPriceRatio = '{$product->unit_price_ratio}';
        var idDefaultImage = {if isset($cover.id_image_only)}{$cover.id_image_only}{else}0{/if};

        // Customizable field
        var img_ps_dir = '{$img_ps_dir}';
        var customizationFields = new Array();
        {assign var='imgIndex' value=0}
        {assign var='textFieldIndex' value=0}
        {foreach from=$customizationFields item='field' name='customizationFields'}
            {assign var="key" value="pictures_`$product->id`_`$field.id_customization_field`"}
        customizationFields[{$smarty.foreach.customizationFields.index|intval}] = new Array();
        customizationFields[{$smarty.foreach.customizationFields.index|intval}][0] = '{if $field.type|intval == 0}img{$imgIndex++}{else}textField{$textFieldIndex++}{/if}';
        customizationFields[{$smarty.foreach.customizationFields.index|intval}][1] = {if $field.type|intval == 0 && isset($pictures.$key) && $pictures.$key}2{else}{$field.required|intval}{/if};
        {/foreach}

        // Images
        var img_prod_dir = '{$img_prod_dir}';
        var combinationImages = new Array();

        {if isset($combinationImages)}
            {foreach from=$combinationImages item='combination' key='combinationId' name='f_combinationImages'}
        combinationImages[{$combinationId}] = new Array();
                {foreach from=$combination item='image' name='f_combinationImage'}
        combinationImages[{$combinationId}][{$smarty.foreach.f_combinationImage.index}] = {$image.id_image|intval};
                {/foreach}
            {/foreach}
        {/if}

        combinationImages[0] = new Array();
        {if isset($images)}
            {foreach from=$images item='image' name='f_defaultImages'}
        combinationImages[0][{$smarty.foreach.f_defaultImages.index}] = {$image.id_image};
            {/foreach}
        {/if}

        // Translations
        var doesntExist = '{l s='The product does not exist in this model. Please choose another.' js=1}';
        var doesntExistNoMore = '{l s='This product is no longer in stock' js=1}';
        var doesntExistNoMoreBut = '{l s='with those attributes but is available with others' js=1}';
        var uploading_in_progress = '{l s='Uploading in progress, please wait...' js=1}';
        var fieldRequired = '{l s='Please fill in all required fields, then save the customization.' js=1}';

        $(document).ready(function() {
            $("input:radio[name=c-customization-style][value=1]").prop('checked', true);
            $("#c-customization-longcholi").prop('checked', false);
            $("#c-customization-longsleeves").prop('checked', false);

            $("input:radio[name=c-customization-style]").click(function() {
                var selectedVal = $(this).val();
                $('.measure-select').hide();
                if (selectedVal == 1)
                    $('#designercholi-measure-select').show();
                else if (selectedVal == 2)
                    $('#indiancholi-measure-select').show();
                else
                    $('#corsetcholi-measure-select').show();
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

            $('.sizeguide').fancybox({
                fitToView: true,
                margin: 0,
                padding: 0
            });

            $('#buy_block').submit(function(e) {
                var selectedStyle = $("input:radio[name=c-customization-style]:checked").val();

                var choli_measurementID = 0;

                if (selectedStyle == 1)
                    choli_measurementID = $('#designercholi_measurement_id option:selected').val();
                else if (selectedStyle == 2)
                    choli_measurementID = $('#indiancholi_measurement_id option:selected').val();
                else
                    choli_measurementID = $('#corsetcholi_measurement_id option:selected').val();

                if (choli_measurementID < 1) {
                    e.preventDefault();
                    alert('Please select a choli measurement');
                }
            });
        });

        {if isset($groups)}
        // Combinations
            {foreach from=$combinations key=idCombination item=combination}
        addCombination({$idCombination|intval}, new Array({$combination.list}), {$combination.quantity}, {$combination.price}, {$combination.ecotax}, {$combination.id_image}, '{$combination.reference|addslashes}', {$combination.unit_impact}, {$combination.minimal_quantity});
            {/foreach}
        // Colors
            {if $colors|@count > 0}
            {if $product->id_color_default}var
id_color_default = {$product->id_color_default|intval};{/if}
        {/if}
    {/if}
                //]]>
</script>


<div style="width:700px;float:left;padding-top:5px;">
    {include file="$tpl_dir./breadcrumb.tpl"}
</div>
<div class="breadcrumb" style="float:left;width:280px;text-align:right;padding-top:5px;">

</div>
<div itemscope itemtype="http://schema.org/Product" id="primary_block" class="clearfix" >

    {if isset($adminActionDisplay) && $adminActionDisplay}
        <div id="admin-action">
            <p>{l s='This product is not visible to your customers.'}
                <input type="hidden" id="admin-action-product-id" value="{$product->id}" />
                <input type="submit" value="{l s='Publish'}" class="exclusive" onclick="submitPublishProduct('{$base_dir}{$smarty.get.ad}', 0)"/>
                <input type="submit" value="{l s='Back'}" class="exclusive" onclick="submitPublishProduct('{$base_dir}{$smarty.get.ad}', 1)"/>
            </p>
            <div class="clear" ></div>
            <p id="admin-action-result"></p>
            </p>
        </div>
    {/if}

    {if isset($confirmation) && $confirmation}
        <p class="confirmation">
            {$confirmation}
        </p>
    {/if}

    <div id="product-top">
        <!-- right infos-->
        <div id="pb-right-column">
            <div style="width:100px;float:left;">
                {if isset($images) && count($images) > 0}
                    <!-- thumbnails -->
                    <div id="views_block" {if isset($images) && count($images) < 1}class="hidden"{/if}>
                    {if isset($images) && count($images) > 3}<span class="view_scroll_spacer"><a id="view_scroll_left" class="hidden" title="{l s='Other views'}" href="javascript:{ldelim}{rdelim}">{l s='Previous'}</a></span>{/if}
                    <div id="thumbs_list">
                        <ul id="thumbs_list_frame">
                            {if isset($images)}
                                {foreach from=$images item=image name=thumbnails}
                                    {assign var=imageIds value="`$product->id`-`$image.id_image`"}
                                    <li id="thumbnail_{$image.id_image}" style="text-align:center;height:115px;">
                                        <a href="{$link->getImageLink($product->link_rewrite, $imageIds, 'thickbox')}"
                                           rel="other-views"
                                           class="thickbox {if $smarty.foreach.thumbnails.first}shown{/if}"
                                           title="{$image.legend|htmlspecialchars}"
                                           style="overflow:scroll"
                                           data-imgid="{$image.id_image}">
                                            <img id="thumb_{$image.id_image}" src="{$link->getImageLink($product->link_rewrite, $imageIds, 'small')}" alt="{$image.legend|htmlspecialchars}" height="93" />
                                            <span>View Full Size</span>
                                        </a>
                                    </li>
                                {/foreach}
                            {/if}
                        </ul>
                    </div>
                {if isset($images) && count($images) > 3}<a id="view_scroll_right" title="{l s='Other views'}" href="javascript:{ldelim}{rdelim}">{l s='Next'}</a>{/if}
            </div>
        {/if}
    {if isset($images) && count($images) > 1}<p class="align_center clear"><span id="wrapResetImages" style="display: none;"><img src="{$img_dir}icon/cancel_16x18.gif" alt="{l s='Cancel'}" width="16" height="18"/> <a id="resetImages" href="{$link->getProductLink($product)}" onclick="$('span#wrapResetImages').hide('slow');
                    return (false);">{l s='Display all pictures'}</a></span></p>{/if}
</div>
<!-- product img-->
<div id="image-block">
    {if $have_image}
        <ul>
            {foreach from=$images item=image name=thumbnails}
                {assign var=imageIds value="`$product->id`-`$image.id_image`"}
                <li id="bigpic_{$image.id_image}" style="display:{if $smarty.foreach.thumbnails.first}block{else}none{/if}" class="{if $smarty.foreach.thumbnails.first}visible{/if}">
                    <a href="{$link->getImageLink($product->link_rewrite, $imageIds, 'thickbox')}"
                       rel="other-views"
                       class="newzoom"
                       title="{$image.legend|htmlspecialchars}"
                       style="overflow:scroll">
                        <img id="largepic_{$image.id_image}" src="{$link->getImageLink($product->link_rewrite, $imageIds, 'large')}" alt="{$image.legend|htmlspecialchars}" height="533" width="390" />
                    </a>
                </li>
            {/foreach}
        </ul>
    {else}
        <img src="{$img_prod_dir}{$lang_iso}-default-large.jpg" id="bigpic" alt="" title="{$product->name|escape:'htmlall':'UTF-8'}" width="{$largeSize.width}" height="{$largeSize.height}" />
    {/if}
</div>
</div>

<!-- left infos-->
<div id="pb-left-column" style="position:relative">
    <h1 itemprop="name">{$product->name|escape:'htmlall':'UTF-8'}</h1>
    {if in_array("buy1get1", $product->tags[1])}
                   <span style="position:absolute;right:0;top:0">
                        <img alt="Buy1-Get1" src="{$img_ps_dir}b1g1_50.png" style="margin:0 0;float: right;left:0px; top:1px;"/>
                   </span>
    {/if}

    {if ($product->show_price AND !isset($restricted_country_mode)) OR isset($groups) OR $product->reference OR (isset($HOOK_PRODUCT_ACTIONS) && $HOOK_PRODUCT_ACTIONS)}
        <!-- add to cart form-->
        <form id="buy_block" {if $PS_CATALOG_MODE AND !isset($groups) AND $product->quantity > 0}class="hidden"{/if} action="{$link->getPageLink('cart.php')}" method="post" style="float:left">

            <!-- hidden datas -->
            <p class="hidden">
                <input type="hidden" name="token" value="{$static_token}" />
                <input type="hidden" name="id_product" value="{$product->id|intval}" id="product_page_product_id" />
                <input type="hidden" name="add" value="1" />
                <input type="hidden" name="id_product_attribute" id="idCombination" value="" />

                <input type="hidden" name="is_customized" id="is_customized" value="{$product->is_customizable}" />
                <input type="hidden" name="choli_customization" id="choli_customization" value="1" />
            </p>

            {include file="$tpl_dir./product_page_price.tpl"}
            {include file="$tpl_dir./product_page_social_love.tpl"}

            <input type="hidden" name="qty" style="width:40px;display:none;position:relative;height:20px;float:left" id="quantity_wanted" class="text" value="{if isset($quantityBackup)}{$quantityBackup|intval}{else}{if $product->minimal_quantity > 1}{$product->minimal_quantity}{else}1{/if}{/if}" {if $product->minimal_quantity > 1}onkeyup="checkMinimalQuantity({$product->minimal_quantity});"{/if} />
            <div id="customizations">
                {if isset($groups)}
                    <!-- attributes -->
                    <div class="custom_group"  id="attributes" style="border-bottom:1px dashed #cacaca">
                        <span style="font-size:15px;margin-bottom:10px;">Make it your own</span>
                        {foreach from=$groups key=id_attribute_group item=group}
                            {if $group.attributes|@count}
                                <p style="text-align:left;padding:9px 0">
                                    <label for="group_{$id_attribute_group|intval}">{$group.name|escape:'htmlall':'UTF-8'} :</label>
                                    {assign var="groupName" value="group_$id_attribute_group"}
                                    <select name="{$groupName}" id="group_{$id_attribute_group|intval}" onchange="javascript:findCombination();{if $colors|@count > 0}$('#wrapResetImages').show('slow');{/if};" style="padding:0;width:100px;">
                                        {foreach from=$group.attributes key=id_attribute item=group_attribute}
                                            <option value="{$id_attribute|intval}"{if (isset($smarty.get.$groupName) && $smarty.get.$groupName|intval == $id_attribute) || $group.default == $id_attribute} selected="selected"{/if} title="{$group_attribute|escape:'htmlall':'UTF-8'}">
                                                {if $is_bottoms}
                                                    Waist: {$group_attribute|escape:'htmlall':'UTF-8'}″
                                                {else}
                                                    Bust: {$group_attribute|escape:'htmlall':'UTF-8'}″
                                                {/if}
                                            </option>
                                        {/foreach}
                                    </select>
                                    {if isset($sizechart) &&  !empty($sizechart)}
                                        <a class="sizeguide span_link fancybox" style="color:#75B1DC;padding:0px 15px;" href="#size_chart">size chart</a>
                                    {/if}
                                </p>
                            {/if}
                        {/foreach}
                    </div>
                {/if}
		{if isset($sizechart) &&  !empty($sizechart)}
                    <div id="size_chart" style="display:none">
                        {include file="$tpl_dir/brandsizes/$sizechart"}
                    </div>
                {/if}
                {if $product->is_customizable == 1}
                    <div class="custom_group" style="border-top:1px dashed #cacaca;">
                        <p style="font-family:Abel;font-size:15px;display:inline-block;width:450px;vertical-align:top;padding:0px 0px;">1. Choli Styles <a style="color:#75B1DC;font:12px/18px arial,georgia,Sans-Serif" class="span_link" target="_blank" href="/only-cholis.php">(About choli styles)</a></p>
                        <p style="margin-bottom:3px;">
                            <input type="radio" name="c-customization-style" id="c-designer" value="1" checked="checked"/>
                            <label for="c-designer">Designer Choli</label>
                        <div id="designercholi-measure-select" style="padding: 5px 0px 5px 20px;vertical-align:top;" class="measure-select">
                            <span style="display:inline-block;width:150px;vertical-align:top;padding:0px 0px;">Measurement (Body Bust):</span>
                            <div style="width:250px;display:inline-block">
                                <select id="designercholi_measurement_id" name="designercholi_measurement_id" style="width:150px;padding:0;">
                                    <option value="0" selected>Select a measurement</option>
                                    <option value="32">32 ″</option>
                                    <option value="34">34 ″</option>
                                    <option value="36">36 ″</option>
                                    <option value="38">38 ″</option>
                                    <option value="40">40 ″</option>
                                    <option value="42">42 ″</option>
                                    <option value="44">44 ″</option>
                                    <option value="46">46 ″</option>
                                    <option value="48">48 ″</option>
                                </select>
                                <a class="sizeguide span_link fancybox" style="color:#75B1DC;padding:0px 15px;" href="#designer_size_chart">size chart</a>
                                <div id="designer_size_chart" style="display:none">
                                    {include file="$tpl_dir/brandsizes/designer-choli.tpl"}
                                </div>
                            </div>
                        </div>
                        </p>
                        <p style="margin-bottom:3px;">
                            <input type="radio" name="c-customization-style" id="c-indian-traditional" value="2"/>
                            <label for="c-indian-traditional">Indian Traditional Cut</label>
                        <div id="indiancholi-measure-select" style="padding: 5px 0px 5px 20px;vertical-align:top;display:none" class="measure-select">
                            <span style="display:inline-block;width:150px;vertical-align:top;padding:0px 0px;">Measurement (Body Bust):</span>
                            <div style="width:250px;display:inline-block">
                                <select id="indiancholi_measurement_id" name="indiancholi_measurement_id" style="width:150px;padding:0;">
                                    <option value="0" selected>Select a measurement</option>
                                    <option value="32">32 ″</option>
                                    <option value="34">34 ″</option>
                                    <option value="36">36 ″</option>
                                    <option value="38">38 ″</option>
                                    <option value="40">40 ″</option>
                                    <option value="42">42 ″</option>
                                    <option value="44">44 ″</option>
                                    <option value="46">46 ″</option>
                                    <option value="48">48 ″</option>
                                    <option value="50">50 ″</option>
                                    <option value="52">52 ″</option>
                                    <option value="54">54 ″</option>
                                    <option value="56">56 ″</option>
                                    <option value="58">58 ″</option>
                                    <option value="60">60 ″</option>
                                </select>
                                <a class="sizeguide span_link fancybox" style="color:#75B1DC;padding:0px 15px;" href="#indian_size_chart">size chart</a>
                                <div id="indian_size_chart" style="display:none">
                                    {include file="$tpl_dir/brandsizes/indian-choli.tpl"}
                                </div>
                            </div>
                        </div>
                        </p>
                        <p style="margin-bottom:3px;">
                            <input type="radio" name="c-customization-style" id="c-corset-style" value="3" />
                            <label for="c-corset-style">Corset Choli <span style="padding:0 15px;color:#E08323">+ {convertAndShow price=36}</span></label>
                        <div id="corsetcholi-measure-select" style="padding: 5px 0px 5px 20px;vertical-align:top;display:none" class="measure-select">
                            <span style="display:inline-block;width:150px;vertical-align:top;padding:0px 0px;">Measurement (Body Bust):</span>
                            <div style="width:250px;display:inline-block">
                                <select id="corsetcholi_measurement_id" name="corsetcholi_measurement_id" style="width:150px;padding:0;">
                                    <option value="0" selected>Select a measurement</option>
                                    <option value="32">32 ″</option>
                                    <option value="34">34 ″</option>
                                    <option value="36">36 ″</option>
                                    <option value="38">38 ″</option>
                                    <option value="40">40 ″</option>
                                    <option value="42">42 ″</option>
                                    <option value="44">44 ″</option>
                                    <option value="46">46 ″</option>
                                    <option value="48">48 ″</option>
                                </select>
                                <a class="sizeguide span_link fancybox" style="color:#75B1DC;padding:0px 15px;" href="#corset_size_chart">size chart</a>
                                <div id="corset_size_chart" style="display:none">
                                    {include file="$tpl_dir/brandsizes/corset-choli.tpl"}
                                </div>
                            </div>
                        </div>
                        </p>
                    </div>

                    <div class="custom_group" style="border-top:1px dashed #cacaca;border-bottom:1px dashed #cacaca;">
                        <p style="font-family:Abel;font-size:15px;display:inline-block;width:450px;vertical-align:top;padding:0px 0px;">2. Additional Customizations</p>
                        <p style="margin-bottom:3px;">
                            <input type="checkbox" name="c-customization-longcholi" id="c-customization-longcholi" value="1"/>
                            <label for="c-customization-longcholi">Long Choli (covering waist uptil the navel)<span style="padding:0 15px;color:#E08323">+ {convertAndShow price=9}</span></label>
                        </p>
                        <p style="margin-bottom:3px;">
                            <input type="checkbox" name="c-customization-longsleeves" id="c-customization-longsleeves" value="1"/>
                            <label for="c-customization-longsleeves">Long Sleeves (3/4th sleeves)<span style="padding:0 15px;color:#E08323">+ {convertAndShow price=9}</span></label>
                        </p>
                    </div>
                </div>
            {/if}

            <!-- Out of stock hook -->
            <p id="oosHook" style="{if $product->quantity > 0} display: none;{/if} text-align:center; float:left; margin-left:115px;">
                <img alt="Out Of Stock" src="{$img_ps_dir}out_of_stock_v.jpg" />
            </p>
            {include file="$tpl_dir./product_detail_shipping_sla.tpl"}
            {if isset($in_wishlist) && $in_wishlist}
                <div style="float:left;padding:5px 5px 5px 0">
                    <a href="/wishlist.php" class="span_link" rel="no-follow">
                        <img src="{$img_ps_dir}heart-disabled.jpg" height="18" width="18" style="vertical-align:middle"/>
                        <span style="color:#939393">IN YOUR WISHLIST</span>
                    </a>
                </div>
            {else}
                {if $cookie->isLogged()}
                    <div style="float:left;padding:5px 5px 5px 0">
                        <a href="/wishlist.php?add={$product->id}" class="span_link" rel="no-follow" >
                            <img src="{$img_ps_dir}heart.jpg" height="18" width="18" style="vertical-align:middle"/>
                            <span style="">ADD TO WISHLIST</span>
                        </a>
                    </div>
                {else}
                    <div style="float:left;padding:5px 5px 5px 0">
                        <a class="fancybox login_link" href="#login_modal_panel" rel="nofollow" >
                            <img src="{$img_ps_dir}heart.jpg" height="18" width="18" style="vertical-align:middle"/>
                            <span style="">ADD TO WISHLIST</span>
                        </a>
                    </div>
                {/if}
            {/if}
            <div style="padding:5px 5px 5px 50px; float:right;{if (!$allow_oosp && $product->quantity <= 0) OR !$product->available_for_order OR (isset($restricted_country_mode) AND $restricted_country_mode) OR $PS_CATALOG_MODE} display: none;{/if}" id="add_to_cart" class="buttons_bottom_block">
                <input class="addtobag" type="submit" name="Submit" value="" />
            </div>
        {if isset($HOOK_PRODUCT_ACTIONS) && $HOOK_PRODUCT_ACTIONS}{$HOOK_PRODUCT_ACTIONS}{/if}
        <div class="clear">
        </div>
    </form>
    {if isset($relatedProducts) && $relatedProducts && $relatedProducts|@count > 0}
        <div id="related_products" style="margin:10px 0;width:450px;clear:both;">
            <span style="font-size:14px;padding-bottom:5px;display:block;border-bottom:1px solid #E0E0E0">Other colors for this product:</span>
            <ul>
                {foreach from=$relatedProducts item=relatedProduct}
                    <li style="display:inline-block;width:100px;text-align:center;padding:0 5px;">
                        <a href="{$relatedProduct->link}">
                            <span class="product_image" href="{$relatedProduct->link}" title="{$relatedProduct->name|escape:html:'UTF-8'}">
                                {if isset($lazy) && $lazy == 1}
                                    <img data-href="{$relatedProduct->image_link}" height="116" width="85" alt="{$relatedProduct->name|escape:html:'UTF-8'}"  class="delaylazy"/>
                                    <noscript>
                                    <img src="{$relatedProduct->image_link}" height="116" width="85" alt="{$relatedProduct->name|escape:html:'UTF-8'}" />
                                    </noscript>
                                {else}
                                    <img src="{$relatedProduct->image_link}" height="116" width="85" alt="{$relatedProduct->name|escape:html:'UTF-8'}" />
                                {/if}
                            </span>
                            <span style="display:inline-block;width:90px;text-transform:capitalize;">
                                {$relatedProduct->color|truncate:100:'...'|escape:'htmlall':'UTF-8'}
                            </span>
                        </a>
                    </li>
                {/foreach}
            </ul>
        </div>
    {/if}
{/if}
{if $HOOK_EXTRA_RIGHT}{$HOOK_EXTRA_RIGHT}{/if}
</div>

</div>
<div id="product-info" style="float:left;width:100%">
    <!-- description and features -->
    {if $product->description || $features}
        <div id="more_info_block">
            <div class="panel_title">PRODUCT DETAILS</div>
            <div id="tab-container" class="tab-container" style="height:300px;">
                <ul class='etabs'>
                    <li class='etab active'><a href="#tabs1">Product</a></li>
                    <li class='etab'><a href="#tabs2">More Details</a></li>
                    <li class='etab'><a href="#tabs3">Wash & Care</a></li>
                    <li class='etab'><a href="#tabs5">Shipping</a></li>
                </ul>
                <div id="tabs1" class='etab_content' style="height:300px;overflow:auto;-ms-overflow-x: hidden;overflow-x: hidden;">
                    <p>{$product->description}</p>
                    <p>Our studio will design the choli in the exact manner as you see in the display image.</p>
                    <p>Please be informed that even if you see a designer choli in the image, it is absolutely possible to customize it to the Indian Choli design on request. You can choose the option based on your body type, personality and occasion.</p>
                    <p>If you want our studio to look into any special instructions, please jot it down in the box which appears as you finish your order. Our Design Studio will make the final judgment using their experience and eye for design and the same shall be communicated to you via email.</p>
                    <p>You can opt for long sleeves to be attached to a choli at an extra cost.</p>
                    <p>Our cholis are crafted in such a way that adjustments at a later stage are readily possible. A leeway of two inches is always provided so that one can easily do the whole adjustment herself, with no help from a designer or tailor. All you need to do is undo a set of stitches to make it a size bigger or run a simple straight stitch on the sides to make it smaller.</p>
                    <p>Disclaimer: There may be slight variations in the patch patti border, prints or weave of the choli but our endeavor is to provide you with the designs closest to the one depicted in the picture with minimum of variations. The Designer Cholis come with padding up to bust size 42. Cholis above the specified size shall be designed without the padding.</p>
                </div>
                <div id="tabs2" class='etab_content' style="height:300px;">
                    <ul>
                        {if isset($product->fabric) && $product->fabric != ''}
                            <li>
                                <span style="font-weight:bold;display:inline-block;width:90px;">Fabric:</span>
                                <span style="padding:0 10px;">{$product->fabric|escape:'htmlall':'UTF-8'}</span>
                            </li>
                        {/if}
                        {if isset($product->color) && $product->color != ''}
                            <li>
                                <span style="font-weight:bold;display:inline-block;width:90px;">Color:</span>
                                <span style="padding:0 10px;">{$product->color|escape:'htmlall':'UTF-8'}</span>
                            </li>
                        {/if}
                        {if isset($product->garment_type) && $product->garment_type != ''}
                            <li>
                                <span style="font-weight:bold;display:inline-block;width:90px;">Garment Type:</span>
                                <span style="padding:0 10px;">{$product->garment_type|escape:'htmlall':'UTF-8'}</span>
                            </li>
                        {/if}
                        {if isset($product->work_type) && $product->work_type != ''}
                            <li>
                                <span style="font-weight:bold;display:inline-block;width:90px;">Work Type:</span>
                                <span style="padding:0 10px;">{$product->work_type|escape:'htmlall':'UTF-8'}</span>
                            </li>
                        {/if}
                        {if isset($product->kameez_style) && $product->kameez_style != ''}
                            <li>
                                <span style="font-weight:bold;display:inline-block;width:90px;">Kameez Style:</span>
                                <span style="padding:0 10px;">{$product->kameez_style|escape:'htmlall':'UTF-8'}</span>
                            </li>
                        {/if}
                        {if isset($product->salwar_style) && $product->salwar_style}
                            <li>
                                <span style="font-weight:bold;display:inline-block;width:90px;">Salwar Style</span>
                                <span style="padding:0 10px;">{$product->salwar_style|escape:'htmlall':'UTF-8'}</span>
                            </li>
                        {/if}
                        {if isset($product->sleeves) && $product->sleeves}
                            <li>
                                <span style="font-weight:bold;display:inline-block;width:90px;">Sleeves</span>
                                <span style="padding:0 10px;">{$product->sleeves|escape:'htmlall':'UTF-8'}</span>
                            </li>
                        {/if}
                        {if isset($product->skirt_length) && $product->skirt_length}
                            <li>
                                <span style="font-weight:bold;display:inline-block;width:90px;">Lehenga Length</span>
                                <span style="padding:0 10px;">{$product->skirt_length|escape:'htmlall':'UTF-8'} inches</span>
                            </li>
                        {/if}
                        {if isset($product->dupatta_length) && $product->dupatta_length}
                            <li>
                                <span style="font-weight:bold;display:inline-block;width:90px;">Dupatta Length</span>
                                <span style="padding:0 10px;">{$product->dupatta_length|escape:'htmlall':'UTF-8'} meters</span>
                            </li>
                        {/if}
                    </ul>
                </div>
                <div id="tabs3" class='etab_content' style="height:300px;">
                    <ul>
                        {if isset($product->wash_care) && $product->wash_care == 1}
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
                        {/if}
                        {if isset($product->wash_care) && $product->wash_care == 2}
                            <li>
                                Standard Wash and care 2
                            </li>
                        {/if}
                        {if isset($product->wash_care) && $product->wash_care == 3}
                            <li>
                                Standard Wash and care 3
                            </li>
                        {/if}
                    </ul>
                </div>
                {*<div id="tabs4" class='etab_content'>
                {$product->description_short}
                </div>*}
                <div id="tabs5" class='etab_content' style="height:300px;">
                    {include file="$tpl_dir./product_shipping_sla_detail.tpl"}
                </div>
            </div>
            {*
            <div id="more_info_sheets" class="sheets align_justify">
            <div class="product_more_details">
            <div class="description">
            {if $product->description}
            <!-- full description -->
            <div id="idTab1" class="rte">
            <h3>{l s='Product Information'}</h3>
            <div itemprop="description">{$product->description}</div>
            <br />
            <h3>{l s='Product Reviews'}</h3>
            <h4 style="font-family: arial, helvetica, sans-serif; font-size: 13px;color:#000000;">No reviews available for {$product->name|escape:'htmlall':'UTF-8'}</h4>

            </div>
            {/if}
            </div>

            {if $features}
            <!-- product's features -->
            <ul id="idTab2" class="bullet">
            {foreach from=$features item=feature}
            <li><span>{$feature.name|escape:'htmlall':'UTF-8'}</span> {$feature.value|escape:'htmlall':'UTF-8'}</li>
            {/foreach}
            </ul>
            {/if}
            {if $attachments}
            <ul id="idTab9" class="bullet">
            {foreach from=$attachments item=attachment}
            <li><a href="{$link->getPageLink('attachment.php', true)}?id_attachment={$attachment.id_attachment}">{$attachment.name|escape:'htmlall':'UTF-8'}</a><br />{$attachment.description|escape:'htmlall':'UTF-8'}</li>
            {/foreach}
            </ul>
            {/if}
            {if isset($accessories) AND $accessories}
            <!-- accessories -->
            <ul id="idTab4" class="bullet">
            <div class="block products_block accessories_block clearfix">
            <div class="block_content">
            <ul>
            {foreach from=$accessories item=accessory name=accessories_list}
            {assign var='accessoryLink' value=$link->getProductLink($accessory.id_product, $accessory.link_rewrite, $accessory.category)}
            <li class="ajax_block_product {if $smarty.foreach.accessories_list.first}first_item{elseif $smarty.foreach.accessories_list.last}last_item{else}item{/if} product_accessories_description">
            <h5><a href="{$accessoryLink|escape:'htmlall':'UTF-8'}">{$accessory.name|truncate:22:'...':true|escape:'htmlall':'UTF-8'}</a></h5>
            <div class="product_desc">
            <a href="{$accessoryLink|escape:'htmlall':'UTF-8'}" title="{$accessory.legend|escape:'htmlall':'UTF-8'}" class="product_image"><img src="{$link->getImageLink($accessory.link_rewrite, $accessory.id_image, 'medium')}" alt="{$accessory.legend|escape:'htmlall':'UTF-8'}" /></a>
            <a href="{$accessoryLink|escape:'htmlall':'UTF-8'}" title="{l s='More'}" class="product_description">{$accessory.description_short|strip_tags|truncate:70:'...'}</a>
            </div>
            <p class="product_accessories_price">
            {if $accessory.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}<span class="price">{if $priceDisplay != 1}{displayWtPrice p=$accessory.price}{else}{displayWtPrice p=$accessory.price_tax_exc}{/if}</span>{/if}
            <a class="button" href="{$accessoryLink|escape:'htmlall':'UTF-8'}" title="{l s='View'}">{l s='View'}</a>
            {if ($accessory.allow_oosp || $accessory.quantity > 0) AND $accessory.available_for_order AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}
            <a class="exclusive button ajax_add_to_cart_button" href="{$link->getPageLink('cart.php')}?qty=1&amp;id_product={$accessory.id_product|intval}&amp;token={$static_token}&amp;add" rel="ajax_id_product_{$accessory.id_product|intval}" title="{l s='Add to cart'}">{l s='Add to cart'}</a>
            {else}
            <span class="exclusive">{l s='Add to cart'}</span>
            <span class="availability">{if (isset($accessory.quantity_all_versions) && $accessory.quantity_all_versions > 0)}{l s='Product available with different options'}{else}{l s='Out of stock'}{/if}</span>
            {/if}
            </p>
            </li>

            {/foreach}
            </ul>
            </div>
            </div>
            </ul>
            {/if}

            </div>
            </div> *}

        </div>
    {/if}
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
<p style="clear:both;border-bottom: 1px dashed #CACACA;padding:10px 0">*There may be minor color variations because of the light and settings during photography and also the color settings and properties of various monitors.</p>
{$HOOK_PRODUCT_TAB_CONTENT}
<div id="products_block" style="float:left;width:100%">
    <script>
                // execute your scripts when the DOM is ready. this is mostly a good habit
                $(function() {

                    // initialize scrollable
                    $(".scrollable").scrollable();

                });
    </script>
    {include file="$tpl_dir/product-recommendations.tpl"}
    {include file="$tpl_dir/product-recent-viewed.tpl"}
</div>
{/if}

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
