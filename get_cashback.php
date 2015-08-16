<?php

include(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');

$value = Tools::getValue('value');
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 30 Apr 2015 23:59:59 GMT"); // Date in the past
header('content-type:image/png');
$cbImage = Tools::createCbImage($value);
readfile("img/" . $cbImage); exit;

?>
