<script type="text/javascript">
//<![CDATA[
	var baseDir = '{$base_dir_ssl}';
	{literal}
	$('a.points_help').cluetip({
			splitTitle: '|',
			arrows: true
		});
	{/literal}
//]]>
</script>

<div style="width:970px;">
        {assign var='selitem' value='points'}
        {include file="$tpl_dir./myaccount_menu.tpl"}
	<div class="vtab-content">
		{*<h2>{l s='My VB Points'}</h2>*}
		{include file="$tpl_dir./errors.tpl"}
		<div style="width:100%;padding-bottom:15px;float:left;">
			<div style="padding:15px 5px;width:150px;height:45px;float:left;text-align:center;">
				<span style="text-align:left;font-size:30px;">{$earned_points}</span>
				<br/>
				<span style="padding:0 5px;">Indusdiva Coins Earned </span>
				<a id="points_help" href="#" title="5 Indusdiva Coins =  1 USD. You can redeem these coins against your future orders."><img src="{$img_dir}icon/help.png" height="12" width="12"/></a>
			</div>
			<div style="padding:15px 5px;width:150px;height:45px;float:left;text-align:center;border-left:1px dotted #cacaca">
				<span style="text-align:left;font-size:30px;">{$redeemed_points}</span>
				<br/>
				<span style="padding:0 5px;">Coins Redeemed</span>
				{*<a id="point_help" href="#" title="You can redeem coins before placing order in your review order page."><img src="{$img_dir}icon/help.png" height="12" width="12"/></a>*}
			</div>
			<div style="padding:15px 5px;width:150px;height:45px;float:left;text-align:center;border-left:1px dotted #cacaca">
				<span style="text-align:left;font-size:30px;">{$balance_points}</span>
				<br/>
				<span style="padding:0 5px;">Indusdiva Coins Available</span>
			</div>
			<div style="padding:5px 10px 5px 20px;;width:270px;min-height:65px;float:left;text-align:left;border-left:1px dotted #cacaca">
				<ul>
					<li>
						{if isset($total_referred) && $total_referred > 0}
							<span style="text-align:left;font-size:15px;">{$total_referred}</span>
							{if $total_referred == 1}
								<span style="padding:0 5px;">Friend referred</span>
							{else}
								<span style="padding:0 5px;">Friends referred</span>
							{/if}
						{else}
							<span>No friends referred </span>
							<a href="{$base_dir_ssl}referral.php" ><span style="font-size:11px; color:#939393">[Invite Now]</span></a>
						{/if}
					</li>
					<li>
						{if isset($reviews_approved) && $reviews_approved > 0}
							<span style="text-align:left;font-size:15px;">{$reviews_approved}</span>
							<span style="padding:0 5px;">Products reviewed</span>
						{else}
							<span>No products reviewed</span>
						{/if}
					</li>
					<li>
						{if isset($social_points) && $social_points > 0}
							<span style="text-align:left;font-size:15px;">{$social_points}</span>
							<span style="padding:0 5px;">Coins for social love </span>
							<br /><span style="font-size:11px; color:#939393;padding:0 5px">(Facebook like and Google plus share)</span>
						{else}
							<span>No social love coins. Start sharing!</span>
							<br /><span style="font-size:11px; color:#939393;">(Click on Google Plus & Facebook Like buttons</span> 
							<br /><span style="font-size:11px; color:#939393;">on your favorite products and earn coins!)</span>
						{/if}
					</li>
				</ul>
			</div>
			<div style="border-top: 1px dotted #CACACA;float: left;margin-top: 5px;padding-top: 5px;text-align: right;width: 100%;">
				<a href="{$base_dir}idrewards.php" target="_blank"><span style="color:#589942;" class="span_link">How do I earn more coins?</span></a>
			</div>
		</div>
		<h2 style="border-bottom: 1px dotted #cacaca;clear:both;">{l s='Account statement'}</h2>
		<div class="block-center" id="block-vbpoints">
			{if $vbpoints && count($vbpoints)}
			<table id="order-list" class="std">
				<thead>
					<tr>
						<th class="first_item" style="text-align:left;">{l s='Date'}</th>
						<th class="item" style="text-align:left;">{l s='Description'}</th>
						<th class="item" style="text-align:right;">{l s='Earned'}</th>
						<th class="item" style="text-align:right;">{l s='Deducted'}</th>
						<th class="last_item" style="text-align:right;">{l s='Balance'}</th>
					</tr>
				</thead>
				<tbody>
				{foreach from=$vbpoints item=vbpoint name=myLoop}
					<tr class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if} {if $smarty.foreach.myLoop.index % 2}alternate_item{/if}">
						<td class="history_date bold">{dateFormat date=$vbpoint.date_add full=0}</td>
						<td class="" style="text-align:left;">{$vbpoint.description}</td>
						<td class="" style="text-align:right;">{$vbpoint.points_awarded}</td>
						<td class="" style="text-align:right;">{$vbpoint.points_deducted}</td>
						<td class="" style="text-align:right;">{$vbpoint.balance}</td>
					</tr>
				{/foreach}
				</tbody>
			</table>
			<div id="block-order-detail" class="hidden" style="padding:10px 0px; float:left">&nbsp;</div>
			{else}
				<p class="warning">{l s='You have not placed any orders.'}</p>
			{/if}
		</div>
	</div>
</div>
