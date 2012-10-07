<?php
/**
 * LowerCase Character Filter
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage CharFilter
 **/

namespace KoolSearch\CharFilter;

/**
 * LowerCase Character Filter
 * 
 * Makes the input stream lowercase
 * 
 * @package KoolSearch
 * @subpackage CharFilter
 */
class LowerCase implements ICharFilter
{
    /**
     * Process stream
     * 
     * @param string $input Input string
     * 
     * @return void LowerCase string
     */
    public function process($input) {
        return strtolower($input);
    }   
    
}