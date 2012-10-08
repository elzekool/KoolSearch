<?php
/**
 * StripHtml Character Filter
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage CharFilter
 **/

namespace KoolSearch\CharFilter;

/**
 * StripHtml Character Filter
 * 
 * Removes HTML from the input stream
 * 
 * @package KoolSearch
 * @subpackage CharFilter
 */
class StripHtml implements ICharFilter
{
    
    /**
     * Process stream
     * 
     * @param string $input Input string
     * 
     * @return void Ascii Folded string
     */
    public function process($input) {
        return html_entity_decode(strip_tags($input));
    }   
    
}