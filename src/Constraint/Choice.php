<?php


namespace Stefmachine\Validation\Constraint;

use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Report\ValidationReport;

class Choice implements ConstraintInterface
{
    use ErrorMessageTrait;
    
    const INVALID_CHOICE_ERROR = '28ef3894-53f4-4b79-9c39-61bd3e88a0e1';
    
    protected function getErrorName(string $uuid): string
    {
        return match ($uuid) {
            self::INVALID_CHOICE_ERROR => 'INVALID_CHOICE_ERROR',
        };
    }
    
    protected function getErrorMessage(string $uuid): string
    {
        return match ($uuid) {
            self::INVALID_CHOICE_ERROR => 'The selected value is not a valid choice.',
        };
    }
    
    public function __construct(
        protected array $choices,
        protected bool  $loose = false,
    ) {}
    
    public function loose(): Choice
    {
        $this->loose = true;
        return $this;
    }
    
    public function strict(): Choice
    {
        $this->loose = false;
        return $this;
    }
    
    public function validate(mixed $value): ValidationReport
    {
        $report = new ValidationReport();
        if(!in_array($value, $this->choices, !$this->loose)) {
            $report->addError($this->newError(self::INVALID_CHOICE_ERROR));
        }
        
        return $report;
    }
}