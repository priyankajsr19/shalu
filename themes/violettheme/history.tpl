<script type="text/javascript">
//<![CDATA[
	var baseDir = '{$base_dir_ssl}';
//]]>
</script>

<div style="width:970px;">
        {assign var='selitem' value='history'}
	{include file="$tpl_dir./myaccount_menu.tpl"}
	<div class="vtab-content">
		<div style="border: 1px solid #D0D3D8;box-shadow: 0 1px 3px 0 black;margin-bottom: 1em;padding-bottom: 1em;margin-top:15px;min-height:400px;float:left;width:100%">
		<h1 style="padding:10px 0;text-align:center;border-bottom:1px dashed #cacaca">{l s='Order history'}</h1>
		{if $slowValidation}<p class="warning">{l s='If you have just placed an order, it may take a few minutes for it to be validated. Please refresh the page if your order is missing.'}</p>{/if}
		
		<div class="block-center" id="block-history">
			{if $orders && count($orders)}
			<table id="order-list" class="std">
				<thead>
					<tr>
						<th class="first_item">{l s='Order'}</th>
						<th class="item">{l s='Date'}</th>
						<th class="item">{l s='Expected Shipping Date'}</th>
						<th class="item" style="text-align:right;">{l s='Total price'}</th>
						<th class="item">{l s='Payment'}</th>
						<th class="item">{l s='Status'}</th>
						<th class="item">{l s='Invoice'}</th>
						<th class="last_item" style="width:65px">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
				{foreach from=$orders item=order name=myLoop}
					<tr class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if} {if $smarty.foreach.myLoop.index % 2}alternate_item{/if}">
						<td class="history_link bold">
							{if isset($order.invoice) && $order.invoice && isset($order.virtual) && $order.virtual}<img src="{$img_dir}icon/download_product.gif" class="icon" alt="{l s='Products to download'}" title="{l s='Products to download'}" />{/if}
							<a class="color-myaccount" href="javascript:showOrder(1, {$order.id_order|intval}, 'order-detail');">{l s='#'}{$order.id_order|string_format:"%06d"}</a>
						</td>
						<td class="history_date bold">{dateFormat date=$order.date_add full=0}</td>
						<td class="history_date bold">{dateFormat date=$order.expected_shipping_date full=0}</td>
						<td class="history_price" style="text-align:right;"><span class="price">{displayPrice price=$order.total_paid_real currency=$order.id_currency no_utf8=false convert=false}</span></td>
						<td class="history_method">{$order.payment|escape:'htmlall':'UTF-8'}</td>
						<td class="history_state">{if isset($order.order_state)}{$order.order_state_external|escape:'htmlall':'UTF-8'}{/if}</td>
						<td class="history_invoice">
						{if (isset($order.invoice) && $order.invoice && isset($order.invoice_number) && $order.invoice_number) && isset($invoiceAllowed) && $invoiceAllowed == true}
							<a href="{$link->getPageLink('pdf-invoice.php', true)}?id_order={$order.id_order|intval}" title="{l s='Invoice'}"><img src="{$img_dir}icon/pdf.gif" alt="{l s='Invoice'}" class="icon" /></a>
							<a href="{$link->getPageLink('pdf-invoice.php', true)}?id_order={$order.id_order|intval}" title="{l s='Invoice'}">{l s='PDF'}</a>
						{else}-{/if}
						</td>
						<td class="history_detail">
							<a class="color-myaccount" href="javascript:showOrder(1, {$order.id_order|intval}, 'order-detail');">{l s='details'}</a>
							{*<a href="{if isset($opc) && $opc}{$link->getPageLink('order-opc.php', true)}{else}{$link->getPageLink('order.php', true)}{/if}?submitReorder&id_order={$order.id_order|intval}" title="{l s='Reorder'}">
								<img src="{$img_dir}arrow_rotate_anticlockwise.png" alt="{l s='Reorder'}" title="{l s='Reorder'}" class="icon" />
							</a>*}
						</td>
					</tr>
				{/foreach}
				</tbody>
			</table>
			<div id="block-order-detail" class="hidden" style="padding:10px 10px; float:left">&nbsp;</div>
			{else}
				<p class="warning">{l s='You have not placed any orders.'}</p>
			{/if}
		</div>
	</div>
	</div>
</div>