<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Errors;

class Map implements ConstraintInterface
{
    const ERROR_ARRAY = 'not_array';
    const ERROR_EXTRA = 'extra_field';
    
    /** @var ConstraintInterface[] */
    protected $constraints;
    /** @var bool */
    protected $allowExtra;
    
    public function __construct(array $_map = array(), bool $_allowExtra = false)
    {
        $this->allowExtra = $_allowExtra;
        $this->constraints = array();
        
        foreach ($_map as $key => $validation){
            $this->set($key, $validation);
        }
    }
    
    public function allowExtra(): Map
    {
        $this->allowExtra = true;
        return $this;
    }
    
    public function set(string $_key, ConstraintInterface $_constraint): Map
    {
        $this->constraints[$_key] = $_constraint;
        return $this;
    }
    
    public function validate($_value): Errors
    {
        if(!is_array($_value) && !$_value instanceof \Traversable){
            return Errors::from(self::ERROR_ARRAY);
        }
        
        $errors = Errors::none();
        $missingKeys = array_keys($this->constraints);
        foreach ($_value as $key => $value){
            $index = array_search($key, $missingKeys);
            if($index !== false){
                unset($missingKeys[$index]);
    
                $errors->merge(
                    $this->constraints[$key]->validate($value),
                    "{$key}."
                );
            }
            elseif (!$this->allowExtra){
                return $errors->add(self::ERROR_EXTRA);
            }
        }
        
        foreach ($missingKeys as $key){
            $errors->merge( // Giving null to trigger validations
                $this->constraints[$key]->validate(null),
                "{$key}."
            );
        }
        
        return $errors;
    }
}