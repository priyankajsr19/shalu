<?php

define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');
include(PS_ADMIN_DIR.'/functions.php');

$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('select email from ps_customer where newsletter = 0');

/*$res = array( 
                array('email'=>'venugopal.annamaneni@violetbag.com'),
		array('email'=>'lekshmi.gopinathan@violetbag.com')
        );

//echo "<pre>"; print_r( $res ); exit;*/



$count = 0;
foreach($res as $row)
{
	if(++$count > 0){ 

		$mailTo = $row['email'];
		$templateVars = array();
		$subject = "25% Off & A free kurti on every purchase";
		$firstname = null;
		@Mail::Send(1, '2012', $subject, $templateVars,$mailTo , $firstname, 'care@indusdiva.com', 'Indusdiva.com', NULL, NULL, _PS_MAIL_DIR_, false);
		echo "".$count." : ".$mailTo."\n";
    		usleep(200000);
	}
}

/*
$count = 0;
foreach($res as $row)
{
	if(++$count > 0){ 

		$mailTo = $row['email'];
		$idCustomer = $row['id_customer'];
            
		$couponCode = "" . $idCustomer . '35PON500';

		// create discount
		$languages = Language::getLanguages($order);
		$voucher = new Discount();
		$voucher->id_discount_type = 1;
		foreach ($languages as $language)
			$voucher->description[$language['id_lang']] = "35% off on USD 500 and above"; // coupon description
		$voucher->value = (float) 35; // coupon value
		$voucher->name = $couponCode;
		$voucher->id_customer = $idCustomer;
		$voucher->id_currency = 2; //USD
		$voucher->quantity = 10;
		$voucher->quantity_per_user = 10;
		$voucher->cumulable = 0;
		$voucher->cumulable_reduction = 1;
		$voucher->minimal = (float) 500; // min order value
		$voucher->active = 1;
		$voucher->cart_display = 1;
		$now = time();
		$voucher->date_from = date('Y-m-d H:i:s', strtotime("06/18/2014 12:00:00"));
		$voucher->date_to = date('Y-m-d H:i:s', strtotime("06/25/2014 23:59:59"));
		if (!$voucher->validateFieldsLang(false) OR !$voucher->add())
			return false;
	
		$templateVars = array('{cname}' => $row['name'], '{ccode}' => $couponCode);
		$subject = "Letter from the CEO";
		@Mail::Send(1, '2012', $subject, $templateVars,$mailTo , $firstname, 'care@indusdiva.com', 'Indusdiva.com', NULL, NULL, _PS_MAIL_DIR_, false);
		echo "".$count." : ".$mailTo."\n";
    		usleep(200000);
	}
}
*/
