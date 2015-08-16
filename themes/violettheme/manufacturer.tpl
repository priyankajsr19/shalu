

<div style="width:770px;">
{include file="$tpl_dir./errors.tpl"}

{if !isset($errors) OR !sizeof($errors)}
	<h1 id="productsHeading">{$manufacturer->name|escape:'htmlall':'UTF-8'} Products</h1>
	{if isset($fetch_error) && $fetch_error}
        <p class="warning">Could not bring the products. Please try after some time.</p>
	{elseif $products}
		{include file="$tpl_dir./product_list_top.tpl" nbProducts=$nb_products}
		{if $cookie->image_size == 1}
			{include file="$tpl_dir./products-pane.tpl" products=$products}
		{else}
			{include file="$tpl_dir./products-pane-small.tpl" products=$products}
		{/if}
		{include file="$tpl_dir./product_list_bottom.tpl" nbProducts=$nb_products}
		{if isset($show_details)}
		<div style="clear:both;padding:10px 0px 0px 0px;">
			<h2 >About {$manufacturer->name|escape:'htmlall':'UTF-8'}</h2>
			{$manufacturer->description}
		</div>
		{/if}
		{if $topSalesProducts}
		<div style="float:left;padding:0px 0px;width:100%;">
		<script>
			// execute your scripts when the DOM is ready. this is mostly a good habit
			$(function() {
			
				// initialize scrollable
				$(".scrollable").scrollable();
			
			});
		</script>
		<div id="top_products">
		<h2 class="panel_heading">Top Selling {$manufacturer->name|escape:'htmlall':'UTF-8'} Products</h2>
		<div  class="products_block" style="padding-left:60px;">
			<!-- "previous page" action -->
			<a class="prev browse left">Prev</a>
			
			<!-- root element for scrollable -->
			<div class="scrollable" style="width:590px">   
			   <!-- root element for the items -->
			   <div class="items">
					{if isset($topSalesProducts)}
						{foreach from=$topSalesProducts item=productitem name=products}
							{if $smarty.foreach.products.first == true || $smarty.foreach.products.index % 3 == 0}
					     		<div>
					     			<!-- Products list -->
									<ul>	
					  		{/if}
										<li class="ajax_block_product" rel="{$productitem.id_product}" {if $smarty.foreach.products.index % 3 == 0}style=" margin-left:15px"{/if}>
											<div class=" {if $smarty.foreach.products.index % 3 == 0} left_card {else}product_card{/if}">
												{if $productitem.quantity <= 0}
												<img alt="Out Of Stock" src="{$img_ps_dir}out_of_stock_vs.png" style="margin:0 0;position:absolute;left:1px; top:0px;"/>
												{/if}
												<a href="{$productitem.link}">
													<span class="product_image" href="{$productitem.link}" title="{$productitem.name|escape:html:'UTF-8'}">
														{if isset($lazy) && $lazy == 1}
															<img data-href="{$link->getImageLink($productitem.link_rewrite, $productitem.id_image, 'home')}" height="129" alt="{$productitem.name|escape:html:'UTF-8'}"  class="delaylazy"/>
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
							{if $smarty.foreach.products.index % 3 == 2 || $smarty.foreach.products.last == true}
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
		{/if}
		{if isset($seo_keywords)}
		<div style="clear:both;padding:10px 0px;;">
			<h2 class="panel_heading">Other popular products</h2>
			{foreach from=$seo_keywords item=keyword name=seo_keywords}
				<span class="popular_products"><a title="{$keyword.keyword}" href="http://{$keyword.url}">{$keyword.keyword}</a></span>
			{/foreach}
		</div>
		{/if}
	{else}
		<p class="warning">{l s='No products for this manufacturer.'}</p>
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

{if isset($remarketing_code)}
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 968757656;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "666666";
var google_conversion_label = "{$remarketing_code}";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/968757656/?label={$remarketing_code}&amp;guid=ON&amp;script=0"/>
</div>
</noscript>	
{/if}

</div>
