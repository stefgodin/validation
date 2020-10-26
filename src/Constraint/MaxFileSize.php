<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;

class MaxFileSize implements ConstraintInterface
{
    const ERROR_FILE_SIZE = 'invalid_file_size';
    
    protected $maxSize;
    
    public function __construct(int $_size)
    {
        $this->maxSize = $_size;
    }
    
    public function validate($_value): Errors
    {
        $errors = Assert::FileExists()->validate($_value);
        if($errors->any()){
            return $errors;
        }
        
        $size = filesize($_value);
        if($size === false || $size > $this->maxSize){
            return Errors::from(self::ERROR_FILE_SIZE);
        }
        
        return Errors::none();
    }
}