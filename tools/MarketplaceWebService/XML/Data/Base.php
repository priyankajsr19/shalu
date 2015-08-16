<?php
abstract class MarketplaceWebService_XML_Data_Base {

    protected $data;
    
    public function __construct() {
        $this->data = array();
    }

    /**
    * Add a value for a multi-valued node
    * 
    * @param string $key
    * @param mixed $value
    * @param int $max optional max occurrences
    * 
    * @return AbstractProduct 
    */
    public function add($key, $value, $max = 0) {
        if (!isset($this->data[$key])) {
            $this->data[$key] = array();
        }
        $this->data[$key][] = $value;
        if ($max) {
            if (count($this->data[$key]) > $max) {
                throw new RuntimeException('Too many values for element ' . $key);
            }
        }
        return $this;
    }

    /**
    * Set value
    * 
    * @param string $key
    * @param mixed $value
    * 
    * @return AbstractProduct 
    */
    public function set($key, $value) {
        if ($value === null) {
            throw new InvalidArgumentException("Value for $key is required");
        }
        $this->data[$key] = $value;
        return $this;
    }

    /**
    * Get value
    * 
    * @param string $key
    * 
    * @return mixed|null
    */
    public function get($key) {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }
}
?>
