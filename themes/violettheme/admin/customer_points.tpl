<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Account Statement</legend>
	<p>
		<ul STYLE="list-style-type: square">
			<li style="padding:5px">Points Redeemed : {$redeemed_points}</li>
			<li style="padding:5px">Points Balance : {$balance_points}</li>
			<li style="padding:5px">Total Referred : {$total_referred}</li>
		</ul>
	</p>
	<div class="block-center" id="block-vbpoints">
		{if $vbpoints && count($vbpoints)}
		<table id="order-list" class="table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th class="first_item" style="text-align:left;">Date</th>
					<th class="item" style="text-align:left;">Description</th>
					<th class="item" style="text-align:right;">Earned</th>
					<th class="item" style="text-align:right;">Deducted</th>
					<th class="last_item" style="text-align:right;">Balance</th>
				</tr>
			</thead>
			<tbody>
			{foreach from=$vbpoints item=vbpoint}
				<tr>
					<td class="history_date bold">{$vbpoint.date_add}</td>
					<td class="" style="text-align:left;">{$vbpoint.description}</td>
					<td class="" style="text-align:right;">{$vbpoint.points_awarded}</td>
					<td class="" style="text-align:right;">{$vbpoint.points_deducted}</td>
					<td class="" style="text-align:right;">{$vbpoint.balance}</td>
				</tr>
			{/foreach}
			</tbody>
		</table>
		{/if}
	</div>
</fieldset>