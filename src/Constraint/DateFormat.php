<?php


namespace Stefmachine\Validation\Constraint;

use DateTime;
use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Report\ValidationReport;
use Stringable;

class DateFormat implements ConstraintInterface
{
    use ErrorMessageTrait;
    
    const NOT_STRINGABLE_ERROR = '2040082a-d327-44de-ae6f-8de75d599f51';
    const INVALID_DATE_FORMAT_ERROR = '41732bcd-cdbc-4463-a5eb-05e51706ff8a';
    
    protected function getErrorName(string $uuid): string
    {
        return match ($uuid) {
            self::NOT_STRINGABLE_ERROR => 'NOT_STRINGABLE_ERROR',
            self::INVALID_DATE_FORMAT_ERROR => 'INVALID_DATE_FORMAT_ERROR',
        };
    }
    
    protected function getErrorMessage(string $uuid): string
    {
        return match ($uuid) {
            self::NOT_STRINGABLE_ERROR => 'The value cannot be converted to a string.',
            self::INVALID_DATE_FORMAT_ERROR => 'The value does not match the specified date format {format}.',
        };
    }
    
    public function __construct(
        protected string $format,
    ) {}
    
    public function validate(mixed $value): ValidationReport
    {
        $report = new ValidationReport();
        if(!is_scalar($value) && !$value instanceof Stringable) {
            return $report->addError($this->newError(self::NOT_STRINGABLE_ERROR));
        }
        $value = (string)$value;
        
        $date = DateTime::createFromFormat($this->format, $value);
        if(!$date instanceof DateTime || $date->format($this->format) !== $value) {
            $report->addError($this->newError(self::INVALID_DATE_FORMAT_ERROR, ['{format}' => $this->format]));
        }
        
        return $report;
    }
}