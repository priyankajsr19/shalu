<html>
<head>
	<style type="text/css">
		a:hover{
			color:blue;
			text-decoration:underline !important;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".edit-review").click(function(){
				var reviewID = $(this).attr('rel');
				$("#editReviewID").val(reviewID);
				$("#editReviewArea").val($("#"+reviewID+"_review").text());
				$("#editReviewTitle").val($("#"+reviewID+"_title").text());

				if($(this).attr('approved') == '1')
					$("#approveReview").attr('checked','checked');
					
				$("#reviewEditForm").fadeIn();
			});
		});
	</script>
	{literal}
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
				$("#date_from").datepicker({
					prevText:"",
					nextText:"",
					dateFormat:"yy-mm-dd"});
			});

			$(function() {
				$("#date_to").datepicker({
					prevText:"",
					nextText:"",
					dateFormat:"yy-mm-dd"});
			});
		</script>
	{/literal}
</head>
<body>
    {if isset($referrer_details)}
	    <p>
    	    Referrer: {$referrer_details.name}<br>
    	    Total Orders: {$referrer_details.total_orders}<br>
    	    Total Paid: {$referrer_details.total_paid}
    	</p>
    {/if}
	{if isset($referredOrders)}
	    <div style="margin:20 auto;">
		<fieldset style="margin-bottom:10px;">
    	<legend><img src="../img/admin/tab-tools.gif" />Referred Orders</legend>
    		<table id="stats_table" class="table" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th colspan="1" style="width:200px">Order ID</th>
						<th colspan="1" style="width:100px">Name</th>
						<th colspan="1" style="width:250px">Address</th>
						<th colspan="1" style="width:100px">Phone</th>
						<th colspan="1" style="width:200px">Total Paid</th>
						<th colspan="1" style="width:200px">Date Register</th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$referredOrders item='order'}
					<tr>
						<td colspan="1" >
							<a href="?tab=AdminOrders&id_order={$order.id_order}&vieworder&token={$orderToken}">
								{$order.id_order}
							</a>
						</td>
						<td colspan="1" >{$order.name}</td>
						<td colspan="1" style="text-align: left">
                             {$order.address}
                        </td>
						<td colspan="1" >{$order.phone_mobile}</td>
						<td colspan="1" >{$order.total_paid}</td>
						<td colspan="1" >{$order.date_register}</td>
					</tr>
					{/foreach}
				</tbody>
			</table>
        </fieldset>
	</div>
	{/if}
	{if isset($referredCustomers)}
	    <div style="margin:20 auto;">
		<fieldset style="margin-bottom:10px;">
    	<legend><img src="../img/admin/tab-tools.gif" />Referred Customers</legend>
    		<table id="stats_table" class="table" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th colspan="1" style="width:200px">Name</th>
						<th colspan="1" style="width:200px">Date Register</th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$referredCustomers item='customer'}
					<tr>
						<td colspan="1" >
							<a href="?tab=AdminCustomers&id_customer={$customer.id_customer}&viewcustomer&token={$customerToken}">
								{$customer.name}
							</a>
						</td>
						<td colspan="1" >{$customer.date_add}</td>
					</tr>
					{/foreach}
				</tbody>
			</table>
        </fieldset>
	</div>
	{/if}
	<div style="margin:20 auto;">
		<fieldset style="margin-bottom:10px;">
    	<legend><img src="../img/admin/tab-tools.gif" />Referrals list</legend>
    		<form action="" method="POST" style="margin-bottom:15px;">
    			From: <input type="text" id="date_from" name="date_from" value="{$date_from}"/>
    			To: <input type="text" id="date_to" name="date_to" value="{$date_to}"/>
    			<input type="submit" value="Update" />
    		</form>
    		<table id="stats_table" class="table" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th colspan="1" style="width:200px">Customer</th>
						<th colspan="1" style="width:100px">Registered</th>
						<th colspan="1" style="width:100px">Orders</th>
						<th colspan="1" style="width:200px">Friends with Orders</th>
						<th colspan="1" style="width:200px">Avg Order Value</th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$referrals item='referral'}
					<tr>
						<td colspan="1" >
							<a href="?tab=AdminCustomers&id_customer={$referral.customerID}&viewcustomer&token={$customerToken}">
								{$referral.name}
							</a>
						</td>
						<td colspan="1" style="text-align: center">
                            {if $referral.total_registered > 0}
                               <a href="?tab=AdminReferrals&getReferrerData=1&token={$token}&referrer={$referral.customerID}">
                                   {$referral.total_registered}
                               </a>
                            {else}
                                {$referral.total_registered}
                            {/if}
                        </td>
						<td colspan="1" >{$referral.total_orders}</td>
						<td colspan="1" >{$referral.total_friends_orders}</td>
						<td colspan="1" >{$referral.avg_order}</td>
					</tr>
					{/foreach}
				</tbody>
			</table>
        </fieldset>
	</div>
</body>
</html>
