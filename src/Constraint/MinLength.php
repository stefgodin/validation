<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;
use Stefmachine\Validation\Helper\ErrorMaker;

class MinLength implements ConstraintInterface
{
    const ERROR_MIN_LENGTH = 'min_length';
    
    protected $min;
    
    public function __construct(int $_min)
    {
        
        $this->min = $_min;
    }
    
    public function validate($_value): Errors
    {
        $errors = Assert::String()->validate($_value);
        if($errors->any()){
            return $errors;
        }
        
        $length = strlen((string) $_value);
        
        if($length < $this->min){
            return Errors::from(ErrorMaker::makeError(self::ERROR_MIN_LENGTH, ['min' => $this->min]));
        }
        
        return Errors::none();
    }
}