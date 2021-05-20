<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;

class NotNull implements ConstraintInterface
{
    use ErrorMessageTrait;
    
    public function __construct(?string $_errorMessage = null)
    {
        $this->setErrorMessage($_errorMessage);
    }
    
    public function validate($_value)
    {
        return $_value !== null ?: $this->getError();
    }
}