<?php
/**
 * Phrase Element
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Query
 **/

namespace KoolSearch\Query\Parse;

use KoolSearch\Storage\IDocumentStorage;
use KoolSearch\Storage\ITermStorage;
use KoolSearch\Storage\ITermDocumentStorage;

/**
 * Phrase Element
 *
 * Represents a phrase in a search query. A pharse contains two or
 * more term elements
 * 
 * @package KoolSearch
 * @subpackage Query
 **/
class PhraseElement implements IQueryElement
{  
    protected $Required = self::REQUIRED_OPTIONAL;
    protected $Field = '*';
    protected $TermElements = array();
    
    /**
     * Set Element Requirement
     * 
     * @param string $required REQUIRE_*
     * 
     * @return void
     */
    public function setRequired($required = self::REQUIRED_OPTIONAL) {
        $this->Required = $required;
    }
    
    /**
     * Get Element Requirement
     * 
     * @return string REQUIRE_*
     */
    public function getRequired() {
        return $this->Required;
    }
    
    /**
     * Constructor
     * 
     * @param string                                $Required     REQUIRE_*
     * @param string                                $Field        Field, * for all
     * @param \KoolSearch\Query\Parse\TermElement[] $TermElements Term Elements
     */
    function __construct($Required, $Field, array $TermElements) {
        $this->Required = $Required;
        $this->Field = $Field;
        $this->TermElements = $TermElements;
    }

    
    /**
     * Execute Query Element
     * 
     * @param \KoolSearch\Storage\ITermStorage         $TermStorage         Term Storage
     * @param \KoolSearch\Storage\IDocumentStorage     $DocumentStorage     Document Storage
     * @param \KoolSearch\Storage\ITermDocumentStorage $TermDocumentStorage Term Document Storage
     * @param \KoolSearch\Entity\Field[]               $Fields              Field Configuration
     *
     * @return void
     */
    public function execute(ITermStorage $TermStorage, IDocumentStorage $DocumentStorage, ITermDocumentStorage $TermDocumentStorage, array $Fields) {
        
        
    }

    /**
     * Get Matching Terms
     * 
     * return \KoolSearch\Entity\Term
     */
    public function getMatchingTerms() {
        // @todo 
        return array();
    }
    
    /**
     * Get Matching TermDocuments
     * 
     * return \KoolSearch\Entity\TermDocument[]
     */
    public function getMatchingTermDocuments() {
        // @todo 
        return array();
    }
    
}