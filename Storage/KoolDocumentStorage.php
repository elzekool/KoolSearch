<?php
/**
 * KoolDevelop DocumentStorage Implementation
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Storage
 **/

namespace KoolSearch\Storage;

/**
 * KoolDevelop DocumentStorage Implementation
 * 
 * DocumentStorage implementation using the KoolDevelop framework
 * 
 * @package KoolSearch
 * @subpackage Storage 
 */
class KoolDocumentStorage implements IDocumentStorage
{    
    private $InsertQuery;
    
    /**
     * Constructor
     */
    function __construct() {
        $database = \KoolDevelop\Database\Adaptor::getInstance('koolsearch');
        $query = $database->newQuery();        
        $this->InsertQuery = $query->custom('INSERT IGNORE INTO `documents` SET id = ?');
    }
    
    /**
     * Save (or update) document into database
     * 
     * @param \KoolSearch\Entity\Document $document Document
     * 
     * @return void
     */
    public function saveDocument(\KoolSearch\Entity\Document &$document) {
        $this->InsertQuery->execute(array($document->getId()));
    }
    
    /**
     * Delete Document
     * 
     * @param \KoolSearch\Entity\Document $document Document
     * 
     * @return void
     */
    
    public function deleteDocument(\KoolSearch\Entity\Document &$document) {
        $database = \KoolDevelop\Database\Adaptor::getInstance('koolsearch');
        $query = $database->newQuery();        
        $query->delete()->from('documents')->where('id = ?', $document->getId());
        $query->execute();
    }
    
    
    /**
     * Optimize database
     * 
     * Perform actions like remove orphaned documents, optimizing
     * database tables eg.
     * 
     * @return void
     */
    public function optimize() {
        $database = \KoolDevelop\Database\Adaptor::getInstance('koolsearch');
        $database->newQuery()->custom('DELETE FROM documents WHERE id NOT IN (SELECT DISTINCT document FROM term_documents)')->execute();
        $database->newQuery()->custom('OPTIMIZE TABLE documents')->execute();
    }
    
    
}
    
    