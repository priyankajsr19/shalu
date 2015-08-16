<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 15:28:25
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/admin/violettools.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13653372495562f241ae1fd1-73680265%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6268e5fef58eebb09594e418c20e5fb738edc982' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/admin/violettools.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13653372495562f241ae1fd1-73680265',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />VioletBag Operations</legend>
	<p>
		<ul STYLE="list-style-type: square">
			<li style="padding:5px"><a href='OMS.php?getAddresses=1'>Download Addresses (Ready for ship orders)</a></li>
			<li style="padding:5px"><a href='OMS.php?getAddressesQuantium=1'>Download Quantium Addresses (Ready for ship orders)</a></li>
			<li style="padding:5px"><a href='deliverystats.php'>Order delivery stats</a></li>
		</ul>
	</p>
</fieldset>

<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Products List</legend>
	<p>
		<ul STYLE="list-style-type: square">
            
			<li style="padding:5px">
                <form action="OMS.php" method="get">
                    <p>Leave the date fields blank for full catalog download</p>
                    From Date : <input type="text" name="datepickerFrom" id="datepickerFrom" value=""/>
                    To Date : <input type="text" name="datepickerTo" id="datepickerTo" value=""/>
                    <input type="hidden" value="1" name="getAmazonList"/>
                    <br/>
                    <br/>
                    Active/InActive:<select name='onlyActive'>
                        <option value="1">All</option>
                        <option value="2" selected>Active</option>
                        <option value="3">Inactive</option>
                    </select>
                    <br/>
                    <br/>
                    Select Set:<select name="set">
                        <option value="1">First 1/3 of products</option>
                        <option value="2">Second 1/3 of products</option>
                        <option value="3">Last 1/3 of products</option>
                    </select>
                    <br/>
                    <br/>
                    <input type="submit" value="Download AMAZON Products List"/>
                </form>
            </li>
			
			<li style="padding:5px"><a href='OMS.php?getPartnerProducts=1'>Download Partner Products List</a></li>
		</ul>
	</p>
</fieldset>


	<script type="text/javascript" src="../js/jquery/jquery-ui-1.8.10.custom.min.js"></script>
	<script type="text/javascript">
		var dateObj = new Date();
		var hours = dateObj.getHours();
		var mins = dateObj.getMinutes();
		var secs = dateObj.getSeconds();
		if (hours < 10) { hours = "0" + hours; }
		if (mins < 10) { mins = "0" + mins; }
		if (secs < 10) { secs = "0" + secs; }
		var time = " "+hours+":"+mins+":"+secs;

		$(function() {
			$("#orders_from").datepicker({
				prevText:"",
				nextText:"",
				dateFormat:"yy-mm-dd"});
		});

		$(function() {
			$("#orders_to").datepicker({
				prevText:"",
				nextText:"",
				dateFormat:"yy-mm-dd"});
		});

		$(function() {
			$("#sales_orders_from").datepicker({
				prevText:"",
				nextText:"",
				dateFormat:"yy-mm-dd"});
		});

		$(function() {
			$("#sales_orders_to").datepicker({
				prevText:"",
				nextText:"",
				dateFormat:"yy-mm-dd"});
		});
	</script>


<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Orders list</legend>
	<p>
		<form action="OMS.php?getProducts=1" method="POST">
			From: <input type="text" id="orders_from" name="orders_from" value=""/>
			To: <input type="text" id="orders_to" name="orders_to" value=""/><br />
			Status: 
			<ul>
			<?php  $_smarty_tpl->tpl_vars['status'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('statuses')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['status']->key => $_smarty_tpl->tpl_vars['status']->value){
?>
			<?php if ($_smarty_tpl->getVariable('statusStats')->value[$_smarty_tpl->tpl_vars['status']->value['id_order_state']]>0){?>
				<li style="list-style: none;">
					<input type="checkbox" name="id_order_state[]" value="<?php echo $_smarty_tpl->tpl_vars['status']->value['id_order_state'];?>
" id="id_order_state_<?php echo $_smarty_tpl->tpl_vars['status']->value['id_order_state'];?>
">
					<label for="id_order_state_<?php echo $_smarty_tpl->tpl_vars['status']->value['id_order_state'];?>
" style="float:none; color:#000; padding:0;text-align:left;width:100%;">
								<?php echo $_smarty_tpl->tpl_vars['status']->value['name'];?>
 
								(
									<?php if (isset($_smarty_tpl->getVariable('statusStats',null,true,false)->value[$_smarty_tpl->tpl_vars['status']->value['id_order_state']])&&$_smarty_tpl->getVariable('statusStats')->value[$_smarty_tpl->tpl_vars['status']->value['id_order_state']]){?>
										<?php echo $_smarty_tpl->getVariable('statusStats')->value[$_smarty_tpl->tpl_vars['status']->value['id_order_state']];?>

									<?php }else{ ?>
										0
									<?php }?>
								)
					</label>
				</li>
			<?php }?>
			<?php }} ?>
			</ul>
			<input type="submit" value="Download" />
		</form>
	</p>
