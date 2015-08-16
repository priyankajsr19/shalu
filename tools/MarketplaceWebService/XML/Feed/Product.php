<?php
class MarketplaceWebService_XML_Feed_Product extends MarketplaceWebService_XML_Feed_Base {

    protected $product;

    public function __construct($config, $feedType) {
        parent::__construct($config, $feedType);
    }

    public function addProduct($object, $operationType="Update") {

        //create Message Tag 
        //common for all kinds of feeds
        //takes care of incrementing message id
        $this->newMessage($operationType);

        // order is very important - please do not change the order
        
        $this->product = $this->message->appendChild( $this->createNode('Product') );


        /* 
         *   addNode( parentNode, productObject, TAG )
         *
         *   If value of TAG is instanceOf MarketplaceWebService_XML_DataType_Base, the respective class should exist.
         *   If not, create a class.
         *   Refer MarketplaceWebService_XML_DataType_Dimension for example and Amazon XSD for class definition
         */

        $this->addNode($this->product, $object, 'SKU');
        $this->addNode($this->product, $object, 'StandardProductID');
        $this->addNode($this->product, $object, 'ProductTaxCode');
        $this->addNode($this->product, $object, 'LaunchDate');
        $this->addNode($this->product, $object, 'DiscontinueDate');
        $this->addNode($this->product, $object, 'ReleaseDate');
        $this->addNode($this->product, $object, 'ExternalProductUrl');
        $this->addNode($this->product, $object, 'OffAmazonChannel');
        $this->addNode($this->product, $object, 'OnAmazonChannel');
        $this->addNode($this->product, $object, 'Condition');
        $this->addNode($this->product, $object, 'Rebate');
        $this->addNode($this->product, $object, 'ItemPackageQuantity');
        $this->addNode($this->product, $object, 'NumberOfItems');
        $this->addNode($this->product, $object, 'LiquidVolume');

        if( $operationType === 'Delete' )
            return;

        // Start Description Data
        $this->desc_data = $this->product->appendChild( $this->createNode('DescriptionData') );
        $this->addNode($this->desc_data, $object, 'Title');
        $this->addNode($this->desc_data, $object, 'Brand');
        $this->addNode($this->desc_data, $object, 'Designer');
        $this->addNode($this->desc_data, $object, 'Description');
        $this->addNode($this->desc_data, $object, 'BulletPoint');
        $this->addNode($this->desc_data, $object, 'ItemDimensions');
        $this->addNode($this->desc_data, $object, 'PackageDimensions');
        $this->addNode($this->desc_data, $object, 'PackageWeight');
        $this->addNode($this->desc_data, $object, 'ShippingWeight');
        $this->addNode($this->desc_data, $object, 'MerchantCatalogNumber');
        $this->addNode($this->desc_data, $object, 'MSRP');
        $this->addNode($this->desc_data, $object, 'MaxOrderQuantity');
        $this->addNode($this->desc_data, $object, 'SerialNumberRequired');
        $this->addNode($this->desc_data, $object, 'Prop65');
        $this->addNode($this->desc_data, $object, 'CPSIAWarning');
        $this->addNode($this->desc_data, $object, 'CPSIAWarningDescription');
        $this->addNode($this->desc_data, $object, 'LegalDisclaimer');
        $this->addNode($this->desc_data, $object, 'Manufacturer');
        $this->addNode($this->desc_data, $object, 'MfrPartNumber');
        $this->addNode($this->desc_data, $object, 'SearchTerms');
        $this->addNode($this->desc_data, $object, 'PlatinumKeywords');
        $this->addNode($this->desc_data, $object, 'Memorabilia');
        $this->addNode($this->desc_data, $object, 'Autographed');
        $this->addNode($this->desc_data, $object, 'UsedFor');
        $this->addNode($this->desc_data, $object, 'ItemType');
        $this->addNode($this->desc_data, $object, 'OtherItemAttributes');
        $this->addNode($this->desc_data, $object, 'TargetAudience');
        $this->addNode($this->desc_data, $object, 'SubjectContent');
        $this->addNode($this->desc_data, $object, 'IsGiftWrapAvailable');
        $this->addNode($this->desc_data, $object, 'IsGiftMessageAvailable');
        $this->addNode($this->desc_data, $object, 'PromotionKeywords');
        $this->addNode($this->desc_data, $object, 'IsDiscontinuedByManufacturer');
        $this->addNode($this->desc_data, $object, 'DeliveryChannel');
        $this->addNode($this->desc_data, $object, 'PurchasingChannel');
        $this->addNode($this->desc_data, $object, 'MaxAggregateShipQuantity');
        $this->addNode($this->desc_data, $object, 'IsCustomizable');
        $this->addNode($this->desc_data, $object, 'CustomizableTemplateName');
        $this->addNode($this->desc_data, $object, 'RecommendedBrowseNode');
        $this->addNode($this->desc_data, $object, 'FEDAS_ID');
        $this->addNode($this->desc_data, $object, 'TSDAgeWarning');
        $this->addNode($this->desc_data, $object, 'TSDWarning');
        $this->addNode($this->desc_data, $object, 'TSDLanguage');
        $this->addNode($this->desc_data, $object, 'OptionalPaymentTypeExclusion');
        //End Description Data


        $this->addNode($this->product, $object, 'PromoTag');
        $this->addNode($this->product, $object, 'DiscoveryData');
        
    }
}
