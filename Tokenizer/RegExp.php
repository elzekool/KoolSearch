<?php
/**
 * RegExp Tokenizer
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Tokenizer
 **/

namespace KoolSearch\Tokenizer;

/**
 * RegExp Tokenizer
 * 
 * Tokenizes string based on an regular expression. Each match(group) is added as an
 * token.
 * 
 * @package KoolSearch
 * @subpackage Tokenizer
 */
class RegExp implements ITokenizer
{
    private $RegExp;
    
    /**
     * Constructor
     * 
     * @param string $RegExp Regular Expression (In PCRE style)
     */
    function __construct($RegExp) {
        $this->RegExp = $RegExp;
    }

    /**
     * Process data 
     * 
     * @param string $input Input string
     * 
     * @return string[] Tokens
     */
    public function process($input) {
        $matches = array();
        if (preg_match_all($this->RegExp, $input, $matches) > 0) {
            $terms = array();
            foreach($matches as $match) {
                array_splice($terms, count($terms), 0, $match);
            }
            return array_unique($terms);
        } else {
            return array();
        }
                
    }
    
    
}