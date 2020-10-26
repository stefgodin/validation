<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;

class MaxCount implements ConstraintInterface
{
    const ERROR_NOT_COUNTABLE = 'not_countable';
    const ERROR_MAX_COUNT = 'max_count';
    
    protected $maxCount;
    
    public function __construct(int $_maxCount)
    {
        $this->maxCount = $_maxCount;
    }
    
    public function validate($_value): Errors
    {
        if(!is_array($_value) || $_value instanceof \Countable){
            return Errors::from(self::ERROR_NOT_COUNTABLE);
        }
        
        if(count($_value) > $this->maxCount){
            return Errors::from(self::ERROR_MAX_COUNT);
        }
        
        return Errors::none();
    }
}