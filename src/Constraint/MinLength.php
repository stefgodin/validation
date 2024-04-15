<?php


namespace Stefmachine\Validation\Constraint;

use InvalidArgumentException;
use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Report\ValidationReport;
use Stringable;

class MinLength implements ConstraintInterface
{
    use ErrorMessageTrait;
    
    const NOT_STRINGABLE_ERROR = 'dfedce91-3675-4b8d-9346-8a25fcd820a2';
    const TOO_SHORT_ERROR = '724593bb-a68f-4208-96d2-e7b1332eb82b';
    
    protected function getErrorName(string $uuid): string
    {
        return match ($uuid) {
            self::NOT_STRINGABLE_ERROR => 'NOT_STRINGABLE_ERROR',
            self::TOO_SHORT_ERROR => 'TOO_SHORT_ERROR',
        };
    }
    
    protected function getErrorMessage(string $uuid): string
    {
        return match ($uuid) {
            self::NOT_STRINGABLE_ERROR => 'The value cannot be converted to a string.',
            self::TOO_SHORT_ERROR => 'The value must be at least {min} characters ({byte_mode}).',
        };
    }
    
    public function __construct(
        protected int  $minLength,
        protected bool $multiByte = true,
    )
    {
        if($this->minLength < 0) {
            throw new InvalidArgumentException("Min length cannot be less than 0.");
        }
    }
    
    public function singleByte(): MinLength
    {
        $this->multiByte = false;
        return $this;
    }
    
    public function multiByte(): MinLength
    {
        $this->multiByte = true;
        return $this;
    }
    
    public function validate(mixed $value): ValidationReport
    {
        $report = new ValidationReport();
        if(!is_scalar($value) && !$value instanceof Stringable) {
            return $report->addError($this->newError(self::NOT_STRINGABLE_ERROR));
        }
        
        $value = (string)$value;
        if(($this->multiByte ? mb_strlen($value) : strlen($value)) < $this->minLength) {
            $report->addError($this->newError(self::TOO_SHORT_ERROR, [
                '{min}' => $this->minLength,
                '{byte_mode}' => $this->multiByte ? 'Multi-Byte' : 'Single-Byte',
            ]));
        }
        
        return $report;
    }
}