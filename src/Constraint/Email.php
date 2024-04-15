<?php


namespace Stefmachine\Validation\Constraint;

use Stefmachine\Validation\ConstraintInterface;

class Email extends Regex implements ConstraintInterface
{
    public function __construct()
    {
        parent::__construct('/^.+\@\S+\.\S+$/');
        $this->setErrorMessage(self::PATTERN_MISMATCH_ERROR, 'The value is not a valid email.');
    }
}