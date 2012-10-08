<?php
/**
 * Term Entity
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Entity
 **/

namespace KoolSearch\Entity;

/**
 * Term Entity
 * 
 * @package KoolSearch
 * @subpackage Entity 
 */
class Term 
{
    private $Term;
    
    /**
     * Constructor
     * 
     * @param string $Term      Term
     * @param int    $Frequency Frequency
     */
    function __construct($Term, $Frequency = null) {
        $this->Term = $Term;
        $this->Frequency = $Frequency;
    }

    /**
     * Get Term
     *
     * @return string Term
     **/
    public function getTerm() {
        return $this->Term;
    }

    /**
     * Set Term
     *
     * @param string $Term Term
     *
     * @return void 
     **/
    public function setTerm($Term) {
        $this->Term = $Term;
    }


}