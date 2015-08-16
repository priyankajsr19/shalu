<?php
include(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');
include(dirname(__FILE__).'/header.php');

$top_categories = array(
                        array(2,'sarees','Sarees'),
                        array(3,'salwar-kameez','Salwar Kameez'),
                        array(1202,'tops','Tops'),
                        array(5,'lehenga','Lehenga Choli'),
                        array(454,'jewelry','Jewelery'),
                        array(450,'indusdiva-pick','Exclusive Designs')
                    );

$cat_products = array();
foreach($top_categories as $category) {
    $category_name = $category[2];
    $category_link = $category[1];
    $id_category = $category[0];

    if( !is_array($cat_products[$category_name]) ) {
        $cat_products[$category_name] = array();
        $cat_products[$category_name]["more_link"] = "$id_category-$category_link#express_shipping=0&sale=0&latest=0&id_category_layered={$id_category}&orderby=new&orderway=desc";
    }
    
    $client = SolrSearch::getClient();
    $query = $client->createSelect();
    
    $query->setQuery('cat_id:' . $id_category);
    $query->setRows(10);
    $query->setStart(0);

    $orderby = 'date_add';
    $way = Solarium_Query_Select::SORT_DESC;

    $query->addSort('inStock', Solarium_Query_Select::SORT_DESC);
    $query->addSort($orderby, $way);

    $results = $client->select($query);
    
    $total_found = $results->getNumFound();
    $products = $results->getData();
    $cat_products[$category_name]['products'] = $products['response']['docs'];
}
//echo "<pre>"; print_r( $cat_products ); exit;
$smarty->assign("whats_new_products",$cat_products);
$smarty->display(_PS_THEME_DIR_.'whats-new.tpl');

include(dirname(__FILE__).'/footer.php');
?>
