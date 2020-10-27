<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;
use Stefmachine\Validation\Helper\ErrorMaker;

class MaxLength implements ConstraintInterface
{
    const ERROR_MAX_LENGTH = 'max_length';
    
    protected $max;
    
    public function __construct(int $_max)
    {
        $this->max = $_max;
    }
    
    public function validate($_value): Errors
    {
        $errors = Assert::String()->validate($_value);
        if($errors->any()){
            return $errors;
        }
        
        $length = strlen((string) $_value);
        
        if($length > $this->max){
            return Errors::from(ErrorMaker::makeError(self::ERROR_MAX_LENGTH, ['max' => $this->max]));
        }
        
        return Errors::none();
    }
}