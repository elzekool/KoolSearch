<?php
/**
 * Tokenizer Interface
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Tokenizer
 **/

namespace KoolSearch\Tokenizer;

/**
 * Tokenizer Interface
 * 
 * A Tokenizer transforms an input character stream into tokens (terms).
 * It is posible to have more than one tokenizer, in this case it
 * is recomended to remove the duplicates.
 * 
 * @package KoolSearch
 * @subpackage Tokenizer
 */
interface ITokenizer 
{
    
    /**
     * Process data 
     * 
     * @param string $input Input string
     * 
     * @return string[] Tokens
     */
    public function process($input);
    
    
}