<?php


namespace Stefmachine\Validation\Constraint;


use InvalidArgumentException;
use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use UnexpectedValueException;

class MaxLength implements ConstraintInterface
{
    protected $maxLength;
    protected $multiBytes;
    
    use ErrorMessageTrait;
    
    public function __construct(int $_maxLength, ?string $_errorMessage = null)
    {
        if($_maxLength < 0){
            throw new InvalidArgumentException("Max length cannot be less than 0.");
        }
        
        $this->maxLength = $_maxLength;
        $this->multiBytes = true;
        $this->setErrorMessage($_errorMessage);
    }
    
    public function singleByte(): MaxLength
    {
        $this->multiBytes = false;
        return $this;
    }
    
    public function multiByte(): MaxLength
    {
        $this->multiBytes = true;
        return $this;
    }
    
    public function validate($_value)
    {
        if(!is_string($_value)){
            throw new UnexpectedValueException("Max length only accept string as values.");
        }
        
        return ($this->multiBytes ? mb_strlen($_value) : strlen($_value)) <= $this->maxLength ?: $this->getError();
    }
}