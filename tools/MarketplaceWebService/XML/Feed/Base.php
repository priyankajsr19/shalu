<?php
abstract class MarketplaceWebService_XML_Feed_Base {	
   
    protected $xml; 
    protected $envelope;
    protected $message;
    protected $message_id;

    protected $config;
    protected $feedType;
    
    public function __construct($config, $feedType) {
        $this->config = $config;
        $this->feedType = $feedType;
        $this->message_id = 1;
        $this->xml = new DOMDocument("1.0");
        $this->envelope = $this->createNode('AmazonEnvelope');
        $this->createAttr( $this->envelope, 'xsi:noNamespaceSchemaLocation', 'amzn-envelope.xsd');
        $this->createAttr( $this->envelope, 'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        
        $header = $this->envelope->appendChild( $this->createNode('Header') );
        $header->appendChild( $this->createNode('DocumentVersion', APPLICATION_VERSION) );
        $header->appendChild( $this->createNode('MerchantIdentifier',$config['merchant_id']) );
        $this->envelope->appendChild( $this->createNode('MessageType', $feedType) );
        $this->envelope->appendChild( $this->createNode('PurgeAndReplace', 'false') );
        $this->xml->appendChild($this->envelope);
    }
    protected function newMessage($operationType='Update') {
        $this->message = $this->envelope->appendChild( $this->createNode('Message') );

        $this->message->appendChild( $this->createNode('MessageID',$this->message_id) );	
        $this->message_id++; // increment for next next product
        if( $operationType )
            $this->message->appendChild( $this->createNode('OperationType',$operationType) );
    }


    public function addNode($parent, $object, $nodeName ) {
        $value = $object->get($nodeName);
        if( $value === null)
            return null;

        if( is_array($value) ) {
            foreach($value as $k=>$v) {
                if( $v instanceOf MarketplaceWebService_XML_DataType_Base ) {
                    // $v is custom DataType
                    $parent->appendChild($v->getXML($this));
                } else {
                    $parent->appendChild( $this->createNode($nodeName,$v) );
                }
            }
        } else if( is_bool($value) ) {
            $parent->appendChild( $this->createNode($nodeName, ($value)?'true':'false') );
        } else if( $value instanceOf DateTime ) {
            $parent->appendChild( $this->createNode($nodeName, $value->format('c') ));
        } else if($value instanceOf MarketplaceWebService_XML_DataType_Base ) {
            // $value is custom DataType
            $parent->appendChild($value->getXML($this));
        } else {
            // string, int, or float
            // Strip any non-ascii chars
            if( !is_numeric($value) )
                $value = preg_replace('/[^(\x20-\x7F)]*/', '', $value);
            $parent->appendChild( $this->createNode($nodeName, $value) );
        }
    }

    public function toString($formatOutput=true) {
        $this->xml->formatOutput = $formatOutput;
        return $this->xml->saveXML();
    }

    public function save($fileName, $formatOutput=true) {
        try {
            $this->xml->formatOutput =  $formatOutput;
            $this->xml->save($fileName);
        } catch(Exception $ex) {
            throw InvalidArgumentException("Unable to Save Feed in $fileName");
        }
    }

    public function createAttr($root,$name, $value ) {
		return $root->appendChild( $this->createAttrName($name) )->appendChild( $this->createAttrValue($value) );
	}
    protected function createAttrName($name) {
        return $this->xml->createAttribute($name);
	}
	protected function createAttrValue($value) {
        return $this->xml->createTextNode($value);
    }
    public function createNode($name,$value=null) {
        if( is_numeric($value) && $value === 0 )
            return $this->xml->createElement($name, $value);
        if( empty($value) )
            return $this->xml->createElement($name);
        else
            return $this->xml->createElement($name, $value);
    }

}
