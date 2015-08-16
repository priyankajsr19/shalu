<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Wishlist</legend>
	
	<div class="block-center" id="block-wishlist_items">
		{if $wishlist_items && count($wishlist_items)}
		<table id="order-list" class="table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th class="first_item" style="text-align:left;">Date</th>
					<th class="item" style="text-align:left;">ID</th>
					<th class="item" style="text-align:right;">Code</th>
					<th class="last_item" style="text-align:right;">Name</th>
				</tr>
			</thead>
			<tbody>
			{foreach from=$wishlist_items item=item}
				<tr>
					<td class="history_date bold">{$item.date_add}</td>
					<td class="" style="text-align:left;">{$item.id_product}</td>
					<td class="" style="text-align:right;">{$item.reference}</td>
					<td class="" style="text-align:right;">
                                            <a style="text-decoration:underline;" href="{$item["link"]}" target="__new">{$item.name}</a>
                                        </td>
				</tr>
			{/foreach}
			</tbody>
		</table>
		{else}
			<span>No items in wishlist</span>
		{/if}
	</div>
</fieldset>
