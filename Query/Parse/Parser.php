<?php
/**
 * Parser
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Query
 **/

namespace KoolSearch\Query\Parse;

use KoolSearch\Query\Tokenize\Token;
use KoolSearch\Query\Parse\IQueryElement;
use KoolSearch\Query\Parse\TermElement;
use KoolSearch\Query\Parse\PhraseElement;

/**
 * Parser
 * 
 * Creates a query tree from the tokenized query.
 * This Query tree can be executed. See Tokenizer for example queries
 * 
 * @package KoolSearch
 * @subpackage Query
 */
class Parser
{
        
    /**
	 * Singleton Instance
	 * @var \KoolSearch\Query\Parser
	 */
	private static $Instance;
    
    /**
	 * Get \KoolSearch\Query\Parse\Parser instance
	 *
	 * @return \KoolSearch\Query\Parse\Parser Parser
	 */
	public static function getInstance() {
		if (self::$Instance === null) {
        	self::$Instance = new self();
      	}
      	return self::$Instance;
    }
    
    /**
     * Constructor. Protected due to Singleton pattern
     */
    protected function __construct() {
        
    }
 
    /**
     * Parse Tokens and create Query elements
     * 
     * @param \KoolSearch\Query\Tokenize\Token[] $tokens Tokens
     * 
     * @return \KoolSearch\Query\Parse\IQueryElement[] Query elements
     */
    public function parse(array $tokens) {
        
        $required = IQueryElement::REQUIRED_OPTIONAL;
        $field = '*';
        $in_phrase = array();
        $phrase_elements = array();
        $elements = array();
        
        foreach($tokens as $token) {            
            $type = $token->getType();
            
            if ($type == Token::TOKEN_OP_REQUIRED) {
                $required = IQueryElement::REQUIRED_REQUIRED;
                
            } else if ($type == Token::TOKEN_OP_EXCLUDE) {
                $required = IQueryElement::REQUIRED_EXCLUDED;
                
            } else if ($type == Token::TOKEN_FIELD) {
                $field = $token->getData();
                
            } else if ($type == Token::TOKEN_PHRASE_START) {
                $in_phrase = true;
                
            } else if ($type == Token::TOKEN_PHRASE_END) {
                if (count($phrase_elements) > 1) {
                    $elements[] = new PhraseElement($required, $field, $phrase_elements);
                } else if ($count($phrase_elements) == 0) {
                    $elements[] = $phrase_elements[0];                    
                }
                $in_phrase = false;
                $phrase_elements = array();
                $required = IQueryElement::REQUIRED_OPTIONAL;
                $field = '*';
                
            } else if ($type == Token::TOKEN_TERM) {
                if ($in_phrase) {
                    $phrase_elements[] = new TermElement(IQueryElement::REQUIRED_REQUIRED, $field, $token->getData());
                } else {
                    $elements[] = new TermElement($required, $field, $token->getData());
                    $required = IQueryElement::REQUIRED_OPTIONAL;
                    $field = '*';
                }
            }
             
        }
        
        return $elements;
        
    }
    
}