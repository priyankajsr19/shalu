<?php
class MarketplaceWebService_XML_DataType_Relation extends MarketplaceWebService_XML_DataType_Base {
    public function __construct($sku = null, $type = null) {
        parent::__construct();
        if( $sku !== null )
            $this->setSKU($sku);
        if( $type !== null )
            $this->setType($type);
    }

    public function setSKU($value) {
        return $this->set('SKU', $value);
    }

    public function setType($value) {
        if( !in_array($value, array(
            'Variation',
            'DisplaySet',
            'Collection',
            'Accessory',
            'Customized',
            'Part',
            'Complements',
            'Piece',
            'Necessary',
            'ReplacementPart',
            'Similar',
            'Episode',
            'Season'
        ))) {
            throw new InvalidArgumentException('Invalid relation type');
        }
        return $this->set('Type',$value);
    }

    public function getXML($feed) {
        $xmlRelation = $feed->createNode('Relation');

        if( $sku = $this->get('SKU') )
            $xmlRelation->appendChild( $feed->createNode('SKU',$sku) );
        if( $type = $this->get('Type') )
            $xmlRelation->appendChild( $feed->createNode('Type', $type) );

        return $xmlRelation;
    }
}
?>
