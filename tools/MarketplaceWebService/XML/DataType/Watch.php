<?php
class MarketplaceWebService_XML_DataType_Watch extends MarketplaceWebService_XML_DataType_Base {
    public function __construct() {
        parent::__construct();
    }

    public function setParentage($value) {
        if (!in_array($value, array('parent', 'child'))) {
            throw new InvalidArgumentException('Invalid parentage value');
        }
        return $this->set('Parentage', $value);
    }
    public function setVariationTheme($value) {
        if (!in_array($value, array('BandColor', 'Color', 'StyleName'))) {
            throw new InvalidArgumentException('Invalid variation theme');
        }
        return $this->set('VariationTheme', $value);
    }
	public function setBandColor($value) {
		$this->set('BandColor',$value);
	}
	public function setBandMaterial($value) {
		$this->set('BandMaterial',$value);
	}
	public function setBandLength($value) {
		$this->set('BandLength',$value);
	}
	public function setBandWidth($value) {
		$this->set('BandWidth',$value);
	}
	public function setNumberOfItems($value) {
		$this->set('NumberOfItems',$value);
	}
	public function setBatteryAverageLife($value) {
		$this->set('BatteryAverageLife',$value);
	}
	public function setBatteryAverageLifeStandby($value) {
		$this->set('BatteryAverageLifeStandby',$value);
	}
	public function setBatteryChargeTime($value) {
		$this->set('BatteryChargeTime',$value);
	}
	public function setCollectionName($value) {
		$this->set('CollectionName',$value);
	}
	public function setClaspType($value) {
		$this->set('ClaspType',$value);
	}
	public function addCaseMaterial($value) {
		$this->add('CaseMaterial',$value,2);
	}
	public function setCaseSizeThickness($value) {
		$this->set('CaseSizeThickness',$value);
	}
	public function setCaseSizeDiameter($value) {
		$this->set('CaseSizeDiameter',$value);
	}
	public function addLifeStyle($value) {
		$this->add('LifeStyle',$value,2);
	}
	public function addSpecificUsesForProduct($value) {
		$this->add('SpecificUsesForProduct',$value, 3);
	}
	public function setMetalStamp($value) {
		$this->set('MetalStamp',$value);
	}
	public function setSettingType($value) {
		$this->set('SettingType',$value);
	}
	public function setDialColor($value) {
		$this->set('DialColor',$value);
	}
	public function setDialColorMap($value) {
		$this->set('DialColorMap',$value);
	}
	public function setBezelMaterial($value) {
		$this->set('BezelMaterial',$value);
	}
	public function setBezelFunction($value) {
		$this->set('BezelFunction',$value);
	}
	public function setGemType($value) {
		$this->set('GemType',$value);
	}
	public function setCrystal($value) {
		$this->set('Crystal',$value);
	}
	public function setMovementType($value) {
		$this->set('MovementType',$value);
	}
	public function setCalendarType($value) {
		$this->set('CalendarType',$value);
	}
	public function setWaterResistantDepth($value) {
		$this->set('WaterResistantDepth',$value);
	}
	public function setResaleType($value) {
		$this->set('ResaleType',$value);
	}
	public function setWarrantyType($value) {
		$this->set('WarrantyType',$value);
	}
	public function setIncludedItems($value)  {
		$this->set('IncludedItems',$value);
	}
	public function setSellerWarrantyDescription($value) {
		$this->set('SellerWarrantyDescription',$value);
	}
	public function setSizeMap($value) {
		$this->set('SizeMap',$value);
	}
	public function setEstatePeriod($value) {
		$this->set('EstatePeriod',$value);
	}
	public function setCountryOfOrigin($value) {
		$this->set('CountryOfOrigin',$value);
	}
	public function setRegionOfOrigin($value) {
		$this->set('RegionOfOrigin',$value);
	}
	public function setItemShape($value) {
		$this->set('ItemShape',$value);
	}
	public function addSpecialFeatures($value) {
		$this->add('SpecialFeatures',$value, 5);
	}
	public function setDisplayLength($value) {
		$this->set('DisplayLength',$value);
	}
	public function setDisplayType($value) {
		$this->set('DisplayType',$value);
	}
	public function setDisplayVolume($value) {
		$this->set('DisplayVolume',$value);
	}
	public function setDisplayWeight($value) {
		$this->set('DisplayWeight',$value);
	}
	public function setMaximumWaterPressure($value) {
		$this->set('MaximumWaterPressure',$value);
	}
	public function setModelYear($value) {
		$this->set('ModelYear',$value);
	}
	public function setWarnings($value) {
		$this->set('Warnings',$value);
	}
	public function setSeason($value) {
		$this->set('Season',$value);
	}
	public function setPowerSource($value) {
		$this->set('PowerSource',$value);
	}
	public function setIsAdultProduct($value) {
		$this->set('IsAdultProduct',$value);
	}
	public function addSportType($value) {
		$this->add('SportType',$value,3);
    }
    public function setTargetGender($value) {
        if( !in_array($value, array(
            'male',
            'female',
            'unisex'
        ))) throw new InvalidArgumentException("Invalue Gender value $value");
        $this->set('TargetGender', $value);
    }
	public function setBatteryTypeLithiumIon($value){
		$this->set('BatteryTypeLithiumIon',$value);
	}
	public function setBatteryTypeLithiumMetal($value){
		$this->set('BatteryTypeLithiumMetal',$value);
	}
	public function setLithiumBatteryEnergyContent($value){
		$this->set('LithiumBatteryEnergyContent',$value);
	}
    public function setLithiumBatteryPackaging($value) {
        if( !in_array($value, array(
            'batteries_contained_in_equipment',
            'batteries_only',
            'batteries_packed_with_equipment'
        ))) throw new InvalidArgumentException("Invalid LithiumBatteryPackaging value $value");
        $this->set('LithiumBatteryPackaging', $value);
    }

