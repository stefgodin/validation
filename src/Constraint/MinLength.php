<?php


namespace Stefmachine\Validation\Constraint;


use InvalidArgumentException;
use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use UnexpectedValueException;

class MinLength implements ConstraintInterface
{
    protected $minLength;
    protected $multiBytes;
    
    use ErrorMessageTrait;
    
    public function __construct(int $_min, ?string $_errorMessage = null)
    {
        if($_min < 0){
            throw new InvalidArgumentException("Min length cannot be less than 0.");
        }
        
        $this->minLength = $_min;
        $this->multiBytes = true;
        $this->setErrorMessage($_errorMessage);
    }
    
    public function singleByte(): MinLength
    {
        $this->multiBytes = false;
        return $this;
    }
    
    public function multiByte(): MinLength
    {
        $this->multiBytes = true;
        return $this;
    }
    
    public function validate($_value)
    {
        if(!is_string($_value)){
            throw new UnexpectedValueException("Value is not a string.");
        }
    
        return ($this->multiBytes ? mb_strlen($_value) : strlen($_value)) >= $this->minLength ?: $this->getError();
    }
}