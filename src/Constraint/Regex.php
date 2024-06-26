<?php


namespace Stefmachine\Validation\Constraint;

use InvalidArgumentException;
use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Report\ValidationReport;
use Stringable;

class Regex implements ConstraintInterface
{
    use ErrorMessageTrait;
    
    const NOT_STRINGABLE_ERROR = '38f092dc-02fa-4f40-a8f3-85e3fa9c9590';
    const PATTERN_MISMATCH_ERROR = '56cc97ef-4f50-410a-a23c-d4ef1f7bfd5e';
    
    protected function getErrorName(string $uuid): string
    {
        return match ($uuid) {
            self::NOT_STRINGABLE_ERROR => 'NOT_STRINGABLE_ERROR',
            self::PATTERN_MISMATCH_ERROR => 'PATTERN_MISMATCH_ERROR',
        };
    }
    
    protected function getErrorMessage(string $uuid): string
    {
        return match ($uuid) {
            self::NOT_STRINGABLE_ERROR => 'The value cannot be converted to a string.',
            self::PATTERN_MISMATCH_ERROR => 'The value does not match the pattern {pattern}.',
        };
    }
    
    public function __construct(protected string $pattern)
    {
        if(@preg_match($this->pattern, '') === false) {
            throw new InvalidArgumentException("Invalid regex given.");
        }
    }
    
    public function validate(mixed $value): ValidationReport
    {
        $report = new ValidationReport();
        if(!is_scalar($value) && !$value instanceof Stringable) {
            return $report->addError($this->newError(self::NOT_STRINGABLE_ERROR));
        }
        
        if(!preg_match($this->pattern, (string)$value)) {
            $report->addError($this->newError(self::PATTERN_MISMATCH_ERROR, [
                '{pattern}' => $this->pattern,
            ]));
        }
        return $report;
    }
}