</fieldset>

<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Sales Data</legend>
	<p>
		<form action="OMS.php?getSalesData=1" method="POST">
			From: <input type="text" id="sales_orders_from" name="orders_from" value=""/>
			To: <input type="text" id="sales_orders_to" name="orders_to" value=""/><br /><br />
			<input type="submit" value="download-products-invoice" name="download-products-invoice"/>
			<input type="submit" value="download-products-delivery" name="download-products-delivery"/>
			<input type="submit" value="download-orders-invoice" name="download-orders-invoice"/>
			<input type="submit" value="download-orders-delivery" name="download-orders-delivery"/>
		</form>
	</p>
</fieldset>

<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Upload shipped orders</legend>
	<p>
		<span style="color:red">Please never upload a file twice, it will send the mails again.</span>
		<form enctype="multipart/form-data" action="OMS.php?markShipped=1" method="POST">
			<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
			Shipped orders file: <input name="orders" type="file" /><br />
			<input type="submit" value="Upload File to mark shipped" />
		</form>
	</p>
</fieldset>

<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Update Product Prices</legend>
	<p>
		<span style="color:red">format: ProductID,NewPrice</span>
		<form enctype="multipart/form-data" action="OMS.php?updatePrice=1" method="POST">
			<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
			Product Prices: <input name="products" type="file" /><br />
			<input type="submit" value="Upload File to update prices" />
		</form>
	</p>
</fieldset>

<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Upload delivered orders</legend>
	<p>
		<span>Upload files with only order IDs.</span>
		<form enctype="multipart/form-data" action="OMS.php?markDelivered=1" method="POST">
			<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
			Shipped orders file: <input name="orders" type="file" /><br />
			<input type="submit" value="Upload File to mark delivered" />
		</form>
	</p>
</fieldset>

<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Upload Product Tags</legend>
	<p>
		<span>Upload files with only ProductId and Tags</span>
		<form enctype="multipart/form-data" action="OMS.php?uploadtags=1" method="POST">
			Product Tags File: <input name="product_tags" type="file" /><br />
            Comma separated tags to retain for the products in the above sheet: <input type="text" name="keep_tags" size="120" value=""/><br/>
            <span style="color:green">e.g raindbow, bakrid, diwali, noorediva</span><br/>
            <span style="color:red">Note: keeping the tags box empty overrides existing tags for these products</span><br/>
			<input type="submit" value="Upload product tags" />
		</form>
	</p>
</fieldset>

<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />SnapDeal Raw Data</legend>
	<p>
		<span>Upload files with only Product IDs (Use first row for heading, not processed)</span>
		<form enctype="multipart/form-data" action="affiliateData.php?snapdeal=1" method="POST">
			<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
			Product IDs file: <input name="affiliate_product_ids" type="file" /><br />
			Select Category : 	<select name="id_category">
							<option value="2">Saree</option>
							<option value="4">Kurti</option>
						</select> <br/>
			<input type="submit" value="DownloadProducts" name="DownloadProducts"/>
			<input type="submit" value="DownloadProductStock" name="DownloadProductStock"/>
			<input type="submit" value="DownloadReferenceValues" name="DownloadReferenceValues"/>
		</form>
	</p>
</fieldset>

<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Upload Product Images</legend>
	<p>
		<span>Upload files with only ProductId and ImageList</span>
		<form enctype="multipart/form-data" action="OMS.php?uploadimages=1" method="POST">
			Product Images File: <input name="product_images" type="file" /><br />
			<input type="submit" value="Upload product images" />
		</form>
	</p>
</fieldset>

<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Download Product Qty(Combinations)</legend>
	<p>
		<span>Upload file with only ProductId(first line is heading) </span>
		<form enctype="multipart/form-data" action="OMS.php?combqty=1" method="POST">
			Product Images File: <input name="product_ids" type="file" /><br />
			<input type="submit" value="Download Qty File" />
		</form>
	</p>
</fieldset>

<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Affiliate Special Prices</legend>
	<p>
		<span>Upload file with Affiliate ID, ProductId, Discount Value, Discount Type(amount or percentage) (first line is heading)</span>
		<span style="display:block;color:red">Amazon US Affiliate ID : 1</span>
		<span style="display:block"><span style="color:green">e.g 1, 25444, 0.30, percentage</span> to add 30% discount for product 25444 on Amazon US</span>
		<form enctype="multipart/form-data" action="OMS.php?channel_discount=1" method="POST">
			Upload File: <input name="product_ids" type="file" /><br />
			<input type="submit" value="Add Special Pricing" />
		</form>
	</p>
</fieldset>
