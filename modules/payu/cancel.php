<?php 
 
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
include(dirname(__FILE__).'/payu.php');
include(dirname(__FILE__).'/../../header.php');

 $response=$_REQUEST;
 $id_order=base64_decode($response['id']); 

$history = new OrderHistory();
$history->id_order = (int)($id_order);
$history->changeIdOrderState(Configuration::get('PS_OS_CANCELED'), (int)($id_order));
$history->add();

$baseUrl=Tools::getShopDomain(true, true).__PS_BASE_URI__;	
$smarty->assign('baseUrl',$baseUrl);
$smarty->assign('orderId',$id_order);

$smarty->display('cancel.tpl');

include(dirname(__FILE__).'/../../footer.php');
?>