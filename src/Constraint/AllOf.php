<?php


namespace Stefmachine\Validation\Constraint;

use InvalidArgumentException;
use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Report\ValidationReport;

class AllOf implements ConstraintInterface
{
    /**
     * @param ConstraintInterface[] $constraints
     */
    public function __construct(protected array $constraints)
    {
        foreach($this->constraints as $constraint) {
            if(!$constraint instanceof ConstraintInterface) {
                throw new InvalidArgumentException("Expected array of " . ConstraintInterface::class . ".");
            }
        }
    }
    
    public function validate(mixed $value): ValidationReport
    {
        foreach($this->constraints as $constraint) {
            $report = $constraint->validate($value);
            if($report->hasError()) {
                return $report;
            }
        }
        
        return new ValidationReport();
    }
}