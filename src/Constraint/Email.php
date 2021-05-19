<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;

class Email extends Regex implements ConstraintInterface
{
    private const PATTERN = '/^.+\@\S+\.\S+$/';
    
    public function __construct(?string $_errorMessage = null)
    {
        parent::__construct(self::PATTERN, $_errorMessage);
    }
}