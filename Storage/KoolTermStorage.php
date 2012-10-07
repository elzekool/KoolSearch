<?php
/**
 * KoolDevelop TermStorage implementation
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Storage
 **/

namespace KoolSearch\Storage;

/**
 * KoolDevelop TermStorage implementation
 * 
 * TermStorage implementation using the KoolDevelop framework
 * 
 * @package KoolSearch
 * @subpackage Storage 
 */
class KoolTermStorage implements ITermStorage
{
    
    /**
     * Save (or update) term into database
     * 
     * @param \KoolSearch\Entity\Term $term Term
     * 
     * @return void
     */
    public function saveTerm(\KoolSearch\Entity\Term &$term) {
        $database = \KoolDevelop\Database\Adaptor::getInstance('koolsearch');
        $query = $database->newQuery();        
        $query->custom('REPLACE INTO `terms` SET term = ?, frequency = ?', $term->getTerm(), $term->getFrequency());
        $query->execute();
    }
    
    /**
     * Search for Terms in database
     * 
     * @param string[] $query       Search Query
     * @param string   $search_type Search Type
     * 
     * @return \KoolSearch\Entity\Term[] Matching terms
     */
    public function searchForTerms(array $query, $search_type = 'exact') {        
        
        $database = \KoolDevelop\Database\Adaptor::getInstance('koolsearch');
        
        if ($search_type == self::SEARCH_EXACT) {
            $search = 'term = ?';
        } else if ($search_type == self::SEARCH_LIKE) {
            $search = 'term LIKE ?';
        } else if ($search_type == self::SEARCH_REGEX) {
            $search = 'term REGEXP ?';
        }

        $result = $database->newQuery()
            ->select('term,frequency')->from('terms')->where(join(' OR ', array_fill(0, count($query), $search)))
            ->execute($query);
        
        $terms = array();
        while($term = $result->fetch()) {
            $terms[] = new \KoolSearch\Entity\Term($term->term, $term->frequency);            
        }
        
        return $terms;
        
    }
    
    /**
     * Optimize database
     * 
     * Perform actions like remove orphaned terms, optimizing
     * database tables eg.
     * 
     * @return void
     */
    public function optimize() {
        $database = \KoolDevelop\Database\Adaptor::getInstance('koolsearch');
        $database->newQuery()->custom('DELETE FROM terms WHERE term NOT IN (SELECT DISTINCT term FROM term_documents)')->execute();
        $database->newQuery()->custom(
            'UPDATE terms JOIN term_documents ON terms.term = term_documents.term ' .
            'SET terms.frequency = (SELECT count(*) as term_frequency ' .
            'FROM term_documents where term_documents.term = terms.term);'
        )->execute();
        $database->newQuery()->custom('OPTIMIZE TABLE terms')->execute();
    }
    
    
}
    
    