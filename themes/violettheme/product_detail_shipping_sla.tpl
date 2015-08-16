{if $product->shipping_sla eq "1"}
    <p style="border-bottom:1px dashed #cacaca;padding:5px 0;clear:both; font-weight:bold; color:#008500">
        <img src="{$img_ps_dir}btruck.png" width="20px" height="20px" style="float:left"/>
        <span style="margin-left:10px">Shipped in 24 hours</span>
    </p>
{else}
<!-- 
    <p style="border-bottom:1px dashed #cacaca;padding:5px 0;clear:both;font-weight:bold; color:#008500">
        <img src="{$img_ps_dir}btruck.png" width="20px" height="20px" style="float:left"/>
        <span style="margin-left:10px">Shipped in {$product->shipping_sla} days</span>
    </p>
 -->
{/if}
