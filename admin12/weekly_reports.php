<?php

define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');
include(PS_ADMIN_DIR.'/functions.php');

global $link;
$link = new Link();
if (!defined('_PS_BASE_URL_'))
	define('_PS_BASE_URL_', Tools::getShopDomain(true));


function sendOrderFeedbackReportMail() {
   
    $this_monday = date("Y-m-d H:i:s");
    $last_monday = new DateTime();
    $last_monday->sub(new DateInterval('P7D'));
    $last_monday = $last_monday->format("Y-m-d H:i:s");
 
    $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS("select f.id_order, c.email, f.overall, f.recommend, f.collection, f.products, f.fitting, f.delivery, f.support, f.suggestion from ps_customer c join ps_order_feedback f on c.id_customer = f.id_customer where f.date_add >= '$last_monday' and f.date_add < '$this_monday'");

    $headers = array(
        array("Order Dd"),
        array("Email"),
        array("Overall"),
        array("Recommend"),
        array("Collection"),
        array("Products"),
        array("Fitting"),
        array("Delivery"),
        array("Support"),
        array("Suggestion"),
    );
    
    $line = '';
    foreach($headers as $header) {
        $value = str_replace( '"' , '""' , $header[0] );
        $value = '"' . $value . '"' . ",";
        $line .= $value;
    }
    $data = trim( $line ) . "\n";
    
    foreach($result as $row)
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
    $fileAttachment['name'] = 'WeeklyOrderFeedback'.date("d-m-Y").'.csv';
    $fileAttachment['mime'] = 'text/csv';

    $templateVars = array();
    $to = array(
        'vineet.saxena@violetbag.com',
    	'jyoti.amba@violetbag.com',
        'ramakant.sharma@violetbag.com',
	'venugopal.annamaneni@violetbag.com',
	'venkatesh.padaki@violetbag.com');

    $subject = "Customer Feedback Weekly Data - ". date('d-m-y');
    @Mail::Send(1, 'empty', $subject, $templateVars, $to , null, 'care@indusdiva.com', 'Indusdiva.com', $fileAttachment, NULL, _PS_MAIL_DIR_, false);
}

sendOrderFeedbackReportMail();
