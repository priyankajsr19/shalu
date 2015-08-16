{*
{if isset($bags_products) && $bags_products|@count > 0}
<div id="bags_pane" class="product_group_panes" style="padding-top:10px">
    <div style="float:left;">
	    <span id="bags_head" class="home_pane_title"></span>
	    <span class="panes_bar"></span>
    </div>
    <span class="home_pane_more"><a href="/15481-bags-wallets">See More</a></span>
    {include file="$tpl_dir./products_pane_home.tpl" products=$bags_products}
</div>
{/if}
{if isset($jewelry_products) && $jewelry_products|@count > 0}
<div id="jewelry_pane" class="product_group_panes">
    <div style="float:left;">
	    <span id="jewelry_head" class="home_pane_title"></span>
	    <span class="panes_bar"></span>
	</div>
	<span class="home_pane_more"><a href="/4989-fashion-jewellery">See More</a></span>
    {include file="$tpl_dir./products_pane_home.tpl" products=$jewelry_products}
</div>
{/if}
{if isset($fragrances_products) && $fragrances_products|@count > 0}
<div id="fragrances_pane" class="product_group_panes">
	<div style="float:left;">
	    <span id="fragrances_head" class="home_pane_title"></span>
	    <span class="panes_bar"></span>
	</div>
	<span class="home_pane_more"><a href="/2-perfumes-deos">See More</a></span>
    {include file="$tpl_dir./products_pane_home.tpl" products=$fragrances_products}
</div>
{/if}
{if isset($makeup_products) && $makeup_products|@count > 0}
<div id="makeup_pane" class="product_group_panes">
    <div style="float:left;">
	    <span id="makeup_head" class="home_pane_title"></span>
	    <span class="panes_bar"></span>
	</div>
	<span class="home_pane_more"><a href="/9-makeup">See More</a></span>
    {include file="$tpl_dir./products_pane_home.tpl" products=$makeup_products}
</div>
{/if}
{if isset($new_products) && $new_products|@count > 0}
<div id="new_pane" class="product_group_panes">
    <div style="float:left;">
	    <span id="new_head" class="home_pane_title"></span>
	    <span class="panes_bar"></span>
	</div>
	<span class="home_pane_more"><a href="/new-products.php?latest=1">See More</a></span>
    {include file="$tpl_dir./products_pane_home.tpl" products=$new_products}
</div>
{/if}
*}