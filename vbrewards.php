<?php
include(dirname(__FILE__) . '/config/config.inc.php');

//will be initialized bellow...
if (intval(Configuration::get('PS_REWRITING_SETTINGS')) === 1)
    $rewrited_url = null;

include(dirname(__FILE__) . '/init.php');
include(dirname(__FILE__) . '/header.php');

$activity_Coins = array(
    "First Purchase Bonus" => 10,
    "Purchase Bonus 150 USD" => 10,
    "Purchase Bonus 250 USD" => 20,
    "Purchase Bonus 500 USD" => 30,
    "Purchase Bonus 750 USD" => 50,
    "Purchase Bonus 1000 USD" => 100,
    "Purchase Bonus 1500 USD" => 150,
    "Refer a friend and both will receive the Coins (on purchase by friend)" => 50,
    "10 friends referred in 1 year (all made purchases)" => 200,
    "Order Feedback" => 10,
    "Each Approved Review (one per product)" => 5,
    "Share Order products on Facebook" => 10,
    "Google Plus Button click (up to 25 products)" => 1,
    "Facebook Like a Product (up to 25 products)" => 1,
    "Facebook like of Indusdiva page" => 10,
    "Total purchase value in a rolling 12 months window is more than or equal to 5000 USD (Free shipping bar will be reduced to 100 USD per order)" => 500
);
?>

