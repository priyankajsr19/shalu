<script type="text/javascript">
//<![CDATA[
	var baseDir = '{$base_dir_ssl}';
//]]>
</script>
<div id="fb-root"></div>
<script>
{literal}
  window.fbAsyncInit = function() {
    FB.init({
      appId  : '285166361588635',
      status : false, // check login status
      cookie : true, // enable cookies to allow the server to access the session
      xfbml  : true,  // parse XFBML
      oauth : true //enables OAuth 2.0
    });
    
    $('#fbshare').click( function(){
        //FB.ui(obj, shareCallBack);
        FB.login(function (response) {
                if (response.authResponse) {
                    FB.api(
                            '/me/indusdiva:buy', 
                            'post', 
                            { product : '{/literal}{$fbShareProductObject}{literal}' },
                            function(response){
                                $("#fbsharemsg").fadeIn().html("Thanks for sharing this awesome product");
                                $.ajax({
                                    type: 'GET',
                                    url: baseDir + 'feedback.php',
                                    data: 'fb_order_share=1&oid='+parseInt({/literal}{$id_order}{literal})+'&pid='+parseInt({/literal}{$fbShareProductObjectId}{literal}),
                                    success: function(msg)
                                    {
                                        
                                    }
                                });
                                setTimeout( function(){ $("#fbsharemsg").fadeOut() } , 4000);
                            });
                } else {
                    $("#fbsharemsg").fadeIn().html("Unable to share.Please try again");
                    setTimeout( function(){ $("#fbsharemsg").fadeOut() } , 4000);
                }
            }, {
                scope: 'publish_actions'
            }
        );
    });
  };

  (function(d){
    var js, id = 'facebook-jssdk'; 
    if (d.getElementById(id)) {
      return; // already loaded, no need to load again
    }
    js = d.createElement('script'); js.id = id; js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    d.getElementsByTagName('head')[0].appendChild(js);
  }(document));
  {/literal}
</script>
<div id="co_content">
	<div id="co_left_column" style="width:980px;">
	
		{assign var='current_step' value='done'}
		{include file="$tpl_dir./order-steps.tpl"}
		
		{include file="$tpl_dir./errors.tpl"}
		<div style="width:750px; border:1px solid black; float:left;margin:20px 120px;border: 1px solid #D0D3D8;box-shadow: 0 1px 3px 0 black;padding:10px">
		<h1 style="border-bottom:1px dashed #cacaca;padding:10px;text-align:center">Order Confirmed</h1>
		<div id="order-confirm" style="width:600px; margin:10px;">
                        <div class="clearfix">
                            <div style="float:left;font-size:21px; color:#a46bcf;font-style:bold;">Thank you for shopping with us!</div>
                            <div style="float:right; width:270px">
                                <img id="fbshare" src="../themes/violettheme/img/facebook_button.png" width="76px" height="28px"> 
                                <p class="warning" id="fbsharemsg" style="display: none"></p>
                            </div>
                        </div>
			<br /><br />
			<span style="font-size:12px; font-style:bold;">Your order #{$id_order} is confirmed. The expected date of shipping for your order is <b>{$shipping_date}</b>. Here are the order details: </span>
			{if isset($paymentMethod) && $paymentMethod == 'COD'}
			<br><span>Someone from our customer care team will call you within 2 business hours to verify the order. Once the verification is complete, the order will be delivered to you within 3-5 business days. </span>
			<br>
			<span>Please keep an amount of Rs. {$order_total} ready at the time of delivery. </span>
			{/if}
			{if $is_guest}
				
				<a href="{$link->getPageLink('guest-tracking.php', true)}?id_order={$id_order}" title="{l s='Follow my order'}"><img src="{$img_dir}icon/order.gif" alt="{l s='Follow my order'}" class="icon" /></a>
				<a href="{$link->getPageLink('guest-tracking.php', true)}?id_order={$id_order}" title="{l s='Follow my order'}">{l s='Follow my order'}</a>
			{else}
			
				{*
				<a href="{$link->getPageLink('history.php', true)}" title="{l s='Back to orders'}"><img src="{$img_dir}icon/order.gif" alt="{l s='Back to orders'}" class="icon" /></a>
				<a href="{$link->getPageLink('history.php', true)}" title="{l s='Back to orders'}">{l s='Back to orders'}</a>
				*}
			{/if}
		</div>
		<div id="block_payment_module">
			{$HOOK_ORDER_CONFIRMATION}
			{$HOOK_PAYMENT_RETURN}
		</div>
		
		<div id="block-order-detail" style="padding:10px;width:720px">
			{include file="$tpl_dir./order-detail.tpl"}
		</div>
		</div>
	</div>
</div>
<!-- Google Code for Sale Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1011353032;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "JgbSCIiBjgMQyIug4gM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1011353032/?value=0&amp;label=JgbSCIiBjgMQyIug4gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

{if $order->payment neq 'Bank Wire'}
	{if $cookie->last_source == 'inuxu'}
		<iframe src="http://inuxu.biz/Tracker/CoT?p1=1026&p2=99&p3={$id_order}&p4={$order_total_usd}&p5={$orderProducts}&p6="/>
	{/if}
	{if $cookie->last_source == 'ibibo'}
		<iframe id='m3_tracker_567' name='m3_tracker_567' src='http://ads.ibibo.com/ad/www/delivery/tifr.php?trackerid=567&amp;Transaction_ID={$id_order}&amp;Sale_Amount={$order_total_usd}&amp;Item_Number={$totalQuantity}&amp;cb=%%RANDOM_NUMBER%%' frameborder='no' scrolling='no' width='0' height='0'></iframe>
	{/if}
	{if $cookie->last_source == 'adroll'}
		<script type="text/javascript">
			{literal}
			adroll_adv_id = "ECTRVXZTQ5B3VDC3WZRYQM";
			adroll_pix_id = "IB2H4VTPCRBV3LQCOMMGKQ";
			adroll_conversion_value_in_dollars = {/literal}"{$order_total_usd}"{literal};
			adroll_custom_data = {{/literal}"ORDER_ID": "{$id_order}"{literal}};
			(function () {
				var oldonload = window.onload;
				window.onload = function(){
					__adroll_loaded=true;
					var scr = document.createElement("script");
					var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
					scr.setAttribute('async', 'true');
					scr.type = "text/javascript";
					scr.src = host + "/j/roundtrip.js";
					((document.getElementsByTagName('head') || [null])[0] ||document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
					if(oldonload) {
						oldonload()
					}
				};
			}());
			{/literal}
		</script>
	{/if}
{/if}
<script type="text/javascript">
    <!--
        _sokClient = '249';
    //-->
</script>
<script type="text/javascript">
    var sokhost = ("https:" == document.location.protocol) ? "https://tracking.sokrati.com" : "http://cdn.sokrati.com";
    var sokratiJS = sokhost + '/javascripts/tracker.js';
    document.write(unescape("%3Cscript src='" + sokratiJS + "' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var paramList = { };
paramList['lead_step'] = 'Placeordernow';
</script>
<script type="text/javascript">
    try { sokrati.trackSaleParams("0", "{$id_order}", "{$order_total_usd}", "{$totalQuantity}",paramList); }
    catch(err) { }
</script>
