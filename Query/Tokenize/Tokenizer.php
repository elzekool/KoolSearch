<?php
/**
 * Tokenizer
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Query
 **/

namespace KoolSearch\Query\Tokenize;

use KoolSearch\Query\Tokenize\Token;

/**
 * Tokenizer
 * 
 * Tokanizes the query for parsing. Tries to correct most common errors.
 * Example queries it can parse:
 * # Apple -Computer
 * # OS +"MS Dos"
 * # +Linus +Tovalds
 * # +title:Ubuntu title:Linux "OS"
 * 
 * @package KoolSearch
 * @subpackage Query
 */
class Tokenizer
{
    
    
    /**
	 * Singleton Instance
	 * @var \KoolSearch\Query\Tokenize\Tokenizer
	 */
	private static $Instance;
    
    /**
	 * Get \KoolSearch\Query\Tokenize\Tokenizer instance
	 *
	 * @return \KoolSearch\Query\Tokenize\Tokenizer Tokenizer
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
     * Tokenize string
     * 
     * @param string $query Query
     * 
     * @return \KoolSearch\Query\Token[] Tokens
     */
    public function tokenize($query) {
        
        $p = 0;
        $l = strlen($query);
        $in_phrase = false;
        $in_term = false;
        $term = '';
        $tokens = array();
                
        while($p < $l) {
            $c = $query[$p];
            
            // Next Term is a required term
            if (($c == '+') AND (!$in_phrase)) {
                if ($in_term) {
                    $tokens[] = new Token(Token::TOKEN_TERM, $term);
                    $term = '';
                    $in_term = false;
                }
                $tokens[] = new Token(Token::TOKEN_OP_REQUIRED, '+');                
                
            // Next Term is an excluded term
            } else if (($c == '-') AND (!$in_phrase)) {
                if ($in_term) {
                    $tokens[] = new Token(Token::TOKEN_TERM, $term);
                    $term = '';
                    $in_term = false;
                }
                $tokens[] = new Token(Token::TOKEN_OP_EXCLUDE, '-');                
             
            // Fieldname, an : direct after name (without space!)
            } else if (($c == ':') AND ($in_term)) {
                $tokens[] = new Token(Token::TOKEN_FIELD, $term);
                $term = '';
                $in_term = false;                
              
            // Start or end of phrase
            } else if (($c == '"') OR ($c == '\'')) {
                if ($in_term) {
                    $tokens[] = new Token(Token::TOKEN_TERM, $term);
                    $term = '';
                    $in_term = false;
                }
                $tokens[] = new Token($in_phrase ? Token::TOKEN_PHRASE_END : Token::TOKEN_PHRASE_START, '"');
                $in_phrase = !$in_phrase;
                
            // Whitespace, ignore
            } else if (($c == ' ') OR ($c == "\t") OR ($c == "\n")) {
                if ($in_term) {
                    $tokens[] = new Token(Token::TOKEN_TERM, $term);
                    $term = '';
                    $in_term = false;
                }
                
            } else {                
                $in_term = true;
                $term .= $c;                
            }
            
            $p++;
            
        }
        
        if ($in_term) {
            $tokens[] = new Token(Token::TOKEN_TERM, $term);
            $term = '';
        }
        
        if ($in_phrase) {
            $tokens[] = new Token(Token::TOKEN_PHRASE_END); 
        }
        
        
        foreach($tokens as $pos => $token) {
            
            // After an exclude or include token should be a term, field or a phrase start
            if (($token->getType() == Token::TOKEN_OP_EXCLUDE) OR ($token->getType() == Token::TOKEN_OP_REQUIRED)) {
                $n_token_type = ($pos+1 == $l) ? null : $tokens[$pos+1]->getType();
                if (($n_token_type != Token::TOKEN_TERM) AND ($n_token_type != Token::TOKEN_PHRASE_START) AND ($n_token_type != Token::TOKEN_FIELD)) {
                    $tokens[$pos] = new Token(Token::TOKEN_TERM, $token->getData());
                }
                
            // After a field token must be an term of phrase start token
            } else if ($token->getType() == Token::TOKEN_FIELD) {
                $n_token_type = ($pos+1 == $l) ? null : $tokens[$pos+1]->getType();
                if (($n_token_type != Token::TOKEN_TERM) AND ($n_token_type != Token::TOKEN_PHRASE_START)) {
                    unset($tokens[$pos]);
                }
                
            // A phrase should have some contents
            } else if ($token->getType() == Token::TOKEN_PHRASE_START) {
                $n_token_type = ($pos+1 == $l) ? null : $tokens[$pos+1]->getType();
                if ($n_token_type === Token::TOKEN_PHRASE_END) {
                    unset($tokens[$pos]);
                    unset($tokens[$pos+1]);
                }
            }           
            
        }
        
        return $tokens;
        
    }

    
}