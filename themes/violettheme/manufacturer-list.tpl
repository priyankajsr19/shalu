{capture name=path}{l s='Brands'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<div class="AllBrandsLetterListLabel">
	<span class="brands-index" style="width:980px;display:block;">
		{foreach from=$brandsIndex key=k item=brand name=brandIndex}
			{if count($brand) > 0}
				<span class="{if $smarty.foreach.brandIndex.first}brand-index-first{/if}{if $smarty.foreach.brandIndex.last}brand-index-last{/if}">{$k}</span>
			{else}
				<span class="no_brands {if $smarty.foreach.brandIndex.first}brand-index-first{/if} {if $smarty.foreach.brandIndex.last}brand-index-last{/if}">{$k}</span>
			{/if}
		{/foreach}
	</span>
</div>

{if isset($errors) AND $errors}
	{include file="$tpl_dir./errors.tpl"}
{else}
	{if $nbManufacturers > 0}
	{foreach from=$cols item=brandGroup}
		<div style="width:180px;float:left;">
			{foreach from=$brandGroup key=k item=charBrands name=manufacturers}
				{if count($charBrands) > 0}
					<div class="brands-group">
						<span class="brands-index">{$k}</span>
						<ul class="manufacturers_list">
							{foreach from=$charBrands item=manufacturer}
								<li class="{if $smarty.foreach.manufacturers.first}first_item{elseif $smarty.foreach.manufacturers.last}last_item{else}item{/if}"> 
									<span>{if $manufacturer.nb_products > 0}<a class="brand-name" href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'htmlall':'UTF-8'}">{/if}
											{$manufacturer.name|truncate:60:'...'|escape:'htmlall':'UTF-8'}
											{if $manufacturer.nb_products > 0}</a>{/if}
									</span>
									{*<span><a class="brand-name">{$manufacturer}</a></span>*}
								</li>
							{/foreach}
						</ul>
					</div>
				{/if}
			{/foreach}
		</div>	
	{/foreach}	
				{*<div>
					<!-- logo -->
					<div class="logo">
					{if $manufacturer.nb_products > 0}<a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'htmlall':'UTF-8'}" title="{$manufacturer.name|escape:'htmlall':'UTF-8'}">{/if}
						<img src="{$img_manu_dir}{$manufacturer.image|escape:'htmlall':'UTF-8'}-medium.jpg" alt="" width="{$mediumSize.width}" height="{$mediumSize.height}" />
					{if $manufacturer.nb_products > 0}</a>{/if}
					</div>
					<!-- name -->
					<h3>
						{if $manufacturer.nb_products > 0}<a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'htmlall':'UTF-8'}">{/if}
						{$manufacturer.name|truncate:60:'...'|escape:'htmlall':'UTF-8'}
						{if $manufacturer.nb_products > 0}</a>{/if}
					</h3>
					<p class="description rte">
					{if $manufacturer.nb_products > 0}<a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'htmlall':'UTF-8'}">{/if}
					{$manufacturer.description}
					{if $manufacturer.nb_products > 0}</a>{/if}
					</p>
				</div>

				<div class="right_side">
				{if $manufacturer.nb_products > 0}<a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'htmlall':'UTF-8'}">{/if}
					<span>{$manufacturer.nb_products|intval} {if $manufacturer.nb_products == 1}{l s='product'}{else}{l s='products'}{/if}</span>
				{if $manufacturer.nb_products > 0}</a>{/if}

				{if $manufacturer.nb_products > 0}
					<a class="button" href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'htmlall':'UTF-8'}">{l s='view products'}</a>
				{/if}
				</div>*}
			</li>
		</ul>
	{/if}
{/if}
