<?php
class MarketplaceWebService_XML_Feed_Jewelry extends MarketplaceWebService_XML_Feed_Product {

    public function __construct($config, $feedType) {
        parent::__construct($config, $feedType);
    }

    public function addProduct($object, $operationType="Update") {

        // First call parent add Product to build common Product XML
        parent::addProduct($object, $operationType);

        if( $operationType === 'Delete') 
            return;

        // Next build Jewelry Specific XML Tags

        $pro_data = $this->product->appendChild( $this->createNode('ProductData') );
        
        $jewelry = $pro_data->appendChild( $this->createNode('Jewelry') );
        $productType = $jewelry->appendChild( $this->createNode('ProductType') );
        $this->addNode($productType, $object, 'ProductType'); 
		$this->addNode($jewelry, $object, 'BatteryAverageLife');
		$this->addNode($jewelry, $object, 'BatteryAverageLifeStandby');
		$this->addNode($jewelry, $object, 'BatteryChargeTime');
		$this->addNode($jewelry, $object, 'Color');
		$this->addNode($jewelry, $object, 'DisplayLength');
		$this->addNode($jewelry, $object, 'DisplayVolume');
		$this->addNode($jewelry, $object, 'DisplayWeight');
		$this->addNode($jewelry, $object, 'MaxOrderQuantity');
		$this->addNode($jewelry, $object, 'MfgWarrantyDescriptionLabor');
		$this->addNode($jewelry, $object, 'MfgWarrantyDescriptionParts');
		$this->addNode($jewelry, $object, 'MfgWarrantyDescriptionType');
		$this->addNode($jewelry, $object, 'StyleName');
		$this->addNode($jewelry, $object, 'PowerSource');
		$this->addNode($jewelry, $object, 'RegionOfOrigin');
		$this->addNode($jewelry, $object, 'Size');
		$this->addNode($jewelry, $object, 'SizeMap');
		$this->addNode($jewelry, $object, 'Warnings');
		$this->addNode($jewelry, $object, 'WarrantyType');
		$this->addNode($jewelry, $object, 'ModelNumber');

    }
}
