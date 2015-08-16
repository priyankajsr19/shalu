<?php
class MarketplaceWebService_XML_Data_Clothing extends MarketplaceWebService_XML_Data_Product {
   
    public function __construct() {
        parent::__construct();
    }

    public function setParentage($value) {
        if (!in_array($value, array('parent', 'child'))) {
            throw new InvalidArgumentException('Invalid parentage value');
        }
        return $this->set('Parentage', $value);
    }
    public function setSize($value) {
        return $this->set('Size', $value);
    }
    public function setColor($value) {
        if (strlen($value) >  50)
            throw new InvalidArgumentException("Color value length should be <= 50. Given $value with length ".strlen($value));
        return $this->set('Color', $value);
    }
    public function setVariationTheme($value) {
        if (!in_array($value, array('Size', 'Color', 'SizeColor'))) {
            throw new InvalidArgumentException('Invalid variation theme');
        }

        return $this->set('VariationTheme', $value);
    }
    public function setClothingType($value) {
        if (!in_array($value, array(
                'Shirt',
                'Sweater',
                'Pants',
                'Shorts',
                'Skirt',
                'Dress',
                'Suit',
                'Blazer',
                'Outerwear',
                'SocksHosiery',
                'Underwear',
                'Bra',
                'Shoes',
                'Hat',
                'Bag',
                'Accessory',
                'Jewelry',
                'Sleepwear',
                'Swimwear',
                'PersonalBodyCare',
                'HomeAccessory',
                'NonApparelMisc',
                'Kimono',
                'Obi',
                'Chanchanko',
                'Jinbei',
                'Yukata'
            ))) {
            throw new InvalidArgumentException('Invalid clothing type');
        }
        return $this->set('ClothingType', $value);
    }

    public function addDepartment($value) {
        if (!in_array($value, array(
                'mens',
                'womens',
                'boys',
                'girls',
                'baby-boys',
                'baby-girls',
                'unisex-adult',
                'unisex-baby',
                'unisex-child'
            ))) {
            throw new InvalidArgumentException('Department');
	}
        return $this->add('Department', $value, 10);
    }

    public function addStyleKeywords($value) {
        return $this->add('StyleKeywords', $value, 10);
    }
    
    public function setColorMap($value) {
        if (!in_array($value, array(
				"Blue",
				"Green",
				"Multi",
				"Purple",
				"Red",
				"Pink",
				"Yellow",
				"Red",
				"White",
				"Black",
				"Brown",
				"White",
				"Gold",
				"Pink",
				"Orange",
				"Beige",
				"Gray",
                "Off White"
        ))) {
             throw new InvalidArgumentException('Invalid ColorMap');
        }    
        return $this->set('ColorMap', $value);
    }
    
    public function addSpecialSizeType($value) {
        return $this->set('SpecialSizeType', $value, 10);
    }

    public function addMaterialAndFabric($value) {
        return $this->set('MaterialAndFabric', $value, 4);
    }

    public function setMaterialComposition($value) {
        return $this->set('MaterialComposition', $value);
    }

    public function setMaterialOpacity($value) {
        return $this->set('MaterialOpacity', $value);
    }

    public function setFabricWash($value) {
        return $this->set('FabricWash',$value);
    }

    public function setTargetGender($value) {
        if (!in_array($value, array(
            'male',
            'female',
            'unisex'
        ))) {
            throw new InvalidArgumentException('Invalid Target Gender');
        }
        $this->add('TargetGender',$value);
    }

    public function setInnerMaterial($value) {
        return $this->set('InnerMaterial', $value);
    }

    public function setOuterMaterial($value) {
        return $this->set('OuterMaterial', $value);
    }

    public function setSoleMaterial($value) {
        return $this->set('SoleMaterial', $value);
    }

    public function setShoeClosureType($value) {
        return $this->set('ShoeClosureType', $value);
    }

    public function setApparelClosureType($value) {
        return $this->set('ApparelClosureType', $value);
    }

    public function setCareInstructions($value) {
        return $this->set('CareInstructions', $value);
    }

    public function addOccasionAndLifestyle($value) {
        return $this->add('OccasionAndLifestyle', $value, 10);
    }

    public function addEventKeywords($value) {
        return $this->add('EventKeywords', $value, 10);
    }

    public function setSeason($value) {
        return $this->set('Season', $value);
    }

    public function addSpecificUses($value) {
        return $this->add('SpecificUses', $value, 3);
    }

    public function addExternalTestingCertification($value) {
        return $this->add('ExternalTestingCertification', $value, 5);
    }

    public function addPerformanceRating($value) {
        if (!in_array($value, array(
                'Sunproof',
                'Waterproof',
                'Weatherproof',
                'Windproof'
            ))) {
            throw new InvalidArgumentException('Invalid performance rating');
        }

        return $this->add('PerformanceRating', $value, 3);
    }

    public function setProductSpecification($value) {
        return $this->set('ProductSpecification', $value);
    }

    public function setWarnings($value) {
        return $this->set('Warnings', $value);
    }

    public function setIsCustomizable($value) {
        return $this->set('IsCustomizable', (bool) $value);
    }

    public function setStyleName($value) {
        return $this->set('StyleName', $value);
    }

    public function setCollarType($value) {
        return $this->set('CollarType', $value);
    }

