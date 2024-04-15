<?php


namespace Stefmachine\Validation\Tests\Mock;

use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Report\ValidationError;
use Stefmachine\Validation\Report\ValidationReport;

class ConstraintMock implements ConstraintInterface
{
    const ERROR = '41a18a3d-6fd9-440b-aa75-a2f13f3bb05e';
    const ERROR_MESSAGE = 'This is an error message {name}.';
    const ERROR_NAME = 'ERROR_NAME';
    
    public function __construct(
        protected bool $succeeds,
    ) {}
    
    public function validate(mixed $value): ValidationReport
    {
        $report = new ValidationReport();
        if(!$this->succeeds) {
            $report->addError(new ValidationError(self::ERROR, self::ERROR_NAME, self::ERROR_MESSAGE, [
                '{name}' => self::ERROR_NAME,
            ]));
        }
        return $report;
    }
}