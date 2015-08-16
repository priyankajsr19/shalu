
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
        {assign var='selitem' value='addresses'}
	{include file="$tpl_dir./myaccount_menu.tpl"}
	<div class="vtab-content">
	<div style="border: 1px solid #D0D3D8;box-shadow: 0 1px 3px 0 black;margin-bottom: 1em;padding-bottom: 1em;margin-top:15px;min-height:400px;float:left;width:100%">
		<h1 style="padding:10px 0;text-align:center;border-bottom:1px dashed #cacaca">{l s='Your Adresses'}</h1>
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
	</div>
	</div
</div>