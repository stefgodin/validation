<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;

class Choice implements ConstraintInterface
{
    const ERROR_CHOICE = 'invalid_choice';
    
    /** @var array */
    protected $choices;
    /** @var bool */
    protected $loose;
    
    public function __construct(array $_choices = array(), bool $_loose = false)
    {
        $this->choices = array();
        $this->loose = $_loose;
        
        foreach ($_choices as $choice){
            $this->add($choice);
        }
    }
    
    public function add($_choice)
    {
        $this->choices[] = $_choice;
        return $this;
    }
    
    public function validate($_value): Errors
    {
        if(in_array($_value, $this->choices, !$this->loose)){
            return Errors::none();
        }
        
        return Errors::from(self::ERROR_CHOICE);
    }
}