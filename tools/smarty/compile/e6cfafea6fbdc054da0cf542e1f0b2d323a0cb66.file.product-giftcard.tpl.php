<?php /* Smarty version Smarty-3.0.7, created on 2015-06-26 06:29:13
         compiled from "/var/www/html/indusdiva/themes/violettheme/product-giftcard.tpl" */ ?>
<?php /*%%SmartyHeaderCode:131866874558ca3e164e656-06273932%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e6cfafea6fbdc054da0cf542e1f0b2d323a0cb66' => 
    array (
      0 => '/var/www/html/indusdiva/themes/violettheme/product-giftcard.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '131866874558ca3e164e656-06273932',
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
			<?php if ($_smarty_tpl->getVariable('product')->value->id_color_default){?>var id_color_default = <?php echo intval($_smarty_tpl->getVariable('product')->value->id_color_default);?>
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
			<!-- product img-->
			<div style="padding:30px 0">			
				<img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
banners/<?php echo $_smarty_tpl->getVariable('product')->value->location;?>
" id="bigpic" alt="" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name,'htmlall','UTF-8');?>
" width="450" height="239" />
			</div>
		</div>

	<!-- left infos-->
	<div id="pb-left-column">
		<h1 itemprop="name"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name,'htmlall','UTF-8');?>
</h1>
		
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
				<input type="hidden" name="is_customized" id="is_customized" value="1" />
			</p>

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
									<span id="old_price_display"><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->getVariable('productPriceWithoutRedution')->value),$_smarty_tpl);?>
</span>
								<?php }?>
							<?php }?>
						</span>
						<?php }?>
						
						<?php if ($_smarty_tpl->getVariable('priceDisplay')->value>=0&&$_smarty_tpl->getVariable('priceDisplay')->value<=2){?>
							<span id="our_price_display">
								<?php echo Product::convertPrice(array('price'=>$_smarty_tpl->getVariable('productPrice')->value),$_smarty_tpl);?>

							</span>
							<span class="price_inr">(Rs <?php echo round($_smarty_tpl->getVariable('productPrice')->value*$_smarty_tpl->getVariable('conversion_rate')->value);?>
)</span>
						<?php }?>
						<span style="border-left:1px solid #cacaca;padding:5px">Product Code:  <?php echo $_smarty_tpl->getVariable('product')->value->reference;?>
</span>
					</p>
				<?php }?>
            </div>
            <div id="social-love" style="vertical-align:top;height:24px;">
				<a href="http://pinterest.com/pin/create/button/?url=<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('canonical_url')->value,'url');?>
&media=<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('og_image_url')->value,'url');?>
&description=<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name,'url');?>
" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
				<div style="display:inline-block;vertical-align:top">
					<div class="g-plusone" data-annotation="none" data-callback="plusClick"></div>
					
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
			
			<?php if (isset($_smarty_tpl->getVariable('groups',null,true,false)->value)){?>
				<!-- attributes -->
				<div id="attributes" style="display:none">
					<?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['id_attribute_group'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('groups')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
 $_smarty_tpl->tpl_vars['id_attribute_group']->value = $_smarty_tpl->tpl_vars['group']->key;
?>
						<?php if (count($_smarty_tpl->tpl_vars['group']->value['attributes'])){?>
							<p>
								<label for="group_<?php echo intval($_smarty_tpl->tpl_vars['id_attribute_group']->value);?>
"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group']->value['name'],'htmlall','UTF-8');?>
 :</label>
								<?php $_smarty_tpl->tpl_vars["groupName"] = new Smarty_variable("group_".($_smarty_tpl->tpl_vars['id_attribute_group']->value), null, null);?>
								<select name="<?php echo $_smarty_tpl->getVariable('groupName')->value;?>
" id="group_<?php echo intval($_smarty_tpl->tpl_vars['id_attribute_group']->value);?>
" onchange="javascript:findCombination();<?php if (count($_smarty_tpl->getVariable('colors')->value)>0){?>$('#wrapResetImages').show('slow');<?php }?>;">
									<?php  $_smarty_tpl->tpl_vars['group_attribute'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['id_attribute'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['group']->value['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['group_attribute']->key => $_smarty_tpl->tpl_vars['group_attribute']->value){
 $_smarty_tpl->tpl_vars['id_attribute']->value = $_smarty_tpl->tpl_vars['group_attribute']->key;
?>
										<option value="<?php echo intval($_smarty_tpl->tpl_vars['id_attribute']->value);?>
"<?php if ((isset($_GET[$_smarty_tpl->getVariable('groupName',null,true,false)->value])&&intval($_GET[$_smarty_tpl->getVariable('groupName')->value])==$_smarty_tpl->tpl_vars['id_attribute']->value)||$_smarty_tpl->tpl_vars['group']->value['default']==$_smarty_tpl->tpl_vars['id_attribute']->value){?> selected="selected"<?php }?> title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value,'htmlall','UTF-8');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value,'htmlall','UTF-8');?>
</option>
									<?php }} ?>
								</select>
							</p>
						<?php }?>
					<?php }} ?>
				</div>
			<?php }?>
			
			<p style="border-top:1px dashed #cacaca;padding:5px 0;clear:both">
				<input type="hidden" name="qty" style="width:40px;display:none;position:relative;height:20px;float:left" id="quantity_wanted" class="text" value="<?php if (isset($_smarty_tpl->getVariable('quantityBackup',null,true,false)->value)){?><?php echo intval($_smarty_tpl->getVariable('quantityBackup')->value);?>
<?php }else{ ?><?php if ($_smarty_tpl->getVariable('product')->value->minimal_quantity>1){?><?php echo $_smarty_tpl->getVariable('product')->value->minimal_quantity;?>
<?php }else{ ?>1<?php }?><?php }?>" <?php if ($_smarty_tpl->getVariable('product')->value->minimal_quantity>1){?>onkeyup="checkMinimalQuantity(<?php echo $_smarty_tpl->getVariable('product')->value->minimal_quantity;?>
);"<?php }?> />
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
			<p id="oosHook" style="<?php if ($_smarty_tpl->getVariable('product')->value->quantity>0){?> display: none;<?php }?> text-align:center; float:left; margin-left:115px;">
				<img alt="Out Of Stock" src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
out_of_stock_v.jpg" />
			</p>
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
			</div>
			
		</form>
		<?php if (isset($_smarty_tpl->getVariable('relatedProducts',null,true,false)->value)&&$_smarty_tpl->getVariable('relatedProducts')->value&&count($_smarty_tpl->getVariable('relatedProducts')->value)>0){?>
			<div id="related_products" style="margin:10px 0;width:450px;float:left;">
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
