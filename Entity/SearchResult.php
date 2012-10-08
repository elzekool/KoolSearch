<?php
/**
 * SearchResult Entity
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Entity
 **/

namespace KoolSearch\Entity;

/**
 * SearchResult Entity
 * 
 * @package KoolSearch
 * @subpackage Entity 
 */
class SearchResult
{
    private $Document;
    private $Score;
    private $Matches;
    
    /**
     * Constructor
     * 
     * @param string                            $Document Document ID
     * @param float                             $Score    Score
     * @param \KoolSearch\Entity\TermDocument[] $Matches  Matching TermDocuments
     */
    function __construct($Document, $Score, array $Matches) {
        $this->Document = $Document;
        $this->Score = $Score;
        $this->Matches = $Matches;
    }
    
    /**
     * Get Document ID
     * 
     * @return string Document ID
     */
    public function getDocument() {
        return $this->Document;
    }

    /**
     * Get Score
     * 
     * @return float Score
     */
    public function getScore() {
        return $this->Score;
    }
    
    /**
     * Get Matches
     * 
     * @return KoolSearch\Entity\TermDocument[] Matching TermDocuments
     */
    public function getMatches() {
        return $this->Matches;
    }


    
}