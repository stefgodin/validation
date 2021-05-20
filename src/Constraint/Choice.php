<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;

class Choice implements ConstraintInterface
{
    /** @var array */
    protected $choices;
    /** @var bool */
    protected $loose;
    
    use ErrorMessageTrait;
    
    public function __construct(array $_choices, ?string $_errorMessage = null)
    {
        $this->choices = $_choices;
        $this->loose = false;
        
        $this->setErrorMessage($_errorMessage);
    }
    
    public function loose(): Choice
    {
        $this->loose = true;
        return $this;
    }
    
    public function strict(): Choice
    {
        $this->loose = false;
        return $this;
    }
    
    public function validate($_value)
    {
        return in_array($_value, $this->choices, !$this->loose) ?: $this->getError();
    }
}