<?php


namespace Stefmachine\Validation\Constraint;

use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Report\ValidationReport;

class NotNull implements ConstraintInterface
{
    use ErrorMessageTrait;
    
    const IS_NULL_ERROR = 'ab27b044-89ec-4c42-928c-9289ee4654a9';
    
    protected function getErrorName(string $uuid): string
    {
        return match ($uuid) {
            self::IS_NULL_ERROR => 'IS_NULL_ERROR',
        };
    }
    
    protected function getErrorMessage(string $uuid): string
    {
        return match ($uuid) {
            self::IS_NULL_ERROR => 'The value must not be null.',
        };
    }
    
    public function validate(mixed $value): ValidationReport
    {
        $report = new ValidationReport();
        if($value === null) {
            $report->addError($this->newError(self::IS_NULL_ERROR));
        }
        return $report;
    }
}