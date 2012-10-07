<?php
/**
 * String Tokenizer
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Tokenizer
 **/

namespace KoolSearch\Tokenizer;

/**
 * String Tokenizer
 * 
 * Transforms the input string into one token for exact matching
 * 
 * @package KoolSearch
 * @subpackage Tokenizer
 */
class String implements ITokenizer
{    
    /**
     * Process data 
     * 
     * @param string $input Input string
     * 
     * @return string[] Tokens
     */
    public function process($input) {
        return array($input);
    }
    
}