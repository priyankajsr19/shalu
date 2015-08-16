<div id="pay-cash" class="payment_module">
{if isset($cod) && $cod != 0}
<input type="radio" name="payMethod" value="COD" style="margin-left:30px;font-size:15px;"/> Cash on delivery payment
<a style="display:none" id="codLink" href="{$this_path_ssl}validation.php?back=order.php&cid={$cod}" title="{l s='Pay with cash on delivery (COD)' mod='cashondelivery'}">		
    Pay cash on delivery.
</a>
<span style="color:#333333;">(Rs. 70 Extra)</span>
{/if}
</div>