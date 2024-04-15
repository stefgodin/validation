<?php


namespace Stefmachine\Validation\Constraint;

use InvalidArgumentException;
use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Report\ValidationReport;
use Stringable;

class MaxLength implements ConstraintInterface
{
    use ErrorMessageTrait;
    
    const NOT_STRINGABLE_ERROR = 'ef0926c0-6323-45c7-b714-0d1c56b6698e';
    const TOO_LONG_ERROR = '4903f590-8b77-4794-bb18-e0311688836e';
    
    protected function getErrorName(string $uuid): string
    {
        return match ($uuid) {
            self::NOT_STRINGABLE_ERROR => 'NOT_STRINGABLE_ERROR',
            self::TOO_LONG_ERROR => 'TOO_LONG_ERROR',
        };
    }
    
    protected function getErrorMessage(string $uuid): string
    {
        return match ($uuid) {
            self::NOT_STRINGABLE_ERROR => 'The value cannot be converted to a string.',
            self::TOO_LONG_ERROR => 'The value must be at most {max} characters ({byte_mode}).',
        };
    }
    
    public function __construct(
        protected int  $maxLength,
        protected bool $multiByte = true,
    )
    {
        if($this->maxLength < 0) {
            throw new InvalidArgumentException("Max length cannot be less than 0.");
        }
    }
    
    public function singleByte(): MaxLength
    {
        $this->multiByte = false;
        return $this;
    }
    
    public function multiByte(): MaxLength
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
        if(($this->multiByte ? mb_strlen($value) : strlen($value)) > $this->maxLength) {
            $report->addError($this->newError(self::TOO_LONG_ERROR, [
                '{max}' => $this->maxLength,
                '{byte_mode}' => $this->multiByte ? 'Multi-Byte' : 'Single-Byte',
            ]));
        }
        
        return $report;
    }
}