<?php
/**
 * EBS payment module thank-you page
 *

 * 
 */


/* SSL Management */
$useSSL = true;

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../header.php');
include(dirname(__FILE__).'/EBS.php');

$DR=$_GET['DR'];
$obj=new EBS();
$obj->finalizeOrder($DR);

$smarty->display(dirname(__FILE__).'/thank-you.tpl');

include(dirname(__FILE__).'/../../footer.php');	

?>
