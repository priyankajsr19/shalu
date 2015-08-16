{* facebook api stuff *}
<div id="fb-root"></div>
<script>
{literal}
  window.fbAsyncInit = function() {
    FB.init({
      appId  : '277196482292288',
      xfbml  : true,
      oauth : true
    });
    FB.Event.subscribe('edge.create',
    	    function(response) {
	    		var datastring = 'ajax=true&fb_like=1&pid=' + id_product;
		    	$.ajax(
						{
							type: 'POST',
							url: baseDir + 'feedback.php',
							data: datastring,
							dataType: 'json',
							success: function(result){
								if(result.feedback_status == 'succeeded')
								{
									
								}
							}
				});
    	    }
    	);
      FB.Event.subscribe('edge.remove',
    		    function(response) {
		    	  var datastring = 'ajax=true&fb_like=2&pid=' + id_product;
			    	$.ajax(
							{
								type: 'POST',
								url: baseDir + 'feedback.php',
								data: datastring,
								dataType: 'json',
								success: function(result){
									if(result.feedback_status == 'succeeded')
									{
										
									}
								}
					});
    		    }
    		);
  };

  function plusClick(data)
  {
	  var plus_click_type = 0;
	  if(data.state=="on"){
		  plus_click_type = 1;
	    }else if(data.state=="off"){
	    	plus_click_type = 2;
	    }

	    var datastring = 'ajax=true&plus_click='+ plus_click_type + '&pid=' + id_product;
		$.ajax(
				{
					type: 'POST',
					url: baseDir + 'feedback.php',
					data: datastring,
					dataType: 'json',
					success: function(result){
						if(result.feedback_status == 'succeeded')
						{
							
						}
					}
		});
  }

  (function(d){
    var js, id = 'facebook-jssdk'; 
    if (d.getElementById(id)) {
      return; // already loaded, no need to load again
    }
    js = d.createElement('script'); js.id = id; js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    d.getElementsByTagName('head')[0].appendChild(js);
  }(document));
{/literal}
</script>


{include file="$tpl_dir./errors.tpl"}
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
	
	{if isset($groups)}
		// Combinations
		{foreach from=$combinations key=idCombination item=combination}
			addCombination({$idCombination|intval}, new Array({$combination.list}), {$combination.quantity}, {$combination.price}, {$combination.ecotax}, {$combination.id_image}, '{$combination.reference|addslashes}', {$combination.unit_impact}, {$combination.minimal_quantity});
		{/foreach}
		// Colors
		{if $colors|@count > 0}
			{if $product->id_color_default}var id_color_default = {$product->id_color_default|intval};{/if}
		{/if}
	{/if}
	
		{*}
		{literal}
		$(document).ready(function() {
			$('#quantity_wanted').numeric({upButtonIcon: 'ui-icon-triangle-1-n', downButtonIcon: 'ui-icon-triangle-1-s', minValue:1, maxValue:100, increment:1 });
		});
		{/literal}
		*}
	//]]>
</script>


<div style="width:700px;float:left;">
	{include file="$tpl_dir./breadcrumb.tpl"}
