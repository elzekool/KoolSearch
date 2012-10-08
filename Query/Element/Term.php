<?php
/**
 * Term Element
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
 * Term Element
 *
 * Represents a term in a search query
 * 
 * @package KoolSearch
 * @subpackage Query
 **/
class Term implements IQueryElement
{  
    protected $Required = self::REQUIRED_OPTIONAL;
    protected $Field = '*';
    protected $Term;
    
    protected $MatchingTerms = array();
    protected $MatchingTermDocuments = array();


    
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
     * @param string $Required REQUIRE_*
     * @param string $Field    Field, * for all
     * @param string $Term     Term
     */
    function __construct($Required, $Field, $Term) {
        $this->Required = $Required;
        $this->Field = $Field;
        $this->Term = $Term;
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
        
        // Determine fields to examine
        if ($this->Field == '*') {
            $fields = $Fields;
        } else {
            $fields = array();
            foreach($Fields as $field) {
                if ($field->getName() == $this->Field) {
                    $fields[] = $field;
                }
            }
        }
        
        // Go trough fields
        foreach($fields as &$field) {
            
            $stream = $this->Term;
            $filters = $field->getFilters();
            $terms = array();

            // Process filters
            foreach($filters as $filter) {
                if ($filter instanceOf \KoolSearch\CharFilter\ICharFilter) {
                    $stream = $filter->process($stream);
                } else if ($filter instanceOf \KoolSearch\Tokenizer\ITokenizer) {
                    $tokens = $filter->process($stream);
                    array_splice($terms, count($terms), 0, $tokens);
                } else if ($filter instanceOf \KoolSearch\Transformer\ITransformer) {
                    $filter->process($terms);
                }
            }
            
            // Find matching terms
            $matching_terms = $TermStorage->searchForTerms($terms, \KoolSearch\Storage\ITermStorage::SEARCH_EXACT);
            
            // If no matching terms, continue to the next field
            if (count($matching_terms) == 0) {
                continue;
            }
            
            
            $matching_term_documents = $TermDocumentStorage->getForTerms($matching_terms, $field);
            
            // If no matching documents, continue to the next field
            if (count($matching_terms) == 0) {
                continue;                
            }
            
            // Add to the full list of matching documents
            array_splice($this->MatchingTerms, count($this->MatchingTerms), 0, $matching_terms);
            array_splice($this->MatchingTermDocuments, count($this->MatchingTermDocuments), 0, $matching_term_documents);
            
        }
        
    }

    /**
     * Get Matching Terms
     * 
     * return \KoolSearch\Entity\Term
     */
    public function getMatchingTerms() {
        return $this->MatchingTerms;
    }
    
    /**
     * Get Matching TermDocuments
     * 
     * return \KoolSearch\Entity\TermDocument[]
     */
    public function getMatchingTermDocuments() {
        return $this->MatchingTermDocuments;
    }
    
}