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

	$(document).ready(function(){
			
			$('#tab-container').easytabs({
					updateHash: false
				});

			$('#customizelink1').click(function(){
				$('.card_customize').hide();
				$('.customizelink').show();
				$('#card_customize1').slideDown();
				$('#customizelink1').hide();
			});

			$('#buy_block').submit(function(e){
				var container = $('#error_container1');
				// validate the form when it is submitted
				var validator = $("#buy_block").validate({
					errorContainer: container,
					errorLabelContainer: $("ol", container),
					wrapper: 'li',
					meta: "validate"
				});
				if(!validator.form())
					e.preventDefault();
			});
	});
	
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
	//]]>
</script>


<div style="width:700px;float:left;padding-top:5px;">
	{include file="$tpl_dir./breadcrumb.tpl"}
</div>
<div class="breadcrumb" style="float:left;width:280px;text-align:right;padding-top:5px;">
	{*<a href="{$link->getmanufacturerLink($product_manufacturer->id_manufacturer, $product_manufacturer->link_rewrite)|escape:'htmlall':'UTF-8'}" title="All {$product->manufacturer_name} Products">
		All {$product->manufacturer_name} Products
	</a>*}
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
			<!-- product img-->
			<div style="padding:30px 0">			
				<img src="{$img_ps_dir}banners/{$product->location}" id="bigpic" alt="" title="{$product->name|escape:'htmlall':'UTF-8'}" width="450" height="239" />
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
				<input type="hidden" name="is_customized" id="is_customized" value="1" />
			</p>

			<div class="price-info">
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
						{if $product->specificPrice AND $product->specificPrice.reduction}
						<span id="old_price">
							{if $priceDisplay >= 0 && $priceDisplay <= 2}
								{if $productPriceWithoutRedution > $productPrice}
									<span id="old_price_display">{convertPrice price=$productPriceWithoutRedution}</span>
								{/if}
							{/if}
						</span>
						{/if}
						
						{if $priceDisplay >= 0 AND $priceDisplay <= 2}
							<span id="our_price_display">
								{convertPrice price=$productPrice}
							</span>
							<span class="price_inr">(Rs {round($productPrice * $conversion_rate)})</span>
						{/if}
						<span style="border-left:1px solid #cacaca;padding:5px">Product Code:  {$product->reference}</span>
					</p>
				{/if}
            </div>
            <div id="social-love" style="vertical-align:top;height:24px;">
				<a href="http://pinterest.com/pin/create/button/?url={$canonical_url|escape:'url'}&media={$og_image_url|escape:'url'}&description={$product->name|escape:'url'}" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
				<div style="display:inline-block;vertical-align:top">
					<div class="g-plusone" data-annotation="none" data-callback="plusClick"></div>
					{literal}
					<script type="text/javascript">
					  (function() {
					    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					    po.src = 'https://apis.google.com/js/plusone.js';
					    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
					  })();
					</script>
					{/literal}
				</div>
				<div style="display:inline-block;vertical-align:top;padding:0px 5px;">
					<div class="fb-like" data-send="false" data-width="300" data-show-faces="false" data-font="arial"></div>
				</div>
			</div>
           {* <div style="line-height:1.1em;">
				{$product->description|truncate:160}
				<span id="seeall" class="span_link" style="color:#75B1DC">(more)</span>
            </div>*}
			
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
			
			<p style="border-top:1px dashed #cacaca;padding:5px 0;clear:both">
				<input type="hidden" name="qty" style="width:40px;display:none;position:relative;height:20px;float:left" id="quantity_wanted" class="text" value="{if isset($quantityBackup)}{$quantityBackup|intval}{else}{if $product->minimal_quantity > 1}{$product->minimal_quantity}{else}1{/if}{/if}" {if $product->minimal_quantity > 1}onkeyup="checkMinimalQuantity({$product->minimal_quantity});"{/if} />
			</p>
			<a id="customizelink1" style="display:none" class="button customizelink" style="display:inline-block" href="#" rel="nofollow">CUSTOMIZE MESSAGE</a>
			<div id="card_customize1" class="card_customize" style="border-bottom:1px dashed #cacaca;padding:5px 0;clear:both">
				<div id="error_container1" class="error_container">
					<h4>There are errors:</h4>
					<ol>
						<li><label for="name_1" class="error">Please select the name of recipient</label></li>
						<li><label for="email_1" class="error">Please enter email address to send gift card to</label></li>
						<li><label for="message_1" class="error">Non empty feedback please</label></li>
					</ol>
				</div>
				<p>
					<label for="from-name" style="width:100px; display:inline-block">Friends Name:</label>
					<input type="text" id="name_1" name="gift_card_name" value="" style="width:340px;" class="required text"/>
				</p>
				<p>
					<label for="from-name" style="width:100px; display:inline-block">Friends Email:</label>
					<input type="text" id="email_1" name="gift_card_email" value="" style="width:340px;" class="required email"/>
				</p>
				<p>
					<label for="from-name" style="width:100px; display:inline-block">Gift Message:</label>
					<textarea type="text" rows="4" id="message_1" name="gift_card_message" value="" style="width:340px;"></textarea>
				</p>
			</div>
				<!-- Out of stock hook -->
			<p id="oosHook" style="{if $product->quantity > 0} display: none;{/if} text-align:center; float:left; margin-left:115px;">
				<img alt="Out Of Stock" src="{$img_ps_dir}out_of_stock_v.jpg" />
			</p>
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
			</div>
			
		</form>
		{if isset($relatedProducts) && $relatedProducts && $relatedProducts|@count > 0}
			<div id="related_products" style="margin:10px 0;width:450px;float:left;">
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
			<div id="tab-container" class="tab-container">
			  <ul class='etabs'>
			    <li class='etab active'><a href="#tabs1">Card</a></li>
			    <li class='etab'><a href="#tabs2">More Details And Terms</a></li>
			  </ul>
			  <div id="tabs1" class='etab_content' style="height:300px;overflow:auto;-ms-overflow-x: hidden;overflow-x: hidden;">
			    <p>
			    	Are you a last minute Gift Shopper?  Are you clueless about that perfect gift for someone special? IndusDiva Gift Cards to the rescue. 
			    	Gift your loved one an IndusDiva Gift Card and let them choose and pick that perfect gift for themselves. 
					Not just this you can also add your special personal message to the card, after all what's a gift if not accompanied by the warmth of words.
			    </p>			    
			  </div>
			  <div id="tabs2" class='etab_content' style="height:300px;overflow:auto;-ms-overflow-x: hidden;overflow-x: hidden;">
			    <p>
			    	1.	IndusDiva Gift Cards are available in the denominations of $50, $100, $200 and $500.<br />
					2.	This is an E-Gift Card and can be redeemed only at IndusDiva.com<br />
					3.	You can redeem one or more Gift Cards at one go.<br />
					4.	It can be used for orders of any value and is also transferrable.<br /> 
					5.	If the product value exceeds the denomination of the gift card, the balance amount needs to be paid using the available payment mode.<br />
					6.	These Gift Cards can be used to buy other Gift Cards.<br />
					7.	A Gift Card can be used only once and is not redeemable against cash or credit.<br />
					8.	A Gift Card will be valid for 365 days from the date of issue.<br />
					9.	A gift card cannot be cancelled.
			    </p>			    
			  </div>
			</div>
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
	<p style="clear:both;border-bottom: 1px dashed #CACACA;padding:5px 0">*There may be minor color variations because of the light and settings during photography and also the color settings and properties of various monitors.</p>
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
(function (w, d, load) {
 var script, 
 first = d.getElementsByTagName('SCRIPT')[0],  
 n = load.length, 
 i = 0,
 go = function () {
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
