<?php


namespace Stefmachine\Validation\Constraint;


use Countable;
use InvalidArgumentException;
use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use UnexpectedValueException;

class MinCount implements ConstraintInterface
{
    protected $minCount;
    
    use ErrorMessageTrait;
    
    public function __construct(int $_minCount, ?string $_errorMessage = null)
    {
        if($_minCount < 0){
            throw new InvalidArgumentException("Min count cannot be less than 0.");
        }
        
        $this->minCount = $_minCount;
        $this->setErrorMessage($_errorMessage);
    }
    
    public function validate($_value)
    {
        if(!is_array($_value) && !$_value instanceof Countable){
            throw new UnexpectedValueException("Value is not an array or countable.");
        }
    
        return count($_value) >= $this->minCount ?: $this->getError();
    }
}