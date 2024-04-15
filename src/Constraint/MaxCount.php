<?php


namespace Stefmachine\Validation\Constraint;

use Countable;
use InvalidArgumentException;
use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Report\ValidationReport;

class MaxCount implements ConstraintInterface
{
    use ErrorMessageTrait;
    
    const TOO_MANY_ERROR = 'eebaa720-f30b-43b5-86e2-1b3b686fc465';
    const INVALID_ARRAY_ERROR = '3b7768bd-f44f-4a3d-ae87-16a7c7835adf';
    
    protected function getErrorName(string $uuid): string
    {
        return match ($uuid) {
            self::TOO_MANY_ERROR => 'TOO_MANY_ERROR',
            self::INVALID_ARRAY_ERROR => 'INVALID_ARRAY_ERROR',
        };
    }
    
    protected function getErrorMessage(string $uuid): string
    {
        return match ($uuid) {
            self::TOO_MANY_ERROR => 'The array must not contain over {max} elements.',
            self::INVALID_ARRAY_ERROR => 'The value is not an array or countable.',
        };
    }
    
    public function __construct(
        protected int $maxCount,
    )
    {
        if($this->maxCount < 0) {
            throw new InvalidArgumentException("Max count cannot be less than 0.");
        }
    }
    
    public function validate(mixed $value): ValidationReport
    {
        $report = new ValidationReport();
        if(!is_array($value) && !$value instanceof Countable) {
            return $report->addError($this->newError(self::INVALID_ARRAY_ERROR));
        }
        
        $count = count($value);
        if($count > $this->maxCount) {
            $report->addError($this->newError(self::TOO_MANY_ERROR, ['{max}' => $this->maxCount]));
        }
        return $report;
    }
}