<?php
/**
 * Indexer
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
 * Indexer
 * 
 * @package KoolSearch
 * @subpackage Core
 */
class Indexer 
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
     * Add Document to Index
     * 
     * @param \KoolSearch\Entity\Document $document Document
     * 
     * @return void
     */
    public function addDocument(\KoolSearch\Entity\Document $document) {

        // First make sure document is in database
        $this->DocumentStorage->saveDocument($document);        
        $this->TermDocumentStorage->deleteForDocument($document);
        
                
        // Fetch data
        $data = $document->getData();
        
        // Go trough fields
        foreach($this->Fields as &$field) {
            
            /* @var $field \KoolSearch\Entity\Field */
            $fieldname = $field->getName();
                        
            if (!array_key_exists($fieldname, $data)) {
                if ($field->getRequired()) {
                    throw new \KoolSearch\Exception\MissingFieldException('Missing required field in document');
                } else {
                    continue;
                }
            }
            
            $stream = $data[$fieldname];
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
            
            
            // Reset position keys
            $terms = array_values($terms);

            // Prepare entities for batch storage
            $_terms = array();
            $_term_documents = array();
            
            foreach($terms as $position => $term) {   
                if ($term != '') {
                    $_terms[] = new \KoolSearch\Entity\Term($term);
                    $_term_documents[] = new \KoolSearch\Entity\TermDocument($term, $fieldname, $document->getId(), $position);
                }
            }
            
            // Save entities
            $this->TermStorage->saveTerms($_terms);            
            $this->TermDocumentStorage->saveTermDocuments($_term_documents);
            
        }
        
    }
    
    /**
     * Optimize storage
     * 
     * @return void
     */
    public function optimize() {
        $this->TermDocumentStorage->optimize();
        $this->DocumentStorage->optimize();
        $this->TermStorage->optimize();
    }
    
}
