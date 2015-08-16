{literal}
<script type="text/javascript">
//<![CDATA[

//]]>
</script>
{/literal}

<div style="width:970px;">
        {assign var='selitem' value='wishlist'}
	{include file="$tpl_dir./myaccount_menu.tpl"}
	<div class="vtab-content">
		{include file="$tpl_dir./errors.tpl"}
        <h1 style="padding:10px 0;text-align:center;border-bottom:1px dashed #cacaca">Wishlist</h1>
        {if isset($wishlist_products) && $wishlist_products}
        <div id="products_block"  class="products_block">
            <ul id="product_list" class="clear product_list">
                {foreach from=$wishlist_products item=product name=wishlist_products}
                    <li class="ajax_block_product" rel="{$product.id_product}" >
            			<div class=" product_card">
            			    {if !$product.inStock}
            				    <img alt="Out Of Stock" src="{$img_ps_dir}out_of_stock_vs.png" style="margin:0 0;position:absolute;left:1px; top:0px;"/>
            			    {/if}
            			    
            				<a href="{$product.product_link}">
            					<span class="product_image_large" href="{$product.product_link}" title="{$product.name|escape:html:'UTF-8'}">
            						{if isset($lazy) && $lazy == 1}
            							<img src="{$img_ps_dir}blank.jpg" data-href="{$product.image_link_list}" height="342" width="250" alt="{$product.name|escape:html:'UTF-8'}"  class="lazy"/>
            							<noscript>
            								<img src="{$product.image_link_list}" height="342" width="250" alt="{$product.name|escape:html:'UTF-8'}" />
            							</noscript>
            						{else}
            							<img src="{$product.image_link_list}" height="342" width="250" alt="{$product.name|escape:html:'UTF-8'}" />
            						{/if}
            					</span>
                               <span class="product-list-name">
            	                   <h2 class="product_card_name">{$product.name|truncate:100:'...'|escape:'htmlall':'UTF-8'}</h2>
                              	</span>
            					<span class="product_info">
                                   	{if $price_tax_country == 110}
                                   		<span class="price">{convertAndShow price=$product.offer_price_in}</span>
                                   	{else}
                                   		<span class="price">{convertAndShow price=$product.offer_price}</span>
            						{/if}
            					</span>
            					<a class="span_link delete_measurement" style="display:inline-block; text-align:center" href="{$base_dir}wishlist.php?delete={$product.id_product}">
            					    <span style="color:red">Remove</span>
            					</a>
            				</a>
            			</div>
            		</li>
            		{if $smarty.foreach.wishlist_products.index % 3 == 2 && $smarty.foreach.wishlist_products.last == false}
                 		<li style="font-size:0px;line-height:0px;border-top:1px solid #D1A6E0;border-bottom:1px solid #D1A6E0;clear:both; margin:5px 25px;width:740px;height:2px;padding:0;"></li>
              		{/if}
                {/foreach}
            </ul>
        </div>
        {else}
        <p style="text-align:center">You have empty wishlist. Start adding products!</p>   
        {/if}
        
	</div>
</div>
