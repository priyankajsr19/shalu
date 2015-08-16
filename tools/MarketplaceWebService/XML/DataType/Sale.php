<?php
class MarketplaceWebService_XML_DataType_Sale extends MarketplaceWebService_XML_DataType_Base {
    public function __construct(DateTime $startDate, DateTime $endDate, MarketplaceWebService_XML_DataType_Price $price ) {
        if( $startDate !== null )
            $this->setStartDate($startDate);
        if( $endDate !== null )
            $this->setEndDate($endDate);
        if( $price !== null )
            $this->setSalePrice($price);
    }

    public function setStartDate(DateTime $value) {
        $this->set('StartDate', $value);
    } 
    public function setEndDate(DateTime $value) {
        $this->set('EndDate', $value);
    }
    public function setSalePrice(MarketplaceWebService_XML_DataType_Price $value) {
        return $this->set('SalePrice', $value);
    }
    public function getXML($feed) {

        $sale = $feed->createNode('Sale');
        if( $startDate = $this->get('StartDate') )
            $sale->appendChild( $feed->createNode('StartDate', $startDate->format('c')) );
        if( $endDate = $this->get('EndDate') )
            $sale->appendChild( $feed->createNode('EndDate', $endDate->format('c')) );
        if( $salePrice = $this->get('SalePrice') )
            $sale->appendChild( $salePrice->getXML($feed,'SalePrice') );
        return $sale;
    }
}
