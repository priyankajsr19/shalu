<?php
include(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');

$ajax = $_GET['ajax'];
if(!isset($ajax))
	include(dirname(__FILE__).'/header.php');

$client = SolrSearch::getClient();
$query = $client->createSelect();

$p = isset($_GET['p']) ? $_GET['p'] : 1;
$query->setQuery('tags:buy1get1 AND inStock:1');
$query->setRows(40);
$query->setStart(($p-1) * 40);
$nextPage = $p+1;

$orderby = 'date_add';
$way = Solarium_Query_Select::SORT_DESC;

$query->addSort('inStock', Solarium_Query_Select::SORT_DESC);
$query->addSort($orderby, $way);
$results = $client->select($query);
$total_found = $results->getNumFound();
$products = $results->getData();
// echo "<pre>"; print_r( $products ); exit;
$smarty->assign("products", $products['response']['docs']);
$smarty->assign("nbProducts", $products['response']['docs']);
$smarty->assign("nextPage", $nextPage);
$smarty->assign("ajax", isset($ajax) ? 1 : 0);

if(!$ajax)
	$smarty->display(_PS_THEME_DIR_.'buy1-get1.tpl');
else{
	$smarty->assign('lazy', 0);
	$productListContent = $smarty->fetch(_PS_THEME_DIR_ . 'buy1-get1.tpl');
	echo Tools::jsonEncode(array(
                        'productList' => $productListContent,
                        'nextPage' => $nextPage
            ));
}

if(!isset($ajax))
	include(dirname(__FILE__).'/footer.php');
?>
