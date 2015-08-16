<?php
class MarketplaceWebService_XML_Data_Image extends MarketplaceWebService_XML_Data_Base {
   
    public function __construct() {
        parent::__construct();
    }

    public function setSKU($value) {
        return $this->set('SKU',$value);
    }

    public function setImageType($value) {
        if( !in_array($value, array(
            'Main',
            'Swatch',
            'PT1',
            'PT2',
            'PT3',
            'PT4',
            'PT5',
            'PT6',
            'PT7',
            'PT8'
        ))) {
            throw new InvalidArgumentException('Invalid ImageType Value');
        }
        return $this->set('ImageType', $value);
    }

    public function setImageLocation($value) {
        $this->set('ImageLocation', $value);
    }

}