    public function setSleeveType($value) {
        return $this->set('SleeveType', $value);
    }

    public function setWaistStyle($value) {
        return $this->set('WaistStyle', $value);
    }

    public function setMinimumHeightRecommended(MarketPlaceWebService_XML_Datatype_LengthDimension $value) {
        return $this->set('MinimumHeightRecommended', $value);
    }
    
    public function setMaximumHeightRecommended(MarketPlaceWebService_XML_Datatype_LengthDimension $value) {
        return $this->set('MaximumHeightRecommended', $value);
    }

    public function setCountryOfOrigin($value) {
        if (strlen($value) != 2) {
            throw new InvalidArgumentException('Invalid country code');
        }

        return $this->set('CountryOfOrigin', $value);
    }

    public function setModelName($value) {
        if( strlen($value) < 1 || strlen($value) > 50 ) {
            throw new InvalidArgumentException("ModelName:$value length is not between 1 and 50");
        }
        return $this->set('ModelName', $value);
    }

    public function setModelNumber($value) {
        if( strlen($value) < 1 || strlen($value) > 40 ) {
            throw new InvalidArgumentException("ModelNumber:$value length is not between 1 and 40");
        }
        return $this->set('ModelNumber', $value);
    }

    public function setModelYear($value) {
        return $this->set('ModelYear', $value);
    }

    public function setIsAdultProduct($value) {
        return $this->set('IsAdultProduct', (bool) $value);
    }

    public function setSizeMap($value) {
        if (!in_array($value, array(
                'XXXXX-Small',
                'XXXX-Small',
                'XXX-Small',
                'XX-Small',
                'X-Small',
                'Small',
                'Medium',
                'Large',
                'X-Large',
                'XX-Large',
                'XXX-Large',
                'XXXX-Large',
                'XXXXX-Large'
            ))) {
            throw new InvalidArgumentException('Invalid SizeMap Value');
        }
        return $this->set('SizeMap', $value);
    }

    public function setWaistSize(MarketPlaceWebService_XML_Datatype_ClothingSizeDimension $value) {
        return $this->set('WaistSize', $value);
    }

    public function setInseamLength(MarketPlaceWebService_XML_Datatype_ClothingSizeDimension $value) {
        return $this->set('InseamLength', $value);
    }

    public function setSleeveLength(MarketPlaceWebService_XML_Datatype_ClothingSizeDimension $value) {
        return $this->set('SleeveLength', $value);
    }

    public function setNeckSize(MarketPlaceWebService_XML_Datatype_ClothingSizeDimension $value) {
        return $this->set('NeckSize', $value);
    }

    public function setChestSize(MarketPlaceWebService_XML_Datatype_ClothingSizeDimension $value) {
        return $this->set('ChestSize', $value);
    }

    public function setCupSize($value) {
        if (!in_array($value, array(
                'A', 'AA', 'B', 'C', 'D', 'DD', 'DDD', 'E', 'EE', 'F', 'FF', 'G', 'GG', 'H', 'I', 'J', 'Free'
            ))) {
            throw new InvalidArgumentException('Invalid cup size');
        }

        return $this->set('CupSize', $value);
    }

    public function setBraBandSize(MarketPlaceWebService_XML_Datatype_LengthDimension $value) {
        return $this->set('BraBandSize', $value);
    }

    public function setShoeWidth($value) {
        if (!in_array($value, array(
                'AAAA', 'AAA', 'AA', 'A', 'B', 'C', 'D', 'E', 'EE', 'EEE', 'EEEE', 'EEEEE', 'F', 'G'
            ))) {
            throw new InvalidArgumentException('Invalid shoe width');
        }

        return $this->set('ShoeWidth', $value);
    }
    
    public function setHeelHeight(MarketPlaceWebService_XML_Datatype_LengthDimension $value) {
        return $this->set('HeelHeight', $value);
    }

    public function setShaftDiameter($value) {
        return $this->set('ShaftDiameter', $value);
    }

    public function setBeltLength(MarketPlaceWebService_XML_Datatype_LengthDimension $value) {
        return $this->set('BeltLength', $value);
    }

    public function setBeltWidth(MarketPlaceWebService_XML_Datatype_LengthDimension $value) {
        return $this->set('BelthWidth', $value);
    }

    public function setFurisodeLength(MarketPlaceWebService_XML_Datatype_LengthDimension $value) {
        return $this->set('FurisodeLength', $value);
    }

    public function setFurisodeWidth(MarketPlaceWebService_XML_Datatype_LengthDimension $value) {
        return $this->set('FurisodeWidth', $value);
    }

    public function setObiLength(MarketPlaceWebService_XML_Datatype_LengthDimension $value) {
        return $this->set('ObiLength', $value);
    }

    public function setObiWidth(MarketPlaceWebService_XML_Datatype_LengthDimension $value) {
        return $this->set('ObiWidth', $value);
    }

    public function setTsukeobiWidth(MarketPlaceWebService_XML_Datatype_LengthDimension $value) {
        return $this->set('TsukeobiWidth', $value);
    }

    public function setTsukeobiHeight(MarketPlaceWebService_XML_Datatype_LengthDimension $value) {
        return $this->set('TsukeobiHeight', $value);
    }

    public function setPillowSize($value) {
        return $this->seT('PillowSize', $value);
    }
}	
