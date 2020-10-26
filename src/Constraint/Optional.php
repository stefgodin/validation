<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;

class Optional implements ConstraintInterface
{
    protected $constraint;
    
    public function __construct(ConstraintInterface $_constraint)
    {
        $this->constraint = $_constraint;
    }
    
    public function validate($_value): Errors
    {
        if($_value === null){
            return Errors::none();
        }
        
        return $this->constraint->validate($_value);
    }
}