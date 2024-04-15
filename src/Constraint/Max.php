<?php


namespace Stefmachine\Validation\Constraint;

use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Report\ValidationReport;

class Max implements ConstraintInterface
{
    use ErrorMessageTrait;
    
    const NOT_A_NUMBER_ERROR = '0f4485ec-4270-4cbf-abec-c640a3ab7b02';
    const TOO_HIGH_ERROR = '445afaad-89c1-4675-beb0-b5307c48240c';
    
    protected function getErrorName(string $uuid): string
    {
        return match ($uuid) {
            self::NOT_A_NUMBER_ERROR => 'NOT_A_NUMBER_ERROR',
            self::TOO_HIGH_ERROR => 'TOO_HIGH_ERROR',
        };
    }
    
    protected function getErrorMessage(string $uuid): string
    {
        return match ($uuid) {
            self::NOT_A_NUMBER_ERROR => 'The value should be a number.',
            self::TOO_HIGH_ERROR => 'The value should be bellow {max} ({mode}).',
        };
    }
    
    public function __construct(
        protected int|float $max,
        protected bool      $inclusive = true,
    ) {}
    
    public function excludeMax(): Max
    {
        $this->inclusive = false;
        return $this;
    }
    
    public function includeMax(): Max
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
        if($this->inclusive ? ($value > $this->max) : ($value >= $this->max)) {
            $report->addError($this->newError(self::TOO_HIGH_ERROR, [
                '{max}' => $this->max,
                '{mode}' => $this->inclusive ? 'inclusive' : 'exclusive',
            ]));
        }
        
        return $report;
    }
}