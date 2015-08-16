<html>
<head>
</head>
<body>
	{if isset($error_uploading)}
		<p style="padding:20px;font-size:15px;color:red">Error uplaoding the file.</p>
	{/if}
	
	{if isset($error_reading)}
		<p style="padding:20px;font-size:15px;color:red">Error reading the file.</p>
	{/if}
	
	{if isset($non_empty_product_id)}
		<p style="padding:20px;font-size:15px;color:red">Error: Product ID found in import file. Import aborted.</p>
	{/if}
	
	{if isset($error)}
		<p style="padding:20px;font-size:15px;color:red">{$error}</p>
	{/if}
	{if isset($product_styles_mapped)}
		<p style="padding:20px;font-size:15px;color:green">{$product_styles_mapped}</p>
	{/if}
	
	{if isset($products_affected)}
		{if isset($is_update) && $is_update}
			<p style="padding:20px;font-size:15px;color:green">Products Updated: {$products_affected|@count}</p>
		{else}
			<p style="padding:20px;font-size:15px;color:green">Products Imported: {$products_affected|@count}</p>
		{/if}
	{/if}
	
	{if isset($updated_ranks)}
	    <p style="padding:20px;font-size:15px;color:green">Products Ranked: {$updated_ranks}</p>
	{/if}
	
	{if isset($updated_oos)}
	    <p style="padding:20px;font-size:15px;color:green">Products Set OOS: {$updated_oos}</p>
	{/if}

	{if isset($updated_b1g1_tags)}
	    <p style="padding:20px;font-size:15px;color:green">Products Set Tags: {$updated_b1g1_tags}</p>
	{/if}

	{if isset($deleted_b1g1_tags)}
	    <p style="padding:20px;font-size:15px;color:green">Remved B1G1 Tags: {$deleted_b1g1_tags}</p>
	{/if}
		
		
	<div style="margin:20 auto;">
		<fieldset style="margin-bottom:10px;">
			<legend><img src="../img/admin/tab-tools.gif" />New Product Import</legend>
			<form enctype="multipart/form-data" action="{$currentIndex}&token={$token}" method="post" id="productImport" style="display:width:520px;margin-left:200px">
				<input type="hidden" name="product_upload" value="1" />
				<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
				Select products file: <input name="products_file" type="file" /><br />
				<input type="submit" value="Upload" />
			</form>
			
			
			
			{if isset($current_file) && !isset($update)}
				<ul>
					<li>product_name: {$product_name}</li>
					<li>fabric: {$fabric}</li>
					<li>color: {$color}</li>
					<li>mrp: {$mrp}</li>
					<li>supplier_code: {$supplier_code}</li>
					<li>size: {$size}</li>
					<li>length: {$length}</li>
					<li>width: {$width}</li>
					<li>blouse_length: {$blouse_length}</li>
					<li>garment_type: {$garment_type}</li>
					<li>work_type: {$work_type}</li>
					<li>weight: {$weight}</li>
					<li>description: {$description}</li>
					<li>style_tips: {$style_tips}</li>
					<li>other_info: {$other_info}</li>
					<li>wash_care: {$wash_care}</li>
					<li>shipping_estimate: {$shipping_estimate}</li>
					<li>supplier_price: {$supplier_price}</li>
					<li>manufacturer: {$manufacturer}</li>
					<li>categories: {$categories}</li>
					<li>tax_rule: {$tax_rule}</li>
					<li>quantity: {$quantity}</li>
					<li>active: {$active}</li>
					<li>discount: {$discount}</li>
					<li>tags: {$tags}</li>
					<li>Kameez style: {$kameez_style}</li>
					<li>Salwar style: {$salwar_style}</li>
					<li>Sleeves: {$sleeves}</li>
					<li>Customizable?: {$customizable}</li>
					<li>Generic Color: {$generic_color}</li>
					<li>Skirt Length: {$skirt_length}</li>
					<li>Dupatta Length: {$dupatta_length}</li>
					<li>Style tips: {$style_tips}</li>
                                        <li>As Shown:{$as_shown}</li>
				</ul>
				<form enctype="multipart/form-data" action="{$currentIndex}&token={$token}" method="post" id="productImport" style="display:width:520px;margin-left:200px">
					<input type="hidden" name="confirm_import" value="1" />
					<input type="hidden" name="current_file" value="{$current_file}" />
					<input type="submit" value="Confirm Import" />
				</form>
			{/if}
		</fieldset>
	</div>
	
	<div style="margin:20 auto;">
		<fieldset style="margin-bottom:10px;">
			<legend><img src="../img/admin/tab-tools.gif" />Product Updates</legend>
			<form enctype="multipart/form-data" action="{$currentIndex}&token={$token}" method="post" id="productImport" style="display:width:520px;margin-left:200px">
				<input type="hidden" name="product_update" value="1" />
				<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
				Select products file: <input name="products_file" type="file" /><br />
				<input type="submit" value="Upload" />
			</form>
			
			{if isset($current_file) && isset($update)}
				<ul>
					<li>product_name: {$product_name}</li>
					<li>fabric: {$fabric}</li>
					<li>color: {$color}</li>
					<li>mrp: {$mrp}</li>
					<li>supplier_code: {$supplier_code}</li>
					<li>size: {$size}</li>
					<li>length: {$length}</li>
					<li>width: {$width}</li>
					<li>blouse_length: {$blouse_length}</li>
					<li>garment_type: {$garment_type}</li>
					<li>work_type: {$work_type}</li>
					<li>weight: {$weight}</li>
					<li>description: {$description}</li>
					<li>style_tips: {$style_tips}</li>
					<li>other_info: {$other_info}</li>
					<li>wash_care: {$wash_care}</li>
					<li>shipping_estimate: {$shipping_estimate}</li>
					<li>supplier_price: {$supplier_price}</li>
					<li>manufacturer: {$manufacturer}</li>
					<li>categories: {$categories}</li>
					<li>tax_rule: {$tax_rule}</li>
					<li>quantity: {$quantity}</li>
					<li>active: {$active}</li>
					<li>discount: {$discount}</li>
					<li>tags: {$tags}</li>
					<li>Kameez style: {$kameez_style}</li>
					<li>Salwar style: {$salwar_style}</li>
					<li>Sleeves: {$sleeves}</li>
					<li>Customizable?: {$customizable}</li>
					<li>Generic Color: {$generic_color}</li>
					<li>Skirt Length: {$skirt_length}</li>
					<li>Dupatta Length: {$dupatta_length}</li>
					<li>Style tips: {$style_tips}</li>
				</ul>
				<form enctype="multipart/form-data" action="{$currentIndex}&token={$token}" method="post" id="productImport" style="display:width:520px;margin-left:200px">
					<input type="hidden" name="confirm_update" value="1" />
					<input type="hidden" name="current_file" value="{$current_file}" />
					<br />
					<input type="checkbox" name="overwrite_imgs" id="overwrite_imgs" style="display:inline-block;float:left"/>
					<label for="overwrite_imgs" style="display:inline-block;padding-left:10px; text-align:left">Over-write images</label>
					<br />
					<input type="submit" value="Confirm Update" />
				</form>
			{/if}
		</fieldset>
	</div>
	
	<div style="margin:20 auto;">
		<fieldset style="margin-bottom:10px;">
			<legend><img src="../img/admin/tab-tools.gif" />Related Products</legend>
			<form enctype="multipart/form-data" action="{$currentIndex}&token={$token}" method="post" id="productImport" style="display:width:520px;margin-left:200px">
				<input type="hidden" name="related_product_update" value="1" />
				<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
				Select related products file: <input name="related_products_file" type="file" /><br />
				<input type="submit" value="Upload" />
			</form>
		</fieldset>
	</div>
	
    <div style="margin:20 auto;">
		<fieldset style="margin-bottom:10px;">
			<legend><img src="../img/admin/tab-tools.gif" />Product Style Mapping</legend>
			<form enctype="multipart/form-data" action="{$currentIndex}&token={$token}" method="post" id="productImport" style="display:width:520px;margin-left:200px">
				<div style="font-weight:bold;color:#F22">Style IDs mentioned in this upload overrides all the previous styles of the product</div>
				<input type="hidden" name="product_style_mapping" value="1" />
				<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
				Select Product Style Mapping file: <input name="product_style_mapping_file" type="file" /><br />
                Select Product Type: 
                <select name="product_type">
                    <option value="rts">Ready To Stich(SKD)</option>
                </select> </br/>
				<input type="submit" value="Upload" />
			</form>
		</fieldset>
	</div>
	
	
	<div style="margin:20 auto;">
		<fieldset style="margin-bottom:10px;">
			<legend><img src="../img/admin/tab-tools.gif" />Update Search Ranks</legend>
			<p style="color:red">Please set score as 7 if a product has to be excluded fron the search results</p>
			<form enctype="multipart/form-data" action="{$currentIndex}&token={$token}" method="post" id="productImport" style="display:width:520px;margin-left:200px">
				<input type="hidden" name="updateSearchRanks" value="1" />
				<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
				Select ranking file: <input name="ranking_products_file" type="file" /><br />
				<input type="submit" value="Upload" />
			</form>
		</fieldset>
	</div>
	
	<div style="margin:20 auto;">
		<fieldset style="margin-bottom:10px;">
			<legend><img src="../img/admin/tab-tools.gif" />Set products OOS</legend>
			<form enctype="multipart/form-data" action="{$currentIndex}&token={$token}" method="post" id="productImport" style="display:width:520px;margin-left:200px">
				<input type="hidden" name="setOOS" value="1" />
				<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
				Select OOS products file: <input name="oos_products_file" type="file" /><br />
				<input type="submit" value="Upload" />
			</form>
		</fieldset>
	</div>

	<div style="margin:20 auto;">
		<fieldset style="margin-bottom:10px;">
			<legend><img src="../img/admin/tab-tools.gif" />Set B1G1 Tag</legend>
			<form enctype="multipart/form-data" action="{$currentIndex}&token={$token}" method="post" id="productImport" style="display:width:520px;margin-left:200px">
				<input type="hidden" name="setB1G1Tag" value="1" />
				Select Products Tags file: <input name="b1g1_tag_file" type="file" /><br />
				<input type="submit" value="Upload" />
			</form>
		</fieldset>

		<fieldset style="margin-bottom:10px;">
			<legend><img src="../img/admin/tab-tools.gif" />Delete B1G1 Tag</legend>
			<form enctype="multipart/form-data" action="{$currentIndex}&token={$token}" method="post" id="productImport" style="display:width:520px;margin-left:200px">
				<input type="hidden" name="removeB1G1Tag" value="1" />
				Select Products Tags file: <input name="b1g1_tag_file" type="file" /><br />
                                <input type="submit" value="Upload" />
				<input type="submit" value="Delete B1G1 Tags" />
			</form>
		</fieldset>
	</div>
	
	<div style="margin:20 auto;">
		<fieldset style="margin-bottom:10px;">
			<legend><img src="../img/admin/tab-tools.gif" />Product Downloads</legend>
                        <form method="post" action="OMS.php?getProductIDS=1">
				<div><label>Min Product ID:</label><input type="text" value="1" name="min"/></div>
				<div><label>Max Product ID:</label><input type="text" value="13000" name="max"/></div>
				<button>DownloadProductIDs</button>
			</form>
		</fieldset>
	</div>
</body>
</html>