<div style="width:980px;padding:0px;" class="faq">
    <img src="http://<?php echo _MEDIA_SERVER_1_; ?>/img/banners/ClubDiva_Banner.jpg" />
    <div style="border-top:1px dashed #cacaca;border-bottom:1px dashed #cacaca;margin:10px 0px;padding:10px 0px;float:left;">
        <img src="http://<?php echo _MEDIA_SERVER_1_; ?>/img/ClubDiva_Box.jpg" style="display:block;float:left" height="160"/>
        <div style="display:block;width:810px;float:left;padding:0 10px;">
            <h1 style="font-weight:lighter;font-size:21px;text-transform:none;">Club Diva - IndusDiva loyalty and rewards program</h1>
            <p>
                Welcome to our exclusive Club Diva- Loyalty and Rewards Program. Your one stop Diva corner for
                everything Divalicious. We are absolutely in love with our tasteful divas who love to pick up the finest of
                attire, you are synonymous with our name and we are glad you are a part of our family. So what best to
                commemorate this love than joining in to form an exclusive Club. We know you believe in splurging on
                quality and finesse and our Club appreciates this tasteful gesture. Every time you shop with us and set
                your own classy statement, we make sure that you get added benefits to shop some more and more.
                For every action showing your love for IndusDiva, we show some love too and add in a chunk of Coins to
                your Diva Bag.
            </p>
            <p style="padding-bottom:10px;">
                There is a Coin for almost everything you do under the sun.
            </p>
        </div>
    </div>
    <div style="width:640px;float:left;padding-right:10px;border-right:3px solid #a41e21;clear:both;">
        <h2 style="font-weight:lighter;font-size:21px;text-transform:none;margin-bottom:20px;">FAQs - Everything you want to know about Coins</h2>
        <p class="q">
            <b>How much is each coin actually worth?</b>
            5 Coins = 1 USD
        </p>
        <p class="q">
            <b>How can I use the Coins to reward myself?</b>
            Coins are a direct cash discount, you can accumulate them and avail cash discounts on all the products displayed in our closet.You can click on the 'Redeem Coins' link at the checkout page and avail partial or
            complete discounts.
        </p>
        <p class="q">
            <b>When can I start redeeming my Coins?</b>
            You can start redeeming your Coins from your second purchase at IndusDiva, the order value should be more than 100 USD.
        </p>
        <p class="q">
            <b>When do I become eligible for IndusDiva Reward Program?</b>
            As soon as you signup with us, you become a part of the IndusDiva family and the reward starts right there.
        </p>
        <p class="q">
            <b>I am an already existent user; do I lose out on the registration and previous purchase Coins?</b>
            Of course not, all existing users would get Coins credited to their accounts based on their shopping so far,right from the beginning of the world!
        </p>
        <p class="q">
            <b>Can I save and accumulate my Coins?</b>
            Of course yes, you can save them for the future and redeem them whenever you wish to.
        </p>
        <p class="q">
            <b>Can I club my Coins with a voucher/coupon or any other offer?</b>
            Yes you can, during checkout you will have the option to use either or both of the coupon and the Coins. You can also opt for partial redemption in which you use just few of your Coins.
        </p>
        <p class="q">
            <b>Will my Coins expire after a limited number of days?</b>
            No, you can accumulate Coins for life; they come with a NO EXPIRY label.
        </p>
        <p class="q">
            <b>Do I get Coins for my first order purchase?</b>
            Yes, you get 50 Coins for your first order purchase.
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
                    <?php
                    $cookie = new Cookie('ps');
                    if ($cookie->isLogged(true)) {
                        echo '<td>Sign-Up/Registration</td>';
                    } else {
                        echo '<td><a rel="nofollow" id="login_link" class="fancybox login_link" href="#login_modal_panel">Sign-Up/Registration</a> </td>';
                    }
                    ?>
                    <td> 50 </td>
                </tr>
                <?php
                $i = 2;
                $count = count($activity_Coins);
                foreach ($activity_Coins as $activity => $Coins) {
                    $class = '';
                    if ($i == 1)
                        $class = " first_item";
                    if ($i == $count)
                        $class .= ' last_item';
                    if ($i % 2 == 0)
                        $class .= ' alternate_item';
                    echo '<tr class=".' . $class . '">';
                    echo "<td> {$activity} </td>";
                    echo "<td> {$Coins} </td>";
                    echo "</tr>";
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
    <div style="clear:both;">
        <p class="q">
            <b>What about my order value? Does my order value get me bonus Coins?</b>
            Absolutely yes, for every order above 150 USD you get 10 Coins. Apart from that for every order above
            250 USD you get bonus 20 Coins more and for the ones above 500 USD, 30 more Coins.
        </p>
        <p class="q">
            <b>Do I earn Coins for every product review I write? Is there a limit?</b>
            Yes, you earn 5 Coins for every approved product review. Your review will be approved if it matches
            our simple review guideline. You can accumulate up to 125 Coins through reviews and not more, though
            you are still free to help other buyers by penning down more reviews.
        </p>
        <p class="q">
            <b>Do I get rewarded for liking the IndusDiva Page on Facebook?</b>
            Yes of course, you get a onetime 10 Coins for liking the IndusDiva Brand Page on Facebook.
        </p>
        <p class="q">
            <b>What about Facebook shares/likes and Google+ likes? Is there a limit?</b>
            Yes, you will be rewarded with 1 Coin for every like and share. You can share. You can accumulate a maximum of 25
            Coins on Facebook shares/likes and 25 Coins on Google+.
        </p>
        <p class="q">
            <b>What if I share my ordered products on Facebook?</b>
            We would love you to do that and yes, you get 10 Coins for sharing the Ordered Products on Facebook Page.
        </p>
        <p class="q">
            <b>Do I get rewarded for every invite I send out to my friends?</b>
            You get rewarded every time a friend accepts your invite, registers and shops for the first time at
            IndusDiva.com. There are no rewards for sending an invite or getting your friends to sign up. However,
            all of your friends do get 50 Coins when they sign up!
        </p>
        <p class="q">
            <b>What about when my friends shop on IndusDiva?</b>
            Yes, you get buddy brownie Coins and that would be 50 Coins.
        </p>
        <p class="q">
            <b>What about Order Feedbacks?</b>
            That would be 10 Coins for every completed Order Feedback Form.
        </p>
        <p class="q">
            <b>How can I track the number of Coins I have accumulated?</b>
            You can log into your IndusDiva account and view your Coins by clicking on the 'My Coins' tab.
        </p>
        <p class='q'>
            <b>I have two IndusDiva accounts; can I transfer my Coins from one to the other?</b>
            No, Coins can only be redeemed against your favorite apparel you pick from IndusDiva; you cannot use it
            for cash redemption.
        </p>
        <p class='q'>
            <b> Is there a minimum redemption value for my Coins? </b>
            No, there is no minimum limit for Coin redemption.
        </p>
        <p class='q'>
            <b>So do I get my Coins credited right after my purchase?</b>
            To make the process hassle free and smooth, your Coins will be credited once your order has been
            delivered. Sometimes, it may take up to 24 hours for the Coins to get updated after delivery of orders.
        </p>
        <p class='q'>
            <b>When I use a voucher for my purchase do I get my Coins based on the purchase amount or the final
                discounted amount?</b>
            Coins are awarded only on the basis of the final amount you end up paying for an order.
        </p>
        <p class='q'>
            <b>The Ultimate Club Diva Offer?</b>
            If you purchase products worth 5000 USD or more from IndusDiva in 12 months then you will be eligible
            for 500 Coins and free shipping for orders above 100 USD.
        </p>
        <p class='q'>
            <b>I have more questions. What do I do?</b>
            Please write to us at care@indusdiva.com and we will take care of all your queries.
        </p>
    </div>
</div>

<?php
include(dirname(__FILE__) . '/footer.php');
?>
