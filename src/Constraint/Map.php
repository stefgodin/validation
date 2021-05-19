<?php


namespace Stefmachine\Validation\Constraint;


use InvalidArgumentException;
use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Traversable;
use UnexpectedValueException;

class Map implements ConstraintInterface
{
    /** @var ConstraintInterface[] */
    protected $constraints;
    /** @var bool */
    protected $allowExtra;
    
    use ErrorMessageTrait;
    
    public function __construct(array $_map, ?string $_errorMessage = null)
    {
        $this->allowExtra = false;
        $this->constraints = array();
        
        $this->setErrorMessage($_errorMessage);
        
        foreach ($_map as $key => $validation){
            if(!$validation instanceof ConstraintInterface){
                throw new InvalidArgumentException("Expected array of ".ConstraintInterface::class.".");
            }
            
            $this->set($key, $validation);
        }
    }
    
    private function set(string $_key, ConstraintInterface $_constraint): Map
    {
        $this->constraints[$_key] = $_constraint;
        return $this;
    }
    
    public function allowExtra(): Map
    {
        $this->allowExtra = true;
        return $this;
    }
    
    public function disallowExtra(): Map
    {
        $this->allowExtra = false;
        return $this;
    }
    
    public function validate($_value)
    {
        if(!is_array($_value) && !$_value instanceof Traversable){
            throw new UnexpectedValueException("Value is not traversable.");
        }
        
        $errors = [];
        $missingKeys = array_keys($this->constraints);
        foreach ($_value as $key => $value){
            $index = array_search($key, $missingKeys);
            if($index !== false){
                unset($missingKeys[$index]);
    
                $errors[] = $this->constraints[$key]->validate($value);
            }
            elseif (!$this->allowExtra){
                return $this->getError();
            }
        }
        
        foreach ($missingKeys as $key){
            $errors[] = $this->constraints[$key]->validate(null);
        }
        
        $hasError = false;
        $errorMessages = array();
        foreach ($errors as $thisError){
            if($thisError !== true){
                $hasError = true;
                
                if(is_string($thisError)){
                    $errorMessages[] = $thisError;
                }
            }
        }
        
        $errorMessages = empty($errorMessages) ? false : implode(' ', $errorMessages);
        
        return !$hasError ?: $this->getError() ?: $errorMessages;
    }
}