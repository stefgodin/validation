<?php


namespace Stefmachine\Validation\Constraint;


use Countable;
use InvalidArgumentException;
use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use UnexpectedValueException;

class MaxCount implements ConstraintInterface
{
    protected $maxCount;
    
    use ErrorMessageTrait;
    
    public function __construct(int $_maxCount, ?string $_errorMessage = null)
    {
        if($_maxCount < 0){
            throw new InvalidArgumentException("Max count cannot be less than 0.");
        }
        
        $this->maxCount = $_maxCount;
        $this->setErrorMessage($_errorMessage);
    }
    
    public function validate($_value)
    {
        if(!is_array($_value) && !$_value instanceof Countable){
            throw new UnexpectedValueException("Value is not an array or countable.");
        }
        
        return count($_value) <= $this->maxCount ?: $this->getError();
    }
}