<?php
/**
 * DocumentStorage Interface
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Storage
 **/

namespace KoolSearch\Storage;

/**
 * DocumentStorage Interface
 * 
 * Storage Interface for documents. Implement this interface if you are
 * using the KoolSearch lib outside the KoolDevelop framework
 * 
 * @package KoolSearch
 * @subpackage Storage 
 */
interface IDocumentStorage
{    

    /**
     * Save (or update) document into database
     * 
     * @param \KoolSearch\Entity\Document $document Document
     * 
     * @return void
     */
    public function saveDocument(\KoolSearch\Entity\Document &$document);
    
    /**
     * Delete Document
     * 
     * @param \KoolSearch\Entity\Document $document Document
     * 
     * @return void
     */
    
    public function deleteDocument(\KoolSearch\Entity\Document &$document);
    
    
    /**
     * Optimize database
     * 
     * Perform actions like remove orphaned documents, optimizing
     * database tables eg.
     * 
     * @return void
     */
    public function optimize();
    
    
}
    
    