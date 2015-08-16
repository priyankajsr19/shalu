<?php
include(dirname(__FILE__).'/config/config.inc.php');

//will be initialized bellow...
if(intval(Configuration::get('PS_REWRITING_SETTINGS')) === 1)
	$rewrited_url = null;

include(dirname(__FILE__).'/init.php');
include(dirname(__FILE__).'/header.php');
?>
<div style="width:980px;padding:0px;">
    <h1 style="padding: 10px;border-bottom:1px dashed #cacaca">WELCOME DISCOUNT VOUCHERS</h1>
    <h2>How do I receive my USD 100 vouchers for IndusDiva?</h2>
    <p style="padding:10px;">When you register with your e-mail or with your facebook account, you will get vouchers and Diva Coins in your account. You can access the voucher codes in My Account section. You can use the vouchers for all products available at IndusDiva</p>
	<h2>Please read the terms to redeem these vouchers:</h2>
    <ol style="list-style-type:decimal;padding:10px;">
        <li>15 USD Voucher, valid on orders above USD 100, valid for 30 days from registration</li>
        <li>30 USD Voucher, valid on orders above USD 200, valid for 60 days from registration</li>
        <li>55 USD Voucher, valid on orders above USD 300, valid for 90 days from registration</li>
        <li>You can use one voucher in a single order.</li>
	<li>Order value limit excludes shipping and customization charges.</li>
	<li>You can use the vouchers for all products at IndusDiva.</li>
    </ol>
    
</div>
<?php
include(dirname(__FILE__).'/footer.php');
?>
