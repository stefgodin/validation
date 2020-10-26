<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;

class MimeType implements ConstraintInterface
{
    const ERROR_MIME_TYPE = 'invalid_mime_type';
    
    protected $mimeType;
    
    public function __construct(string $_mimeType)
    {
        $this->mimeType = $_mimeType;
    }
    
    public function validate($_value): Errors
    {
        $errors = Assert::FileExists()->validate($_value);
        if($errors->any()){
            return $errors;
        }
        
        if($this->mimeType != mime_content_type($_value)){
            return Errors::from(self::ERROR_MIME_TYPE);
        }
        
        return Errors::none();
    }
}