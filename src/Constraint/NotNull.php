<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;

class NotNull implements ConstraintInterface
{
    const ERROR_NOT_NULL = 'required';
    
    public function validate($_value): Errors
    {
        if($_value === null){
            return Errors::from(self::ERROR_NOT_NULL);
        }
        
        return Errors::none();
    }
}