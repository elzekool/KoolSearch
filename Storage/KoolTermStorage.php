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
     * Save (or update) terms into database
     * 
     * @param \KoolSearch\Entity\Term[] $terms Terms
     * 
     * @return void
     */
    public function saveTerms(array &$terms) {
        
        if (count($terms) == 0) {
            return;
        }
        
        $database = \KoolDevelop\Database\Adaptor::getInstance('koolsearch');
        
        $query = $database->newQuery();        
        $query->custom('INSERT IGNORE INTO `terms` (`term`) VALUES ' . join(',', array_fill(0, count($terms), '(?)')));

        $params = array();
        foreach($terms as $term) {
            $params[] = $term->getTerm();
        }        
        $query->execute($params);
        
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
            ->select('term')->from('terms')->where(join(' OR ', array_fill(0, count($query), $search)))
            ->execute($query);
        
        $terms = array();
        while($term = $result->fetch()) {
            $terms[] = new \KoolSearch\Entity\Term($term->term);            
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
        $database->newQuery()->custom('OPTIMIZE TABLE terms')->execute();
    }
    
    
}
    
    