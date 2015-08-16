<?php
class MarketplaceWebService_XML_Data_Jewelry extends MarketplaceWebService_XML_Data_Product {
   
    public function __construct() {
        parent::__construct();
    }

    public function setProductType(MarketplaceWebService_XML_DataType_Base $value) {
        return $this->set('ProductType', $value);
    }
	public function setBatteryAverageLife($value) {
		return $this->set('BatteryAverageLife',$value);
	}
	public function setBatteryAverageLifeStandby($value) {
		return $this->set('BatteryAverageLifeStandby',$value);
	}
	public function setBatteryChargeTime($value) {
		return $this->set('BatteryChargeTime',$value);
	}
    public function setColor($value) {
        if( empty($value) )
            throw new InvalidArgumentException("Color value cannot be empty");
		return $this->set('Color',$value);
	}
	public function setDisplayLength($value) {
		return $this->set('DisplayLength',$value);
	}
	public function setDisplayVolume($value) {
		return $this->set('DisplayVolume',$value);
	}
	public function setDisplayWeight($value) {
		return $this->set('DisplayWeight',$value);
	}
	public function setMaxOrderQuantity($value) {
		return $this->set('MaxOrderQuantity',$value);
	}
	public function setMfgWarrantyDescriptionLabor($value) {
		return $this->set('MfgWarrantyDescriptionLabor',$value);
	}
	public function setMfgWarrantyDescriptionParts($value) {
		return $this->set('MfgWarrantyDescriptionParts',$value);
	}
	public function setMfgWarrantyDescriptionType($value) {
		return $this->set('MfgWarrantyDescriptionType',$value);
	}
	public function setStyleName($value) {
		return $this->set('StyleName',$value);
	}
	public function setPowerSource($value) {
		return $this->set('PowerSource',$value);
	}
	public function setRegionOfOrigin($value) {
		return $this->set('RegionOfOrigin',$value);
	}
	public function setSize($value) {
		return $this->set('Size',$value);
	}
	public function setSizeMap($value) {
		return $this->set('SizeMap',$value);
	}
	public function setWarnings($value) {
		return $this->set('Warnings',$value);
	}
	public function setWarrantyType($value) {
		return $this->set('WarrantyType',$value);
	}
	public function setModelNumber($value) {
		return $this->set('ModelNumber',$value);
    }
}
