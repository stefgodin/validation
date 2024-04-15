<?php


namespace Stefmachine\Validation\Constraint;

use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Report\ValidationReport;

class Optional implements ConstraintInterface
{
    public function __construct(
        protected ConstraintInterface $constraint,
    ) {}
    
    public function validate(mixed $value): ValidationReport
    {
        if($value === null) {
            return new ValidationReport();
        }
        
        return $this->constraint->validate($value);
    }
}