<?php
/**
 * Searcher
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Core
 **/

namespace KoolSearch;

use KoolSearch\Storage\IDocumentStorage;
use KoolSearch\Storage\ITermStorage;
use KoolSearch\Storage\ITermDocumentStorage;

/**
 * Searcher
 *
 * @package KoolSearch
 * @subpackage Core
 */
class Searcher
{
    private $TermStorage;
    private $DocumentStorage;
    private $TermDocumentStorage;
    private $Fields;

    /**
     * Constructor
     *
     * @param \KoolSearch\Storage\ITermStorage         $TermStorage         Term Storage
     * @param \KoolSearch\Storage\IDocumentStorage     $DocumentStorage     Document Storage
     * @param \KoolSearch\Storage\ITermDocumentStorage $TermDocumentStorage Term Document Storage
     * @param \KoolSearch\Entity\Field[]               $Fields              Field Configuration
     */
    public function __construct(ITermStorage $TermStorage, IDocumentStorage $DocumentStorage, ITermDocumentStorage $TermDocumentStorage, array $Fields) {
        $this->TermStorage = $TermStorage;
        $this->DocumentStorage = $DocumentStorage;
        $this->TermDocumentStorage = $TermDocumentStorage;
        $this->Fields = $Fields;
    }

    /**
     * Query Index
     *
     * @param string $query Search Query
     *
     * @return \KoolSearch\Entity\SearchResult Search Results
     */
    public function query($query) {

        // Tokenize query
        $tokenizer = \KoolSearch\Query\Tokenize\Tokenizer::getInstance();
        $tokens = $tokenizer->tokenize($query);

        if (count($tokens) == 0) {
            return array();
        }

        // Parse tokens
        $parser = \KoolSearch\Query\Parse\Parser::getInstance();
        $elements = $parser->parse($tokens);

        // Excecute elements
        foreach($elements as &$element) {
            /* @var $element \KoolSearch\Query\Parse\IQueryElement */
            $element->execute($this->TermStorage, $this->DocumentStorage, $this->TermDocumentStorage, $this->Fields);
        }

        // For simplicity make fieldname the key
        $fields = array();
        foreach($this->Fields as $field) {
            $fields[$field->getName()] = $field;
        }
        
        // List of documents, key is document id, value is score
        $document_score = array();       
        $document_matches = array();
        $match_required = array();
        $match_exclude = array();
        
        foreach($elements as &$element) {
            
            /* @var $element \KoolSearch\Query\Parse\IQueryElement */

            // For simplicity make term the field key
            $matching_terms = array();
            foreach($element->getMatchingTerms() as $term) {
                $matching_terms[$term->getTerm()] = $term;
            }

            // For simplicity make document id the field key
            $matching_term_documents = array();
            foreach($element->getMatchingTermDocuments() as $term_document) {
                $document = $term_document->getDocument();
                if (!isset($matching_term_documents[$document])) {
                    $matching_term_documents[$document] = array();
                }
                $matching_term_documents[$document][] = $term_document;
            }

            // If required add document id's to the required list
            if ($element->getRequired() == \KoolSearch\Query\Parse\IQueryElement::REQUIRED_REQUIRED) {
                $match_required[] = array_keys($matching_term_documents);

            // If exclude add document id's to the exclude list
            } else if ($element->getRequired() == \KoolSearch\Query\Parse\IQueryElement::REQUIRED_EXCLUDED) {
                $match_exclude[] = array_keys($matching_term_documents);
                
                // Don't add the documents to the found document list
                continue;
            }

            // Go trough matching documents
            foreach($matching_term_documents as $document_id => $matches_for_document) {
                
                if (!isset($document_score[$document_id])) {
                    $document_score[$document_id] = 0;
                    $document_matches[$document_id] = array();
                }
                
                foreach($matches_for_document as $term_document) {
                    /* @var $term_document \KoolSearch\Entity\TermDocument */                    
                    $field = $fields[$term_document->getField()];
                    $term = $matching_terms[$term_document->getTerm()];                    
                    $score = $field->getScoreMultiplier();                    
                    $document_score[$document_id] += $score;
                    $document_matches[$document_id][] = $term_document;
                }
                
            }
            
        }
        
        // Remove documents that did not match required elements
        foreach($match_required as $required) {
            foreach($document_score as $document_id => $document) {
                if (!in_array($document_id, $required)) {
                    unset($document_score[$document_id]);
                }
            }
        }
        
        // Remove documents that should be excluded
        foreach($match_exclude as $exclude) {
            foreach($document_score as $document_id => $document) {
                if (in_array($document_id, $exclude)) {
                    unset($document_score[$document_id]);
                }
            }
        }
        
        // Sort documents based on score
        arsort($document_score);
        
        
        $result = array();
        foreach($document_score as $document_id => $score) {
            $result[] = new \KoolSearch\Entity\SearchResult($document_id, $score, $document_matches[$document_id]);
        }
        
        return $result;

    }

}
