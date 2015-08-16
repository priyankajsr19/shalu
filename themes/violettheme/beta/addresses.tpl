
<script type="text/javascript">
//<![CDATA[
	var baseDir = '{$base_dir_ssl}';
	$(document).ready(function(){
		$('.delete_address').click(function(e){
			
			if(!confirm('Delete this address from your Address-Book?'))
				e.preventDefault();
		});
	});
//]]>
</script>

{*{capture name=path}<a href="{$link->getPageLink('my-account.php', true)}">{l s='My account'}</a><span class="navigation-pipe">{$navigationPipe}</span>{l s='My addresses'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}
*}
<div style="width:970px;">
	<div class="vtab-bar">
		<ul id="my_account_links">
			<li ><div class="vtab-bar-link"><a href="{$base_dir_ssl}identity.php" title="{l s='Information'}">{l s='Personal Info'}</a></div></li>
			<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}history.php" title="{l s='Orders'}">{l s='Orders'}</a></li>
			{if $returnAllowed}
				<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}order-follow.php" title="{l s='Merchandise returns'}">{l s='Returns'}</a></div></li>
			{/if}
			{*<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}order-slip.php" title="{l s='Credit slips'}">{l s='Credit Slips'}</a></div></li>*}
			<li class="selected"><div class="vtab-bar-link"><a href="{$base_dir_ssl}addresses.php" title="{l s='My Address Book'}">{l s='My Address Book'}</a></div></li>
			
			{if $voucherAllowed}
				<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}discount.php" title="{l s='Vouchers'}">{l s='My vouchers'}</a></div></li>
			{/if}
			<li ><div class="vtab-bar-link"><a href="{$base_dir_ssl}vcoins.php" title="{l s='My Violet Coins'}">{l s='My Violet Coins'}</a></div></li>
			<li><div class="vtab-bar-link"><a href="{$base_dir_ssl}referral.php" title="{l s='My Referrals'}">{l s='My Referrals'}</a></div></li>
		</ul>
	</div>
	<div class="vtab-content">
		<h1>{l s='My Address Book'}</h1>
		
		
		<div id="address_wrapper">
			<a href="{$link->getPageLink('address.php', true)}" title="{l s='Add an address'}">
				<div id="new_address_card" class="new_address_card" style="cursor:pointer;">
					<span class="new_address_title"">Add a new address</span>
				</div>
			</a>
			{foreach from=$addresses key=k item=address}
				<div id="address_link_{$address.id_address|intval}" class="selectable address_card_selected ">
						<div class="address_title" style="padding:3px 3px 3px 15px;display:block;">
							
							<a id="removeAddress_{$address.id_address|intval}" class="delete_address" title="Delete from Address Book" href="{$base_dir_ssl}address.php?id_address={$address.id_address|intval}&delete=1" ></a>
						</div>
						<ul class="address item" id="address_{$address.id_address|intval}">
							
							<li class="address_name">{$address.firstname|addslashes} {$address.lastname|addslashes}</li>
							<li class="address_address1">{$address.address1|addslashes}</li>
							<li class="address_address2">{$address.address2|addslashes}</li>
							<li class="address_city">{$address.city|addslashes}</li>
							<li class="address_pincode">{$address.postcode|addslashes}</li>
							<li class="address_country">Phone: {$address.phone_mobile|addslashes}</li>
						</ul>
						<span class="updateaddress"><a href="{$base_dir_ssl}address.php?id_address={$address.id_address|intval}" title="{l s='Update'}">{l s='Update'}</a></span>
				</div>
			{/foreach}
		</div>
		
		
{*		<ul class="footer_links">
			<li><a href="{$link->getPageLink('my-account.php', true)}"><img src="{$img_dir}icon/my-account.gif" alt="" class="icon" /></a><a href="{$link->getPageLink('my-account.php', true)}">{l s='Back to Your Account'}</a></li>
			<li><a href="{$base_dir}"><img src="{$img_dir}icon/home.gif" alt="" class="icon" /></a><a href="{$base_dir}">{l s='Home'}</a></li>
		</ul>
*}
	</div>
</div>