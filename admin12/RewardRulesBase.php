<?php

define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');
include(PS_ADMIN_DIR.'/functions.php');

echo "test";
$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("SELECT id_product, price from ps_product where active = 1");