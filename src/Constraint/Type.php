<?php


namespace Stefmachine\Validation\Constraint;

use InvalidArgumentException;
use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Report\ValidationReport;
use Stringable;
use Traversable;

class Type implements ConstraintInterface
{
    use ErrorMessageTrait;
    
    const INVALID_TYPE_ERROR = '90a2b646-c742-4f83-9dbb-6ac4decce68f';
    
    protected function getErrorName(string $uuid): string
    {
        return match ($uuid) {
            self::INVALID_TYPE_ERROR => 'INVALID_TYPE_ERROR',
        };
    }
    
    protected function getErrorMessage(string $uuid): string
    {
        return match ($uuid) {
            self::INVALID_TYPE_ERROR => 'The value is not a valid {type}.',
        };
    }
    
    const BOOLEAN = 'bool';
    const STRING = 'string';
    const STRINGABLE = 'stringable';
    const DOUBLE = 'double';
    const INTEGER = 'integer';
    const FLOAT = 'float';
    const NUMERIC = 'numeric';
    const ARRAY = 'array';
    const TRAVERSABLE = 'traversable';
    const SCALAR = 'scalar';
    
    private const TYPES = [
        self::BOOLEAN,
        self::STRING,
        self::STRINGABLE,
        self::DOUBLE,
        self::INTEGER,
        self::FLOAT,
        self::NUMERIC,
        self::ARRAY,
        self::TRAVERSABLE,
        self::SCALAR,
    ];
    
    public function __construct(
        protected string $type,
    )
    {
        if(!in_array($this->type, self::TYPES)) {
            throw new InvalidArgumentException(
                sprintf("Specified type must be one of %s.", implode(', ', self::TYPES))
            );
        }
    }
    
    public function validate(mixed $value): ValidationReport
    {
        $report = new ValidationReport();
        $fn = "is_{$this->type}";
        $valid = match ($this->type) {
            self::STRINGABLE => $value === null || is_scalar($value) || $value instanceof Stringable,
            self::TRAVERSABLE => is_array($value) || $value instanceof Traversable,
            default => gettype($value) === $this->type || (function_exists($fn) && $fn($value))
        };
        
        if(!$valid) {
            $report->addError($this->newError(self::INVALID_TYPE_ERROR, ['{type}' => $this->type]));
        }
        
        return $report;
    }
}