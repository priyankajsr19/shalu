<?php
class MarketplaceWebService_XML_Data_Relationship extends MarketplaceWebService_XML_Data_Base {
   
    public function __construct() {
        parent::__construct();
    }

    public function setParentSKU($value) {
        return $this->set('ParentSKU',$value);
    }

    public function addRelation(MarketplaceWebService_XML_DataType_Relation $value) {
        return $this->add('Relation', $value);
    }

}
