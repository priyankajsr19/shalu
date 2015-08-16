<?php
class MarketplaceWebService_XML_Data_Inventory extends MarketplaceWebService_XML_Data_Base {
   
    public function __construct() {
        parent::__construct();
    }

    public function setSKU($value) {
        return $this->set('SKU',$value);
    }
    public function setQuantity($value) {
        if( !is_int($value) ) {
            throw new InvalidArgumentException("Quantity must be an integer");
        }
        return $this->set('Quantity',$value);
    }
    public function setFulfillmentLatency($value) {
        if( !is_int($value) || ($value < 1) || ($value >30) ) {
            throw new InvalidArgumentException("FulfillmentLatency must be a whole number between 1 and 30");
        }
        return $this->set('FulfillmentLatency',$value);
    }
}