</div>
<div class="breadcrumb" style="float:left;width:280px;text-align:right">
	<a href="{$link->getmanufacturerLink($product_manufacturer->id_manufacturer, $product_manufacturer->link_rewrite)|escape:'htmlall':'UTF-8'}" title="All {$product->manufacturer_name} Products">
		All {$product->manufacturer_name} Products
	</a>
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

	<div style="float:left;width:700px">
	<!-- right infos-->
	<div id="pb-right-column">
		<!-- product img-->
		<div id="image-block">
		{if $have_image}
			<img itemprop="image" src="{$link->getImageLink($product->link_rewrite, $cover.id_image, 'large')}"
				{if $jqZoomEnabled}class="jqzoom" alt="{$link->getImageLink($product->link_rewrite, $cover.id_image, 'thickbox')}"{else} title="{$product->name|escape:'htmlall':'UTF-8'}" alt="{$product->name|escape:'htmlall':'UTF-8'}" {/if} id="bigpic" />
		{else}
			<img src="{$img_prod_dir}{$lang_iso}-default-large.jpg" id="bigpic" alt="" title="{$product->name|escape:'htmlall':'UTF-8'}" width="{$largeSize.width}" height="{$largeSize.height}" />
		{/if}
		</div>

		{if isset($images) && count($images) > 0}
		<!-- thumbnails -->
		<div id="views_block" {if isset($images) && count($images) < 2}class="hidden"{/if}>
		{if isset($images) && count($images) > 3}<span class="view_scroll_spacer"><a id="view_scroll_left" class="hidden" title="{l s='Other views'}" href="javascript:{ldelim}{rdelim}">{l s='Previous'}</a></span>{/if}
		<div id="thumbs_list">
			<ul id="thumbs_list_frame">
				{if isset($images)}
					{foreach from=$images item=image name=thumbnails}
					{assign var=imageIds value="`$product->id`-`$image.id_image`"}
					<li id="thumbnail_{$image.id_image}">
						<a href="{$link->getImageLink($product->link_rewrite, $imageIds, 'thickbox')}" rel="other-views" class="thickbox {if $smarty.foreach.thumbnails.first}shown{/if}" title="{$image.legend|htmlspecialchars}" style="overflow:scroll">
							<img id="thumb_{$image.id_image}" src="{$link->getImageLink($product->link_rewrite, $imageIds, 'medium')}" alt="{$image.legend|htmlspecialchars}" height="{$mediumSize.height}" width="{$mediumSize.width}" />
						</a>
					</li>
					{/foreach}
				{/if}
			</ul>
		</div>
		{if isset($images) && count($images) > 3}<a id="view_scroll_right" title="{l s='Other views'}" href="javascript:{ldelim}{rdelim}">{l s='Next'}</a>{/if}
		</div>
		{/if}
		{if isset($images) && count($images) > 1}<p class="align_center clear"><span id="wrapResetImages" style="display: none;"><img src="{$img_dir}icon/cancel_16x18.gif" alt="{l s='Cancel'}" width="16" height="18"/> <a id="resetImages" href="{$link->getProductLink($product)}" onclick="$('span#wrapResetImages').hide('slow');return (false);">{l s='Display all pictures'}</a></span></p>{/if}
{*		
		<!-- usefull links-->
		<ul id="usefull_link_block">
			{if $HOOK_EXTRA_LEFT}{$HOOK_EXTRA_LEFT}{/if}
			<li><a href="javascript:print();">{l s='Print'}</a><br class="clear" /></li>
			{if $have_image && !$jqZoomEnabled}
			<li><span id="view_full_size" class="span_link">{l s='View full size'}</span></li>
			{/if}
		</ul>
*}
	</div>

	<!-- left infos-->
	<div id="pb-left-column">
	<div style="height:75px;vertical-align:middle;display:table-cell">
		<h1 itemprop="name">{$product->name|escape:'htmlall':'UTF-8'}</h1>
	</div>

	<div id="social-love" style="vertical-align:top;height:24px;">
		<div style="display:inline-block;vertical-align:top">
			<div class="g-plusone" data-annotation="none" callback="plusClick"></div>
			<script type="text/javascript">
			  (function() {
			    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			    po.src = 'https://apis.google.com/js/plusone.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
		</div>
		<div style="display:inline-block;vertical-align:top;padding:0px 5px;">
			<div class="fb-like" data-send="false" data-width="300" data-show-faces="false" data-font="arial"></div>
		</div>
	</div>

		{*{if $product->description_short OR $packItems|@count > 0}*}
		{if $packItems|@count > 0}
		<div id="short_description_block">
{*			
			{if $product->description_short}
				<div id="short_description_content" class="rte align_justify">{$product->description_short}</div>
			{/if}
			{if $product->description}
			<p class="buttons_bottom_block"><a href="javascript:{ldelim}{rdelim}" class="button">{l s='More details'}</a></p>
			{/if}
*}
			{if $packItems|@count > 0}
				<h3>{l s='Pack content'}</h3>
				{foreach from=$packItems item=packItem}
					<div class="pack_content">
						{$packItem.pack_quantity} x <a href="{$link->getProductLink($packItem.id_product, $packItem.link_rewrite, $packItem.category)}">{$packItem.name|escape:'htmlall':'UTF-8'}</a>
						<p>{$packItem.description_short}</p>
					</div>
				{/foreach}
			{/if}
		</div>
		{/if}

		{if isset($colors) && $colors}
		<!-- colors -->
		<div id="color_picker">
			<p>{l s='Pick a color:' js=1}</p>
			<div class="clear"></div>
			<ul id="color_to_pick_list">
			{foreach from=$colors key='id_attribute' item='color'}
				<li><a id="color_{$id_attribute|intval}" class="color_pick" style="background: {$color.value};" onclick="updateColorSelect({$id_attribute|intval});$('#wrapResetImages').show('slow');" title="{$color.name}">{if file_exists($col_img_dir|cat:$id_attribute|cat:'.jpg')}<img src="{$img_col_dir}{$id_attribute}.jpg" alt="{$color.name}" width="20" height="20" />{/if}</a></li>
			{/foreach}
			</ul>
			<div class="clear"></div>
		</div>
		{/if}
		
		{if ($product->show_price AND !isset($restricted_country_mode)) OR isset($groups) OR $product->reference OR (isset($HOOK_PRODUCT_ACTIONS) && $HOOK_PRODUCT_ACTIONS)}
		<!-- add to cart form-->
		<form id="buy_block" {if $PS_CATALOG_MODE AND !isset($groups) AND $product->quantity > 0}class="hidden"{/if} action="{$link->getPageLink('cart.php')}" method="post">

			<!-- hidden datas -->
			<p class="hidden">
				<input type="hidden" name="token" value="{$static_token}" />
				<input type="hidden" name="id_product" value="{$product->id|intval}" id="product_page_product_id" />
				<input type="hidden" name="add" value="1" />
				<input type="hidden" name="id_product_attribute" id="idCombination" value="" />
			</p>

			<div class="price-info">
	            <div class="price-block">
				<!-- prices -->
				{if $product->show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}
					<p class="price">
						{if !$priceDisplay || $priceDisplay == 2}
							{assign var='productPrice' value=$product->getPrice(true, $smarty.const.NULL, 2)}
							{assign var='productPriceWithoutRedution' value=$product->getPriceWithoutReduct(false, $smarty.const.NULL)}
						{elseif $priceDisplay == 1}
							{assign var='productPrice' value=$product->getPrice(false, $smarty.const.NULL, 2)}
							{assign var='productPriceWithoutRedution' value=$product->getPriceWithoutReduct(true, $smarty.const.NULL)}
						{/if}
						{*{if $product->on_sale}
							<img src="{$img_dir}onsale_{$lang_iso}.gif" alt="{l s='On sale'}" class="on_sale_img"/>
							<span class="on_sale">{l s='On sale!'}</span>
						{elseif $product->specificPrice AND $product->specificPrice.reduction AND $productPriceWithoutRedution > $productPrice}
							<span class="discount">{l s='Reduced price!'}</span>
						{/if}*}
						<span class="our_price_display">
						{if $priceDisplay >= 0 && $priceDisplay <= 2}
							<span id="our_price_display">{convertPrice price=$productPrice}</span>
								{*{if $tax_enabled  && ((isset($display_tax_label) && $display_tax_label == 1) OR !isset($display_tax_label))}
									{if $priceDisplay == 1}{l s='tax excl.'}{else}{l s='tax incl.'}{/if}
								{/if}*}
						{/if}
						</span>
						{if $priceDisplay == 2}
							<br />
							<span id="pretaxe_price"><span id="pretaxe_price_display">{convertPrice price=$product->getPrice(false, $smarty.const.NULL)}</span>&nbsp;{l s='tax excl.'}</span>
						{/if}
						<br />
					</p>
					{if $product->specificPrice AND $product->specificPrice.reduction}
						<p id="old_price"><span>
							<span style="font-size:13px">MRP </span>
							{if $priceDisplay >= 0 && $priceDisplay <= 2}
								{if $productPriceWithoutRedution > $productPrice}
									<span id="old_price_display">{convertPrice price=$productPriceWithoutRedution}</span>
										{*{if $tax_enabled && $display_tax_label == 1}
											{if $priceDisplay == 1}{l s='tax excl.'}{else}{l s='tax incl.'}{/if}
										{/if}*}
								{/if}
							{/if}
							</span>
						</p>
	
					{/if}
					
					{if $productPriceWithoutRedution - $productPrice > 1}
						<p id="reduction_percent">{l s='('}<span id="reduction_percent_display">{round((($productPriceWithoutRedution - $productPrice)/$productPriceWithoutRedution)*100)}</span>%{l s=' Off)'}</p>
					{/if}
					
					{if $packItems|@count}
						<p class="pack_price">{l s='instead of'} <span style="text-decoration: line-through;">{convertPrice price=$product->getNoPackPrice()}</span></p>
						<br class="clear" />
					{/if}
					{if $product->ecotax != 0}
						<p class="price-ecotax">{l s='include'} <span id="ecotax_price_display">{if $priceDisplay == 2}{$ecotax_tax_exc|convertAndFormatPrice}{else}{$ecotax_tax_inc|convertAndFormatPrice}{/if}</span> {l s='for green tax'}
							{if $product->specificPrice AND $product->specificPrice.reduction}
							<br />{l s='(not impacted by the discount)'}
							{/if}
						</p>
					{/if}
					{if !empty($product->unity) && $product->unit_price_ratio > 0.000000}
					    {math equation="pprice / punit_price"  pprice=$productPrice  punit_price=$product->unit_price_ratio assign=unit_price}
						<p class="unit-price"><span id="unit_price_display">{convertPrice price=$unit_price}</span> {l s='per'} {$product->unity|escape:'htmlall':'UTF-8'}</p>
					{/if}
					{*close if for show price*}
				{/if}
				</div>
            	<span style="float: left; width: 130px; padding-top:4px;padding-bottom: 12px;background: url({$img_dir}phone.png) no-repeat left top transparent;padding-left:36px;">Need help in buying this product? Call Us!</span>
            	<span style="float: left; width: 150px;text-align:center;font-size:18px;padding-left: 6px;color:#939393" >+91-80-65655500</span>
            	<span style="float: left; width: 150px;text-align:center;font-size:10px;padding-left: 6px;color:#939393" >(10 AM to 7 PM, Mon to Sat)</span>
            </div> 

			
			{if isset($groups)}
				<!-- attributes -->
				<div id="attributes" style="display:none">
					{foreach from=$groups key=id_attribute_group item=group}
						{if $group.attributes|@count}
							<p>
								<label for="group_{$id_attribute_group|intval}">{$group.name|escape:'htmlall':'UTF-8'} :</label>
								{assign var="groupName" value="group_$id_attribute_group"}
								<select name="{$groupName}" id="group_{$id_attribute_group|intval}" onchange="javascript:findCombination();{if $colors|@count > 0}$('#wrapResetImages').show('slow');{/if};">
									{foreach from=$group.attributes key=id_attribute item=group_attribute}
										<option value="{$id_attribute|intval}"{if (isset($smarty.get.$groupName) && $smarty.get.$groupName|intval == $id_attribute) || $group.default == $id_attribute} selected="selected"{/if} title="{$group_attribute|escape:'htmlall':'UTF-8'}">{$group_attribute|escape:'htmlall':'UTF-8'}</option>
									{/foreach}
								</select>
							</p>
						{/if}
					{/foreach}
				</div>
			{/if}
			{if isset($textures) && $textures}
			<div id="shade_selector" style="width:360px;height:160px;">
				<div id="tex_panel">
				{foreach from=$textures item='texture'}
					<div id="tex_{$texture}" style="height:160px;width:135px;float:left;{if $currentShade.texture == $texture}display:block;{else}display:none{/if}" class="texture {if $currentShade.texture == $texture}visible default{/if}">
						<img src="{$img_ps_dir}shades/{$texture}.png" style="{if $currentShade.texture == $texture}background-color:{$currentShade.color}{/if}"></img>
						<span class="shade_name" style="width:135px;text-align:center;display:block;">{$currentShade.name}</span>
					</div>
				{/foreach}
				</div>
				<div id="color_list">
					<p>Select a shade to see in detail:</p>
					<ul>
					{foreach from=$shades item='shade'}
						<a href="{$shade.link}" alt="{$shade.name}">
							<li class="color_swatch" pid="$shade.id_product" shade="{$shade.name}" texture="{$shade.texture}" color="{$shade.color}" style="background-color: {$shade.color}"><span></span></li>
						</a>
					{/foreach}
					</ul>
				</div>
			</div>
			{/if}
			{if isset($textures) && $textures}
				<script type="text/javascript">
					var currentShade = '{$currentShade.name}';
					var currentTexture = '{$currentShade.texture}';
					var currentColor = '{$currentShade.color}';
					{literal}
						$(document).ready(function() {
							$('.color_swatch').hover(
								function(){
									texture = 'tex_' + $(this).attr('texture');
									color = $(this).attr('color');
									shade = $(this).attr('shade');
									if($('.visible').attr('id') != texture)
									{
										$('.visible').hide().removeClass('visible');
										$('#'+texture).addClass('visible').css('display', 'block');
									}

									$('.visible > img').css('background-color', color);
									$('.visible > .shade_name').html(shade);
								},
								function(){
									$('.visible').hide().removeClass('visible');
									$('#tex_'+currentTexture).addClass('visible').css('display', 'block');
									$('.visible > img').css('background-color', currentColor);
									$('.visible > .shade_name').html(currentShade);
								}
							);
						});
					{/literal}
				</script>
			{/if}
			<p id="product_reference" {if isset($groups) OR !$product->reference}style="display: none;"{/if}><label for="product_reference">{l s='Reference :'} </label><span class="editable">{$product->reference|escape:'htmlall':'UTF-8'}</span></p>

			<!-- quantity wanted -->
			{if (!$allow_oosp && $product->quantity <= 0) OR $virtual OR !$product->available_for_order OR $PS_CATALOG_MODE}
				<div style="text-align:center;font-weight:bold;">Product temporarily out of stock.</div>
			{else}
				
				<div id="quantity_wanted_p" style="width:100px;padding-left:20px;float:left;margin-top:20px;">
					<label style="width:35px;text-align:left;padding-left:3px;padding-top:3px;font-size:15px">{l s='Qty :'}</label>
					<div style="width:60px;position:relative;float:left;">
						<input type="text" name="qty" style="width:40px;display:block;position:relative;height:20px;float:left" id="quantity_wanted" class="text" value="{if isset($quantityBackup)}{$quantityBackup|intval}{else}{if $product->minimal_quantity > 1}{$product->minimal_quantity}{else}1{/if}{/if}" {if $product->minimal_quantity > 1}onkeyup="checkMinimalQuantity({$product->minimal_quantity});"{/if} />
						<a rel="nofollow" style="left:40px;" class="p_quantity_up btn_spinner_up" id="cart_quantity_up_btn" href="#" title="{l s='Add'}"></a>
						<a rel="nofollow" style="left:40px;" class="p_quantity_down btn_spinner_down" id="cart_quantity_down_btn" href="#" title="{l s='Subtract'}"></a>
					</div>
				</div>
				{literal}
					<script type="text/javascript">
						$(document).ready(function() {
							$('#cart_quantity_up_btn').click(function(){
								oldVal = parseInt($('input#quantity_wanted').val());
								if(isNaN(oldVal)) return;
								if(oldVal > 50)
								{
									alert('Sorry, we cannot deliver that many in a single order at this time.');
									return;
								}
								$('input#quantity_wanted').val(oldVal + 1);
							});
							$('#cart_quantity_down_btn').click(function(){
								oldVal = parseInt($('input#quantity_wanted').val());
								if(isNaN(oldVal)) return;
								if(oldVal < 2)
								{
									return;
								}
								$('input#quantity_wanted').val(oldVal - 1);
							});
						});
					</script>
				{/literal}
			{/if}
			
			<!-- minimal quantity wanted -->
			<p id="minimal_quantity_wanted_p"{if $product->minimal_quantity <= 1 OR !$product->available_for_order OR $PS_CATALOG_MODE} style="display: none;"{/if}>{l s='You must add '}<b id="minimal_quantity_label">{$product->minimal_quantity}</b>{l s=' as a minimum quantity to buy this product.'}</p>
			{if $product->minimal_quantity > 1}
			<script type="text/javascript">
				checkMinimalQuantity();
			</script>
			{/if}

{*			
			<!-- availability -->
			<p id="availability_statut"{if ($product->quantity <= 0 && !$product->available_later && $allow_oosp) OR ($product->quantity > 0 && !$product->available_now) OR !$product->available_for_order OR $PS_CATALOG_MODE} style="display: none;"{/if}>
				<span id="availability_label">{l s='Availability:'}</span>
				<span id="availability_value"{if $product->quantity <= 0} class="warning_inline"{/if}>
					{if $product->quantity <= 0}{if $allow_oosp}{$product->available_later}{else}{l s='This product is no longer in stock'}{/if}{else}{$product->available_now}{/if}
				</span>
			</p>

			<!-- number of item in stock -->
			{if ($display_qties == 1 && !$PS_CATALOG_MODE && $product->available_for_order)}
			<p id="pQuantityAvailable"{if $product->quantity <= 0} style="display: none;"{/if}>
				<span id="quantityAvailable">{$product->quantity|intval}</span>
				<span {if $product->quantity > 1} style="display: none;"{/if} id="quantityAvailableTxt">{l s='item in stock'}</span>
				<span {if $product->quantity == 1} style="display: none;"{/if} id="quantityAvailableTxtMultiple">{l s='items in stock'}</span>
			</p>
     		{/if}
	
			<!-- Out of stock hook -->
			<p id="oosHook"{if $product->quantity > 0} style="display: none;"{/if}>
				{$HOOK_PRODUCT_OOS}
			</p>

			<p class="warning_inline" id="last_quantities"{if ($product->quantity > $last_qties OR $product->quantity <= 0) OR $allow_oosp OR !$product->available_for_order OR $PS_CATALOG_MODE} style="display: none;"{/if} >{l s='Warning: Last items in stock!'}</p>

			{if $product->online_only}
				<p>{l s='Online only'}</p>
			{/if}
*}
			<!-- Out of stock hook -->
			<p id="oosHook" style="{if $product->quantity > 0} display: none;{/if} text-align:center; float:left; margin-left:115px;">
				<img alt="Out Of Stock" src="{$img_ps_dir}out_of_stock_v.jpg" />
			</p>
			<div style="width:200px;float:left;padding:15px 0px 0px 20px; {if (!$allow_oosp && $product->quantity <= 0) OR !$product->available_for_order OR (isset($restricted_country_mode) AND $restricted_country_mode) OR $PS_CATALOG_MODE} display: none;{/if}" id="add_to_cart" class="buttons_bottom_block">
				<input class="addtobag" type="submit" name="Submit" value="" /></div>
			{if isset($HOOK_PRODUCT_ACTIONS) && $HOOK_PRODUCT_ACTIONS}{$HOOK_PRODUCT_ACTIONS}{/if}
			<div class="clear"></div>
		</form>
		{/if}
		{if $HOOK_EXTRA_RIGHT}{$HOOK_EXTRA_RIGHT}{/if}
	</div>
	<div id="product-info" style="float:left;">
		<!-- description and features -->
{if $product->description || $features || $accessories || $HOOK_PRODUCT_TAB || $attachments}
<div id="more_info_block" class="clear">
{*
	<ul id="more_info_tabs" class="idTabs idTabsShort">
		{if $product->description}<li><a id="more_info_tab_more_info" href="#idTab1">{l s='More info'}</a></li>{/if}
		{if $features}<li><a id="more_info_tab_data_sheet" href="#idTab2">{l s='Data sheet'}</a></li>{/if}
		{if $attachments}<li><a id="more_info_tab_attachments" href="#idTab9">{l s='Download'}</a></li>{/if}
		{if isset($accessories) AND $accessories}<li><a href="#idTab4">{l s='Accessories'}</a></li>{/if}
		{$HOOK_PRODUCT_TAB}
	</ul>
*}
	<div id="more_info_sheets" class="sheets align_justify">
		<div class="product_more_details">
			<div class="description">
				{if $product->description}
					<!-- full description -->
					<div id="idTab1" class="rte">
						<h3>{l s='Product Information'}</h3>
						<div itemprop="description">{$product->description}</div>
						<br />
						{*<h3>{l s='Product Reviews'}</h3>
						<h4 style="font-family: arial, helvetica, sans-serif; font-size: 13px;color:#000000;">No reviews available for {$product->name|escape:'htmlall':'UTF-8'}</h4>
						*}
					</div>
				{/if}
			</div>
{*			
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
*}
			{$HOOK_PRODUCT_TAB_CONTENT}
		</div>
	</div>
</div>
{/if}
	</div>
	</div>
	<div id="right_info_column">
	    <div class="rht_box">
	    	<img data-href="{$img_ps_dir}freeshipping.jpg" width="240"  class="lazy"/>
	    	<noscript>
	    		<img src="{$img_ps_dir}freeshipping.jpg" width="240"  alt="img1" />
	    	</noscript>
	    </div>
	    <div class="rht_box">
	    	<img data-href="{$img_ps_dir}cashondelivery.jpg" width="240"  class="lazy"/>
	    	<noscript>
	    		<img src="{$img_ps_dir}cashondelivery.jpg" width="240"  alt="img1" />
	    	</noscript>
	    </div>
	    <div class="rht_box">
	    	<img data-href="{$img_ps_dir}payment.jpg" width="240" class="lazy" />
	    	<noscript>
	    		<img src="{$img_ps_dir}payment.jpg" width="240" alt="img1" />
	    	</noscript>
	    </div>
	    <div class="fb-like-box" 
	    	data-href="http://www.facebook.com/pages/VioletBagcom/156806014397317" 
	    	data-width="240" 
	    	data-show-faces="true" 
	    	data-stream="false" 
	    	data-header="false"></div>
  	</div>
  	<div id="products_block" style="float:left;">
		<script>
			// execute your scripts when the DOM is ready. this is mostly a good habit
			$(function() {
			
				// initialize scrollable
				$(".scrollable").scrollable();
			
			});
		</script>
		<div id="category_products" class="sheets">
		<h2 class="products_heading">Other Popular Products</h2>
		<div  class="products_block">
			<!-- "previous page" action -->
			<a class="prev browse left">Prev</a>
			
			<!-- root element for scrollable -->
			<div class="scrollable">   
			   
			   <!-- root element for the items -->
			   <div class="items">
			   
					{if isset($new_products)}
						
						
						{foreach from=$new_products item=productitem name=products}
							{if $smarty.foreach.products.first == true || $smarty.foreach.products.index % 4 == 0}
					     		<div>
					     			<!-- Products list -->
									<ul>	
					  		{/if}
										<li class="ajax_block_product" rel="{$productitem.id_product}" {if $smarty.foreach.products.index % 4 == 0}style=" margin-left:15px"{/if}>
											<div class=" {if $smarty.foreach.products.index % 4 == 0} left_card {else}product_card{/if}">
												{if $productitem.quantity <= 0}
												<img alt="Out Of Stock" src="{$img_ps_dir}out_of_stock_vs.png" style="margin:0 0;position:absolute;left:1px; top:0px;"/>
												{/if}
												<a href="{$productitem.link}">
													<span class="product_image" href="{$productitem.link}" title="{$productitem.name|escape:html:'UTF-8'}">
														{if isset($lazy) && $lazy == 1}
															<img data-href="{$link->getImageLink($productitem.link_rewrite, $productitem.id_image, 'home')}" height="129" alt="{$productitem.name|escape:html:'UTF-8'}"  class="lazy"/>
															<noscript>
																<img src="{$link->getImageLink($productitem.link_rewrite, $productitem.id_image, 'home')}" height="129" alt="{$productitem.name|escape:html:'UTF-8'}" />
															</noscript>
														{else}
															<img src="{$link->getImageLink($productitem.link_rewrite, $productitem.id_image, 'home')}" height="129" alt="{$productitem.name|escape:html:'UTF-8'}" />
														{/if}
													</span>
								                   <span class="product-list-name">
									                   <h2 class="product_card_name">{$productitem.name|truncate:100:'...'|escape:'htmlall':'UTF-8'}</h2>
								                  	</span>
													<span class="product_info">
								                       	<span class="price">{if !$priceDisplay}{convertPrice price=$productitem.price}{else}{convertPrice price=$productitem.price_tax_exc}{/if}</span>
								                       	{if ($productitem.price_without_reduction - $productitem.price > 1)}
									                       	<span class="strike_price">MRP {if !$priceDisplay}{convertPrice price=$productitem.price_without_reduction} {/if}</span>
									                       	<span class="clear" style="display:block;color:#DA0F00;">({round((($productitem.price_without_reduction - $productitem.price)/$productitem.price_without_reduction)*100)}% Off)</span>
															
														{/if}
													</span>
												</a>
												{if ($productitem.quantity > 0 OR $productitem.allow_oosp) AND $productitem.customizable != 2}
													<span id="ajax_id_product_{$productitem.id_product}" class="add2cart exclusive ajax_add_to_cart_button" idprod="ajax_id_product_{$productitem.id_product}" title="{l s='Add to Bag' mod='homefeatured'}">{l s='Add to Bag' mod='homefeatured'}</span>
												{/if}
											</div>
										</li>
							{if $smarty.foreach.products.index % 4 == 3 || $smarty.foreach.products.last == true}
			     					</ul>
			     				</div>
			  				{/if}
						{/foreach}
						
						<!-- /Products list -->
					{/if}
			   
			   </div>
			   
			</div>
			
			<!-- "next page" action -->
			<a class="next browse right" style="display:block;">Next</a>
		</div>
		</div>
		
		<div id="brand_products" class="sheets">
		<h2 class="products_heading">
			<a href="{$link->getmanufacturerLink($product_manufacturer->id_manufacturer, $product_manufacturer->link_rewrite)|escape:'htmlall':'UTF-8'}" title="All {$product->manufacturer_name} Products">
				Other Products From {$product->manufacturer_name}
			</a>
		</h2>
		<div  class="products_block">
			<!-- "previous page" action -->
			<a class="prev browse left">Prev</a>
			
			<div class="scrollable">   
			   
			   <div class="items">
					{if isset($brand_products)}
						{foreach from=$brand_products item=productitem name=brandproducts}
							{if $smarty.foreach.brandproducts.first == true || $smarty.foreach.brandproducts.index % 4 == 0}
					     		<div>
									<ul>	
					  		{/if}
										<li class="ajax_block_product" rel="{$productitem.id_product}" {if $smarty.foreach.brandproducts.index % 4 == 0}style=" margin-left:15px"{/if}>
											<div class=" {if $smarty.foreach.brandproducts.index % 4 == 0} left_card {else}product_card{/if}">
												{if $productitem.quantity <= 0}
												<img alt="Out Of Stock" src="{$img_ps_dir}out_of_stock_vs.png" style="margin:0 0;position:absolute;left:1px; top:0px;"/>
												{/if}
												<a href="{$productitem.link}">
													<span class="product_image" href="{$productitem.link}" title="{$productitem.name|escape:html:'UTF-8'}">
														{if isset($lazy) && $lazy == 1}
															<img data-href="{$link->getImageLink($productitem.link_rewrite, $productitem.id_image, 'home')}" height="129" alt="{$productitem.name|escape:html:'UTF-8'}"  class="lazy"/>
															<noscript>
																<img src="{$link->getImageLink($productitem.link_rewrite, $productitem.id_image, 'home')}" height="129" alt="{$productitem.name|escape:html:'UTF-8'}" />
															</noscript>
														{else}
															<img src="{$link->getImageLink($productitem.link_rewrite, $productitem.id_image, 'home')}" height="129" alt="{$productitem.name|escape:html:'UTF-8'}" />
														{/if}
													</span>
								                   <span class="product-list-name">
									                   <h2 class="product_card_name">{$productitem.name|truncate:100:'...'|escape:'htmlall':'UTF-8'}</h2>
								                  	</span>
													<span class="product_info">
								                       	<span class="price">{if !$priceDisplay}{convertPrice price=$productitem.price}{else}{convertPrice price=$productitem.price_tax_exc}{/if}</span>
								                       	{if ($productitem.price_without_reduction - $productitem.price > 1)}
									                       	<span class="strike_price">MRP {if !$priceDisplay}{convertPrice price=$productitem.price_without_reduction} {/if}</span>
									                       	<span class="clear" style="display:block;color:#DA0F00;">({round((($productitem.price_without_reduction - $productitem.price)/$productitem.price_without_reduction)*100)}% Off)</span>
															
														{/if}
													</span>
												</a>
												{if ($productitem.quantity > 0 OR $productitem.allow_oosp) AND $productitem.customizable != 2}
													<span id="ajax_id_product_{$productitem.id_product}" class="add2cart exclusive ajax_add_to_cart_button" idprod="ajax_id_product_{$productitem.id_product}" title="{l s='Add to Bag' mod='homefeatured'}">{l s='Add to Bag' mod='homefeatured'}</span>
												{/if}
											</div>
										</li>
							{if $smarty.foreach.brandproducts.index % 4 == 3 || $smarty.foreach.brandproducts.last == true}
			     					</ul>
			     				</div>
			  				{/if}
						{/foreach}
						
						<!-- /Products list -->
					{/if}
			   
			   </div>
			   
			</div>
			
			<!-- "next page" action -->
			<a class="next browse right" style="display:block;">Next</a>
		</div>
		</div>
	</div>
</div>

{if $quantity_discounts}
<!-- quantity discount -->
<ul class="idTabs">
	<li><a style="cursor: pointer" class="selected">{l s='Quantity discount'}</a></li>
</ul>
<div id="quantityDiscount">
	<table class="std">
		<tr>
			{foreach from=$quantity_discounts item='quantity_discount' name='quantity_discounts'}
				<th>{$quantity_discount.quantity|intval}
				{if $quantity_discount.quantity|intval > 1}
					{l s='quantities'}
				{else}
					{l s='quantity'}
				{/if}
				</th>
			{/foreach}
		</tr>
		<tr>
			{foreach from=$quantity_discounts item='quantity_discount' name='quantity_discounts'}
				<td>
				{if $quantity_discount.price != 0 OR $quantity_discount.reduction_type == 'amount'}
					-{convertPrice price=$quantity_discount.real_value|floatval}
				{else}
    				-{$quantity_discount.real_value|floatval}%
				{/if}
				</td>
			{/foreach}
		</tr>
	</table>
</div>
{/if}

{$HOOK_PRODUCT_FOOTER}



<!-- Customizable products -->
{if $product->customizable}
	<ul class="idTabs">
		<li><a style="cursor: pointer">{l s='Product customization'}</a></li>
	</ul>
	<div class="customization_block">
		<form method="post" action="{$customizationFormTarget}" enctype="multipart/form-data" id="customizationForm">
			<p>
				<img src="{$img_dir}icon/infos.gif" alt="Informations" />
				{l s='After saving your customized product, remember to add it to your cart.'}
				{if $product->uploadable_files}<br />{l s='Allowed file formats are: GIF, JPG, PNG'}{/if}
			</p>
			{if $product->uploadable_files|intval}
			<h2>{l s='Pictures'}</h2>
			<ul id="uploadable_files">
				{counter start=0 assign='customizationField'}
				{foreach from=$customizationFields item='field' name='customizationFields'}
					{if $field.type == 0}
						<li class="customizationUploadLine{if $field.required} required{/if}">{assign var='key' value='pictures_'|cat:$product->id|cat:'_'|cat:$field.id_customization_field}
							{if isset($pictures.$key)}<div class="customizationUploadBrowse">
									<img src="{$pic_dir}{$pictures.$key}_small" alt="" />
									<a href="{$link->getProductDeletePictureLink($product, $field.id_customization_field)}" title="{l s='Delete'}" >
										<img src="{$img_dir}icon/delete.gif" alt="{l s='Delete'}" class="customization_delete_icon" width="11" height="13" />
									</a>
								</div>{/if}
							<div class="customizationUploadBrowse"><input type="file" name="file{$field.id_customization_field}" id="img{$customizationField}" class="customization_block_input {if isset($pictures.$key)}filled{/if}" />{if $field.required}<sup>*</sup>{/if}
							<div class="customizationUploadBrowseDescription">{if !empty($field.name)}{$field.name}{else}{l s='Please select an image file from your hard drive'}{/if}</div></div>
						</li>
						{counter}
					{/if}
				{/foreach}
			</ul>
			{/if}
			<div class="clear"></div>
			{if $product->text_fields|intval}
			<h2>{l s='Texts'}</h2>
			<ul id="text_fields">
				{counter start=0 assign='customizationField'}
				{foreach from=$customizationFields item='field' name='customizationFields'}
					{if $field.type == 1}
						<li class="customizationUploadLine{if $field.required} required{/if}">{assign var='key' value='textFields_'|cat:$product->id|cat:'_'|cat:$field.id_customization_field}
							{if !empty($field.name)}{$field.name}{/if}{if $field.required}<sup>*</sup>{/if}<textarea type="text" name="textField{$field.id_customization_field}" id="textField{$customizationField}" rows="1" cols="40" class="customization_block_input" />{if isset($textFields.$key)}{$textFields.$key|stripslashes}{/if}</textarea>
						</li>
						{counter}
					{/if}
				{/foreach}
			</ul>
			{/if}
			<p style="clear: left;" id="customizedDatas">
				<input type="hidden" name="quantityBackup" id="quantityBackup" value="" />
				<input type="hidden" name="submitCustomizedDatas" value="1" />
				<input type="button" class="button" value="{l s='Save'}" onclick="javascript:saveCustomization()" />
				<span id="ajax-loader" style="display:none"><img src="{$img_ps_dir}loader.gif" alt="loader" /></span>
			</p>
		</form>
		<p class="clear required"><sup>*</sup> {l s='required fields'}</p>
	</div>
{/if}

{if $packItems|@count > 0}
	<div>
		<h2>{l s='Pack content'}</h2>
		{include file="$tpl_dir./product-list.tpl" products=$packItems}
	</div>
{/if}

{/if}
<!-- Google Code for Master List Remarketing List -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 968757656;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "666666";
var google_conversion_label = "sYcMCJjCuwMQmKP4zQM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/968757656/?label=sYcMCJjCuwMQmKP4zQM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
{if $product_manufacturer->id_manufacturer == 76}
<!-- Google Code for VLCC Remarketing List -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 968757656;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "666666";
var google_conversion_label = "DEchCKjAuwMQmKP4zQM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/968757656/?label=DEchCKjAuwMQmKP4zQM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

{/if}
{if $product_manufacturer->id_manufacturer == 78}
<!-- Google Code for Gillette Remarketing List -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 968757656;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "666666";
var google_conversion_label = "Pgf6CKDBuwMQmKP4zQM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/968757656/?label=Pgf6CKDBuwMQmKP4zQM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>	
{/if}


