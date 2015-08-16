<?php
class MarketplaceWebService_XML_Feed_Clothing extends MarketplaceWebService_XML_Feed_Product {

    public function __construct($config, $feedType) {
        parent::__construct($config, $feedType);
    }

    public function addProduct($object, $operationType="Update") {

        // First call parent add Product to build common Product XML
        parent::addProduct($object, $operationType);

        if( $operationType === 'Delete') 
            return;

        // Next build Clothing Specific XML Tags

        $pro_data = $this->product->appendChild( $this->createNode('ProductData') );
        $clothing = $pro_data->appendChild( $this->createNode('Clothing') );

        $variation_data = $clothing->appendChild( $this->createNode('VariationData'));
        $this->addNode($variation_data, $object, 'Parentage'); 
        $this->addNode($variation_data, $object, 'Size'); 
        $this->addNode($variation_data, $object, 'Color'); 
        $this->addNode($variation_data, $object, 'VariationTheme'); 

        $classification_data = $clothing->appendChild( $this->createNode('ClassificationData'));
        $this->addNode($classification_data, $object, 'BatteryAverageLife'); 
        $this->addNode($classification_data, $object, 'BatteryAverageLifeStandby'); 
        $this->addNode($classification_data, $object, 'BatteryChargeTime'); 
        $this->addNode($classification_data, $object, 'ClothingType'); 
        $this->addNode($classification_data, $object, 'Department'); 
        $this->addNode($classification_data, $object, 'StyleKeywords'); 
        $this->addNode($classification_data, $object, 'PlatinumKeywords'); 
        $this->addNode($classification_data, $object, 'ColorMap'); 
        $this->addNode($classification_data, $object, 'SpecialSizeType'); 
        $this->addNode($classification_data, $object, 'MaterialAndFabric'); 
        $this->addNode($classification_data, $object, 'ImportDesignation'); 
        $this->addNode($classification_data, $object, 'CountryAsLabeled'); 
        $this->addNode($classification_data, $object, 'FurDescription'); 
        $this->addNode($classification_data, $object, 'MaterialComposition'); 
        $this->addNode($classification_data, $object, 'MaterialOpacity'); 
        $this->addNode($classification_data, $object, 'InnerMaterial'); 
        $this->addNode($classification_data, $object, 'OuterMaterial'); 
        $this->addNode($classification_data, $object, 'SoleMaterial'); 
        $this->addNode($classification_data, $object, 'ShoeClosureType'); 
        $this->addNode($classification_data, $object, 'ApparelClosureType'); 
        $this->addNode($classification_data, $object, 'ClosureType'); 
        $this->addNode($classification_data, $object, 'CareInstructions'); 
        $this->addNode($classification_data, $object, 'OccasionAndLifestyle'); 
        $this->addNode($classification_data, $object, 'EventKeywords'); 
        $this->addNode($classification_data, $object, 'Season'); 
        $this->addNode($classification_data, $object, 'SpecificUses'); 
        $this->addNode($classification_data, $object, 'ExternalTestingCertification'); 
        $this->addNode($classification_data, $object, 'PerformanceRating'); 
        $this->addNode($classification_data, $object, 'ProductSpecification'); 
        $this->addNode($classification_data, $object, 'Warnings'); 
        $this->addNode($classification_data, $object, 'IsCustomizable'); 
        $this->addNode($classification_data, $object, 'CustomizableTemplateName'); 
        $this->addNode($classification_data, $object, 'StyleName'); 
        $this->addNode($classification_data, $object, 'CollarType'); 
        $this->addNode($classification_data, $object, 'SleeveType'); 
        $this->addNode($classification_data, $object, 'WaistStyle'); 
        $this->addNode($classification_data, $object, 'MinimumHeightRecommended'); 
        $this->addNode($classification_data, $object, 'MaximumHeightRecommended'); 
        $this->addNode($classification_data, $object, 'CountryName'); 
        $this->addNode($classification_data, $object, 'CountryOfOrigin'); 
        $this->addNode($classification_data, $object, 'DisplayLength'); 
        $this->addNode($classification_data, $object, 'DisplayVolume'); 
        $this->addNode($classification_data, $object, 'DisplayWeight'); 
        $this->addNode($classification_data, $object, 'ModelName'); 
        $this->addNode($classification_data, $object, 'ModelNumber'); 
        $this->addNode($classification_data, $object, 'ModelYear'); 
        $this->addNode($classification_data, $object, 'IsAdultProduct'); 
        $this->addNode($classification_data, $object, 'SizeMap'); 
        $this->addNode($classification_data, $object, 'WaistSize'); 
        $this->addNode($classification_data, $object, 'InseamLength'); 
        $this->addNode($classification_data, $object, 'SleeveLength'); 
        $this->addNode($classification_data, $object, 'NeckSize'); 
        $this->addNode($classification_data, $object, 'ChestSize'); 
        $this->addNode($classification_data, $object, 'CupSize'); 
        $this->addNode($classification_data, $object, 'BraBandSize'); 
        $this->addNode($classification_data, $object, 'ShoeWidth'); 
        $this->addNode($classification_data, $object, 'HeelHeight'); 
        $this->addNode($classification_data, $object, 'HeelType'); 
        $this->addNode($classification_data, $object, 'ShaftHeight'); 
        $this->addNode($classification_data, $object, 'ShaftDiameter');
        $this->addNode($classification_data, $object, 'BeltLength');
        $this->addNode($classification_data, $object, 'BeltWidth');
        $this->addNode($classification_data, $object, 'BeltStyle');
        $this->addNode($classification_data, $object, 'BottomStyle');
        $this->addNode($classification_data, $object, 'ButtonQuantity');
        $this->addNode($classification_data, $object, 'Character');
        $this->addNode($classification_data, $object, 'ControlType');
        $this->addNode($classification_data, $object, 'CuffType');
        $this->addNode($classification_data, $object, 'FabricType');
        $this->addNode($classification_data, $object, 'FabricWash');
        $this->addNode($classification_data, $object, 'FitType');
        $this->addNode($classification_data, $object, 'FrontPleatType');
        $this->addNode($classification_data, $object, 'IncludedComponents');
        $this->addNode($classification_data, $object, 'ItemRise');
        $this->addNode($classification_data, $object, 'LaptopCapacity');
        $this->addNode($classification_data, $object, 'LegDiameter');
        $this->addNode($classification_data, $object, 'LegStyle');
        $this->addNode($classification_data, $object, 'MaterialType');
        $this->addNode($classification_data, $object, 'MfrWarrantyDescriptionLabor');
        $this->addNode($classification_data, $object, 'MfrWarrantyDescriptionParts');
        $this->addNode($classification_data, $object, 'MfrWarrantyDescriptionType');
        $this->addNode($classification_data, $object, 'NeckStyle');
        $this->addNode($classification_data, $object, 'Opacity');
        $this->addNode($classification_data, $object, 'PatternStyle');
        $this->addNode($classification_data, $object, 'CollectionName');
        $this->addNode($classification_data, $object, 'FrameMaterialType');
        $this->addNode($classification_data, $object, 'LensMaterialType');
        $this->addNode($classification_data, $object, 'PolarizationType');
        $this->addNode($classification_data, $object, 'LensWidth');
        $this->addNode($classification_data, $object, 'LensHeight');
        $this->addNode($classification_data, $object, 'BridgeWidth');
        $this->addNode($classification_data, $object, 'PocketDescription');
        $this->addNode($classification_data, $object, 'RegionOfOrigin');
        $this->addNode($classification_data, $object, 'RiseStyle');
        $this->addNode($classification_data, $object, 'SafetyWarning');
        $this->addNode($classification_data, $object, 'SellerWarrantyDescription');
        $this->addNode($classification_data, $object, 'SpecialFeature');
        $this->addNode($classification_data, $object, 'TargetGender'); 
        $this->addNode($classification_data, $object, 'Theme');
        $this->addNode($classification_data, $object, 'TopStyle');
        $this->addNode($classification_data, $object, 'UnderwireType');
        $this->addNode($classification_data, $object, 'Volume');
        $this->addNode($classification_data, $object, 'WaterResistanceLevel'); 
        $this->addNode($classification_data, $object, 'WheelType');
        $this->addNode($classification_data, $object, 'FurisodeLength');
        $this->addNode($classification_data, $object, 'FurisodeWidth');
        $this->addNode($classification_data, $object, 'ObiLength');
        $this->addNode($classification_data, $object, 'ObiWidth');
        $this->addNode($classification_data, $object, 'TsukeobiWidth');
        $this->addNode($classification_data, $object, 'TsukeobiHeight');
        $this->addNode($classification_data, $object, 'PillowSize');
        $this->addNode($classification_data, $object, 'StrapType');
        $this->addNode($classification_data, $object, 'ToeShape');
        $this->addNode($clothing, $object, 'Battery');
        $this->addNode($clothing, $object, 'LithiumBatteryEnergyContent');
        $this->addNode($clothing, $object, 'LithiumBatteryPackaging');
        $this->addNode($clothing, $object, 'LithiumBatteryVoltage');
        $this->addNode($clothing, $object, 'LithiumBatteryWeight');
        $this->addNode($clothing, $object, 'NumberOfLithiumIonCells');
        $this->addNode($clothing, $object, 'NumberOfLithiumMetalCells');
        $this->addNode($clothing, $object, 'PowerSource');
        $this->addNode($clothing, $object, 'ItemLengthDescription');

    }
}
