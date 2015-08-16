<?php
include(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');


$idCustomer = 10080;

var_dump (Tools::addCoupons($idCustomer));

?>
