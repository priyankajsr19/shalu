{if isset($product->shipping_estimate) && $product->shipping_estimate != ''}
    {$product->shipping_estimate|escape:'htmlall':'UTF-8'}
{/if}
<br />
{if !isset($nocust)}
    For orders that include customizations, please add an additional 7 days for shipping. 
{/if}
All orders are shipped by reputed international couriers and may take another 3 to 10 business days to get delivered depending upon the delivery location.
<br />
The estimate provided does not include business holidays and weekends.
<br />
<a href="#shipping-charges" class="shipping_link span_link">Know more about your shipping charges</a>
