<?php
class MarketplaceWebService_XML_Feed_Relationship extends MarketplaceWebService_XML_Feed_Base {

    public function __construct($config, $feedType) {
        parent::__construct($config, $feedType);
    }

    public function addRelationship($object, $operationType="Update") {
        //create Message Tag 
        //common for all kinds of feeds
        //takes care of incrementing message id
        $this->newMessage($operationType);

        $relationship = $this->message->appendChild( $this->createNode('Relationship') );

        $this->addNode($relationship, $object, 'ParentSKU');
        $this->addNode($relationship, $object, 'Relation');
    }
}
