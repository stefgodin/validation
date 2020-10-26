<?php


namespace Stefmachine\Validation;


interface ConstraintInterface
{
    public function validate($_value): Errors;
}