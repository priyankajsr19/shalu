<?php /* Smarty version Smarty-3.0.7, created on 2015-08-05 19:05:00
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/admin/product_import.tpl" */ ?>
<?php /*%%SmartyHeaderCode:173873827155c211045cfd82-46901415%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '522c623f971353e16d0187456bc390d3d69a66e9' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/admin/product_import.tpl',
      1 => 1438683395,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '173873827155c211045cfd82-46901415',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>
<head>
</head>
<body>
	<?php if (isset($_smarty_tpl->getVariable('error_uploading',null,true,false)->value)){?>
		<p style="padding:20px;font-size:15px;color:red">Error uplaoding the file.</p>
	<?php }?>
	
	<?php if (isset($_smarty_tpl->getVariable('error_reading',null,true,false)->value)){?>
		<p style="padding:20px;font-size:15px;color:red">Error reading the file.</p>
	<?php }?>
	
	<?php if (isset($_smarty_tpl->getVariable('non_empty_product_id',null,true,false)->value)){?>
		<p style="padding:20px;font-size:15px;color:red">Error: Product ID found in import file. Import aborted.</p>
	<?php }?>
	
	<?php if (isset($_smarty_tpl->getVariable('error',null,true,false)->value)){?>
		<p style="padding:20px;font-size:15px;color:red"><?php echo $_smarty_tpl->getVariable('error')->value;?>
</p>
	<?php }?>
	<?php if (isset($_smarty_tpl->getVariable('product_styles_mapped',null,true,false)->value)){?>
		<p style="padding:20px;font-size:15px;color:green"><?php echo $_smarty_tpl->getVariable('product_styles_mapped')->value;?>
</p>
	<?php }?>
	
	<?php if (isset($_smarty_tpl->getVariable('products_affected',null,true,false)->value)){?>
		<?php if (isset($_smarty_tpl->getVariable('is_update',null,true,false)->value)&&$_smarty_tpl->getVariable('is_update')->value){?>
			<p style="padding:20px;font-size:15px;color:green">Products Updated: <?php echo count($_smarty_tpl->getVariable('products_affected')->value);?>
</p>
		<?php }else{ ?>
			<p style="padding:20px;font-size:15px;color:green">Products Imported: <?php echo count($_smarty_tpl->getVariable('products_affected')->value);?>
</p>
		<?php }?>
	<?php }?>
	
	<?php if (isset($_smarty_tpl->getVariable('updated_ranks',null,true,false)->value)){?>
	    <p style="padding:20px;font-size:15px;color:green">Products Ranked: <?php echo $_smarty_tpl->getVariable('updated_ranks')->value;?>
</p>
	<?php }?>
	
	<?php if (isset($_smarty_tpl->getVariable('updated_oos',null,true,false)->value)){?>
	    <p style="padding:20px;font-size:15px;color:green">Products Set OOS: <?php echo $_smarty_tpl->getVariable('updated_oos')->value;?>
</p>
	<?php }?>

	<?php if (isset($_smarty_tpl->getVariable('updated_b1g1_tags',null,true,false)->value)){?>
	    <p style="padding:20px;font-size:15px;color:green">Products Set Tags: <?php echo $_smarty_tpl->getVariable('updated_b1g1_tags')->value;?>
</p>
	<?php }?>

	<?php if (isset($_smarty_tpl->getVariable('deleted_b1g1_tags',null,true,false)->value)){?>
	    <p style="padding:20px;font-size:15px;color:green">Remved B1G1 Tags: <?php echo $_smarty_tpl->getVariable('deleted_b1g1_tags')->value;?>
</p>
	<?php }?>
		
		
	<div style="margin:20 auto;">
		<fieldset style="margin-bottom:10px;">
			<legend><img src="../img/admin/tab-tools.gif" />New Product Import</legend>
			<form enctype="multipart/form-data" action="<?php echo $_smarty_tpl->getVariable('currentIndex')->value;?>
&token=<?php echo $_smarty_tpl->getVariable('token')->value;?>
" method="post" id="productImport" style="display:width:520px;margin-left:200px">
				<input type="hidden" name="product_upload" value="1" />
				<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
				Select products file: <input name="products_file" type="file" /><br />
				<input type="submit" value="Upload" />
			</form>
			
			
			
			<?php if (isset($_smarty_tpl->getVariable('current_file',null,true,false)->value)&&!isset($_smarty_tpl->getVariable('update',null,true,false)->value)){?>
				<ul>
					<li>product_name: <?php echo $_smarty_tpl->getVariable('product_name')->value;?>
</li>
					<li>fabric: <?php echo $_smarty_tpl->getVariable('fabric')->value;?>
</li>
					<li>color: <?php echo $_smarty_tpl->getVariable('color')->value;?>
</li>
					<li>mrp: <?php echo $_smarty_tpl->getVariable('mrp')->value;?>
</li>
					<li>supplier_code: <?php echo $_smarty_tpl->getVariable('supplier_code')->value;?>
</li>
					<li>size: <?php echo $_smarty_tpl->getVariable('size')->value;?>
</li>
					<li>length: <?php echo $_smarty_tpl->getVariable('length')->value;?>
</li>
					<li>width: <?php echo $_smarty_tpl->getVariable('width')->value;?>
</li>
					<li>blouse_length: <?php echo $_smarty_tpl->getVariable('blouse_length')->value;?>
</li>
					<li>garment_type: <?php echo $_smarty_tpl->getVariable('garment_type')->value;?>
</li>
					<li>work_type: <?php echo $_smarty_tpl->getVariable('work_type')->value;?>
</li>
					<li>weight: <?php echo $_smarty_tpl->getVariable('weight')->value;?>
</li>
					<li>description: <?php echo $_smarty_tpl->getVariable('description')->value;?>
</li>
					<li>style_tips: <?php echo $_smarty_tpl->getVariable('style_tips')->value;?>
</li>
					<li>other_info: <?php echo $_smarty_tpl->getVariable('other_info')->value;?>
</li>
					<li>wash_care: <?php echo $_smarty_tpl->getVariable('wash_care')->value;?>
</li>
					<li>shipping_estimate: <?php echo $_smarty_tpl->getVariable('shipping_estimate')->value;?>
</li>
					<li>supplier_price: <?php echo $_smarty_tpl->getVariable('supplier_price')->value;?>
</li>
					<li>manufacturer: <?php echo $_smarty_tpl->getVariable('manufacturer')->value;?>
</li>
					<li>categories: <?php echo $_smarty_tpl->getVariable('categories')->value;?>
</li>
					<li>tax_rule: <?php echo $_smarty_tpl->getVariable('tax_rule')->value;?>
</li>
					<li>quantity: <?php echo $_smarty_tpl->getVariable('quantity')->value;?>
</li>
					<li>active: <?php echo $_smarty_tpl->getVariable('active')->value;?>
</li>
					<li>discount: <?php echo $_smarty_tpl->getVariable('discount')->value;?>
</li>
					<li>tags: <?php echo $_smarty_tpl->getVariable('tags')->value;?>
</li>
					<li>Kameez style: <?php echo $_smarty_tpl->getVariable('kameez_style')->value;?>
</li>
					<li>Salwar style: <?php echo $_smarty_tpl->getVariable('salwar_style')->value;?>
</li>
					<li>Sleeves: <?php echo $_smarty_tpl->getVariable('sleeves')->value;?>
</li>
					<li>Customizable?: <?php echo $_smarty_tpl->getVariable('customizable')->value;?>
</li>
					<li>Generic Color: <?php echo $_smarty_tpl->getVariable('generic_color')->value;?>
</li>
					<li>Skirt Length: <?php echo $_smarty_tpl->getVariable('skirt_length')->value;?>
</li>
					<li>Dupatta Length: <?php echo $_smarty_tpl->getVariable('dupatta_length')->value;?>
</li>
					<li>Style tips: <?php echo $_smarty_tpl->getVariable('style_tips')->value;?>
</li>
                                        <li>As Shown:<?php echo $_smarty_tpl->getVariable('as_shown')->value;?>
</li>
				</ul>
				<form enctype="multipart/form-data" action="<?php echo $_smarty_tpl->getVariable('currentIndex')->value;?>
&token=<?php echo $_smarty_tpl->getVariable('token')->value;?>
" method="post" id="productImport" style="display:width:520px;margin-left:200px">
					<input type="hidden" name="confirm_import" value="1" />
					<input type="hidden" name="current_file" value="<?php echo $_smarty_tpl->getVariable('current_file')->value;?>
" />
					<input type="submit" value="Confirm Import" />
				</form>
			<?php }?>
		</fieldset>
	</div>
	
	<div style="margin:20 auto;">
		<fieldset style="margin-bottom:10px;">
			<legend><img src="../img/admin/tab-tools.gif" />Product Updates</legend>
			<form enctype="multipart/form-data" action="<?php echo $_smarty_tpl->getVariable('currentIndex')->value;?>
&token=<?php echo $_smarty_tpl->getVariable('token')->value;?>
" method="post" id="productImport" style="display:width:520px;margin-left:200px">
				<input type="hidden" name="product_update" value="1" />
				<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
				Select products file: <input name="products_file" type="file" /><br />
				<input type="submit" value="Upload" />
			</form>
			
			<?php if (isset($_smarty_tpl->getVariable('current_file',null,true,false)->value)&&isset($_smarty_tpl->getVariable('update',null,true,false)->value)){?>
				<ul>
					<li>product_name: <?php echo $_smarty_tpl->getVariable('product_name')->value;?>
</li>
					<li>fabric: <?php echo $_smarty_tpl->getVariable('fabric')->value;?>
</li>
					<li>color: <?php echo $_smarty_tpl->getVariable('color')->value;?>
</li>
					<li>mrp: <?php echo $_smarty_tpl->getVariable('mrp')->value;?>
</li>
					<li>supplier_code: <?php echo $_smarty_tpl->getVariable('supplier_code')->value;?>
</li>
					<li>size: <?php echo $_smarty_tpl->getVariable('size')->value;?>
</li>
					<li>length: <?php echo $_smarty_tpl->getVariable('length')->value;?>
</li>
					<li>width: <?php echo $_smarty_tpl->getVariable('width')->value;?>
</li>
					<li>blouse_length: <?php echo $_smarty_tpl->getVariable('blouse_length')->value;?>
</li>
					<li>garment_type: <?php echo $_smarty_tpl->getVariable('garment_type')->value;?>
</li>
					<li>work_type: <?php echo $_smarty_tpl->getVariable('work_type')->value;?>
</li>
					<li>weight: <?php echo $_smarty_tpl->getVariable('weight')->value;?>
</li>
					<li>description: <?php echo $_smarty_tpl->getVariable('description')->value;?>
</li>
					<li>style_tips: <?php echo $_smarty_tpl->getVariable('style_tips')->value;?>
</li>
					<li>other_info: <?php echo $_smarty_tpl->getVariable('other_info')->value;?>
</li>
					<li>wash_care: <?php echo $_smarty_tpl->getVariable('wash_care')->value;?>
</li>
					<li>shipping_estimate: <?php echo $_smarty_tpl->getVariable('shipping_estimate')->value;?>
</li>
					<li>supplier_price: <?php echo $_smarty_tpl->getVariable('supplier_price')->value;?>
</li>
					<li>manufacturer: <?php echo $_smarty_tpl->getVariable('manufacturer')->value;?>
</li>
					<li>categories: <?php echo $_smarty_tpl->getVariable('categories')->value;?>
</li>
					<li>tax_rule: <?php echo $_smarty_tpl->getVariable('tax_rule')->value;?>
</li>
					<li>quantity: <?php echo $_smarty_tpl->getVariable('quantity')->value;?>
</li>
					<li>active: <?php echo $_smarty_tpl->getVariable('active')->value;?>
</li>
					<li>discount: <?php echo $_smarty_tpl->getVariable('discount')->value;?>
</li>
					<li>tags: <?php echo $_smarty_tpl->getVariable('tags')->value;?>
</li>
					<li>Kameez style: <?php echo $_smarty_tpl->getVariable('kameez_style')->value;?>
</li>
					<li>Salwar style: <?php echo $_smarty_tpl->getVariable('salwar_style')->value;?>
</li>
					<li>Sleeves: <?php echo $_smarty_tpl->getVariable('sleeves')->value;?>
</li>
					<li>Customizable?: <?php echo $_smarty_tpl->getVariable('customizable')->value;?>
</li>
					<li>Generic Color: <?php echo $_smarty_tpl->getVariable('generic_color')->value;?>
</li>
					<li>Skirt Length: <?php echo $_smarty_tpl->getVariable('skirt_length')->value;?>
</li>
					<li>Dupatta Length: <?php echo $_smarty_tpl->getVariable('dupatta_length')->value;?>
</li>
					<li>Style tips: <?php echo $_smarty_tpl->getVariable('style_tips')->value;?>
</li>
				</ul>
				<form enctype="multipart/form-data" action="<?php echo $_smarty_tpl->getVariable('currentIndex')->value;?>
&token=<?php echo $_smarty_tpl->getVariable('token')->value;?>
" method="post" id="productImport" style="display:width:520px;margin-left:200px">
					<input type="hidden" name="confirm_update" value="1" />
					<input type="hidden" name="current_file" value="<?php echo $_smarty_tpl->getVariable('current_file')->value;?>
" />
					<br />
					<input type="checkbox" name="overwrite_imgs" id="overwrite_imgs" style="display:inline-block;float:left"/>
					<label for="overwrite_imgs" style="display:inline-block;padding-left:10px; text-align:left">Over-write images</label>
					<br />
					<input type="submit" value="Confirm Update" />
				</form>
			<?php }?>
		</fieldset>
	</div>
	
	<div style="margin:20 auto;">
		<fieldset style="margin-bottom:10px;">
			<legend><img src="../img/admin/tab-tools.gif" />Related Products</legend>
			<form enctype="multipart/form-data" action="<?php echo $_smarty_tpl->getVariable('currentIndex')->value;?>
&token=<?php echo $_smarty_tpl->getVariable('token')->value;?>
" method="post" id="productImport" style="display:width:520px;margin-left:200px">
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
			<form enctype="multipart/form-data" action="<?php echo $_smarty_tpl->getVariable('currentIndex')->value;?>
&token=<?php echo $_smarty_tpl->getVariable('token')->value;?>
" method="post" id="productImport" style="display:width:520px;margin-left:200px">
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
			<form enctype="multipart/form-data" action="<?php echo $_smarty_tpl->getVariable('currentIndex')->value;?>
&token=<?php echo $_smarty_tpl->getVariable('token')->value;?>
" method="post" id="productImport" style="display:width:520px;margin-left:200px">
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
			<form enctype="multipart/form-data" action="<?php echo $_smarty_tpl->getVariable('currentIndex')->value;?>
&token=<?php echo $_smarty_tpl->getVariable('token')->value;?>
" method="post" id="productImport" style="display:width:520px;margin-left:200px">
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
			<form enctype="multipart/form-data" action="<?php echo $_smarty_tpl->getVariable('currentIndex')->value;?>
&token=<?php echo $_smarty_tpl->getVariable('token')->value;?>
" method="post" id="productImport" style="display:width:520px;margin-left:200px">
				<input type="hidden" name="setB1G1Tag" value="1" />
				Select Products Tags file: <input name="b1g1_tag_file" type="file" /><br />
				<input type="submit" value="Upload" />
			</form>
		</fieldset>

		<fieldset style="margin-bottom:10px;">
			<legend><img src="../img/admin/tab-tools.gif" />Delete B1G1 Tag</legend>
			<form enctype="multipart/form-data" action="<?php echo $_smarty_tpl->getVariable('currentIndex')->value;?>
&token=<?php echo $_smarty_tpl->getVariable('token')->value;?>
" method="post" id="productImport" style="display:width:520px;margin-left:200px">
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
