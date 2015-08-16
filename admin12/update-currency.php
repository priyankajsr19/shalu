<?php
define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');
include(PS_ADMIN_DIR.'/functions.php');
echomsg("Start Updating Currency Conversion Rates");
try {
	$curr_list = file_get_contents("http://openexchangerates.org/api/latest.json?app_id=c8cbe15270254f4686d6b3f3a7a2af89");
	$curr = Tools::jsonDecode($curr_list);
  
	if( strtoupper((string)$curr->base) === 'USD') {
                $update_clause = array();
                $rates = $curr->rates;
		$currencies = CurrencyCore::getCurrencies(false,0);
                foreach($currencies as $currency) {
                    $iso_code = $currency['iso_code'];
                    $this_rate = number_format((float)$rates->$iso_code, 2, '.', '');
                    array_push($update_clause, "WHEN iso_code = '$iso_code' THEN '$this_rate'");
                }
                $sql = "update ps_currency set conversion_rate = CASE ";
                $sql .= implode(" ", $update_clause);
                $sql .= " END";
                Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);
                echomsg("All Currencies Conversions Updated Successfully");
	} else {
		echomsg("Base Currency not in US", true);
	}
} catch(Exception $ex) {
	echomsg('Unable to retrieve currency conversion list', true);
	
}

function echomsg($message, $alert=false) {
	$tnow = date('Y-m-d H:i:s');
	echo "\n$tnow - $message";
	if($alert) {
                $event = 'Currency Conversion Rates Update Failed';
		$templateVars = array();
		$templateVars['{event}'] = $event;
		$templateVars['{description}'] = $message;
		$to_email = array('venugopal.annamaneni@violetbag.com','vineet.saxena@violetbag.com','ramakant.sharma@violetbag.com'); 
		@Mail::Send(1, 'alert', $event, $templateVars, $to_email , null, 'care@indusdiva.com', 'Indusdiva.com', NULL, NULL, _PS_MAIL_DIR_, false);
	}
}
?>
