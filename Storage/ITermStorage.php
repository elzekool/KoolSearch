<?php
/**
 * TermStorage Interface
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Storage
 **/

namespace KoolSearch\Storage;

/**
 * TermStorage Interface
 * 
 * Storage Interface for terms. Implement this interface if you are
 * using the KoolSearch lib outside the KoolDevelop framework
 * 
 * @package KoolSearch
 * @subpackage Storage 
 */
interface ITermStorage
{
    
    const SEARCH_EXACT = 'exact';
    const SEARCH_LIKE = 'like';
    const SEARCH_REGEX = 'regex';   
    
    /**
     * Save (or update) term into database
     * 
     * @param \KoolSearch\Entity\Term $term Term
     * 
     * @return void
     */
    public function saveTerm(\KoolSearch\Entity\Term &$term);
    
    /**
     * Search for Terms in database
     * 
     * @param string[] $query       Search Query
     * @param string   $search_type Search Type
     * 
     * @return \KoolSearch\Entity\Term[] Matching terms
     */
    public function searchForTerms(array $query, $search_type = 'exact');
    
    /**
     * Optimize database
     * 
     * Perform actions like remove orphaned terms, optimizing
     * database tables eg.
     * 
     * @return void
     */
    public function optimize();
    
    
}
    
    