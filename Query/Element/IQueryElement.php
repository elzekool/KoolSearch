<?php
/**
 * QueryElement Interface
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Query
 **/

namespace KoolSearch\Query\Element;

use KoolSearch\Storage\IDocumentStorage;
use KoolSearch\Storage\ITermStorage;
use KoolSearch\Storage\ITermDocumentStorage;


/**
 * QueryElement Interface
 *
 * @package KoolSearch
 * @subpackage Query
 **/
interface IQueryElement
{  
    const REQUIRED_OPTIONAL = 'REQUIRED_OPTIONAL';
    const REQUIRED_REQUIRED = 'REQUIRED_REQUIRED';
    const REQUIRED_EXCLUDED = 'REQUIRED_EXCLUDED';
    
    /**
     * Set Element Requirement
     * 
     * @param string $required REQUIRE_*
     * 
     * @return void
     */
    public function setRequired($required);
    
    /**
     * Get Element Requirement
     * 
     * @return string REQUIRE_*
     */
    public function getRequired();
    
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
    public function execute(ITermStorage $TermStorage, IDocumentStorage $DocumentStorage, ITermDocumentStorage $TermDocumentStorage, array $Fields);

    /**
     * Get Matching Terms
     * 
     * return \KoolSearch\Entity\Term
     */
    public function getMatchingTerms();    
    
    /**
     * Get Matching TermDocuments
     * 
     * return \KoolSearch\Entity\TermDocument[]
     */
    public function getMatchingTermDocuments();
    
}