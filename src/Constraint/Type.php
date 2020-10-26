<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;

class Type implements ConstraintInterface
{
    const ERROR_TYPE_PREFIX = 'invalid_';
    
    protected $type;
    
    public function __construct(string $_type)
    {
        $this->type = $_type;
    }
    
    public function validate($_value): Errors
    {
        $function = "is_{$this->type}";
        if(function_exists($function) && $function($_value) || gettype($_value) == $this->type){
            return Errors::none();
        }
        
        // Special case for object with __toString
        if($this->type == 'string' && method_exists($_value, '__toString')){
            return Errors::none();
        }
        
        return Errors::from(self::ERROR_TYPE_PREFIX.$this->type);
    }
}