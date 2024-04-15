<?php


namespace Stefmachine\Validation\Constraint;

use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Report\ValidationReport;
use Traversable;

class Each implements ConstraintInterface
{
    use ErrorMessageTrait;
    
    const INVALID_ARRAY_ERROR = 'e2223267-fe96-484d-8b34-2a8ba1348437';
    
    protected function getErrorName(string $uuid): string
    {
        return match ($uuid) {
            self::INVALID_ARRAY_ERROR => 'INVALID_ARRAY_ERROR',
        };
    }
    
    protected function getErrorMessage(string $uuid): string
    {
        return match ($uuid) {
            self::INVALID_ARRAY_ERROR => 'The value is not an array or traversable.',
        };
    }
    
    public function __construct(
        protected ConstraintInterface $constraint,
    ) {}
    
    public function validate(mixed $value): ValidationReport
    {
        $report = new ValidationReport();
        if(!is_array($value) && !$value instanceof Traversable) {
            return $report->addError($this->newError(self::INVALID_ARRAY_ERROR));
        }
        
        foreach($value as $i => $v) {
            $report->merge($this->constraint->validate($v), $i);
        }
        
        return $report;
    }
}