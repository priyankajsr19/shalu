<?php
class MarketplaceWebService_XML_XMLBuilder
{
	private $xml;
	private $envelope;
	private $message;
	public function __construct($type,$merchantIdentifier,$version='1.01') {
		$this->xml = new DOMDocument("1.0");

		$this->envelope = $this->createNode('AmazonEnvelope');
		$this->createAttr( $this->envelope, 'xsi:noNamespaceSchemaLocation', 'amzn-envelope.xsd');
		$this->createAttr( $this->envelope, 'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');

		$header = $this->envelope->appendChild( $this->createNode('Header') );
		$header->appendChild( $this->createNode('DocumentVersion',$version) );
		$header->appendChild( $this->createNode('MerchantIdentifier',$merchantIdentifier) );

		$this->envelope->appendChild( $this->createNode('MessageType', $type) );
		$this->envelope->appendChild( $this->createNode('PurgeAndReplace', 'false') );
		$this->xml->appendChild($this->envelope);
	
	}
	private function createAttr($root,$name, $value ) {
		$root->appendChild( $this->createAttrName($name) )->appendChild( $this->createAttrValue($value) );
	}
	private function createAttrName($name) {
		return $this->xml->createAttribute($name);
	}
	private function createAttrValue($value) {
		return $this->xml->createTextNode($value);
	}
	private function createNode($name,$value="") {
		if( empty($value) )
			return $this->xml->createElement($name);
		else
			return $this->xml->createElement($name, $value);
	}
	public function toXMLString($formatOutput=true) {
		$this->xml->formatOutput = $formatOutput;
		return $this->xml->saveXML();
	}

	private function createMessage($message_id) {
		$this->message = $this->envelope->appendChild( $this->createNode('Message') );
		$this->message->appendChild( $this->createNode('MessageID',$message_id) );	
		$this->message->appendChild( $this->createNode('OperationType','Update') );	
	}
	
