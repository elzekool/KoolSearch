<?php
/**
 * Stopwords Transformer
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Transformer
 **/

namespace KoolSearch\Transformer;

/**
 * Stopwords Transformer
 * 
 * Removes stopwords from terms
 * 
 * @package KoolSearch
 * @subpackage Transformer
 */
class Stopwords implements ITransformer
{
    private $Stopwords;
    
    /**
     * Constructor
     * 
     * @param string[] $Stopwords Stopwords
     */
    function __construct(array $Stopwords) {
        $this->Stopwords = $Stopwords;
    }
    
    /**
     * Process terms
     * 
     * @param string[] $terms Terms
     */
    public function process(array &$terms) {
        for($x = count($terms)-1; $x >= 0; $x--) {
            if (in_array(strtolower($terms[$x]), $this->Stopwords)) {
                unset($terms[$x]);
            }
        }
    }
    
}
    