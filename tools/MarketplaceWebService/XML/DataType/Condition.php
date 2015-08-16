<?php

class MarketplaceWebService_XML_DataType_Condition extends MarketplaceWebService_XML_DataType_Base {

    public function __construct($conditionType=null, $conditionNote=null) {
        parent::__construct(); 
        if( $conditionType !== null )
            $this->setConditionType($conditionType);
        if( $conditionNote != null )
            $this->setConditionNote($conditionNote);
    } 
    
    public function setConditionType($value) {
        if (!in_array($value, array(
                'New',
                'UsedLikeNew',
                'UsedVeryGood',
                'UsedGood',
                'UsedAcceptable',
                'CollectibleLikeNew',
                'CollectibleVeryGood',
                'CollectibleGood',
                'CollectibleAcceptable',
                'Refurbished',
                'Club'
        ))) {
                throw new \InvalidArgumentException('Invalid condition type');
        }
        return $this->set('ConditionType', $value);
    }

    public function setConditionNote($value) {
        return $this->set('ConditionNote', $value);
    }

    public function getXML($feed) {
        $condition = $feed->createNode('Condition');
        if( $conditionType = $this->get('ConditionType') )
            $condition->appendChild( $feed->createNode('ConditionType', $conditionType) );
        if ($conditionNote = $this->get('ConditionNote'))
            $condition->appendChild( $feed->createNode('ConditionNote', $conditionNote) );
        return $condition;
    }
}

?>
