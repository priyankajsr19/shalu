{if $product.shipping_sla eq "1"}
    <div style="text-align:left;color:#008500">Shipped in 24 hours</div>
{else if $product.shipping_sla|string_format:"%d" <= 5}
    <div style="text-align:left;color:#008500">Shipped in {$product.shipping_sla} days</div>
{/if}
