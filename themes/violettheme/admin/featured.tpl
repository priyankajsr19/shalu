<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Curated Products</legend>
	<form action="" method="POST" style="margin-bottom:15px;">
		Product IDs:
		<textarea name="product_ids" rows="4" cols="80">{$curated_product_ids}</textarea>
		<input type="hidden" name="group_id" value="1" />
		<input type="submit" value="Update" />
	</form>
	
	<div class="block-center" id="block-vbpoints">
		{if $curated_products}
		<table id="order-list" class="table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th class="first_item" style="text-align:left;">Product ID</th>
					<th class="item" style="text-align:left;">Product</th>
					<th class="item" style="text-align:left;">Price</th>
				</tr>
			</thead>
			<tbody>
			{foreach from=$curated_products item=product}
				<tr>
					<td class="history_date bold">{$product.id_product}</td>
					<td class="" style="text-align:left;">
                        <a href="?tab=AdminCatalog&id_product={$product.id_product}&updateproduct&token={$productToken}">
                            {$product.name}
                        </a>
                    </td>
                    <td class="history_date bold">{$product.price}</td>
				</tr>
			{/foreach}
			</tbody>
		</table>
		{/if}
	</div>
</fieldset>
{*<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Jewelry Products</legend>
	<form action="" method="POST" style="margin-bottom:15px;">
		Product IDs: <input type="text" name="product_ids" value="{$jewelry_product_ids}" style="width:500px;"/>
		<input type="hidden" name="group_id" value="3" />
		<input type="submit" value="Update" />
	</form>
	
	<div class="block-center" id="block-vbpoints">
		{if $jewelry_products}
		<table id="order-list" class="table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th class="first_item" style="text-align:left;">Product ID</th>
					<th class="item" style="text-align:left;">Product</th>
					<th class="item" style="text-align:left;">Price</th>
				</tr>
			</thead>
			<tbody>
			{foreach from=$jewelry_products item=product}
				<tr>
					<td class="history_date bold">{$product.id_product}</td>
					<td class="" style="text-align:left;">
                        <a href="?tab=AdminCatalog&id_product={$product.id_product}&updateproduct&token={$productToken}">
                            {$product.name}
                        </a>
                    </td>
                    <td class="history_date bold">{$product.price}</td>
				</tr>
			{/foreach}
			</tbody>
		</table>
		{/if}
	</div>
</fieldset>
<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Fragrances Products</legend>
	<form action="" method="POST" style="margin-bottom:15px;">
		Product IDs: <input type="text" name="product_ids" value="{$fragrances_product_ids}" style="width:500px;"/>
		<input type="hidden" name="group_id" value="4" />
		<input type="submit" value="Update" />
	</form>
	
	<div class="block-center" id="block-vbpoints">
		{if $fragrances_products}
		<table id="order-list" class="table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th class="first_item" style="text-align:left;">Product ID</th>
					<th class="item" style="text-align:left;">Product</th>
					<th class="item" style="text-align:left;">Price</th>
				</tr>
			</thead>
			<tbody>
			{foreach from=$fragrances_products item=product}
				<tr>
					<td class="history_date bold">{$product.id_product}</td>
					<td class="" style="text-align:left;">
                        <a href="?tab=AdminCatalog&id_product={$product.id_product}&updateproduct&token={$productToken}">
                            {$product.name}
                        </a>
                    </td>
                    <td class="history_date bold">{$product.price}</td>
				</tr>
			{/foreach}
			</tbody>
		</table>
		{/if}
	</div>
</fieldset>
<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Make Up Products</legend>
	<form action="" method="POST" style="margin-bottom:15px;">
		Product IDs: <input type="text" name="product_ids" value="{$makeup_product_ids}" style="width:500px;"/>
		<input type="hidden" name="group_id" value="5" />
		<input type="submit" value="Update" />
	</form>
	
	<div class="block-center" id="block-vbpoints">
		{if $makeup_products}
		<table id="order-list" class="table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th class="first_item" style="text-align:left;">Product ID</th>
					<th class="item" style="text-align:left;">Product</th>
					<th class="item" style="text-align:left;">Price</th>
				</tr>
			</thead>
			<tbody>
			{foreach from=$makeup_products item=product}
				<tr>
					<td class="history_date bold">{$product.id_product}</td>
					<td class="" style="text-align:left;">
                        <a href="?tab=AdminCatalog&id_product={$product.id_product}&updateproduct&token={$productToken}">
                            {$product.name}
                        </a>
                    </td>
                    <td class="history_date bold">{$product.price}</td>
				</tr>
			{/foreach}
			</tbody>
		</table>
		{/if}
	</div>
</fieldset>
<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />New Products</legend>
	<form action="" method="POST" style="margin-bottom:15px;">
		Product IDs: <input type="text" name="product_ids" value="{$new_product_ids}" style="width:500px;"/>
		<input type="hidden" name="group_id" value="6" />
		<input type="submit" value="Update" />
	</form>
	
	<div class="block-center" id="block-vbpoints">
		{if $new_products}
		<table id="order-list" class="table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th class="first_item" style="text-align:left;">Product ID</th>
					<th class="item" style="text-align:left;">Product</th>
					<th class="item" style="text-align:left;">Price</th>
				</tr>
			</thead>
			<tbody>
			{foreach from=$new_products item=product}
				<tr>
					<td class="history_date bold">{$product.id_product}</td>
					<td class="" style="text-align:left;">
                        <a href="?tab=AdminCatalog&id_product={$product.id_product}&updateproduct&token={$productToken}">
                            {$product.name}
                        </a>
                    </td>
                    <td class="history_date bold">{$product.price}</td>
				</tr>
			{/foreach}
			</tbody>
		</table>
		{/if}
	</div>
</fieldset>
<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Featured Products</legend>
	<form action="" method="POST" style="margin-bottom:15px;">
		Product IDs: <input type="text" name="product_ids" value="{$home_product_ids}" style="width:500px;"/>
		<input type="hidden" name="group_id" value="1" />
		<input type="submit" value="Update" />
	</form>
	
	<div class="block-center" id="block-vbpoints">
		{if $home_products}
		<table id="order-list" class="table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th class="first_item" style="text-align:left;">Product ID</th>
					<th class="item" style="text-align:left;">Product</th>
					<th class="item" style="text-align:left;">Price</th>
				</tr>
			</thead>
			<tbody>
			{foreach from=$home_products item=product}
				<tr>
					<td class="history_date bold">{$product.id_product}</td>
					<td class="" style="text-align:left;">
                        <a href="?tab=AdminCatalog&id_product={$product.id_product}&updateproduct&token={$productToken}">
                            {$product.name}
                        </a>
                    </td>
                    <td class="history_date bold">{$product.price}</td>
				</tr>
			{/foreach}
			</tbody>
		</table>
		{/if}
	</div>
</fieldset>*}