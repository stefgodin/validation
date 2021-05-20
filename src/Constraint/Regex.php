<?php


namespace Stefmachine\Validation\Constraint;


use InvalidArgumentException;
use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\ConstraintViolations;
use UnexpectedValueException;

class Regex implements ConstraintInterface
{
    protected $regex;
    
    use ErrorMessageTrait;
    
    public function __construct(string $_regex, ?string $_errorMessage = null)
    {
        if(@preg_match($_regex, '') === false){
            throw new InvalidArgumentException("Invalid regex given.");
        }
    
        $this->regex = $_regex;
        $this->setErrorMessage($_errorMessage);
    }
    
    public function validate($_value)
    {
        if(!is_string($_value)){
            throw new UnexpectedValueException("Value is not a string.");
        }
    
        return preg_match($this->regex, $_value) !== 0 ?: $this->getError();
    }
}