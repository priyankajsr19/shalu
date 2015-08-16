<div style="height:150px;width:990px;margin:10px 0;background:url('{$img_ps_dir}banners/divas-closet.jpg') repeat scroll 0 0 transparent">
	<h1 style="padding:45px 60px 0 475px;margin:0;font-size:25px;font-family:Abel">Its all about getting Divalicious with us!</h1>
	<p style="padding:0px 60px;">
		Showcasing our exclusive assortment of hand-picked ensembles just for you, because we do not believe in just dressing up, we believe in making statements.
		Combining the best of ethnicity with contemporary trends and most beautiful of fabrics from every nook and corner of India.
		Diva's closet celebrates the spirit of the IndusDiva lady with &eacute;lan.
	</p>
</div>
<div style="float:left; Width:420px;">
{if isset($curated_products_left)}
	<ul class="clear">
	{foreach from=$curated_products_left item=product name=products}
		<li class="{if $smarty.foreach.products.index % 7 == 0}block_product_large{else}block_product_small{/if}" rel="{$product.id_product}" >
			<div class=" product_card">
			{if !$product.inStock}
				<img alt="Out Of Stock" src="{$img_ps_dir}out_of_stock_vs.png" style="margin:0 0;position:absolute;left:1px; top:0px;"/>
			{/if}
				<a href="{$product.product_link}">
					<span href="{$product.product_link}" title="{$product.name|escape:html:'UTF-8'}">
							{if $smarty.foreach.products.index % 7 == 0}
							<img src="{$img_ps_dir}blank.jpg" data-href="{$product.image_link_large}" height="533" width="390" alt="{$product.name|escape:html:'UTF-8'}"  class="lazy"/>
							<noscript>
								<img src="{$product.image_link_large}" height="533" width="390" alt="{$product.name|escape:html:'UTF-8'}" />
							</noscript>
							{else}
							<img src="{$img_ps_dir}blank.jpg" data-href="{$product.image_link_list}" height="246" width="180" alt="{$product.name|escape:html:'UTF-8'}"  class="lazy"/>
							<noscript>
								<img src="{$product.image_link_list}" width="180" height="246" alt="{$product.name|escape:html:'UTF-8'}" />
							</noscript>
							{/if}
					</span>
                   <span class="product-list-name">
	                   <h2 class="product_card_name">{$product.name|truncate:100:'...'|escape:'htmlall':'UTF-8'}</h2>
                  	</span>
					<span class="product_info">
                       	{if $price_tax_country == 110}
                       		<span class="price">{convertAndShow price=$product.offer_price_in}</span>
                       		{if ($product.discount > 0)}
	                       	<span class="strike_price">{convertAndShow price=$product.mrp_in}</span>
	                       	<span class="clear" style="display:block;color:#DA0F00;">({$product.discount}% Off)</span>
						{/if}
                       	{else}
                       		<span class="price">{convertAndShow price=$product.offer_price}</span>
                       		{if ($product.discount > 0)}
	                       	<span class="strike_price">{convertAndShow price=$product.mrp}</span>
	                       	<span class="clear" style="display:block;color:#DA0F00;">({$product.discount}% Off)</span>
							{/if}
						{/if}
					</span>
				</a>
			</div>
		</li>
		{if $smarty.foreach.products.index % 7 == 0}
		{assign var='countSmall' value=0}
		{else}
		{assign var='countSmall' value=$countSmall+1}
		{/if}
		{if $countSmall % 2 == 0}
     		<li style="clear:both;width:10px;"></li>
  		{/if}
  		{/foreach}
  	</ul>
{/if}
</div>
<div style="float:left; Width:550px;">
{if isset($curated_products_right)}
	<ul class="clear">
	{foreach from=$curated_products_right item=product name=products}
		<li class="block_product_medium" rel="{$product.id_product}" >
			<div class=" product_card">
			{if !$product.inStock}
				<img alt="Out Of Stock" src="{$img_ps_dir}out_of_stock_vs.png" style="margin:0 0;position:absolute;left:1px; top:0px;"/>
			{/if}
				<a href="{$product.product_link}">
					<span href="{$product.product_link}" title="{$product.name|escape:html:'UTF-8'}">
							<img src="{$img_ps_dir}blank.jpg" data-href="{$product.image_link_list}" height="342" width="250" alt="{$product.name|escape:html:'UTF-8'}"  class="lazy"/>
							<noscript>
								<img src="{$product.image_link_list}" height="342" width="250" alt="{$product.name|escape:html:'UTF-8'}" />
							</noscript>
					</span>
                   <span class="product-list-name">
	                   <h2 class="product_card_name">{$product.name|truncate:100:'...'|escape:'htmlall':'UTF-8'}</h2>
                  	</span>
					<span class="product_info">
                       	{if $price_tax_country == 110}
                       		<span class="price">{convertAndShow price=$product.offer_price_in}</span>
                       		{if ($product.discount > 0)}
	                       	<span class="strike_price">{convertAndShow price=$product.mrp_in}</span>
	                       	<span class="clear" style="display:block;color:#DA0F00;">({$product.discount}% Off)</span>
						{/if}
                       	{else}
                       		<span class="price">{convertAndShow price=$product.offer_price}</span>
                       		{if ($product.discount > 0)}
	                       	<span class="strike_price">{convertAndShow price=$product.mrp}</span>
	                       	<span class="clear" style="display:block;color:#DA0F00;">({$product.discount}% Off)</span>
							{/if}
						{/if}
					</span>
				</a>
			</div>
		</li>
		{if $smarty.foreach.products.index % 2 == 1}
     		<li style="clear:both;width:10px;"></li>
  		{/if}
  		{/foreach}
  	</ul>
{/if}
</div>
