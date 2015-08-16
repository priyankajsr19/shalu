<?php

class OrderFeedbackControllerCore extends FrontController
{
    public function __construct()
    {
        $this->auth = true;
        $this->php_self = 'order-feedback.php';
        $this->authRedirection = 'order-feedback.php';
        $this->ssl = true;
    
        parent::__construct();
    }
    
    public function preProcess()
    {
        parent::preProcess();
        
        $id_customer = self::$cookie->id_customer;
        $customer = new Customer($id_customer);
        
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        //self::$smarty->assign('display_thanks', 1);
        
        if(!Tools::isSubmit('submitFeedback')) return;
        
        $overall = Tools::getValue('overall');
        $recommend = Tools::getValue('recommend');
        $collection = Tools::getValue('collection');
        $products = Tools::getValue('products');
        $fitting = Tools::getValue('fitting');
        $delivery = Tools::getValue('delivery');
        $support = Tools::getValue('support');
        $suggestions = Tools::getValue('suggestions');
        $id_order = Tools::getValue('oid');
        
        if( empty($id_order) )
            $id_order  = 0;
        $suggestions = pSQL($suggestions);
        
        $query = 'INSERT INTO `ps_order_feedback`(id_customer, overall, recommend, collection, products, fitting, delivery, support, suggestion,id_order) values(
        '. $id_customer . ', 
        '. $overall . ', 
        '. $recommend . ', 
        '. $collection . ', 
        '. $products . ', 
        '. $fitting . ', 
        '. $delivery . ', 
        '. $support . ', 
        "'. $suggestions . '",
        '.$id_order.'
        )';
        
        $db->Execute($query);
        
        Mail::Send(1, 'neworderfeedback', Mail::l('New Order Feedback'),
                array('{customer_name}' => $customer->firstname. ' - ' . $customer->email . ' - (Order Id # ' . $id_order . ')', 
                        '{$overall}' => $overall,
                        '{$recommend}' => $recommend,
                        '{$collection}' => $collection,
                        '{$products}' => $products,
                        '{$fitting}' => $fitting,
                        '{$delivery}' => $delivery,
                        '{$support}' => $support,
                        '{$suggestions}' => $suggestions), array('mgmt@violetbag.com','orderfeedbacks@indusdiva.com','care@indusdiva.com'), 'IndusDiva Order Feedback');
        
        self::$smarty->assign('display_thanks', 1);
        Tools::sendSQSRuleMessage(EVENT_ORDER_FEEDBACK, $id_order, $cookie->id_customer, date('Y-m-d H:i:s'));
    }
    
    public function setMedia()
    {
        parent::setMedia();
    }
    
    public function displayContent()
    {
        parent::displayContent();
                self::$smarty->assign('id_order',Tools::getValue('oid'));
        self::$smarty->display(_PS_THEME_DIR_.'order-feedback.tpl');
    }
    
    public function displayHeader()
    {
        self::$smarty->assign('nobots', 1);
        parent::displayHeader();
    }
}


