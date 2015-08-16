<?php
class MarketplaceWebService_XML_Feed_Inventory extends MarketplaceWebService_XML_Feed_Base {

    public function __construct($config, $feedType) {
        parent::__construct($config, $feedType);
    }

    public function addInventory($object) {
        //create Message Tag 
        //common for all kinds of feeds
        //takes care of incrementing message id
        $this->newMessage();

        $inventory = $this->message->appendChild( $this->createNode('Inventory') );

        $this->addNode($inventory, $object, 'SKU');
        $this->addNode($inventory, $object, 'Quantity');
        $this->addNode($inventory, $object, 'FulfillmentLatency');
    }
}
?>
