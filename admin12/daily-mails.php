<?php

define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');
include(PS_ADMIN_DIR.'/functions.php');

global $link;
$link = new Link();
if (!defined('_PS_BASE_URL_'))
	define('_PS_BASE_URL_', Tools::getShopDomain(true));

function sendVoucherMails() {
	
	$sql = "SELECT d.id_customer, d.date_to, c.`firstname`, c.email
	FROM ps_discount d 
	INNER JOIN ps_customer c ON c.id_customer = d.`id_customer`
	WHERE datediff(`date_to`, curdate()) = 3
	AND c.newsletter = 0
	AND d.`quantity` > 0
	GROUP BY c.id_customer";

	$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);

	$count = 0;
	foreach($res as $row)
	{
		$count++;
		$coupondate = new DateTime($row['date_to']);
		$coupondatestr = $coupondate->format("F j, Y");

		$templateVars = array();
		$templateVars['{firstname}'] = $row['firstname'];
		$templateVars['{expirydate}'] = $coupondatestr;

		$mailTo = $row['email'];
		echo "".$count." : ".$mailTo."\n";
		$subject = $row['firstname'] . ", Hurry Up! Your Vouchers expire in 3 days";
		@Mail::Send(1, 'coupon-reminder', $subject, $templateVars,$mailTo , $row['firstname'], 'care@indusdiva.com', 'Indusdiva.com', NULL, NULL, _PS_MAIL_DIR_, false);
		usleep(200000);
	}
}

function sendCartMails() {
	global $link;
	
	$sql = "SELECT c.id_cart, cc.email, cc.`firstname`, cc.id_customer
	FROM `ps_cart` c
	INNER JOIN ps_customer cc ON cc.`id_customer` = c.`id_customer`
	INNER JOIN `ps_cart_product` cp ON cp.`id_cart` = c.id_cart
	LEFT JOIN ps_orders o ON o.`id_cart` = c.id_cart
	WHERE o.id_cart IS NULL
	AND datediff(curdate(), c.`date_upd`) = 3
	AND cc.newsletter = 0
	GROUP BY cc.`id_customer`";
	
	/*$sql = "SELECT c.id_cart, cc.email, cc.`firstname`, cc.id_customer
	FROM `ps_cart` c
	INNER JOIN ps_customer cc ON cc.`id_customer` = c.`id_customer`
	INNER JOIN `ps_cart_product` cp ON cp.`id_cart` = c.id_cart
	LEFT JOIN ps_orders o ON o.`id_cart` = c.id_cart
	WHERE cc.id_customer = 1
	GROUP BY cc.`id_customer`";*/

	$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);

	$count = 0;
	foreach($res as $row)
	{
		$count++;
		$id_cart = Cart::lastNoneOrderedCart($row['id_customer']);
		$cart = new Cart($id_cart);
		$id_product = $cart->getLastProduct();
		$id_product = $id_product['id_product'];
		$product = new Product($id_product, true, 1);

		$idImage = $product->getCoverWs();
		if($idImage)
			$idImage = $product->id.'-'.$idImage;
		else
			$idImage = Language::getIsoById(1).'-default';

		$templateVars = array();
		$templateVars['{firstname}'] = $row['firstname'];
		$templateVars['{product_url}'] = $product->getLink();
		$templateVars['{product_name}'] = $product->name;
		$templateVars['{image_link}'] = $link->getImageLink($product->link_rewrite,$idImage, 'list');

		$mailTo = $row['email'];
		echo "".$count." : ".$mailTo."\n";
		$subject = $row['firstname'] . ", you left your shopping bag with us";
		@Mail::Send(1, 'abandoned', $subject, $templateVars,$mailTo , $row['firstname'], 'care@indusdiva.com', 'Indusdiva.com', NULL, NULL, _PS_MAIL_DIR_, false);
		usleep(200000);
	}
}

