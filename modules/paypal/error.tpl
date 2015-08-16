{capture name=path}<a href="{$link->getPageLink('order.php', true)}">{l s='Your shopping cart' mod='paypal'}</a>
<span class="navigation-pipe">{$navigationPipe}</span>{l s='PayPal' mod='paypal'}{/capture}
<div style="width:750px; border:1px solid black; float:left;margin:20px 120px;border: 1px solid #D0D3D8;box-shadow: 0 1px 3px 0 black;padding:10px">
		<h1 style="border-bottom:1px dashed #cacaca;padding:10px;text-align:center">Payment Error</h1>
		<p>There were some errors while processing your payment.</p>
		<p>Please try again later.</p>
<p style="text-align:center"><a href="{$base_dir}/order?step=3" class="button_small" style="margin:auto" title="{l s='Back' mod='paypal'}">&laquo; {l s='Back' mod='paypal'}</a></p>
</div>