	public function createProduct($p, $parentageData, $attribute=null) {
		
		$isParent = $parentageData['isParent'];
		$isChild = $parentageData['isChild'];
		$hasChildren = $parentageData['hasChildren'];
		if( !$isParent && $isChild && !empty($attribute) )
			$id_sku = "ID-".(int)$p->id."-".$attribute['attribute_name'];
		else
			$id_sku = "ID-".(int)$p->id;
		

		$product = $this->message->appendChild( $this->createNode('Product') );

		$product->appendChild( $this->createNode( 'SKU' , $id_sku) );

		$condition = $product->appendChild( $this->createNode('Condition') );
		$condition->appendChild( $this->createNode('ConditionType','New') );

		$description = $product->appendChild( $this->createNode('DescriptionData') );
		$description->appendChild( $this->createNode('Title',(string)$p->name) );
		$description->appendChild( $this->createNode('Brand','IndusDiva') );
		$description->appendChild( $this->createNode('Description', (string)$p->description) );
		//Bullet Points
		if( isset($p->work_type) && $p->work_type != '' )
			$description->appendChild( $this->createNode('BulletPoint',(string)$p->work_type) );
		if( isset($p->garment_type) && $p->garment_type != '' )
			$description->appendChild( $this->createNode('BulletPoint',(string)$p->garment_type) );

		$measurements = array();
		if( isset($p->width) ) {	
			$p->width = trim($p->width);
			if(!empty($p->width) )
				array_push($measurements, "Length:".(string)$p->height." cm");
		}
		if( isset($p->height) ){
			$p->height = trim($p->height);
			if( !empty($p->height) )
				array_push($measurements, "Width:".(string)$p->width." meters");
		}
		if( isset($p->blouse_length)) {
			$p->blouse_length = trim($p->blouse_length);
			if( !empty($p->blouse_length) )
				array_push($measurements, "Blouse Length:".(string)$p->blouse_length." inches");
		}
		if( !empty($measurements) )
			$description->appendChild( $this->createNode('BulletPoint', implode(" - ",$measurements)) );
	
		$description->appendChild( $this->createNode('MerchantCatalogNumber',(string)$p->reference) );
		
		$tt = 0;
		if( is_array($p->tags) ) {
			foreach($p->tags[1] as $tag) {
				$description->appendChild( $this->createNode('SearchTerms', (string)$tag) );
				if( ++$tt > 5)
					break;
			}
		}
		$description->appendChild( $this->createNode('ItemType',"world-apparel") );
		$description->appendChild( $this->createNode('IsGiftWrapAvailable',"false") );
		$description->appendChild( $this->createNode('IsGiftMessageAvailable',"false") );
	
		$product_data = $product->appendChild( $this->createNode('ProductData') );
		$clothing = $product_data->appendChild( $this->createNode("Clothing") );

		$vdata = $clothing->appendChild( $this->createNode('VariationData'));
		if( $isParent || $isChild )  {
			$parentage = ($isParent)?'parent':'child';
			$vdata->appendChild( $this->createNode('Parentage',$parentage) );
		}
		if( !empty($attribute) )
			$vdata->appendChild( $this->createNode('Size', $attribute['attribute_name']) );
		if( isset($p->color) && !empty($p->color) )
			$vdata->appendChild( $this->createNode('Color', (string)$p->color) );
		$vdata->appendChild( $this->createNode('VariationTheme','Size') );


		$cdata = $clothing->appendChild($this->createNode('ClassificationData'));
		$cdata->appendChild( $this->createNode('ClothingType','Dress') );
		$cdata->appendChild( $this->createNode('Department','womens') );
		if( isset($p->generic_color) && !empty($p->generic_color) ) {
			$amazon_color = MarketplaceWebService_AmazonDataMap::getAmazonColor((string)$p->generic_color);
			if( $amazon_color  !== null )   
				$cdata->appendChild( $this->createNode('ColorMap', $amazon_color) );
		}
		if( isset($p->fabric) && !empty($p->fabric) )
			$cdata->appendChild( $this->createNode('MaterialAndFabric',(string)$p->fabric));
		$cdata->appendChild( $this->createNode('ModelNumber', $id_sku) );
		if( !empty($attribute) ) {
			$size = $attribute['attribute_name'];
			$amazon_size = MarketplaceWebService_AmazonDataMap::getAmazonSize($size);
			if( $amazon_size !== null )
				$cdata->appendChild( $this->createNode('SizeMap', $amazon_size) );
		}

		$wash_care = "Dry cleaning is the best method to wash";
		$cdata->appendChild( $this->createNode('FabricWash', $wash_care) );
		$cdata->appendChild( $this->createNode('TargetGender','female'));
		//$wash_care = "Dry cleaning is the best method to wash an apparel made of soft and delicate material. Never wrap silk apparel in plastic and trap the moisture; this could change the color and quality of the fabric in no time.";
		return $product;
	}
	public function makeParent($p,$product) {

	}

	public function makeChild($p,$product) {

	}

	public function addProduct($p, $message_id) {
	
		$this->createMessage($message_id);	

		$attributes = $p->getAttributesGroups(1);
			
		if( empty($attributes) ) {
			//this product has no variations (Sizes)
			$attribute = array();
			$attribute['attribute_name'] = 'One Size';
			$parentageData = array('isParent' => false,'isChild' => false,'hasChildren' => false);	
			$product = $this->createProduct($p,$parentageData, $attribute);
		} else {
			$parentageData = array('isParent' => true,'isChild' => false,'hasChildren' => true);	
			$product = $this->createProduct($p,$parentageData);
			foreach($attributes as $attribute) {
				$parentageData = array('isParent' => false,'isChild' => true,'hasChildren' => false);	
				$product = $this->createProduct($p,$parentageData, $attribute);
			}
		}

	}
	
}
