<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class ThirdPartyStockSync {

    private static $url = 'http://122.166.247.244:8844/XZ/Items.asmx?WSDL';

    // Test Server Link ( Maitri office )
    //private static $url = 'http://122.166.236.109:8844/XZ/Items.asmx?wsdl';


    private static $alert_data = array();
    private static $csv_data = array();
    private static $to_list = array('venugopal.annamaneni@violetbag.com','vineet.saxena@violetbag.com','ramakant.sharma@violetbag.com','mahesh.bc@violetbag.com','jyoti.amba@violetbag.com','venkatesh.padaki@violetbag.com');
    //private static $to_list = array('venugopal.annamaneni@violetbag.com');
    private static $to_engg_list = array('venugopal.annamaneni@violetbag.com');
    
    public static function getQuantityByItemcode($id_product, $design_no, $item_code) {

        return self::getQuantity($item_code, $design_no);
    }

    private static function getQuantity($item_code, $design_no) {
        try {
            $client = self::getClient();
            $data = array(
                "DesignNo" => $design_no,
                "Itemcode" => $item_code,
                "Size" => "-"
            );
            $result = $client->GetQuantity($data);
            return $result;
        } catch( Exception $ex ) {
            self::send_tech_mail('Stock Sync Update Quantity',"Get Quantity API Failed");
            return false;	
        }
    }

    public static function setAsidebyItemcode($id_product, $reference, $supplier_reference, $id_order, $quantity) {
        return self::setAside($id_product, $reference, $supplier_reference, $id_order, $quantity);
    }

    private static function setAside($id_product,$reference, $supplier_reference, $id_order,$quantity) {
	    $message = array(
            'id_product' => $id_product,
            'reference' => $reference,
            'supplier_reference' => $supplier_reference,
            'id_order' => $id_order,
            "quantity" => $quantity,
        );
        $sqs = new AmazonSQS();
        $sqs->set_region(AmazonSQS::REGION_APAC_SE1);
        $response = $sqs->send_message(STOCK_SYNC_QUEUE, Tools::jsonEncode($message));
        if (!$response->isOK()) {
            self::send_tech_mail('SQS Stock Sync send message',"Failed to send message to the queue. Product Id:{$id_product} , Order Id:{$id_order}, Qty:{$quantity}");
            return false;
        }
        return true;
    }


    private static function getClient() {
        $client = new My_SoapClient(self::$url, array("trace" => false, "exception" => true));
        return $client;
    }

    public static function setAsideCron() {

        self::echomsg(null,"Start Sudarshan Stock Sync - SetAside", true);
        $sqs = new AmazonSQS();
        $sqs->set_region(AmazonSQS::REGION_APAC_SE1);
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $updates = false;
        while(true) {
            $response = $sqs->receive_message(STOCK_SYNC_QUEUE);
            if(!$response->body->ReceiveMessageResult->Message) {
                break;
            }
            else {
                $updates = true;
                self::echomsg(null,"--------------------------------------------------", true);
                $message = Tools::jsonDecode($response->body->ReceiveMessageResult->Message->Body, true);

                $supplier_reference = $message['supplier_reference']; 
                $sup_details = explode("::", $supplier_reference );
                if( count($sup_details) !== 2 ) {
                    self::echomsg($message,"Action Needed - Invalid Vendor Code. Manual SetAside needed", true);
                } else {
                    $design_no = $sup_details[0];
                    $item_code = $sup_details[1];
                    $id_product = $message["id_product"];
                    $reference = $message["reference"];
                    $id_order = $message["id_order"];
                    $quantity = (int)$message["quantity"];

                    $product = array();
                    $product['id_product'] = $id_product;
                    $product['reference'] = $reference;
                    $product['supplier_reference'] = $supplier_reference;
                    $product['id_order'] = $id_order;

                    self::echomsg($product, "Quantity #{$quantity} - Waiting for SetAside Update");
                    for($i=1; $i<=$quantity; $i++) {
                        try {
                            $client = self::getClient();
                            $data = array(
                                "Itemcode" => $item_code,
                                "DesignNo" => $design_no,
                                "OrderNo" => (string) $id_order,
                                "Size" => "-"
                            );
                            $result = $client->SetAside($data);
                            if( (int)$result->SetAsideResult === 1 )
                                self::echomsg($product,"SetAside success",  true);
                            else
                                self::echomsg($product, "Manual SetAside Action Needed - System SetAside Failed",  true);
                        } catch(Exception $ex) {
                            $ex_msg = $ex->getMessage();
                            if( stripos($ex_msg,"is insufficient for the requested quantity") ) {
                                self::echomsg($product, "<b>Out of Stock</b>",  true);
                            } else {
                                self::send_tech_mail('Stock Sync Update SetAside',"Set Aside API Failed");
                                self::echomsg($product, "Manual SetAside Action Needed - System SetAside Failed",  true);
                            }
                        }
                    }
                }
                $handle = $response->body->ReceiveMessageResult->Message->ReceiptHandle;
                $sqs->delete_message(STOCK_SYNC_QUEUE, $handle);
            }
        }
        self::echomsg(null,"--------------------------------------------------", true);
        self::echomsg(null,"End Sudarshan Stock Sync - SetAside", true);
        if( $updates )
            self::send_log_mail('Set Aside');
        return true;
    }

	
    public static function updateQuantityCron() {

        $link =  new Link();
        global $link;

        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);

	// update data from sudarshan_details table to ps_product
        $sql = "update ps_product p inner join sudarshan_details s on (s.id_product = p.id_product and p.reference like 'BLR002%') set p.supplier_reference = CASE WHEN concat(s.design_no,'::',s.item_code) = '::' THEN '' WHEN concat(s.design_no,'::',s.item_code) != '' THEN concat(s.design_no,'::',s.item_code) END, p.active = s.enabled";
	$db->ExecuteS($sql);

        $sql = "select id_supplier from ps_supplier where code = 'BLR002'";
        $res = $db->getRow($sql);
        $id_supplier = $res['id_supplier'];

        self::echomsg(null, "Start Sudarshan Stock Sync - UpdateQuantity", true);

        // Sudarshan Vendor Code is in the format design_no::item_code
        $sql = "select id_product, reference, supplier_reference from ps_product where id_supplier = $id_supplier and supplier_reference like '%::%' and active = 1";
        $res = $db->ExecuteS($sql);

        /*$res = array( 
            array('id_product' => 111, 'supplier_reference' => '675::CRB', 'reference' => 'BLR0021001'),
            array('id_product' => 112, 'supplier_reference' => 'BLR020020::CRB', 'reference' => 'BLR0020020'),
            array('id_product' => 113, 'supplier_reference' => 'BLR020021::CRB', 'reference' => 'BLR0020021'),
            array('id_product' => 114, 'supplier_reference' => 'BLR020022::CRB', 'reference' => 'BLR0020022'),
            array('id_product' => 115, 'supplier_reference' => 'BLR020023::CRB', 'reference' => 'BLR0020023'),
        );*/

        foreach($res as $product) {
 
            self::echomsg(null,"--------------------------------------------------", true);

            $id_product = $product['id_product'];
            $supplier_reference = $product['supplier_reference'];
            $reference = $product['reference'];

            if( empty($supplier_reference) ) {
                self::echomsg($product,"No Vendor Code", true);
                continue;
            }
            $sup_details = explode("::", $supplier_reference );
            if( count($sup_details) !== 2 ) {
                self::echomsg($product,"Invalid Vendor Code $supplier_reference", true);
                continue;
            }

            self::echomsg($product,"Waiting for response");

            $design_no = $sup_details[0];
            $item_code = $sup_details[1];
            $qres = self::getQuantityByItemcode($id_product, $design_no, $item_code);

            if( $qres === false) {
                $sql = "update sudarshan_details set valid = 0 where id_product = $id_product";
                $db->ExecuteS($sql); 
                self::echomsg($product,"Failed to get quantity - Updating quantity to 5 and shipping sla to 15 days", true);
                $quantity = 5;
                $shipping_sla = 15;
            } else {
                $sql = "update sudarshan_details set valid = 1 where id_product = $id_product";
                $db->ExecuteS($sql); 
                $quantity = (int)$qres->GetQuantityResult;
                if( $quantity === 0) {
                    $quantity = 5;
                    $shipping_sla = 15;
                } else {
                    $shipping_sla = 3;
                }
                self::echomsg($product, "Vendor Quantity $quantity");
            }

            $dbproduct = new Product($id_product);
            $old_quantity = (int)$dbproduct->quantity;
            //$sql = "select quantity from ps_product where id_product = {$id_product}";
            //$res = $db->ExecuteS($sql);
            //$old_quantity = (int)$res[0]["quantity"];

            if( $quantity === $old_quantity && (int)$dbproduct->shipping_sla === $shipping_sla ) {
                self::echomsg($product, "Quantity $quantity already upto date", true);
                continue;
            }
            
            //update DB and Solr
            $dbproduct->quantity  = $quantity;
            $dbproduct->update();
            //$sql = "update ps_product set quantity=$quantity where id_product = $id_product";
            //$db->ExecuteS($sql);
            self::addFeature($id_product, 'shipping_estimate', "Ready to be shipped in $shipping_sla days");
            SolrSearch::updateProduct($id_product);
            //Search::indexation();	
            //Log the update
            $sql = "insert into stock_sync_data(id_product,old_quantity,new_quantity,id_employee,status) values($id_product,$old_quantity,$quantity,-9999,1)";
            $db->ExecuteS($sql);
            self::echomsg($product,"Updated Product Quantity to $quantity", true);
        }
        self::echomsg(null,"--------------------------------------------------", true);
        self::echomsg(null,"End Sudarshan Stock Sync - UpdateQuantity", true);
        self::send_log_mail('Update Quantity');
    }
 
    private static function addFeature($id_product, $feature_name, $feature_value) {
        if (empty($feature_value))
            return;
        $id_feature = Feature::addFeatureImport($feature_name);
        $id_feature_value = FeatureValue::addFeatureValueImport($id_feature, $feature_value);
        Product::addFeatureProductImport($id_product, $id_feature, $id_feature_value);
    }

   
    private static function send_tech_mail($event, $description) {
        $templateVars = array(
            'event' => $event,
            'description' => $description
        );
        //@Mail::Send(1, 'alert', Mail::l('Stock Sync Alarm'), $templateVars, self::$to_engg_list, null, 'care@indusdiva.com', 'Indusdiva Monitoring', NULL, NULL, _PS_MAIL_DIR_, false);
    }
 
    private static function send_log_mail($type) {
        self::$alert_data = implode("<br/>\n", self::$alert_data);

        self::sendmail("Stock Sync $type Log", self::$alert_data, self::$csv_data);
    }   
 
    private static function sendmail($event, $description, $log_data=array()) {
        $data = '';
        foreach($log_data as $row) {
            $line = '';
            foreach($row as $value) {
                if ((!isset($value)) || ($value == "")) {
                    $value = ",";
                } else {
                    $value = str_replace( '"' , '""' , $value );
                    $value = '"' . $value . '"' . ",";
                }
                $line .= $value;
            }
            $data .= trim( $line ) . "\n";
        }
        $data = str_replace( "\r" , "" , $data );
        $fileAttachment = null;
        if( !empty($data) ) {
            $fileAttachment['content'] = $data;
            $fileAttachment['name'] = "Stock Sync $event - ".date("d-m-Y").'.csv';
            $fileAttachment['mime'] = 'text/csv';
        }
        $subject = "Stock Sync $event ";
        $templateVars = array('event' => $event , 'description' => $description);
        @Mail::Send(1, 'alert', $subject, $templateVars, self::$to_list, null, 'care@indusdiva.com', 'Indusdiva Monitoring', $fileAttachment, NULL, _PS_MAIL_DIR_, false);
    }


    private static function echomsg($product, $message, $alert = false) {
        $tnow = date('Y-m-d H:i:s');
	
        $pdata = '';
        if(!empty($product)) {
            $pdata = '';
            if( isset($product['id_product']) )
                $pdata .= "Product# ".$product['id_product'];
            if( isset($product['reference']) )
                $pdata .= ", Indusdiva Code# ".$product['reference'];
            if( isset($product['supplier_reference']) )
                $pdata .= ", Supplier Code# ".$product['supplier_reference'];
            if( isset($product['id_order']) )
                $pdata .= ", Order Id# ".$product['id_order'];
                $pdata .= " - ";
        }

        echo $print = "$tnow - $pdata $message\n";
        if( $alert ) {
            array_push( self::$alert_data, $print );
            if(!empty($product))	
                array_push( self::$csv_data, array_merge($product, array("message"=>$message)) ); 
        }
    }
}

?>
