
<div style="width:1230px;margin:20 auto;">
<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Shipped but not delivered</legend>
	<h2>Total: {$orders|@count}</h2>
	<table id="stats_table" class="table" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th colspan="1">Order ID</th>
				<th colspan="1">Carrier</th>
				<th colspan="1">Shipping Date</th>
				<th colspan="1">Tracking Number</th>
				<th colspan="1">City</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$orders item='order'}
			<tr>
				<td class="title">{$order.OrderID}</td>
				<td class="title">{$order.Carrier}</td>
				<td class="title">{$order.ShippingDate}</td>
				<td class="title">{$order.TrackingCode}</td>
				<td class="title">{$order.city}</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
</fieldset>
</div>

