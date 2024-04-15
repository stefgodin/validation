<?php


namespace Stefmachine\Validation\Constraint;

use Countable;
use InvalidArgumentException;
use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Report\ValidationReport;

class MinCount implements ConstraintInterface
{
    use ErrorMessageTrait;
    
    const TOO_FEW_ERROR = '3468d46c-93d6-46f0-9d02-7635cf7a4754';
    const INVALID_ARRAY_ERROR = 'a6c261aa-abf6-4cf2-a837-5a79cfa1b448';
    
    protected function getErrorName(string $uuid): string
    {
        return match ($uuid) {
            self::TOO_FEW_ERROR => 'TOO_FEW_ERROR',
            self::INVALID_ARRAY_ERROR => 'INVALID_ARRAY_ERROR',
        };
    }
    
    protected function getErrorMessage(string $uuid): string
    {
        return match ($uuid) {
            self::TOO_FEW_ERROR => 'The array must not contain under {min} elements.',
            self::INVALID_ARRAY_ERROR => 'The value is not an array or countable.',
        };
    }
    
    public function __construct(
        protected int $minCount,
    )
    {
        if($this->minCount < 0) {
            throw new InvalidArgumentException("Min count cannot be less than 0.");
        }
    }
    
    public function validate(mixed $value): ValidationReport
    {
        $report = new ValidationReport();
        if(!is_array($value) && !$value instanceof Countable) {
            return $report->addError($this->newError(self::INVALID_ARRAY_ERROR));
        }
        
        $count = count($value);
        if($count < $this->minCount) {
            $report->addError($this->newError(self::TOO_FEW_ERROR, ['{min}' => $this->minCount]));
        }
        return $report;
    }
}