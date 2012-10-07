<?php
/**
 * Standard Tokenizer
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Tokenizer
 **/

namespace KoolSearch\Tokenizer;

/**
 * Standard Tokenizer
 * 
 * Standard tokenizer, usefull in most cases. Splits words on
 * comma, dot, dash and whitespace characters
 * 
 * @package KoolSearch
 * @subpackage Tokenizer
 */
class Standard implements ITokenizer
{
    
    /**
     * Process data 
     * 
     * @param string $input Input string
     * 
     * @return string[] Tokens
     */
    public function process($input) {
        return preg_split("/[\s,\.\-\(\)]+/", $input);
    }
    
    
}