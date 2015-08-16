<?php
class MarketplaceWebService_XML_DataType_Price extends MarketplaceWebService_XML_DataType_Base {
    public function __construct($price, $currency) {
        parent::__construct();
        if($price !== null)
            $this->setPrice($price);
        if($currency!== null)
            $this->setCurrency($currency);
    }

    public function setPrice($value) {
        return $this->set('Price',$value);
    }

    public function setCurrency($value) {
        if( !in_array($value, array(
            'USD'
        ))){
            throw new InvalidArgumentException('Invalid Currency type');
        }
        return $this->set('Currency', $value);
    }
    public function getXML($feed, $nodeName='StandardPrice') {
        if( $price = $this->get('Price') ) {
            $priceNode = $feed->createNode($nodeName, $price );
            if( $currency = $this->get('Currency') )
                $feed->createAttr($priceNode, "currency", $currency);
            return $priceNode;
        }
    }
}
