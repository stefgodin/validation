<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;

class Email implements ConstraintInterface
{
    const ERROR_EMAIL = 'invalid_email';
    
    private const PATTERN = '/^.+\@\S+\.\S+$/';
    
    public function validate($_value): Errors
    {
        $errors = Assert::String()->validate($_value);
        if($errors->any()){
            return $errors;
        }
        
        if(!preg_match(self::PATTERN, $_value)){
            return Errors::from(self::ERROR_EMAIL);
        }
        
        return Errors::none();
    }
}