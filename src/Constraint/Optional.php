<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;

class Optional implements ConstraintInterface
{
    protected $constraint;
    
    use ErrorMessageTrait;
    
    public function __construct(ConstraintInterface $_constraint, ?string $_errorMessage = null)
    {
        $this->constraint = $_constraint;
        
        $this->setErrorMessage($_errorMessage);
    }
    
    public function validate($_value)
    {
        if($_value === null){
            return true;
        }
        
        $constraintError = $this->constraint->validate($_value);
        return $constraintError === true ?: $this->getError() ?: $constraintError;
    }
}