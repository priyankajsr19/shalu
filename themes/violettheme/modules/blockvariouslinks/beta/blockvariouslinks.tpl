{* <!-- /MODULE Block various links --> *}
<div id="footer_wrapper">
    <div class="footer">
    <div class="footer-links">
        <ul>
            <li><strong>Company Information</strong></li>
            <li><a href="{$base_dir}about-us.php" {if !isset($follow_footerlinks)}rel="nofollow"{/if}>About us</a></li>
            <li><a href="{$base_dir}contact-us.php" {if !isset($follow_footerlinks)}rel="nofollow"{/if}>Contact Us</a></li>
            <li><a href="{$base_dir}careers.php" {if !isset($follow_footerlinks)}rel="nofollow"{/if}>Careers</a></li>
        </ul>
        <ul>
            <li><strong>Need Help?</strong></li>
            <li><a href="{$base_dir}faqs.php" {if !isset($follow_footerlinks)}rel="nofollow"{/if}>FAQs</a></li>
            <li><a href="{$base_dir}shipping-policy.php" {if !isset($follow_footerlinks)}rel="nofollow"{/if}>Shipping Policy</a></li>
            <li><a href="{$base_dir}return-policy.php" {if !isset($follow_footerlinks)}rel="nofollow"{/if}>Return Policy</a></li>
            <li><a href="{$base_dir}history.php" rel="nofollow">Track Your Order</a></li>
            <li><a href="{$base_dir}sitemaps/" {if !isset($follow_footerlinks)}rel="nofollow"{/if}>Popular Searches</a></li>
        </ul>
        <ul>
            <li><strong>My Account</strong></li>
            {if $cookie->isLogged()}
            	 <li><a href="{$base_dir}vcoins.php" rel="nofollow">My Account</a></li>
            	 <li><a id="referral_button" rel="nofollow" href="{$base_dir}referral.php">Tell a friend</a></li>
            {else}
            	<li><a href="{$base_dir}authentication.php?back=index.php" rel="nofollow">Login/Register</a></li>
            {/if}
            <li><a href="{$base_dir}clubv.php" rel="nofollow">Club V</a></li>
            <li><a class="lnk_shopping_bag {if $cart_qties != 0}hidden{/if}" href="{$base_dir}order.php" rel="nofollow">My Shopping Bag</a></li>
        </ul>
        <ul>
            <li><strong>Security and Privacy</strong></li>
            <li><a href="{$base_dir}security.php" {if !isset($follow_footerlinks)}rel="nofollow"{/if}>Security</a></li>
            <li><a href="{$base_dir}privacy.php" {if !isset($follow_footerlinks)}rel="nofollow"{/if}>Privacy Policy</a></li>
            <li><a href="{$base_dir}terms.php" {if !isset($follow_footerlinks)}rel="nofollow"{/if}>Terms and Conditions</a></li>
        </ul>
        <ul style="" class="payment-logos right">
            <li><b>We Accept</b></li>
            <li>
            	<img data-href="{$img_ps_dir}payment-banner.png" alt="payment gateway" width="222" height="72" style="margin:7px 0px;" class="lazy"/>
            	<noscript>
            	<img src="{$img_ps_dir}payment-banner.png" alt="payment gateway" width="222" height="72" style="margin:7px 0px;" />
            	</noscript>
            </li>
            <li style="text-align: right"><b>And Cash On Delivery</b></li>
		</ul>

    </div>

    <div class="follow-us right" style="display:none">
    	<p class="left snetwork"></p>
    	<div class="append left"><strong>Follow us on:</strong></div>
    	<a href="" class="icon-facebook"></a>
    	<a href="" class="icon-twitter"></a>
    </div>
    <div id="copyright" style="clear:both;">&copy;  All rights reserved.</div>
	</div>
	{literal}
	<script type="text/javascript">
		adroll_adv_id = "WU73JCHMIRH4ZOCGOQUWUE";
		adroll_pix_id = "62UYB34GCBG5HEVPPCDS6F";
		(function () {
		var oldonload = window.onload;
		window.onload = function(){
		   __adroll_loaded=true;
		   var scr = document.createElement("script");
		   var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
		   scr.setAttribute('async', 'true');
		   scr.type = "text/javascript";
		   scr.src = host + "/j/roundtrip.js";
		   ((document.getElementsByTagName('head') || [null])[0] ||
		    document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
		   if(oldonload){oldonload()}};
		}());
	</script>
	{/literal}
</div>

