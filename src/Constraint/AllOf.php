<?php


namespace Stefmachine\Validation\Constraint;


use InvalidArgumentException;
use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;

class AllOf implements ConstraintInterface
{
    /** @var ConstraintInterface[] */
    protected $constraints;
    
    use ErrorMessageTrait;
    
    public function __construct(array $_constraints, ?string $_errorMessage = null)
    {
        $this->constraints = array();
        $this->setErrorMessage($_errorMessage);
        
        foreach ($_constraints as $constraint){
            if(!$constraint instanceof ConstraintInterface){
                throw new InvalidArgumentException("Expected array of ".ConstraintInterface::class.".");
            }
            
            $this->add($constraint);
        }
    }
    
    private function add(ConstraintInterface $_constraint): AllOf
    {
        $this->constraints[] = $_constraint;
        return $this;
    }
    
    public function validate($_value)
    {
        foreach ($this->constraints as $constraint){
            $valid = $constraint->validate($_value);
            if($valid !== true){
                return $this->getError() ?: $valid;
            }
        }
        
        return true;
    }
}