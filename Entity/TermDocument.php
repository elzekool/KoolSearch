<?php
/**
 * TermDocument Entity
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Entity
 **/

namespace KoolSearch\Entity;

/**
 * TermDocument Entity
 * 
 * @package KoolSearch
 * @subpackage Entity 
 */
class TermDocument 
{
    private $Term;
    private $Field;
    private $Document;
    private $Position;
    
    
    /**
     * Constructor
     * 
     * @param string $Term     Term
     * @param string $Field    Field
     * @param string $Document Document ID
     * @param int    $Position Position
     */
    function __construct($Term, $Field, $Document, $Position) {
        $this->Term = $Term;
        $this->Field = $Field;
        $this->Document = $Document;
        $this->Position = $Position;
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


    /**
     * Get Field
     *
     * @return string Field
     **/
    public function getField() {
        return $this->Field;
    }

    /**
     * Set Field
     *
     * @param string $Field Field
     *
     * @return void 
     **/
    public function setField($Field) {
        $this->Field = $Field;
    }

    /**
     * Get Document
     *
     * @return string Document
     **/
    public function getDocument() {
        return $this->Document;
    }

    /**
     * Set Document
     *
     * @param string $Document Document
     *
     * @return void 
     **/
    public function setDocument($Document) {
        $this->Document = $Document;
    }

    
    /**
     * Get Position
     *
     * @return int Position
     **/
    public function getPosition() {
        return $this->Position;
    }

    /**
     * Set Position
     *
     * @param int $Position Position
     *
     * @return void 
     **/
    public function setPosition($Position) {
        $this->Position = $Position;
    }


}