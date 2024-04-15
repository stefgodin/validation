<?php


namespace Stefmachine\Validation\Constraint;

use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Report\ValidationReport;

class Min implements ConstraintInterface
{
    use ErrorMessageTrait;
    
    const NOT_A_NUMBER_ERROR = 'f0eba344-f71a-4822-b244-7eb63efff1fb';
    const TOO_LOW_ERROR = '379af6d0-5705-4ab6-addb-4ffb3fc7cc65';
    
    protected function getErrorName(string $uuid): string
    {
        return match ($uuid) {
            self::NOT_A_NUMBER_ERROR => 'NOT_A_NUMBER_ERROR',
            self::TOO_LOW_ERROR => 'TOO_LOW_ERROR',
        };
    }
    
    protected function getErrorMessage(string $uuid): string
    {
        return match ($uuid) {
            self::NOT_A_NUMBER_ERROR => 'The value should be a number.',
            self::TOO_LOW_ERROR => 'The value should be above {min} ({mode}).',
        };
    }
    
    public function __construct(
        protected int|float $min,
        protected bool      $inclusive = true,
    ) {}
    
    public function excludeMin(): Min
    {
        $this->inclusive = false;
        return $this;
    }
    
    public function includeMin(): Min
    {
        $this->inclusive = true;
        return $this;
    }
    
    public function validate(mixed $value): ValidationReport
    {
        $report = new ValidationReport();
        if(!is_numeric($value)) {
            return $report->addError($this->newError(self::NOT_A_NUMBER_ERROR));
        }
        
        $value = (float)$value;
        if($this->inclusive ? ($value < $this->min) : ($value <= $this->min)) {
            $report->addError($this->newError(self::TOO_LOW_ERROR, [
                '{min}' => $this->min,
                '{mode}' => $this->inclusive ? 'inclusive' : 'exclusive',
            ]));
        }
        
        return $report;
    }
}