function sendOrderStatusMail() {
    
    // Select all Orders which are not in (4,5,6,10) state
    // Select id_order, payment and is_queued atleast once
    $sql = "select 
                o.id_order, 
                o.payment, 
                position('3' IN group_concat(oh.id_order_state)) as is_queued  
            from 
                ps_orders o 
            inner join ps_order_history oh 
                on oh.id_order = o.id_order 
            inner join ps_order_history h  
                on h.id_order = o.id_order 
            inner join 
                (select id_order, max(date_add) max_date_add from ps_order_history group by id_order) t2  
                    on (h.id_order = t2.id_order and h.date_add = t2.max_date_add) 
            where 
                h.id_order_state not in (4,5,6,10,20,34) 
            group by 
                o.id_order";

    $total_orders = $not_shipped = $in_sourcing = $in_cust = $on_track = 0;
    
    $result = Db::getInstance()->ExecuteS($sql);
    $reports = array();
    foreach( $result as $order) {
        
        $total_orders++;
        
        $id_order = (int)$order['id_order'];
        $payment = (string)$order['payment'];
        $is_queued  = ((int)$order['is_queued'] === 0) ? false : true;
        
        if( $payment === 'Bank Wire' && $is_queued === false)
            continue;
        
        $order = new Order($id_order);
        $orderHistory =  new OrderHistory();
        $orderStateObj = $orderHistory->getLastOrderState($id_order);
        $customer =  new Customer($order->id_customer);
        $cart = new Cart($order->id_cart);
        $products = $cart->getProducts();
        
        $order_placed_date = date_create((string)$order->date_add);
        $actual_expected_shipping_date = date_create((string)$order->actual_expected_shipping_date);
        $current_expected_shipping_date = date_create((string) $order->expected_shipping_date);
        $status_updated_date = date_create((string)$orderStateObj->date_add);
        $curr_date = new Datetime();
        
        
        
        $same_order = false;
        foreach($products as $product) {   
            $reportObject = array();
            $reportObject['id_order'] = $id_order;
            $reportObject["name"] = $product['name'];
            $reportObject["reference"] = $product['reference'];
            
        
            $reportObject['customer_name'] = (string)$customer->firstname . ' ' . (string)$customer->lastname;
            $reportObject['email'] = (string)$customer->email;
            $reportObject['total_paid'] = (float)$order->total_paid;
            $reportObject['order_state'] = (string)$orderStateObj->name;
            $reportObject['order_placed_date'] = (string)$order_placed_date->format('Y-m-d');
            $reportObject['actual_expected_shipping_date'] = (string)$actual_expected_shipping_date->format('Y-m-d');
            $reportObject['current_expected_shipping_date'] = (string)$current_expected_shipping_date->format('Y-m-d');
            $reportObject['status_updated_date'] = (string)$status_updated_date->format('Y-m-d');
            $reportObject['flags'] = array();

            if( $actual_expected_shipping_date < $curr_date || 
                    $current_expected_shipping_date < $curr_date ) {
                if( !$same_order )
                    $not_shipped++;
                array_push($reportObject['flags'], "not shipped");
            }
            if( $reportObject['order_state'] === 'Customization in Progress' && 
                    $status_updated_date->add(new DateInterval('P5D')) < $curr_date ) {
                if( !$same_order )
                    $in_cust++;
                array_push($reportObject['flags'], "> 5days in cust");
            }
            //(DATEDIFF(o.expected_shipping_date, o.date_add)/2 > DATEDIFF(o.expected_shipping_date, t1.date_add))
            if( $reportObject['order_state'] === 'Sourcing in Progress') {
                $sourcing_flag = false;
                if( $current_expected_shipping_date > $curr_date ) {
                    $total_days_avail = (int)$current_expected_shipping_date->diff($order_placed_date)->days;
                    $curr_days_avail = (int)$curr_date->diff($current_expected_shipping_date)->days;
                    if( $total_days_avail/2 > $curr_days_avail)
                        $sourcing_flag = true;
                } else {
                    $sourcing_flag = true;
                }
                if( $sourcing_flag ) { 
                    if( !$same_order )
                        $in_sourcing++;
                    array_push($reportObject['flags'], "in sourcing");
                }
            }
            if( empty($reportObject['flags']) ) {
                if( !$same_order )
                    $on_track++;
                $reportObject['flags'] = 'on track';
            }
            else
                $reportObject['flags'] = implode(",", $reportObject['flags']);
            array_push( $reports , $reportObject);
            
            $same_order = true;
        }
    }    
   
    $headers = array(
        array("order_id","40px"),
        array("pname","100px"),
        array("pcode","40px"),
        array("customer_name","100px"),
        array("customer_email","100px"),
        array("total_paid","40px"),
        array("current_status","100px"),
        array("placed_date","50px"),
        array("original_shipping_date","50px"),
        array("current_shipping_date","50px"),
        array("order_status_updated_date","50px"),
        array("urgency_level", "40px")
    );
    global $smarty;
    $smarty->assign("headers",$headers);
    $smarty->assign("total_orders",$total_orders);
    $smarty->assign("not_shipped",$not_shipped);
    $smarty->assign("in_cust", $in_cust);
    $smarty->assign("in_sourcing", $in_sourcing);
    $smarty->assign("on_track", $on_track);
    $smarty->assign("result", $reports);
    
    $line = '';
    foreach($headers as $header) {
        $value = str_replace( '"' , '""' , $header[0] );
        $value = '"' . $value . '"' . ",";
        $line .= $value;
    }
    $data = trim( $line ) . "\n";
    
    foreach($reports as $row)
    {
        $line = '';
        foreach( $row as $value )
        {                                            
            if ( ( !isset( $value ) ) || ( $value == "" ) )
            {
                $value = ",";
            }
            else
            {
                $value = str_replace( '"' , '""' , $value );
                $value = '"' . $value . '"' . ",";
            }
            $line .= $value;
        }
        $data .= trim( $line ) . "\n";
    }
    $data = str_replace( "\r" , "" , $data );

    if ( $data == "" )
    {
        $data = "\nNo Records Found!\n";                        
    }
    
    $fileAttachment['content'] = $data;
    $fileAttachment['name'] = 'IndusdivaOrderDailyStatus'.date("d-m-Y").'.csv';
    $fileAttachment['mime'] = 'text/csv';
    
    $templateVars = array();
    $templateVars['{today_date}'] = date('d-m-y');
    $templateVars['{report_summary}'] = $smarty->fetch(_PS_THEME_DIR_.'order-daily-summary.tpl');
    $templateVars['{report_content}'] = $smarty->fetch(_PS_THEME_DIR_.'order-daily-status.tpl');
    $to = array(
        'rohit.modi@violetbag.com',
        'vineet.saxena@violetbag.com',
    	'jyoti.amba@violetbag.com',
        'savio.dsouza@violetbag.com',
        'zubair.ahmad@violetbag.com',
        'mahesh.bc@violetbag.com',
        'neeraj.kumar@violetbag.com',
        'sandhya.kumari@violetbag.com',
        'ramakant.sharma@violetbag.com',
	'venugopal.annamaneni@violetbag.com',
	'venkatesh.padaki@violetbag.com');

    $subject = "Order Daily Status - ". date('d-m-y');
    @Mail::Send(1, 'order_daily_status', $subject, $templateVars, $to , null, 'care@indusdiva.com', 'Indusdiva.com', $fileAttachment, NULL, _PS_MAIL_DIR_, false);
}

