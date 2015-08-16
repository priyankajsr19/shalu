<?php

define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');
include(PS_ADMIN_DIR.'/functions.php');

$db = Db::getInstance(_PS_USE_SQL_SLAVE_);

$sql = "select c.email,c.firstname as name, p.balance as coins from ps_customer c join vb_customer_reward_balance p on c.id_customer = p.id_customer";
$to_list = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);

foreach($to_list as $to) {
	$to_email = $to['email'];
	$templateVars = array();
	$templateVars['{name}'] = $to["name"];
	$templateVars['{coins}'] = $to["coins"];
	$subject = "Congratulations, you are a privileged CLUB DIVA member!";
	@Mail::Send(1, 'clubdiva', $subject, $templateVars, $to_email , null, 'care@indusdiva.com', 'Indusdiva.com', NULL, NULL, _PS_MAIL_DIR_, false);
	echo "\n{$to_email}";
	usleep(200000);
} 
?>
