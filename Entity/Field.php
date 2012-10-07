<?php
/**
 * Field Entity
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Entity
 **/

namespace KoolSearch\Entity;

/**
 * Field Entity
 * 
 * @package KoolSearch
 * @subpackage Entity 
 */
class Field 
{
    private $Name;
    private $Required = false;
    private $Filters = array();
    private $ScoreMultiplier = 1.0;
    
    /**
     * Constructor
     * 
     * @param string  $Name            Name
     * @param boolean $Required        Required
     * @param mixed[] $Filters         Filters
     * @param float   $ScoreMultiplier ScoreMultiplier
     */
    function __construct($Name, $Required = false, $Filters = array(), $ScoreMultiplier = 1.0) {
        $this->Name = $Name;
        $this->Required = $Required;
        $this->Filters = $Filters;
        $this->ScoreMultiplier = $ScoreMultiplier;
    }

    
    /**
     * Get Name
     *
     * @return string Name
     **/
    public function getName() {
        return $this->Name;
    }

    /**
     * Set Name
     *
     * @param string $Name Name
     *
     * @return void 
     **/
    public function setName($Name) {
        $this->Name = $Name;
    }

    /**
     * Get Required
     *
     * @return boolean Required
     **/
    public function getRequired() {
        return $this->Required;
    }

    /**
     * Set Required
     *
     * @param boolean $Required Required
     *
     * @return void 
     **/
    public function setRequired($Required) {
        $this->Required = $Required;
    }

        
    /**
     * Get Filters
     *
     * @return mixed[] Filters
     **/
    public function getFilters() {
        return $this->Filters;
    }

    /**
     * Set Filters
     *
     * @param mixed[] $Filters Filters
     *
     * @return void 
     **/
    public function setFilters(array $Filters) {
        $this->Filters = $Filters;
    }

    /**
     * Get Score Multiplier
     *
     * @return float Score Multiplier
     **/
    public function getScoreMultiplier() {
        return $this->ScoreMultiplier;
    }

    /**
     * Set Score Multiplier
     *
     * @param float $ScoreMultiplier Score Multiplier
     *
     * @return void 
     **/
    public function setScoreMultiplier($ScoreMultiplier) {
        $this->ScoreMultiplier = $ScoreMultiplier;
    }



    
}