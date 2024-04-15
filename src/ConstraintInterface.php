<?php


namespace Stefmachine\Validation;

use Stefmachine\Validation\Report\ValidationReport;

interface ConstraintInterface
{
    public function validate(mixed $value): ValidationReport;
}