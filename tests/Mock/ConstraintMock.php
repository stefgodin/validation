<?php


namespace Stefmachine\Validation\Tests\Mock;


use Stefmachine\Validation\ConstraintInterface;

class ConstraintMock implements ConstraintInterface
{
    protected $checkedValue;
    protected $errorMessage;
    
    public function __construct($_checkedValue, $_errorMessage = false)
    {
        $this->checkedValue = $_checkedValue;
        $this->errorMessage = $_errorMessage;
    }
    
    public function validate($_value)
    {
        return $_value === $this->checkedValue ?: $this->errorMessage;
    }
}