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
</head>
<body>
	<div style="margin:20 auto;">
		<fieldset style="margin-bottom:10px;">
			<legend><img src="../img/admin/tab-tools.gif" /><a href="deliverystats.php">Reviews</a></legend>
			<form action="{$currentIndex}&token={$token}" method="post" id="reviewEditForm" style="display:{if isset($review)}block{else}none{/if};width:520px;margin-left:200px">
				<input type="hidden" name="reviewID" value="{if isset($review)}$review->id{/if}" id="editReviewID" />
				<label>Title</label>
				<input type="text" name="reviewTitle" value="{if isset($review)}{$review->title}{/if}" id="editReviewTitle" style="width:300px;"/><br><br>
				<label>Review</label>
				<textarea rows="10" cols="50" id="editReviewArea" name="reviewContent" style="width:300px;">{if isset($review)}{$review->content}{/if}</textarea><br><br>
				<input style="margin-left:205px" type="checkbox" name="approveReview" id="approveReview"/><label style="float:none;margin-left:5px;font-weight:normal">Approve</label> 
				<div style="text-align:right;padding:5px">
					<input type="submit" name="editReview" class="eclusive button" value="Save" style="text-align: right"/>
				</div>
			</form>
			<div>
				{for $pageNo = 1 to $pages}
				<a href="{$currentIndex}&token={$token}&p={$pageNo}">{$pageNo}</a>
				{/for}
			</div>
			<table id="stats_table" class="table" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th colspan="1" style="width:100px">User</th>
						<th colspan="1" style="width:300px">Product</th>
						<th colspan="1" style="width:50px">Rating</th>
						<th colspan="1" style="width:200px">Title</th>
						<th colspan="1" style="width:350px">Review</th>
						<th colspan="1" style="width:50px">Review</th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$reviews item='review'}
					<tr>
						<td colspan="1" >
							<a href="?tab=AdminCustomers&id_customer={$review.customerID}&viewcustomer&token={$customerToken}">
								{$review.customer_name}
							</a>
						</td>
						<td colspan="1" >{$review.name}</td>
						<td colspan="1" style="text-align: center">{$review.grade}</td>
						<td colspan="1" ><span id="{$review.id_product_comment}_title">{$review.title}</span></td>
						<td colspan="1" style="padding:5px 0">
							<span id="{$review.id_product_comment}_review">{$review.content}</span>
							<span class="edit-review" rel="{$review.id_product_comment}" approved="{$review.validate}" style="color:green;text-decoration:underline;cursor:pointer">[edit]</span>
						</td>
						<td colspan="1" style="text-align:center">
							{if $review.deleted == 1}
								<img src="../img/admin/disabled.gif" />
								<a href="{$currentIndex}&token={$token}&restore=1&reviewID={$review.id_product_comment}">Restore</a>
							{elseif $review.validate == 1}
								<img src="../img/admin/enabled.gif" />
							{else}
								<a href="{$currentIndex}&token={$token}&approve=1&reviewID={$review.id_product_comment}">Approve</a>
								<a href="{$currentIndex}&token={$token}&disapprove=1&reviewID={$review.id_product_comment}">Disapprove</a>
							{/if}
						</td>
					</tr>
					{/foreach}
				</tbody>
			</table>
		</fieldset>
	</div>
</body>
</html>
