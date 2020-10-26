<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;

class FileExists implements ConstraintInterface
{
    const ERROR_NO_FILE = 'file_not_found';
    
    public function validate($_value): Errors
    {
        $errors = Assert::String()->validate($_value);
        if($errors->any()){
            return $errors;
        }
        
        if(!file_exists($_value)){
            return Errors::from(self::ERROR_NO_FILE);
        }
        
        return Errors::none();
    }
}