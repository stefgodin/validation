<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;

class Max implements ConstraintInterface
{
    const ERROR_MAX = 'max';
    
    protected $max;
    
    public function __construct(int $_max)
    {
        $this->max = $_max;
    }
    
    public function validate($_value): Errors
    {
        $errors = Assert::Numeric()->validate($_value);
        if($errors->any()){
            return $errors;
        }
        
        if($_value > $this->max){
            return Errors::from(self::ERROR_MAX);
        }
        
        return Errors::none();
    }
}