<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;
use Stefmachine\Validation\Helper\ErrorMaker;

class MinCount implements ConstraintInterface
{
    const ERROR_NOT_COUNTABLE = 'not_countable';
    const ERROR_MIN_COUNT = 'min_count';
    
    protected $minCount;
    
    public function __construct(int $_minCount)
    {
        $this->minCount = $_minCount;
    }
    
    public function validate($_value): Errors
    {
        if(!is_array($_value) || $_value instanceof \Countable){
            return Errors::from(self::ERROR_NOT_COUNTABLE);
        }
        
        if(count($_value) < $this->minCount){
            return Errors::from(ErrorMaker::makeError(self::ERROR_MIN_COUNT, ['min' => $this->minCount]));
        }
        
        return Errors::none();
    }
}