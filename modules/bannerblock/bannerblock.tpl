{if $page_name=='index'}
<!-- MODULE Block banners -->
<div id="bannerblock">
<div class="banner_left">
<div id="manufacturers_block_left" class="block blockmanufacturer" style="padding: 0;">
	<h4 class="panel_heading"><a href="{$base_dir}manufacturer.php" title="{l s='Manufacturers' mod='blockmanufacturer'}">{l s='Brands' mod='blockmanufacturer'}</a></h4>
	<div class="block_content" style="padding: 0;">
{if $manufacturers}
	{if $text_list}
	<ul class="bullet">
	{foreach from=$manufacturers item=manufacturer name=manufacturer_list}
		{if $smarty.foreach.manufacturer_list.iteration <= $text_list_nb}
		<li class="{if $smarty.foreach.manufacturer_list.last}last_item{elseif $smarty.foreach.manufacturer_list.first}first_item{else}item{/if}"><a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)}" title="{l s='More about' mod='blockmanufacturer'} {$manufacturer.name}">{$manufacturer.name|escape:'htmlall':'UTF-8'}
                   
                    
                    </a></li>
		{/if}
	{/foreach}
	</ul>
	{/if}
	{if $form_list}
		<form action="{$smarty.server.SCRIPT_NAME}" method="get">
			<p>
				<select id="manufacturer_list" onchange="autoUrl('manufacturer_list', '');">
					<option value="0">{l s='All manufacturers' mod='blockmanufacturer'}</option>
				{foreach from=$manufacturers item=manufacturer}
					<option value="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)}">{$manufacturer.name|escape:'htmlall':'UTF-8'}</option>
				{/foreach}
				</select>
			</p>
		</form>
	{/if}
{else}
	<p>{l s='No manufacturer' mod='blockmanufacturer'}</p>
{/if}
	</div>
</div>











</div>
<div class="banner_right">

<a class="banner_big" href="{$base_dir}category.php?id_category=3"><img src="{$module_dir}banners/mac.jpg" alt=""></a>
	<div>
		<a class="banner1" href="{$base_dir}product.php?id_product=7"><img src="{$module_dir}banners/banner1.jpg" alt=""></a>
		<a class="banner2" href="{$base_dir}new-products.php"><img src="{$module_dir}banners/banner2.jpg" alt=""></a>
		<a class="banner3" href="{$base_dir}category.php?id_category=5"><img src="{$module_dir}banners/banner3.jpg" alt=""></a>
	</div>
</div>


	
</div>
<!-- /MODULE Block banners -->
{/if}