{*
* 2007-2011 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 6677 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{*
{include file="$tpl_dir./breadcrumb.tpl"}
{include file="$tpl_dir./errors.tpl"}
*}
<div id="categoryContent">
   
	{if isset($category)}
		{if $category->id AND $category->active}
			<h1 id="productsHeading">{strip}
				{$category->name|escape:'htmlall':'UTF-8'}
				{/strip}
			</h1>
	         {if isset($fetch_error) && $fetch_error}
                <p class="warning">Could not bring the products. Please try after some time.</p>
	        {/if}
			{if $products}
				{include file="$tpl_dir./product_list_top.tpl" nbProducts=$nb_products}
				{if $cookie->image_size == 1}
					{include file="$tpl_dir./products-pane.tpl" products=$products}
				{else}
					{include file="$tpl_dir./products-pane-small.tpl" products=$products}
				{/if}
				{include file="$tpl_dir./product_list_bottom.tpl" nbProducts=$nb_products}
					
			{elseif !isset($subcategories)}
				<p class="warning">{l s='There are no products in this category.'}</p>
			{/if}
		{elseif $category->id}
			<p class="warning">{l s='This category is currently unavailable.'}</p>
		{/if}
	{/if}
	
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

