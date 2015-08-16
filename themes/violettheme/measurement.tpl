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
	<div class="vtab-bar">
		<ul id="my_account_links">
			<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}identity.php" title="{l s='Information'}">{l s='Personal Info'}</a></div></li>
			<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}history.php" title="{l s='Orders'}">{l s='Orders'}</a></li>
			{if isset($returnAllowed)}
				<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}order-follow.php" title="{l s='Merchandise returns'}">{l s='Returns'}</a></div></li>
			{/if}
			{*<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}order-slip.php" title="{l s='Credit slips'}">{l s='Credit Slips'}</a></div></li>*}
			<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}addresses.php" title="{l s='My Address Book'}">{l s='My Address Book'}</a></div></li>
			
			{if isset($voucherAllowed)}
				<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}discount.php" title="{l s='Vouchers'}">{l s='My vouchers'}</a></div></li>
			{/if}
			<li class="selected"><div class="vtab-bar-link"><a href="{$base_dir_ssl}vcoins.php" title="{l s='My Violet Coins'}">{l s='My Violet Coins'}</a></div></li>
			<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}referral.php" title="{l s='My Referrals'}">{l s='My Referrals'}</a></div></li>
		</ul>
	</div>
	<div class="vtab-content">
		{*<h2>{l s='My VB Points'}</h2>*}
		{include file="$tpl_dir./errors.tpl"}
		{include file="$tpl_dir./measurement-form.tpl"}
	</div>
</div>
