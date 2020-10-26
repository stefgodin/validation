<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;

class XOf implements ConstraintInterface
{
    /** @var ConstraintInterface[] $constraints */
    protected $constraints;
    /** @var int $expected */
    protected $expected;
    
    public function __construct(int $_expects, array $_constraints = array())
    {
        $this->expected = $_expects;
        $this->constraints = array();
        
        foreach ($_constraints as $constraint){
            $this->add($constraint);
        }
    }
    
    public function add(ConstraintInterface $_constraint, int $_addExpects = 0)
    {
        $this->constraints[] = $_constraint;
        $this->expected += $_addExpects;
    }
    
    public function validate($_value): Errors
    {
        $countValid = 0;
        $firstInvalid = null;
        foreach ($this->constraints as $constraint){
            $errors = $constraint->validate($_value);
            if($errors->any()){
                $firstInvalid = $firstInvalid ?? $errors;
            }
            else{
                $countValid++;
            }
        }
        
        if($countValid >= $this->expected){
            return Errors::none();
        }
        
        return $firstInvalid ?? Errors::none();
    }
}