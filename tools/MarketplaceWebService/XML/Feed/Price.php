<?php
class MarketplaceWebService_XML_Feed_Price extends MarketplaceWebService_XML_Feed_Base {

    public function __construct($config, $feedType) {
        parent::__construct($config, $feedType);
    }

    public function addPrice($object) {
        //create Message Tag 
        //common for all kinds of feeds
        //takes care of incrementing message id
        $this->newMessage(null);

        $price = $this->message->appendChild( $this->createNode('Price') );

        $this->addNode($price,$object,'SKU');
        $this->addNode($price,$object,'StandardPrice');
        $this->addNode($price,$object,'Sale');     
    }
    
}
?>
