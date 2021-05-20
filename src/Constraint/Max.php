<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use UnexpectedValueException;

class Max implements ConstraintInterface
{
    protected $max;
    
    use ErrorMessageTrait;
    
    public function __construct(int $_max, ?string $_errorMessage = null)
    {
        $this->max = $_max;
        
        $this->setErrorMessage($_errorMessage);
    }
    
    public function validate($_value)
    {
        if(!is_numeric($_value)){
            throw new UnexpectedValueException("Value is not numeric.");
        }
        
        return $_value <= $this->max ?: $this->getError();
    }
}