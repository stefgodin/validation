<?php


namespace Stefmachine\Validation\Constraint;

use InvalidArgumentException;
use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Report\ValidationReport;

class AnyOf implements ConstraintInterface
{
    /**
     * @param ConstraintInterface[] $constraints
     */
    public function __construct(
        protected array $constraints,
    )
    {
        foreach($this->constraints as $constraint) {
            if(!$constraint instanceof ConstraintInterface) {
                throw new InvalidArgumentException("Expected array of " . ConstraintInterface::class . ".");
            }
        }
    }
    
    public function validate(mixed $value): ValidationReport
    {
        $allReports = new ValidationReport();
        foreach($this->constraints as $constraint) {
            $report = $constraint->validate($value);
            
            if($report->isValid()) {
                return $report;
            } else {
                $allReports->merge($report);
            }
        }
        
        return $allReports;
    }
}