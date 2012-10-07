<?php
/**
 * RemoveDuplicates Transformer
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Transformer
 **/

namespace KoolSearch\Transformer;

/**
 * RemoveDuplicates Transformer
 * 
 * Removes duplicate terms
 * 
 * @package KoolSearch
 * @subpackage Transformer
 */
class RemoveDuplicates implements ITransformer
{
    /**
     * Process terms
     * 
     * @param string[] $terms Terms
     */
    public function process(array &$terms) {
        $terms = array_unique($terms, SORT_STRING);
    }
    
}
    