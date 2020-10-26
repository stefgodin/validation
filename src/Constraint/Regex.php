<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;

class Regex implements ConstraintInterface
{
    const ERROR_STRING = 'invalid_string';
    const ERROR_REGEX_MATCH = 'no_match';
    
    protected $regex;
    
    public function __construct(string $_regex)
    {
        $this->regex = $_regex;
        if(preg_match($this->regex, '') === false){
            throw new \LogicException("Invalid regex given.");
        }
    }
    
    public function validate($_value): Errors
    {
        $match = preg_match($this->regex, $_value);
        if($match === false){
            return Errors::from(self::ERROR_STRING);
        }
        
        if($match === 0){
            return Errors::from(self::ERROR_REGEX_MATCH);
        }
        
        return Errors::none();
    }
}