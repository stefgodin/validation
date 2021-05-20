<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Traversable;
use UnexpectedValueException;

class Each implements ConstraintInterface
{
    /** @var ConstraintInterface $constraint */
    protected $constraint;
    
    use ErrorMessageTrait;
    
    public function __construct(ConstraintInterface $_constraint, ?string $_errorMessage = null)
    {
        $this->constraint = $_constraint;
        
        $this->setErrorMessage($_errorMessage);
    }
    
    public function validate($_value)
    {
        if(!is_array($_value) && !$_value instanceof Traversable){
            throw new UnexpectedValueException("Value is not traversable.");
        }
        
        foreach ($_value as $value){
            $error = $this->constraint->validate($value);
            if($error !== true){
                return $this->getError() ?: $error;
            }
        }
        
        return true;
    }
}