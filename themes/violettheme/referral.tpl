<script type="text/javascript">
//<![CDATA[
	var baseDir = '{$base_dir_ssl}';
//]]>
</script>
<div style="width:970px;">
	{assign var='selitem' value='referral'}
	{include file="$tpl_dir./myaccount_menu.tpl"}
	<div class="vtab-content" style="margin:0 5px 0 10px; width:800px;">
		
		{include file="$tpl_dir./errors.tpl"}
		{*<img src="{$img_ps_dir}banners/referral.jpg"/>*} 
		<div class="block-center" id="block-vbpoints">
			{if isset($countInvited) && $countInvited > 0}
				<p class="warning">{$countInvited} invitations will be sent shortly.</p>
			{/if}
			{if isset($countInvited) && $countInvalid > 0 && isset($countInvalid) && $countInvalid > 0}
				<p class="warning">{$countInvalid} emails already registered.</p>
			{/if}
			<div id="referral-panel" style="text-align:left;border:1px dashed #cacaca;margin-bottom:20px; padding:10px 20px;">
				<form id="referral-form" action="{$base_dir}referral.php" method="post">
					<div id="ref_error_container" class="error_container">
						<h4>There are errors:</h4>
						<ol>
							<li class="incorrect_email"><label for="ref_email" class="error incorrect_email">Please add correct emails (seperated by commas)</label></li>
						</ol>
					</div>
					<p style="padding-left:0">
						Earn while you share! Invite your friends to the gorgeous Indusdiva family and earn 50 Indusdiva Coins when your pal makes the first purchase. 
						So go ahead and share the joy of shopping and reward yourself on the go. 
						<a href="{$base_dir}idrewards.php" target="_blank"><span style="color:#589942;" class="span_link">Click here to know more.</span></a>
					</p>
					<div>
						<p class="required text" style="padding:5px 0px 0px;">
							<label for="ref_emails" style="font-weight:bold">{l s='E-mails (seperated by commas)'}</label>
							<br />
							<textarea class="text required email_names" type="text" id="ref_emails" name="ref_emails" value="" style="width:100%;height:150px;font-size:13px"></textarea>
						</p>
						<p style="padding-left:0;margin:0">
							<a class="cs_import">
								<span style="width:125px;display:inline-block">Import from GMail, Yahoo, MSN and more</span>
								<img src="{$img_ps_dir}yahoo.png" />
								<img src="{$img_ps_dir}google.png" />
								<img src="{$img_ps_dir}msn.png" />
							</a>
						</p>
						
						<input id="submit_referral" type="submit" value="Send Invites" class="button exclusive_large" style="margin:auto; margin-top:10px;" />
					</div>
				</form>
				<p style="padding:10px 0 0 0">Sharing the spirit of shopping was never so easy, use your unique referral link and invite your friends over. 
				Copy and paste this anywhere on the World Wide Web and keep adding to your treasure house of Indusdiva Coins.
				</p>
				<p style="padding-left:0">
					<span style="font-weight:bold;padding:0 10px 0 0">Your unique referral link:</span>
					<span style="color:#636363;font-weight:bold">{$base_dir}?vbref={$customer_id}</span>
				</p>
		</div>
			{if isset($referrals) && count($referrals)}
			<h2 style="border-bottom:1px dotted #cacaca">{l s='My Referrals'}</h2>
			<table id="referral-list" class="std">
				<thead>
					<tr>
						<th class="first_item" style="text-align:left;">{l s='Date Invite'}</th>
						<th class="item" style="text-align:left;">{l s='Name'}</th>
						<th class="item" style="text-align:left;">{l s='Email'}</th>
						<th class="item" style="text-align:right;">{l s='Registered'}</th>
						<th class="last_item" style="text-align:right;">{l s='First Order delivered'}</th>
					</tr>
				</thead>
				<tbody>
				{foreach from=$referrals item=referral name=myLoop}
					<tr class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if} {if $smarty.foreach.myLoop.index % 2}alternate_item{/if}">
						<td class="history_date bold" style="text-align:left;">{dateFormat date=$referral.date_add full=0}</td>
						<td class="" style="text-align:left;">{$referral.name}</td>
						<td class="" style="text-align:left;">{$referral.email}</td>
						<td class="" style="text-align:center;"><img src="{$img_dir}icon/available.gif" width="14" height="14" /></td>
						{if $referral.total_delivered > 0}
							<td class="" style="text-align:center;"><img src="{$img_dir}icon/available.gif" width="14" height="14" /></td>
						{else}
							<td class="" style="text-align:center;"> - </td>
						{/if}
					</tr>
				{/foreach}
				</tbody>
			</table>
			<div id="block-order-detail" class="hidden" style="padding:10px 0px; float:left">&nbsp;</div>
			{else}
				{if isset($referrals_invited) && $referrals_invited > 0}
					<p class="warning">None of your friends have signed up at Indusdiva.com</p>
				{else}
					<p class="warning">{l s='You have not invited any of your friends.'}</p>
				{/if}
			{/if}
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
			
				var csPageOptions = {
					  domain_key:"W76TRN28M7YPWJ47TJBP", 
					  textarea_id:"ref_emails"
					};
				
				$(document).ready(function() {

					jQuery.validator.addMethod("email_names", function(value, element) {
						var emailList = value;
						var patt=new RegExp("^.*[<]?([a-z0-9!#$%&\'*+\/=?^`{}|~_-]+[.a-z0-9!#$%&\'*+\/=?^`{}|~_-]*@[a-z0-9]+[._a-z0-9-]*\.[a-z0-9]+)>?$","i");
						//var regex = /^[a-z0-9!#$%&\'*+\/=?^`{}|~_-]+[.a-z0-9!#$%&\'*+\/=?^`{}|~_-]*@[a-z0-9]+[._a-z0-9-]*\.[a-z0-9]+$/
						var emails = emailList.split(",");
						if(emails.length < 1) return false;
						for (var i = 0; i < emails.length; i++)
						{
							if(!patt.exec(emails[i].trim())) return false;
						}
					  	
						return true;
					}, "Please specify the correct domain for your documents");
					
					
					$('#referral-form').submit(function(e){
						var container = $('#ref_error_container');
						// validate the form when it is submitted
						var validator = $("#referral-form").validate({
							errorContainer: container,
							errorLabelContainer: $("ol", container),
							wrapper: 'li',
							meta: "validate"
						});

						if(!validator.form())						
						{
							e.preventDefault();
						}
						else if(!isValidEmails())
						{
							e.preventDefault();
							$('#ref_error_container').show();
							$('#ref_error_container ol').show();
							$('.incorrect_email').show();
						}
					});
				});
			
			</script>
			{/literal}
	<script type="text/javascript" src="https://api.cloudsponge.com/address_books.js"></script>