<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\ConstraintViolations;
use Stefmachine\Validation\Helper\ErrorMaker;
use UnexpectedValueException;

class Min implements ConstraintInterface
{
    protected $min;
    
    use ErrorMessageTrait;
    
    public function __construct(int $_min, ?string $_errorMessage = null)
    {
        $this->min = $_min;
        
        $this->setErrorMessage($_errorMessage);
    }
    
    public function validate($_value)
    {
        if(!is_numeric($_value)){
            throw new UnexpectedValueException("Value is not numeric.");
        }
        
        return $_value >= $this->min ?: $this->getError();
    }
}