	public function setLithiumBatteryVoltage($value){
		$this->set('LithiumBatteryVoltage',$value);
	}
	public function setLithiumBatteryWeight($value){
		$this->set('LithiumBatteryWeight',$value);
	}
	public function setManufacturerWarrantyType($value){
		$this->set('ManufacturerWarrantyType',$value);
	}
	public function setMaxOrderQuantity($value){
		$this->set('MaxOrderQuantity',$value);
	}
	public function setMfgWarrantyDescriptionLabor($value){
		$this->set('MfgWarrantyDescriptionLabor',$value);
	}
	public function setMfgWarrantyDescriptionParts($value){
		$this->set('MfgWarrantyDescriptionParts',$value);
	}
	public function setNumberOfLithiumIonCells($value){
		$this->set('NumberOfLithiumIonCells',$value);
	}
	public function setNumberOfLithiumMetalCells($value){
		$this->set('NumberOfLithiumMetalCells',$value);
	}
	public function setBattery($value){
		$this->set('Battery',$value);
    }
    public function getXML($feed) {
        $watch = $feed->createNode('Watch');
        $parentage = $this->get('Parentage');
        $vtheme = $this->get('VariationTheme');
        if( !empty($parentage) || !empty($vtheme) ) {
            $variation_data = $watch->appendChild( $feed->createNode('VariationData') );
            $feed->addNode($variation_data, $this, 'Parentage');
            $feed->addNode($variation_data, $this, 'VariationTheme');
        }
		$feed->addNode($watch, $this,'BandColor');
		$feed->addNode($watch, $this,'BandMaterial');
		$feed->addNode($watch, $this,'BandLength');
		$feed->addNode($watch, $this,'BandWidth');
		$feed->addNode($watch, $this,'NumberOfItems');
		$feed->addNode($watch, $this,'BatteryAverageLife');
		$feed->addNode($watch, $this,'BatteryAverageLifeStandby');
		$feed->addNode($watch, $this,'BatteryChargeTime');
		$feed->addNode($watch, $this,'CollectionName');
		$feed->addNode($watch, $this,'ClaspType');
		$feed->addNode($watch, $this,'CaseMaterial');
		$feed->addNode($watch, $this,'CaseSizeThickness');
		$feed->addNode($watch, $this,'CaseSizeDiameter');
		$feed->addNode($watch, $this,'LifeStyle');
		$feed->addNode($watch, $this,'SpecificUsesForProduct');
		$feed->addNode($watch, $this,'MetalStamp');
		$feed->addNode($watch, $this,'SettingType');
		$feed->addNode($watch, $this,'DialColor');
		$feed->addNode($watch, $this,'DialColorMap');
		$feed->addNode($watch, $this,'BezelMaterial');
		$feed->addNode($watch, $this,'BezelFunction');
		$feed->addNode($watch, $this,'GemType');
		$feed->addNode($watch, $this,'Crystal');
		$feed->addNode($watch, $this,'MovementType');
		$feed->addNode($watch, $this,'CalendarType');
		$feed->addNode($watch, $this,'WaterResistantDepth');
		$feed->addNode($watch, $this,'ResaleType');
		$feed->addNode($watch, $this,'WarrantyType');
		$feed->addNode($watch, $this,'IncludedItems');
		$feed->addNode($watch, $this,'SellerWarrantyDescription');
		$feed->addNode($watch, $this,'SizeMap');
		$feed->addNode($watch, $this,'EstatePeriod');
		$feed->addNode($watch, $this,'CountryOfOrigin');
		$feed->addNode($watch, $this,'RegionOfOrigin');
		$feed->addNode($watch, $this,'ItemShape');
		$feed->addNode($watch, $this,'SpecialFeatures');
		$feed->addNode($watch, $this,'DisplayLength');
		$feed->addNode($watch, $this,'DisplayType');
		$feed->addNode($watch, $this,'DisplayVolume');
		$feed->addNode($watch, $this,'DisplayWeight');
		$feed->addNode($watch, $this,'MaximumWaterPressure');
		$feed->addNode($watch, $this,'ModelYear');
		$feed->addNode($watch, $this,'Warnings');
		$feed->addNode($watch, $this,'Season');
		$feed->addNode($watch, $this,'PowerSource');
		$feed->addNode($watch, $this,'IsAdultProduct');
		$feed->addNode($watch, $this,'SportType');
		$feed->addNode($watch, $this,'TargetGender" minOccurs="0">');
		$feed->addNode($watch, $this,'BatteryTypeLithiumIon');
		$feed->addNode($watch, $this,'BatteryTypeLithiumMetal');
		$feed->addNode($watch, $this,'LithiumBatteryEnergyContent');
		$feed->addNode($watch, $this,'LithiumBatteryPackaging" minOccurs="0">');
		$feed->addNode($watch, $this,'LithiumBatteryVoltage');
		$feed->addNode($watch, $this,'LithiumBatteryWeight');
		$feed->addNode($watch, $this,'ManufacturerWarrantyType');
		$feed->addNode($watch, $this,'MaxOrderQuantity');
		$feed->addNode($watch, $this,'MfgWarrantyDescriptionLabor');
		$feed->addNode($watch, $this,'MfgWarrantyDescriptionParts');
		$feed->addNode($watch, $this,'NumberOfLithiumIonCells');
		$feed->addNode($watch, $this,'NumberOfLithiumMetalCells');
		$feed->addNode($watch, $this,'Battery');
        return $watch;
    }
}
