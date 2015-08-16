<?php
class MarketplaceWebService_XML_Data_Price extends MarketplaceWebService_XML_Data_Base {
   
    public function __construct() {
        parent::__construct();
    }

    public function setSKU($value) {
        return $this->set('SKU',$value);
    }

    public function setStandardPrice(MarketPlaceWebService_XML_Datatype_Price $value) {
        return $this->set('StandardPrice',$value);
    }

    public function setSale(MarketPlaceWebService_XML_Datatype_Sale $value) {
        return $this->set('Sale', $value);
    }
}
?>
