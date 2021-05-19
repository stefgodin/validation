<?php


namespace Stefmachine\Validation;


use UnexpectedValueException;

interface ConstraintInterface
{
    /**
     * @param $_value
     * @return bool|string
     * @throws UnexpectedValueException
     */
    public function validate($_value);
}