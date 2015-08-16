{* <!-- /MODULE Block various links --> *}
{literal}
<div style="text-align:center;" class="clearfix">
	<div style="width:100%; float:left; margin-top:45px; text-align:center">
		<span style="display:inline-block; overflow:hidden; width:470px;"><img alt="Its safe shopping with us. Accepting PayPal, Visa, MasterCard and American Express. 128 bit SSL secured" src="{/literal}{$img_ps_dir}{literal}banners/safe-payments-options.jpg" /></span>
		<span style="display:inline-block; width:135px;">
			<script type="text/javascript" src="https://seal.verisign.com/getseal?host_name=www.indusdiva.com&amp;size=L&amp;use_flash=YES&amp;use_transparent=YES&amp;lang=en"></script>
		</span>
	</div>
</div>
{/literal}
<div id="footer_wrapper">
    <div class="footer">
		<div class="footer-links" style="clear: both; padding: 20px 0px; float: left;">
	        <ul>
	            <li><strong>Company Information</strong></li>
	            <li><a href="{$base_dir}about-us.php">About us</a></li>
	            <li><a href="{$base_dir}contact-us.php">Contact Us</a></li>
	            <li><a href="{$base_dir}careers.php" {if !isset($follow_footerlinks)}rel="nofollow"{/if}>Careers</a></li>
	        </ul>
	        <ul>
	            <li><strong>Need Help?</strong></li>
	            <li><a href="{$base_dir}faqs.php" {if !isset($follow_footerlinks)}rel="nofollow"{/if}>FAQs</a></li>
	            <li><a href="{$base_dir}shipping-policy.php" {if !isset($follow_footerlinks)}rel="nofollow"{/if}>Shipping Policy</a></li>
	            <li><a href="{$base_dir}return-policy.php" {if !isset($follow_footerlinks)}rel="nofollow"{/if}>Return Policy</a></li>
                <li><a href="{$base_dir}content/10-cancellation-policy" {if !isset($follow_footerlinks)}rel="nofollow"{/if}>Cancellation Policy</a></li>
	            <li><a href="{$base_dir}history.php" rel="nofollow">Track Your Order</a></li>
	            <li><a href="{$base_dir}sitemaps/">Popular Searches</a></li>
                    <li><a href="{$base_dir}gift-cards.php">Gift Cards</a></li>
		    <li><a href="{$base_dir}content/26-buy-one-get-one-free">TnC - Buy1,Get1</a></li>
	        </ul>
	        <ul>
	            <li><strong>My Account</strong></li>
	            {if $cookie->isLogged()}
	            	 <li><a href="{$base_dir}history.php" rel="nofollow">My Account</a></li>
	            	 {*<li><a id="referral_button" rel="nofollow" href="{$base_dir}referral.php">Tell a friend</a></li>*}
	            {else}
	            	<li><a href="{$base_dir}authentication.php?back=index.php" rel="nofollow">Login/Register</a></li>
	            {/if}
	            <li><a class="lnk_shopping_bag {if $cart_qties != 0}hidden{/if}" href="{$base_dir}order.php" rel="nofollow">My Shopping Bag</a></li>
                <li><a href="{$base_dir}idrewards.php">Club Diva</a></li>
                <li><a href="{$base_dir}discount-terms.php">Discounts</a></li>
	        </ul>
	        <ul>
	            <li><strong>Security and Privacy</strong></li>
	            <li><a href="{$base_dir}security.php" {if !isset($follow_footerlinks)}rel="nofollow"{/if}>Security</a></li>
	            <li><a href="{$base_dir}privacy.php" {if !isset($follow_footerlinks)}rel="nofollow"{/if}>Privacy Policy</a></li>
	            <li><a href="{$base_dir}terms.php" {if !isset($follow_footerlinks)}rel="nofollow"{/if}>Terms and Conditions</a></li>
	        </ul>
	        <ul>
	            <li><strong>Why Choose Us?</strong></li>
	            <li>24x7 Customer Support</li>
	            <li>On-time deliveries</li>
	            <li>Custom tailoring services</li>
	            <li>Eclectic and curated ethnic-wear collection</li>
	            <li>Easy return policy</li>
	            <li>Free shipping world-wide (over $100)</li>
	            <li>Design studio services</li>
	        </ul>
    	</div>
    	
    <div id="copyright" style="clear:both;">&copy;  All rights reserved.</div>
	</div>
</div>

