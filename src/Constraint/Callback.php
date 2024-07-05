<?php


namespace Stefmachine\Validation\Constraint;

use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Report\ValidationError;
use Stefmachine\Validation\Report\ValidationReport;

class Callback implements ConstraintInterface
{
    use ErrorMessageTrait;
    
    const INVALID_VALUE_ERROR = '84033c73-d9cb-4d5f-a083-a13445594f53';
    
    protected function getErrorName(string $uuid): string
    {
        return match ($uuid) {
            self::INVALID_VALUE_ERROR => 'INVALID_VALUE_ERROR',
        };
    }
    
    protected function getErrorMessage(string $uuid): string
    {
        return match ($uuid) {
            self::INVALID_VALUE_ERROR => 'The value is not valid.',
        };
    }
    
    /** @var callable */
    protected mixed $callback;
    
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }
    
    public function validate(mixed $value): ValidationReport
    {
        $report = new ValidationReport();
        $result = ($this->callback)($value);
        if($result !== true) {
            if($result instanceof ValidationReport) {
                $report->merge($result);
            } else if($result instanceof ValidationError) {
                $report->addError($result);
            } else {
                $report->addError($this->newError(self::INVALID_VALUE_ERROR));
            }
        }
        return $report;
    }
}