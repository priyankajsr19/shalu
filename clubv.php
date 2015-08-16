<?php
include(dirname(__FILE__).'/config/config.inc.php');

//will be initialized bellow...
if(intval(Configuration::get('PS_REWRITING_SETTINGS')) === 1)
	$rewrited_url = null;

include(dirname(__FILE__).'/init.php');
include(dirname(__FILE__).'/header.php');
?>

<div style="width:980px;padding:0px;" class="faq">
	<!--  <img src="img/banners/vbrewards.jpg" />  -->
	<div style="border-bottom:1px dashed #cacaca;margin:10px 0px;padding:10px 0px;float:left;">
		<img src="<?php echo _PS_IMG_?>rewards.png" style="display:block;float:left" height="160"/>
		<div style="display:block;width:810px;float:left;padding:0 10px;">
			<h1 style="font-weight:lighter;font-size:21px;text-transform:none;">Club V - VioletBag loyalty and rewards program</h1>
			<p>
				Welcome to Club I! We are extremely glad that you are a part of the VioletBag family and for all the love you have given us, this is our way of saying thank you. Every time you shop with us or spread some VioletBag love, we credit Violet Coins to your account.
			</p>
			<p>
				Club V is for all you beautyholics out there who believe in splurging on quality. We appreciate that you choose to shop with the best and we believe you need to be rewarded for this tasteful gesture.
			</p>
			<p style="padding-bottom:10px;">
				There is a Violet Coin for almost everything you do under the sun.
			</p>
		</div>
	</div>
	<div style="width:640px;float:left;padding-right:10px;border-right:3px solid #52247F;clear:both;">
		<h2 style="font-weight:lighter;font-size:21px;text-transform:none;margin-bottom:20px;">FAQs - Everything you want to know about Violet Coins</h2>
		<p class="q">
			<b>How much is each coin actually worth?</b>
			5 Violet Coins = Re.1
		</p>
		<p class="q">
			<b>How can I use the Violet Coins to reward myself?</b>
			Violet Coins are a direct cash discount, you can accumulate them and avail cash discounts on all the products displayed on our shelves. You can click on the 'Redeem Violet Coins' link at the checkout page and avail partial or complete discounts. 
		</p>
		<p class="q">
			<b>When can I start redeeming my Violet Coins?</b>
			You can start redeeming your Violet Coins from your third purchase onwards and not prior to that.
		</p>
		<p class="q">
			<b>When do I become eligible for Club V membership?</b>
			As soon as you sign up with us, you become a part of the VioletBag family and the rewards start right there. 
		</p>
		<p class="q">
			<b>I am an already existent user; do I lose out on the registration and previous purchase coins?</b>
			Of course not, all existing users would get coins credited to their accounts based on their shopping so far, right from the beginning of the world! 
		</p>
		<p class="q">
			<b>Can I save and accumulate my Violet Coins?</b>
			Of course yes, you can save them for the future and redeem them whenever you wish to.
		</p>
		
	</div>
	<div style="width:300px;float:left;margin-left:20px;">
		
		<table style="border-collapse: collapse;border-spacing: 0;width:100%" id="loyalty-activities" class="std">
		<thead>
			<tr style="border-bottom: 1px dashed #cacaca;padding:5px 0">
				<th style="font-size:14px;text-align:left;text-transform:none;width:80%">Activity</th>
				<th style="font-size:14px;text-align:center;text-transform:none;width:20%">Coins</th>
			</tr>
		</thead>
		<tbody>
			<tr class="first_item">
				<td>Sign-Up/Registration</td>
				<td style="text-align:right;">250</td>
			</tr>
			<tr class="alternate_item">
				<td>Purchase of every Rs 100</td>
				<td style="text-align:right;">10</td>
			</tr>
			<tr class="">
				<td>First Purchase Bonus</td>
				<td style="text-align:right;">100</td>
			</tr>
			<tr class="alternate_item">
				<td>Purchase Bonus Rs 1000</td>
				<td style="text-align:right;">100</td>
			</tr>
			<tr class="">
				<td>Purchase Bonus Rs 2500</td>
				<td style="text-align:right;">250</td>
			</tr>
			<tr class="alternate_item">
				<td>Purchase Bonus Rs 5000</td>
				<td style="text-align:right;">500</td>
			</tr>
			<tr class="">
				<td>Each Approved Review (up to 100 reviews)</td>
				<td style="text-align:right;">25</td>
			</tr>
			<tr class="alternate_item">
				<td>First Approved Review Bonus</td>
				<td style="text-align:right;">50</td>
			</tr>
			<tr class="">
				<td>Facebook Like a Product (up to 250 products)</td>
				<td style="text-align:right;">2</td>
			</tr>
			<tr class="alternate_item">
				<td>Google Plus Button click (up to 250 products)</td>
				<td style="text-align:right;">2</td>
			</tr>
			<tr class="">
				<td>First purchase by an invited friend</td>
				<td style="text-align:right;">1000</td>
			</tr>
			<tr class="alternate_item">
				<td>10 friends (first) purchase bonus</td>
				<td style="text-align:right;">5000</td>
			</tr>
			<tr class="">
				<td>25 friends (first) purchase bonus</td>
				<td style="text-align:right;">10000</td>
			</tr>
			<tr class="last_item alternate_item">
				<td>Online Payment Bonus</td>
				<td style="text-align:right;">100</td>
			</tr>
		</tbody>
		</table>
	</div>
	<div style="clear:both;">
		<p class="q">
			<b>Can I club my Violet Coins with a voucher/coupon or any other offer?</b>
			Yes you can, during checkout you will have the option to use either or both of the coupon and the Violet Coins. You can also opt for partial redemption in which you use just few of your coins.
		</p>
		<p class="q">
			<b>Will my coins expire after a limited number of days?</b>
			No, you can accumulate Violet Coins for life; they come with a NO EXPIRY label.
		</p>
		<p class="q">
			<b>Do I earn coins if I choose Online Payment over Cash on Delivery?</b>
			Yes, you earn 100 bonus coins every single time you pay online while placing an order. 
		</p>
		<p class="q">
			<b>Do I earn coins for every product review I write? Is there a limit?</b>
			Yes, you earn 25 coins for every approved product review. Your review will be approved if it matches our simple review guideline. You can accumulate up to 2500 coins through reviews and not more, though you are still free to help other buyers by penning down more reviews.
		</p>
		<p class="q">
			<b>What about Facebook and Google+ likes? Is there a limit?</b>
			Yes, you can accumulate a maximum of 500 coins on Facebook Likes and 500 coins on Google+.
		</p>
		<p class="q">
			<b>Do I get rewarded for every invite I send out to my friends?</b>
			You get rewarded every time a friend accepts your invite, registers and shops for the first time at VioletBag.com. There are no rewards for sending an invite or getting your friends to sign up. However, all of your friends do get 250 coins when they sign up!  
		</p>
		<p class="q">
			<b>How can I track the number of coins I have accumulated?</b>
			You can log into your VioletBag account and view your coins by clicking on the 'My Violet Coins' tab. 
		</p>
		<p class="q">
			<b>I have two VioletBag accounts; can I transfer my coins from one to the other?</b>
			We are sorry but Violet Coins are non-transferable. 
		</p>
		<p class="q">
			<b>Can I use my coins for cash redemption?</b>
			No, coins can only be redeemed against your favorite products you pick from the VioletBag shelves; you cannot use it for cash redemption.
		</p>
		<p class="q">
			<b>Is there a minimum redemption value for my coins?</b>
			Yes, you need to redeem a minimum of 100 coins in one go. 
		</p>
		<p class="q">
			<b>So do I get my Violet Coins credited right after my purchase?</b>
			To make the process hassle free and smooth, your coins will be credited once your order has been delivered. Sometimes, it may take up to 24 hours for the coins to get updated after delivery of orders. 
		</p>
		<p class="q">
			<b>When I use a voucher for my purchase do I get my coins based on the purchase amount or the final discounted amount?</b>
			Violet Coins are awarded only on the basis of the final amount you end up paying for an order. 
		</p>
		<p class="q">
			<b>I have more questions. What do I do?</b>
			Please write to us at care@violetbag.com and we will take care of all your queries.
		</p>
	</div>
</div>

<?php
include(dirname(__FILE__).'/footer.php');
?>
