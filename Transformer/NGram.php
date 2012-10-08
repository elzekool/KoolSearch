<?php
/**
 * NGram Transformer
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolSearch
 * @subpackage Transformer
 **/

namespace KoolSearch\Transformer;

/**
 * NGram Transformer
 * 
 * Transforms terms into NGrams with the given minimum and maximum size.
 * It's recomended to use the RemoveDuplicates filter to reduce the number
 * of duplicate NGrams.
 * 
 * @package KoolSearch
 * @subpackage Transformer
 */
class NGram implements ITransformer
{
    private $MinSize;
    private $MaxSize;
    
    /**
     * 
     * @param type $MinSize
     * @param type $MaxSize
     */
    function __construct($MinSize = 3, $MaxSize = 5) {
        if ($MinSize < 1) {
            throw new \InvalidArgumentException('MinSize must be greater or equal to 1');
        }
        if ($MaxSize < $MinSize) {
            throw new \InvalidArgumentException('MaxSize must be greater or equal to MinSize');
        }
        
        $this->MinSize = $MinSize;
        $this->MaxSize = $MaxSize;
    }

    /**
     * Get NGrams of size N from word
     * 
     * @param string $word Word
     * @param int    $n    Size
     * 
     * @return string[] NGrams
     */
    private function _getNgrams($word, $n) {
        $ngrams = array();
        $len = strlen($word);
        for ($i = 0; $i < $len; $i++) {
            if ($i > ($n - 2)) {
                $ng = '';
                for ($j = $n - 1; $j >= 0; $j--) {
                    $ng .= $word[$i - $j];
                }
                $ngrams[] = $ng;
            }
        }
        return $ngrams;
    }

    
    
    /**
     * Process terms
     * 
     * @param string[] $terms Terms
     */
    public function process(array &$terms) {
        $terms = array_values($terms);        
        for($x = count($terms)-1; $x >= 0; $x--) {            
            $ngrams = array();
            for($n = $this->MinSize; $n <= $this->MaxSize; $n++) {
                $n_ngrams = $this->_getNgrams($terms[$x], $n);
                array_splice($ngrams, count($ngrams), 0, $n_ngrams);
            }
            array_splice($terms, $x, 1, $ngrams);
        }
    }
    
}
    