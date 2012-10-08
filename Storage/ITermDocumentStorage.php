<?php
/**
 * TermDocumentStorage Interface
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Storage
 **/

namespace KoolSearch\Storage;

/**
 * TermDocumentStorage Interface
 * 
 * Storage Interface for term_document. Implement this interface if you are
 * using the KoolSearch lib outside the KoolDevelop framework
 * 
 * @package KoolSearch
 * @subpackage Storage 
 */
interface ITermDocumentStorage
{    

    /**
     * Save (or update) term_documents into database
     * 
     * @param \KoolSearch\Entity\TermDocument[] $term_documents TermDocuments
     * 
     * @return void
     */
    public function saveTermDocuments(array &$term_documents);
    
    /**
     * Delete term_document for Document
     * 
     * @param \KoolSearch\Entity\Document $document Document
     * 
     * @return void
     */    
    public function deleteForDocument(\KoolSearch\Entity\Document &$document);
      
    /**
     * Get Term Documents that have one of the geven terms and belongs to field
     * 
     * @param \KoolSearch\Entity\Term[] $terms Terms
     * @param \KoolSearch\Entity\Field  $field Field
     * 
     * @return \KoolSearch\Entity\TermDocument[] TermDocuments matching
     */
    public function getForTerms(array $terms, \KoolSearch\Entity\Field $field);
    
    /**
     * Optimize database
     * 
     * Perform actions like remove orphaned terms/documents, optimizing
     * database tables eg.
     * 
     * @return void
     */
    public function optimize();
    
    
}
    
    