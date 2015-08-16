<?php
class MarketplaceWebService_XML_Feed_Image extends MarketplaceWebService_XML_Feed_Base {

    public function __construct($config, $feedType) {
        parent::__construct($config, $feedType);
    }

    public function addImage($object) {
        //create Message Tag 
        //common for all kinds of feeds
        //takes care of incrementing message id
        $this->newMessage();

        $productImage = $this->message->appendChild( $this->createNode('ProductImage') );

        $this->addNode($productImage, $object, 'SKU');
        $this->addNode($productImage, $object, 'ImageType');
        $this->addNode($productImage, $object, 'ImageLocation');
    }
}
?>
