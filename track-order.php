<?php

include(dirname(__FILE__).'/config/config.inc.php');

//will be initialized bellow...
if(intval(Configuration::get('PS_REWRITING_SETTINGS')) === 1)
	$rewrited_url = null;

include(dirname(__FILE__).'/init.php');

include(dirname(__FILE__).'/header.php');
	
$smarty->display(_PS_THEME_DIR_.'trackorder.tpl');
include(dirname(__FILE__).'/footer.php');


?>