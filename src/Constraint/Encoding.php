<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;
use Stefmachine\Validation\Helper\ErrorMaker;

class Encoding implements ConstraintInterface
{
    const ERROR_ENCODING = 'invalid_encoding';
    
    protected $encoding;
    
    public function __construct(string $_encoding)
    {
        $this->encoding = $_encoding;
    
        if(!in_array($_encoding, mb_list_encodings())){
            throw new \LogicException("Unsupported encoding '{$_encoding}' given. Expected one of ".implode(', ', mb_list_encodings()).".");
        }
    }
    
    public function validate($_value): Errors
    {
        $errors = Assert::String()->validate($_value);
        if($errors->any()){
            return $errors;
        }
        
        if(!mb_check_encoding($_value, $this->encoding)){
            return Errors::from(ErrorMaker::makeError(self::ERROR_ENCODING, ['encoding' => $this->encoding]));
        }
        
        return Errors::none();
    }
}