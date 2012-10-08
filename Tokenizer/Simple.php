<?php
/**
 * Simple Tokenizer
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Tokenizer
 **/

namespace KoolSearch\Tokenizer;

/**
 * Simple Tokenizer
 * 
 * Tokenizes string on an exact delimiter
 * 
 * @package KoolSearch
 * @subpackage Tokenizer
 */
class Simple implements ITokenizer
{
    private $Delimiter;
    
    /**
     * Constructor
     * 
     * @param string $Delimiter Delimiter
     */
    function __construct($Delimiter = ',') {
        $this->Delimiter = $Delimiter;
    }

    /**
     * Process data 
     * 
     * @param string $input Input string
     * 
     * @return string[] Tokens
     */
    public function process($input) {
        return explode($this->Delimiter, $input);
    }
    
    
}