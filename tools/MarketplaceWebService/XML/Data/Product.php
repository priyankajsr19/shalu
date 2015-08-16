<?php
abstract class MarketplaceWebService_XML_Data_Product extends MarketplaceWebService_XML_Data_Base {
    
    public function __construct() {
        parent::__construct();
    }

    public function setSKU($value) {
        return $this->set('SKU',$value);
    }
    public function setStandardProductId(MarketPlaceWebService_XML_Datatype_StandardProductID $productId) {
        return $this->set('StandardProductID', $productId);
    }
    public function setProductTaxCode($value) {
        return $this->set('ProductTaxCode', $value);
    }
    public function setLaunchDate(DateTime $value) {
        return $this->set('LaunchDate', $value);
    }
    public function setDiscontinueDate(DateTime $value) {
        return $this->set('DiscontinueDate', $value);
    }
    public function setReleaseDate(DateTime $value){
        return $this->set('ReleaseDate', $value);
    }
    public function setCondition(MarketPlaceWebService_XML_Datatype_Condition $value) {
        return $this->set('Condition', $value);
    }
    public function addRebate($value) {
        return $this->add('Rebate', $value, 2);
    }
    public function setItemPackageQuantity($value) {
        return $this->set('ItemPackageQuantity', $value);
    }
    public function setNumberOfItems($value) {
        return $this->set('NumberOfItems', $value);
    }
    public function setTitle($value) {
        if( strlen($value) < 1 || strlen($value) > 80 ) {
            throw new InvalidArgumentException("Title:$value length is not between 1 and 80");
        }
        return $this->set('Title', $value);
    }
    public function setBrand($value) {
        if( strlen($value) < 1 || strlen($value) > 50 ) {
            throw new InvalidArgumentException("Brand:$value length is not between 1 and 50");
        }
        return $this->set('Brand', $value);
    }
    public function setDesigner($value) {
        return $this->set('Designer', $value);
    }
    public function setDescription($value) {
        if( strlen($value) < 1 || strlen($value) > 2000 ) {
            throw new InvalidArgumentException("Description:$value length is not between 1 and 2000");
        }
        return $this->set('Description', $value);
    }
    public function addBulletPoint($value) {
        if( strlen($value) < 1 || strlen($value) > 100 ) {
            throw new InvalidArgumentException("BulletPoint:$value length is not between 1 and 100");
        }
        return $this->add('BulletPoint', $value, 5);
    }
    public function setItemDimensions(MarketPlaceWebService_XML_Datatype_Dimenstions $dimensions) {
        return $this->set('ItemDimensions', $dimensions);
    }
    public function setPackageDimensions(MarketPlaceWebService_XML_Datatype_PackageDimensions $packageDimensions) {
        return $this->set('PackageDimensions', $packageDimensions);
    }
    public function setPackageWeight(DataType_WeightDimension $weight) {
        return $this->set('PackageWeight', $weight);
    }
    public function setShippingWeight(DataType_WeightDimension $weight) {
        return $this->set('ShippingWeight', $weight);
    }
    public function setMerchantCatalogNumber($value) {
        return $this->set('MerchantCatalogNumber', $value);
    }
    public function setMsrp(DataType\CurrencyAmount $value) {
        return $this->set('MSRP', $value);
    }
    public function setMaxOrderQuantity($value) {
        return $this->set('MaxOrderQuantity', $value);
    }
    public function setSerialNumberRequired($value) {
        return $this->set('SerialNumberRequired', (bool) $value);
    }
    public function setProp65($value) {
        return $this->set('Prop65', (bool) $value);
    }
    public function addCPSIAWarning($value) {
        if (!in_array($value, array(
                'choking_hazard_balloon',
                'choking_hazard_contains_a_marble',
                'choking_hazard_contains_small_ball' .
                'choking_hazard_is_a_marble',
                'choking_hazard_is_a_small_ball',
                'choking_hazard_small_parts',
                'no_warning_applicable'
            ))) {
            throw new InvalidArgumentException('Invalid value for CPSIAWarning');
        }
        return $this->add('CPSIAWarning', $value, 4);
    }
	public function setCPSIAWarningDescription($value) {
        return $this->set('CPSIAWarningDescription', $value);
    }
	public function setLegalDisclaimer($value) {
        return $this->set('LegalDisclaimer', $value);
    }
	public function setManufacturer($value) {
        return $this->set('Manufacturer', $value);
    }
	public function setMfrPartNumber($value) {
        return $this->set('MfrPartNumber', $value);
    }
	public function addSearchTerms($value) {
        if( strlen($value) < 1 || strlen($value) > 50 ) {
            throw new InvalidArgumentException("Search Term:$value length is not between 1 and 50");
        }
        return $this->add('SearchTerms', $value, 5);
    }
    public function addPlatinumKeywords($value) {
        return $this->add('PlatinumKeywords', $value, 20);
    }
    public function setMemorabilia($value) {
        return $this->set('Memorabilia', (bool) $value);
    } 
    public function setAutographed($value) {
        return $this->set('Autographed', (bool) $value);
    }
    public function addUsedFor($value) {
        return $this->add('UsedFor', $value, 5);
    }
    public function setItemType($value) {
        return $this->set('ItemType', $value);
    }
    public function addOtherItemAttributes($value) {
        return $this->add('OtherItemAttributes', $value, 5);
    }
    public function addTargetAudience($value) {
        return $this->add('TargetAudience', $value, 3);
    }
    public function addSubjectContent($value) {
        return $this->add('SubjectContent', $value, 5);
    }
    public function setIsGiftWrapAvailable($value) {
        return $this->set('IsGiftWrapAvailable', (bool) $value);
    }
    public function setIsGiftMessageAvailable($value) {
        return $this->set('IsGiftMessageAvailable', (bool) $value);
    }
    public function addPromotionKeywords($value) {
        return $this->add('PromotionKeywords', $value, 10);
    }
    public function setIsDiscontinuedByManufacturer($value) {
        return $this->set('IsDiscontinuedByManufacturer', $value);
    }
    public function setDeliveryChannel($value) {
        if (!in_array($value, array(
                'in_store',
                'direct_ship'
            ))) {
            throw new InvalidArgumentException('Invalid delivery channel');
        }

        return $this->set('DeliveryChannel', $value);
    }
    public function setMaxAggregateShipQuantity($value) {
        return $this->set('MaxAggregateShipQuantity', $value);
    }
    public function setPriority($value) {
        if ($value < 1 || $value > 10) {
            throw new InvalidArgumentException('Invalid priority');
        }

        return $this->set('Priority', $value);
    }
    public function setBrowseExclusion($value) {
        return $this->set('BrowseExclusion', (bool) $value);
    }
    public function setRecommendationExclusion($value) {
        return $this->set('RecommendationExclusion', (bool) $value);
    }
}
