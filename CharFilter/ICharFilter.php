<?php
/**
 * Char Filter Interface
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage CharFilter
 **/

namespace KoolSearch\CharFilter;

/**
 * Char Filter interface
 * 
 * A char filters string based contents. Char Filters work on the 
 * raw input stream.
 * 
 * @package KoolSearch
 * @subpackage CharFilter
 */
interface ICharFilter 
{
    
    /**
     * Process data 
     * 
     * @param string $input Input string
     * 
     * @return string Processed string
     */
    public function process($input);
    
    
}