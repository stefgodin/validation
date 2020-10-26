<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;

class Each implements ConstraintInterface
{
    const NOT_ARRAY = 'not_array';
    
    /** @var ConstraintInterface[] $constraints */
    protected $constraints;
    
    public function __construct(array $_constraints = array())
    {
        $this->constraints = array();
        
        foreach ($_constraints as $constraint){
            $this->add($constraint);
        }
    }
    
    public function add(ConstraintInterface $_constraint)
    {
        $this->constraints[] = $_constraint;
    }
    
    public function validate($_value): Errors
    {
        if(!is_array($_value) && !$_value instanceof \Traversable){
            return Errors::from(self::NOT_ARRAY);
        }
        
        $errors = Errors::none();
        foreach ($_value as $index => $value){
            foreach ($this->constraints as $constraint){
                $errors->merge(
                    $constraint->validate($value),
                    "{$index}:"
                );
                
                break;
            }
        }
        
        return $errors;
    }
}