function sendOrderFeedbackMail() {
    $sql = "select 
                o.id_order,
                c.firstname,
                c.email,
                date_format(t1.date_add,'%M %d,%Y') as delivery_date 
            from 
                ps_order_history t1
            inner join                      
                (select id_order, max(date_add) max_date_add from ps_order_history group by id_order) t2
                    on (t1.id_order = t2.id_order and t1.date_add = t2.max_date_add)
            inner join ps_orders o
                on o.id_order = t1.id_order
            inner join ps_customer c
                on c.id_customer = o.id_customer  
            where t1.id_order_state = 5 and 
                datediff(date_format(curdate(),'%Y-%m-%d'), date_format(t1.date_add,'%Y-%m-%d')) = 3";
    
    $orders = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);
    foreach($orders as $order) {
        $templateVars = array();
        $templateVars['{firstname}'] = $order['firstname'];
        $templateVars['{id_order}'] = $order['id_order'];
        $templateVars['{delivery_date}'] = $order['delivery_date'];
        $templateVars['{shop_url}'] = Tools::getShopDomain(true, true).__PS_BASE_URI__;
        $templateVars['{feedback_form_link}'] = 'order-feedback.php';
        $templateVars['{order_history_link}'] = 'order-history';
        $mailTo = $order['email'];
        
        $subject = "Indusdiva needs your feedback for order #".$order['id_order'];
        @Mail::Send(1, 'order_feedback', $subject, $templateVars,$mailTo , $order['firstname'], 'care@indusdiva.com', 'Indusdiva.com', NULL, NULL, _PS_MAIL_DIR_, false);
        usleep(200000);
    }
}

sendVoucherMails();
sendCartMails();
sendOrderFeedbackMail();
sendOrderStatusMail();
