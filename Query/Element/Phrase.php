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

namespace KoolSearch\Query\Element;

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
class Phrase implements IQueryElement
{  
    protected $Required = self::REQUIRED_OPTIONAL;
    protected $Field = '*';
    protected $TermElements = array();
    
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
     * @param string                           $Required     REQUIRE_*
     * @param string                           $Field        Field, * for all
     * @param \KoolSearch\Query\Element\Term[] $TermElements Term Elements
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
        
        $term_matches = array();
        foreach($this->TermElements as $term_element) {
            /* @var $term_element \KoolSearch\Query\Element\Term */
            $term_element->execute($TermStorage, $DocumentStorage, $TermDocumentStorage, $Fields);
            $matches = $term_element->getMatchingTermDocuments();
            if (count($matches) == 0) {
                // We can stop looking if there is no match
                return;
            }
            $term_matches[] = $matches;            
        }
        
        $n_terms = count($this->TermElements);         
        
        // Start with the first TermMatches as starting point        
        foreach($term_matches[0] as &$term_document_0) {            
            /* @var $term_document_0 \KoolSearch\Entity\TermDocument */
            
            $field = $term_document_0->getField();
            $pos = $term_document_0->getPosition();     
            $document = $term_document_0->getDocument();
            
            $matching_term_documents = array($term_document_0);
            $matching_terms = array(new \KoolSearch\Entity\Term($term_document_0->getTerm()));
            
            // Now go further to the next terms where there must be a match
            // on the same field and an increased positon
            for($x = 1; $x < $n_terms; $x++) {        
                
                $match_cnt = 0;
                foreach($term_matches[$x] as &$term_document_n) {
                    /* @var $term_document_n \KoolSearch\Entity\TermDocument */                    
                    if (
                        ($term_document_n->getField() == $field) AND 
                        ($term_document_n->getDocument() == $document) AND 
                        ($term_document_n->getPosition() == ($pos + $x))
                    ) {
                        $matching_term_documents[] = $term_document_n; 
                        $matching_terms[] = new \KoolSearch\Entity\Term($term_document_n->getTerm());
                        $match_cnt++;
                    }
                }
                
                if ($match_cnt == 0) {
                    // If no match stop looking further for this field and starting position
                    continue 2;
                }
                
            }
            
            // We now know we have a full phrase match. Add matching terms and term_documents to the list
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