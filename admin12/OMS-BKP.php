<?php


define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');
include(PS_ADMIN_DIR.'/functions.php');
require_once(dirname(__FILE__).'/init.php');
//include(PS_ADMIN_DIR.'/header.inc.php');
@ini_set('max_execution_time', 0);

if(Tools::getValue('getSalesData'))
{
    $date_from = Tools::getValue('orders_from');
    $date_to = Tools::getValue('orders_to');
    //products delivery
    $sql_products_delivery = "SELECT 
        DATE(o.`date_add`) AS 'Date Order',
        DATE(oh.date_add) AS 'Date Delivery',
        o.`invoice_number` AS 'invoice ID',
        o.id_order AS 'Order ID',
        o.id_cart AS 'Cart ID',
        od.`product_id` AS 'ProductID',
        od.`product_name` AS 'Product NAME',
        od.product_reference AS 'Product Code',
        od.`product_quantity` AS 'Quantity',
        round(od.`product_price` * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`) AS 'MRP',
        round(p.`wholesale_price` * 55 ) AS 'Sourcing Price',
        (round((IF(od.reduction_percent > 0, od.`product_price`*(1-od.reduction_percent/100), 
            IF(od.`reduction_amount` > 0, od.`product_price` - od.reduction_amount, od.product_price)))* (1+(od.`tax_rate`/100))) * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`)  AS 'Offer Price',
        round(od.`tax_rate`, 2) AS 'Product Tax',
        o.`payment` AS 'Payment Method',
        ((o.`total_products` * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`)) AS 'Total Pretax',
        (o.`total_discounts` * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`)  AS 'Discounts',
        ((o.`total_products_wt` - o.`total_products`) * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`) AS 'Tax',
        (o.`total_shipping` * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`) AS 'Shipping',
        ((o.`total_paid`+o.`total_discounts`) * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`) AS 'Order Total',
        (round(o.`total_paid_real`) * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`) AS 'Total Paid',
        o.`conversion_rate` AS 'Conversion Rate',
        (SELECT osl.name 
            FROM `ps_order_state_lang` osl
            INNER JOIN `ps_order_history` ioh ON ioh.id_order_state = osl.id_order_state 
            WHERE ioh.id_order_history = (SELECT max(id_order_history) FROM ps_order_history WHERE id_order = o.id_order)) AS 'Current State',
        s.name AS 'Country',
        a.`city` AS 'City',
        cr.name AS 'Carrier',
        DATE(o.actual_expected_shipping_date) as 'Promised Shipping Date',
        DATE(ohs.date_add) as 'Date Shipped'
        FROM ps_orders o
        INNER JOIN `ps_order_detail` od ON o.id_order = od.`id_order`
        INNER JOIN `ps_order_history` oh ON (oh.`id_order` = o.`id_order`)
        INNER JOIN `ps_order_history` ohs ON (ohs.`id_order` = o.`id_order` and ohs.id_order_state = 4)
        INNER JOIN ps_customer c ON c.`id_customer` = o.`id_customer`
        INNER JOIN ps_address a ON a.`id_address` = o.`id_address_delivery`
        INNER JOIN `ps_country_lang` s ON s.`id_country` = a.id_country
        INNER JOIN `ps_carrier` cr ON cr.`id_carrier` = o.`id_carrier`
        INNER JOIN `ps_product` p ON p.`id_product` = od.`product_id` 
        LEFT JOIN `ps_currency_rates` pr ON date(pr.`day`) = date(o.`date_add`)
        WHERE oh.id_order_state = 5
        AND oh.`date_add` BETWEEN '" . $date_from ."' AND '" . $date_to ."'
        GROUP BY od.`id_order_detail`, o.id_order";

    //products invoice
    $sql_products_invoice = "SELECT 
        DATE(o.`date_add`) AS 'Date Order',
        o.`invoice_number` AS 'invoice ID',
        o.id_order AS 'Order ID',
        o.id_cart AS 'Cart ID',
        od.`product_id` AS 'ProductID',
        od.`product_name` AS 'Product NAME',
        od.product_reference AS 'Product Code',
        od.`product_quantity` AS 'Quantity',
        round(p.`wholesale_price` * 55 ) AS 'Sourcing Price',
        round(od.`product_price` * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`) AS 'MRP',
        (round((IF(od.reduction_percent > 0, od.`product_price`*(1-od.reduction_percent/100), 
            IF(od.`reduction_amount` > 0, od.`product_price` - od.reduction_amount, od.product_price)))* (1+(od.`tax_rate`/100))) * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`)  AS 'Offer Price',
        round(od.`tax_rate`, 2) AS 'Product Tax',
        o.`payment` AS 'Payment Method',
        ((o.`total_products` * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`)) AS 'Total Pretax',
        (o.`total_discounts` * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`)  AS 'Discounts',
        ((o.`total_products_wt` - o.`total_products`) * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`) AS 'Tax',
        (o.`total_shipping` * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`) AS 'Shipping',
        ((o.`total_paid`+o.`total_discounts`) * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`) AS 'Order Total',
        (round(o.`total_paid_real`) * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`) AS 'Total Paid',
        o.`conversion_rate` AS 'Conversion Rate',
        (SELECT osl.name 
            FROM `ps_order_state_lang` osl
            INNER JOIN `ps_order_history` ioh ON ioh.id_order_state = osl.id_order_state 
            WHERE ioh.id_order_history = (SELECT max(id_order_history) FROM ps_order_history WHERE id_order = o.id_order)) AS 'Current State',
        s.name AS 'Country',
        a.`city` AS 'City',
        cr.name AS 'Carrier'
        FROM ps_orders o
        INNER JOIN `ps_order_detail` od ON o.id_order = od.`id_order`
        INNER JOIN `ps_order_history` oh ON (oh.`id_order` = o.`id_order`)
        INNER JOIN ps_customer c ON c.`id_customer` = o.`id_customer`
        INNER JOIN ps_address a ON a.`id_address` = o.`id_address_delivery`
        INNER JOIN `ps_country_lang` s ON s.`id_country` = a.id_country
        INNER JOIN `ps_carrier` cr ON cr.`id_carrier` = o.`id_carrier` 
        INNER JOIN `ps_product` p ON p.`id_product` = od.`product_id` 
        LEFT JOIN `ps_currency_rates` pr ON date(pr.`day`) = date(o.`date_add`)
        WHERE o.valid = 1
        AND o.`date_add` BETWEEN '" . $date_from ."' AND '" . $date_to ."'
        GROUP BY od.`id_order_detail`, o.id_order";

    //orders delivery
    $sql_orders_delivery = "SELECT 
        DATE(o.`date_add`) AS 'Date Order',
        DATE(oh.date_add) AS 'Date Delivery',
        DATE(ohs.date_add) AS 'Date Shipped',
        o.`invoice_number` AS 'invoice ID',
        o.id_order AS 'Order ID',
        o.id_cart AS 'Cart ID',
        o.`payment` AS 'Payment Method',
        ((o.`total_products` * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`)) AS 'Total Pretax',
        (o.`total_discounts` * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`)  AS 'Discounts',
        ((o.`total_products_wt` - o.`total_products`) * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`) AS 'Tax',
        (o.`total_shipping` * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`) AS 'Shipping',
        ((o.`total_paid`+o.`total_discounts`) * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`) AS 'Order Total',
        (round(o.`total_paid_real`) * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`) AS 'Total Paid',
        o.`conversion_rate` AS 'Conversion Rate',
        (SELECT osl.name 
            FROM `ps_order_state_lang` osl
            INNER JOIN `ps_order_history` ioh ON ioh.id_order_state = osl.id_order_state 
            WHERE ioh.id_order_history = (SELECT max(id_order_history) FROM ps_order_history WHERE id_order = o.id_order)) AS 'Current State',
        s.name AS 'Ship Country',
        b.name AS 'Bill Country',
        a.`city` AS 'City',
        cr.name AS 'Carrier',
        DATE(o.actual_expected_shipping_date) as 'Promised Shipping Date',
	c.email AS 'Email'
        FROM ps_orders o
        INNER JOIN `ps_order_detail` od ON o.id_order = od.`id_order`
        INNER JOIN `ps_order_history` oh ON (oh.`id_order` = o.`id_order`)
        INNER JOIN `ps_order_history` ohs ON (ohs.`id_order` = o.`id_order` and ohs.id_order_state = 4)
        INNER JOIN ps_customer c ON c.`id_customer` = o.`id_customer`
        INNER JOIN ps_address a ON a.`id_address` = o.`id_address_delivery`
        INNER JOIN `ps_country_lang` s ON s.`id_country` = a.id_country
        INNER JOIN ps_address a1 ON a1.`id_address` = o.`id_address_invoice`
        INNER JOIN `ps_country_lang` b ON b.`id_country` = a1.id_country
        INNER JOIN `ps_carrier` cr ON cr.`id_carrier` = o.`id_carrier` 
        LEFT JOIN `ps_currency_rates` pr ON date(pr.`day`) = date(o.`date_add`)
        WHERE oh.id_order_state = 5
        AND oh.`date_add` BETWEEN '" . $date_from ."' AND '" . $date_to ."'
        GROUP BY o.id_order";

    //orders invoice
    $sql_orders_invoice = "SELECT 
        DATE(o.`date_add`) AS 'Date Order',
        o.`invoice_number` AS 'invoice ID',
        o.id_order AS 'Order ID',
        o.id_cart AS 'Cart ID',
        o.`payment` AS 'Payment Method',
        ((o.`total_products` * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`)) AS 'Total Pretax',
        (o.`total_discounts` * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`)  AS 'Discounts',
        ((o.`total_products_wt` - o.`total_products`) * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`) AS 'Tax',
        (o.`total_shipping` * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`) AS 'Shipping',
        ((o.`total_paid`+o.`total_discounts`) * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`) AS 'Order Total',
        (round(o.`total_paid_real`) * IFNULL(pr.`conversion_rate`,55) / o.`conversion_rate`) AS 'Total Paid',
        o.`conversion_rate` AS 'Conversion Rate',
	IFNULL(pr.`conversion_rate`,55) AS 'USD to INR',
        (SELECT osl.name 
            FROM `ps_order_state_lang` osl
            INNER JOIN `ps_order_history` ioh ON ioh.id_order_state = osl.id_order_state 
            WHERE ioh.id_order_history = (SELECT max(id_order_history) FROM ps_order_history WHERE id_order = o.id_order)) AS 'Current State',
        s.name AS 'Country',
        a.`city` AS 'City',
        cr.name AS 'Carrier',
        DATE(o.actual_expected_shipping_date) as 'Promised Shipping Date',
	c.email AS 'Email',
	concat(c.firstname,' ',c.lastname) as 'CName',
        cp.qty AS 'NumProducts',
	a.address1 AS 'Address1',
	a.address2 AS 'Address2',
	a.postcode AS 'Postcode',
	a.city AS 'City',
	a.phone_mobile AS 'Mobile'	
        FROM ps_orders o
        INNER JOIN `ps_order_detail` od ON o.id_order = od.`id_order`
        INNER JOIN `ps_order_history` oh ON (oh.`id_order` = o.`id_order`)
        INNER JOIN ps_customer c ON c.`id_customer` = o.`id_customer`
        INNER JOIN ps_address a ON a.`id_address` = o.`id_address_delivery`
        INNER JOIN `ps_country_lang` s ON s.`id_country` = a.id_country
        INNER JOIN `ps_carrier` cr ON cr.`id_carrier` = o.`id_carrier`
        INNER JOIN (select id_cart, sum(quantity) qty from ps_cart_product group by id_cart) cp  on cp.id_cart = o.id_cart
        LEFT JOIN `ps_currency_rates` pr ON date(pr.`day`) = date(o.`date_add`)
        WHERE o.valid = 1
        AND o.`date_add` BETWEEN '" . $date_from ."' AND '" . $date_to ."'
        GROUP BY o.id_order";

    if(Tools::isSubmit('download-products-invoice'))
    {
        $filename = 'indusdiva-products-invoice-'.$date_from.'-to-'.$date_to.'.csv';
        $sql = $sql_products_invoice;
        $header = array('DateOrder', 'InvoiceID', 'OrderID', 'CartID', 'ProductID', 'Product', 'Product Code','Quantity','Sourcing Price','MRP', 'Offer Price', 'ProductTax', 'PaymentMethod', 'TotalPretax', 'Discount', 'Tax', 'Shipping', 'OrderTotal', 'TotalPaid', 'Conversion Rate', 'CurrentState', 'Country', 'City', 'Carrier');
    }

    if(Tools::isSubmit('download-products-delivery'))
    {
        $filename = 'indusdiva-products-delivery-'.$date_from.'-to-'.$date_to.'.csv';
        $sql = $sql_products_delivery;
        $header = array('DateOrder', 'Date Delivery', 'Promised Shipping Date' , 'Date Shipped','InvoiceID', 'OrderID', 'CartID', 'ProductID', 'Product', 'Product Code','Quantity', 'Sourcing Price', 'MRP', 'Offer Price', 'ProductTax', 'PaymentMethod', 'TotalPretax', 'Discount', 'Tax', 'Shipping', 'OrderTotal', 'TotalPaid', 'Conversion Rate', 'CurrentState', 'Country', 'City', 'Carrier');
    }

    if(Tools::isSubmit('download-orders-invoice'))
    {
        $filename = 'indusdiva-orders-invoice-'.$date_from.'-to-'.$date_to.'.csv';
        $sql = $sql_orders_invoice;
        $header = array('Date Order', 'invoice ID', 'Order ID', 'Cart ID', 'Payment Method', 'Total Pretax', 'Discount', 'Tax', 'Shipping', 'Order Total', 'Total Paid', 'Conversion Rate', 'USD to INR', 'CurrentState', 'Country', 'City', 'Carrier','Promised Shipping Date','Email','CustomerName','NumProducts','Address1','Address2','City','Postcode','Mobile');
    }

    if(Tools::isSubmit('download-orders-delivery'))
    {
        $filename = 'indusdiva-orders-delivery-'.$date_from.'-to-'.$date_to.'.csv';
        $sql = $sql_orders_delivery;
        $header = array('Date Order', 'Date Delivery', 'Promised Shipping Date' , 'Date Shipped', 'invoice ID', 'Order ID', 'Cart ID', 'Payment Method', 'Total Pretax', 'Discount', 'Tax', 'Shipping', 'Order Total', 'Total Paid', 'Conversion Rate', 'CurrentState', 'Ship Country', 'Bill Country', 'City', 'Carrier','Email');
    }
    
    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);
    header("Content-type: text/csv");
    header("Cache-Control: no-store, no-cache");
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    $outstream = fopen("php://output",'w');
    fputcsv($outstream, $header, ',', '"');

    if(Tools::isSubmit('download-products-invoice'))
        foreach($res as $row){
        $record = array($row['Date Order'], $row['invoice ID'], $row['Order ID'], $row['Cart ID'], $row['ProductID'], $row['Product NAME'], $row['Product Code'], $row['Quantity'], $row['Sourcing Price'],$row['MRP'], $row['Offer Price'], $row['Product Tax'], $row['Payment Method'], $row['Total Pretax'], $row['Discounts'], $row['Tax'], $row['Shipping'],  $row['Order Total'], $row['Total Paid'], $row['Conversion Rate'], $row['Current State'],$row['Country'], $row['City'], $row['Carrier']);
        fputcsv($outstream, $record, ',', '"');
    }
    elseif(Tools::isSubmit('download-products-delivery'))
    foreach($res as $row){
        $record = array($row['Date Order'], $row['Date Delivery'], $row['Promised Shipping Date'], $row['Date Shipped'], $row['invoice ID'], $row['Order ID'], $row['Cart ID'], $row['ProductID'], $row['Product NAME'], $row['Product NAME'], $row['Quantity'], $row['Sourcing Price'], $row['MRP'], $row['Offer Price'], $row['Product Tax'], $row['Payment Method'], $row['Total Pretax'], $row['Discounts'], $row['Tax'], $row['Shipping'], $row['Order Total'], $row['Total Paid'], $row['Conversion Rate'], $row['Current State'], $row['Country'], $row['City'], $row['Carrier']);
        fputcsv($outstream, $record, ',', '"');
    }
    elseif(Tools::isSubmit('download-orders-invoice'))
    foreach($res as $row){
        $record = array($row['Date Order'], $row['invoice ID'], $row['Order ID'], $row['Cart ID'], $row['Payment Method'], $row['Total Pretax'], $row['Discounts'], $row['Tax'], $row['Shipping'], $row['Order Total'], $row['Total Paid'], $row['Conversion Rate'], $row['USD to INR'], $row['Current State'], $row['Country'], $row['City'], $row['Carrier'],$row['Promised Shipping Date'],$row['Email'],$row['CName'],$row['NumProducts'],$row['Address1'],$row['Address1'],$row['City'],$row['Postcode'],$row['Mobile']);
        fputcsv($outstream, $record, ',', '"');
    }
    elseif(Tools::isSubmit('download-orders-delivery'))
    foreach($res as $row){
        $record = array($row['Date Order'], $row['Date Delivery'], $row['Promised Shipping Date'], $row['Date Shipped'], $row['invoice ID'], $row['Order ID'], $row['Cart ID'], $row['Payment Method'], $row['Total Pretax'], $row['Discounts'], $row['Tax'], $row['Shipping'], $row['Order Total'], $row['Total Paid'], $row['Conversion Rate'], $row['Current State'], $row['Ship Country'], $row['Bill Country'], $row['City'], $row['Carrier'],$row['Email']);
        fputcsv($outstream, $record, ',', '"');
    }

    fclose($outstream);
}


if(Tools::getValue('updatePrice'))
{
    //Get the uploaded file
    // Where the file is going to be placed 
    $target_path = "orderuploads/";
    
    /* Add the original filename to our target path.  
    Result is "uploads/filename.extension" */
    $target_path = $target_path . basename( $_FILES['products']['name']); 
    
    if(move_uploaded_file($_FILES['products']['tmp_name'], $target_path)) 
    {
        $f = fopen($target_path, 'r');
        if ($f) 
        {
            $count = 0;
            while ($line = fgetcsv($f)) 
            {  
                if(!is_numeric($line[0])) continue;
                
                $id_product = (int)($line[0]);
                $product = new Product($id_product, true, 1);
                $newPrice = (float)($line[1]);
                $mrp = $product->getPriceWithoutReduct();
                $product = new Order($id_order);
                SpecificPrice::deleteByProductId($id_product);
                
                $specificPriceIDs = SpecificPrice::getIdsByProductId($id_product);
                if(count($specificPriceIDs) > 0)
                {
                    $specificPrice = new SpecificPrice((int)($specificPriceIDs[0]['id_specific_price']));
                    
                    //delete discount if the prices are equal update otherwise
                    if(round($mrp) > round($newPrice))
                    {
                        $specificPrice->reduction_type = "amount";
                        $specificPrice->reduction = $mrp - $newPrice;
                        $specificPrice->update();
                    }
                    else
                    {
                        SpecificPrice::deleteByProductId($id_product);
                    }
                }
                else 
                {
                    if(round($mrp) > round($newPrice))
                    {
                        $specificPrice = new SpecificPrice();
                        $specificPrice->id_product = $id_product;
                        $specificPrice->reduction_type = "amount";
                        $specificPrice->reduction = $mrp - $newPrice;
                        $specificPrice->from_quantity = 1;
                        $specificPrice->from = date('Y-m-d H:i:s');
                        $specificPrice->update();
                    }
                }
                
                SolrSearch::updateProduct($id_product);
                
                $count++;
            }
            
            fclose($f);
            
            echo 'Total '.$count.' products updated. Thanks for your attention.';
        } 
        else 
        {
            // error
        }
    } 
    else
    {
        echo "There was an error uploading the file, please try again!";
    }
    
}

if(Tools::getValue('getAddresses'))
{
    header("Content-type: text/csv");  
    header("Cache-Control: no-store, no-cache");  
    header('Content-Disposition: attachment; filename="addresses-list.csv"');  
      
    $outstream = fopen("php://output",'w');  
      
    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("SELECT SQL_CALC_FOUND_ROWS a.id_order as `order id`, CONCAT(psa.firstname, ' ', psa.lastname) AS `reciever name`,
 psa.address1 as address, psa.city, CONCAT(psa.firstname, ' ', psa.lastname) as contact, psa.postcode as `pin code`, psa.phone_mobile as `mobile phone`, a.payment,
IF(a.payment = 'EBS', NULL, round(a.total_paid)) as `COD value`, psc.name as `carrier`, coalesce(a.shipping_number, '') as 'tracking_no', round(a.total_paid) as 'order value'
FROM `ps_orders` a 
LEFT JOIN `ps_customer` c ON (c.`id_customer` = a.`id_customer`) 
LEFT JOIN `ps_order_history` oh ON (oh.`id_order` = a.`id_order`) 
LEFT JOIN `ps_order_state` os ON (os.`id_order_state` = oh.`id_order_state`) 
LEFT JOIN `ps_order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = 1) 
LEFT JOIN `ps_address` psa ON (psa.id_address = a.id_address_delivery) 
LEFT JOIN `ps_carrier` psc ON (a.id_carrier = psc.id_carrier)
WHERE 1 AND oh.`id_order_history` = (SELECT MAX(`id_order_history`) FROM `ps_order_history` moh WHERE moh.`id_order` = a.`id_order` GROUP BY moh.`id_order`) 
and os.`id_order_state` = 16  
ORDER BY a.date_add DESC"); 
    
    $header = array('order id', 'reciever name', 'address', 'city', 'contact', 'pin code', 'mobile phone', 'payment', 'COD value', 'carrier', 'tracking no', 'order value');
    fputcsv($outstream, $header, ',', '"');
    foreach( $res as $row )  
    {  
        $row['address'] = str_replace("\r", ", ", $row['address']);
        $row['address'] = str_replace("\n", "", $row['address']);
        fputcsv($outstream, $row, ',', '"');  
    }  
      
    fclose($outstream);
}

if(Tools::getValue('getMeasurement'))
{
    $id_measurement = Tools::getValue('id_measurement');
    $type = Tools::getValue('type');
    $table = '';
    switch($type)
    {
        case 1: $table = 'ps_blouse_measurements';break;
        case 2: $table = 'ps_skirt_measurements';break;
        case 3: $table = 'ps_kurta_measurements';break;
        case 4: $table = 'ps_salwar_measurements';break;
    }
    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("SELECT m.* FROM " . $table.  " m  where m.id_measurement = " . $id_measurement);
    $resLabels = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("SELECT * from ps_measurement_label m  where m.type = " . $type);
    $measurementRow = $res[0];
    
    header("Content-type: text/csv");
    header("Cache-Control: no-store, no-cache");
    header('Content-Disposition: attachment; filename="measurement'.$measurementRow['name'].'.csv"');
     
    $outstream = fopen("php://output",'w');
    
    fputcsv($outstream, array('Measurement Name: ', $measurementRow['name']), ',', '"');;
    $header = array('Short Name', 'Name', 'Value');
    fputcsv($outstream, $header, ',', '"');
    
    $measurements = array();
    
    foreach($resLabels as $labelRow)
    {
        $measurementsItem = array();
        $measurementsItem[] = $labelRow['short_name'];
        $measurementsItem[] = $labelRow['label'];
        $measurementsItem[] = $measurementRow[$labelRow['short_name']];
        fputcsv($outstream, $measurementsItem, ',', '"');
    }
         
    fclose($outstream);
}

if(Tools::getValue('getAddressesQuantium'))
{
    header("Content-type: text/csv");  
    header("Cache-Control: no-store, no-cache");  
    header('Content-Disposition: attachment; filename="addresses-list.csv"');  
      
    $outstream = fopen("php://output",'w');  
      
    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("SELECT SQL_CALC_FOUND_ROWS a.id_order as `order id`, CONCAT(psa.firstname, ' ', psa.lastname) AS `reciever name`,
 psa.address1 as address, psa.city, CONCAT(psa.firstname, ' ', psa.lastname) as contact, psa.postcode as `pin code`, psa.phone_mobile as `mobile phone`, a.payment,
IF(a.payment = 'EBS', NULL, round(a.total_paid)) as `COD value`, psc.name as `carrier`, pc.destcode as `destcode`, a.shipping_number as `tracking_code`
FROM `ps_orders` a 
LEFT JOIN `ps_customer` c ON (c.`id_customer` = a.`id_customer`) 
LEFT JOIN `ps_order_history` oh ON (oh.`id_order` = a.`id_order`) 
LEFT JOIN `ps_order_state` os ON (os.`id_order_state` = oh.`id_order_state`) 
LEFT JOIN `ps_order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = 1) 
LEFT JOIN `ps_address` psa ON (psa.id_address = a.id_address_delivery)
LEFT JOIN `ps_pincodes` pc ON (pc.pin = psa.postcode)
LEFT JOIN `ps_carrier` psc ON (a.id_carrier = psc.id_carrier)
WHERE 1 AND oh.`id_order_history` = (SELECT MAX(`id_order_history`) FROM `ps_order_history` moh WHERE moh.`id_order` = a.`id_order` GROUP BY moh.`id_order`) 
and os.`id_order_state` = 16  
and a.id_carrier = 10
ORDER BY a.date_add DESC"); 
    
    $header = array('order id', 'reciever name', 'address', 'city', 'contact', 'pin code', 'mobile phone', 'payment', 'COD value', 'carrier');
    $header = array('Origin_Mail_Centre_Code', 
                    'Destination_Mail_Centre_Code', 
                    'Destination_City', 'Reference', 
                    'Order_Date', 
                    'Picking_Date', 
                    'Customer_Code', 
                    'AccountNo', 
                    'Bag_No',
                    'Master_Con_Note',
                    'Tracking_No',
                    'Quantity',
                    'Weight',
                    'Special_Delivery_Instruction',
                    'Instruction_On_Undelivery',
                    'Receiver_Name',
                    'Receiver_Contact_No',
                    'Receiver_Area',
                    'Receiver_City',
                    'Receiver_Zip');
    fputcsv($outstream, $header, ',', '"');
    foreach( $res as $row )  
    {  
        $row['address'] = str_replace("\r", ", ", $row['address']);
        $row['address'] = str_replace("\n", "", $row['address']);
        $specialDelivery = '';
        if($row['COD value'])
            $specialDelivery = 'COD:'.$row['COD value'];
        $record = array('BLR', 
                        $row['destcode'], 
                        $row['city'], 
                        $row['order id'], 
                        date('d.m.Y'), 
                        date('d.m.Y'), 
                        '11056', 
                        '11056', 
                        '1', 
                        '', 
                        $row['tracking_code'], 
                        '1', 
                        '', 
                        $specialDelivery, 
                        'Return to Origin', 
                        $row['reciever name'], 
                        $row['mobile phone'], 
                        $row['address'], 
                        $row['city'], 
                        $row['pin code']);
                        
        fputcsv($outstream, $record, ',', '"');  
    }  
      
    fclose($outstream);
}

if(Tools::getValue('getAmazonList') && Tools::getValue('onlyprices'))
{
    Product::initPricesComputation();
    header("Cache-Control: no-store, no-cache");  
    header('Content-Encoding: UTF-8');
    header('Content-type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="amazon-products-prices.csv"');  
    //echo "\xEF\xBB\xBF"; // UTF-8 BOM
      
    $outstream = fopen("php://output",'w');  
      
    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("SELECT p.id_product, ap.browse_node from ps_product p left join amazon_product ap on ap.id_product = p.id_product where p.quantity > 0 and p.active = 1"); 
    
    $header = array('SKU','Price', 'MRP', 'PriceIN', 'MRPIN');
    fputcsv($outstream, $header, ',', '"');
    foreach( $res as $row )  
    {  
        $productDetails = array();
        
        $id_product = ((int)$row['id_product']);
        
        $product = new Product($id_product, true, 1);
        
        $offer_price_in = Product::getPriceStatic($id_product, true, NULL, 6, NULL, false, true, 1, false, NULL, NULL, IND_ADDRESS_ID);
        $offer_price_in_rs = Tools::convertPrice($offer_price_in, 4);
        $mrp_in = Product::getPriceStatic($id_product, true, NULL, 6, NULL, false, false, 1, false, NULL, NULL, IND_ADDRESS_ID);
        $mrp_in_rs = Tools::convertPrice($mrp_in, 4);
        
        $productDetails = array($product->id,
                                round($product->getPrice()),
                                round($product->getPriceWithoutReduct()),
                                round($offer_price_in_rs),
                                round($mrp_in_rs));
                                
        
        fputcsv($outstream, $productDetails, ',', '"');  
    }  
      
    fclose($outstream);
}
elseif(Tools::getValue('getAmazonList'))
{
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
    $set = Tools::getValue('set');

    header("Cache-Control: no-store, no-cache");  
    header('Content-Encoding: UTF-8');
    header('Content-type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="amazon-products-set-'.$set.'.csv"');
    //echo "\xEF\xBB\xBF"; // UTF-8 BOM
      
    $outstream = fopen("php://output",'w');  

    $cond = array();
    $activeC = (int)Tools::getValue('onlyActive');
    if( $activeC == 2 )
        $cond[] = "active = 1";
    elseif($activeC == 3)
        $cond[] = "active = 0";

    $fromDate = Tools::getValue('datepickerFrom');
    $toDate = Tools::getValue('datepickerTo');
    if( !empty($fromDate) && !empty($toDate) )
        $cond[] = "date_add >= '$fromDate 00:00:00' and date_add <= '$toDate 23:59:59'";
    elseif( !empty($fromDate) )
        $cond[] = "date_add >= '$fromDate 00:00:00'";
    elseif( !empty($toDate)) 
        $cond[] = "date_add <= '$toDate 23:59:59'";



    $sql = "SELECT p.id_product from ps_product p";
    if( count($cond) > 0) {
        $sql .= " where " . implode(" AND ", $cond);
    }
    $sql .= " order by id_product";
    
    //Download products at a time is taking so much time and sometimes leading to seg fault
    $countsql  = "SELECT count(*) as count from ps_product";
    if( count($cond) > 0) {
        $countsql .= " where " . implode(" AND ", $cond);
    }
    $row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($countsql);
    $count = $row['count'];
    $set = Tools::getValue('set');
    $set = intval($set);
    if( $set === 1 )
	$sql .= " limit 0,".floor($count/3);
    elseif( $set === 2 )
        $sql .= " limit ".(floor($count/3)-1).",".floor($count/3);
    elseif( $set === 3)
        $sql .= "  limit ".(floor($count*2/3)-2).",". floor($count/3);
    //end
    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql); 
    
    $header = array('SKU','Code','Supplier Code', 'Title','Link','Price','List Price','Price IN','List Price IN','Description','Shipping Cost','Availability','Manufacturer','Main Category','All Categories','Color', 'Fabric', 'Active', 'Quantity','Delivery SLA', 'Customizable','Image', 'ThickboxImage','Date Created','More Images');
    fputcsv($outstream, $header, ',', '"');
    //echo '"'.implode($header,'","').'"';
    //echo PHP_EOL;
    foreach( $res as $row )  
    { 
        
        $id_product = ((int)$row['id_product']);
        
        $productObj = new Product($id_product, true, 1);
                
        $offer_price_in = Product::getPriceStatic($productObj->id, true, NULL, 6, NULL, false, true, 1, false, NULL, NULL, IND_ADDRESS_ID); 
        $offer_price_in_rs = Tools::convertPrice($offer_price_in, 4);
        $mrp_in = Product::getPriceStatic($productObj->id, true, NULL, 6, NULL, false, false, 1, false, NULL, NULL, IND_ADDRESS_ID);
        $mrp_in_rs = Tools::convertPrice($mrp_in, 4);

        $color = '';
        if(isset($productObj->generic_color) && !empty($productObj->generic_color)) {
            $colors = explode(',', $productObj->generic_color);
            foreach($colors as $c){
                $color  = strtolower(preg_replace('/\s+/', '-',trim($c)));
            }
        }

        $fabric = '';
        if( isset($productObj->fabric) && !empty($productObj->fabric))
            $fabric = $productObj->fabric;
        
        $availability = 'TRUE';
        $quantity = Product::getQuantity($id_product);
        if((int)$quantity < 1)
            $availability = 'FALSE';
        
        $catIds = $productObj->getCategories();
        $category_names = array();

        foreach($catIds as $catID)
        {
            $category = new Category((int)$catID);
            $category_names[] = $category->getName(1);
        }

        $category_names = array_diff($category_names, array('Home'));
        $categories = implode(',', $category_names);

        $category = 'Other';
        if( in_array(CAT_SAREE,$catIds) )
            $category = 'Saree';
        elseif( in_array(CAT_SKD, $catIds )) {
            if( in_array(CAT_ANARKALI, $catIds))
                $category = 'Anarkali';
            else
                $category = 'SKD';
        }
        elseif( in_array(CAT_KURTI, $catIds ))
            $category = 'Kurti';
        elseif( in_array(CAT_LEHENGA, $catIds))
            $category = 'Lehenga';
        elseif( in_array(CAT_BOTTOMS, $catIds))
            $category = 'Bottom';
        elseif( in_array(CAT_CHOLIS, $catIds))
            $category = 'Choli';
        elseif( in_array(CAT_GIFTCARD, $catIds))
            $category = 'GiftCard';
        elseif( in_array(CAT_JEWELRY, $catIds))
            $category = 'Jewelry';
        elseif( in_array(CAT_KIDS, $catIds))
            $category = 'Kids';
        elseif( in_array(CAT_ABAYA, $catIds))
            $category = 'Abaya';
        elseif( in_array(CAT_MEN, $catIds))
            $category = 'Men';
        elseif( in_array(CAT_HANDBAG, $catIds))
            $category = 'Handbag';

        $doc->product_link = $productObj->getLink();
        $idImage = $productObj->getCoverWs();
        if($idImage)
            $idImage = $productObj->id.'-'.$idImage;
        else
            $idImage = Language::getIsoById(1).'-default';
        $thickbox_image = $link->getImageLink($productObj->link_rewrite,$idImage, 'thickbox');
        $large_image = $link->getImageLink($productObj->link_rewrite,$idImage, 'large');

        $id_manufacturer  = $productObj->id_manufacturer;
        $manufacturer = '';
        if( !empty($id_manufacturer) ){
            $manufacturer = Manufacturer::getNameById($id_manufacturer);
        }

        $productRec = array($id_product,
                                $productObj->reference,
                                $productObj->supplier_reference,
                                $productObj->name,
                                $productObj->getLink(),
                                $productObj->getPriceWithoutReduct(),
                                round($productObj->getPrice()),
                                round($mrp_in_rs),
                                round($offer_price_in_rs),
                                strip_tags($productObj->description),
                                '0',
                                $availability,
                                $manufacturer,
                                $category,
                                $categories,
                                $color,
                                $fabric,
                                ((int)$productObj->active === 1)?'ACTIVE':'INACTIVE',
                                $quantity,
                                $productObj->shipping_sla,
                                $productObj->is_customizable,
                                $large_image,
                                $thickbox_image,
                                date('Y-m-d',strtotime($productObj->date_add))
                    );
 
        $images = $productObj->getImages(1);
        foreach($images as $image) {
            $oImage = $link->getImageLink($productObj->link_rewrite,$image['id_image'], 'thickbox');
            if( $thickbox_image !== $oImage ) {
                array_push($productRec, $oImage);
            } 
        }        
    	//echo '"'.implode($productRec,'","').'"';
        //echo PHP_EOL;
        fputcsv($outstream, $productRec, ',', '"');  
        ob_flush();
        flush();
    }  
      
    fclose($outstream);
}
elseif(Tools::getValue('getPartnerProducts'))
{
    ini_set('max_execution_time', 600);
    ini_set('memory_limit', '-1');

    header("Cache-Control: no-store, no-cache");
    header('Content-Encoding: UTF-8');
    header('Content-type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="indusdiva-products.csv"');
    //echo "\xEF\xBB\xBF"; // UTF-8 BOM
     
    $outstream = fopen("php://output",'w');
     
    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("SELECT p.id_product
            from ps_product p
            inner join ps_category_product cp on cp.id_product = p.id_product 
            where p.active = 1
            and p.quantity > 0
            and cp.id_category = 2");

    $header = array('SKU','Title','Link','Price','Delivery Time','Standard Product ID','Category',
            'Description','Image','List Price','Keywords1', 'Target Gender', 'PriceIN', 
            'MRPIN', 'Color', 'Fabric', 'Quantity', 'Garment Type', 'Work Type', 
            'Blouse Length', 'Saree Length', 'Saree Width', 'weight');
    fputcsv($outstream, $header, ',', '"');
    foreach( $res as $row )
    {
        $productDetails = array();

        $id_product = ((int)$row['id_product']);

        $productDetails = SolrSearch::getProductsForIDs(array($id_product));

        $productDetails = $productDetails[0];

        $offer_price_in = $productDetails['offer_price_in'];
        $offer_price_in_rs = $productDetails['offer_price_in_rs'];
        $mrp_in = $productDetails['mrp_in'];
        $mrp_in_rs = Tools::convertPrice($mrp_in, 4);

        $color = '';
        $colors = $productDetails['color'];
        if(isset($colors[0]))
        {
            $color = implode(',', $colors);
        }

        $fabric = '';
        $fabric = $productDetails['fabric'];

        $productDetails['cat_name'] = array_diff($productDetails['cat_name'], array('Home'));
        $tags = implode(',', $productDetails['cat_name']);
        $workType = implode(',', $productDetails['work_type']);
        $images = implode(',', $productDetails['image_links']); 
        $productRec = array($id_product,
                $productDetails['name'],
                $productDetails['product_link'],
                round($productDetails['offer_price']),
                $productDetails['shipping_sla'],
                $productDetails['reference'],
                'Saree',
                strip_tags($productDetails['description']),
                $images,
                $productDetails['mrp'],
                $tags,
                'Women',
                round($offer_price_in_rs),
                round($mrp_in_rs),
                $color,
                $fabric, 
                $productDetails['quantity'],
                $productDetails['garment_type'],
                $workType,
                ''.$productDetails['blouse_length']. ' cm',
                ''.$productDetails['height']. ' meters',
                ''.$productDetails['width']. ' inches',
                $productDetails['weight']);


        fputcsv($outstream, $productRec, ',', '"');
    }
     
    fclose($outstream);
}

if(Tools::getValue('getProductIDS'))
{
    header("Cache-Control: no-store, no-cache");
    header('Content-Encoding: UTF-8');
    header('Content-type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="product-ids.csv"');
    //echo "\xEF\xBB\xBF"; // UTF-8 BOM

    $outstream = fopen("php://output",'w');

    $min = Tools::getValue('min');
    $max = Tools::getValue('max');
    if( !empty($min) && !empty($max) )
    	$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("SELECT p.id_product, p.reference, p.wholesale_price from ps_product p where id_product >= $min and id_product <= $max");
    else
        $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("SELECT p.id_product, p.reference, p.wholesale_price from ps_product p");
    $header = array('id_product','Reference', 'mrp', 'wholesale_price');
    fputcsv($outstream, $header, ',', '"');
    $i=0;
    foreach( $res as $row )
    {
        $product = new Product((int)$row['id_product'], false, 1);
        $productDetails = array((int)$row['id_product'], $row['reference'], $product->getPriceWithoutReduct(), (int)$row['wholesale_price']);
        fputcsv($outstream, $productDetails, ',', '"');
        ob_flush();
        flush();
    }
    fclose($outstream);
}

if(Tools::getValue('getProductsList'))
{
    Product::initPricesComputation();
    header("Cache-Control: no-store, no-cache");  
    header('Content-Encoding: UTF-8');
    header('Content-type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="indusdiva-products.csv"');  
      
    $outstream = fopen("php://output",'w');  
      
    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("SELECT id_product from ps_product"); 
    
    $header = array('SKU','Name','Active','Price','Category','MRP', 'Brand');
    fputcsv($outstream, $header, ',', '"');
    foreach( $res as $row )  
    {  
        $productDetails = array();
        
        $id_product = ((int)$row['id_product']);
        
        $product = new Product($id_product, true, 1);
        
        $price = $product->getPrice();
        
        $cat = new Category($product->id_category_default);
        $product_category = $cat->getName(1);
        
        $productDetails = array($product->id,
                                $product->name,
                                $product->active,
                                $product->getPrice(),
                                $product_category,
                                $product->getPriceWithoutReduct(),
                                $product->manufacturer_name);
                                
        
        fputcsv($outstream, $productDetails, ',', '"');  
    }  
      
    fclose($outstream);
}

if(Tools::getValue('getProducts'))
{
    $date_from = Tools::getValue('orders_from');
    $date_to = Tools::getValue('orders_to');
    if (!is_array($statusArray = Tools::getValue('id_order_state')) OR !count($statusArray))
        $statusFilter = '';
    else 
        $statusFilter = "and os.`id_order_state` in (" . implode(',', $statusArray) . ") ";
        
    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("SELECT SQL_CALC_FOUND_ROWS a.id_order as `order id`, 
    pd.product_name as `Product`, 
    osl.name as `Status`,
    pd.product_quantity as `Quantity`, 
    round(pp.wholesale_price * 55) as `Souring Price`, 
    pp.ean13 as `EAN`,
    pp.reference as 'REF',
    pp.supplier_reference as 'SUP_REF',
    vl.value as 'Shipping Estimate'
    FROM `ps_orders` a 
    INNER JOIN `ps_order_detail` pd ON (a.id_order = pd.id_order)
    INNER JOIN `ps_product` pp ON (pd.product_id = pp.`id_product`)
    LEFT JOIN `ps_order_history` oh ON (oh.`id_order` = a.`id_order`) 
    LEFT JOIN `ps_order_state` os ON (os.`id_order_state` = oh.`id_order_state`)
        INNER JOIN `ps_order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state`) 
        INNER JOIN ps_feature_product fp on (fp.id_product = pp.id_product  and fp.id_feature = 8 )
        INNER JOIN ps_feature_value_lang vl on fp.id_feature_value = vl.id_feature_value
        LEFT JOIN `ps_currency_rates` pr ON date(pr.`day`) = date(a.`date_add`)
    WHERE 1 AND oh.`id_order_history` = (SELECT MAX(`id_order_history`) FROM `ps_order_history` moh WHERE moh.`id_order` = a.`id_order` GROUP BY moh.`id_order`) 
    " . $statusFilter . "
    and CAST(a.date_add AS DATE) between '" . $date_from  ."' and '" . $date_to ."'
    ORDER BY a.date_add DESC"); 
    
    $header = array('Order ID',  'Product', 'Status','Quantity', 'Sourcing Price', 'EAN', 'REF', 'SUPPLIER REFERENCE','Shipping Estimate');
    
    header("Content-type: text/csv");  
    header("Cache-Control: no-store, no-cache");  
    header('Content-Disposition: attachment; filename="products-list.csv"');  
    
    $outstream = fopen("php://output",'w');
    fputcsv($outstream, $header, ',', '"');
    
    foreach( $res as $row )  
    {
            $row["Shipping Estimate"] = filter_var($row['Shipping Estimate'], FILTER_SANITIZE_NUMBER_INT);
        fputcsv($outstream, $row, ',', '"');  
    }  

    fclose($outstream);
}

if(Tools::getValue('getSalesData'))
{
    $date_from = Tools::getValue('orders_from');
    $date_to = Tools::getValue('orders_to');
    
    if(Tools::getValue('only_delivered') == 1)
    {
        echo 'only delivered selected';
    }

    /*$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("SELECT SQL_CALC_FOUND_ROWS a.id_order as `order id`,
            pd.product_name as `Product`,
            osl.name as `Status`,
            pd.product_quantity as `Quantity`,
            round(pp.price * 1.14) as `MRP`,
            round(if(pd.`reduction_percent` > 0.00, pp.price*1.14*(1-0.01*pd.`reduction_percent`), pp.price - pd.`reduction_amount`)) as `Offer Price`,
            pp.ean13 as `EAN`,
            pp.reference as 'REF',
            pp.supplier_reference as 'SUP_REF'
            FROM `ps_orders` a
            INNER JOIN `ps_order_detail` pd ON (a.id_order = pd.id_order)
            INNER JOIN `ps_product` pp ON (pd.product_id = pp.`id_product`)
            LEFT JOIN `ps_order_history` oh ON (oh.`id_order` = a.`id_order`)
            LEFT JOIN `ps_order_state` os ON (os.`id_order_state` = oh.`id_order_state`)
            INNER JOIN `ps_order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state`)
            WHERE 1 AND oh.`id_order_history` = (SELECT MAX(`id_order_history`) FROM `ps_order_history` moh WHERE moh.`id_order` = a.`id_order` GROUP BY moh.`id_order`)
            " . $statusFilter . "
            and CAST(a.date_add AS DATE) between '" . $date_from  ."' and '" . $date_to ."'
            ORDER BY a.date_add DESC");

    $header = array('Order ID',  'Product', 'Status','Quantity', 'MRP', 'Offer Price', 'EAN', 'REF', 'SUPPLIER REFERENCE');

    header("Content-type: text/csv");
    header("Cache-Control: no-store, no-cache");
    header('Content-Disposition: attachment; filename="products-list.csv"');

    $outstream = fopen("php://output",'w');
    fputcsv($outstream, $header, ',', '"');

    foreach( $res as $row )
    {
        fputcsv($outstream, $row, ',', '"');
    }

    fclose($outstream);*/
}

if(Tools::getValue('getManufacturerProducts'))
{
    $id_manufacturer = Tools::getValue('id_manufacturer');
    $sql = "select pl.id_product, pl.name, if(p.quantity>0, 'IN-STOCK', 'OOS') as 'OOS', if(p.active>0, 'ENABLED', 'DISABLED') as 'Live'
            from ps_product_lang pl
            inner join ps_product p on p.id_product = pl.id_product
            and p.id_manufacturer =  ".$id_manufacturer;
    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);
    
    $products = array();
    foreach($res as $row)
    {
        $product = new Product((int)$row['id_product'], true, 1);
        $mrp = $product->getPriceWithoutReduct();
        $products[] = array('id_product' => $row['id_product'], 'name' => $row['name'], 'oos' => $row['OOS'], 'mrp' => $mrp, 'live' => $row['Live']);
    }
    
    $header = array('id_product',  'name', 'oos', 'MRP', 'Live');
    header("Content-type: text/csv");  
    header("Cache-Control: no-store, no-cache");  
    header('Content-Disposition: attachment; filename="manufacturer-products-'.$id_manufacturer.'.csv"');
    
    $outstream = fopen("php://output",'w');
    fputcsv($outstream, $header, ',', '"');
    
    foreach( $products as $row )  
    {  
        fputcsv($outstream, $row, ',', '"');  
    }  

    fclose($outstream);
}

if(Tools::getValue('getLastMonthSales'))
{
    $id_manufacturer = Tools::getValue('id_manufacturer');
    $sql = "select m.name as 'brand',
    od.`product_id` as 'id_product',
    od.`product_name` as 'product-name',
    sum(od.`product_quantity`) as 'quantity',
    round(p.`wholesale_price`, 2) as 'cost-price',
    round(sum(p.`wholesale_price`*od.`product_quantity`), 2) as 'total-cost-price',
    MONTHNAME(oh.`date_add`) as 'month'
    from ps_orders o
    inner join ps_order_detail od on od.`id_order` = o.id_order
    inner join ps_product p on p.id_product = od.product_id
    inner join `ps_manufacturer` m on p.`id_manufacturer` = m.`id_manufacturer`
    inner join `ps_order_history` oh ON (oh.`id_order` = o.`id_order`) 
    where month(curdate()) - month(oh.`date_add`) = 1
    and o.id_order > 1205010000
    and oh.`id_order_state` = 5
    and oh.`id_order_history` = (SELECT MAX(`id_order_history`) FROM `ps_order_history` moh WHERE moh.`id_order` = o.`id_order` GROUP BY moh.`id_order`)
    and p.id_manufacturer = " . $id_manufacturer ."
    group by p.id_product";
    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);

    $header = array('Brand',  'ProductID', 'Name','Quantity', 'Cost Price', 'Total Cost Price', 'Month');
    
    header("Content-type: text/csv");
    header("Cache-Control: no-store, no-cache");
    header('Content-Disposition: attachment; filename="brand-sales-'.$id_manufacturer.'.csv"');

    $outstream = fopen("php://output",'w');
    fputcsv($outstream, $header, ',', '"');

    foreach( $res as $row )
    {
        fputcsv($outstream, $row, ',', '"');
    }

    fclose($outstream);
}

if(Tools::getValue('markShipped'))
{
    //Get the uploaded file
    // Where the file is going to be placed 
    $target_path = "/var/www/indusdiva.com/orderuploads/";
    
    /* Add the original filename to our target path.  
    Result is "uploads/filename.extension" */
    $target_path = $target_path . basename( $_FILES['orders']['name']); 
    
    if(move_uploaded_file($_FILES['orders']['tmp_name'], $target_path)) 
    {
        $f = fopen($target_path, 'r');
        if ($f) 
        {
            $count = 0;
            while ($line = fgetcsv($f)) 
            {  
                if(!is_numeric($line[1])) continue;
                
                $id_order = (int)($line[1]);
                $order = new Order($id_order);
                $history = new OrderHistory();
                $history->id_order = $id_order;
                $history->id_employee = (int)($cookie->id_employee);
                
                if($history->getLastOrderState($id_order) == _PS_OS_SHIPPING_)
                    continue;
                        
                $history->changeIdOrderState(_PS_OS_SHIPPING_, $id_order);
                
                $history->addWithemail(true, false);
                
                $shipping_number = pSQL($line[0]);
                $order->shipping_number = $shipping_number;
                $order->update();
                if ($shipping_number)
                {
                    global $_LANGMAIL;
                    $customer = new Customer((int)($order->id_customer));
                    $carrier = new Carrier((int)($order->id_carrier));
                    if (!Validate::isLoadedObject($customer) OR !Validate::isLoadedObject($carrier))
                        die(Tools::displayError());
                    $templateVars = array(
                        '{order_amount}' => Tools::displayPrice($order->total_paid, $currency, false),
                        '{carrier_name}' => $carrier->name,
                        '{tracking_number}' => $order->shipping_number,
                        '{followup}' => str_replace('@', $order->shipping_number, $carrier->url),
                        '{firstname}' => $customer->firstname,
                        '{lastname}' => $customer->lastname,
                        '{id_order}' => (int)($order->id)
                    );
                    if(strpos($order->payment, 'COD') === false)
                        @Mail::Send((int)($order->id_lang), 'in_transit', Mail::l('Your order #'.$order->id.' with IndusDiva.com has been shipped'), $templateVars, $customer->email, $customer->firstname.' '.$customer->lastname);
                    else 
                        @Mail::Send((int)($order->id_lang), 'in_transit_cod', Mail::l('Your order #'.$order->id.' with IndusDiva.com has been shipped'), $templateVars, $customer->email, $customer->firstname.' '.$customer->lastname);
                
                    //Send SMS
                    $delivery = new Address((int)($order->id_address_delivery));
                    if(strpos($order->payment, 'COD') === false)
                        $smsText = 'Dear customer, your order #'.$order->id.' at IndusDiva.com has been shipped via '.$carrier->name.'. The airway bill no is '.$order->shipping_number.'. www.indusdiva.com';
                    else
                        $smsText = 'Dear customer, your order #'.$order->id.' at IndusDiva.com has been shipped. Carrier: '.$carrier->name.', AWB No. : '.$order->shipping_number.', Amount payable:'.Tools::displayPrice($order->total_paid, $currency, false).'. www.indusdiva.com';
                    Tools::sendSMS($delivery->phone_mobile, $smsText);
                }
                
                $count++;
                echo $history->id_order;echo '<br>';
            }
            fclose($f);
            
            echo 'Total '.$count.' orders marked shipped successfully. Thanks for your attention.';
        } 
        else 
        {
            // error
        }
    } 
    else
    {
        echo "There was an error uploading the file, please try again!";
    }
    
}
if( Tools::getValue('uploadtags')) {
    ini_set('max_execution_time', 0);
    ini_set('memory_limit', '-1');
    //Get the uploaded file
    // Where the file is going to be placed 
    $target_path = "/var/www/indusdiva.com/admin12/import/";
    
    /* Add the original filename to our target path.  
    Result is "uploads/filename.extension" */
    $target_path = $target_path . basename( $_FILES['product_tags']['name']) . time(); 
    if(move_uploaded_file($_FILES['product_tags']['tmp_name'], $target_path))  {
        $f = fopen($target_path, 'r');
        if ($f) {
            $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
            $count = 0;
            $ktags = Tools::getValue('keep_tags',null);
            $ktags = explode(",",$ktags);
            $keep_tags = array();
            foreach($ktags as $tag){
                array_push($keep_tags, trim($tag));
            }
            fgetcsv($f);
            $product_ids = array();
            $errors = array();
            while ($line = fgetcsv($f)) {
                if( count($line) !== 2) {
                    echo "Invalid file format.please check";
                    exit;
                }
                $id_product = (int)$line[0];
                $tags = $line[1];
                if( empty($tagname) ) {
                    $atags = explode(",",$tags);
                    $tagname = $atags[0];
                }
                $product = new Product($id_product);
                if( !empty($keep_tags) ) {
                    $new_tags = array();
                    $old_tags = $product->description_short[1];
                    $old_tags = explode(",",$old_tags);
                    foreach($old_tags as $key => $tag) {
                        if( $tag === $tagname )
                            continue;
                        if( array_search($tag, $keep_tags) )
                            array_push($new_tags, $tag);
                    }
                    $new_tags = implode(",", $new_tags);
		    if( strlen($new_tags) <= 0)
			$new_tags = $tags;
		    else
	                $new_tags = $new_tags . "," . $tags;
                    $product->description_short[1]  = $new_tags;
                } else {
                    $product->description_short[1]  = $tags;
                }
		$fieldError = $product->validateFields(UNFRIENDLY_ERROR, true);
		$langFieldError = $product->validateFieldsLang(UNFRIENDLY_ERROR, true); 
		
		if( !empty($fieldError) ) {
			$product->update();	
		} else {
			$errors[] = "<br/>$id_product : ". $langFieldError;
		} 
                $count++;
                array_push($product_ids, $id_product);
            }
            fclose($f);
            SolrSearch::updateProducts($product_ids);
            echo "Total $count rows processed";
            echo "<br/>";
            echo "<a href='http://www.indusdiva.com/products/$tagname'>link</a>";
	    echo "<br/>"."--------------------------------------------------";
	    echo "<br/>Errors";
            echo implode("<br/>", $errors); exit;
        } 
        else 
        {
            echo "There was an error in reading the file, please try again or report this incident";
        }
    } 
    else
    {
        echo "There was an error uploading/moving the file, please try again or report this incident";
    }

}
if(Tools::getValue('markDelivered'))
{
    //Get the uploaded file
    // Where the file is going to be placed 
    $target_path = "/var/www/indusdiva.com/orderuploads/";
    
    /* Add the original filename to our target path.  
    Result is "uploads/filename.extension" */
    $target_path = $target_path . basename( $_FILES['orders']['name']); 
    
    if(move_uploaded_file($_FILES['orders']['tmp_name'], $target_path)) 
    {
        $f = fopen($target_path, 'r');
        if ($f) 
        {
            $count = 0;
            while ($line = fgetcsv($f)) 
            {  
                if(!is_numeric($line[0])) 
                    continue;
                    
                $id_order = (int)($line[0]);
                $order = new Order($id_order);
                $history = new OrderHistory();
                $history->id_order = $id_order;
                $history->id_employee = (int)($cookie->id_employee);
                
                if($history->getLastOrderState($id_order) == _PS_OS_DELIVERED_)
                    continue;
                
                $history->changeIdOrderState(_PS_OS_DELIVERED_, $id_order);
                
                $history->addWithemail(true, false);
                $count++;
                echo $history->id_order;echo '<br>';
            }
            fclose($f);
            
            echo 'Total '.$count.' orders marked delivered successfully. Thanks for your attention.';
        } 
        else 
        {
            // error
        }
    } 
    else
    {
        echo "There was an error uploading the file, please try again!";
    }
    
}
if( Tools::getValue('uploadimages')) {
    ini_set('max_execution_time', 0);
    //Get the uploaded file
    // Where the file is going to be placed 
    $target_path = "/var/www/indusdiva.com/admin12/import/";

    $products = array(); 
    
    /* Add the original filename to our target path.  
    Result is "uploads/filename.extension" */
    $target_path = $target_path . basename( $_FILES['product_images']['name']) . time(); 
    if(move_uploaded_file($_FILES['product_images']['tmp_name'], $target_path))  {
        $f = fopen($target_path, 'r');
        if ($f) {
            fgetcsv($f);
            while ($line = fgetcsv($f)) {
                if( count($line) !== 2) {
                    echo "Invalid file format.please check";
                    exit;
                }
                $id_product = (int)$line[0];
                $images = $line[1];
                $images = explode(",", $images);
                foreach ($images AS $image_name) {
                    $image_name = trim($image_name);
                    $image_path = IMAGE_UPLOAD_PATH . $image_name;
                    if (!empty($image_name) && !file_exists($image_path)) {
                        echo "Image not found for: " . trim($id_product) . ", Image Name: " . $image_name;
                        exit;
                    }
                }
                $product = new Product((int) $id_product);
                if( !Validate::isLoadedObject($product)) {
                    echo "Invalid Product Id $id_product";
                    exit;
                }
                $product->deleteImages();
                $first_image = true;
                $defaultLanguageId = (int) (Configuration::get('PS_LANG_DEFAULT'));
                foreach ($images AS $image_name) {
                    $image_name = trim($image_name);
                    $image_path = IMAGE_UPLOAD_PATH . $image_name;
                    if (!empty($image_name)) {
                        $image = new Image();
                        $image->id_product = (int) ($product->id);
                        $image->position = Image::getHighestPosition($product->id) + 1;
                        $image->cover = $first_image;
                        $image->legend[$defaultLanguageId] = $product->name[$defaultLanguageId];
                        if (($fieldError = $image->validateFields(false, true)) === true AND ($langFieldError = $image->validateFieldsLang(false, true)) === true AND $image->add()) {
                            if (!Tools::copyImg($product->id, $image->id, $image_path)) {
                                echo "Error copying image:"  . $image_path;
                                exit;
                            }
                            else {
                                //delete the original image
                                @unlink($image_path);
                            }
                        } else {
				print_r( $fieldError ); 
				print_r( $langFieldError ); exit;
			}
                    }
                    $first_image = false;
                }
		array_push($products, $id_product);
            }
            SolrSearch::updateProducts($products);
        }
        else 
        {
            echo "There was an error in reading the file, please try again or report this incident";
        }
    } else {
        echo "There was an error in reading the file, please try again or report this incident";
    }
}

if(Tools::getValue('combqty'))
{
    ini_set('max_execution_time', 0);
    ini_set('memory_limit', '-1');

    header("Cache-Control: no-store, no-cache");  
    header('Content-Encoding: UTF-8');
    header('Content-type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="products-qty.csv"');
      
    $outstream = fopen("php://output",'w');
    $record = array("ID","Size","Code","Qty");
    fputcsv($outstream, $record, ',', '"');

    $target_path = "import/";
    
    $target_path = $target_path . basename( $_FILES['product_ids']['name']) . time(); 
    if(move_uploaded_file($_FILES['product_ids']['tmp_name'], $target_path))  {
        $f = fopen($target_path, 'r');
        if ($f) {
            $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
            $count = 0;
            fgetcsv($f);
            while ($line = fgetcsv($f)) 
            {
                $id_product = intval($line[0]);
                $product = new Product($id_product,true,1);
                $attributesGroups = $product->getAttributesGroups(1);
		$quantity = 0;
                if( !empty($attributesGroups) ) {
                    foreach($attributesGroups as $group) {
                        $record = array($id_product,$group['attribute_name'],$product->reference, $group['quantity']);
                        fputcsv($outstream, $record, ',', '"');
			$quantity += intval($group['quantity']);
                    } 
                }
		if( empty($attributesGroups) )
			$quantity = $product->quantity;
                $record = array($id_product,"",$product->reference, $quantity);
                fputcsv($outstream, $record, ',', '"');
            } 
        }
        exit;
    } else {
        exit;
    }
}
if( Tools::getValue('channel_discount') ) {
    ini_set('max_execution_time', 0);
    ini_set('memory_limit', '-1');

    $target_path = "import/";
    
    $target_path = $target_path . basename( $_FILES['product_ids']['name']) . time(); 
    if(move_uploaded_file($_FILES['product_ids']['tmp_name'], $target_path))  {
        $f = fopen($target_path, 'r');
        if ($f) {
            $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
            $count = 0;
            fgetcsv($f);
            while ($line = fgetcsv($f)) {
                $id_affiliate = intval($line[0]);
                $id_product = intval($line[1]);
                $reduction = $line[2];
                $reduction_type = $line[3];
               
                $sql  = "delete from ps_affiliate_specific_price where id_product = $id_product";
                $db->ExecuteS($sql);
 
                $sql = "insert into ps_affiliate_specific_price (id_product,id_affiliate, id_shop, id_currency, id_country, id_group, price, from_quantity, reduction, reduction_type, `from`, `to`) values   ($id_product,$id_affiliate,0,0,0,0,0,0,'$reduction', '$reduction_type','0000-00-00 00:00:00','0000-00-00 00:00:00')";
                $db->ExecuteS($sql);
        
                //update product updated time so amazon feed picks this in the next run
                $sql = "update ps_product set date_upd = '".date('Y-m-d H:i:s')."' where id_product = ". $id_product;
                $db->ExecuteS($sql);
                
            }
            echo "Discouts added - these should get captured in the next feed"; 
        } else {
            echo "There was an error in reading the file, please try again or report this incident";
        }
    } else {
        echo "There was an error in reading the file, please try again or report this incident";
    }
}
