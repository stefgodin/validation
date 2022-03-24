<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use UnexpectedValueException;

class Min implements ConstraintInterface
{
    protected $min;
    protected $excluded;
    
    use ErrorMessageTrait;
    
    public function __construct(int $_min, ?string $_errorMessage = null)
    {
        $this->min = $_min;
        $this->excluded = false;
        
        $this->setErrorMessage($_errorMessage);
    }
    
    public function excludeMin(): Min
    {
        $this->excluded = true;
        return $this;
    }
    
    public function includeMin(): Min
    {
        $this->excluded = false;
        return $this;
    }
    
    public function validate($_value)
    {
        if(!is_numeric($_value)){
            throw new UnexpectedValueException("Value is not numeric.");
        }
        
        return ($_value > $this->min || !$this->excluded && $_value == $this->min) ?: $this->getError();
    }
}