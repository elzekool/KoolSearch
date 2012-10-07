<?php
/**
 * Document Entity
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Entity
 **/

namespace KoolSearch\Entity;

/**
 * Document Entity
 * 
 * @package KoolSearch
 * @subpackage Entity 
 */
class Document 
{
    private $Id;    
    private $Data = array();
    
    /**
     * Constructor 
     * 
     * @param string  $Id   Document ID
     * @param mixed[] $Data Data
     */
    function __construct($Id, $Data = array()) {
        $this->Id = $Id;
        $this->Data = $Data;
    }

    
    /**
     * Get Id
     *
     * @return string Id
     **/
    public function getId() {
        return $this->Id;
    }

    /**
     * Set Id
     *
     * @param string $Id Id
     *
     * @return void 
     **/
    public function setId($Id) {
        $this->Id = $Id;
    }

    /**
     * Get Data
     *
     * @return string[] Data
     **/
    public function getData() {
        return $this->Data;
    }

    /**
     * Set Data
     *
     * @param string[] $Data Data
     *
     * @return void 
     **/
    public function setData(array $Data) {
        $this->Data = $Data;
    }


}