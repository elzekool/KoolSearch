<?php
/**
 * Transformer Interface
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Transformer
 **/

namespace KoolSearch\Transformer;

/**
 * Transformer Interface
 * 
 * A Transformer works on the tokenized terms. It can perform an
 * host of actions.
 * 
 * @package KoolSearch
 * @subpackage Transformer
 */
interface ITransformer
{
    
    /**
     * Process terms 
     * 
     * @param string[] $terms Terms
     * 
     * @return void
     */
    public function process(array &$terms);
    
    
}