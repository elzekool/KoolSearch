<?php
/**
 * KoolDevelop TermDocumentStorage implementation
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Storage
 **/

namespace KoolSearch\Storage;

/**
 * KoolDevelop TermDocumentStorage implementation
 * 
 * TermDocumentStorage implementation using the KoolDevelop framework.
 * 
 * @package KoolSearch
 * @subpackage Storage 
 */
class KoolTermDocumentStorage implements ITermDocumentStorage
{    
    private $InsertQuery;
    
    /**
     * Constructor
     */
    function __construct() {
        $database = \KoolDevelop\Database\Adaptor::getInstance('koolsearch');
        $query = $database->newQuery();        
        $this->InsertQuery = $query->custom('INSERT INTO `term_documents` SET term = ?, field = ?, document = ?, position = ?');
    }
        
    /**
     * Save (or update) term_documents into database
     * 
     * @param \KoolSearch\Entity\TermDocument[] $term_documents TermDocuments
     * 
     * @return void
     */
    public function saveTermDocuments(array &$term_documents) {
                
        if (count($term_documents) == 0) {
            return;
        }
        
        $database = \KoolDevelop\Database\Adaptor::getInstance('koolsearch');
        
        $query = $database->newQuery();        
        $query->custom('INSERT INTO `term_documents` (`term`, `field`, `document`, `position`) VALUES ' . join(',', array_fill(0, count($term_documents), '(?, ?, ?, ?)')));

        $params = array();
        foreach($term_documents as $term_document) {
            $params[] = $term_document->getTerm();
            $params[] = $term_document->getField();
            $params[] = $term_document->getDocument();
            $params[] = $term_document->getPosition();
        }        
        $query->execute($params);

    }
    
    /**
     * Delete term_document for Document
     * 
     * @param \KoolSearch\Entity\Document $document Document
     * 
     * @return void
     */    
    public function deleteForDocument(\KoolSearch\Entity\Document &$document) {
        $database = \KoolDevelop\Database\Adaptor::getInstance('koolsearch');
        $query = $database->newQuery();        
                
        $query
            ->delete()->from('term_documents')
            ->where('document = ?', $document->getId());
                
        $query->execute();
    }
    
    /**
     * Get Term Documents that have one of the geven terms and belongs to field
     * 
     * @param \KoolSearch\Entity\Term[] $terms Terms
     * @param \KoolSearch\Entity\Field  $field Field
     * 
     * @return \KoolSearch\Entity\TermDocument[] TermDocuments matching
     */
    public function getForTerms(array $terms, \KoolSearch\Entity\Field $field) {
                
        // Create parameters
        $params = array();
        foreach($terms as $term) {
            $params[] = $term->getTerm();
        }
        $params[] = $field->getName();
        
        $database = \KoolDevelop\Database\Adaptor::getInstance('koolsearch');        
        $result = $database->newQuery()
            ->select('*')->from('term_documents')
            ->where('(' . join(' OR ', array_fill(0, count($terms), 'term = ?')) . ')')
            ->where('field = ?')
            ->execute($params);
        
        $term_documents = array();
        while($term_document = $result->fetch()) {
            $term_documents[] = new \KoolSearch\Entity\TermDocument(
                $term_document->term, 
                $term_document->field, 
                $term_document->document, 
                $term_document->position
            );
        }
        
        return $term_documents;
        
    }

    
    /**
     * Optimize database
     * 
     * Perform actions like remove orphaned terms/documents, optimizing
     * database tables eg.
     * 
     * @return void
     */
    public function optimize() {
        $database = \KoolDevelop\Database\Adaptor::getInstance('koolsearch');
        $database->newQuery()->custom('DELETE FROM term_documents WHERE document NOT IN (SELECT id FROM documents)')->execute();
        $database->newQuery()->custom('DELETE FROM term_documents WHERE term NOT IN (SELECT term FROM terms)')->execute();
        $database->newQuery()->custom('OPTIMIZE TABLE term_documents')->execute();
    }
    
    
}
    
    