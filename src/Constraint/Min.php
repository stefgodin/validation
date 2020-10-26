<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;

class Min implements ConstraintInterface
{
    const ERROR_MIN = 'min';
    
    protected $min;
    
    public function __construct(int $_min)
    {
        $this->min = $_min;
    }
    
    public function validate($_value): Errors
    {
        $errors = Assert::Numeric()->validate($_value);
        if($errors->any()){
            return $errors;
        }
        
        if($_value < $this->min){
            return Errors::from(self::ERROR_MIN);
        }
        
        return Errors::none();
    }
}